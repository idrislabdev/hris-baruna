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

  class IntegrasiKenaikan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function IntegrasiKenaikan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		// $this->setField("TUNJANGAN_JABATAN_ID", $this->getNextId("TUNJANGAN_JABATAN_ID","PPI_GAJI.TUNJANGAN_JABATAN")); 
		$str = "
				INSERT INTO PPI_SIMPEG.INTEGRASI_KENAIKAN(
					    NIS, 
					    DEPARTEMEN_ID, 
					    DEPARTEMEN_KELAS_ID, 
					    TAHUN) 
				VALUES(
					  '".$this->getField("NIS")."',
					  '".$this->getField("DEPARTEMEN_ID")."',
					  '".$this->getField("DEPARTEMEN_KELAS_ID")."',
					  ".$this->getField("JUMLAH")."
				)"; 
		// $this->id = $this->getField("PPI_GAJI.TUNJANGAN_JABATAN");
		//echo $str;exit;
		$this->query = $str;
		return $this->execQuery($str);
    }

	function import()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		// $this->setField("GAJI_KONDISI_PEGAWAI_ID", $this->getNextId("GAJI_KONDISI_PEGAWAI_ID","PPI_GAJI.GAJI_KONDISI_PEGAWAI")); 
		$str = "
				INSERT INTO PPI_SIMPEG.INTEGRASI_KENAIKAN(
					    NIS, 
					    DEPARTEMEN_ID, 
					    DEPARTEMEN_KELAS_ID, 
					    TAHUN) 
				VALUES(
					  '".$this->getField("NIS")."',
					  '".$this->getField("DEPARTEMEN_ID")."',
					  '".$this->getField("DEPARTEMEN_KELAS_ID")."',
					  ".$this->getField("TAHUN")."
				)";  
		// $this->id = $this->getField("PPI_GAJI.GAJI_KONDISI_PEGAWAI_ID");
		// echo $str;exit;
		$this->query = $str;
		// echo $str;exit();
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_SIMPEG.INTEGRASI_KENAIKAN
			   SET 
			   		DEPARTEMEN_ID		= '".$this->getField("DEPARTEMEN_ID")."',
			   		DEPARTEMEN_KELAS_ID	= '".$this->getField("DEPARTEMEN_KELAS_ID")."',
				   	TAHUN				= ".$this->getField("TAHUN")."
			 WHERE NIS = '".$this->getField("NIS")."''
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.INTEGRASI_KENAIKAN
                WHERE 
                  NIS = ".$this->getField("NIS").""; 
				  
		// echo $str->query;exit();		  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deletePeriode()
	{
        $str = "DELETE FROM PPI_SIMPEG.INTEGRASI_KENAIKAN
                WHERE 
                  NVL(TAHUN, '0') = '".$this->getField("TAHUN")."' AND NIS = '".$this->getField("NIS")."' AND PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."'"; 
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
				 SELECT A.NIS, A.DEPARTEMEN_ID, A.DEPARTEMEN_KELAS_ID, 
                   A.TAHUN, C.NAMA SISWA, B.NAMA KELAS, B.KETERANGAN
                FROM PPI_SIMPEG.INTEGRASI_KENAIKAN A
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN_KELAS B ON A.DEPARTEMEN_KELAS_ID = B.DEPARTEMEN_KELAS_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI C ON A.NIS = C.NIS
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN D ON A.DEPARTEMEN_ID = D.DEPARTEMEN_ID
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

 //    function selectByParamsImport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY DEPARTEMEN_ID")
	// {
	// 	$str = "
	// 		    SELECT A.PEGAWAI_ID, A.NAMA, C.NAMA NAMA_JABATAN FROM PPI_SIMPEG.PEGAWAI A
	// 			LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
	// 			LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
	// 			LEFT JOIN PPI_SIMPEG.DEPARTEMEN D ON C.DEPARTEMEN_ID = D.DEPARTEMEN_ID
	// 			WHERE JENIS_PEGAWAI_ID <> '8'
	// 		"; 
		
	// 	while(list($key,$val) = each($paramsArray))
	// 	{
	// 		$str .= " AND $key = '$val' ";
	// 	}
		
	// 	$str .= $statement."ORDER BY PEGAWAI_ID";
	// 	$this->query = $str;
	// 	return $this->selectLimit($str,$limit,$from); 
 //    }
 //    function selectByParamsKondisi($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY DEPARTEMEN_ID")
	// {
	// 	$str = "
	// 		    SELECT POTONGAN_KONDISI_ID, NAMA FROM PPI_GAJI.POTONGAN_KONDISI

	// 		"; 
		
	// 	while(list($key,$val) = each($paramsArray))
	// 	{
	// 		$str .= " AND $key = '$val' ";
	// 	}
		
	// 	$str .= $statement." ".$order;
	// 	$this->query = $str;
	// 	return $this->selectLimit($str,$limit,$from); 
 //    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT A.NIS, A.DEPARTEMEN_ID, A.DEPARTEMEN_KELAS_ID, 
                   A.TAHUN, C.NAMA SISWA, B.NAMA KELAS, B.KETERANGAN
                FROM PPI_SIMPEG.INTEGRASI_KENAIKAN A
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN_KELAS B ON A.DEPARTEMEN_KELAS_ID = B.DEPARTEMEN_KELAS_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI C ON A.NIS = C.NIS
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN D ON A.DEPARTEMEN_ID = D.DEPARTEMEN_ID     
                WHERE 1=1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY NIS DESC";
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
		$str = "SELECT COUNT(A.NIS) AS ROWCOUNT 
		FROM PPI_SIMPEG.INTEGRASI_KENAIKAN A
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN_KELAS B ON A.DEPARTEMEN_KELAS_ID = B.DEPARTEMEN_KELAS_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI C ON A.NIS = C.NIS
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN D ON A.DEPARTEMEN_ID = D.DEPARTEMEN_ID   
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
		$str = "SELECT COUNT(PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.INTEGRASI_KENAIKAN A
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN_KELAS B ON A.DEPARTEMEN_KELAS_ID = B.DEPARTEMEN_KELAS_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI C ON A.NIS = C.NIS
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN D ON A.DEPARTEMEN_ID = D.DEPARTEMEN_ID    
		WHERE 1 = 1 "; 
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