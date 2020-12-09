<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class RegistrationController extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url'); 
		$this->load->library('session');
			
			/** check if !isset session  redirect to login **/
			if(!$this->session->userdata('UserID')){ 
				redirect('login');
			}

	}
	
	
	public function index(){
	
        $this->load->view('acquire/registration');
	}
	
	
}
