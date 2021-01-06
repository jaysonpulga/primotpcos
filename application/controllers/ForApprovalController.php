<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ForApprovalController extends CI_Controller
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
		
			$this->load->view('acquire/forapproval');
	}
	
	public function GetDataforApproval(){
		
			$strSQL = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND Status= 'for Approval' ";
			$query = $this->WMSIdeagenDB->query($strSQL);
			$post = $query->result();
			
			$data = array();
			
			if(!empty($post))
			{
							
				foreach($post as $dd) 
				{
					
										$EntryForm = "SELECT * From  tbldataentry_forms WHERE  RefId= '".$dd->RefId."' ";
					$query = $this->WMSIdeagenDB->query($EntryForm);
					$dataform = $query->result();
					
					$metaData = "";
					$SGML_filename = "";
					
					
					$metaDataFieldName = "";
					$metaDataAnswer = "";
					$metaDataTable = "";
					if(!empty($dataform))
					{
						foreach($dataform as $metaifo)
						{
							
							
							if($metaifo->FieldCaption)
							{
								$metaDataFieldName .= "<td><center><b>".$metaifo->FieldCaption."</b></center></td>";
							}
						
							
							if($metaifo->Answer)
							{								
								$metaDataAnswer  .= "<td>".$metaifo->Answer."</td>";
							}
						
						}
						
						$metaDataTable .= "<table class='table table-bordered table-striped' border=1>";
						$metaDataTable .= "<tr>";
						$metaDataTable .= $metaDataFieldName;
						$metaDataTable .= "</tr>";
						$metaDataTable .= "<tr>";
						$metaDataTable .= $metaDataAnswer;
						$metaDataTable .= "</tr>";
						$metaDataTable .= "</table>";
					}
					
					$title = $this->functions_library->UTF8_encoding(@$dd->Title);
					
					if( strlen( $title ) > 25 ) {
					   $title = substr( $title, 0, 25 ) . '...';
					}
					
					$row = array();
					$row['RefId'] = @$dd->RefId;
					$row['meta_data'] = $metaDataTable;
					$row['ConfigName'] = @$dd->ConfigName;
					$row['Jurisdiction'] = @$dd->Jurisdiction;
					$row['SGML_filename'] = @$dd->SGML_filename;
					$row['Status'] 		= @$dd->Status;
					$row['Title'] =  '<a href="fullscreen/'.@$dd->RefId.'" target="_blank">'.$title.'</a>';
					$row['RegulationNumber'] = @$dd->RegulationNumber;
					$row['Filename'] = @$dd->Filename;
					$row['DateRegistered'] = @$dd->DateRegistered;
					
					
					
					$data[] = $row;
				}
				
				
				
			}
			else
			{
				$data = [];
			}
			
			
			$output = array( "data" => $data);
			
			echo json_encode($output);
			
		
	}
	
	
	public function UpdateStatus()
	{
		
		$status_selcted = $this->input->post('status_selcted'); 
		$RefId = $this->input->post('RefId'); 
		
		//update status
		$strSQL = "UPDATE PRIMO_Integration SET Status ='".$status_selcted."'  where RefId = '".$RefId."' ";
		$query = $this->WMSIdeagenDB->query($strSQL);
		echo "updated";
	}

	public function  ExportToExcel()
	{
			
		$strSQL = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND Status ='for Approval'  ";
		$query = $this->WMSIdeagenDB->query($strSQL);
		$data = $query->result();

		
		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
       	$sheet->setCellValue('A1', 'RefId');
        $sheet->setCellValue('B1', 'MetaData Info.'); 
		$sheet->setCellValue('C1', 'SGML Filename.'); 		
		$sheet->setCellValue('D1', 'Configname');	
		$sheet->setCellValue('E1', 'Jurisdiction');
		$sheet->setCellValue('F1', 'Title');
		$sheet->setCellValue('G1', 'Filename');
		$sheet->setCellValue('H1', 'Date Registered');
		$sheet->setCellValue('I1', 'Status');


		
		
        $rows = 2;
		
        foreach ($data as $val){
			
			
					$EntryForm = "SELECT * From  tbldataentry_forms WHERE  RefId= '".$val->RefId."' ";
					$query = $this->WMSIdeagenDB->query($EntryForm);
					$dataform = $query->result();
					$metadataInfo = "";
					if(!empty($dataform))
					{
						foreach($dataform as $metaifo)
						{
							$metadataInfo .= $metaifo->FieldName." : ".$metaifo->Answer .";";
						
						}
					}
			
			
            $sheet->setCellValue('A' . $rows, $val->RefId);
            $sheet->setCellValue('B' . $rows, $metadataInfo);
			$sheet->setCellValue('C' . $rows, $val->SGML_filename);
			$sheet->setCellValue('D' . $rows, $val->ConfigName);
			$sheet->setCellValue('E' . $rows, $val->Jurisdiction);
			$sheet->setCellValue('F' . $rows, $val->Title);
			$sheet->setCellValue('G' . $rows, $val->Filename);
			$sheet->setCellValue('H' . $rows, $val->DateRegistered);
			$sheet->setCellValue('I' . $rows, $val->Status);
			
			$validation = $rows;
			
			$validation= $spreadsheet->getActiveSheet()->getCell('I'.$rows)->getDataValidation();
			$validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
			$validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
			$validation->setAllowBlank(false);
			$validation->setShowInputMessage(true);
			$validation->setShowErrorMessage(true);
			$validation->setShowDropDown(true);
			$validation->setErrorTitle('Input error');
			$validation->setError('Value is not in list.');
			$validation->setPromptTitle('Pick from list');
			$validation->setPrompt('Please pick a value from the drop-down list.');
			$validation->setFormula1('"Approved,Discarded,Others"');
			

			
            $rows++;
        } 
		
		
		
		
		
		
		$currDateTime = date("Y-m-d H:i:s");
		
		$fileName = 'ForApproval'.'_'.$currDateTime.'.xlsx'; 
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$fileName.'"');
		header('Cache-Control: max-age=0');
		header("Content-Type: application/vnd.ms-excel");
		
        $writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		
		die();
		
	}
	
	
	public function importExcel(){
		
		$data=array();

		$file_mimes = array('application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		

		$resultString = "";
		
		if(isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes) ) {
			
				$arr_file = explode('.', $_FILES['upload_file']['name']);
				
				$extension = end($arr_file);
				
				if('csv' == $extension){
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				
				$spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();
				
				$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
				$highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
				
				
				
				// get RefID for checking if existing and compare if value exist
				$GetRefIDHeader = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, 1)->getValue();
				
				
				if(empty($GetRefIDHeader))
				{
					$res = "RefId not in field";
					echo json_encode(array('resultStatus'=>'failed','res'=>$res));
					exit;
				}
				else if(!empty($GetRefIDHeader) && $GetRefIDHeader !="RefId"){
					
					$res = "RefId not in field";
					echo json_encode(array('resultStatus'=>'failed','res'=>$res));
					exit;
					
					
				}else{
			
				
				
						for($row=2; $row<=$highestRow; $row++)
						{
							
							
							
							//Get and set value from excel
							$RefId = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
							$MetaDataInfo = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
							$SGML_Filename = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
							$Configname = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
							$Jurisdiction = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
							$Title = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
							$Filename = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
							$DateRegistered = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue();
							$Status = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(9, $row)->getValue();
							
							//Query result if existing the RefID and status is for approval		
							$EntryForm = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND  RefId=".$RefId." AND Status= 'for Approval' ";
							$query = $this->WMSIdeagenDB->query($EntryForm);
							$dataform = $query->result();
							$count = count($dataform);
							
							if($count > 0)
							{
									
									$valid_staus = array('Approved','Discarded','Others');	
										
									if(!empty($Status) && in_array($Status,$valid_staus) )
									{
										
										//update status
										$strSQL = "UPDATE PRIMO_Integration SET Status ='".$Status."'  where RefId = '".$RefId."' ";
										$query = $this->WMSIdeagenDB->query($strSQL);
										
										//success updating
										$resultString .= $RefId. "- <span style='color:green'> Successful Upadate </span> <br>";
										
										 							
									}else{
										
										//error updating
										$resultString .= $RefId. "- <span style='color:red'>Failed to Update (Invalid Status)</span><br>";
									}
								
								
							}
							else{
								
								//error updating
								$resultString .= $RefId. "- <span style='color:red'>No existing RefId in the table</span><br>"; 
								
							}

					}// end of for loop
					
				}//end of else	


		}
		else{
			$res = "<span style='color:red'>Invalid File</span><br>";
			echo json_encode(array('resultStatus'=>'failed','res'=>$res));
			exit;
		}
		

		echo json_encode(array('resultStatus'=>'success','res'=>$resultString));
						
	
	
   }

}