<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		
		 /*Load the URL helper*/ 
         $this->load->helper('url');
		 $this->load->library('session');
	
	}
	
	
	
	public function signout()
	{
		$this->session->sess_destroy();
		redirect("login");  
	}
	
	
}
