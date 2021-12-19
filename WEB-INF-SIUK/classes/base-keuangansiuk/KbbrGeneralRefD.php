<? 
/* *******************************************************************************************************
MODUL NAME 			: IMASYS
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_GENERAL_REF_D.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrGeneralRefD extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrGeneralRefD()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("KBBR_GENERAL_REF_D_ID", $this->getNextId("KBBR_GENERAL_REF_D_ID","KBBR_GENERAL_REF_D")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_GENERAL_REF_D (
				   KD_CABANG, JENIS_FILE, ID_FILE, 
				   ID_REF_FILE, ID_REF_DATA, KET_REF_DATA, 
				   KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				   PROGRAM_NAME) 
				VALUES ( '".$this->getField("KD_CABANG")."', '".$this->getField("JENIS_FILE")."', '".$this->getField("ID_FILE")."',
					'".$this->getField("ID_REF_FILE")."', '".$this->getField("ID_REF_DATA")."', '".$this->getField("KET_REF_DATA")."',
					'".$this->getField("KD_AKTIF")."', ".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."', 
					'".$this->getField("PROGRAM_NAME")."'
				)";
				
		$this->id = $this->getField("KBBR_GENERAL_REF_D_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_GENERAL_REF_D
				SET    
					   ID_REF_DATA      = '".$this->getField("ID_REF_DATA")."',
					   KET_REF_DATA     = '".$this->getField("KET_REF_DATA")."',
					   KD_AKTIF         = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."'
				WHERE  ID_REF_FILE = '".$this->getField("ID_REF_FILE")."' AND ID_REF_DATA = '".$this->getField("ID_REF_DATA_TEMP")."' 
			";
		/*KD_CABANG        = '".$this->getField("KD_CABANG")."',
	    JENIS_FILE       = '".$this->getField("JENIS_FILE")."',
	    ID_FILE          = '".$this->getField("ID_FILE")."',
	    ID_REF_FILE      = '".$this->getField("ID_REF_FILE")."',
		PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."'*/
					   
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_GENERAL_REF_D
                WHERE 
                  ID_REF_DATA = '".$this->getField("ID_REF_DATA")."' AND ID_REF_FILE = '".$this->getField("ID_REF_FILE")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT KD_CABANG, JENIS_FILE, ID_FILE, 
				ID_REF_FILE, ID_REF_DATA, KET_REF_DATA, 
				CASE WHEN KD_AKTIF = 'A' THEN 'AKTIF' ELSE KD_AKTIF END KD_AKTIF_INFO,
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME
				FROM KBBR_GENERAL_REF_D A
				WHERE 1 = 1
				"; 
				
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
		function selectByParamsJurnal($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT ID_REF_DATA JURNAL
				FROM KBBR_GENERAL_REF_D
				WHERE ID_REF_FILE = 'JENISJURNAL'
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." GROUP BY ID_REF_DATA ORDER BY ID_REF_DATA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsRegisterJurnal($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT ID_REF_DATA JURNAL
				FROM KBBR_GENERAL_REF_D
				WHERE ID_REF_FILE = 'JENISJURNAL'
				AND ID_REF_DATA IN ('JKK', 'JKM')
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." GROUP BY ID_REF_DATA ORDER BY ID_REF_DATA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, JENIS_FILE, ID_FILE, 
				ID_REF_FILE, ID_REF_DATA, KET_REF_DATA, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME
				FROM KBBR_GENERAL_REF_D
				WHERE 1 = 1
			  "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KD_CABANG ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(ID_REF_FILE) AS ROWCOUNT FROM KBBR_GENERAL_REF_D
		        WHERE 1 = 1 ".$statement; 
		
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

    function getSetting($paramsArray=array(), $statement="")
	{
		$str = "SELECT KET_REF_DATA AS ROWCOUNT FROM KBBR_GENERAL_REF_D
		        WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return ""; 
    }
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KBBR_GENERAL_REF_D_ID) AS ROWCOUNT FROM KBBR_GENERAL_REF_D
		        WHERE ID_REF_FILE IS NOT NULL ".$statement; 
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