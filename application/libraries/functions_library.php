<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class functions_library {
	
	
	private $ProjectName = "primotpcos";

	public function UTF8_encoding($string){
		$encoding = mb_detect_encoding($string, mb_detect_order(), false);
		if($encoding == "UTF-8"){
			$string = mb_convert_encoding($string, "UTF-8", "Windows-1252");
		}
		
		$out = iconv(mb_detect_encoding($string, mb_detect_order(), false), "UTF-8//IGNORE", $string);
		return $out;
	}
	
	public function CreateFolderAndFileforTestingPurpose($RefId,$Filename){
		
		$File_Extension = pathinfo($Filename,PATHINFO_EXTENSION);
		
		$directory = 'uploadfiles/'.$RefId;
		if (!file_exists($directory)) {
		    mkdir($directory, 0777, true);
			
				if($File_Extension == 'pdf' || $File_Extension == 'PDF' )
				{
					$source = 'uploadfiles/sample_long.pdf'; 
					$destination = 'uploadfiles/'.$RefId.'/'.$Filename; 
				}
				else if($File_Extension == 'html' || $File_Extension == 'HTML' || $File_Extension == 'htm' )
				{
					$source = 'uploadfiles/sample.html'; 
					$destination = 'uploadfiles/'.$RefId.'/'.$Filename; 
				}
				else if($File_Extension == 'doc' || $File_Extension == 'docx' )
				{
					$source = 'uploadfiles/sample.doc'; 
					$destination = 'uploadfiles/'.$RefId.'/'.$Filename; 
				}
			
				copy($source,$destination);
				
		}
		
	}
	
	
		public function convertPDFToHTML($RefId, $filename){
		
		$pdf_file =  $_SERVER{'DOCUMENT_ROOT'}."\\".$this->ProjectName."\\uploadfiles\\".$RefId."\\".pathinfo($filename, PATHINFO_FILENAME).".pdf";
		$html_dir =  $_SERVER{'DOCUMENT_ROOT'}."\\".$this->ProjectName."\\uploadfiles\\".$RefId."\\".pathinfo($filename, PATHINFO_FILENAME).".html";
		$cmd = "pdftotext $pdf_file $html_dir";
		$cmd = "mutool convert -o $html_dir $pdf_file";
		exec($cmd, $out, $ret);
		
	}
	
	
	public function convertDocToHTML($RefId, $RealfileNameDoc){
		
		$filename = pathinfo($RealfileNameDoc, PATHINFO_FILENAME);
		$File_Extension = pathinfo($RealfileNameDoc,PATHINFO_EXTENSION);
		
		$doc_dir =  $_SERVER{'DOCUMENT_ROOT'}."\\".$this->ProjectName."\\uploadfiles\\".$RefId."\\".pathinfo($filename, PATHINFO_FILENAME).".".$File_Extension;
		$html_dir =  $_SERVER{'DOCUMENT_ROOT'}."\\".$this->ProjectName."\\uploadfiles\\".$RefId."\\".pathinfo($filename, PATHINFO_FILENAME).".html";
		
		$outdirFile =  $_SERVER{'DOCUMENT_ROOT'}."\\".$this->ProjectName."\\uploadfiles\\".$RefId;
		
	    $exeute = $_SERVER{'DOCUMENT_ROOT'}."\\".$this->ProjectName."\\LibreOffice\\program\\soffice.exe --headless  -convert-to html ".$doc_dir." -outdir " . $outdirFile;
		
		exec($exeute, $out, $ret);
		
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