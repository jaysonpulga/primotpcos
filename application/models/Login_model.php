<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('cookie');
		$this->load->library('session');
		$this->SearchnetIdeagenDB = $this->load->database('SearchnetIdeagenDB', TRUE);
		$this->WMSIdeagenDB = $this->load->database('WMSIdeagenDB', TRUE);
	}
	
	public function ChecktoLogin($username,$password)
	{
		
		/*
		$sql="SELECT * FROM primo_view_Jobs Where ProcessCode='ENRICHMENT' AND statusstring in('Allocated','Pending','Ongoing')  AND AssignedTo='$username'";	
		$query =$this->WMSIdeagenDB->query($sql);
		$res = $query->result();
		$arrayrow = $query->row();
		print_r($res);
		exit;
		*/
		
		
		
		$this->db->select('user.*, access.*');
		$this->db->from('tbluser as user');
		$this->db->join('tblUserAccess as access', 'access.UserID = user.id');
		$this->db->where('user.UserName',$username);
		$this->db->where('user.Password',$password);
		$query = $this->db->get();
		$array = $query->row();
		$result_array = $query->result_array();
		
		
		$SESSION = array();
	
		if($query->num_rows() > 0)
		{
			$row = $result_array[0];
			
			$SESSION['login_user'] = $username;
		 	$SESSION['UserID'] = $row['id'];
			$SESSION['EName'] = $row['Name'];
			$SESSION['UserType'] = $row['UserType'];
			$SESSION['ACQUIRE'] = $row['ACQUIRE'];
			$SESSION['ENRICH'] = $row['ENRICH'];
			$SESSION['DELIVER'] = $row['DELIVER'];
			$SESSION['USER_MAINTENANCE'] = $row['USER_MAINTENANCE'];
			$SESSION['EDITOR_SETTINGS'] = $row['EDITOR_SETTINGS'];
			$SESSION['ML_SETTINGS'] = $row['ML_SETTINGS'];
			$SESSION['TRANSFORMATION'] = $row['TRANSFORMATION'];
			$SESSION['TRANSMISSION'] = $row['TRANSMISSION'];
			$SESSION['AQUISITIONREPORT'] = $row['AQUISITIONREPORT'];
			$SESSION['CONFIDENCELEVELREPORT'] = $row['ConfidenceLevelReport'];
			$SESSION['TASKSETTING'] = $row['TaskSetting'];
			$SESSION['DATAENTRYSETTING'] = $row['DataEntrySetting'];
			$SESSION['REPORTMANAGEMENT'] = $row['REPORTMANAGEMENT'];
			
			$this->session->set_userdata($SESSION);
			
			redirect("dashboard");
			return;

			
		}	
		else
		{
			return false;
			exit();
		}
	
	
	
	}
	
	
	
}