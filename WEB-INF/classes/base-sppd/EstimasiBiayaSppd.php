<? 
/* *******************************************************************************************************
MODUL NAME 			: PPI
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel PANGKAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class EstimasiBiayaSppd extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function EstimasiBiayaSppd()
	{
      $this->Entity(); 
    }

	function callEstimasiSppd()
	{
		$str = " CALL PPI_SPPD.ESTIMASI_SPPD(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }		

	function callEstimasiSppdDuaTujuan()
	{
		$str = " CALL PPI_SPPD.ESTIMASI_SPPD_DUA_TUJUAN(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }		

	function callEstimasiSppdDidikLatih()
	{
		$str = " CALL PPI_SPPD.ESTIMASI_SPPD_DIDIK_LATIH(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callEstimasiSppdStJabatan()
	{
		$str = " CALL PPI_SPPD.ESTIMASI_SPPD_ST_JABATAN(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callEstimasiSppdSementara()
	{
		$str = " CALL PPI_SPPD.ESTIMASI_SPPD_DETASERING(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callEstimasiSppdSementaraExt()
	{
		$str = " CALL PPI_SPPD.ESTIMASI_SPPD_DETASERING_EXT(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callEstimasiSppdKonsinyering()
	{
		$str = " CALL PPI_SPPD.ESTIMASI_SPPD_KONSINYERING(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callEstimasiSppdAwakKapal()
	{
		$str = " CALL PPI_SPPD.ESTIMASI_SPPD_AWAK_KAPAL(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }	

	function callEstimasiSppdAngkutBarang()
	{
		$str = " CALL PPI_SPPD.ESTIMASI_SPPD_ANGKUT_BARANG(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }	

	function callEstimasiSppdKunjungan()
	{
		$str = " CALL PPI_SPPD.ESTIMASI_SPPD_KUNJUNGAN(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }	
	

	function callEstimasiSppdDinasPindah()
	{
		$str = " CALL PPI_SPPD.ESTIMASI_SPPD_PINDAH(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }	

	function callRealisasiSppd()
	{
		$str = " CALL PPI_SPPD.REALISASI_SPPD(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }		

	function callRealisasiSppdDuaTujuan()
	{
		$str = " CALL PPI_SPPD.REALISASI_SPPD_DUA_TUJUAN(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }		

	function callRealisasiSppdDidikLatih()
	{
		$str = " CALL PPI_SPPD.REALISASI_SPPD_DIDIK_LATIH(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callRealisasiSppdStJabatan()
	{
		$str = " CALL PPI_SPPD.REALISASI_SPPD_ST_JABATAN(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callRealisasiSppdSementara()
	{
		$str = " CALL PPI_SPPD.REALISASI_SPPD_DETASERING(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callRealisasiSppdSementaraExt()
	{
		$str = " CALL PPI_SPPD.REALISASI_SPPD_DETASERING_EXT(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callRealisasiSppdKonsinyering()
	{
		$str = " CALL PPI_SPPD.REALISASI_SPPD_KONSINYERING(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callRealisasiSppdAwakKapal()
	{
		$str = " CALL PPI_SPPD.REALISASI_SPPD_AWAK_KAPAL(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }	

	function callRealisasiSppdAngkutBarang()
	{
		$str = " CALL PPI_SPPD.REALISASI_SPPD_ANGKUT_BARANG(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }	

	function callRealisasiSppdKunjungan()
	{
		$str = " CALL PPI_SPPD.REALISASI_SPPD_KUNJUNGAN(".$this->getField("SPPD_ID").") ";
		
		$this->query = $str;
        return $this->execQuery($str);
    }	
	

	function callRealisasiSppdDinasPindah()
	{
		$str = " CALL PPI_SPPD.REALISASI_SPPD_PINDAH(".$this->getField("SPPD_ID").") ";
		
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT 
                    A.SPPD_ID, A.PEGAWAI_ID, B.NAMA, BIAYA_JSON, 
                       A.LAMA_PERJALANAN, C.JENIS_SPPD_ID
                    FROM PPI_SPPD.ESTIMASI_BIAYA_SPPD A
                    INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                    INNER JOIN PPI_SPPD.SPPD C ON A.SPPD_ID = C.SPPD_ID
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

    function selectKirimJurnalSemua($reqId)
	{
		$str = "SELECT (SELECT NVL(SUM(JUMLAH), 0) FROM PPI_SPPD.SPPD_BIAYA_DEPARTEMEN WHERE SPPD_ID = '".$reqId."') + 
					   (SELECT NVL(SUM(JUMLAH), 0) FROM PPI_SPPD.SPPD_BIAYA_KAPAL WHERE SPPD_ID = '".$reqId."') JUMLAH  
				FROM DUAL
				"; 
		
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

    function selectKirimJurnalDetil($reqId)
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
							   CASE WHEN B.KODE = 'AUTO' THEN CASE WHEN A.DEPARTEMEN_ID = '77' THEN '808.01.02' ELSE '808.01.01' END ELSE B.KODE END KD_BUKU_BESAR, 
							   CASE WHEN B.KODE_KARTU = 'AUTO' THEN '00000' ELSE B.KODE_KARTU END KD_SUB_BANTU, 
							   CASE WHEN B.KODE_PUSAT = 'AUTO' THEN PUSPEL ELSE B.KODE_PUSAT END  KD_BUKU_PUSAT, 'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, 
							   JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, 
							   NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK 
							   FROM PPI_SIMPEG.DEPARTEMEN A 
						RIGHT JOIN (SELECT DEPARTEMEN_ID, KODE, KODE_KARTU, KODE_PUSAT, SUM(JUMLAH) JUMLAH FROM PPI_SPPD.SPPD_BIAYA_DEPARTEMEN A WHERE SPPD_ID = '".$reqId."' AND JUMLAH IS NOT NULL
									GROUP BY A.DEPARTEMEN_ID, KODE, KODE_KARTU, KODE_PUSAT ORDER BY DEPARTEMEN_ID ASC) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID                                                                                    
									) A                
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
					   SELECT '96' KD_CABANG, 'NO_NOTA' NO_NOTA, 1 NO_SEQ, 'KBB' KD_SUBSIS, 'JKK' KD_JURNAL, 'JKK-KBB-01' TIPE_TRANS, NULL KLAS_TRANS, 
					   CASE WHEN B.KODE = 'AUTO' THEN '808.01.01' ELSE B.KODE END KD_BUKU_BESAR, 
					   CASE WHEN B.KODE_KARTU = 'AUTO' THEN A.NO_KARTU ELSE B.KODE_KARTU END KD_SUB_BANTU, 
					   CASE WHEN B.KODE_PUSAT = 'AUTO' THEN PUSPEL ELSE B.KODE_PUSAT END  KD_BUKU_PUSAT, 
					   'IDR' KD_VALUTA, SYSDATE TGL_VALUTA, 1 KURS_VALUTA, JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NULL KET_TAMBAH, NULL TANDA_TRANS, NULL KD_AKTIF, SYSDATE LAST_UPDATE_DATE, 'AKUNTANSI_PMS' LAST_UPDATED_BY, 'KBB_ENTRY_JUR_JKK' PROGRAM_NAME, '' PREV_NO_NOTA, '' REF_NOTA_JUAL_BELI, '' BAYAR_VIA, NULL STATUS_KENA_PAJAK 
					   FROM PPI_OPERASIONAL.KAPAL A 
						INNER JOIN (SELECT KAPAL_ID, KODE, KODE_KARTU, KODE_PUSAT, SUM(JUMLAH) JUMLAH FROM PPI_SPPD.SPPD_BIAYA_KAPAL A WHERE SPPD_ID = '".$reqId."' 
									GROUP BY A.KAPAL_ID, KODE, KODE_KARTU, KODE_PUSAT) B ON A.KAPAL_ID = B.KAPAL_ID
					   )                                                              
					   UNION ALL
						SELECT '96', 'NO_NOTA', 4, 'KBB', 'JKK', 'JKK-KBB-01', NULL, '101.01.00' KODE_BUKU_BESAR, '00000', '000.00.00' PUSPEL, 'IDR', SYSDATE, 1, 0, JUMLAH_POTONGAN_KAS, 0, JUMLAH_POTONGAN_KAS, NULL, NULL, NULL, SYSDATE, 'AKUNTANSI_PMS', 'KBB_ENTRY_JUR_JKK', '', '', '', NULL 
						FROM (SELECT (SELECT NVL(SUM(JUMLAH), 0) FROM PPI_SPPD.SPPD_BIAYA_DEPARTEMEN WHERE SPPD_ID = '".$reqId."') + (SELECT NVL(SUM(JUMLAH), 0) FROM PPI_SPPD.SPPD_BIAYA_KAPAL WHERE SPPD_ID = '".$reqId."') JUMLAH_POTONGAN_KAS FROM DUAL) C   
				"; 
		
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }
		
	function selectByParamsRealisasiLebihKurang($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT 
                    PEGAWAI_ID, SPPD_ID, PEGAWAI, JENIS_SPPD, BERANGKAT, 
 					TANGGAL_BERANGKAT, TUJUAN, JUMLAH, CASE WHEN JUMLAH < 0 THEN 1 ELSE 0 END STATUS
					FROM PPI_SPPD.REALISASI_SPPD_LEBIH_KURANG
                WHERE 1 = 1 AND NOT JUMLAH = 0
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPerhitunganBiaya($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY STATUS_URUT, KELAS, SPPD_PESERTA_ID, TANGGAL_BERANGKAT, BIAYA_SPPD_ID, KOTA_TUJUAN ")
	{
		$str = "SELECT 
				PEGAWAI_ID, SPPD_ID, NAMA, 
				   URAIAN, BESARAN, JUMLAH_HARI, 
				   BIAYA, KALI, PROSENTASE, KOTA_TUJUAN, KOTA_BERANGKAT
				FROM PPI_SPPD.SPPD_PERHITUNGAN_REPORT A
                WHERE 1 = 1 AND NOT (BESARAN = 0 OR BIAYA = 0)
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		
		//echo $str; exit;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsRekapKirimJurnal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "	SELECT 
					A.PEGAWAI_ID, A.NAMA, SUM(BIAYA) JUMLAH
					FROM PPI_SPPD.SPPD_PERHITUNGAN_REPORT A
					WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.PEGAWAI_ID, A.NAMA ".$order;
		
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPerhitunganBiayaRealisasi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT 
				BIAYA_SPPD_ID, PEGAWAI_ID, SPPD_ID, 
				   NAMA, URAIAN, BESARAN, BESARAN_REAL,
				   JUMLAH_HARI, PROSENTASE, BIAYA, 
				   KALI, JUMLAH_HARI_REAL, PROSENTASE_REAL, 
				   BIAYA_REAL, KALI_REAL, TAMBAH_KURANG, KOTA_BERANGKAT, KOTA_TUJUAN
				FROM PPI_SPPD.SPPD_TAMBAH_KURANG_REPORT A WHERE 1 = 1 AND NOT BESARAN_REAL = 0
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
		$str = "SELECT 
                    SPPD_ID, A.PEGAWAI_ID, B.NAMA, BIAYA_JSON, 
                       LAMA_PERJALANAN
                    FROM PPI_SPPD.ESTIMASI_BIAYA_SPPD A
                    INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SPPD_ID) AS ROWCOUNT FROM PPI_SPPD.ESTIMASI_BIAYA_SPPD

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
	
	function getCountByParamsRealisasiLebihKurang($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.SPPD_ID) AS ROWCOUNT FROM PPI_SPPD.REALISASI_SPPD_LEBIH_KURANG A
		        WHERE 1 = 1  AND NOT JUMLAH = 0 ".$statement; 
		
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

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SPPD_ID) AS ROWCOUNT FROM PPI_SPPD.ESTIMASI_BIAYA_SPPD

		        WHERE 1 = 1 ".$statement; 
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