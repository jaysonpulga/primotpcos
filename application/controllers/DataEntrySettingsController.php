<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');


class DataEntrySettingsController extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url'); 
		$this->load->database();
		$this->load->library('session');
		$this->load->model('DataEntrySettings_model');
			
			/** check if !isset session  redirect to login **/
			if(!$this->session->userdata('UserID')){ 
				redirect('login');
			}
		
	}
	
	
	public function index(){
	
        $this->load->view('configuration/dataentry_settings');
	}
	
	
	public function entryData()
	{
		
		$this->db->select('*');
		$this->db->from('tbldataentry');
		$query = $this->db->get();
		$resultarray = $query->result();

		
		
			$data = array();
			if(!empty($resultarray))
			{
				
	
			
				foreach($resultarray as $dd) 
				{
					$row = array();
					$row['ColumnID'] = @$dd->ColumnID;
					$row['FieldName'] = @$dd->FieldName;
					$row['FieldCaption'] = @$dd->FieldCaption;
					$row['FieldType'] = @$dd->FieldType;
					$row['FieldOption'] = @$dd->FieldOption;
					$row['Action']  = '<button type="button" class="btn btn-xs btn-info edit" data-id="'.$dd->ColumnID.'" >Update</button>&nbsp;&nbsp;';
					$row['Action'] .= '<button class="btn btn-xs btn-danger delete" data-id="'.$dd->ColumnID.'">Delete</button>';
					$data[] = $row;
				}
				
				
				
			}
			else
			{
				$data = [];
			}
			
			
		   $output = array("data"=> $data);
		   echo json_encode($output);
			
	}
	
	
	public function addnewEntry(){
		
		
	
		$data = array(
		
			'FieldName'    => $this->input->post('FieldName'),
            'FieldType'    => $this->input->post('FieldType'),
            'FieldOption'  => $this->input->post('FieldOption'),
			'FieldCaption' => $this->input->post('FieldCaption'),
		);

		$this->db->insert('tbldataentry', $data);

		echo 'save';
	
	}
	
	public function updateEntry(){
		  
		  
		  $id = $this->input->post('ColumnID');
		  
		  $data = array(
		  
				'FieldName'    => $this->input->post('FieldName'),
				'FieldType'    => $this->input->post('FieldType'),
				'FieldOption'  => $this->input->post('FieldOption'),
				'FieldCaption' => $this->input->post('FieldCaption'),
			);
		  
		  $this->db->where('ColumnID', $id);
		  $this->db->update('tbldataentry', $data);
		  
		  echo 'save';
	}
	
	public function geEntrybyID(){
			
		$id = $this->input->post('id');
		$query = $this->db->get_where('tbldataentry', array('ColumnID ' => $id));
        $data = $query->row();
		echo json_encode($data);
	}
	
	public function deleteEntry(){
		
		$id = $this->input->post('id');
		$this->db->delete('tbldataentry', array('ColumnID' => $id));
	
	}
	
	
	

	
}
