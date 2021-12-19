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

  class KalkulasiPenyusutan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KalkulasiPenyusutan()
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

	function kalkulasi()
	{
        $str = " CALL PPI_ASSET.SINKRONISASI_PENYUSUTAN('".$this->getField("PERIODE")."') "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	
	function postingJurnal()
	{
        $str = "UPDATE PPI_ASSET.KALKULASI_PENYUSUTAN_JURNAL
				SET POSTING = '1'
                WHERE 
                  PERIODE = '".$this->getField("PERIODE")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deletePeriode()
	{
        $str = "DELETE FROM PPI_ASSET.KALKULASI_PENYUSUTAN
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
					   NILAI_PEROLEHAN, ROUND(NILAI_PENYUSUTAN) NILAI_PENYUSUTAN,  ROUND(AKM_PENYUSUTAN) AKM_PENYUSUTAN, 
					   NILAI_AKHIR, KODE_GL_PUSAT
					FROM PPI_ASSET.KALKULASI_PENYUSUTAN A
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
	

	
    function selectByParamsRekapKelompokTahun($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY KODE_HEADER ASC ")
	{
		$str = "
					SELECT 
				PERIODE, KODE_HEADER, NAMA_HEADER, KODE_HEADER || ' - ' || NAMA_HEADER HEADER,
				   NILAI_LALU, NILAI_PENAMBAHAN, NILAI_PENGURANGAN, 
				   NILAI_KINI, AKM_LALU, AKM_PENAMBAHAN, 
				   AKM_PENGURANGAN, AKM_PENYUSUTAN, NILAI_AKHIR
				FROM PPI_ASSET.REKAP_KELOMPOK_TAHUN A
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
	

	
    function selectByParamsRekapKelompokFlexy($reqPeriode, $reqPeriodeLalu, $paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY KODE_HEADER ASC ")
	{

		$reqTahun = substr($reqPeriodeLalu, 2,4);
		if($reqTahun > 2019)
			$tabel = "_LALU";
		$str = "
					SELECT 
				PERIODE, KODE_HEADER, NAMA_HEADER, KODE_HEADER || ' - ' || NAMA_HEADER HEADER,
				   NILAI_LALU, NILAI_PENAMBAHAN, NILAI_PENGURANGAN, 
				   NILAI_KINI, AKM_LALU, AKM_PENAMBAHAN, 
				   AKM_PENGURANGAN, AKM_PENYUSUTAN, NILAI_AKHIR
				FROM (
					SELECT A.PERIODE, 
					   A.KODE_HEADER, A.NAMA_HEADER, 
					   B.NILAI_PEROLEHAN NILAI_LALU, 
					   (A.NILAI_PEROLEHAN - B.NILAI_PEROLEHAN) NILAI_PENAMBAHAN, 0 NILAI_PENGURANGAN, A.NILAI_PEROLEHAN NILAI_KINI, 
					   B.AKM_PENYUSUTAN AKM_LALU, 
					   (A.AKM_PENYUSUTAN - B.AKM_PENYUSUTAN) AKM_PENAMBAHAN, 0 AKM_PENGURANGAN, A.AKM_PENYUSUTAN, 
					   A.NILAI_AKHIR FROM PPI_ASSET.REKAP_KELOMPOK A
					LEFT JOIN PPI_ASSET.REKAP_KELOMPOK$tabel B ON B.PERIODE = '".$reqPeriodeLalu."' AND A.KODE_HEADER = B.KODE_HEADER
					WHERE A.PERIODE = '".$reqPeriode."'
				) A
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
	
	
    function selectByParamsRekapKelompokPeriode($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY KODE_HEADER ASC ")
	{
		$str = "
					SELECT 
				PERIODE, KODE_HEADER, NAMA_HEADER, KODE_HEADER || ' - ' || NAMA_HEADER HEADER,
				   NILAI_LALU, NILAI_PENAMBAHAN, NILAI_PENGURANGAN, 
				   NILAI_KINI, AKM_LALU, AKM_PENAMBAHAN, 
				   AKM_PENGURANGAN, AKM_PENYUSUTAN, NILAI_AKHIR
				FROM PPI_ASSET.REKAP_KELOMPOK_PERIODE A
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
					   SISA_UMUR, NILAI_PEROLEHAN, ROUND(AKM_PENYUSUTAN_LALU) AKM_PENYUSUTAN_LALU, 
					   ROUND(NILAI_PENYUSUTAN) NILAI_PENYUSUTAN, ROUND(AKM_PENYUSUTAN) AKM_PENYUSUTAN, ROUND(NILAI_AKHIR) NILAI_AKHIR
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
	
	
    function selectByParamsRekapAktivaV2($reqPeriode, $reqPeriodeLalu, $paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY KODE_HEADER, NAMA_HEADER, KODE, LOKASI_ID ASC ")
	{
		$str = "
					SELECT 
					PERIODE, INVENTARIS_RUANGAN_ID, KODE_HEADER || ' - ' || NAMA_HEADER HEADER, 
					   KODE_HEADER, 
					   NAMA_HEADER, KODE, LOKASI, 
					   NAMA, SPESIFIKASI, TANGGAL_PEROLEHAN, 
					   SISA_UMUR, NILAI_PEROLEHAN, COALESCE(ROUND(AKM_PENYUSUTAN_LALU), 0) AKM_PENYUSUTAN_LALU, 
						ROUND(AKM_PENYUSUTAN) - COALESCE(ROUND(AKM_PENYUSUTAN_LALU), 0) NILAI_PENYUSUTAN,
					ROUND(AKM_PENYUSUTAN) AKM_PENYUSUTAN, ROUND(NILAI_AKHIR) NILAI_AKHIR
					FROM 
					(SELECT PERIODE, INVENTARIS_RUANGAN_ID, LOKASI_ID,
					KODE_HEADER, NAMA_HEADER,
					KODE, LOKASI, NAMA, SPESIFIKASI, TANGGAL_PEROLEHAN, CASE WHEN UMUR_EKONOMIS_REAL > UMUR_EKONOMIS OR UMUR_EKONOMIS_REAL = 0 THEN 0 ELSE UMUR_EKONOMIS - UMUR_EKONOMIS_REAL END SISA_UMUR,
					NILAI_PEROLEHAN, 
					(SELECT AKM_PENYUSUTAN FROM PPI_ASSET.REKAP_AKTIVA_LALU X WHERE X.PERIODE = '".$reqPeriodeLalu."' AND X.INVENTARIS_RUANGAN_ID = A.INVENTARIS_RUANGAN_ID) AKM_PENYUSUTAN_LALU,
					NILAI_PENYUSUTAN, AKM_PENYUSUTAN, NILAI_AKHIR FROM PPI_ASSET.KALKULASI_PENYUSUTAN A
					WHERE PERIODE = '".$reqPeriode."'
					) A
				WHERE 1=1   
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		 //echo $str; exit();
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
				FROM PPI_ASSET.KALKULASI_PENYUSUTAN_JURNAL A
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
	
	

    function selectByParamsJurnalV2($reqPeriodeLalu, $reqPeriode, $paramsArray=array(),$limit=-1,$from=-1)
	{
		$str = "
				SELECT KD_BUKU_BESAR, NM_BUKU_BESAR, KD_SUB_BANTU, KD_BUKU_PUSAT, NM_BUKU_PUSAT, DEBET, KREDIT FROM
				(
			   SELECT KD_BUKU_BESAR, NM_BUKU_BESAR, KD_SUB_BANTU, KD_BUKU_PUSAT, NM_BUKU_PUSAT, DEBET, KREDIT FROM (
				SELECT KD_BUKU_BESAR, NM_BUKU_BESAR, '00000' KD_SUB_BANTU,
								   NVL(KD_BUKU_PUSAT, '000.00.00') KD_BUKU_PUSAT, NM_BUKU_PUSAT,
					   SUM(
						 ROUND (AKM_PENYUSUTAN)
					   - COALESCE (ROUND (AKM_PENYUSUTAN_LALU), 0)) DEBET, 0 KREDIT
				  FROM (SELECT PERIODE, INVENTARIS_RUANGAN_ID, LOKASI_ID, KODE_HEADER,
							   NAMA_HEADER, KODE, LOKASI, NAMA, SPESIFIKASI,
							   TANGGAL_PEROLEHAN, B.KD_BUKU_BESAR, B.NM_BUKU_BESAR,
							   C.KD_BUKU_BESAR KD_BUKU_PUSAT, C.NM_BUKU_BESAR NM_BUKU_PUSAT,
							   CASE
								  WHEN UMUR_EKONOMIS_REAL > UMUR_EKONOMIS
								   OR UMUR_EKONOMIS_REAL = 0
									 THEN 0
								  ELSE UMUR_EKONOMIS - UMUR_EKONOMIS_REAL
							   END SISA_UMUR,
							   NILAI_PEROLEHAN,
							   (SELECT AKM_PENYUSUTAN
								  FROM PPI_ASSET.REKAP_AKTIVA_LALU X
								 WHERE X.PERIODE = '".$reqPeriodeLalu."'
								   AND X.INVENTARIS_RUANGAN_ID = A.INVENTARIS_RUANGAN_ID)
																		  AKM_PENYUSUTAN_LALU,
							   NILAI_PENYUSUTAN, AKM_PENYUSUTAN, NILAI_AKHIR
						  FROM PPI_ASSET.KALKULASI_PENYUSUTAN A
					LEFT JOIN PPI_SIUK.KBBR_BUKU_BESAR B ON TRIM(A.KODE_GL_DEBET) = B.KD_BUKU_BESAR
					LEFT JOIN PPI_SIUK.KBBR_BUKU_PUSAT C ON A.KODE_GL_PUSAT = C.KD_BUKU_BESAR
						 WHERE PERIODE = '".$reqPeriode."') A
				 WHERE 1 = 1
				   AND (UPPER (NAMA) LIKE '%%' OR UPPER (KODE) LIKE '%%')
				   AND PERIODE = '".$reqPeriode."'
				   GROUP BY KD_BUKU_BESAR, NM_BUKU_BESAR, '00000',
								   NVL(A.KD_BUKU_PUSAT, '000.00.00'), NM_BUKU_PUSAT
				   ORDER BY A.KD_BUKU_BESAR, NVL(A.KD_BUKU_PUSAT, '000.00.00')
				) WHERE DEBET > 0
				UNION ALL
				SELECT * FROM (
				SELECT KD_BUKU_BESAR, NM_BUKU_BESAR, '00000' KD_SUB_BANTU,
								   NVL(KD_BUKU_PUSAT, '000.00.00') KD_BUKU_PUSAT, NM_BUKU_PUSAT,
					   0 DEBET, SUM(
						 ROUND (AKM_PENYUSUTAN)
					   - COALESCE (ROUND (AKM_PENYUSUTAN_LALU), 0))  KREDIT
				  FROM (SELECT PERIODE, INVENTARIS_RUANGAN_ID, LOKASI_ID, KODE_HEADER,
							   NAMA_HEADER, KODE, LOKASI, NAMA, SPESIFIKASI,
							   TANGGAL_PEROLEHAN, B.KD_BUKU_BESAR, B.NM_BUKU_BESAR,
							   '000.00.00' KD_BUKU_PUSAT, NULL NM_BUKU_PUSAT,
							   CASE
								  WHEN UMUR_EKONOMIS_REAL > UMUR_EKONOMIS
								   OR UMUR_EKONOMIS_REAL = 0
									 THEN 0
								  ELSE UMUR_EKONOMIS - UMUR_EKONOMIS_REAL
							   END SISA_UMUR,
							   NILAI_PEROLEHAN,
							   (SELECT AKM_PENYUSUTAN
								  FROM PPI_ASSET.REKAP_AKTIVA_LALU X
								 WHERE X.PERIODE = '".$reqPeriodeLalu."'
								   AND X.INVENTARIS_RUANGAN_ID = A.INVENTARIS_RUANGAN_ID)
																		  AKM_PENYUSUTAN_LALU,
							   NILAI_PENYUSUTAN, AKM_PENYUSUTAN, NILAI_AKHIR
						  FROM PPI_ASSET.KALKULASI_PENYUSUTAN A
					LEFT JOIN PPI_SIUK.KBBR_BUKU_BESAR B ON TRIM(A.KODE_GL_KREDIT) = B.KD_BUKU_BESAR
						 WHERE PERIODE = '".$reqPeriode."') A
				 WHERE 1 = 1
				   AND (UPPER (NAMA) LIKE '%%' OR UPPER (KODE) LIKE '%%')
				   AND PERIODE = '".$reqPeriode."'
				   GROUP BY KD_BUKU_BESAR, NM_BUKU_BESAR, '00000',
								   NVL(A.KD_BUKU_PUSAT, '000.00.00'), NM_BUKU_PUSAT
				   ORDER BY A.KD_BUKU_BESAR, NVL(A.KD_BUKU_PUSAT, '000.00.00')
				) WHERE KREDIT > 0
				) A WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."   ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsPeriode($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY TO_DATE(PERIODE, 'MMYYYY') DESC ")
	{
		$str = "
			    
				SELECT DISTINCT PERIODE FROM PPI_ASSET.PERIODE A
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
	
	
    function selectByParamsPeriodeAda($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY TO_DATE(PERIODE, 'MMYYYY') DESC ")
	{
		$str = "
			    SELECT DISTINCT PERIODE FROM
				(
				SELECT DISTINCT PERIODE FROM PPI_ASSET.KALKULASI_PENYUSUTAN A
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
	
    function selectByParamsPeriodeTahunan($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY TO_DATE(PERIODE, 'MMYYYY') DESC ")
	{
		$str = "
			    SELECT PERIODE FROM PPI_ASSET.PERIODE A
				WHERE 1 = 1 AND SUBSTR(PERIODE, 0, 2) = '06'
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
	
	
	
    function getCountByParamsRekapKelompokFlexy($reqPeriode, $reqPeriodeLalu, $paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM (
					SELECT A.PERIODE, 
					   A.KODE_HEADER, A.NAMA_HEADER, 
					   B.NILAI_PEROLEHAN NILAI_LALU, 
					   (A.NILAI_PEROLEHAN - B.NILAI_PEROLEHAN) NILAI_PENAMBAHAN, 0 NILAI_PENGURANGAN, A.NILAI_PEROLEHAN NILAI_KINI, 
					   B.AKM_PENYUSUTAN AKM_LALU, 
					   (A.AKM_PENYUSUTAN - B.AKM_PENYUSUTAN) AKM_PENAMBAHAN, 0 AKM_PENGURANGAN, A.AKM_PENYUSUTAN, 
					   A.NILAI_AKHIR FROM PPI_ASSET.REKAP_KELOMPOK A
					LEFT JOIN PPI_ASSET.REKAP_KELOMPOK B ON B.PERIODE = '".$reqPeriodeLalu."' AND A.KODE_HEADER = B.KODE_HEADER
					WHERE A.PERIODE = '".$reqPeriode."'
				) A
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