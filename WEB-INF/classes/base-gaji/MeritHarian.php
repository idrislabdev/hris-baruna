<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class MeritHarian extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function MeritHarian()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("MERIT_HARIAN_ID", $this->getNextId("MERIT_HARIAN_ID","PPI_GAJI.MERIT_HARIAN")); 
		$str = "
				INSERT INTO PPI_GAJI.MERIT_HARIAN (
				   MERIT_HARIAN_ID, JENIS_LOKASI, MINGGU, 
				   BULAN, NILAI, MAX, 
				   LAST_CREATE_USER, LAST_CREATE_DATE) 
				VALUES ( '".$this->getField("MERIT_HARIAN_ID")."', '".$this->getField("JENIS_LOKASI")."', '".$this->getField("MINGGU")."',
				    '".$this->getField("BULAN")."', '".$this->getField("NILAI")."', '".$this->getField("MAX")."',
				    '".$this->getField("LAST_CREATE_USER")."', ".$this->getField("LAST_CREATE_DATE").")
				"; 
		$this->id = $this->getField("PPI_GAJI.MERIT_HARIAN");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.MERIT_HARIAN
				SET    JENIS_LOKASI     = '".$this->getField("JENIS_LOKASI")."',
				       MINGGU           = '".$this->getField("MINGGU")."',
				       BULAN            = '".$this->getField("BULAN")."',
				       NILAI            = '".$this->getField("NILAI")."',
				       MAX              = '".$this->getField("MAX")."',
				       LAST_UPDATE_USER = '".$this->getField("LAST_UPDATE_USER")."',
				       LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  MERIT_HARIAN_ID  = '".$this->getField("MERIT_HARIAN_ID")."'

				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.MERIT_HARIAN
                WHERE 
                  MERIT_HARIAN_ID = ".$this->getField("MERIT_HARIAN_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
					MERIT_HARIAN_ID, JENIS_LOKASI, MINGGU, 
					   BULAN, NILAI, MAX, 
					   LAST_CREATE_USER, LAST_CREATE_DATE, LAST_UPDATE_USER, 
					   LAST_UPDATE_DATE
					FROM PPI_GAJI.MERIT_HARIAN A	
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
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT 
					MERIT_HARIAN_ID, JENIS_LOKASI, MINGGU, 
					   BULAN, NILAI, MAX, 
					   LAST_CREATE_USER, LAST_CREATE_DATE, LAST_UPDATE_USER, 
					   LAST_UPDATE_DATE
					FROM PPI_GAJI.MERIT_HARIAN A	
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY MERIT_HARIAN_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(MERIT_HARIAN_ID) AS ROWCOUNT 
				FROM PPI_GAJI.MERIT_HARIAN A 	 WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(MERIT_HARIAN_ID) AS ROWCOUNT FROM PPI_GAJI.MERIT_HARIAN WHERE 1 = 1 "; 
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