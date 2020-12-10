<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataEntrySettings_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('cookie');
		$this->load->library('session');
		$this->SearchnetIdeagenDB = $this->load->database('SearchnetIdeagenDB', TRUE);
		$this->WMSIdeagenDB = $this->load->database('WMSIdeagenDB', TRUE);
	}

	
	public function loaddDataEntry()
	{
		
		$this->db->select('*');
		$this->db->from('tbldataentry');
		$query = $this->db->get();
		$data = $query->result();
		
		$returndata = array();
		

		
		foreach($data as $field){
			
			$value ="" ;
		
				switch ($field->FieldType) {
					  case "dropdown":
					  
							$value .= '<div class="form-group">';
							$value	.=	'<label >$field->FieldCaption</label><br>';
							$value	.=	 '<select  class="form-control form_answer" name="'.$field->FieldName.'" id="'.$field->FieldName.'"  data-fieldtype="'.$field->FieldType.'" data-fieldcaption="'.$field->FieldCaption.'"   >';
											$cats = explode("|",$field->FieldOption);
												foreach($cats as $cat) {
							$value .=	        '<option value="No">'.$cat.'</option>';
											}
							$value .=	'</select>';
							$value .= '</div>';
						
						break;
						case "textarea":
									
								$value .= '<div class="form-group">';
								$value .= '<label >'.$field->FieldCaption.'</label><br>';
								$value .= '<textarea class="form-control form_answer" id="'.$field->FieldName.'" name="'.$field->FieldName.'" rows="4" cols="50" data-fieldtype="'.$field->FieldType.'"  data-fieldcaption="'.$field->FieldCaption.'"  ></textarea>';
								$value .= '</div>';
						
						break;
						
					  default:
								$value .= '<div class="form-group">';
								$value .= '<label >'.$field->FieldCaption.'</label><br>';
								$value .= '<input type="'.$field->FieldType.'" class="form-control form_answer" placeholder="'.$field->FieldCaption.'" name="'.$field->FieldName.'" id="'.$field->FieldName.'"  data-fieldtype="'.$field->FieldType.'" data-fieldcaption="'.$field->FieldCaption.'"   >';
								$value .= '</div>';
					  
					  
					}
			
				$returndata[] = $value;
		}
		
		$htmlForm ="";
		
		//iterate and dispaly as html form
		foreach($returndata as $displayForm){
			$htmlForm .= $displayForm;
		}
		
		return $htmlForm;
		
	}
	
}