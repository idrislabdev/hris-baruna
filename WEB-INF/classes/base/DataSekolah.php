<?php
/* *******************************************************************************************************
MODUL NAME 			: PEL
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel AGAMA.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class DataSekolah extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function DataSekolah(){
      $this->Entity(); 
    }
	
	function insert(){
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SEKOLAH_ID", $this->getNextId("SEKOLAH_ID","PPI.DATA_SEKOLAH")); 		
		$str = "
				INSERT INTO PPI.DATA_SEKOLAH (
				   SEKOLAH_ID, NAMA, TELPON, FAX, EMAIL, WEBSITE, KOTA, ALAMAT, REKOMENDASI_N, REKOMENDASI_T, SERTIFIKAT, TGL_SERTIFIKAT, APPROVAL_DESC, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("SEKOLAH_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("TELPON")."',
				  '".$this->getField("FAX")."',
				  '".$this->getField("EMAIL")."',
				  '".$this->getField("WEBSITE")."',
				  '".$this->getField("KOTA")."',
				  '".$this->getField("ALAMAT")."',
				  '".$this->getField("REKOMENDASI_N")."',
				  '".$this->getField("REKOMENDASI_T")."',
				  '".$this->getField("SERTIFIKAT")."',
				  ".$this->getField("TGL_SERTIFIKAT").",
				  '".$this->getField("APPROVAL_DESC")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")." 
				)"; 
		$this->id = $this->getField("SEKOLAH_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update(){
		$str = "
				UPDATE PPI.DATA_SEKOLAH 
				SET    
					NAMA   				= '".$this->getField("NAMA")."',
					TELPON   			= '".$this->getField("TELPON")."',
					FAX 				= '".$this->getField("FAX")."',
					KOTA   				= '".$this->getField("KOTA")."',
					ALAMAT 				= '".$this->getField("ALAMAT")."',
					WEBSITE   			= '".$this->getField("WEBSITE")."',
					EMAIL 				= '".$this->getField("EMAIL")."',
					REKOMENDASI_N 		= '".$this->getField("REKOMENDASI_N")."',
					REKOMENDASI_T 		= '".$this->getField("REKOMENDASI_T")."',
					SERTIFIKAT 			= '".$this->getField("SERTIFIKAT")."',
					TGL_SERTIFIKAT 		= ".$this->getField("TGL_SERTIFIKAT").",
					APPROVAL_DESC		= '".$this->getField("APPROVAL_DESC")."',
					LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")." 
				WHERE  SEKOLAH_ID 		= ".$this->getField("SEKOLAH_ID")."  
			 "; 
		$this->query = $str;
		//echo $str; exit;
		return $this->execQuery($str);
    }
	
	function delete(){
        $str = "
				DELETE FROM PPI.DATA_SEKOLAH 
                WHERE 
                  SEKOLAH_ID = '".$this->getField("SEKOLAH_ID")."'
			"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=""){
		$str = "
				SELECT SEKOLAH_ID, NAMA, EMAIL, WEBSITE, TELPON, ALAMAT, FAX, REKOMENDASI_N, REKOMENDASI_T, SERTIFIKAT, TGL_SERTIFIKAT, TO_CHAR(TGL_SERTIFIKAT, 'DD MON YYYY') TEXT_TGL_SERTIFIKAT, APPROVAL_DESC, KOTA 
				FROM PPI.DATA_SEKOLAH 			
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")	{
		$str = "
				SELECT SEKOLAH_ID, NAMA, TELPON, ALAMAT, FAX, REKOMENDASI_N, REKOMENDASI_T, SERTIFIKAT, TGL_SERTIFIKAT, APPROVAL_DESC, KOTA 
				FROM PPI.DATA_SEKOLAH 			
				WHERE 1 = 1
			 "; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    function getCountByParams($paramsArray=array(), $statement="")	{
		$str = "SELECT COUNT(SEKOLAH_ID) AS ROWCOUNT FROM PPI.DATA_SEKOLAH 	
		        WHERE SEKOLAH_ID IS NOT NULL ".$statement; 		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
    function getCountByParamsLike($paramsArray=array(), $statement=""){
		$str = "SELECT COUNT(SEKOLAH_ID) AS ROWCOUNT FROM PPI.DATA_SEKOLAH 	
		        WHERE SEKOLAH_ID IS NOT NULL ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	
  } 
?>