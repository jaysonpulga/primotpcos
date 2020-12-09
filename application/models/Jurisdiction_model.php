<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurisdiction_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('cookie');
		$this->load->library('session');
		$this->SearchnetIdeagenDB = $this->load->database('SearchnetIdeagenDB', TRUE);
		$this->WMSIdeagenDB = $this->load->database('WMSIdeagenDB', TRUE);
	}


		
	// load dropdown jurisdiction list
	public  function load_Jurisdiction()
	{
			$sql="Select DISTINCT Jurisdiction From tblJurisdiction ORDER BY Jurisdiction";
			$query = $this->WMSIdeagenDB->query($sql);
			$res = $query->result();
			$arrayrow = $query->row();
			return $res;
	}
}