<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');


class UserListController extends CI_Controller
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
	
        $this->load->view('configuration/userlist');
	}
	
	
	public function user_access(){
		
		 $UID = $this->input->get('UID');
		 $query = $this->db->get_where('tblUserAccess', array('UserID' => $UID));
		 $resultarray = $query->row();	
		 $this->load->view('configuration/user_access',array('UID'=>$UID,'user_access'=> $resultarray));
	}
	
	public function user_update(){
		
		$UserID = $this->input->get('UID');
		
		$this->db->select('*');
		$this->db->from('tbluser');
		$this->db->where('id',$UserID);
		$queryres = $this->db->get();
		$result = $queryres->row();		
		$this->load->view('configuration/user_update',array('userinfo'=>$result));
	}

	
	public function getData(){
		
		$this->db->select('*');
		$this->db->from('tbluser');
		$query = $this->db->get();
		$resultarray = $query->result();
		

		
			$data = array();
			if(!empty($resultarray))
			{
				
	
			
				foreach($resultarray as $dd) 
				{
					
					  
					
					
					$row = array();
					$row['id'] = @$dd->id;
					$row['UserName'] = @$dd->UserName;
					$row['Name'] = @$dd->Name;
					$row['UserType'] = @$dd->UserType;
					  
					$user_access="UserAccess?UID=".$dd->id."&TransType=Update&Name=".$dd->Name;
					$user_update="UserUpdate?UID=".$dd->id."&TransType=Update";
					
					$row['Action'] =  '<a href="'.$user_access.'" type="button" class="btn btn-xs btn-success btn-flat btn-block"> Access Rights</a>';
					$row['Action'] .= '<a href="'.$user_update.'" type="button" class="btn btn-xs btn-info  btn-flat btn-block"> Update</a>';
					$row['Action'] .= '<a type="button" class="btn btn-xs btn-danger btn-flat btn-block" data-id="'.$dd->id .'"> Delete</a>';
					
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
	
	
	public function get_tbluserreport(){
		
		$UserID = $this->input->post('UserID');
		   
		$this->db->select('*');
		$this->db->from('tblreport');
		$query = $this->db->get();
		$resultarray = $query->result();
		
			$data = array();
			if(!empty($resultarray))
			{
				
				
				
				foreach($resultarray as $dd) 
				{
					
					

					$this->db->select('*');
					$this->db->from('tbluserreport');
					$this->db->where('UserID',$UserID);
					$this->db->where('ReportID',$dd->ReportID);
					$queryres = $this->db->get();
					$result = $queryres->row();
					$Val=@$result->ReportID;
				
				
					$check1="";
					if(!empty($Val)){
						$check1="checked";
					}
					
				
					
					$row = array();
					$row['id'] = '<input type="Checkbox" id="chk" name="chk[]" value="'.$dd->ReportID.'"  '.$check1.' >';
					$row['ReportName'] = $dd->ReportName;

		
		
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
	
	
	public function get_process(){
		
		$UserID = $this->input->post('UserID');
		
		$strSQL="select wms_Processes.ProcessId,wms_Processes.ProcessCode,wms_Processes.Description,wms_WorkFlows.WorkFlowName,wms_WorkFlows.WorkFlowId from wms_Processes inner join wms_WorkFlowProcesses ON  wms_Processes.ProcessId = wms_WorkFlowProcesses.ProcessId Inner join wms_WorkFlows  on wms_WorkFlows.WorkFlowId = wms_WorkFlowProcesses.WorkFlowId ORDER BY wms_WorkFlowProcesses.RefID asc";
		
		$query = $this->WMSIdeagenDB->query($strSQL);
		$result = $query->result();
		
	

			
			$data = array();
			if(!empty($result))
			{
				
				
				
				foreach($result as $dd) 
				{
					
					
					
					$this->db->select('*');
					$this->db->from('tblusertask');
					$this->db->where('UserID',$UserID);
					$this->db->where('TaskID',$dd->ProcessId);
					$this->db->where('WorkFlowId',$dd->WorkFlowId);
					$queryres = $this->db->get();
					$result = $queryres->row();
					$Val=@$result->UserID;
					
					
				
					$check1="";
					if(!empty($Val)){
						$check1="checked";
					}
					
				
					
					$row = array();
					$row['id'] = '<input type="Checkbox" id="chk" name="chk[]" value="'.$dd->ProcessId.','.$dd->WorkFlowId.'"  '.$check1.' >';
					$row['ProcessCode'] = $dd->ProcessCode;
					$row['WorkFlowName'] = $dd->WorkFlowName;
					$row['Description'] = $dd->Description;

		
		
					$data[] = $row;
					
					
					
				}
				
				
				
			}
			else
			{
				$data = [];
			}
			
			
		   $output = array("data"=> $data,'res'=>$result);
		   echo json_encode($output);
		
		
	}
	
	public function update_user_access(){
		
		$ACQUIRE  					= (!empty($this->input->post('ACQUIRE')) ? 1 : 0);
		$ENRICH  					= (!empty($this->input->post('ENRICH')) ? 1 : 0);
		$DELIVER 					= (!empty($this->input->post('DELIVER')) ? 1 : 0);
		$USER_MAINTENANCE  			= (!empty($this->input->post('USER_MAINTENANCE')) ? 1 : 0);
		$EDITOR_SETTINGS 			= (!empty($this->input->post('EDITOR_SETTINGS')) ? 1 : 0);
		$ML_SETTINGS  				= (!empty($this->input->post('ML_SETTINGS')) ? 1 : 0);
		$TRANSFORMATION_SETTINGS  	= (!empty($this->input->post('TRANSFORMATION_SETTINGS')) ? 1 : 0);
		$TRANSMISSION_SETTINGS  	= (!empty($this->input->post('TRANSMISSION_SETTINGS')) ? 1 : 0);
		$ACQUISITION_REPORT  		= (!empty($this->input->post('ACQUISITION_REPORT')) ? 1 : 0);
		$CONFIDENCE_LEVEL_REPORT  	= (!empty($this->input->post('CONFIDENCE_LEVEL_REPORT')) ? 1 : 0);
		$TASK_SETTINGS  			= (!empty($this->input->post('TASK_SETTINGS')) ? 1 : 0);
		$DATAENTRY_SETTINGS  	    = (!empty($this->input->post('DATAENTRY_SETTINGS')) ? 1 : 0);
		$REPORT_MANAGEMENT  		= (!empty($this->input->post('REPORT_MANAGEMENT')) ? 1 : 0);
		$UserID  					= $this->input->post('UserID');
		
		
		//PROCESS 1
		//select if exist taskID in table		
        $query = $this->db->get_where('tblUserAccess', array('UserID' => $UserID));
		$count = $query->num_rows(); //counting result from query
		
		if ($count === 0) {
				// insert
				$data = array(
					'ACQUIRE' => $ACQUIRE,
					'ENRICH' => $ENRICH,
					'DELIVER' => $DELIVER,
					'USER_MAINTENANCE' => $USER_MAINTENANCE,
					'EDITOR_SETTINGS' => $EDITOR_SETTINGS,
					'ML_SETTINGS' => $ML_SETTINGS,
					'TRANSFORMATION' => $TRANSFORMATION_SETTINGS,
					'TRANSMISSION' => $TRANSMISSION_SETTINGS,
					'AQUISITIONREPORT' => $ACQUISITION_REPORT,
					'ConfidenceLevelReport' => $CONFIDENCE_LEVEL_REPORT,
					'TaskSetting' => $TASK_SETTINGS,
					'DataEntrySetting' => $DATAENTRY_SETTINGS,
					'REPORTMANAGEMENT' => $REPORT_MANAGEMENT
				);
            $this->db->insert('tbluserAccess', $data);
        }
		else{
			
			// Update
			$data = array(
					'ACQUIRE' => $ACQUIRE,
					'ENRICH' => $ENRICH,
					'DELIVER' => $DELIVER,
					'USER_MAINTENANCE' => $USER_MAINTENANCE,
					'EDITOR_SETTINGS' => $EDITOR_SETTINGS,
					'ML_SETTINGS' => $ML_SETTINGS,
					'TRANSFORMATION' => $TRANSFORMATION_SETTINGS,
					'TRANSMISSION' => $TRANSMISSION_SETTINGS,
					'AQUISITIONREPORT' => $ACQUISITION_REPORT,
					'ConfidenceLevelReport' => $CONFIDENCE_LEVEL_REPORT,
					'TaskSetting' => $TASK_SETTINGS,
					'DataEntrySetting' => $DATAENTRY_SETTINGS,
					'REPORTMANAGEMENT' => $REPORT_MANAGEMENT	
				);	
            $this->db->where('UserID',$UserID);
            $this->db->update('tbluserAccess',$data);
			
		}//end else
		
		
		
		//PROCESS 2
		$this->db->where('UserID', $UserID);
		$this->db->delete('tbluserreport');
		
		
		if(!empty($_POST['chk'])) {
			foreach($_POST['chk'] as $check) {
				$BatchID=$check; 
				// insert
				$data = array(
					'ReportID' => $BatchID,
					'UserID' => $UserID,
				);
				$this->db->insert('tbluserreport', $data); 
			}
		}

		
	}
	
	
	
	public function update_user_task_and_info(){
		
		
			$UserID    = $_SESSION['UserID'];
			$UserType  = $this->input->post('UserType');
			$Name	   = $this->input->post('Name');
			$UserName  = $this->input->post('UserName');
			$Password  = $this->input->post('Password');
		
			//PROCESS 1
			// Update 
			$data = array(
					'UserType' => $UserType,
					'Name' => $Name,
					'UserName' => $UserName,
					'Password' => $Password,
				);	
            $this->db->where('id',$UserID);
            $this->db->update('tbluser',$data);
			
			//update NM_use
			 if ($UserType=='Admin'){
				$UserLevel=9;
				$RoleID=1;
			}
			else{
				$UserLevel=0;
				$RoleID=7;
			}
			
			$strSQL="Update NM_Users SET LoginName='$UserName',password='$Password',FullName='$Name',UserLevel='$UserLevel',RoleID='$RoleID',ShiftID=1 ,Disabled=0,FacilityID=1,ManagerUserID=22 WHERE UserID='$UserID'";
			$this->WMSIdeagenDB->query($strSQL);
			
			
			//PROCESS 2
			$sqlDelete="DELETE FROM NM_UsersProcesses WHERE UserID ='$UserID'";
			$this->WMSIdeagenDB->query($sqlDelete);
			
			$this->db->where('UserID', $UserID);
			$this->db->delete('tblusertask');
			
			
			
			if(!empty($_POST['chk'])) {
				foreach($_POST['chk'] as $check) {
					
					
					$data = explode(",", $check);
					$BatchID = $data[0];
					$WorkFlowId = $data[1];
					

					 // insert
					$data = array(
						'UserID' => $UserID,
						'TaskID' => $BatchID,
						'WorkFlowId' => $WorkFlowId
					);
					$this->db->insert('tblusertask', $data);
					 

					$sqlinsert="INSERT INTO NM_UsersProcesses (UserID,ProcessID,WorkFlowId) VALUES ('$UserID','$BatchID','$WorkFlowId')";
					$this->WMSIdeagenDB->query($sqlinsert);
			
					
				
				}
			}
		
		
	}
	
}