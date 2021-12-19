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

  class GajiKondisiPegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function GajiKondisiPegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		// $this->setField("TUNJANGAN_JABATAN_ID", $this->getNextId("TUNJANGAN_JABATAN_ID","PPI_GAJI.TUNJANGAN_JABATAN")); 
		$str = "
				INSERT INTO PPI_GAJI.GAJI_KONDISI_PEGAWAI(
					   GAJI_KONDISI_PEGAWAI_ID,PEGAWAI_ID, PERIODE, GAJI_KONDISI_ID,GAJI_PREFIX, JUMLAH,
					   LAST_CREATE_USER, LAST_CREATE_DATE) 
				VALUES(
					  '".$this->getField("PEGAWAI_ID")."',
					  '".$this->getField("GAJI_KONDISI_PEGAWAI_ID")."',
					  '".$this->getField("PERIODE")."',
					  '".$this->getField("GAJI_KONDISI_ID")."',
					  '".$this->getField("GAJI_PREFIX")."',
					  ".$this->getField("JUMLAH").",
					  '".$this->getField("LAST_CREATE_USER")."',
					  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		// $this->id = $this->getField("PPI_GAJI.TUNJANGAN_JABATAN");
		//echo $str;exit;
		$this->query = $str;
		return $this->execQuery($str);
    }

	function import()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("GAJI_KONDISI_PEGAWAI_ID", $this->getNextId("GAJI_KONDISI_PEGAWAI_ID","PPI_GAJI.GAJI_KONDISI_PEGAWAI")); 
		$str = "
				INSERT INTO PPI_GAJI.GAJI_KONDISI_PEGAWAI(
					  GAJI_KONDISI_PEGAWAI_ID,PEGAWAI_ID, PERIODE, GAJI_KONDISI_ID, GAJI_PREFIX, JUMLAH,
					   LAST_CREATE_USER, LAST_CREATE_DATE) 
				VALUES(
					  '".$this->getField("GAJI_KONDISI_PEGAWAI_ID")."',
					  '".$this->getField("PEGAWAI_ID")."',
					  '".$this->getField("PERIODE")."',
					  '".$this->getField("GAJI_KONDISI_ID")."',
					  '".$this->getField("GAJI_PREFIX")."',
					  ".$this->getField("JUMLAH").",
					  '".$this->getField("LAST_CREATE_USER")."',
					  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("PPI_GAJI.GAJI_KONDISI_PEGAWAI_ID");
		// echo $str;exit;
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.GAJI_KONDISI_PEGAWAI
			   SET 
			   		GAJI_KONDISI_PEGAWAI_ID				= '".$this->getField("GAJI_KONDISI_PEGAWAI_ID")."',
			   		PERIODE				= '".$this->getField("PERIODE")."',
			   		GAJI_KONDISI_ID	= '".$this->getField("GAJI_KONDISI_ID")."',
			   		GAJI_PREFIX	= '".$this->getField("GAJI_PREFIX")."',
				   	JUMLAH	= ".$this->getField("JUMLAH").",
				   	LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
				   	LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE").",
			 WHERE PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.GAJI_KONDISI_PEGAWAI
                WHERE 
                  GAJI_KONDISI_PEGAWAI_ID = ".$this->getField("GAJI_KONDISI_PEGAWAI_ID").""; 
				  
		// echo $str->query;exit();		  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deletePeriode()
	{
        $str = "DELETE FROM PPI_GAJI.GAJI_KONDISI_PEGAWAI
                WHERE 
                  NVL(PERIODE, '0') = '".$this->getField("PERIODE")."' AND GAJI_KONDISI_ID = '".$this->getField("GAJI_KONDISI_ID")."' AND PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."'"; 
        // echo $str;
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
                SELECT A.GAJI_KONDISI_PEGAWAI_ID,A.PEGAWAI_ID, A.PERIODE, A.GAJI_KONDISI_ID,A.GAJI_PREFIX, A.JUMLAH, B.NAMA NAMA_PEGAWAI, C.NAMA NAMA_GAJI_KONDISI 
                FROM PPI_GAJI.GAJI_KONDISI_PEGAWAI A 
				LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID=B.PEGAWAI_ID 
                LEFT JOIN PPI_GAJI.GAJI_KONDISI C ON A.GAJI_KONDISI_ID=C.GAJI_KONDISI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR D ON B.PEGAWAI_ID = D.PEGAWAI_ID
				WHERE 1=1   
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str; exit();
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsImport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY DEPARTEMEN_ID")
	{
		$str = "
			    SELECT A.PEGAWAI_ID, A.NAMA, C.NAMA NAMA_JABATAN FROM PPI_SIMPEG.PEGAWAI A
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.DEPARTEMEN D ON C.DEPARTEMEN_ID = D.DEPARTEMEN_ID
				WHERE JENIS_PEGAWAI_ID <> '8'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."ORDER BY PEGAWAI_ID";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    function selectByParamsKondisi($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY DEPARTEMEN_ID")
	{
		$str = "
			    SELECT POTONGAN_KONDISI_ID, NAMA FROM PPI_GAJI.POTONGAN_KONDISI

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
			     SELECT A.PEGAWAI_ID, A.PERIODE, A.JUMLAH_JAM_MENGAJAR, A.JUMLAH_JAM_LEBIH, A.TARIF_MENGAJAR, A.TARIF_LEBIH, A.TOTAL_TUNJANGAN,  A.LAST_CREATE_USER, A.LAST_CREATE_DATE, A.LAST_UPDATE_USER, A.LAST_UPDATE_DATE
                	FROM PPI_GAJI.INTEGRASI_TUNJANGAN_PRESTASI A         
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
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT 
		FROM PPI_GAJI.GAJI_KONDISI_PEGAWAI A
		LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID=B.PEGAWAI_ID 
        LEFT JOIN PPI_GAJI.GAJI_KONDISI C ON A.GAJI_KONDISI_ID=C.GAJI_KONDISI_ID
		LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR D ON B.PEGAWAI_ID = D.PEGAWAI_ID
		WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		// echo $str; exit();
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.INTEGRASI_TUNJANGAN_PRESTASI WHERE 1 = 1 "; 
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