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
	
	public function GetDataBatching(){
		
		
		

		
		
			$strSQL = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND Status= 'Approved' ";
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




}