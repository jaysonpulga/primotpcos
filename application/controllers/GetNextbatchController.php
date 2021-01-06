<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');


class GetNextbatchController extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url'); 
		$this->load->database();
		$this->load->library('session');
		$this->load->model('DataEntrySettings_model');
		
		 error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		
		$this->SearchnetIdeagenDB = $this->load->database('SearchnetIdeagenDB', TRUE);
		$this->WMSIdeagenDB = $this->load->database('WMSIdeagenDB', TRUE);
			
			/** check if !isset session  redirect to login **/
			if(!$this->session->userdata('UserID')){ 
				redirect('login');
			}
		
	}
	
	
	public function AutoAllocate(){
		
		
		  $conWMS=odbc_connect('WMSIdeagen','','');
		  $err ='';
		 
		  $WorkFlowID = $_POST['WorkFlowId'];
		  $Task = $_POST['ProcessCode'];
		  $_SESSION['login_user'];
		  $sqls="EXEC usp_PRIMO_AUTOALLOCATE  @UserName='".$_SESSION['login_user']."', @ProcessCode='".$Task."',@WorkflowId='".$WorkFlowID."'";
		  odbc_exec($conWMS,$sqls);
		  $error = odbc_errormsg($conWMS);
		  if(!empty($error)){
			  
			 $err =  substr($error,47);  // get string error;
			 
			  $output = array("error" => true, "message" => $err, "count"=> count($resultquery), "RefId" => @$result->RefId, "BatchID" => @$result->BatchId, "Task" => @$result->ProcessCode   );
			  echo json_encode($output);
			  
		  }	
		  else{
			  
			 $sqlCount="SELECT * FROM primo_view_Jobs Where ProcessCode='$Task' AND statusstring in('Allocated','Pending','Ongoing')  AND AssignedTo='$_SESSION[login_user]'";
			 $query =$this->WMSIdeagenDB->query($sqlCount);
			 
			 
			
			 
			 $result = $query->row();
			 $resultquery = $query->result();
			 
			 $output = array("error" => false, "message" => $err,"count"=> count($resultquery), "RefId" => @$result->RefId, "BatchID" => @$result->BatchId, "Task" => @$result->ProcessCode   );
			 echo json_encode($output);
			  
			  
		  }

	}


}