<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class PrecodingController extends CI_Controller
{
	
	private $ProjectName = "primotpcos";
	
	function __construct(){
		
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->library('session');
		$this->load->model('DataEntrySettings_model');
		$this->load->model('ListStyleSettings_model');	
		
		$this->SearchnetIdeagenDB = $this->load->database('SearchnetIdeagenDB', TRUE);
		$this->WMSIdeagenDB = $this->load->database('WMSIdeagenDB', TRUE);
		
			/** check if !isset session  redirect to login **/
			if(!$this->session->userdata('UserID')){ 
				redirect('login');
			}
		
		
	}
	
	public function index(){		
        $this->load->view('acquire/precoding');
	}
	
	
	
	
	public function GetData()
	{
		
			$search_val  = $this->input->post('search_val');
		
			$strSQL = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND Status= '".$search_val."' ";
			$query = $this->WMSIdeagenDB->query($strSQL);
			$post = $query->result();

			
			$data = array();
			if(!empty($post)){
				
	
			
				foreach($post as $dd) 
				{
	
					$row = array();
					$row['RefId'] = @$dd->RefId;
					$row['ConfigName'] = @$dd->ConfigName;
					$row['Jurisdiction'] = @$dd->Jurisdiction;
					$row['Status'] 		= @$dd->Status;
					$row['Title'] =  '<a href="fullscreen/'.@$dd->RefId.'" target="_blank">'.$this->functions_library->UTF8_encoding(@$dd->Title).'</a>';
					$row['RegulationNumber'] = @$dd->RegulationNumber;
					$row['Filename'] = @$dd->Filename;
					$row['DateRegistered'] = @$dd->DateRegistered;
					
					
					
					$data[] = $row;
				}
				
				
				
			}
			else{
				$data = [];
			}
			
			$output = array("data" => $data);
			
			
			echo json_encode($output);
			
			
			
	}
	
	public function serversideGetData(){		
					
			$limit  	 = $this->input->post('length');
			$start   	 = $this->input->post('start');
			$draw 		 = $this->input->post('draw');
			$search_val  = $this->input->post('search_val');
									
						
			$strSQL = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND Status= '".$search_val."' ";
			$query = $this->WMSIdeagenDB->query($strSQL);
			$post = $query->result();
			$totalData = count($post);
			$totalFiltered = $totalData;
			
			$strSQL = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND Status= '".$search_val."' ORDER BY RefId ASC OFFSET ".$start."  ROWS FETCH NEXT ".$limit." ROWS ONLY ";
			$query = $this->WMSIdeagenDB->query($strSQL);
			$post = $query->result();
			$totalData = count($post);
						
		
	
				
	
			$data = array();
			if(!empty($post))
			{
				
	
			
				foreach($post as $dd) 
				{
					$row = array();
					$row['RefId'] = @$dd->RefId;
					$row['ConfigName'] = @$dd->ConfigName;
					$row['Jurisdiction'] = @$dd->Jurisdiction;
					$row['Status'] 		= @$dd->Status;
					$row['Title'] =  '<a href="fullscreen/'.@$dd->RefId.'" target="_blank">'.$this->functions_library->UTF8_encoding(@$dd->Title).'</a>'; 
					$row['Filename'] = @$dd->Filename;
					$row['DateRegistered'] = @$dd->DateRegistered;
					
					
					
					$data[] = $row;
				}
				
				
				
			}
			else
			{
				$data = [];
			}
			
			
			$output = array(
						"draw"            => intval($draw),  
						"recordsTotal"    => intval($totalData),  
						"recordsFiltered" => intval($totalFiltered), 
						"data"            => $data,
						);
			
			
			echo json_encode($output);
	}
	
	
	public function fullscreen($RefId)
	{
		
		//load dataentry model and get loaddDataentry html form 
		$loaddDataEntry = $this->DataEntrySettings_model->loaddDataEntry();
		
		//query the RefID details
		$strSQL = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND RefId ='".$RefId."' ";
		$query = $this->WMSIdeagenDB->query($strSQL);
		
		
	    $result = $query->row();
		$resultquery = $query->result();
	
		if(count($resultquery)==0){
			echo "RefId nof found";
			exit;
		}

		$Filename = @$result->Filename;

		/*** tempory function  create folder and file for testing purpose ***/
		//$testfilefordocs= pathinfo($result->Filename, PATHINFO_FILENAME);
		//$Filename = $testfilefordocs.'.doc'; /*sample convert doc to html;*/
		// for testing create job folder and file
		$this->functions_library->CreateFolderAndFileforTestingPurpose($result->RefId,$Filename);
	
		
		
		
		$file = $this->loadhtmlfilein_ckeditor($RefId,$Filename);
		
		
		$data = array(
					'dataresult' => $result,
					'RefId' => $RefId,
					'dataEntryFormTemplate' => $loaddDataEntry,
					'ckeditorloadfile' => $file,
					);

		$this->load->view('acquire/precoding_fullscreen',$data);
		
	}
	
	
	public function GetAnswerDataForm(){
		
		$RefId = $this->input->post('RefId'); 
		
		//Get  tbldataentry_forms
		$strSQLDataEntryAnswer = "SELECT * From  tbldataentry_forms WHERE  RefId= '".$RefId."' ";
		$query = $this->WMSIdeagenDB->query($strSQLDataEntryAnswer);
		$dataAnswer = $query->result();
		
		echo json_encode($dataAnswer);
		
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
	


	
	public function loadhtmlfilein_ckeditor2()
	{	
	
		 $RefId = $this->input->post('RefId');
		 $Filename = $this->input->post('Filename');
		
		
		$output ="";
	
	
		// read file
		$file = $_SERVER{'DOCUMENT_ROOT'}."/".$this->ProjectName."/uploadfiles/".$RefId."/".$Filename;
		
		//get file name
		$filenameinfo = pathinfo($Filename, PATHINFO_FILENAME);
		
		if(file_exists($file)){
			
				$File_Extension = pathinfo($Filename,PATHINFO_EXTENSION);
				
			
				if($File_Extension == 'pdf' || $File_Extension == 'PDF' )
				{
						
						// read if we have html copy
						 $gethtml = $_SERVER{'DOCUMENT_ROOT'}."/".$this->ProjectName."/uploadfiles/".$RefId."/".$filenameinfo.'.html';
				
						// if file html copy exist get the file 
						if(file_exists($gethtml)){
							$getfilecontenthtml = file_get_contents($gethtml);
							//encode
							$encoding = mb_detect_encoding($getfilecontenthtml, mb_detect_order(), false);
							if($encoding == "UTF-8"){
								$getfilecontenthtml = mb_convert_encoding($getfilecontenthtml, "UTF-8", "Windows-1252");    
							}
							$output  =  iconv(mb_detect_encoding($getfilecontenthtml, mb_detect_order(), false), "UTF-8//IGNORE", $getfilecontenthtml);
							

						}
						else{
							// convert file 
							// call function convert pdf to html and get file
							$convertedfile = $this->functions_library->convertPDFToHTML($RefId, $filenameinfo);
							//encode 
							$encoding = mb_detect_encoding($convertedfile, mb_detect_order(), false);
							if($encoding == "UTF-8"){
								$convertedfile = mb_convert_encoding($convertedfile, "UTF-8", "Windows-1252");    
							}
							$output  = iconv(mb_detect_encoding($convertedfile, mb_detect_order(), false), "UTF-8//IGNORE", $convertedfile);
						}

						
				}
				else if($File_Extension == 'html' || $File_Extension == 'HTML' || $File_Extension == 'htm' )
				{
						// if file is html get content html
						$getfilecontent= file_get_contents($file);
						$encoding = mb_detect_encoding($getfilecontent, mb_detect_order(), false);
						if($encoding == "UTF-8"){
							$getfilecontent = mb_convert_encoding($getfilecontent, "UTF-8", "Windows-1252");    
						}
						$output  = iconv(mb_detect_encoding($getfilecontent, mb_detect_order(), false), "UTF-8//IGNORE", $getfilecontent);
						
				

				}
				else if($File_Extension == 'doc' || $File_Extension == 'docx' )
				{
					
						// read if we have html copy
						$gethtml = $_SERVER{'DOCUMENT_ROOT'}."/".$this->ProjectName."/uploadfiles/".$RefId."/".$filenameinfo.'.html';
						// if file html copy exist get the file 
						if(file_exists($gethtml)){
							$getfilecontenthtml = file_get_contents($gethtml);
							//encode
							$encoding = mb_detect_encoding($getfilecontenthtml, mb_detect_order(), false);
							if($encoding == "UTF-8"){
								$getfilecontenthtml = mb_convert_encoding($getfilecontenthtml, "UTF-8", "Windows-1252");    
							}
							$output  =  iconv(mb_detect_encoding($getfilecontenthtml, mb_detect_order(), false), "UTF-8//IGNORE", $getfilecontenthtml);
						}
						else{
							// convert file 
							// call function convert pdf to html and get file
							$convertedfile = $this->functions_library->convertDocToHTML($RefId,$Filename);
							//encode 
							$encoding = mb_detect_encoding($convertedfile, mb_detect_order(), false);
							if($encoding == "UTF-8"){
								$convertedfile = mb_convert_encoding($convertedfile, "UTF-8", "Windows-1252");    
							}
							$output  =  iconv(mb_detect_encoding($convertedfile, mb_detect_order(), false), "UTF-8//IGNORE", $convertedfile);
						}
				}
			
		}
		
		echo $output; 
	
		
	}

	
	public function saveFormData()
	{
		
		$answerlist = $this->input->post('answerlist'); 
		$RefId = $this->input->post('RefId'); 
		$UserID = $this->session->userdata('UserID');
		$RefIdStatus = $this->input->post('RefIdStatus');
		$Filename = $this->input->post('Filename');
		$htmlsource = $this->input->post('htmlsource');
		


		if(!empty($answerlist))
		{
			$strSQLDelete = "DELETE FROM tbldataentry_forms WHERE RefId ='".$RefId."' ";
			$query = $this->WMSIdeagenDB->query($strSQLDelete);
		}
		
		

		// insert  tbldataentry_forms 
		foreach($answerlist as $data_ans){
			
			
			 
			if(!empty($data_ans['answer'])){
									
					$strSQL = "INSERT INTO tbldataentry_forms (Refid,FieldName,FieldType,Answer,UserId,FieldCaption) VALUES ('".$RefId."','".$data_ans['fieldname']."','".$data_ans['fieldtype']."','".$data_ans['answer']."','".$UserID."','".$data_ans['fieldcaption']."')";
					$query = $this->WMSIdeagenDB->query($strSQL);
					
					
					if($data_ans['fieldname'] == "Sgml"){
						$strSQL = "UPDATE PRIMO_Integration SET SGML_filename = '".$data_ans['answer']."'  where RefId = '".$RefId."' ";
						$query = $this->WMSIdeagenDB->query($strSQL);	
				
					}
			}
			

			
			
		}
		
		
		
		//update table if status is New
		if($RefIdStatus  == "NEW" ||$RefIdStatus  == "New")
		{
			$strSQL = "UPDATE PRIMO_Integration SET Status ='for Approval'  where RefId = '".$RefId."' ";
			$query = $this->WMSIdeagenDB->query($strSQL);
		}
		
		$directory = 'uploadfiles/'.$RefId;
		$tempDir = $directory."/".$Filename.".html";
		$tempFile = fopen($tempDir, "w") or die("Unable to open file!");
		fclose($tempFile);
		chmod($tempDir, 0777); 
		file_put_contents($tempDir, $htmlsource);
		
		
		echo "done";

	
	}
	
	
	
	
	

	

}