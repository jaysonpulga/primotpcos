<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class functions_library {

	public function UTF8_encoding($string){
		$encoding = mb_detect_encoding($string, mb_detect_order(), false);
		if($encoding == "UTF-8"){
			$string = mb_convert_encoding($string, "UTF-8", "Windows-1252");
		}
		
		$out = iconv(mb_detect_encoding($string, mb_detect_order(), false), "UTF-8//IGNORE", $string);
		return $out;
	}

	 public function replace_quote($array){
		$newArray = array();
		foreach ($array as $key => $value) {
			if($key!='AR'){
				$value = str_replace("'","''", $value);
				$newArray[$key] = $value;
				// $newArray[$key] = $this->mb_htmlentities($value, false);
			}
		}
		return $newArray;
	}

	public function getTagValues($tag, $str) {
		$re = sprintf("/\<(%s)\>(.+?)\<\/\\1\>/", preg_quote($tag));
		preg_match_all($re, $str, $matches);
		return $matches[2];
	}

	 public function mb_htmlentities($string, $hex = true, $encoding = 'UTF-8') {
		return preg_replace_callback('/[\x{80}-\x{10FFFF}]/u', function ($match) use ($hex){
		return sprintf($hex ? '&#x%X;' : '&#%d;', mb_ord($match[0]));
		// return sprintf($hex ? '&#x%X;' : '&#%d;', ord($match[0]));
		}, $string);
	}

	public function mb_html_entity_decode($string, $flags = null, $encoding = 'UTF-8') {
		return html_entity_decode($string, ($flags === NULL) ? ENT_COMPAT | ENT_HTML401 : $flags, $encoding);
	}

}