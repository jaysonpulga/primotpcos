<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class RegisteredController extends CI_Controller
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
		
			$this->load->view('acquire/registered');
	}
	
	

	
	public function GetDataRegsitered(){
		
	
			$strSQL = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND Status= 'Registered' ";
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
					$row['SGML_filename'] = @$dd->SGML_filename; 
					$row['ConfigName'] = @$dd->ConfigName;
					$row['Jurisdiction'] = @$dd->Jurisdiction;
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
	
	


}