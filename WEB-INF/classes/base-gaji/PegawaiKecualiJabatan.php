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

  class PegawaiKecualiJabatan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiKecualiJabatan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_KECUALI_JABATAN_ID", $this->getNextId("PEGAWAI_KECUALI_JABATAN_ID","PPI_GAJI.PEGAWAI_KECUALI_JABATAN")); 
		$str = "
				INSERT INTO PPI_GAJI.PEGAWAI_KECUALI_JABATAN (
				   PEGAWAI_KECUALI_JABATAN_ID, PEGAWAI_ID) 
				VALUES ( '".$this->getField("PEGAWAI_KECUALI_JABATAN_ID")."', '".$this->getField("PEGAWAI_ID")."')"; 

		$this->id = $this->getField("PEGAWAI_KECUALI_JABATAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.PEGAWAI_KECUALI_JABATAN
			   SET 		   		
					  PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."'
			   WHERE PEGAWAI_KECUALI_JABATAN_ID = '".$this->getField("PEGAWAI_KECUALI_JABATAN_ID")."'
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function delete()
	{
        $str = "
				DELETE FROM PPI_GAJI.PEGAWAI_KECUALI_JABATAN
                WHERE 
                  PEGAWAI_KECUALI_JABATAN_ID = '".$this->getField("PEGAWAI_KECUALI_JABATAN_ID")."'
			"; 
				  
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

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY PEGAWAI_ID")
	{
		$str = "
				SELECT PEGAWAI_KECUALI_JABATAN_ID, PEGAWAI_ID FROM
				PPI_GAJI.PEGAWAI_KECUALI_JABATAN A 
				WHERE 1=1
			   "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY PEGAWAI_ID")
	{
		$str = "
				SELECT PEGAWAI_KECUALI_JABATAN_ID, A.PEGAWAI_ID, B.NAMA PEGAWAI_NAMA, C.NAMA DEPARTEMEN_NAMA 
				FROM PPI_GAJI.PEGAWAI_KECUALI_JABATAN A 
				LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.DEPARTEMEN C ON B.DEPARTEMEN_ID = C.DEPARTEMEN_ID
				WHERE 1=1
			   "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT PEGAWAI_KECUALI_JABATAN_ID, PEGAWAI_ID FROM
				PPI_GAJI.PEGAWAI_KECUALI_JABATAN A 
				WHERE 1=1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY PEGAWAI_ID DESC";
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
		$str = "
				SELECT COUNT(1) AS ROWCOUNT
                PPI_GAJI.PEGAWAI_KECUALI_JABATAN A
                WHERE 1=1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
    function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "
				SELECT COUNT(1) AS ROWCOUNT 
				FROM PPI_GAJI.PEGAWAI_KECUALI_JABATAN A 
				LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.DEPARTEMEN C ON B.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                WHERE 1=1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}

		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM PPI_GAJI.PEGAWAI_KECUALI_JABATAN A WHERE 1 = 1 "; 
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