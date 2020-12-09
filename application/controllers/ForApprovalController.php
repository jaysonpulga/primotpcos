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
			$metaData = "";
			if(!empty($post))
			{
							
				foreach($post as $dd) 
				{
					
					$EntryForm = "SELECT * From  tbldataentry_forms WHERE  RefId= '".$dd->RefId."' ";
					$query = $this->WMSIdeagenDB->query($EntryForm);
					$dataform = $query->result();
					
					if(!empty($dataform))
					{
						foreach($dataform as $metaifo)
						{
							$metaData .= "<table >
										  <tr>
										    <td>".$metaifo->FieldName."</td>
											<td>:</td>
										    <td>".$metaifo->Answer."</td>
										  </tr>
										</table>";
						
						}
					}
					
					
					$row = array();
					$row['RefId'] = @$dd->RefId;
					$row['meta_data'] = $metaData;
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
		
		$RefId = $this->input->post('RefId_value');
	
		$strSQL = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND RefId = '".$RefId."'  ";
		$query = $this->WMSIdeagenDB->query($strSQL);
		$data = $query->result();
		
		
		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
       	$sheet->setCellValue('A1', 'RefId');
        $sheet->setCellValue('B1', 'MetaData Info.');  
		$sheet->setCellValue('C1', 'Configname');	
		$sheet->setCellValue('D1', 'Jurisdiction');
		$sheet->setCellValue('E1', 'Status');	
		$sheet->setCellValue('F1', 'Title');
		$sheet->setCellValue('G1', 'Filename');
		$sheet->setCellValue('H1', 'Date Registered');	
		
		
        $rows = 2;
		$metadataInfo = "";
        foreach ($data as $val){
			
			
					$EntryForm = "SELECT * From  tbldataentry_forms WHERE  RefId= '".$val->RefId."' ";
					$query = $this->WMSIdeagenDB->query($EntryForm);
					$dataform = $query->result();
					
					if(!empty($dataform))
					{
						foreach($dataform as $metaifo)
						{
							$metadataInfo .= $metaifo->FieldName." : ".$metaifo->Answer .";";
						
						}
					}
			
			
            $sheet->setCellValue('A' . $rows, $val->RefId);
            $sheet->setCellValue('B' . $rows, $metadataInfo);
			$sheet->setCellValue('C' . $rows, $val->ConfigName);
			$sheet->setCellValue('D' . $rows, $val->Jurisdiction);
			$sheet->setCellValue('E' . $rows, $val->Status);
			$sheet->setCellValue('F' . $rows, $val->Title);
			$sheet->setCellValue('G' . $rows, $val->Filename);
			$sheet->setCellValue('H' . $rows, $val->DateRegistered);
			
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
					echo "RefId not in field";
					exit;
				}
				else if(!empty($GetRefIDHeader) && $GetRefIDHeader !="RefId"){
					echo "RefId not in field";
					exit;
				}
			
				
				
				for($row=2; $row<=$highestRow; $row++)
				{
					
					
					
					//Get and set value from excel
					$RefId = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
					$MetaDataInfo = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
					$Configname = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
					$Jurisdiction = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
					$Status = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
					$Title = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
					$Filename = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
					$DateRegistered = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue();
					
					//Query result if existing the RefID and status is for approval		
					$EntryForm = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND  RefId=".$RefId." AND Status= 'for Approval' ";
					$query = $this->WMSIdeagenDB->query($EntryForm);
					$dataform = $query->result();
					$count = count($dataform);
					
					if($count > 0)
					{
							
							$valid_staus = array('Approved','Discarded/Others');	
								
							if(!empty($Status) && in_array($Status,$valid_staus) )
							{
								
								//update status
								$strSQL = "UPDATE PRIMO_Integration SET Status ='".$Status."'  where RefId = '".$RefId."' ";
								$query = $this->WMSIdeagenDB->query($strSQL);
								echo "updated";
								
								/*
								$data[] = array(
								  'RefID'  => $RefId,
								  'MetaDataInfo' => $MetaDataInfo,
								  'Configname' => $Configname,
								  'Jurisdiction' => $Jurisdiction,
								  'Status' => $Status,
								  'Title' => $Title,
								  'Filename' => $Filename,
								  'DateRegistered' => $DateRegistered
								 );
								 */
								 
							
							}else{
								
								echo "Invalid Status  <br><small>*allow value(Approved and Discarded/Others)</small>";
							}
						
						
					}
					else{
						echo "No existing RefId in the table";
					}

			}


		}
		else{
			echo "invalid_file";
		}
			
	
	
   }

}