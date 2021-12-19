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

  class TunjanganMengajar extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TunjanganJabatan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TUNJANGAN_JABATAN_ID", $this->getNextId("TUNJANGAN_JABATAN_ID","PPI_GAJI.TUNJANGAN_JABATAN")); 
		$str = "
				INSERT INTO PPI_GAJI.TUNJANGAN_MENGAJAR (PEGAWAI_ID, KELOMPOK_PEGAWAI, KELOMPOK_PENDIDIK,PERIODE,JUMLAH_JAM_INTRA, JUMLAH_JAM_ESKUL, JUMLAH_JAM_LEBIH) 
				VALUES(
					  '".$this->getField("PEGAWAI_ID")."',
					  '".$this->getField("KELOMPOK_PEGAWAI")."',
					  '".$this->getField("KELOMPOK_PENDIDIK")."',
					  '".$this->getField("PERIODE")."',
					  '".$this->getField("JUMLAH_JAM_INTRA")."',
					  '".$this->getField("JUMLAH_JAM_ESKUL")."',
					  '".$this->getField("JUMLAH_JAM_LEBIH")."'
				)"; 
		$this->id = $this->getField("PPI_GAJI.TUNJANGAN_JABATAN");
				//echo $str;exit;
		//exit;
		$this->query = $str;
		echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.TUNJANGAN_MENGAJAR
			   SET 
			   		KELOMPOK_PEGAWAI	= '".$this->getField("KELOMPOK_PEGAWAI")."',
			   		KELOMPOK_PENDIDIK	= '".$this->getField("KELOMPOK_PENDIDIK")."',
			   		PERIODE				= '".$this->getField("PERIODE")."',
				   	JUMLAH_JAM_INTRA	= ".$this->getField("JUMLAH_JAM_INTRA").",
				   	JUMLAH_JAM_ESKUL	= ".$this->getField("JUMLAH_JAM_ESKUL").",
				   	JUMLAH_JAM_LEBIH	= ".$this->getField("JUMLAH_JAM_LEBIH").",
			 WHERE PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.TUNJANGAN_MENGAJAR
                WHERE 
                  PEGAWAI_ID = ".$this->getField("PEGAWAI_ID").""; 
				  
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
			    SELECT PEGAWAI_ID, KELOMPOK_PEGAWAI, KELOMPOK_PENDIDIK, PERIODE, JUMLAH_JAM_INTRA, JUMLAH_JAM_ESKUL, JUMLAH_JAM_LEBIH
                	FROM PPI_GAJI.TUNJANGAN_MENGAJAR A         
                WHERE 1=1
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
			    SELECT A.PEGAWAI_ID, A.KELOMPOK_PEGAWAI, A.KELOMPOK_PENDIDIK, A.PERIODE, A.JUMLAH_JAM_INTRA, A.JUMLAH_JAM_EKSTRA, A.JUMLAH_JAM_LEBIH
                	FROM PPI_GAJI.TUNJANGAN_MENGAJAR A         
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
		$str = "SELECT COUNT(PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.TUNJANGAN_MENGAJAR WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.TUNJANGAN_MENGAJAR WHERE 1 = 1 "; 
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