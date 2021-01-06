<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');


class TaskSettingsController extends CI_Controller
{
	
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
	
        $this->load->view('configuration/tasksettings');
	}
	
	public function task_configuration(){
		
		$UID = $this->input->get('UID');
		$Processcode = $this->input->get('ProcessCode'); 
		$query = $this->db->get_where('tbltaskeditorsetting', array('TaskID' => $UID));
		$resultarray = $query->row();		 
		$this->load->view('configuration/taskconfiguration',array('TaskID'=>$UID,'Processcode'=>$Processcode,'setttings'=>$resultarray));
	}
	
	public function getData(){
		

		
		
			$strSQL="select * from wms_Processes inner join wms_WorkFlowProcesses ON  wms_Processes.ProcessId = wms_WorkFlowProcesses.ProcessId Inner join wms_WorkFlows  on wms_WorkFlows.WorkFlowId = wms_WorkFlowProcesses.WorkFlowId ORDER BY wms_WorkFlowProcesses.RefID asc";
			$query = $this->WMSIdeagenDB->query($strSQL);
			$resultarray = $query->result();
			

			$data = array();
			if(!empty($resultarray))
			{
				
	
			
				foreach($resultarray as $dd) 
				{
				
					$row = array();
					
					$row['RefID'] = @$dd->RefID ;
					
					$row['WorkFlowId'] = @$dd->WorkFlowId ;
					$row['WorkFlowName'] = @$dd->WorkFlowName;
					
					$row['ProcessId'] = @$dd->ProcessId;
					$row['ProcessCode'] = @$dd->ProcessCode;
					
					
					$row['Description'] = @$dd->Description;
					
					$row['Process1'] = "";
					$row['Process2'] = "";
					$row['Process3'] = "";
					
					$IsOptional="";
					if(!empty($dd->IsOptional)  &&  $dd->IsOptional != 0){
						$IsOptional="checked";
					}
					
					$IsAutoAllocate="";
					if(!empty($dd->IsAutoAllocate )  &&  $dd->IsAutoAllocate != 0){
						$IsAutoAllocate="checked";
					}
					
					$row['Optional'] = '<input type="Checkbox" id="chk" name="chk[]" '.$IsOptional.' >';
					
					$row['Quota'] = @$dd->Quota;
					
					$row['AutoAllocate'] = '<input type="Checkbox" id="chk" name="chk[]" '.$IsAutoAllocate.'>';
					
					$configure = "TaskConfiguration?UID=".$dd->ProcessId."&TransType=Update&Name=".$dd->Description."&ProcessCode=".$dd->ProcessCode;
					
					$row['Action']  = '<a type="button" href='.$configure.' class="btn btn-xs btn-success btn-flat btn-block" >Configure</a>';
					$row['Action'] .= '<a type="button" class="btn btn-xs btn-primary btn-flat btn-block" >Plugins</a>';
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
	
	
	
	
	public function getConfig(){
		
		$UID = $this->input->post('UID');
		   
		$this->db->select('*');
		$this->db->from('tblmlconfig');
		$query = $this->db->get();
		$resultarray = $query->result();
		

		
			$data = array();
			if(!empty($resultarray))
			{
				
				
				
				foreach($resultarray as $dd) 
				{
					
					

					$this->db->select('*');
					$this->db->from('tbltaskml');
					$this->db->where('TaskID', $UID);
					$this->db->where('MLID', $dd->id);
					$queryres = $this->db->get();
					$result = $queryres->row();
					
			
					$Val=@$result->id;
					$AutoLoad=@$result->Autoload;
				
				
					$check1="";
					$check2="";
					
					if(!empty($Val)){
						$check1="checked";
					}
					
					if(!empty($AutoLoad) || $AutoLoad != 0 ){
						$check2="checked";
					}					
					
					$row = array();
					$row['id'] = '<input type="Checkbox" id="chk" name="chk[]" value="'.$dd->id.'"  '.$check1.' >';
					$row['MLName'] = $dd->MLName;
					$row['autoload'] = '<input type="Checkbox" id="chk" name="AutoLoad[]" value="'.$dd->id.'" '.$check2.' >';
		
		
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
	
	
	public function UpdatetaskConfiguration(){


		
		$Source 	      = (!empty($this->input->post('SOURCE')) ? 1 : 0);
		$Styling 		  = (!empty($this->input->post('Styling')) ? 1 : 0);
		$XMLEditor       = (!empty($this->input->post('XML_Editor')) ? 1 : 0);
		$SequenceLabeling = (!empty($this->input->post('SequenceLabeling')) ? 1 : 0);
		$TextCat 		  = (!empty($this->input->post('TextCat')) ? 1 : 0);
		$DataEntry 		  = (!empty($this->input->post('DataEntry')) ? 1 : 0);
		$TreeView 		  = (!empty($this->input->post('TreeView')) ? 1 : 0);
		
		$TaskID = $this->input->post('TaskID');
		$Processcode = $this->input->post('Processcode');
		$MenuGroup = $this->input->post('MenuGroup');
		
		//PROCESS 1
		//select if exist taskID in table		
        $query = $this->db->get_where('tbltaskeditorsetting', array('TaskID' => $TaskID));
		$count = $query->num_rows(); //counting result from query
		
		if ($count === 0) {
				// insert
				$data = array(
					'Source' => $Source,
					'Styling' => $Styling,
					'XMLEditor' => $XMLEditor,
					'SequenceLabeling' => $SequenceLabeling,
					'TextCategorization' => $TextCat,
					'DataEntry' => $DataEntry,
					'TreeView' => $TreeView,
					'MenuGroup' => $MenuGroup,
					'Processcode' => $Processcode,
					
				);
            $this->db->insert('tbltaskeditorsetting', $data);
        }
		else{
			
			// Update
				$data = array(
					'Source' => $Source,
					'Styling' => $Styling,
					'XMLEditor' => $XMLEditor,
					'SequenceLabeling' => $SequenceLabeling,
					'TextCategorization' => $TextCat,
					'DataEntry' => $DataEntry,
					'TreeView' => $TreeView,
					'MenuGroup' => $MenuGroup,
					'Processcode' => $Processcode,
					
				);
            $this->db->where('TaskID',$TaskID);
            $this->db->update('tbltaskeditorsetting',$data);
			
		}//end else
		
		
		//PROCESS 2
		$this->db->where('TaskID', $TaskID);
		$this->db->delete('tbltaskml');
	
		if(!empty($_POST['chk'])) {
			foreach($_POST['chk'] as $check) {
				$BatchID=$check;
				$autoload = 0;
				
				if(!empty($_POST['AutoLoad'])){
					foreach($_POST['AutoLoad'] as $load ){
						if($BatchID == $load ){
							$autoload = 1;
						}
					}
				}
				
				// insert
				$data = array(
					'TaskID' => $TaskID,
					'MLID' => $BatchID,
					'Autoload' => $autoload
				);
				$this->db->insert('tbltaskml', $data);
								
				$ctr++;
			}
		}

		
	}
	
	
}