<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');


class EditorSettingsController extends CI_Controller
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
	
	
	public function index(){
	
        $this->load->view('configuration/editorsettings');
	}

	
	public function getDataEditorSettings(){
		
		$this->db->select('*');
		$this->db->from('tblstyles');
		$query = $this->db->get();
		$resultarray = $query->result();
		

		
			$data = array();
			if(!empty($resultarray))
			{
				
	
			
				foreach($resultarray as $dd) 
				{
					
					  
					
					
					$row = array();
					$row['StyleID'] = @$dd->StyleID ;
					$row['StyleName'] = @$dd->StyleName;
					$row['Color'] =   '<input type="Color"  name="Color" value='.@$dd->Color.'> ';
					$row['FontColor'] = '<input type="Color"  name="FontColor" value='.@$dd->FontColor.'> ';
					
					  
					  //Inline
					  if (@$dd->Inline==1){
						  $Inline='checked';
					  }
					  else{
						  $Inline='';
					  }
					  
					  
					  //ctrlKey
					  if (@$dd->ctrlKey==1){
						  $ctrl='CTRL';
					  }
					  else{
						  $ctrl='';
					  }
					
					  
					  //Shftkey
					  if (@$dd->Shftkey==1){
						  $Shift='Shift';
					  }
					  else{
						  $Shift='';
					  }
					
					
					 //KeyVal
					 $Keyvalue = $dd->KeyVal;
					
					
					$ShortcutKey='';
					
					if ($ctrl!=''){
						$ShortcutKey=$ctrl;
					}
					
					if ($Shift!=''){
						if ($ctrl!=''){
						$ShortcutKey=$ShortcutKey.'+'.$Shift;
						}
						else{
							$ShortcutKey=$Shift;
						}
					}
					
					
					
					if(	!empty($Keyvalue) ){
						
						if ($Shift!=''){
							if ($ctrl!=''){
							$ShortcutKey=$ctrl.'+'.$Shift.'+'.$Keyvalue;
							}
							else{
								$ShortcutKey=$Shift.'+'.$Keyvalue;
							}
						}
						else{
							if ($ctrl!=''){
								$ShortcutKey=$ctrl.'+'.$Keyvalue;
							}
						}
					}
					else{
						$ShortcutKey='';
					}
					

					
					
					$row['Inline'] = '<input type="checkbox"  name="Inline"  '.$Inline.' >';
					$row['ShortcutKey'] = $ShortcutKey;
					
					$row['Action']  = '<button type="button" class="btn btn-xs btn-info edit" data-id="'.$dd->StyleID.'" >Update</button>&nbsp;&nbsp;';
					$row['Action'] .= '<button class="btn btn-xs btn-danger delete" data-id="'.$dd->StyleID.'">Delete</button>';
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
	
	
	public function addnewStyle(){
		
		$Inline = ($this->input->post('Inline') !='' ? 1 : 0 );
		$ctrlKey = ($this->input->post('ctrlKey') !='' ? 1 : 0 );
		$Shftkey = ($this->input->post('Shftkey') !='' ? 1 : 0 );
		
		$StyleName = $this->input->post('StyleName');
		
		$this->db->select('*');
		$this->db->from('tblstyles');
		$this->db->where('StyleName',$StyleName);
		$query = $this->db->get();
		$resultarray = $query->result();
		
		if($query->num_rows() == 0){
		
		
			$data = array(
		
				'StyleName'    => $StyleName,
				'Color'    => $this->input->post('Color'),
				'FontColor'  => $this->input->post('FontColor'),
				'Inline' => $Inline,
				'ctrlKey' => $ctrlKey,
				'Shftkey' => $Shftkey,
				'KeyVal' => $this->input->post('KeyVal'),
			);

		    $this->db->insert('tblstyles', $data);
			
			
			$this->ovewriteCssFile();
			
			
			echo "created";
		
		}
		else
		{
			echo "exist";
		}
	 

		
		
	}
	
	
	
	public function getStlebyID(){
		
	
		$id = $this->input->post('id');
		$query = $this->db->get_where('tblstyles', array('StyleID  ' => $id));
        $data = $query->row();
		echo json_encode($data);
		
		
	}
	
	public function updateStyle(){
		
		
		$StyleID = $this->input->post('StyleID');
		
		$Inline = ($this->input->post('Inline') !='' ? 1 : 0 );
		$ctrlKey = ($this->input->post('ctrlKey') !='' ? 1 : 0 );
		$Shftkey = ($this->input->post('Shftkey') !='' ? 1 : 0 );
		 $StyleName = $this->input->post('StyleName'); 
		  
		  $data = array(
		  
				'StyleName'    => $StyleName,
				'Color'    => $this->input->post('Color'),
				'FontColor'  => $this->input->post('FontColor'),
				'Inline' => $Inline,
				'ctrlKey' => $ctrlKey,
				'Shftkey' => $Shftkey,
				'KeyVal' => $this->input->post('KeyVal'),
			);
		  
		  $this->db->where('StyleID', $StyleID);
		  $this->db->update('tblstyles', $data);
		  
		  
		 $this->ovewriteCssFile();
			
			
			echo "created";
		
		
	}
	
	
	
	public function deleteStyle(){
		
		
		$id = $this->input->post('id');
		$this->db->delete('tblstyles', array('StyleID' => $id));
		$this->ovewriteCssFile();
	}
	
	public function ovewriteCssFile(){
		
		    $prTExt="body\r\n{\r\nfont-family: Arial, Verdana, sans-serif;\r\nfont-size: 12px;\r\ncolor: #222;\r\nbackground-color: #fff;\r\n}\r\n";
			
			
			$this->db->select('*');
			$this->db->from('tblstyles');
			$query = $this->db->get();
			$resultarray = $query->result();
			
			foreach($resultarray as $data){
				
				$StyleName = $data->StyleName;
				$Color = $data->Color;
				$FontColor = $data->FontColor;
				$Inline = $data->Inline;

				
				
				if ($Inline==1){
				$prTExt=$prTExt."span.".$StyleName." { background-color:".$Color."; color: ".$FontColor.";}\r\n";
				}
				else{
					$prTExt=$prTExt."div.".$StyleName." {  background-color:".$Color.";border-style:solid; border-color:".$Color."; color: ".$FontColor.";}\r\n";
				}
				
			}
			
			$prTExt=$prTExt."span.ATC { text-decoration: underline;text-decoration-color: red; text-decoration-style: wavy;}";
			file_put_contents("assets/ckeditor/stylesheetparser.css", $prTExt);
		
	}
	
}