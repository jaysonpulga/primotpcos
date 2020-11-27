<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		
		 /*Load the URL helper*/ 
         $this->load->helper('url'); 
		 
		  /*Load the cookie */
		 $this->load->helper('cookie');
		 $this->load->library('session');
		 $this->load->model('Login_model');
		 
			/** check session is set redirect to dashboard **/
			if($this->session->userdata('UserID')){ 
				redirect('dashboard');
			}
		
	}
	
	
	public function index(){
		
        $this->load->view('login');
	}
	
	
	public function signin()
	{
		
		   $this->load->library('form_validation');  
           $this->form_validation->set_rules('username', 'username', 'required');  
           $this->form_validation->set_rules('password', 'password', 'required');  
           if($this->form_validation->run())  
           {  
                //true  
                $username = $this->input->post('username');  
                $password = $this->input->post('password');  

                $result = $this->Login_model->ChecktoLogin($username, $password); 
				if($result == false)
                {  
                     $this->session->set_flashdata('error', '*Invalid username and password');  
                     redirect(base_url().'login');  
                } 
				
           }  
           else  
           {  
                //false  
                $this->index();  
           }  
		
	
	
	}
	
	
	
}
