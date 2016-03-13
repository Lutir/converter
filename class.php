<?php

ini_set('display_errors', 1); 
ini_set('log_errors', 1); 
ini_set('error_log', dirname(__FILE__) . '/error_log.txt'); 
error_reporting(E_ALL);
/* 
this class is used to convert any doc,docx file to simple text format.
*/ 

class Doc2Txt {
	private $filename;
	
	public function __construct($filePath) {
		$this->filename = $filePath;
	}
	
	private function read_doc()	{
		$fileHandle = fopen($this->filename, "r");
		$line = @fread($fileHandle, filesize($this->filename));   
		$lines = explode(chr(0x0D).chr(0x0A),$line);
		
		$fieldAndFieldValues = array();
		// $outtext = "";
		
		foreach($lines as $thisline)
		  {
			$pos = strpos($thisline, chr(0x00));
			if (($pos !== FALSE)||(strlen($thisline)==0))
			  {
			  	// break;
			  } else {
				// 
				// //echo $fields[0];
				
				// $fieldAndFieldValues[$fields[$i]] = $fields[$i+1];
				// $fieldAndFieldValues[$fields[$i]] = preg_replace("/[^a-zA-Z0-9\s\,\.\:\-\n\r\t@\/\_\(\)]/","",$fieldAndFieldValues[$fields[$i]]);
				// $i++;
				// $fieldAndFieldValues[$fields[$i]] = $fields[$i+1];
				// $fieldAndFieldValues[$fields[$i]] = preg_replace("/[^a-zA-Z0-9\s\,\.\:\-\n\r\t@\/\_\(\)]/","",$fieldAndFieldValues[$fields[$i]]);
				// $i++;
				$pattern = '/[:!]/';
				$fields = explode(':',$thisline);
				$fields = preg_split($pattern, $line);
				$fieldIds = array();
				$fieldValues = array();
				$fieldAndFieldValues = array();
				$count = 0;
				$i=0;
				for($i = 0; $i < sizeof($fields); $i++)
				{
					if($i%2 == 0)
					{
						$fieldIds[$count] = $fields[$i];
					} 
					else
					{
						$fieldValues[$count] = $fields[$i];
						$fieldAndFieldValues[$fieldIds[$count]] = $fieldValues[$count];
						$count++;
					}
				}
		 
				// $outtext .= $thisline." ";
			  }
		  }
		 // $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\:\-\n\r\t@\/\_\(\)]/","",$outtext);
		  //print_r($fieldAndFieldValues);
		 return $fieldAndFieldValues;
		// return $outtext;
	}

	private function read_docx(){

		$striped_content = '';
		$content = '';

		$zip = zip_open($this->filename);

		if (!$zip || is_numeric($zip)) return false;

		while ($zip_entry = zip_read($zip)) {

			if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

			if (zip_entry_name($zip_entry) != "word/document.xml") continue;

			$content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

			zip_entry_close($zip_entry);
		}// end while

		zip_close($zip);

		$content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
		$content = str_replace('</w:r></w:p>', "\r\n", $content);
		$striped_content = strip_tags($content);

		return $striped_content;
	}
	
	public function convertToText() {
	
		if(isset($this->filename) && !file_exists($this->filename)) {
			return "File Not exists";
		}
		
		$fileArray = pathinfo($this->filename);
		$file_ext  = $fileArray['extension'];
		if($file_ext == "doc" || $file_ext == "docx")
		{
			if($file_ext == "doc") {
				return $this->read_doc();
			} else {
				return $this->read_docx();
			}
		} else {
			return "Invalid File Type";
		}
	}
}
?>
