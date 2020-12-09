<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');


class ListStyleSettingsController extends CI_Controller
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
	
	public function loadStyleData()
	{
		
		$this->db->select('*');
		$this->db->from('tblstyles');
		$this->db->order_by("StyleName", "asc");
		$query = $this->db->get();
		$resultarray = $query->result();
		
		$sLog ="";


			$data = array();
			if(!empty($resultarray))
			{
				
				foreach($resultarray as $dd) 
				{
						$row = array();
				
						$StyleName = $dd->StyleName;
						$Color     = $dd->Color;
						$FontColor = $dd->FontColor;
						$Inline    = $dd->Inline;
						$ctrlKey   = $dd->ctrlKey;
						$Shftkey   = $dd->Shftkey;
						$KeyVal    = $dd->KeyVal;
						
						if($ctrlKey==1){
							  $ctrl='CTRL';
					    }
					    else{
						  $ctrl='';
					    }
						
						
						if($Shftkey==1){
							$Shift='Shift';
						}
						else{
							$Shift='';
						}
						
						$keyVal=$KeyVal;
						$ShortcutKey='';
						
						if($ctrl!=''){
							$ShortcutKey=$ctrl;
						}
						
						
						if ($Shift!=''){
							if($ctrl!=''){
							$ShortcutKey=$ShortcutKey.'+'.$Shift;
							}
							else{
								$ShortcutKey=$Shift;
							}
						}
						
						
						if ($keyVal!=''){
							if ($Shift!=''){
								if ($ctrl!=''){
								$ShortcutKey=$ctrl.'+'.$Shift.'+'.$keyVal;
								}
								else{
									$ShortcutKey=$Shift.'+'.$keyVal;
								}
							}
							else{
								if ($ctrl!=''){
									$ShortcutKey=$ctrl.'+'.$keyVal;
								}
							}
						}
						else{
							$ShortcutKey='';
						}
						
						
						
						if ($Inline==1){
							$sLog .= "<p style='background-color:".$Color.";'><a href='#'style='color: ".$FontColor."' onclick='StyleDoc(\"".$StyleName."\",\"".$Inline."\")'> ".$StyleName."  <sub>".$ShortcutKey."</sub></a></p>";
						}
						else{
							$sLog .= "<p style='background-color:".$Color.";border-style: solid;border-color:".$Color.";'><a href='#'style='color: ".$FontColor."' onclick='StyleDoc(\"".$StyleName."\",\"".$Inline."\")'> ".$StyleName."  <sub>".$ShortcutKey."</sub></a></p>";
						}
						
						
					
				}
				
				
				
			}
	
			
			echo $sLog;
			
	}

	


}