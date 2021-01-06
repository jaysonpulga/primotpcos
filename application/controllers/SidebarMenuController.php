<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class SidebarMenuController extends CI_Controller
{
	public $WMSIdeagenDB;
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url'); 
		$this->load->library('session');
		$this->load->database();
		$this->SearchnetIdeagenDB = $this->load->database('SearchnetIdeagenDB', TRUE);
		$this->WMSIdeagenDB = $this->load->database('WMSIdeagenDB', TRUE);
		
		
			
			/** check if !isset session  redirect to login **/
			if(!$this->session->userdata('UserID')){ 
				redirect('login');
			}

	}
	
	
	public function Countmenubar(){
		
		$strSQLPrecoding = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND Status= 'NEW' ";
		$queryPrecoding = $this->WMSIdeagenDB->query($strSQLPrecoding);
		$countPrecoding = $queryPrecoding->result();
		
		
		

		$strSQLApproval = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND  Status= 'for Approval' ";
		$queryLApproval = $this->WMSIdeagenDB->query($strSQLApproval);
		$countApproval = $queryLApproval->result();
		
		$strSQLApproved = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND  Status= 'Approved' ";
		$queryApproved = $this->WMSIdeagenDB->query($strSQLApproved);
		$countApproved = $queryApproved->result();
		
		$strSQLRegistered = "SELECT * From  primo_view_Integration WHERE IsNull(Relevancy,'')='' AND  Status= 'Registered' ";
		$queryRegistered = $this->WMSIdeagenDB->query($strSQLRegistered);
		$countRegistered  = $queryRegistered->result();
		
		echo json_encode(
			array('countPrecoding' => count($countPrecoding),
				  'countApproval' => count($countApproval), 
				  'countApproved' => count($countApproved),
				  'countRegistered' => count($countRegistered)
				  )
		);
		
		

	}
	
	public static  function EnrichMenu(){
		
	
		$UserID = $_SESSION['UserID'];
		
		$conWMS=odbc_connect('WMSIdeagen','','');
		if (!$conWMS){
			exit("Connection Failed WMSIdeagen: " . $conWMS);
		}
		
		
		$strSQLApproval = "SELECT t1.UserId,t1.ProcessId,t1.WorkFlowId,process.ProcessCode,workflow.WorkFlowName  FROM NM_UsersProcesses as t1 INNER JOIN wms_Processes as process ON  process.ProcessId = t1.ProcessId   INNER JOIN  wms_WorkFlows as workflow  on workflow.WorkFlowId = t1.WorkFlowId where UserID = ".$UserID;
		
		$rs=odbc_exec($conWMS,$strSQLApproval);
		$WorkFlowName = array();
		
		$lCode="";
		while ($data = odbc_fetch_array($rs)) {
			
			$datax['UserId'] = $data['UserId'];
            $datax['ProcessId'] = $data['ProcessId'];
            $datax['WorkFlowId'] = $data['WorkFlowId'];
            $datax['ProcessCode'] = $data['ProcessCode'];
            $datax['WorkFlowName'] = $data['WorkFlowName']; 
			
			$ProcessCode = $data['ProcessCode'];
			$WorkFlowId = $data['WorkFlowId'];
			
			$datat = array();
			
		
			if($_SESSION['UserType']=='Admin')
			{
						
				if ($lCode=="")
				{
					$sql="SELECT * FROM primo_view_Jobs Where ProcessCode='$ProcessCode' AND  WorkFlowId = '$WorkFlowId' and statusstring<>'Done'";		
				}
				else
				{
					$sql="SELECT * FROM primo_view_Jobs Where ProcessCode='$ProcessCode' AND  WorkFlowId = '$WorkFlowId' and Jobname IN (Select Jobname from primo_view_Jobs Where ProcessCode='$lCode' and statusstring ='Done') AND StatusString='NEW'";			
				}
				
			}
			else
			{
				$sql="SELECT * FROM primo_view_Jobs Where ProcessCode='$ProcessCode' AND  WorkFlowId = '$WorkFlowId'  AND statusstring in('Allocated','Pending','Ongoing')  AND AssignedTo='$_SESSION[login_user]'";	
			}
				 
			$rs2=odbc_exec($conWMS,$sql);
			$ctr = odbc_num_rows($rs2);
			
			$datax2['UserId'] 	    = $data['UserId'];
			$datax2['ProcessId']    = $data['ProcessId'];
			$datax2['WorkFlowId']   = $data['WorkFlowId'];
			$datax2['ProcessCode']  = $data['ProcessCode'];
			$datax2['WorkFlowName'] = $data['WorkFlowName'];
			$datax2['countNum']     = $ctr;
		
		
			
			if($ctr > 0 ){
				
			
				while ($dd = odbc_fetch_array($rs2)) {
					
				

					$dat['filename'] = $dd['Filename'];
					$dat['BatchID'] = $dd['BatchId'];
					$dat['JObname'] = $dd['JobName'];
					$dat['RefId'] = $dd['RefId'];
					
					
					
					$datat[]  = $dat;
				}
				
				
			}else{
						
						$dat['filename'] = '';
						$dat['BatchID'] = '';
						$dat['JObname'] = '';
						$dat['RefId'] = '';
						$datat  = $dat;
			}	
			
			$datax2['data_value'] =  $datat;
				
			$WorkFlowName[ $data['WorkFlowName'] ][$data['ProcessCode']] = $datax2;
			
			$lCode=$ProcessCode;	

		}		
		
		return $WorkFlowName;
	
	}
		

}
