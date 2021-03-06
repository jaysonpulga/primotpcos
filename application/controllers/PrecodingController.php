<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class PrecodingController extends CI_Controller
{

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
		
		//$this->convertPDFToHTML();

		
		//load dataentry model and get loaddDataentry html form 
		$loaddDataEntry = $this->DataEntrySettings_model->loaddDataEntry();
		
		//call loadhtmlfile into ckeditot
		$htmlfile = $this->loadhtmlfilein_ckeditor();

		//query the RefID details
		$strSQL = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND RefId ='".$RefId."' ";
		$query = $this->WMSIdeagenDB->query($strSQL);
	    $result = $query->row();
		
		
		
			
		$data = array(
					'dataresult' => $result,
					'RefId' => $RefId,
					'dataEntryFormTemplate' => $loaddDataEntry,
					'htmlfile_source' => $htmlfile);
		
		
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
	
	
	
	
	public function convertPDFToHTML(){
		
			
		$JobId = "22268";
		$filename="SOR2020-178NewReg";
		
		$pdf_file =  $_SERVER{'DOCUMENT_ROOT'}."\\primotpcos\\uploadfiles\\".$JobId."\\".pathinfo($filename, PATHINFO_FILENAME).".pdf";
		$html_dir =  $_SERVER{'DOCUMENT_ROOT'}."\\primotpcos\\uploadfiles\\".$JobId."\\".pathinfo($filename, PATHINFO_FILENAME).".html";
		 $cmd = "pdftotext $pdf_file $html_dir";
		
		$cmd = "mutool convert -o $html_dir $pdf_file";
		
		exec($cmd, $out, $ret);
		
		exit;
		
		
	}

	
	public function loadhtmlfilein_ckeditor()
	{
		
			$pp = $_SERVER{'DOCUMENT_ROOT'}."/primotpcos/uploadfiles/22268/Reg_of_n_R134_A103_Appendix.html";
			
			if(file_exists($pp )){
			     $sFile= file_get_contents($pp);
			 
			   	$encoding = mb_detect_encoding($sFile, mb_detect_order(), false);
				
			    if($encoding == "UTF-8"){
					$sFile = mb_convert_encoding($sFile, "UTF-8", "Windows-1252");    
				}
				
				return $htmlfile_text = iconv(mb_detect_encoding($sFile, mb_detect_order(), false), "UTF-8//IGNORE", $sFile);
			
				
			}

	}

	
	public function saveFormData()
	{
		
		$answerlist = $this->input->post('answerlist'); 
		$RefId = $this->input->post('RefId'); 
		$UserID = $this->session->userdata('UserID');
		$RefIdStatus = $this->input->post('RefIdStatus');

		if(!empty($answerlist))
		{
			$strSQLDelete = "DELETE FROM tbldataentry_forms WHERE RefId ='".$RefId."' ";
			$query = $this->WMSIdeagenDB->query($strSQLDelete);
		}
		
		

		// insert  tbldataentry_forms 
		foreach($answerlist as $data_ans){
			
			
			 
			if(!empty($data_ans['answer'])){
									
					$strSQL = "INSERT INTO tbldataentry_forms (Refid,FieldName,FieldType,Answer,UserId) VALUES ('".$RefId."','".$data_ans['fieldname']."','".$data_ans['fieldtype']."','".$data_ans['answer']."','".$UserID."')";
					$query = $this->WMSIdeagenDB->query($strSQL);
			}
			
			
		}
		
		
		
		//update table if status is New
		if($RefIdStatus  == "NEW")
		{
			$strSQL = "UPDATE PRIMO_Integration SET Status ='for Approval'  where RefId = '".$RefId."' ";
			$query = $this->WMSIdeagenDB->query($strSQL);
		}
		
		echo "done";

	
	}
	
	
	
	
	

	

}