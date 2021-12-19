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
  * EntitySIUK-base class untuk mengimplementasikan tabel SAFR_VALUTA.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class SafrValuta extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SafrValuta()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SAFR_VALUTA_ID", $this->getNextId("SAFR_VALUTA_ID","SAFR_VALUTA")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO SAFR_VALUTA (
					   KD_CABANG, JENIS_TABLE, ID_TABLE, 
					   KODE_VALUTA, LABEL_VALUTA, NAMA_VALUTA, 
					   KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
					   PROGRAM_NAME) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("JENIS_TABLE")."', '".$this->getField("ID_TABLE")."',
						'".$this->getField("KODE_VALUTA")."', '".$this->getField("LABEL_VALUTA")."', '".$this->getField("NAMA_VALUTA")."',
						'".$this->getField("KD_AKTIF")."', ".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."',
						'".$this->getField("PROGRAM_NAME")."'
						)";
				
		$this->id = $this->getField("SAFR_VALUTA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE SAFR_VALUTA
				SET    
					   KD_CABANG        = '".$this->getField("KD_CABANG")."',
					   JENIS_TABLE      = '".$this->getField("JENIS_TABLE")."',
					   ID_TABLE         = '".$this->getField("ID_TABLE")."',
					   KODE_VALUTA      = '".$this->getField("KODE_VALUTA")."',
					   LABEL_VALUTA     = '".$this->getField("LABEL_VALUTA")."',
					   NAMA_VALUTA      = '".$this->getField("NAMA_VALUTA")."',
					   KD_AKTIF         = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."'
				WHERE  SAFR_VALUTA_ID = '".$this->getField("SAFR_VALUTA_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM SAFR_VALUTA
                WHERE 
                  SAFR_VALUTA_ID = ".$this->getField("SAFR_VALUTA_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="",$sOrder="ORDER BY KODE_VALUTA ASC")
	{
		$str = "
				SELECT KD_CABANG, JENIS_TABLE, ID_TABLE, 
				KODE_VALUTA, LABEL_VALUTA, NAMA_VALUTA, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME
				FROM SAFR_VALUTA
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, JENIS_TABLE, ID_TABLE, 
				KODE_VALUTA, LABEL_VALUTA, NAMA_VALUTA, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME
				FROM SAFR_VALUTA
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NO_JUDUL ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SAFR_VALUTA_ID) AS ROWCOUNT FROM SAFR_VALUTA
		        WHERE SAFR_VALUTA_ID IS NOT NULL ".$statement; 
		
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

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SAFR_VALUTA_ID) AS ROWCOUNT FROM SAFR_VALUTA
		        WHERE SAFR_VALUTA_ID IS NOT NULL ".$statement; 
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