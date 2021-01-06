<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');


class CodeMirrorController extends CI_Controller
{
	private $ProjectName = "primotpcos";
	
	
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url'); 
		$this->load->database();
		$this->load->library('session');
		$this->load->model('DataEntrySettings_model');
		
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
				
		$this->SearchnetIdeagenDB = $this->load->database('SearchnetIdeagenDB', TRUE);
		$this->WMSIdeagenDB = $this->load->database('WMSIdeagenDB', TRUE);
			
			/** check if !isset session  redirect to login **/
			if(!$this->session->userdata('UserID')){ 
				redirect('login');
			}
		
	}
	
	
	public function index(){
		
		$RefId = $_GET['RefId'];
		$BatchID = $_GET['BatchID'];
		$ProcessCode = $_GET['Task'];
		
	

		//load dataentry model and get loaddDataentry html form 
		$loaddDataEntry = $this->DataEntrySettings_model->loaddDataEntry();
		
		//query the RefID details
		$strSQL="SELECT * FROM primo_view_Jobs Where ProcessCode='$ProcessCode' AND statusstring in('Allocated','Pending','Ongoing','Done','Hold')  AND AssignedTo='$_SESSION[login_user]' AND BatchId = '$BatchID' AND RefId = '$RefId' ";	
		$query = $this->WMSIdeagenDB->query($strSQL);
	
	    $result = $query->row();
		$resultquery = $query->result();
		
		/*
		echo "<pre>";
		print_r($result);
		echo "</pre>";
		exit;
		*/
		
		if(count($resultquery)==0){
			echo "File nof found";
			exit;
		}
		
		
		$Filename = @$result->Filename;
		$filepath = $this->loadhtmlfilein_ckeditor($RefId,$Filename);
		
		$file = "uploadfiles/".$RefId."/".$Filename;
		
		$arraymenu = array('parent_menu'=>'parent_masterdata','child_menu'=>'chartofaccount','sub_child_menu'=>'main_account_menu');	
		
		$data = array(
					'dataresult' => $result,
					'RefId' => $result->RefId,
					'dataEntryFormTemplate' => $loaddDataEntry,
					'filepath' => $filepath,
					'file' => $file,
					
					'Parent_Menu_'=>'Parent_Menu_EnrichMenu',
					'Child_Menu_'=>'Child_Menu_'.preg_replace('/\s+/', '',@$result->WorkFlowName),
					'Sub_Child_Menu_'=>'Sub_Child_Menu_'. @$result->ProcessCode,
					'Second_Sub_Child_Menu_'=>'Second_Sub_Child_Menu_'. @$result->RefId,
					
					);
					

        $this->load->view('enrich/codemirror',$data);
	}
	
	public function submitxml(){
		$RefId = $this->input->post('RefId');
		$SGML_filename = $this->input->post('SGML_filename');
		$output ="";

		// read if we have xml copy
		$getxml = $_SERVER{'DOCUMENT_ROOT'}."/".$this->ProjectName."/uploadfiles/".$RefId."/".$SGML_filename.'.xml';
		
		// if file html copy exist get the file 
		if(file_exists($getxml)){
			$getfilecontentxml = file_get_contents($getxml);
			//encode
			$encoding = mb_detect_encoding($getfilecontentxml, mb_detect_order(), false);
			if($encoding == "UTF-8"){
				$getfilecontentxml = mb_convert_encoding($getfilecontentxml, "UTF-8", "Windows-1252");    
			}
			$output  =  iconv(mb_detect_encoding($getfilecontentxml, mb_detect_order(), false), "UTF-8//IGNORE", $getfilecontentxml);
		}
		echo $output;
	}
	
	
	public function StartJob(){
		 $BatchID = $this->input->post('batch_id');
		 $sqls="EXEC usp_PRIMO_STARTBATCH @BatchId=".$BatchID;
		 $this->WMSIdeagenDB->query($sqls);
	}
	
	public function SetasCompleted(){
		 $BatchID = $this->input->post('batch_id');
		 $SGML_filename = $this->input->post('SGML_filename');
		 $RefId = $this->input->post('RefId');
		 
		 // read if we have xml copy
		$getxml = $_SERVER{'DOCUMENT_ROOT'}."/".$this->ProjectName."/uploadfiles/".$RefId."/".$SGML_filename.'.xml';
		
		if(file_exists($getxml)){
			
			
			$res = $this->ValidateXml($RefId,$SGML_filename);
			if(!empty($res)){
				
				echo $res;
				exit;
			}
			
			$sqls="EXEC USP_PRIMO_DONEBATCH @BatchId=".$BatchID;
			$this->WMSIdeagenDB->query($sqls);
			echo "exist_xml";
			
					
		}
		else{
			
			echo "no_xml_exist";
		}
		
	}
	
	public function PendingJob(){
		$BatchID = $this->input->post('batch_id');
		$sqls="EXEC USP_PRIMO_PENDINGBATCH @BatchId=".$BatchID;
		$this->WMSIdeagenDB->query($sqls);
	}
	
	public function HoldJob(){
		
		$BatchID=$_POST['BatchIDHold'];
		$JobID=$_POST['JobIDHold'];
		$Remarks=$_POST['Remarks'];
		$Remarks= str_replace("'","''", $Remarks);
		$sqls="EXEC USP_PRIMO_HOLDBATCH @BatchId=".$BatchID;
		$this->WMSIdeagenDB->query($sqls);		
		$this->WMSIdeagenDB->query("Update PRIMO_Integration SET HoldRemarks='$Remarks' Where JobID='$JobID'");	
		
		echo "hold";

	}
	
	
	
	
	

	
	

	public function loadhtmlfilein_ckeditor($RefId,$Filename)
	{	
	
		
		$output ="";
	
		// read file
		$file = $_SERVER{'DOCUMENT_ROOT'}."/".$this->ProjectName."/uploadfiles/".$RefId."/".$Filename;
		
		//get file name
		$filenameinfo = pathinfo($Filename, PATHINFO_FILENAME);
		$File_Extension = pathinfo($Filename,PATHINFO_EXTENSION);
		
		if(file_exists($file)){
			
				$File_Extension = pathinfo($Filename,PATHINFO_EXTENSION);
				
			
				if($File_Extension == 'pdf' || $File_Extension == 'PDF' )
				{
						
						// read if we have html copy
						 $gethtml = $_SERVER{'DOCUMENT_ROOT'}."/".$this->ProjectName."/uploadfiles/".$RefId."/".$filenameinfo.'.html';
				
						// if file html copy exist get the file 
						if(file_exists($gethtml)){
						
							$output = "uploadfiles/".$RefId."/".$filenameinfo.'.html';

						}
						else{
							// convert file 
							// call function convert pdf to html and get file
							$this->functions_library->convertPDFToHTML($RefId, $filenameinfo);
							$output = "uploadfiles/".$RefId."/".$filenameinfo.'.html';
							
						}

						
				}
				else if($File_Extension == 'html' || $File_Extension == 'HTML' || $File_Extension == 'htm' )
				{
						// if file is html get content html
						$output = "uploadfiles/".$RefId."/".$filenameinfo.'.'.$File_Extension;
						
				

				}
				else if($File_Extension == 'doc' || $File_Extension == 'docx' )
				{
					
						// read if we have html copy
						$gethtml = $_SERVER{'DOCUMENT_ROOT'}."/".$this->ProjectName."/uploadfiles/".$RefId."/".$filenameinfo.'.html';
						// if file html copy exist get the file 
						if(file_exists($gethtml)){
							$output = "uploadfiles/".$RefId."/".$filenameinfo.'.html';
						}
						else{
							// convert file 
							// call function convert pdf to html and get file
							 $this->functions_library->convertDocToHTML($RefId,$Filename);
							 $output = "uploadfiles/".$RefId."/".$filenameinfo.'.html';
						
						}
				}
			
		}
		
		return $output; 
	
		
	}
	
	
	
	
	
	public function saveXmlFormData(){
		
		$RefId = $this->input->post('RefId');
		$xmltextarea = $this->input->post('xmltextarea');
		$SGML_filename = $this->input->post('SGML_filename');
	
		$directory = 'uploadfiles/'.$RefId;
		$tempDir = $directory."/".$SGML_filename.".xml";
		$tempFile = fopen($tempDir, "w") or die("Unable to open file!");
		fclose($tempFile);
		chmod($tempDir, 0777); 
		file_put_contents($tempDir, $xmltextarea);
		
		$res = $this->ValidateXml($RefId,$SGML_filename);
		
		if(!empty($res)){
			
			echo $res;
		}
		else{
			
			echo 'done';
		}
		

		
	}
	
	public function ValidateXml($RefId,$SGML_filename){
		
		$sLog = '';

		// read if we have xml copy
		$getxml = $_SERVER{'DOCUMENT_ROOT'}."/".$this->ProjectName."/uploadfiles/".$RefId."/".$SGML_filename.'.xml';
		
		$schemaxsd = $_SERVER{'DOCUMENT_ROOT'}."/".$this->ProjectName."/assets/schema/carswell-editing.dtd";
		
		if(!file_exists($schemaxsd)){
		
			echo "xsd_file_not_exist";
			die();
		}

		
		libxml_use_internal_errors(true);

		$xml = new DOMDocument('1.0', 'utf-8');
		$xml->load($getxml);
		//dito mo isetup schema
		if(!$xml->schemaValidate($schemaxsd)) {
			// print '<b>DOMDocument::schemaValidate() Generated Errors!</b>';
			$sError = $this->libxml_display_errors();
			$sLog= $sLog.$sError;
		}
		

		return $sLog;
		
	}
	
	
	function libxml_display_error($error)
	{
		$return = "\n\n";
		switch ($error->level) {
			case LIBXML_ERR_WARNING:
				$return .= "<b>Warning $error->code</b>: ";
				break;
			case LIBXML_ERR_ERROR:
				$return .= "<b>Error $error->code</b>: ";
				break;
			case LIBXML_ERR_FATAL:
				$return .= "<b>Fatal Error $error->code</b>: ";
				break;
		}
		$return .= trim($error->message);
		if ($error->file) {
			// $return .=    " in <b>$error->file</b>";
		}
		$return .= " LINE NO $error->line---";

		return $return;
	}

	function libxml_display_errors() {
		$errors = libxml_get_errors();
		$sError ="";
		$sLog="";
		$nVal=1;
		foreach ($errors as $error) {
			// print libxml_display_error($error);
			$sError =  $this->libxml_display_error($error);
			
			//print_r($sError );

			$Log= explode(" LINE NO",$sError);

			if ( $Log[0]!=''){
				$Description = $Log[0];
				// $Log= explode(" LINE NO",$sError);
				$A1= explode("---",$Log[1]);

				$lineNo = trim($A1[0]);
				$ColNo=50;
				
				$lenVal=50;
				$Color='red';

				

				$sLog = $sLog."<li><a href='#p$nVal' id='myclass$lineNo' style='color:red' class='myclass' onclick='jumpToLine($lineNo,$ColNo,$lenVal);'><i class='fa fa-circle text-$Color'></i>$Description</a></li>";
				$nVal++;
			}
			

		}
		return $sLog;
		libxml_clear_errors();
	}
	
	
	public function saveXmlFormDatawithHtml(){
		
		
		$RefId = $this->input->post('RefId'); 
		$UserID = $this->session->userdata('UserID');
		
		// html
		$Filename = $this->input->post('Filename');
		$htmlsource = $this->input->post('htmlsource');
	
		$directory = 'uploadfiles/'.$RefId;
		$tempDir = $directory."/".$Filename.".html";
		$tempFile = fopen($tempDir, "w") or die("Unable to open file!");
		fclose($tempFile);
		chmod($tempDir, 0777); 
		file_put_contents($tempDir, $htmlsource);
			
		// xml
		$xmltextarea = $this->input->post('xmltextarea');
		$SGML_filename = $this->input->post('SGML_filename');
	
		$directoryxml = 'uploadfiles/'.$RefId;
		$tempDirxml = $directoryxml."/".$SGML_filename.".xml";
		$tempFilexml = fopen($tempDirxml, "w") or die("Unable to open file!");
		fclose($tempFilexml);
		chmod($tempDirxml, 0777); 
		file_put_contents($tempDirxml, $xmltextarea);
		
		
		$res = $this->ValidateXml($RefId,$SGML_filename);
		
		if(!empty($res)){
			
			echo $res;
		}
		else{
			
			echo "<span style='color:green'>XML VALIDATION SUCESSFUL</span>";
		}
		
		
		
	}
	
	


}