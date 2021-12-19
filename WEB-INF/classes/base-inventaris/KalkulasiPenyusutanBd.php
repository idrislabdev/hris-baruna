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

  class KalkulasiPenyusutanBd extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KalkulasiPenyusutanBd()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		// $this->setField("TUNJANGAN_JABATAN_ID", $this->getNextId("TUNJANGAN_JABATAN_ID","PPI_GAJI.TUNJANGAN_JABATAN")); 
		$str = "
				INSERT INTO PPI_ASSET.KALKULASI_PENYUSUTAN_BD(
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
				INSERT INTO PPI_ASSET.KALKULASI_PENYUSUTAN_BD(
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

	function kalkulasi()
	{
        $str = " CALL PPI_ASSET.SINKRONISASI_PENYUSUTAN_BD('".$this->getField("PERIODE")."') "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	
	function postingJurnal()
	{
        $str = "UPDATE PPI_ASSET.KALKULASI_PENYUSUTAN_JURNAL_BD
				SET POSTING = '1'
                WHERE 
                  PERIODE = '".$this->getField("PERIODE")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deletePeriode()
	{
        $str = "DELETE FROM PPI_ASSET.KALKULASI_PENYUSUTAN_BD
                WHERE 
                  PERIODE = '".$this->getField("PERIODE")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY KODE_HEADER, KODE, LOKASI_ID ASC ")
	{
		$str = "
				SELECT 
					PERIODE, INVENTARIS_RUANGAN_ID, INVENTARIS_ID, 
					   JENIS_INVENTARIS_ID, LOKASI_ID, JENIS_INVENTARIS, 
					   KODE_GL_DEBET, KODE_GL_KREDIT, KODE_HEADER, 
					   NAMA_HEADER, KODE, NOMOR, 
					   NAMA, SPESIFIKASI, LOKASI, 
					   TANGGAL_PEROLEHAN, UMUR_EKONOMIS, UMUR_EKONOMIS_REAL, 
					   NILAI_PEROLEHAN, NILAI_PENYUSUTAN, AKM_PENYUSUTAN, 
					   NILAI_AKHIR, KODE_GL_PUSAT
					FROM PPI_ASSET.KALKULASI_PENYUSUTAN_BD A
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
	
	
    function selectByParamsRekapKelompok($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY KODE_HEADER ASC ")
	{
		$str = "
					SELECT 
				PERIODE, KODE_HEADER || ' - ' || NAMA_HEADER HEADER, 
				   NILAI_PEROLEHAN, AKM_PENYUSUTAN_LALU, NILAI_PENYUSUTAN, 
				   AKM_PENYUSUTAN, NILAI_AKHIR
				FROM PPI_ASSET.REKAP_KELOMPOK A
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
	

	
	
    function selectByParamsRekapAktiva($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY KODE_HEADER, KODE, LOKASI_ID ASC ")
	{
		$str = "
					SELECT 
					PERIODE, INVENTARIS_RUANGAN_ID, KODE_HEADER || ' - ' || NAMA_HEADER HEADER, 
					   KODE_HEADER, 
					   NAMA_HEADER, KODE, LOKASI, 
					   NAMA, SPESIFIKASI, TANGGAL_PEROLEHAN, 
					   SISA_UMUR, NILAI_PEROLEHAN, AKM_PENYUSUTAN_LALU, 
					   NILAI_PENYUSUTAN, AKM_PENYUSUTAN, NILAI_AKHIR
					FROM PPI_ASSET.REKAP_AKTIVA A
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
	
	

    function selectByParamsJurnal($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order= "ORDER BY DEBET DESC ")
	{
		$str = "
			    SELECT 
				PERIODE, KD_BUKU_BESAR, NM_BUKU_BESAR, '00000' KD_SUB_BANTU,
				   NVL(KD_BUKU_PUSAT, '000.00.00') KD_BUKU_PUSAT, NM_BUKU_PUSAT, DEBET, 
				   KREDIT, POSTING
				FROM PPI_ASSET.KALKULASI_PENYUSUTAN_JURNAL_BD A
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsPeriode($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY TO_DATE(PERIODE, 'MMYYYY') ASC ")
	{
		$str = "
			    SELECT DISTINCT PERIODE FROM
				(
				SELECT DISTINCT PERIODE FROM PPI_ASSET.KALKULASI_PENYUSUTAN_BD A
				UNION ALL
				SELECT TO_CHAR(SYSDATE, 'MMYYYY') FROM DUAL
				UNION ALL
				SELECT TO_CHAR(NVL(MAX(TO_DATE(PERIODE, 'MMYYYY')), SYSDATE) + 32, 'MMYYYY') FROM PPI_ASSET.KALKULASI_PENYUSUTAN_BD A
				) A
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
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM PPI_ASSET.KALKULASI_PENYUSUTAN_BD
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
	
	
    function getCountByParamsRekapKelompok($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM PPI_ASSET.REKAP_KELOMPOK A
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
	
	
	
    function getCountByParamsRekapAktiva($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM PPI_ASSET.REKAP_AKTIVA A
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