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

  class DataAgen extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function DataAgen(){
      $this->Entity(); 
    }
	
	function insert(){
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("AGEN_ID", $this->getNextId("AGEN_ID","PPI.DATA_AGEN")); 		
		$str = "
				INSERT INTO PPI.DATA_AGEN (
				   AGEN_ID, NAMA, JENIS, TELPON, FAX, EMAIL, WEBSITE, KOTA, ALAMAT, KATEGORI, KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("AGEN_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("JENIS")."',
				  '".$this->getField("TELPON")."',
				  '".$this->getField("FAX")."',
				  '".$this->getField("EMAIL")."',
				  '".$this->getField("WEBSITE")."',
				  '".$this->getField("KOTA")."',
				  '".$this->getField("ALAMAT")."',
				  '".$this->getField("KATEGORI")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")." 
				)"; 
		$this->id = $this->getField("AGEN_ID");
		$this->query = $str;
		//echo $str; exit;
		return $this->execQuery($str);
    }

    function update(){
		$str = "
				UPDATE PPI.DATA_AGEN 
				SET    
					NAMA   				= '".$this->getField("NAMA")."',
					JENIS   			= '".$this->getField("JENIS")."',
					TELPON   			= '".$this->getField("TELPON")."',
					FAX 				= '".$this->getField("FAX")."',
					KOTA   				= '".$this->getField("KOTA")."',
					ALAMAT 				= '".$this->getField("ALAMAT")."',
					WEBSITE   			= '".$this->getField("WEBSITE")."',
					EMAIL 				= '".$this->getField("EMAIL")."',
					KATEGORI 			= '".$this->getField("KATEGORI")."',
					KETERANGAN 			= '".$this->getField("KETERANGAN")."',
					LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")." 
				WHERE  AGEN_ID 		= ".$this->getField("AGEN_ID")."  
			 "; 
		$this->query = $str;
		//echo $str; exit;
		return $this->execQuery($str);
    }
	
	function delete(){
        $str = "
				DELETE FROM PPI.DATA_AGEN 
                WHERE 
                  AGEN_ID = '".$this->getField("AGEN_ID")."'
			"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=""){
		$str = "
				SELECT AGEN_ID, NAMA, TELPON, ALAMAT, FAX, KOTA, EMAIL, WEBSITE, KATEGORI, KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE, LAST_UPDATE_USER, LAST_UPDATE_DATE, JENIS 
				FROM PPI.DATA_AGEN 			
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
    function selectByParamsKategori($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=""){
		$str = "
				SELECT TRIM(KATE) AS KATEGORI
				FROM (
				    WITH TAB AS (SELECT DISTINCT KATEGORI STR FROM PPI.DATA_AGEN WHERE KATEGORI IS NOT NULL)
				        SELECT SUBSTR(STR, INSTR(STR, ',', 1, LVL) + 1, INSTR(STR, ',', 1, LVL + 1) - INSTR(STR, ',', 1, LVL) - 1) KATE 
				    FROM ( SELECT ',' || STR || ',' AS STR  FROM TAB ), ( SELECT LEVEL AS LVL FROM DUAL CONNECT BY LEVEL <= 100 )
				    WHERE LVL <= LENGTH(STR) - LENGTH(REPLACE(STR, ',')) - 1
				    ORDER BY KATE
				)			
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
    
    function getCountByParams($paramsArray=array(), $statement="")	{
		$str = "SELECT COUNT(AGEN_ID) AS ROWCOUNT FROM PPI.DATA_AGEN 	
		        WHERE AGEN_ID IS NOT NULL ".$statement; 		
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

  } 
?>