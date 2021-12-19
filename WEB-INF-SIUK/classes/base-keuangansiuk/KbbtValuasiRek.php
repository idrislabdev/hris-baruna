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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBT_VALUASI_REK.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbtValuasiRek extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbtValuasiRek()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBT_VALUASI_REK_ID", $this->getNextId("KBBT_VALUASI_REK_ID","KBBT_VALUASI_REK")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBT_VALUASI_REK (
					   KD_BUKU_BESAR, NM_BUKU_BESAR, KELOMPOK, 
					   TIPE_REKENING) 
				VALUES ('".$this->getField("KD_BUKU_BESAR")."', '".$this->getField("NM_BUKU_BESAR")."', '".$this->getField("KELOMPOK")."',
						'".$this->getField("TIPE_REKENING")."'
						)";
				
		$this->id = $this->getField("KBBT_VALUASI_REK_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBT_VALUASI_REK
				SET    
						KD_BUKU_BESAR = '".$this->getField("KD_BUKU_BESAR")."',
						NM_BUKU_BESAR = '".$this->getField("NM_BUKU_BESAR")."',
						KELOMPOK      = '".$this->getField("KELOMPOK")."',
						TIPE_REKENING = '".$this->getField("TIPE_REKENING")."'
				WHERE  KBBT_VALUASI_REK_ID = '".$this->getField("KBBT_VALUASI_REK_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBT_VALUASI_REK
                WHERE 
                  KBBT_VALUASI_REK_ID = ".$this->getField("KBBT_VALUASI_REK_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_BUKU_BESAR, NM_BUKU_BESAR, KELOMPOK, 
				TIPE_REKENING
				FROM KBBT_VALUASI_REK
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KBBT_VALUASI_REK_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_BUKU_BESAR, NM_BUKU_BESAR, KELOMPOK, 
				TIPE_REKENING
				FROM KBBT_VALUASI_REK
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
		$str = "SELECT COUNT(KBBT_VALUASI_REK_ID) AS ROWCOUNT FROM KBBT_VALUASI_REK
		        WHERE KBBT_VALUASI_REK_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KBBT_VALUASI_REK_ID) AS ROWCOUNT FROM KBBT_VALUASI_REK
		        WHERE KBBT_VALUASI_REK_ID IS NOT NULL ".$statement; 
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