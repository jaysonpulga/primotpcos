<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');


class SplitviewController extends CI_Controller
{
	
	private $ProjectName = "primotpcos";
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url'); 
		$this->load->database();
		$this->load->library('session');
		$this->load->model('DataEntrySettings_model');
		
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
	
		if(count($resultquery)==0){
			echo "File nof found";
			exit;
		}
		
		

		$Filename = @$result->Filename;
		$filepath = $this->loadhtmlfilein_ckeditor($RefId,$Filename);
		
		$data = array(
					'dataresult' => $result,
					'RefId' => $RefId,
					'dataEntryFormTemplate' => $loaddDataEntry,
					'filepath' => $filepath,
					);

		$this->load->view('enrich/splitview',$data);
	
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
	
	


}