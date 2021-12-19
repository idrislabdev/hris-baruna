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

  class AktivaTetap extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AktivaTetap()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		// $this->setField("TUNJANGAN_JABATAN_ID", $this->getNextId("TUNJANGAN_JABATAN_ID","PPI_GAJI.TUNJANGAN_JABATAN")); 
		$str = "
				INSERT INTO PPI_ASSET.KALKULASI_PENYUSUTAN(
					   PERIODE, INVENTARIS_RUANGAN_ID, INVENTARIS_ID, 
					   JENIS_INVENTARIS_ID, LOKASI_ID, KODE, 
					   NOMOR, NAMA, LOKASI, 
					   TANGGAL_PEROLEHAN, UMUR_EKONOMIS, UMUR_EKONOMIS_REAL, 
					   NILAI_PEROLEHAN, NILAI_PENYUSUTAN, NILAI_AKHIR) 
				VALUES(
					  '".$this->getField("PERIODE")."',
					  '".$this->getField("INVENTARIS_RUANGAN_ID")."',
					  '".$this->getField("INVENTARIS_ID")."',
					  '".$this->getField("JENIS_INVENTARIS_ID")."',
					  '".$this->getField("LOKASI_ID")."',
					  '".$this->getField("KODE")."',
					  '".$this->getField("NOMOR")."',
					  '".$this->getField("NAMA")."',
					  '".$this->getField("LOKASI")."',
					  ".$this->getField("TANGGAL_PEROLEHAN").",
					  '".$this->getField("UMUR_EKONOMIS")."',
					  '".$this->getField("UMUR_EKONOMIS_REAL")."',
					  ".$this->getField("NILAI_PEROLEHAN").",
					  ".$this->getField("NILAI_PENYUSUTAN")."
					  ".$this->getField("NILAI_AKHIR")."

				)"; 
		// $this->id = $this->getField("PPI_GAJI.TUNJANGAN_JABATAN");
		//echo $str;exit;
		$this->query = $str;
		return $this->execQuery($str);
    }

	function import()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		// $this->setField("TUNJANGAN_JABATAN_ID", $this->getNextId("TUNJANGAN_JABATAN_ID","PPI_GAJI.TUNJANGAN_JABATAN")); 
		$str = "
				INSERT INTO PPI_ASSET.KALKULASI_PENYUSUTAN(
					   PERIODE, INVENTARIS_RUANGAN_ID, INVENTARIS_ID, 
					   JENIS_INVENTARIS_ID, LOKASI_ID, KODE, 
					   NOMOR, NAMA, LOKASI, 
					   TANGGAL_PEROLEHAN, UMUR_EKONOMIS, UMUR_EKONOMIS_REAL, 
					   NILAI_PEROLEHAN, NILAI_PENYUSUTAN, NILAI_AKHIR) 
				VALUES(
					  '".$this->getField("PERIODE")."',
					  '".$this->getField("INVENTARIS_RUANGAN_ID")."',
					  '".$this->getField("INVENTARIS_ID")."',
					  '".$this->getField("JENIS_INVENTARIS_ID")."',
					  '".$this->getField("LOKASI_ID")."',
					  '".$this->getField("KODE")."',
					  '".$this->getField("NOMOR")."',
					  '".$this->getField("NAMA")."',
					  '".$this->getField("LOKASI")."',
					  ".$this->getField("TANGGAL_PEROLEHAN").",
					  '".$this->getField("UMUR_EKONOMIS")."',
					  '".$this->getField("UMUR_EKONOMIS_REAL")."',
					  ".$this->getField("NILAI_PEROLEHAN").",
					  ".$this->getField("NILAI_PENYUSUTAN")."
					  ".$this->getField("NILAI_AKHIR")."
				)"; 
		// $this->id = $this->getField("PPI_GAJI.TUNJANGAN_JABATAN");
		//echo $str;exit;
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.INTEGRASI_POTONGAN
			   SET 
			   		PERIODE				= '".$this->getField("PERIODE")."',
			   		POTONGAN_KONDISI_ID	= '".$this->getField("POTONGAN_KONDISI_ID")."',
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
        $str = "DELETE FROM PPI_GAJI.INTEGRASI_POTONGAN
                WHERE 
                  PEGAWAI_ID = ".$this->getField("PEGAWAI_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deletePeriode()
	{
        $str = "DELETE FROM PPI_ASSET.KALKULASI_PENYUSUTAN
                WHERE 
                  PERIODE = ".$this->getField("PERIODE").""; 
				  
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
				SELECT PERIODE, INVENTARIS_RUANGAN_ID, INVENTARIS_ID, JENIS_INVENTARIS_ID, LOKASI_ID, KODE, 
				   NOMOR, NAMA, LOKASI, TANGGAL_PEROLEHAN, UMUR_EKONOMIS, UMUR_EKONOMIS_REAL, NILAI_PEROLEHAN, NILAI_PENYUSUTAN, NILAI_AKHIR
				FROM PPI_ASSET.KALKULASI_PENYUSUTAN
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
		$str = "SELECT COUNT(NOMOR) AS ROWCOUNT 
		FROM PPI_ASSET.KALKULASI_PENYUSUTAN
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