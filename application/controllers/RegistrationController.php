<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class RegistrationController extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url'); 
		$this->load->library('session');
		
		$this->SearchnetIdeagenDB = $this->load->database('SearchnetIdeagenDB', TRUE);
		$this->WMSIdeagenDB = $this->load->database('WMSIdeagenDB', TRUE);
			
			/** check if !isset session  redirect to login **/
			if(!$this->session->userdata('UserID')){ 
				redirect('login');
			}

	}
	
	
	public function index(){
	
        $this->load->view('acquire/registration');
	}
	
	public function UploadFile(){
		
		$data=array();

		$file_mimes = array('application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		
		$file_allowed_extension = array('application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/pdf','text/html');
		
		
		
		$filenameArray = array();

		$Files=$_FILES['Files']['name'];
		

		foreach($Files as $filename){
			
			$filenameArray[] = $filename;
		}
		

		

		$resultString = array();
		
		if(isset($_FILES['ExcelFile']['name']) && in_array($_FILES['ExcelFile']['type'], $file_mimes) ) {
			
				$arr_file = explode('.', $_FILES['ExcelFile']['name']);
				
				$extension = end($arr_file);
				
				if('csv' == $extension){
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				
				$spreadsheet = $reader->load($_FILES['ExcelFile']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();
				//print_r($sheetData);
				
				$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
				$highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
				
				
				
				// get RefID for checking if existing and compare if value exist
				$GetFileName= $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, 1)->getValue();
				
				
				if(empty($GetFileName)){
					$res = "FileName not in field";
					echo json_encode(array('resultStatus'=>'failed','res'=>$res));
					exit;
				}
				else if(!empty($GetFileName) && $GetFileName !="FileName"){
					
					$res = "FileName not in field";
					echo json_encode(array('resultStatus'=>'failed','res'=>$res));
					exit;
					
					
				}
				else
				{
			
				
				
						for($row=2; $row<=$highestRow; $row++)
						{
							
							//Get and set value from excel
							$SourceUrl = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
							$FileName = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
							$State = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
							$RegulationNumber = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
							$BatchName = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
							
							$ExecutionId = 1;
							$ProjectCode = "PRIMO";
							$Status = "NEW";
							
							// check if Filename Exist in File Array file
							if(in_array($FileName, $filenameArray)){
								
								
								 $elect = "SELECT Filename from PRIMO_Integration where Filename = '".$FileName."' ";
								 $querySelect = $this->WMSIdeagenDB->query($elect);
								 $dataCount = $querySelect->result();
								
								 if(count($dataCount) > 0){
									 // filename is already in DB
									 $resultString['error'][] = $FileName. "- <span> already exist </span> <br>";
									 
									 
								 }else{
								 
									 
										for($i=0; $i<count($filenameArray); $i++) {
											
											$FILE_NAME = $_FILES['Files']['name'][$i];
											
											
											// check the same Filename and Files
											if($FileName == $FILE_NAME){
											
													//checking of File extesion if allow
													if(isset($_FILES['Files']['name'][$i]) && in_array($_FILES['Files']['type'][$i], $file_allowed_extension)) {
			
															
																//inser record on wms primo
													
																$strSQL = "INSERT INTO PRIMO_Integration(ExecutionId,SourceUrl,Filename,Status,State,ProjectCode,RegulationNumber,BatchName) values('".$ExecutionId."','".$SourceUrl."','".$FileName."','".$Status."','".$State."','".$ProjectCode."','".$RegulationNumber."','".$BatchName."')";
																$query = $this->WMSIdeagenDB->query($strSQL);
															 
																$pkCol = "RefId";
																$sqls = "SELECT [".$pkCol."] AS LastID FROM  PRIMO_Integration WHERE [".$pkCol."] = @@Identity;";
																$querys = $this->WMSIdeagenDB->query($sqls);
																$result = $querys->row();
																$RefId = $result->LastID;
																
																
																
																// make directory						
																$path_dir = "uploadfiles/".$RefId;
																
																if(!is_dir($path_dir)){
																	@mkdir($path_dir, 0777, true);
																}
																
																$tmpFilePath = $_FILES['Files']['tmp_name'][$i];
																
																//Setup our new file path
																$newFilePath = $path_dir."/". $_FILES['Files']['name'][$i];
																	
																//Upload the file into the temp dir
																move_uploaded_file($tmpFilePath, $newFilePath);
																
																
																//success updating
																$resultString['success'][] = $FileName. "- <span> Successful added </span> <br>";
																
														
													   }else{
														   
														   
															$resultString['error'][] =  $FileName. "- <span> file not allowed  <small>required file : docx,html,pdf</small> </span> <br>";
														   
													   }// end of checking file extension
											   
											   
										}// checking if filename is equal to file uploaded	  
										
												   
											 
									}// for loop for File
									
										
		
								 }//else  filename  not exist in database procced to upload and insert record
								
								
							}
							else
							{
								$resultString['error'][] = $FileName. "- <span> not found in uploaded file </span> <br>";
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
