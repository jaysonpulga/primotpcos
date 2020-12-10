<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class BatchingController extends CI_Controller
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
		
			$this->load->view('acquire/batching');
	}
	
	
	public function SetupColumn(){
		
		
				   $RefId = "22268";
		
					$EntryForm = "SELECT * From  tbldataentry_forms WHERE  RefId= '".$RefId."' ";
					$query = $this->WMSIdeagenDB->query($EntryForm);
					$dataform = $query->result();
					
					//print_r($dataform);
					 $dataArray = array();
					 $dataArray2 = array();
				
					$metaDataFieldName = "";
					$metaDataAnswer = "";
					
					if(!empty($dataform))
					{
						
						
						foreach($dataform as $key => $metaifo)
						{
							
							
							
							if($metaifo->FieldName)
							{
								$dataArray[] = $metaifo->FieldName;
								
								$metaDataFieldName .= "<td>".$metaifo->FieldName."</td>";
							}
							
							if($metaifo->Answer)
							{
								$dataArray2[] = $metaifo->Answer;
								
								$metaDataAnswer  .= "<td>".$metaifo->Answer."</td>";
							}
							
							
							/*
							if($metaifo->FieldName)
							{
								$dataArray[] = $metaifo;
							} 
							 */

							 
							  /*
								foreach($metaifo as $key2 => $val)
								{
										$dataArray[$key2][] = $val;
								}
								*/
						
							
							/*$metaData .="<table border=1 >";
							
										if($metaifo->FieldName)
										{
											
										}
							
												<tr>
													<td>".$metaifo->FieldName."</td>
													<td>:</td>
													<td>".$metaifo->Answer."</td>
												</tr>
						    $metaData .="</table>";
							*/
							
						
						}
					}
					
					
					print_r($dataArray);
					print_r($dataArray2);
					
					echo "<table border='1'>";
					
						echo "<tr>";
						echo $metaDataFieldName;
						echo "</tr>";
						
						echo "<tr>";
						echo $metaDataAnswer;
						echo "</tr>";
						
						
					echo "</table>";
	}
	
	public function GetDataBatching(){
		
		
		

		
		
			$strSQL = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND Status= 'Approved' ";
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
							
							if($metaifo->FieldName == "Sgml")
							{
								$SGML_filename = $metaifo->Answer;
								
							}
							
							if($metaifo->FieldCaption)
							{
								$metaDataFieldName .= "<td><center><b>".$metaifo->FieldCaption."</b></center></td>";
							}
							
							if($metaifo->Answer)
							{								
								$metaDataAnswer  .= "<td>".$metaifo->Answer."</td>";
							}
						
						}
						
						$metaDataTable .= "<table border='1'>";
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
					$row['SGML_filename'] = $SGML_filename;
					$row['ConfigName'] = @$dd->ConfigName;
					$row['Jurisdiction'] = @$dd->Jurisdiction;
					$row['Status'] 		= @$dd->Status;
					$row['Title'] =  '<a href="fullscreen/'.@$dd->RefId.'" target="_blank">'.$title.'</a>'; 
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




}