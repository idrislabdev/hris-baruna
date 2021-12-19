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
  * Entity-base class untuk mengimplementasikan tabel AGAMA.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class SinkronisasiPegawaiLock extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SinkronisasiPegawaiLock()
	{
      $this->Entity(); 
    }

	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("ABSENSI_ID", $this->getNextId("ABSENSI_ID","pds_absensi.ABSENSI")); 
		$str = "
				INSERT INTO PPI_GAJI.SINKRONISASI_PEGAWAI_LOCK(
			            PERIODE, LOCK_BY, LOCK_DATE)
			    VALUES (
					  '".$this->getField("PERIODE")."',
					  '".$this->getField("LOCK_BY")."',
					  ".$this->getField("LOCK_DATE")."
				)"; 
		//$this->id = $this->getField("ABSENSI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function delete()
	{
        $str = "
        		DELETE FROM PPI_GAJI.SINKRONISASI_PEGAWAI_LOCK
                WHERE 
                  PERIODE = '".$this->getField("PERIODE")."'
                  "; 
				  
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

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="order by PERIODE asc")
	{
		$str = "
				SELECT LOCK_BY, LOCK_DATE, PERIODE
  					FROM PPI_GAJI.SINKRONISASI_PEGAWAI_LOCK
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

    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
				FROM PPI_GAJI.SINKRONISASI_PEGAWAI_LOCK A
				WHERE 1 = 1
			 ".$statement; 
		
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