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
		
			$strSQL = "SELECT TOP(10) * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND Status= '".$search_val."' ";
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
		$this->load->helper('pdf_helper');
		//$this->convertPDFToHTML();

		//load dataentry model and get loaddDataentry html form 
		$loaddDataEntry = $this->DataEntrySettings_model->loaddDataEntry();
		
		//query the RefID details
		$strSQL = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND RefId ='".$RefId."' ";
		$query = $this->WMSIdeagenDB->query($strSQL);
	    $result = $query->row();
		// echo"<pre>";
		// print_r($result);
		// echo"</pre>";
		// die();
		//call loadhtmlfile into ckeditor
		
		$Filename = pathinfo($result->Filename, PATHINFO_FILENAME);
		$RefId = $result->RefId;
		$directory = 'uploadfiles/'.$result->RefId;
		if (!file_exists($directory)) {
		    mkdir($directory, 0777, true);
		    $this->create_pdf($RefId, $Filename);
		    $this->convertPDFToHTML($RefId, $Filename);
		}  
		$htmlfile = $this->loadhtmlfilein_ckeditor($RefId, $Filename);


		$data = array(
			'dataresult' => $result,
			'RefId' => $RefId,
			'dataEntryFormTemplate' => $loaddDataEntry,
			'htmlfile_source' => $htmlfile
		);
		$this->load->view('acquire/precoding_fullscreen',$data);
		
	}

	public function loadhtmlfilein_ckeditor($RefId, $Filename)
	{
	
		$htmlFile = 'uploadfiles/'.$RefId."/".$Filename.".html";
		$pdfFile = 'uploadfiles/'.$RefId."/".$Filename.".pdf";
		
		if(file_exists($htmlFile)){
		    $sFile= file_get_contents($htmlFile);
		   	$encoding = mb_detect_encoding($sFile, mb_detect_order(), false);
		    if($encoding == "UTF-8"){
				$sFile = mb_convert_encoding($sFile, "UTF-8", "Windows-1252");    
			}
			return $htmlfile_text = iconv(mb_detect_encoding($sFile, mb_detect_order(), false), "UTF-8//IGNORE", $sFile);
		}
		else if(file_exists($pdfFile)){
			$this->convertPDFToHTML($RefId, $Filename);
			return $this->loadhtmlfilein_ckeditor($RefId, $Filename);
		}
		
	}
	
	public function create_pdf($RefId, $Filename){
		$directory = 'uploadfiles/'.$RefId;
		$pdfFile = $directory."/".$Filename.".pdf";
		if (file_exists($pdfFile)) unlink($pdfFile);

		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = $Filename;
		$obj_pdf->SetTitle($title);
		$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		    // we can have any view part here like HTML, PHP etc
		    $content = ob_get_contents();
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output($pdfFile, 'F');

		// exit;
	}

	public function convertPDFToHTML($RefId, $filename){
		// $RefId = "22268";
		// $filename="SOR2020-178NewReg";
		
		$pdf_file =  $_SERVER{'DOCUMENT_ROOT'}."\\primotpcos\\uploadfiles\\".$RefId."\\".pathinfo($filename, PATHINFO_FILENAME).".pdf";
		$html_dir =  $_SERVER{'DOCUMENT_ROOT'}."\\primotpcos\\uploadfiles\\".$RefId."\\".pathinfo($filename, PATHINFO_FILENAME).".html";
		 $cmd = "pdftotext $pdf_file $html_dir";
		
		$cmd = "mutool convert -o $html_dir $pdf_file";
		
		exec($cmd, $out, $ret);
		
		// exit;
	}
	
	public function GetAnswerDataForm(){
		
		$RefId = $this->input->post('RefId'); 
		
		//Get  tbldataentry_forms
		$strSQLDataEntryAnswer = "SELECT * From  tbldataentry_forms WHERE  RefId= '".$RefId."' ";
		$query = $this->WMSIdeagenDB->query($strSQLDataEntryAnswer);
		$dataAnswer = $query->result();
		
		echo json_encode($dataAnswer);
		
	}

	
	public function saveFormData()
	{
		// echo"<pre>";
		// print_r($_POST);
		// echo"</pre>";
		// die();
		$answerlist = $this->input->post('answerlist'); 
		$RefId = $this->input->post('RefId'); 
		$UserID = $this->session->userdata('UserID');
		$RefIdStatus = $this->input->post('RefIdStatus');
		$Filename = $this->input->post('Filename');

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
			}
		}
		//update table if status is New
		if($RefIdStatus  == "NEW" ||$RefIdStatus  == "New"  )
		{
			$strSQL = "UPDATE PRIMO_Integration SET Status ='for Approval'  where RefId = '".$RefId."' ";
			$query = $this->WMSIdeagenDB->query($strSQL);
		}

		$directory = 'uploadfiles/'.$RefId;
		if (!file_exists($directory)) {
		    mkdir($directory, 0777, true);
		}
		$htmlsource = $this->input->post('htmlsource');
		$tempDir = $directory."/".$Filename.".html";
		$tempFile = fopen($tempDir, "w") or die("Unable to open file!");
		fclose($tempFile);
		chmod($tempDir, 0777); 
		file_put_contents($tempDir, $htmlsource);


		echo "done";

	
	}
	
	
	
	
	

	

}