<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: Upload.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Class that responsible to handle upload file
***************************************************************************************************** */

class Upload {
	/* PROPERTIES */
	/** 
	* Item yang akan diupload 
	* @var string
	**/
	var $item; 
	
	/** 
	* Lokasi upload bila akan disimpan dalam direktori tertentu 
	* @var string
	**/
	var $dirLocation;
	
	/** 
	* Field (tipe blob) pada tabel bila akan disimpan dalam database  
	* @var string
	**/
	var $fieldLocation;
	
	/* METHODS */
	function uploadToDir($source="", $destination="") {
		if ($source == "") {
			$source = $this->item;
		}
		if ($destination == "") {
			$destination = $this->dirLocation;
		}
		move_uploaded_file($_FILES[$item]["tmp_name"], $destination);
	}
	
	function uploadToDB() {
	
	}
}
?>