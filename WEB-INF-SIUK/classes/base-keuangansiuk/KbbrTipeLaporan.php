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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_TIPE_LAPORAN.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrTipeLaporan extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrTipeLaporan()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBR_TIPE_LAPORAN_ID", $this->getNextId("KBBR_TIPE_LAPORAN_ID","KBBR_TIPE_LAPORAN")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_TIPE_LAPORAN (
					   KD_CABANG, KD_LAPORAN, NM_LAPORAN, 
					   KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
					   PROGRAM_NAME) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("KD_LAPORAN")."', '".$this->getField("NM_LAPORAN")."',
						'".$this->getField("KD_AKTIF")."', ".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."',
						'".$this->getField("PROGRAM_NAME")."'
				)";
				
		$this->id = $this->getField("KBBR_TIPE_LAPORAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_TIPE_LAPORAN
				SET    
					   KD_CABANG        = '".$this->getField("KD_CABANG")."',
					   KD_LAPORAN       = '".$this->getField("KD_LAPORAN")."',
					   NM_LAPORAN       = '".$this->getField("NM_LAPORAN")."',
					   KD_AKTIF         = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."'
				WHERE  KBBR_TIPE_LAPORAN_ID = '".$this->getField("KBBR_TIPE_LAPORAN_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_TIPE_LAPORAN
                WHERE 
                  KBBR_TIPE_LAPORAN_ID = ".$this->getField("KBBR_TIPE_LAPORAN_ID").""; 
				  
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
				SELECT KD_CABANG, KD_LAPORAN, NM_LAPORAN, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME
				FROM KBBR_TIPE_LAPORAN
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KBBR_TIPE_LAPORAN_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, KD_LAPORAN, NM_LAPORAN, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME
				FROM KBBR_TIPE_LAPORAN
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
		$str = "SELECT COUNT(KBBR_TIPE_LAPORAN_ID) AS ROWCOUNT FROM KBBR_TIPE_LAPORAN
		        WHERE KBBR_TIPE_LAPORAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KBBR_TIPE_LAPORAN_ID) AS ROWCOUNT FROM KBBR_TIPE_LAPORAN
		        WHERE KBBR_TIPE_LAPORAN_ID IS NOT NULL ".$statement; 
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