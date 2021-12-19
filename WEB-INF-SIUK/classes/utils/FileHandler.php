<?
/* *******************************************************************************************************
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Class that responsible to handle file
***************************************************************************************************** */

class FileHandler {
	/* PROPERTIES */
	/** 
	* Full path item yang akan ditangani
	* @var string
	**/
	var $source; 
	
	/** 
	* Lokasi upload bila akan disimpan dalam direktori tertentu 
	* @var string
	**/
	var $dirLocation;
	
	/** 
	* Full path file setelah diupload
	* @var string
	**/
	var $uploadedFile;
	
	/** 
	* Nama file setelah diupload
	* @var string
	**/
	var $uploadedFileName;
	var $uploadedExtension;
	var $uploadedSize;
	
	/* METHODS */
	function uploadToDir($varSource = "", $varDirLocation = "", $varRenameFile = "") 
	{
		if ($varSource !== "")
			$this->source = $varSource;

		if ($varDirLocation !== "") 
			$this->dirLocation = $varDirLocation;
		
		// if file renamed
		if ($varRenameFile !== "")
			$this->uploadedFileName = $varRenameFile;
		else
			$this->uploadedFileName = $_FILES[$varSource]['name'];

		$this->uploadedFile = $this->dirLocation.$this->uploadedFileName;
		$this->uploadedSize = $_FILES[$varSource]['size'];
		$this->uploadedExtension = $this->getFileExtension($this->uploadedFileName);
   
    	if(move_uploaded_file($_FILES[$this->source]['tmp_name'], $this->uploadedFile))
			return true;
		else
			return false;
	}
	
	function uploadToDirArray($varSource = "", $varDirLocation = "", $varRenameFile = "", $varArray = "") 
	{
		if ($varSource !== "")
			$this->source = $varSource;

		if ($varDirLocation !== "") 
			$this->dirLocation = $varDirLocation;
		
		// if file renamed
		if ($varRenameFile !== "")
			$this->uploadedFileName = $varRenameFile;
		else
			$this->uploadedFileName = $_FILES[$varSource]['name'][$varArray];

		$this->uploadedFile = $this->dirLocation.$this->uploadedFileName;
		$this->uploadedSize = $_FILES[$varSource]['size'][$varArray];
		$this->uploadedExtension = $this->getFileExtension($this->uploadedFileName);
   
    	if(move_uploaded_file($_FILES[$this->source]['tmp_name'][$varArray], $this->uploadedFile))
			return true;
		else
			return false;
	}
	
	function delete($varSource)
	{
		if ($varSource !== "")
			$this->source = $varSource;
		
		if (file_exists($this->source))
			return unlink($this->source);
		else
			return false;
	}
	
	function deleteAllow($varSource, $varDirLocation)
	{
		if ($varSource !== "")
			$this->source = $varSource;

		if ($varDirLocation !== "") 
			$this->dirLocation = $varDirLocation;

		if (is_dir($this->dirLocation )) {
		   if ($dh = opendir($this->dirLocation )) {
		       if (($file = readdir($dh)) !== false) {
		           //if (preg_match('/^D001_image\d\.jpg$/', $file))
		              unlink($this->source);
		       }
		       closedir($dh);
		   }
		   return true;
		}
	}
	
	function getFileName($varSource)
	{
		return $_FILES[$varSource]['name'];
	}
	
	function getFileNameArray($varSource, $i)
	{
		return $_FILES[$varSource]['name'][$i];
	}
	
	function getFileNameWithoutExtension($varSource)
	{
		$dotExt = ".".$this->getFileExtension($varSource);
		return str_replace($dotExt, $varSource);
	}
	
	function getFileExtension($varSource)
	{
		$temp = explode(".", $varSource);
		return end($temp);
	}
	
}
?>