<? 
/* *******************************************************************************************************
MODUL NAME 			: 
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

  class GajiAwalBulan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function GajiAwalBulan()
	{
      $this->Entity(); 
    }
	
    function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   INSERT INTO PPI_GAJI.GAJI_AWAL_BULAN_LOG(PERIODE) VALUES ('TES')
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.GAJI_AWAL_BULAN
			   SET 
			   		DEPARTEMEN_ID  	= '".$this->getField("DEPARTEMEN_ID")."',
				   	BULANTAHUN		= '".$this->getField("BULANTAHUN")."',
				   	KELAS			= '".$this->getField("KELAS")."',
				   	PERIODE			= '".$this->getField("PERIODE")."',
				   	STATUS_BAYAR	= '".$this->getField("STATUS_BAYAR")."',
					GAJI_JSON		= '".$this->getField("GAJI_JSON")."'
			   WHERE PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

    function updateStatusBayar()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.GAJI_AWAL_BULAN
			   SET 
			   		STATUS_BAYAR	= 1
			   WHERE BULANTAHUN IN ('".$this->getField("AWAL")."', '".$this->getField("AKHIR")."') AND NVL(STATUS_BAYAR, 0) = 0
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
		
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_GAJI.GAJI_AWAL_BULAN SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")." AND BULANTAHUN = ".$this->getField("BULANTAHUN")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "
				DELETE FROM PPI_GAJI.GAJI_AWAL_BULAN
                WHERE 
                  PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")."
			"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callHitungGajiAwalBulanV2()
	{
		$str = " CALL PPI_GAJI.PROSES_ROLLBACK_CICILAN('".$this->getField("JENIS_PEGAWAI_ID")."') ";
		
		$this->execQuery($str);
		
        $str = "
				CALL PPI_GAJI.PROSES_HITUNG_GAJI_V7('".$this->getField("PERIODE")."', '01', '".$this->getField("JENIS_PEGAWAI_ID")."', 'AWAL_BULAN')
		"; 
				  
		$this->query = $str;
		// echo $str; exit;
        return $this->execQuery($str);
    }	

	function callHitungGajiAwalBulan()
	{
        $str = "
				CALL PPI_GAJI.PROSES_HITUNG_GAJI('".$this->getField("PERIODE")."', '01', ".$this->getField("JENIS_PEGAWAI_ID").", 'AWAL_BULAN')
		"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }	
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
	function selectByParamsGaji($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="", $periode="", $jenis_pegawai_id="", $status_pegawai_id="1,2,3,4,5,6")
	{
		$str = "
				SELECT B.NO_URUT, PPI_SIMPEG.AMBIL_JENIS_PEGAWAI_PERIODE(B.BULANTAHUN, A.PEGAWAI_ID) JENIS_PEGAWAI_ID, A.PEGAWAI_ID, A.NRP, A.NAMA, A.DEPARTEMEN_ID, B.BULANTAHUN, B.KELAS, B.PERIODE, B.STATUS_BAYAR, B.DEPARTEMEN,
						GAJI_JSON, SUMBANGAN_JSON, POTONGAN_JSON, POTONGAN_LAIN_JSON, TANGGUNGAN_JSON, '' ASAL_PERUSAHAAN, B.JABATAN, B.JABATAN||'('|| B.KELAS ||')' AS JBT_KLS, 
						PPI_GAJI.AMBIL_ISI_JSON (GAJI_JSON, 'UANG_TRANSPORT')+PPI_GAJI.AMBIL_ISI_JSON (GAJI_JSON, 'UANG_MAKAN')+PPI_GAJI.AMBIL_ISI_JSON (GAJI_JSON, 'UANG_INSENTIF') LUMPSUM
				FROM PPI_GAJI.GAJI_AWAL_BULAN B 
					 INNER JOIN PPI_GAJI.PEGAWAI A ON A.PEGAWAI_ID = B.PEGAWAI_ID AND A.STATUS_PEGAWAI_ID IN (".$status_pegawai_id.") AND A.PERIODE = B.BULANTAHUN
				WHERE 1 = 1 AND BULANTAHUN = '".$periode."' 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsGajiLihat($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="", $periode="", $jenis_pegawai_id="")
	{
		$str = "
				SELECT A.PEGAWAI_ID, A.NAMA, A.NRP, D.KELAS, D.NAMA JABATAN, GAJI_POKOK, PANGKAT, F.KODE STATUS_KELUARGA ,BULANTAHUN, REKENING_NO, NPWP, 
                        PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(A.DEPARTEMEN_ID,0)) DEPARTEMEN, STATUS_BAYAR, 
						GAJI_JSON, SUMBANGAN_JSON, POTONGAN_JSON, POTONGAN_LAIN_JSON, TANGGUNGAN_JSON, ASAL_PERUSAHAAN
				FROM PPI_SIMPEG.PEGAWAI A 
					 LEFT JOIN PPI_GAJI.GAJI_AWAL_BULAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND BULANTAHUN = '".$periode."'
					 LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID 
					 LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID 
					 LEFT JOIN PPI_SIMPEG.PEGAWAI_PANGKAT_TERAKHIR E ON A.PEGAWAI_ID = E.PEGAWAI_ID 
                     LEFT JOIN PPI_SIMPEG.STATUS_KELUARGA F ON A.STATUS_KELUARGA_ID = F.STATUS_KELUARGA_ID
                WHERE 1 = 1 AND (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5)
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
	
	function selectByParamsGajiTengahBulan($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="", $periode="", $jenis_pegawai_id="")
	{
		$str = "
				SELECT A.PEGAWAI_ID, A.NAMA, A.DEPARTEMEN_ID, B.BULANTAHUN, KELAS, PERIODE, STATUS_BAYAR, 
						GAJI_JSON
				FROM PPI_SIMPEG.PEGAWAI A 
					 LEFT JOIN PPI_GAJI.GAJI_TENGAH_BULAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND BULANTAHUN = '".$periode."'
					 INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID 
				WHERE 1 = 1 AND C.JENIS_PEGAWAI_ID = ".$jenis_pegawai_id."  AND (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5)
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
		
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="", $reqBulan="", $reqTahun="")
	{
		$str = "
				SELECT A.PEGAWAI_ID, A.NAMA, A.DEPARTEMEN_ID, BULANTAHUN, KELAS, PERIODE, STATUS_BAYAR, GAJI_JSON, SUMBANGAN_JSON
                FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_GAJI.GAJI_AWAL_BULAN B 
                ON A.PEGAWAI_ID = B.PEGAWAI_ID
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

    function selectByParamsJurnalSemua($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT
				(SELECT (SUM(JUMLAH_GAJI_KOTOR) + SUM(UANG_MAKAN) + SUM(UANG_TRANSPORT) + SUM(UANG_INSENTIF) + SUM(PEMBULATAN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE NVL(STATUS_BAYAR, 0) = 0 AND PERIODE = '".$periode."') JUMLAH
				FROM DUAL
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsJurnalSemuaJanuari2014($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT
				(SELECT (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE JENIS_PEGAWAI_ID IN (2,6,7) AND PERIODE = '".$periode."')
				+
				(SELECT (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE JENIS_PEGAWAI_ID IN (3,5) AND PERIODE = '".$periode."') JUMLAH
				FROM DUAL
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
    function selectByParamsJurnalMakanSemua($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT SUM(TOTAL) JUMLAH FROM PPI_GAJI.UANG_MAKAN_KAPAL_REPORT A WHERE PERIODE = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJurnalTransportasiSemua($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT SUM(TOTAL) JUMLAH FROM PPI_GAJI.REKAP_UANG_TRANSPORT_REPORT A WHERE PERIODE = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJurnalTHRSemua($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT SUM(TOTAL) JUMLAH FROM PPI_GAJI.REKAP_THR_REPORT A WHERE PERIODE = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJurnalJKMTHR($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT SUM(BANTUAN_PPH) JUMLAH FROM PPI_GAJI.REKAP_THR_REPORT A WHERE PERIODE = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsJurnalJKMTransportasi($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT SUM(BANTUAN) JUMLAH FROM PPI_GAJI.REKAP_UANG_TRANSPORT_REPORT A WHERE PERIODE = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJurnalInsentifSemua($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT SUM(TOTAL) JUMLAH FROM PPI_GAJI.REKAP_INSENTIF_REPORT A WHERE PERIODE = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsJurnalInsentifKhususSemua($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT SUM(JUMLAH) JUMLAH FROM PPI_GAJI.INSENTIF_KHUSUS_REPORT WHERE PERIODE '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJurnalCutiTahunanSemua($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT SUM(TOTAL) JUMLAH FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A WHERE PERIODE = '".$periode."' AND TANGGAL_APPROVE IS NULL AND JUMLAH IS NOT NULL
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsJurnalJKMInsentif($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT SUM(POTONGAN_PPH) JUMLAH FROM PPI_GAJI.REKAP_INSENTIF_REPORT A WHERE PERIODE = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsJurnalJKMInsentifKhusus($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT SUM(JUMLAH_PPH) JUMLAH FROM PPI_GAJI.INSENTIF_KHUSUS_REPORT WHERE PERIODE = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJurnalJKMCutiTahunan($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT SUM(JUMLAH_POTONGAN) JUMLAH FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A WHERE PERIODE = '".$periode."' AND TANGGAL_APPROVE IS NULL AND JUMLAH IS NOT NULL
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsJurnalPremiSemua($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT SUM(TOTAL_INSENTIF) JUMLAH FROM PPI_GAJI.PREMI_REPORT A WHERE PERIODE = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJurnalJKMPremi($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT (SUM(TOTAL_INSENTIF) - SUM(JUMLAH_DITERIMA)) JUMLAH FROM PPI_GAJI.PREMI_REPORT A WHERE PERIODE = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJurnalJKMMakan($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT SUM(BANTUAN_PPH) JUMLAH FROM PPI_GAJI.UANG_MAKAN_KAPAL_REPORT A WHERE PERIODE = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

					
    function selectByParamsJurnal($paramsArray=array(),$limit=-1,$from=-1,$statement="")
	{
		$str = "
				SELECT (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJurnalJKMSemua($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT (SELECT SUM (JUMLAH_POTONGAN_WAJIB) JUMLAH
						  FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
						 WHERE NVL (STATUS_BAYAR, 0) = 0
						   AND PERIODE = '".$periode."') JUMLAH
				  FROM DUAL
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalJKMSemuaJanuari2014($paramsArray=array(),$limit=-1,$from=-1,$periode="", $periode="")
	{
		$str = "
				SELECT
				(SELECT SUM(JUMLAH_POTONGAN_WAJIB) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE JENIS_PEGAWAI_ID IN (2,6,7) AND PERIODE = '".$periode."')
				+
				(SELECT SUM(JUMLAH_POTONGAN_WAJIB) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE JENIS_PEGAWAI_ID IN (3,5) AND PERIODE = '".$periode."') JUMLAH
				FROM DUAL
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
				
    function selectByParamsJurnalJKM($paramsArray=array(),$limit=-1,$from=-1,$statement="")
	{
		$str = "
				SELECT SUM(JUMLAH_POTONGAN_WAJIB) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalDetil($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $periode="")
	{
		$str = "(SELECT URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT 1 URUT, '0001' DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT '01' DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.03.01' KD_BUKU_BESAR, '00001' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM 
                (SELECT SUM(MERIT_PMS) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE ='".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 6 
                            ) B 
                UNION ALL
                SELECT '01' DEPARTEMEN_ID, '96', 'NO_NOTA', 'A2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.07', '00001', '000.00.00', 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM 
                 (SELECT SUM(MOBILITAS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE ='".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 6 
                            ) C 
                UNION ALL
                SELECT '01' DEPARTEMEN_ID, '96', 'NO_NOTA', 'A3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.06', '00001', '000.00.00', 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM 
                (SELECT SUM(PERUMAHAN) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE ='".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 6 
                            ) C 
                UNION ALL
                SELECT '01' DEPARTEMEN_ID, '96', 'NO_NOTA', 'A4', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', '00001', '000.00.00', 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM 
                (SELECT SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE ='".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 6 
                            ) C 
                ) A ORDER BY A.NO_SEQ ASC
                ) A
                UNION ALL
                SELECT 7 URUT, 'A1111', '96', 'NO_NOTA', 'G2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00001', '000.00.00', 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(DANA_PENSIUN)+SUM(ASURANSI_JIWASRAYA)+SUM(BPJS_PESERTA) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE (PERIODE ='".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID IN (2,6,7)) OR (PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID IN (1,3, 5, 12)) ) C 
                UNION ALL
                SELECT 7 URUT, 'A1111', '96', 'NO_NOTA', 'G1', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00001', '000.00.00', 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(POTONGAN_PPH21) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE (PERIODE ='".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID IN (2,6,7)) OR (PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID IN (1,3, 5, 12)) ) C 
                UNION ALL
                SELECT 7 URUT, 'A1111', '96', 'NO_NOTA', 'G3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.11.00', '00001', '000.00.00', 'IDR', SYSDATE, 1, 0, JUMLAH, 0, JUMLAH, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM 
                (SELECT (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) - (SUM(JUMLAH_POTONGAN_WAJIB) + SUM(JUMLAH_POTONGAN_LAIN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE (PERIODE ='".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID IN (2,6,7)) OR (PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID IN (1,3,5,12))
                 ) C 
                ) A  WHERE 1 = 1 AND NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0)     
                UNION ALL                                                
                SELECT URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (                
                SELECT 4 URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT '01' DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'C1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.01.00' KD_BUKU_BESAR, '00001' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM 
                (SELECT SUM(MERIT_PMS) + SUM(TUNJANGAN_PERBANTUAN) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 1
                            ) B 
                UNION ALL
                SELECT '01' DEPARTEMEN_ID, '96', 'NO_NOTA', 'C4', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.00', '00001', '000.00.00', 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM 
                (SELECT SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 1
                            ) C 
                UNION ALL
                SELECT '01' DEPARTEMEN_ID, '96', 'NO_NOTA', 'C3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.03', '00001', '000.00.00', 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM 
                (SELECT SUM(TUNJANGAN_JABATAN) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 1
                            ) C 
                UNION ALL
                SELECT '01' DEPARTEMEN_ID, '96', 'NO_NOTA', 'C2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.05', '00001', '000.00.00', 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM 
                (SELECT SUM(TPP_PMS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 1
                            ) C 
                ) A ORDER BY  A.NO_SEQ ASC
                ) A               
                ) A  WHERE 1 = 1 AND NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0)                               
                )                 
                ORDER BY URUT, NO_SEQ ";
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalDetilJanuari2014($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $periode="")
	{
	
		$str = "
                (SELECT URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT 1 URUT, '0001' DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.03.01' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MERIT_PMS) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'A2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.07', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MOBILITAS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'A3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.06', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(PERUMAHAN) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'A4', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A
                UNION ALL
                SELECT 7 URUT, 'A1111', '96', 'NO_NOTA', 'G1', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_LAIN) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE (PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID IN (2,6,7)) OR (PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID IN (3, 5)) ) C 
                UNION ALL
                SELECT 7 URUT, 'A1111', '96', 'NO_NOTA', 'G2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE (PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID IN (2,6,7)) OR (PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID IN (3, 5)) ) C 
                UNION ALL
                SELECT 7 URUT, 'A1111', '96', 'NO_NOTA', 'G3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH, 0, JUMLAH, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.BANK A 
                INNER JOIN (SELECT BANK, (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) - (SUM(JUMLAH_POTONGAN_WAJIB) + SUM(JUMLAH_POTONGAN_LAIN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE (PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID IN (2,6,7)) OR (PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID IN (3, 5))
                            GROUP BY A.BANK) C ON A.NAMA = C.BANK
                ) A 
                UNION ALL
                SELECT URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT 2 URUT, '0002' DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'B1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.03.00' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MERIT_PMS) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'B2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.07', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MOBILITAS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'B3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.03', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TELEPON) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'B4', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A
                ) A
                UNION ALL                                                
                SELECT URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (                
                SELECT 3 URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'C1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.01.00' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MERIT_PMS) + SUM(TUNJANGAN_PERBANTUAN) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2 AND NOT EXISTS (SELECT 1 FROM PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID)
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'C2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2 AND NOT EXISTS (SELECT 1 FROM PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID)
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'C3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.03', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TUNJANGAN_JABATAN) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2 AND NOT EXISTS (SELECT 1 FROM PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID)
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'C4', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.04', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TPP_PMS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2 AND NOT EXISTS (SELECT 1 FROM PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID)
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A
                UNION ALL                
                SELECT 3 URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.NAMA DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'C1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.01.00' KD_BUKU_BESAR, NO_KARTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL_ID, SUM(MERIT_PMS) + SUM(TUNJANGAN_PERBANTUAN) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A INNER JOIN PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2 
                            GROUP BY B.KAPAL_ID ORDER BY KAPAL_ID ASC) B ON A.KAPAL_ID = B.KAPAL_ID
                UNION ALL
                SELECT A.NAMA DEPARTEMEN_ID, '96', 'NO_NOTA', 'C2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', NO_KARTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL_ID, SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A INNER JOIN PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2
                            GROUP BY B.KAPAL_ID ORDER BY KAPAL_ID ASC) C ON A.KAPAL_ID = C.KAPAL_ID
                UNION ALL
                SELECT A.NAMA DEPARTEMEN_ID, '96', 'NO_NOTA', 'C3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.03', NO_KARTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL_ID, SUM(TUNJANGAN_JABATAN) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A INNER JOIN PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2
                            GROUP BY B.KAPAL_ID ORDER BY KAPAL_ID ASC) C ON A.KAPAL_ID = C.KAPAL_ID
                UNION ALL
                SELECT A.NAMA DEPARTEMEN_ID, '96', 'NO_NOTA', 'C4', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.04', NO_KARTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL_ID, SUM(TPP_PMS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A INNER JOIN PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2
                            GROUP BY B.KAPAL_ID ORDER BY KAPAL_ID ASC) C ON A.KAPAL_ID = C.KAPAL_ID
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A        
                ) A WHERE 1 = 1           
                UNION ALL
                SELECT URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (                
                SELECT 5 URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'C1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.01.00' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MERIT_PMS) + SUM(TUNJANGAN_PERBANTUAN) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5 AND NOT EXISTS (SELECT 1 FROM PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID)
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'C2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5 AND NOT EXISTS (SELECT 1 FROM PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID)
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'C3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.03', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TUNJANGAN_JABATAN) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5 AND NOT EXISTS (SELECT 1 FROM PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID)
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'C4', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.04', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TPP_PMS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5 AND NOT EXISTS (SELECT 1 FROM PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID)
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A
                UNION ALL                
                SELECT 5 URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.NAMA DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'C1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.01.00' KD_BUKU_BESAR, NO_KARTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL_ID, SUM(MERIT_PMS) + SUM(TUNJANGAN_PERBANTUAN) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A INNER JOIN PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5 
                            GROUP BY B.KAPAL_ID ORDER BY KAPAL_ID ASC) B ON A.KAPAL_ID = B.KAPAL_ID
                UNION ALL
                SELECT A.NAMA DEPARTEMEN_ID, '96', 'NO_NOTA', 'C2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', NO_KARTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL_ID, SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A INNER JOIN PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5
                            GROUP BY B.KAPAL_ID ORDER BY KAPAL_ID ASC) C ON A.KAPAL_ID = C.KAPAL_ID
                UNION ALL
                SELECT A.NAMA DEPARTEMEN_ID, '96', 'NO_NOTA', 'C3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.03', NO_KARTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL_ID, SUM(TUNJANGAN_JABATAN) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A INNER JOIN PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5
                            GROUP BY B.KAPAL_ID ORDER BY KAPAL_ID ASC) C ON A.KAPAL_ID = C.KAPAL_ID
                UNION ALL
                SELECT A.NAMA DEPARTEMEN_ID, '96', 'NO_NOTA', 'C4', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.04', NO_KARTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL_ID, SUM(TPP_PMS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A INNER JOIN PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5
                            GROUP BY B.KAPAL_ID ORDER BY KAPAL_ID ASC) C ON A.KAPAL_ID = C.KAPAL_ID
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A                                    
                ) A
                UNION ALL
                SELECT URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (                
                SELECT 6 URUT,  DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'F1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '806.10.03' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3  AND NOT EXISTS (SELECT 1 FROM PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID)
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID                
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A
                UNION ALL
                SELECT 6 URUT,  DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.NAMA DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'F1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '806.10.03' KD_BUKU_BESAR, NO_KARTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL_ID, SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A INNER JOIN PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID  WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3 
                            GROUP BY B.KAPAL_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.KAPAL_ID = B.KAPAL_ID                
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A         
                ) A WHERE 1 = 1 
                )                 
                ORDER BY URUT, DEPARTEMEN_ID, NO_SEQ 
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalDetilBAKDEPARTEMENSAJA($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $periode="")
	{
		$str = "
                (SELECT URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT 1 URUT, '0001' DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.03.00' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MERIT_PMS) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'A2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.07', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MOBILITAS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'A3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.06', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(PERUMAHAN) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'A4', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A
                UNION ALL
                SELECT 7 URUT, 'A1111', '96', 'NO_NOTA', 'G1', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_LAIN) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6 ) C 
                UNION ALL
                SELECT 7 URUT, 'A1111', '96', 'NO_NOTA', 'G2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6 ) C 
                UNION ALL
                SELECT 7 URUT, 'A1111', '96', 'NO_NOTA', 'G3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH, 0, JUMLAH, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.BANK A 
                INNER JOIN (SELECT BANK, (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) - (SUM(JUMLAH_POTONGAN_WAJIB) + SUM(JUMLAH_POTONGAN_LAIN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6 
                            GROUP BY A.BANK) C ON A.NAMA = C.BANK
                ) A 
                UNION ALL
                SELECT URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT 2 URUT, '0002' DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'B1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.03.00' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MERIT_PMS) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'B2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.07', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MOBILITAS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'B3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.03', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TELEPON) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'B4', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A
                UNION ALL
                SELECT 8 URUT, 'A1111', '96', 'NO_NOTA', 'H1', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_LAIN) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C 
                UNION ALL
                SELECT 8 URUT, 'A1111', '96', 'NO_NOTA', 'H2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C 
                UNION ALL
                SELECT 8 URUT, 'A1111', '96', 'NO_NOTA', 'H3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH, 0, JUMLAH, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.BANK A 
                INNER JOIN (SELECT BANK, (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) - (SUM(JUMLAH_POTONGAN_WAJIB) + SUM(JUMLAH_POTONGAN_LAIN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7
                            GROUP BY A.BANK) C ON A.NAMA = C.BANK
                ) A
                UNION ALL                                                
                SELECT URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT 3 URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'C1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.01.00' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MERIT_PMS) + SUM(TUNJANGAN_PERBANTUAN) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'C2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'C3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.03', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TUNJANGAN_JABATAN) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'C4', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.04', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TPP_PMS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A
                UNION ALL
                SELECT 9 URUT,   'AA1111', '96', 'NO_NOTA', 'I1', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_LAIN) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C 
                UNION ALL
                SELECT 9 URUT,   'AA1111', '96', 'NO_NOTA', 'I2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C 
                UNION ALL
                SELECT 9 URUT,   'AA1111', '96', 'NO_NOTA', 'I3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH, 0, JUMLAH, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.BANK A 
                INNER JOIN (SELECT BANK, (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) - (SUM(JUMLAH_POTONGAN_WAJIB) + SUM(JUMLAH_POTONGAN_LAIN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2
                            GROUP BY A.BANK) C ON A.NAMA = C.BANK
                ) A WHERE 1 = 1           
                UNION ALL                
                SELECT URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT 4 URUT,   DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'D1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.01.00' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MERIT_PMS) + SUM(TUNJANGAN_PERBANTUAN) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 1
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'D2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 1
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'D3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.03', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TUNJANGAN_JABATAN) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 1
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'D4', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.04', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TPP_PMS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 1
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A
                UNION ALL
                SELECT 10 URUT, 'A1111', '96', 'NO_NOTA', 'J1', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_LAIN) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 1) C 
                UNION ALL
                SELECT 10 URUT, 'A1111', '96', 'NO_NOTA', 'J2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 1) C 
                UNION ALL
                SELECT 10 URUT, 'A1111', '96', 'NO_NOTA', 'J3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH, 0, JUMLAH, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.BANK A 
                INNER JOIN (SELECT BANK, (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) - (SUM(JUMLAH_POTONGAN_WAJIB) + SUM(JUMLAH_POTONGAN_LAIN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 1
                            GROUP BY A.BANK) C ON A.NAMA = C.BANK
                ) A                
                UNION ALL
                SELECT URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT 5 URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'E1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.01.00' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MERIT_PMS) + SUM(TUNJANGAN_PERBANTUAN) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'E2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'E3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.03', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TUNJANGAN_JABATAN) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 'E4', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.04', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TPP_PMS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A
                UNION ALL
                SELECT 11 URUT,  'A1111', '96', 'NO_NOTA', 'K1', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_LAIN) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C 
                UNION ALL
                SELECT 11 URUT,  'A1111', '96', 'NO_NOTA', 'K2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C 
                UNION ALL
                SELECT 11 URUT,  'A1111', '96', 'NO_NOTA', 'K3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH, 0, JUMLAH, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.BANK A 
                INNER JOIN (SELECT BANK, (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) - (SUM(JUMLAH_POTONGAN_WAJIB) + SUM(JUMLAH_POTONGAN_LAIN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5
                            GROUP BY A.BANK) C ON A.NAMA = C.BANK
                ) A
                UNION ALL
                SELECT URUT, DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT 6 URUT,  DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT DEPARTEMEN_ID, KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'F1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '806.10.03' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID                
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A
                UNION ALL
                SELECT 12 URUT,   'A1111', '96', 'NO_NOTA', 'L1', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_LAIN) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3 ) C 
                UNION ALL
                SELECT 12 URUT,   'A1111', '96', 'NO_NOTA', 'L2', 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3 ) C 
                UNION ALL
                SELECT 12 URUT,   'A1111', '96', 'NO_NOTA', 'L3', 'KBB', 'JKK', 'JKK-KBB-01', NULL, KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH, 0, JUMLAH, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.BANK A 
                INNER JOIN (SELECT BANK, (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) - (SUM(JUMLAH_POTONGAN_WAJIB) + SUM(JUMLAH_POTONGAN_LAIN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3 
                            GROUP BY A.BANK) C ON A.NAMA = C.BANK
                ) A WHERE 1 = 1 
                )                 
                ORDER BY URUT, DEPARTEMEN_ID, NO_SEQ
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	

    function selectByParamsJurnalDetilBAK($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
				SELECT KD_CABANG, NO_NOTA, ROWNUM NO_SEQ, 
				   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
				   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
				   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
				   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
				   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
				   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
				   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
				   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
				(
				SELECT KD_CABANG, NO_NOTA, ROWNUM NO_SEQ, 
				   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
				   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
				   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
				   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
				   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
				   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
				   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
				   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
				(
				SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
				   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
				   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
				   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
				   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
				   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
				   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
				   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
				   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
				(
				SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.01.00' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
				INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MERIT_PMS) + SUM(TUNJANGAN_PERBANTUAN) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
							GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
				UNION ALL
				SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 2, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.04', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
				INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TPP_PMS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
							GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
				UNION ALL
				SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 3, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.05.03', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
				INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TUNJANGAN_JABATAN) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
							GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
				UNION ALL
				SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
				INNER JOIN (SELECT DEPARTEMEN_ID, SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
							GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
				) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
				) A
				UNION ALL
				SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
				FROM (SELECT SUM(JUMLAH_POTONGAN_LAIN) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." ) C 
				UNION ALL
				SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
				FROM (SELECT SUM(JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." ) C 
				UNION ALL
				SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH, 0, JUMLAH, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.BANK A 
				INNER JOIN (SELECT BANK, (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) - (SUM(JUMLAH_POTONGAN_WAJIB) + SUM(JUMLAH_POTONGAN_LAIN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
							GROUP BY A.BANK) C ON A.NAMA = C.BANK
				) A WHERE 1 = 1				
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalDetilTransportasi($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
                SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (                               
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.05.05' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID_KEUANGAN DEPARTEMEN_ID, SUM(JUMLAH) JUMLAH FROM PPI_GAJI.TRANSPORT_MOBILITAS_REPORT A WHERE PERIODE = '".$periode."' 
                            GROUP BY A.DEPARTEMEN_ID_KEUANGAN ORDER BY DEPARTEMEN_ID_KEUANGAN ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 2 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.02.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID_KEUANGAN DEPARTEMEN_ID, SUM(BANTUAN_PPH) JUMLAH FROM PPI_GAJI.TRANSPORT_MOBILITAS_REPORT A WHERE PERIODE = '".$periode."' 
                            GROUP BY A.DEPARTEMEN_ID_KEUANGAN ORDER BY DEPARTEMEN_ID_KEUANGAN ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                ORDER BY DEPARTEMEN_ID ASC, NO_SEQ ASC ) A 
                UNION ALL               
                SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (                                               
               SELECT KAPAL , '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.05.05' KD_BUKU_BESAR, NO_KARTU KD_SUB_BANTU, A.PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL, KAPAL_ID, SUM(JUMLAH) JUMLAH FROM PPI_GAJI.UANG_TRANSPORT_KAPAL_REPORT A WHERE PERIODE = '".$periode."' 
                            GROUP BY A.KAPAL_ID, A.KAPAL ORDER BY KAPAL ASC) B ON A.KAPAL_ID = B.KAPAL_ID
               UNION ALL
               SELECT KAPAL , '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 2 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.02.00' KD_BUKU_BESAR, NO_KARTU KD_SUB_BANTU, A.PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL, KAPAL_ID, SUM(BANTUAN_PPH) JUMLAH FROM PPI_GAJI.UANG_TRANSPORT_KAPAL_REPORT A WHERE PERIODE = '".$periode."' 
                            GROUP BY A.KAPAL_ID, A.KAPAL ORDER BY KAPAL ASC) B ON A.KAPAL_ID = B.KAPAL_ID
               ORDER BY KAPAL ASC, NO_SEQ               
               ) B
               UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(BANTUAN) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.REKAP_UANG_TRANSPORT_REPORT A WHERE PERIODE = '".$periode."' ) C                 
                UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.REKAP_UANG_TRANSPORT_REPORT A WHERE PERIODE = '".$periode."') C 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalDetilTHR($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
                SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (                               
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, 
                decode(A.DEPARTEMEN_ID, 77, '801.03.02', 88,'801.03.02', '801.05.06') KD_BUKU_BESAR, '00000' KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID_KEUANGAN DEPARTEMEN_ID, SUM(JUMLAH) JUMLAH FROM PPI_GAJI.THR_REPORT A WHERE PERIODE = '".$periode."' AND KAPAL_ID IS NULL
                            GROUP BY A.DEPARTEMEN_ID_KEUANGAN ORDER BY DEPARTEMEN_ID_KEUANGAN ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 2 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.02.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID_KEUANGAN DEPARTEMEN_ID, SUM(BANTUAN_PPH) JUMLAH FROM PPI_GAJI.THR_REPORT A WHERE PERIODE = '".$periode."' AND KAPAL_ID IS NULL
                            GROUP BY A.DEPARTEMEN_ID_KEUANGAN ORDER BY DEPARTEMEN_ID_KEUANGAN ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                ORDER BY DEPARTEMEN_ID ASC, NO_SEQ ASC ) A   
                UNION ALL         
                SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (                                               
               SELECT KAPAL_NAMA , '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, CASE WHEN 'A.DEPARTEMEN_ID' = '77' THEN '801.03.02' ELSE '801.05.06' END KD_BUKU_BESAR, NO_KARTU KD_SUB_BANTU, A.PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL_NAMA, KAPAL_ID, SUM(JUMLAH) JUMLAH FROM PPI_GAJI.THR_REPORT A WHERE PERIODE = '".$periode."' AND KAPAL_ID IS NOT NULL 
                            GROUP BY A.KAPAL_ID, A.KAPAL_NAMA ORDER BY KAPAL_NAMA ASC) B ON A.KAPAL_ID = B.KAPAL_ID
               UNION ALL
               SELECT KAPAL_NAMA , '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 2 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.02.00' KD_BUKU_BESAR, NO_KARTU KD_SUB_BANTU, A.PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL_NAMA, KAPAL_ID, SUM(BANTUAN_PPH) JUMLAH FROM PPI_GAJI.THR_REPORT A WHERE PERIODE = '".$periode."'  AND KAPAL_ID IS NOT NULL
                            GROUP BY A.KAPAL_ID, A.KAPAL_NAMA ORDER BY KAPAL_NAMA ASC) B ON A.KAPAL_ID = B.KAPAL_ID
               ORDER BY KAPAL_NAMA ASC, NO_SEQ               
               ) B      
               UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(BANTUAN_PPH) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.REKAP_THR_REPORT A WHERE PERIODE = '".$periode."' ) C                 
                UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.REKAP_THR_REPORT A WHERE PERIODE = '".$periode."') C 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }		

    function selectByParamsJurnalDetilInsentif($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
                SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (                               
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.06.99' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID_KEUANGAN DEPARTEMEN_ID, SUM(JUMLAH) - SUM(JUMLAH_POTONGAN) JUMLAH FROM PPI_GAJI.INSENTIF_REPORT A WHERE PERIODE = '".$periode."' 
                            GROUP BY A.DEPARTEMEN_ID_KEUANGAN ORDER BY DEPARTEMEN_ID_KEUANGAN ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID) A 
               UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_PPH) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.INSENTIF_REPORT A WHERE PERIODE = '".$periode."' ) C                 
                UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT (SUM(JUMLAH) - SUM(JUMLAH_POTONGAN)) - SUM(JUMLAH_PPH) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.INSENTIF_REPORT A WHERE PERIODE = '".$periode."') C 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	function selectByParamsJurnalDetilInsentifKhusus($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
                 SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (                               
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.06.99' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID_KEUANGAN DEPARTEMEN_ID, SUM(JUMLAH) - SUM(JUMLAH_POTONGAN) JUMLAH FROM PPI_GAJI.INSENTIF_KHUSUS_REPORT A WHERE PERIODE = '".$periode."' 
                            GROUP BY A.DEPARTEMEN_ID_KEUANGAN ORDER BY DEPARTEMEN_ID_KEUANGAN ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID) A 
               UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_PPH) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.INSENTIF_KHUSUS_REPORT A WHERE PERIODE = '".$periode."' ) C                 
                UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT (SUM(JUMLAH) - SUM(JUMLAH_POTONGAN)) - SUM(JUMLAH_PPH) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.INSENTIF_KHUSUS_REPORT A WHERE PERIODE = '".$periode."') C 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalDetilCutiTahunan($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		/*
		$str = "
			SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (                                               
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, CASE WHEN A.DEPARTEMEN_ID = '77' THEN '801.03.04' ELSE '801.05.07' END KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TOTAL) JUMLAH FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A WHERE PERIODE = '".$periode."' AND TANGGAL_APPROVE IS NULL AND JUMLAH IS NOT NULL
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID                                                        
                            ) A 
               UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A WHERE PERIODE = '".$periode."'  AND TANGGAL_APPROVE IS NULL AND JUMLAH IS NOT NULL) C                 
                UNION ALL                
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT (SUM(JUMLAH))JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A WHERE PERIODE = '".$periode."'  AND TANGGAL_APPROVE IS NULL AND JUMLAH IS NOT NULL) C 
			"; 
		*/
		/*
		$str = "SELECT KD_CABANG, NO_NOTA, rownum NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (   select * from (                 
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, CASE WHEN A.DEPARTEMEN_ID = '77' THEN '801.03.04' ELSE '801.05.07' END KD_BUKU_BESAR, NVL(B.NO_KARTU, KODE_SUB_BANTU) KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, B.NO_KARTU, SUM(JUMLAH) JUMLAH FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A LEFT JOIN PEL_OPERASIONAL.DAFTAR_AWAK_KAPAL B ON (A.PEGAWAI_ID = B.PEGAWAI_ID) 
                            WHERE PERIODE = '".$periode."' AND TANGGAL_APPROVE IS NULL 
                            AND JUMLAH IS NOT NULL
                            GROUP BY A.DEPARTEMEN_ID, B.NO_KARTU ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID                                                        
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.02.00' KD_BUKU_BESAR, NVL(B.NO_KARTU, KODE_SUB_BANTU) KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, B.NO_KARTU, SUM(JUMLAH_POTONGAN) JUMLAH FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A LEFT JOIN PEL_OPERASIONAL.DAFTAR_AWAK_KAPAL B ON (A.PEGAWAI_ID = B.PEGAWAI_ID) 
                            WHERE PERIODE = '".$periode."' AND TANGGAL_APPROVE IS NULL 
                            AND JUMLAH IS NOT NULL
                            GROUP BY A.DEPARTEMEN_ID, B.NO_KARTU ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                   SELECT '1', '96', 'NO_NOTA', 1, 'KBB', 'JKK', 'JKK-KBB-01', '', '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A WHERE PERIODE = '".$periode."' AND TANGGAL_APPROVE IS NULL
                AND JUMLAH IS NOT NULL) C                 
                UNION ALL                
                SELECT '0', '96', 'NO_NOTA', 1, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT (SUM(JUMLAH))JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A WHERE PERIODE = '".$periode."' 
                 AND TANGGAL_APPROVE IS NULL AND JUMLAH IS NOT NULL) C 
                         ) ORDER BY KD_SUB_BANTU DESC, KD_BUKU_BESAR DESC ) A ";
		*/
		
		$str = "SELECT KD_CABANG, NO_NOTA, rownum NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (   select * from (                 
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, CASE WHEN A.DEPARTEMEN_ID = '77' THEN '801.03.04' ELSE '801.05.07' END KD_BUKU_BESAR, NVL(B.NO_KARTU, '00000') KD_SUB_BANTU, NVL(B.PUSPEL, A.PUSPEL) KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK 
                FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, B.NO_KARTU, B.PUSPEL, SUM(JUMLAH) JUMLAH FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A LEFT JOIN PEL_OPERASIONAL.DAFTAR_AWAK_KAPAL B ON (A.PEGAWAI_ID = B.PEGAWAI_ID) 
                            WHERE PERIODE = '".$periode."' AND TANGGAL_APPROVE IS NULL
                            AND JUMLAH IS NOT NULL
							" . $statement . " GROUP BY A.DEPARTEMEN_ID, B.NO_KARTU, B.PUSPEL ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID                                                        
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.02.00' KD_BUKU_BESAR, NVL(B.NO_KARTU, KODE_SUB_BANTU) KD_SUB_BANTU, NVL(B.PUSPEL, A.PUSPEL) KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, B.NO_KARTU, B.PUSPEL, SUM(JUMLAH_POTONGAN) JUMLAH FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A LEFT JOIN PEL_OPERASIONAL.DAFTAR_AWAK_KAPAL B ON (A.PEGAWAI_ID = B.PEGAWAI_ID) 
                            WHERE PERIODE = '".$periode."' AND TANGGAL_APPROVE IS NULL
                            AND JUMLAH IS NOT NULL
							" . $statement . " 
                            GROUP BY A.DEPARTEMEN_ID, B.NO_KARTU, B.PUSPEL ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                   SELECT '1', '96', 'NO_NOTA', 1, 'KBB', 'JKK', 'JKK-KBB-01', '', '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A WHERE PERIODE = '".$periode."' AND TANGGAL_APPROVE IS NULL
                AND JUMLAH IS NOT NULL " . $statement . " ) C                 
                UNION ALL                
                SELECT '0', '96', 'NO_NOTA', 1, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT (SUM(JUMLAH))JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A WHERE PERIODE = '".$periode."' 
				" . $statement . " 
                 AND TANGGAL_APPROVE IS NULL AND JUMLAH IS NOT NULL) C 
                         ) ORDER BY KD_SUB_BANTU DESC, KD_BUKU_BESAR DESC ) A ";
						 				 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		//$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	


    function selectByParamsJurnalDetilPremi($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
                SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (                                               
               SELECT NAMA_KAPAL , '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.06.03' KD_BUKU_BESAR, NO_KARTU KD_SUB_BANTU, A.PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT NAMA_KAPAL, KAPAL_ID, SUM(TOTAL_INSENTIF) JUMLAH FROM PPI_GAJI.PREMI_REPORT A WHERE PERIODE = '".$periode."' 
                            GROUP BY A.KAPAL_ID, A.NAMA_KAPAL ORDER BY NAMA_KAPAL ASC) B ON A.KAPAL_ID = B.KAPAL_ID
               ORDER BY NAMA_KAPAL ASC, NO_SEQ               
               ) B
               UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT (SUM(TOTAL_INSENTIF) - SUM(JUMLAH_DITERIMA)) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.PREMI_REPORT A WHERE PERIODE = '".$periode."' ) C                 
                UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT (SUM(JUMLAH_DITERIMA)) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.PREMI_REPORT A WHERE PERIODE = '".$periode."') C 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

  
    function selectByParamsJurnalJKMDetilTransportasi($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
                   SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (BANTUAN) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.REKAP_UANG_TRANSPORT_REPORT A
                             WHERE PERIODE = '".$periode."')
                     UNION ALL
                     SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '410.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, 0 SALDO_VAL_DEBET, JUMLAH_POTONGAN_KAS SALDO_VAL_KREDIT, 0 SALDO_RP_DEBET, JUMLAH_POTONGAN_KAS SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (BANTUAN) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.REKAP_UANG_TRANSPORT_REPORT A
                             WHERE PERIODE = '".$periode."')        
                     )          

			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
    function selectByParamsJurnalJKMDetilTHR($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
				 SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
					 KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
					 KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
					 KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
					 KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
					 SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
					 TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
					 LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
					 REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (BANTUAN_PPH) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.REKAP_THR_REPORT A
                             WHERE PERIODE = '".$periode."')
                     UNION ALL
                     SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '410.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, 0 SALDO_VAL_DEBET, JUMLAH_POTONGAN_KAS SALDO_VAL_KREDIT, 0 SALDO_RP_DEBET, JUMLAH_POTONGAN_KAS SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (BANTUAN_PPH) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.REKAP_THR_REPORT A
                             WHERE PERIODE = '".$periode."')        
                     )    

			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }		

    function selectByParamsJurnalDetilMakan($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
                SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (                                               
               SELECT KAPAL , '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '802.03.00' KD_BUKU_BESAR, NO_KARTU KD_SUB_BANTU, A.PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL, KAPAL_ID, SUM(JUMLAH) JUMLAH FROM PPI_GAJI.UANG_MAKAN_KAPAL_REPORT A WHERE PERIODE = '".$periode."' 
                            GROUP BY A.KAPAL_ID, A.KAPAL ORDER BY KAPAL ASC) B ON A.KAPAL_ID = B.KAPAL_ID
               UNION ALL
               SELECT KAPAL , '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 2 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.02.00' KD_BUKU_BESAR, NO_KARTU KD_SUB_BANTU, A.PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PEL_OPERASIONAL.KAPAL A 
                INNER JOIN (SELECT KAPAL, KAPAL_ID, SUM(BANTUAN_PPH) JUMLAH FROM PPI_GAJI.UANG_MAKAN_KAPAL_REPORT A WHERE PERIODE = '".$periode."' 
                            GROUP BY A.KAPAL_ID, A.KAPAL ORDER BY KAPAL ASC) B ON A.KAPAL_ID = B.KAPAL_ID
               ORDER BY KAPAL ASC, NO_SEQ               
               ) B
               UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(BANTUAN_PPH) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.UANG_MAKAN_KAPAL_REPORT A WHERE PERIODE = '".$periode."' ) C                 
                UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.UANG_MAKAN_KAPAL_REPORT A WHERE PERIODE = '".$periode."') C 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalJKMDetilMakan($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
                   SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (BANTUAN_PPH) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.UANG_MAKAN_KAPAL_REPORT A
                             WHERE PERIODE = '".$periode."')
                     UNION ALL
                     SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '410.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, 0 SALDO_VAL_DEBET, JUMLAH_POTONGAN_KAS SALDO_VAL_KREDIT, 0 SALDO_RP_DEBET, JUMLAH_POTONGAN_KAS SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (BANTUAN_PPH) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.UANG_MAKAN_KAPAL_REPORT A
                             WHERE PERIODE = '".$periode."')        
                     )          
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalJKMDetilInsentif($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
                   SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_PPH) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.INSENTIF_REPORT A
                             WHERE PERIODE = '".$periode."')
                     UNION ALL
                     SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '410.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, 0 SALDO_VAL_DEBET, JUMLAH_POTONGAN_KAS SALDO_VAL_KREDIT, 0 SALDO_RP_DEBET, JUMLAH_POTONGAN_KAS SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_PPH) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.INSENTIF_REPORT A
                             WHERE PERIODE = '".$periode."')        
                     )          
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	function selectByParamsJurnalJKMDetilInsentifKhusus($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
                   SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_PPH) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.INSENTIF_KHUSUS_REPORT A
                             WHERE PERIODE = '".$periode."')
                     UNION ALL
                     SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '410.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, 0 SALDO_VAL_DEBET, JUMLAH_POTONGAN_KAS SALDO_VAL_KREDIT, 0 SALDO_RP_DEBET, JUMLAH_POTONGAN_KAS SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_PPH) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.INSENTIF_KHUSUS_REPORT A
                             WHERE PERIODE = '".$periode."'))         
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJurnalJKMDetilCutiTahunan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $periode="")
	{
		$str = "
					SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A 
                             WHERE PERIODE = '".$periode."' AND TANGGAL_APPROVE IS NULL AND JUMLAH IS NOT NULL ".$statement." )
                     UNION ALL
                     SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '410.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, 0 SALDO_VAL_DEBET, JUMLAH_POTONGAN_KAS SALDO_VAL_KREDIT, 0 SALDO_RP_DEBET, JUMLAH_POTONGAN_KAS SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.CUTI_TAHUNAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND TANGGAL_APPROVE IS NULL AND JUMLAH IS NOT NULL ".$statement." )        
                     )          
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		//$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	


    function selectByParamsJurnalJKMDetilPremi($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
                   SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT (SUM(TOTAL_INSENTIF) - SUM(JUMLAH_DITERIMA)) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.PREMI_REPORT A
                             WHERE PERIODE = '".$periode."')
                     UNION ALL
                     SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '410.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, 0 SALDO_VAL_DEBET, JUMLAH_POTONGAN_KAS SALDO_VAL_KREDIT, 0 SALDO_RP_DEBET, JUMLAH_POTONGAN_KAS SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT (SUM(TOTAL_INSENTIF) - SUM(JUMLAH_DITERIMA)) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.PREMI_REPORT A
                             WHERE PERIODE = '".$periode."')        
                     )
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalDetilPKWT($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
				SELECT KD_CABANG, NO_NOTA, ROWNUM NO_SEQ, 
				   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
				   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
				   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
				   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
				   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
				   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
				   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
				   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
				(
				SELECT KD_CABANG, NO_NOTA, ROWNUM NO_SEQ, 
				   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
				   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
				   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
				   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
				   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
				   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
				   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
				   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
				(
				SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
				   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
				   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
				   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
				   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
				   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
				   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
				   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
				   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
				(
				SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '806.10.03' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
				INNER JOIN (SELECT DEPARTEMEN_ID, SUM(JUMLAH_GAJI_KOTOR) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
							GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID				
				) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
				) A
				UNION ALL
				SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
				FROM (SELECT SUM(JUMLAH_POTONGAN_LAIN) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." ) C 
				UNION ALL
				SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
				FROM (SELECT SUM(JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." ) C 
				UNION ALL
				SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH, 0, JUMLAH, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.BANK A 
				INNER JOIN (SELECT BANK, (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) - (SUM(JUMLAH_POTONGAN_WAJIB) + SUM(JUMLAH_POTONGAN_LAIN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
							GROUP BY A.BANK) C ON A.NAMA = C.BANK
				) A WHERE 1 = 1				
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalDetilDireksi($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
                SELECT KD_CABANG, NO_NOTA, ROWNUM NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT KD_CABANG, NO_NOTA, ROWNUM NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.03.00' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MERIT_PMS) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 2, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.07', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MOBILITAS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 3, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.06', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(PERUMAHAN) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A
                UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_LAIN) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." ) C 
                UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." ) C 
                UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH, 0, JUMLAH, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.BANK A 
                INNER JOIN (SELECT BANK, (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) - (SUM(JUMLAH_POTONGAN_WAJIB) + SUM(JUMLAH_POTONGAN_LAIN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
                            GROUP BY A.BANK) C ON A.NAMA = C.BANK
                ) A WHERE 1 = 1       
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalDetilKomisaris($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
                SELECT KD_CABANG, NO_NOTA, ROWNUM NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT KD_CABANG, NO_NOTA, ROWNUM NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                (
                SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM
                (
                SELECT A.DEPARTEMEN_ID, '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, '801.03.00' KD_BUKU_BESAR, KODE_SUB_BANTU KD_SUB_BANTU, PUSPEL KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MERIT_PMS) + SUM(PEMBULATAN) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 2, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.07', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_TPP, 0, JUMLAH_TPP, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(MOBILITAS) JUMLAH_TPP FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 3, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.03.03', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_JABATAN, 0, JUMLAH_JABATAN, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(TELEPON) JUMLAH_JABATAN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                UNION ALL
                SELECT A.DEPARTEMEN_ID, '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '801.02.00', KODE_SUB_BANTU, PUSPEL, 'IDR', SYSDATE, 1, JUMLAH_PPH21, 0, JUMLAH_PPH21, 0, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.DEPARTEMEN A 
                INNER JOIN (SELECT DEPARTEMEN_ID, SUM(POTONGAN_PPH21) JUMLAH_PPH21 FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
                            GROUP BY A.DEPARTEMEN_ID ORDER BY DEPARTEMEN_ID ASC) C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                ) A ORDER BY A.DEPARTEMEN_ID ASC, A.NO_SEQ ASC
                ) A
                UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.05.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_LAIN, 0, JUMLAH_POTONGAN_LAIN, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_LAIN) JUMLAH_POTONGAN_LAIN FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." ) C 
                UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
                FROM (SELECT SUM(JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." ) C 
                UNION ALL
                SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH, 0, JUMLAH, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL FROM PPI_SIMPEG.BANK A 
                INNER JOIN (SELECT BANK, (SUM(JUMLAH_GAJI_KOTOR) + SUM(PEMBULATAN)) - (SUM(JUMLAH_POTONGAN_WAJIB) + SUM(JUMLAH_POTONGAN_LAIN)) JUMLAH FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." 
                            GROUP BY A.BANK) C ON A.NAMA = C.BANK
                ) A WHERE 1 = 1                        
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	


    function selectByParamsJurnalJKMDetil($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $periode="")
	{
	
	$str = "
                    SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00001' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 6) C         
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G1', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.06.00' KODE_BUKU_BESAR, '00001', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_TASPEN, 0, JUMLAH_IURAN_TASPEN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_TASPEN) JUMLAH_IURAN_TASPEN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G2', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.99.00' KODE_BUKU_BESAR, '00001', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_DANA_PENSIUN, 0, JUMLAH_DANA_PENSIUN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (DANA_PENSIUN) JUMLAH_DANA_PENSIUN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G3', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '791.99.00' KODE_BUKU_BESAR, '00001', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_KESEHATAN, 0, JUMLAH_IURAN_KESEHATAN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_KESEHATAN) JUMLAH_IURAN_KESEHATAN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G4', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '410.01.00' KODE_BUKU_BESAR, '00001', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_PPH21, 0, JUMLAH_POTONGAN_PPH21, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_PPH21) JUMLAH_POTONGAN_PPH21
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G5', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.11.00' KODE_BUKU_BESAR, '00001', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_ASURANSI_JIWASRAYA, 0, JUMLAH_ASURANSI_JIWASRAYA, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM(ASURANSI_JIWASRAYA) + SUM(BPJS_PESERTA) JUMLAH_ASURANSI_JIWASRAYA
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G6', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00001', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_PURNA_BAKTI, 0, JUMLAH_IURAN_PURNA_BAKTI, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_PURNA_BAKTI) JUMLAH_IURAN_PURNA_BAKTI
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G7', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.99.00' KODE_BUKU_BESAR, NO_KARTU, '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_DINAS, 0, JUMLAH_POTONGAN_DINAS, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT NO_KARTU, SUM (POTONGAN_DINAS) JUMLAH_POTONGAN_DINAS
                              FROM  PPI_GAJI.GAJI_AWAL_BULAN_REPORT A INNER JOIN PPI_GAJI.ASURANSI B ON A.KETERANGAN = B.KETERANGAN
                             WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 6  GROUP BY B.NO_KARTU) C
                    ) A WHERE  NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0 AND SALDO_RP_DEBET = 0 AND SALDO_RP_KREDIT = 0)
                    UNION ALL
                    SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'D1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00001' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 1) C         
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'J3', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.13.00' KODE_BUKU_BESAR, '00001', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, ASURANSI_JIWASRAYA, 0, ASURANSI_JIWASRAYA, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (ASURANSI_JIWASRAYA) ASURANSI_JIWASRAYA
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 1) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'J2', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.11.00' KODE_BUKU_BESAR, '00001', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_DANA_PENSIUN, 0, JUMLAH_DANA_PENSIUN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (DANA_PENSIUN) JUMLAH_DANA_PENSIUN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 1) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'J1', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '410.01.00' KODE_BUKU_BESAR, '00001', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_PPH21, 0, JUMLAH_POTONGAN_PPH21, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_PPH21) JUMLAH_POTONGAN_PPH21
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 1) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'J4', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00001', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, BPJS_PESERTA, 0, BPJS_PESERTA, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM(BPJS_PESERTA) BPJS_PESERTA
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND NVL(STATUS_BAYAR,0) = 0 AND JENIS_PEGAWAI_ID = 1) C
                    ) A WHERE  NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0 AND SALDO_RP_DEBET = 0 AND SALDO_RP_KREDIT = 0)
                    ORDER BY NO_SEQ    
 			   "; 
	
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalJKMDetilJanuari2014($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $periode="")
	{
	
	$str = "
                    SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6) C         
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G1', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.06.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_TASPEN, 0, JUMLAH_IURAN_TASPEN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_TASPEN) JUMLAH_IURAN_TASPEN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G2', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.99.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_DANA_PENSIUN, 0, JUMLAH_DANA_PENSIUN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (DANA_PENSIUN) JUMLAH_DANA_PENSIUN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G3', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '791.99.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_KESEHATAN, 0, JUMLAH_IURAN_KESEHATAN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_KESEHATAN) JUMLAH_IURAN_KESEHATAN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G4', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '410.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_PPH21, 0, JUMLAH_POTONGAN_PPH21, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_PPH21) JUMLAH_POTONGAN_PPH21
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G5', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.11.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_ASURANSI_JIWASRAYA, 0, JUMLAH_ASURANSI_JIWASRAYA, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (ASURANSI_JIWASRAYA) JUMLAH_ASURANSI_JIWASRAYA
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G6', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_PURNA_BAKTI, 0, JUMLAH_IURAN_PURNA_BAKTI, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_PURNA_BAKTI) JUMLAH_IURAN_PURNA_BAKTI
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6) C
                    ) A WHERE  NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0 AND SALDO_RP_DEBET = 0 AND SALDO_RP_KREDIT = 0)
                    UNION ALL
                    SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'B1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C         
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'H1', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.06.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_TASPEN, 0, JUMLAH_IURAN_TASPEN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_TASPEN) JUMLAH_IURAN_TASPEN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'H2', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.99.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_DANA_PENSIUN, 0, JUMLAH_DANA_PENSIUN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (DANA_PENSIUN) JUMLAH_DANA_PENSIUN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'H3', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '791.99.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_KESEHATAN, 0, JUMLAH_IURAN_KESEHATAN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_KESEHATAN) JUMLAH_IURAN_KESEHATAN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'H4', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '410.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_PPH21, 0, JUMLAH_POTONGAN_PPH21, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_PPH21) JUMLAH_POTONGAN_PPH21
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'H5', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.11.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_ASURANSI_JIWASRAYA, 0, JUMLAH_ASURANSI_JIWASRAYA, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (ASURANSI_JIWASRAYA) JUMLAH_ASURANSI_JIWASRAYA
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'H6', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_PURNA_BAKTI, 0, JUMLAH_IURAN_PURNA_BAKTI, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_PURNA_BAKTI) JUMLAH_IURAN_PURNA_BAKTI
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C
                    ) A WHERE  NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0 AND SALDO_RP_DEBET = 0 AND SALDO_RP_KREDIT = 0)
                    UNION ALL
                    SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'C1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C         
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'I1', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.06.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_TASPEN, 0, JUMLAH_IURAN_TASPEN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_TASPEN) JUMLAH_IURAN_TASPEN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'I2', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.99.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_DANA_PENSIUN, 0, JUMLAH_DANA_PENSIUN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (DANA_PENSIUN) JUMLAH_DANA_PENSIUN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'I3', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '791.99.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_KESEHATAN, 0, JUMLAH_IURAN_KESEHATAN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_KESEHATAN) JUMLAH_IURAN_KESEHATAN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'I4', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '410.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_PPH21, 0, JUMLAH_POTONGAN_PPH21, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_PPH21) JUMLAH_POTONGAN_PPH21
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'I5', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.11.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_ASURANSI_JIWASRAYA, 0, JUMLAH_ASURANSI_JIWASRAYA, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (ASURANSI_JIWASRAYA) JUMLAH_ASURANSI_JIWASRAYA
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'I6', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_PURNA_BAKTI, 0, JUMLAH_IURAN_PURNA_BAKTI, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_PURNA_BAKTI) JUMLAH_IURAN_PURNA_BAKTI
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C
					UNION ALL
                    SELECT '96', 'NO_NOTA', 'I6', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_DINAS, 0, JUMLAH_POTONGAN_DINAS, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_DINAS) JUMLAH_POTONGAN_DINAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C
                    ) A WHERE  NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0 AND SALDO_RP_DEBET = 0 AND SALDO_RP_KREDIT = 0)                    
                    UNION ALL
                    SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'E1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C         
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'K1', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.06.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_TASPEN, 0, JUMLAH_IURAN_TASPEN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_TASPEN) JUMLAH_IURAN_TASPEN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'K2', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.99.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_DANA_PENSIUN, 0, JUMLAH_DANA_PENSIUN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (DANA_PENSIUN) JUMLAH_DANA_PENSIUN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'K3', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '791.99.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_KESEHATAN, 0, JUMLAH_IURAN_KESEHATAN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_KESEHATAN) JUMLAH_IURAN_KESEHATAN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'K4', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '410.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_PPH21, 0, JUMLAH_POTONGAN_PPH21, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_PPH21) JUMLAH_POTONGAN_PPH21
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'K5', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.11.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_ASURANSI_JIWASRAYA, 0, JUMLAH_ASURANSI_JIWASRAYA, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (ASURANSI_JIWASRAYA) JUMLAH_ASURANSI_JIWASRAYA
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'K6', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_PURNA_BAKTI, 0, JUMLAH_IURAN_PURNA_BAKTI, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_PURNA_BAKTI) JUMLAH_IURAN_PURNA_BAKTI
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C
                    ) A WHERE  NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0 AND SALDO_RP_DEBET = 0 AND SALDO_RP_KREDIT = 0)
                    UNION ALL
                    SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'F1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3) C         
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'Z1', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.06.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_TASPEN, 0, JUMLAH_IURAN_TASPEN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_TASPEN) JUMLAH_IURAN_TASPEN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'Z2', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.99.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_DANA_PENSIUN, 0, JUMLAH_DANA_PENSIUN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (DANA_PENSIUN) JUMLAH_DANA_PENSIUN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'Z3', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '791.99.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_KESEHATAN, 0, JUMLAH_IURAN_KESEHATAN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_KESEHATAN) JUMLAH_IURAN_KESEHATAN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'Z4', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '410.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_PPH21, 0, JUMLAH_POTONGAN_PPH21, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_PPH21) JUMLAH_POTONGAN_PPH21
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'Z5', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.11.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_ASURANSI_JIWASRAYA, 0, JUMLAH_ASURANSI_JIWASRAYA, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (ASURANSI_JIWASRAYA) JUMLAH_ASURANSI_JIWASRAYA
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'Z6', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_PURNA_BAKTI, 0, JUMLAH_IURAN_PURNA_BAKTI, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_PURNA_BAKTI) JUMLAH_IURAN_PURNA_BAKTI
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3) C
                    ) A WHERE  NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0 AND SALDO_RP_DEBET = 0 AND SALDO_RP_KREDIT = 0)
                    ORDER BY NO_SEQ    
 			   "; 
	
	/*
		$str = "
				SELECT KD_CABANG, NO_NOTA,
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SUM(SALDO_VAL_DEBET) SALDO_VAL_DEBET, SUM(SALDO_VAL_KREDIT) SALDO_VAL_KREDIT, 
                                       SUM(SALDO_RP_DEBET) SALDO_RP_DEBET, SUM(SALDO_RP_KREDIT) SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM (
                    SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'A1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6) C         
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G1', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.06.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_TASPEN, 0, JUMLAH_IURAN_TASPEN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_TASPEN) JUMLAH_IURAN_TASPEN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G2', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.99.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_DANA_PENSIUN, 0, JUMLAH_DANA_PENSIUN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (DANA_PENSIUN) JUMLAH_DANA_PENSIUN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G3', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '791.99.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_KESEHATAN, 0, JUMLAH_IURAN_KESEHATAN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_KESEHATAN) JUMLAH_IURAN_KESEHATAN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G4', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '410.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_PPH21, 0, JUMLAH_POTONGAN_PPH21, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_PPH21) JUMLAH_POTONGAN_PPH21
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL

                    SELECT '96', 'NO_NOTA', 'G5', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.11.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_ASURANSI_JIWASRAYA, 0, JUMLAH_ASURANSI_JIWASRAYA, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (ASURANSI_JIWASRAYA) JUMLAH_ASURANSI_JIWASRAYA
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'G6', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_PURNA_BAKTI, 0, JUMLAH_IURAN_PURNA_BAKTI, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_PURNA_BAKTI) JUMLAH_IURAN_PURNA_BAKTI
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 6) C
                    ) A WHERE  NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0 AND SALDO_RP_DEBET = 0 AND SALDO_RP_KREDIT = 0)
                    UNION ALL
                    SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'B1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C         
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'H1', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.06.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_TASPEN, 0, JUMLAH_IURAN_TASPEN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_TASPEN) JUMLAH_IURAN_TASPEN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'H2', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.99.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_DANA_PENSIUN, 0, JUMLAH_DANA_PENSIUN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (DANA_PENSIUN) JUMLAH_DANA_PENSIUN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'H3', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '791.99.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_KESEHATAN, 0, JUMLAH_IURAN_KESEHATAN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_KESEHATAN) JUMLAH_IURAN_KESEHATAN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'H4', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '410.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_PPH21, 0, JUMLAH_POTONGAN_PPH21, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_PPH21) JUMLAH_POTONGAN_PPH21
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'H5', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.11.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_ASURANSI_JIWASRAYA, 0, JUMLAH_ASURANSI_JIWASRAYA, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (ASURANSI_JIWASRAYA) JUMLAH_ASURANSI_JIWASRAYA
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'H6', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_PURNA_BAKTI, 0, JUMLAH_IURAN_PURNA_BAKTI, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_PURNA_BAKTI) JUMLAH_IURAN_PURNA_BAKTI
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 7) C
                    ) A WHERE  NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0 AND SALDO_RP_DEBET = 0 AND SALDO_RP_KREDIT = 0)
                    UNION ALL
                    SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'C1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C         
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'I1', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.06.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_TASPEN, 0, JUMLAH_IURAN_TASPEN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_TASPEN) JUMLAH_IURAN_TASPEN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'I2', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.99.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_DANA_PENSIUN, 0, JUMLAH_DANA_PENSIUN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (DANA_PENSIUN) JUMLAH_DANA_PENSIUN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'I3', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '791.99.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_KESEHATAN, 0, JUMLAH_IURAN_KESEHATAN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_KESEHATAN) JUMLAH_IURAN_KESEHATAN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'I4', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '410.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_PPH21, 0, JUMLAH_POTONGAN_PPH21, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_PPH21) JUMLAH_POTONGAN_PPH21
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'I5', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.11.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_ASURANSI_JIWASRAYA, 0, JUMLAH_ASURANSI_JIWASRAYA, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (ASURANSI_JIWASRAYA) JUMLAH_ASURANSI_JIWASRAYA
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'I6', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_PURNA_BAKTI, 0, JUMLAH_IURAN_PURNA_BAKTI, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_PURNA_BAKTI) JUMLAH_IURAN_PURNA_BAKTI
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C
					UNION ALL
                    SELECT '96', 'NO_NOTA', 'I6', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_DINAS, 0, JUMLAH_POTONGAN_DINAS, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_DINAS) JUMLAH_POTONGAN_DINAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 2) C
                    ) A WHERE  NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0 AND SALDO_RP_DEBET = 0 AND SALDO_RP_KREDIT = 0)
                    UNION ALL
                    SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'D1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 1) C         
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'J1', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.06.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_TASPEN, 0, JUMLAH_IURAN_TASPEN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_TASPEN) JUMLAH_IURAN_TASPEN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 1) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'J2', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.99.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_DANA_PENSIUN, 0, JUMLAH_DANA_PENSIUN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (DANA_PENSIUN) JUMLAH_DANA_PENSIUN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 1) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'J3', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '791.99.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_KESEHATAN, 0, JUMLAH_IURAN_KESEHATAN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_KESEHATAN) JUMLAH_IURAN_KESEHATAN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 1) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'J4', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '410.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_PPH21, 0, JUMLAH_POTONGAN_PPH21, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_PPH21) JUMLAH_POTONGAN_PPH21
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 1) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'J5', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.11.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_ASURANSI_JIWASRAYA, 0, JUMLAH_ASURANSI_JIWASRAYA, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (ASURANSI_JIWASRAYA) JUMLAH_ASURANSI_JIWASRAYA
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 1) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'J6', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_PURNA_BAKTI, 0, JUMLAH_IURAN_PURNA_BAKTI, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_PURNA_BAKTI) JUMLAH_IURAN_PURNA_BAKTI
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 1) C
                    ) A WHERE  NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0 AND SALDO_RP_DEBET = 0 AND SALDO_RP_KREDIT = 0)
                    UNION ALL
                    SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'E1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C         
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'K1', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.06.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_TASPEN, 0, JUMLAH_IURAN_TASPEN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_TASPEN) JUMLAH_IURAN_TASPEN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'K2', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.99.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_DANA_PENSIUN, 0, JUMLAH_DANA_PENSIUN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (DANA_PENSIUN) JUMLAH_DANA_PENSIUN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'K3', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '791.99.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_KESEHATAN, 0, JUMLAH_IURAN_KESEHATAN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_KESEHATAN) JUMLAH_IURAN_KESEHATAN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'K4', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '410.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_PPH21, 0, JUMLAH_POTONGAN_PPH21, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_PPH21) JUMLAH_POTONGAN_PPH21
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'K5', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.11.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_ASURANSI_JIWASRAYA, 0, JUMLAH_ASURANSI_JIWASRAYA, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (ASURANSI_JIWASRAYA) JUMLAH_ASURANSI_JIWASRAYA
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'K6', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_PURNA_BAKTI, 0, JUMLAH_IURAN_PURNA_BAKTI, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_PURNA_BAKTI) JUMLAH_IURAN_PURNA_BAKTI
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 5) C
                    ) A WHERE  NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0 AND SALDO_RP_DEBET = 0 AND SALDO_RP_KREDIT = 0)
                    UNION ALL
                    SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                                       SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK FROM 
                    (                   
                    SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 'F1' NO_SEQ, 'KBB' KD_SUBSIS, 'JKM' KD_JURNAL, 'JKM-KBB-01' TIPE_TRANS, NULL KLAS_TRANS,
                           '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, '000.00.00' KD_BUKU_PUSAT, 'IDR' KD_VALUTA,
                           SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH_POTONGAN_KAS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH_POTONGAN_KAS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS,
                           NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKM' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK
                      FROM (SELECT SUM (JUMLAH_POTONGAN_WAJIB) JUMLAH_POTONGAN_KAS
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3) C         
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'Z1', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.06.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_TASPEN, 0, JUMLAH_IURAN_TASPEN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_TASPEN) JUMLAH_IURAN_TASPEN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'Z2', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.99.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_DANA_PENSIUN, 0, JUMLAH_DANA_PENSIUN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (DANA_PENSIUN) JUMLAH_DANA_PENSIUN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'Z3', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '791.99.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_KESEHATAN, 0, JUMLAH_IURAN_KESEHATAN, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_KESEHATAN) JUMLAH_IURAN_KESEHATAN
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'Z4', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '410.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_POTONGAN_PPH21, 0, JUMLAH_POTONGAN_PPH21, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (POTONGAN_PPH21) JUMLAH_POTONGAN_PPH21
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'Z5', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.11.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_ASURANSI_JIWASRAYA, 0, JUMLAH_ASURANSI_JIWASRAYA, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (ASURANSI_JIWASRAYA) JUMLAH_ASURANSI_JIWASRAYA
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3) C
                    UNION ALL
                    SELECT '96', 'NO_NOTA', 'Z6', 'KBB', 'JKM', 'JKM-KBB-01', NULL,
                           '404.12.00' KODE_BUKU_BESAR, '00002', '000.00.00' PUSPEL, 'IDR',
                           SYSDATE, 1, 0, JUMLAH_IURAN_PURNA_BAKTI, 0, JUMLAH_IURAN_PURNA_BAKTI, NULL, NULL,
                           NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKM', '', '', '', NULL
                      FROM (SELECT SUM (IURAN_PURNA_BAKTI) JUMLAH_IURAN_PURNA_BAKTI
                              FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A
                             WHERE PERIODE = '".$periode."' AND JENIS_PEGAWAI_ID = 3) C
                    ) A WHERE  NOT (SALDO_VAL_DEBET = 0 AND SALDO_VAL_KREDIT = 0 AND SALDO_RP_DEBET = 0 AND SALDO_RP_KREDIT = 0)
                    ORDER BY NO_SEQ ) GROUP BY KD_CABANG, NO_NOTA,
                                       KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                                       KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
                                       KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                                       KURS_VALUTA, 
                                       KET_TAMBAH, 
                                       TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
                                       LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
                                       REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK
                                       order by 14
 			   ";  */
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
			
    function selectByParamsMilReport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				PENUGASAN_ID, PEGAWAI_KAPAL_HISTORI_ID, PEGAWAI_ID, 
				   KAPAL_ID, TANGGAL_MASUK, NRP, 
				   NIPP, NAMA, JABATAN, 
				   KRU_JABATAN_ID, JUMLAH_MIL
				FROM PPI_GAJI.UANG_MIL_REPORT
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
	
    function selectByParamsPotonganReport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
		$str = "
				SELECT 
				PEGAWAI_ID, JENIS_PEGAWAI_ID, NRP, 
				   NAMA, ANGSURAN_TERBAYAR, JUMLAH, 
				   KETERANGAN, PERIODE, ANGSURAN, 
				   BANK, LAIN_KONDISI_ID
				FROM PPI_GAJI.POTONGAN_LAIN_REPORT 
				WHERE 1 = 1 AND  PERIODE  = '".$periode."'
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

    function selectByParamsAsuransiReport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
		$str = "
				SELECT 
				PEGAWAI_ID, JENIS_PEGAWAI_ID, NRP, 
				   NAMA, JUMLAH, 
				   PERIODE, 
				   POTONGAN
				FROM PPI_GAJI.ASURANSI_REPORT 
				WHERE 1 = 1 AND  PERIODE  = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
//		echo $str;
	//	exit;
		return $this->selectLimit($str,$limit,$from); 
    }		
	
    function selectByParamsPotonganReportExcel($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
		$str = "
				SELECT 
				PEGAWAI_ID, JENIS_PEGAWAI_ID, NRP, 
				   NAMA, PERIODE, ARISAN_PERISPINDO, 
				   POTONGAN
				FROM PPI_GAJI.POTONGAN_REPORT	
				WHERE 1 = 1
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
	
    function selectByParamsDaftarPengantarBankReport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
		$str = "
				SELECT 
				PEGAWAI_ID, NAMA, NRP, 
				   KELAS, JABATAN, GAJI_POKOK, 
				   PANGKAT, STATUS_KELUARGA, DEPARTEMEN, 
				   REKENING_NO, REKENING_NAMA, NPWP, MASA_KERJA_TAHUN, 
				   MASA_KERJA_BULAN, PERIODE, MERIT_PMS, 
				   TUNJANGAN_PERBANTUAN, TUNJANGAN_JABATAN, TPP_PMS, 
				   IURAN_TASPEN, DANA_PENSIUN, IURAN_KESEHATAN, 
				   SUMBANGAN_MASJID, ASURANSI_JIWASRAYA, ARISAN_PERISPINDO, 
				   IURAN_SPPI, IURAN_PURNA_BAKTI, BNI, 
				   BUKOPIN, BRI, BTN, 
				   BPD, SIMPANAN_WAJIB_KOPERASI, SIMPANAN_WAJIB_KOPERASI_3LAUT, 
				   MITRA_KARYA_ANGGOTA, INFAQ, KOPERASI, 
				   POTONGAN_LAIN, KOPERASI_PMS, POTONGAN_PPH21, 
				   POTONGAN_DINAS, JENIS_PEGAWAI_ID, HARI_KERJA, 
				   JUMLAH_UANG_MAKAN, JUMLAH_TRANSPORTASI, DANA_PENSIUN_BULANAN, 
				   BANK, KOTA, CABANG, 
				   DEPARTEMEN_ID, TANGGAL_MASUK, TEMPAT_LAHIR, 
				   TANGGAL_LAHIR, NO_URUT, PUSPEL, 
				   MOBILITAS, PERUMAHAN, BBM, 
				   TELEPON, UANG_KEHADIRAN, UANG_TRANSPORT, 
				   UANG_MAKAN, ASAL_PERUSAHAAN, BPJS_PESERTA, UANG_TRANSPORT, UANG_MAKAN, UANG_INSENTIF
				FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT				
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		//exit;
		return $this->selectLimit($str,$limit,$from); 
    }		
	
    function selectByParamsDaftarJamsostek($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				A.PEGAWAI_ID, NRP, KPJ, 
				   NAMA, KAWIN, TGL_LAHIR, 
				   PERIODE, UPAH_TK, RAPEL_UPAH_TK,
				   CASE WHEN RAPEL_UPAH_TK < (SELECT NILAI FROM PPI.SETTING_APLIKASI WHERE KODE = 'GAJI_UMR_SURABAYA') 
				   		THEN TO_NUMBER ((SELECT NILAI FROM PPI.SETTING_APLIKASI WHERE KODE = 'GAJI_UMR_SURABAYA')) 
				   		ELSE RAPEL_UPAH_TK END UPAH_REVISI,
				   /*
				   CASE WHEN JENIS_PEGAWAI_ID IN (2,6,7) THEN UPAH_TK 
				    	WHEN RAPEL_UPAH_TK < (SELECT NILAI FROM PPI.SETTING_APLIKASI WHERE KODE = 'GAJI_UMR_SURABAYA') AND RAPEL_UPAH_TK <> 0
                        THEN  TO_NUMBER ((SELECT NILAI FROM PPI.SETTING_APLIKASI WHERE KODE = 'GAJI_UMR_SURABAYA')) 
                        ELSE RAPEL_UPAH_TK END AS RAPEL_UPAH_TK ,
                    */
				   JHT, JHT_PEG, JKM, JKK, 
				   JPK, IURAN, KETERANGAN, 
				   BULANTAHUN, JENIS_PEGAWAI_ID, DEPARTEMEN, DEPARTEMEN_ID
				FROM PPI_GAJI.DAFTAR_IURAN_JAMSOSTEK A
					/*INNER JOIN PPI_GAJI.POTONGAN_KONDISI_PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND B.POTONGAN_KONDISI_ID LIKE '11%' */
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsDaftarBPJS($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT   A.PEGAWAI_ID,
						 NRP,
						 NAMA,
						 KAWIN,
						 TGL_LAHIR,
						 JENIS_PEGAWAI_ID,
						 DEPARTEMEN_ID,
						 DEPARTEMEN,
						 BULANTAHUN,
						 UPAH_TK,
						 CASE WHEN UPAH_TK < (SELECT NILAI FROM PPI.SETTING_APLIKASI WHERE KODE = 'GAJI_UMR_SURABAYA') AND UPAH_TK <> 0
	                        THEN  TO_NUMBER ((SELECT NILAI FROM PPI.SETTING_APLIKASI WHERE KODE = 'GAJI_UMR_SURABAYA')) 
	                        ELSE UPAH_TK END AS UPAH_BERSIH ,
						 JPK_PERUSAHAAN,
						 JPK_PESERTA,
						 IURAN,
						 KETERANGAN
				  FROM   PPI_GAJI.DAFTAR_IURAN_BPJS A
					INNER JOIN PPI_GAJI.POTONGAN_KONDISI_PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND B.POTONGAN_KONDISI_ID LIKE '18%'
				  WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;		exit;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	function selectByParamsDaftarBPJSRekap($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT   
					 DEPARTEMEN,BULANTAHUN, SUM(JPK_PERUSAHAAN) JPK_PERUSAHAAN, SUM(JPK_PESERTA) JPK_PESERTA, 
					 SUM(IURAN) IURAN
				FROM   PPI_GAJI.DAFTAR_IURAN_BPJS A 
				INNER JOIN PPI_GAJI.POTONGAN_KONDISI_PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND B.POTONGAN_KONDISI_ID LIKE '18%'
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement. " GROUP BY DEPARTEMEN, BULANTAHUN ".$order;
		$this->query = $str;
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsDaftarTaspen($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				NRP, NAMA, TEMPAT_LAHIR, 
				   TANGGAL_LAHIR, GOLONGAN, PANGKAT, 
				   KODE, GAJI_POKOK, PROSENTASE_1, 
				   PROSENTASE_2, PROSENTASE_3, GAJI_KOTOR, 
				   IURAN_TASPEN, PERIODE, DEPARTEMEN, DEPARTEMEN_ID
				FROM PPI_GAJI.IURAN_TASPEN_REPORT WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }			

    function selectByParamsDaftarIuranPurnaBakti($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
					NRP, NAMA, IURAN_PURNA_BAKTI, 
					   PERIODE
					FROM PPI_GAJI.IURAN_PURNA_BAKTI_REPORT WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }				

    function selectByParamsDaftarDanaPensiun($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
					NRP, NAMA, DANA_PENSIUN, 
					   PERIODE
					FROM PPI_GAJI.DANA_PENSIUN_REPORT WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }			

    function selectByParamsRekap($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
					PEGAWAI_ID, NAMA, JABATAN, 
					KELAS, NRP, GAJI_POKOK, 
					PANGKAT, STATUS_KELUARGA, KAPAL_ID, 
					DEPARTEMEN, REKENING_NO, REKENING_NAMA, 
					MASA_KERJA_TAHUN, MASA_KERJA_BULAN, PERIODE, 
					JUMLAH_JAM_MENGAJAR, JUMLAH_JAM_LEBIH, TARIF_MENGAJAR, 
					TARIF_LEBIH, TOTAL_TUNJANGAN_PRESENSI, MERIT_PMS, 
					TUNJANGAN_JABATAN, TUNJANGAN_PRESTASI, TUNJANGAN_PERALIHAN, 
					TUNJANGAN_SINOMAN, TUNJANGAN_PPH21, TUNJANGAN_KINERJA, 
					TUNJANGAN_MASA_KERJA, KELEBIHAN_JAM_MENGAJAR, JUMLAH_GAJI_KOTOR, 
					JUMLAH_POTONGAN_WAJIB, PEMBULATAN, POTONGAN_SINOMAN, 
					POTONGAN_TUNJANGAN_PRESTASI, JENIS_PEGAWAI_ID, HARI_KERJA, 
					JUMLAH_UANG_MAKAN, JUMLAH_TRANSPORTASI, DANA_PENSIUN_BULANAN, 
					BANK, KOTA, CABANG, 
					DEPARTEMEN_ID, TANGGAL_MASUK, NO_URUT, 
					PUSPEL, ASAL_PERUSAHAAN, KETERANGAN, 
					ASURANSI_NAMA, STATUS_BAYAR, STATUS_CALPEG,
					CASE WHEN STATUS_CALPEG = 'Y' THEN 'Calpeg' ELSE 'Pegawai' END STATUS_CALPEG_DESC,
					'' TUGAS_MENGAJAR
				FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT A 
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

    function selectByParamsSlipGaji($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT A.PEGAWAI_ID, B.JENIS_PEGAWAI_ID, 
                       B.NRP, B.NAMA, MASA_KERJA, DEPARTEMEN, 
                       BULANTAHUN, B.KELAS, B.JABATAN,
                       GAJI_JSON, SUMBANGAN_JSON, POTONGAN_LAIN_JSON, POTONGAN_JSON, TANGGUNGAN_JSON, 
                       B.REKENING_NO, CASE WHEN UPPER(C.NAMA) = 'YAYASAN' THEN 'KUPP Barunawati' ELSE C.NAMA END DEPARTEMEN_NAMA
                FROM PPI_GAJI.GAJI_AWAL_BULAN A 
                INNER JOIN PPI_GAJI.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND A.BULANTAHUN = B.PERIODE
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN C ON B.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		//echo $str;
		$this->query = $str;

		return $this->selectLimit($str,$limit,$from); 
    }
	
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT A.PEGAWAI_ID, A.NAMA, A.DEPARTEMEN_ID, BULANTAHUN, KELAS, PERIODE, STATUS_BAYAR, GAJI_JSON
                FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_GAJI.GAJI_AWAL_BULAN B 
                ON A.PEGAWAI_ID = B.PEGAWAI_ID
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

    function getCountByParamsPotonganReport($paramsArray=array(),$statement="", $periode="")
	{
		$str = "
				SELECT COUNT(PEGAWAI_ID) ROWCOUNT
				FROM PPI_GAJI.POTONGAN_LAIN_REPORT 
				WHERE 1 = 1 AND  PERIODE  = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsAsuransiReport($paramsArray=array(),$statement="", $periode="")
	{
		$str = "
				SELECT COUNT(PEGAWAI_ID) ROWCOUNT
				FROM PPI_GAJI.ASURANSI_REPORT 
				WHERE 1 = 1 AND  PERIODE  = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	
		
    function getCountByParams($paramsArray=array(), $statement="", $periode="", $jenis_pegawai_id="", $status_pegawai_id="1,2,3,4,5")
	{
		// $str = "SELECT COUNT(C.PEGAWAI_ID) AS ROWCOUNT 
		// FROM PPI_GAJI.GAJI_AWAL_BULAN C 
		// INNER JOIN PPI_SIMPEG.PEGAWAI A ON A.PEGAWAI_ID = C.PEGAWAI_ID AND BULANTAHUN = '".$periode."'  AND A.STATUS_PEGAWAI_ID IN (".$status_pegawai_id.") 
		// INNER JOIN (SELECT X.PEGAWAI_ID, PPI_SIMPEG.AMBIL_JENIS_PEGAWAI_PERIODE('".$periode."', X.PEGAWAI_ID) JENIS_PEGAWAI_ID FROM PPI_SIMPEG.PEGAWAI X) B ON B.PEGAWAI_ID = C.PEGAWAI_ID WHERE 1 = 1  ".$statement;

		$str = "SELECT COUNT(C.PEGAWAI_ID) AS ROWCOUNT
				FROM PPI_GAJI.GAJI_AWAL_BULAN B 
					 INNER JOIN PPI_GAJI.PEGAWAI A ON A.PEGAWAI_ID = B.PEGAWAI_ID AND A.STATUS_PEGAWAI_ID IN (".$status_pegawai_id.") AND A.PERIODE = B.BULANTAHUN
					 INNER JOIN PPI_GAJI.GAJI_AWAL_BULAN_REPORT C ON B.BULANTAHUN = C.PERIODE AND B.PEGAWAI_ID = C.PEGAWAI_ID 
				WHERE 1 = 1 AND BULANTAHUN = '".$periode."'".$statement;

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
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI A WHERE 1 = 1 "; 
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
	
	function selectByParamsPengantarBankBNIHeader($statement="", $limit=-1,$from=-1)
	{
		$str = "
				SELECT TO_CHAR(sysdate,'dd/mm/yyyy hh24:mi:ss') TANGGAL_BUAT, count(nama) TOTAL, sum(jumlah_kotor - jumlah_potongan - jumlah_lain_lain) SUM_GAJI, SUM(substr(REKENING_NO, -4)) CEK_AKUN FROM (
SELECT NAMA, REKENING_NO, BANK, (BNI + BUKOPIN + BRI + BTN + BPD + SIMPANAN_WAJIB_KOPERASI + MITRA_KARYA_ANGGOTA + INFAQ + KOPERASI +  POTONGAN_LAIN) JUMLAH_LAIN_LAIN,
(IURAN_TASPEN + DANA_PENSIUN + IURAN_KESEHATAN + POTONGAN_PPH21 + SUMBANGAN_MASJID + ASURANSI_JIWASRAYA + ARISAN_PERISPINDO + IURAN_SPPI + IURAN_PURNA_BAKTI + POTONGAN_DINAS + BPJS_PESERTA) jumlah_potongan,
(MERIT_PMS + POTONGAN_PPH21 + TUNJANGAN_PERBANTUAN + TUNJANGAN_JABATAN + TPP_PMS + MOBILITAS + TELEPON + BBM + PERUMAHAN) jumlah_kotor
                FROM PPI_GAJI.GAJI_AWAL_BULAN_REPORT a
                WHERE 1 = 1
                ".$statement."
                )
			"; 
		
		$this->query = $str;
		//echo $str;
		//exit;
		return $this->selectLimit($str,-1,-1); 
    }
	

	function replaceSpecialCharacter($strVariable="")
	{
		$strRestrict = array(",", "`", "~", "!", "@", "#", "$", "%", "^", "&", "*", "_", "{", "}", "<", ">", "[", "]", "=", "\\", ";", "'");
		$result = str_replace($strRestrict, " ", $strVariable);
		return $result;
	}
	
	function getCountByParamsSlipGaji($paramsArray=array(),$statement="")
	{
		$str = "
				SELECT COUNT(1) AS ROWCOUNT
                FROM PPI_GAJI.GAJI_AWAL_BULAN A 
                INNER JOIN PPI_GAJI.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND A.BULANTAHUN = B.PERIODE
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                WHERE 1 = 1
			".$statement; 
		
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