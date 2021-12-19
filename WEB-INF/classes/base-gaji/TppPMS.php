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

  class TppPMS extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TppPMS()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TPP_PMS_ID", $this->getNextId("TPP_PMS_ID","PPI_GAJI.TPP_PMS")); 
		$str = "
				INSERT INTO PPI_GAJI.TPP_PMS (   
				TPP_PMS_ID, 
				KELAS, 
				TUNJANGAN_PRESTASI, 
				MIN_JAM_MENGAJAR, 
				TARIF_KELEBIHAN, 
				MAX_KELEBIHAN, 
				MAX_POTONGAN, 
				LAST_CREATE_USER, 
				LAST_CREATE_DATE,  
				JENIS_PEGAWAI_ID, 
				KELOMPOK_PEGAWAI, 
				KELOMPOK_PENDIDIK) 
				VALUES(
					  ".$this->getField("TPP_PMS_ID").",
					  ".$this->getField("KELAS").",
					  '".$this->getField("TUNJANGAN_PRESTASI")."',
					  '".$this->getField("MIN_JAM_MENGAJAR")."',
					  '".$this->getField("TARIF_KELEBIHAN")."',
					  '".$this->getField("MAX_KELEBIHAN")."',
					  '".$this->getField("MAX_POTONGAN")."',
					  '".$this->getField("LAST_CREATE_USER")."',
					  '".$this->getField("LAST_CREATE_DATE")."',
					  '".$this->getField("JENIS_PEGAWAI_ID")."',
					  '".$this->getField("KELOMPOK_PEGAWAI")."',
					  '".$this->getField("KELOMPOK_PENDIDIK")."'
				)"; 
		$this->id = $this->getField("PPI_GAJI.TPP_PMS_ID");
		$this->query = $str;
		// echo $str; exit();
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.TPP_PMS
			   SET 
			   		KELAS	= ".$this->getField("KELAS").",
				   	TUNJANGAN_PRESTASI	= '".$this->getField("TUNJANGAN_PRESTASI")."',
				   	MIN_JAM_MENGAJAR	= '".$this->getField("MIN_JAM_MENGAJAR")."',
					TARIF_KELEBIHAN = '".$this->getField("TARIF_KELEBIHAN")."',
					MAX_KELEBIHAN = '".$this->getField("MAX_KELEBIHAN")."',
					MAX_POTONGAN = '".$this->getField("MAX_POTONGAN")."',
					LAST_UPDATE_USER = '".$this->getField("LAST_UPDATE_USER")."',
					LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					KELOMPOK_PEGAWAI = '".$this->getField("KELOMPOK_PEGAWAI")."',
					KELOMPOK_PENDIDIK = '".$this->getField("KELOMPOK_PENDIDIK")."'
			 WHERE TPP_PMS_ID = ".$this->getField("TPP_PMS_ID")."
				"; 
				$this->query = $str;

					//JENIS_PEGAWAI_ID = ".$this->getField("JENIS_PEGAWAI_ID").",
				//echo $str;exit;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.TPP_PMS
                WHERE 
                  TPP_PMS_ID = ".$this->getField("TPP_PMS_ID").""; 
				  
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
				TPP_PMS_ID, KELAS, TUNJANGAN_PRESTASI, MIN_JAM_MENGAJAR,
				   TARIF_KELEBIHAN, MAX_KELEBIHAN, MAX_POTONGAN, 
				   LAST_CREATE_USER, LAST_CREATE_DATE, LAST_UPDATE_USER, 
				   LAST_UPDATE_DATE, KELOMPOK_PEGAWAI
				FROM PPI_GAJI.TPP_PMS A
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		// echo $str; exit();

		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				TPP_PMS_ID, KELAS, TUNJANGAN_PRESTASI, MIN_JAM_MENGAJAR,
				   TARIF_KELEBIHAN, MAX_KELEBIHAN, MAX_POTONGAN, 
				   LAST_CREATE_USER, LAST_CREATE_DATE, LAST_UPDATE_USER, 
				   LAST_UPDATE_DATE, A.KELOMPOK_PEGAWAI, B.NAMA NAMA_KELOMPOK_PEGAWAI
				FROM PPI_GAJI.TPP_PMS A
				LEFT JOIN PPI_SIMPEG.KELOMPOK_PEGAWAI B ON A.KELOMPOK_PEGAWAI = B.KELOMPOK_PEGAWAI
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
				TPP_PMS_ID, KELAS, TUNJANGAN_PRESTASI, 
				   TARIF_KELEBIHAN, MAX_KELEBIHAN, MAX_POTONGAN, 
				   LAST_CREATE_USER, LAST_CREATE_DATE, LAST_UPDATE_USER, 
				   LAST_UPDATE_DATE
				FROM PPI_GAJI.TPP_PMS A
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY TPP_PMS_ID DESC";
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
		$str = "SELECT COUNT(TPP_PMS_ID) AS ROWCOUNT 
		FROM PPI_GAJI.TPP_PMS WHERE 1 = 1 ".$statement; 
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

    function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(TPP_PMS_ID) AS ROWCOUNT 
				FROM PPI_GAJI.TPP_PMS 
				LEFT JOIN PPI_SIMPEG.KELOMPOK_PEGAWAI B ON A.KELOMPOK_PEGAWAI = B.KELOMPOK_PEGAWAI
				WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(TPP_PMS_ID) AS ROWCOUNT FROM PPI_GAJI.TPP_PMS WHERE 1 = 1 "; 
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