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
  * Entity-base class untuk mengimplementasikan tabel KAPAL_JENIS.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class KontrakSbpp extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KontrakSbpp()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KONTRAK_SBPP_ID", $this->getNextId("KONTRAK_SBPP_ID","PPI_OPERASIONAL.KONTRAK_SBPP"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KONTRAK_SBPP (
				   KONTRAK_SBPP_ID, LOKASI_ID, NOMOR, NOMOR_PMS,
				   NAMA, JENIS, KETERANGAN, 
				   TANGGAL_AWAL, TANGGAL_AKHIR, TANGGAL_TANDA_TANGAN, JUMLAH_AKTIF, JUMLAH_CADANGAN, TARIF_PER_TAHUN, TARIF_PER_BULAN)
 			  	VALUES (
				  ".$this->getField("KONTRAK_SBPP_ID").",
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("NOMOR")."',
				  '".$this->getField("NOMOR_PMS")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("JENIS")."',
				  '".$this->getField("KETERANGAN")."',
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  ".$this->getField("TANGGAL_TANDA_TANGAN").",
				  '".$this->getField("JUMLAH_AKTIF")."',
				  '".$this->getField("JUMLAH_CADANGAN")."',
				  '".$this->getField("TARIF_PER_TAHUN")."',
				  '".$this->getField("TARIF_PER_BULAN")."'
				)"; 
		$this->id = $this->getField("KONTRAK_SBPP_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KONTRAK_SBPP
				SET    
					   LOKASI_ID	 		= '".$this->getField("LOKASI_ID")."',
					   NOMOR	 			= '".$this->getField("NOMOR")."',
					   NOMOR_PMS			= '".$this->getField("NOMOR_PMS")."',
					   NAMA	 				= '".$this->getField("NAMA")."',
					   JENIS	 			= '".$this->getField("JENIS")."',
					   KETERANGAN	 		= '".$this->getField("KETERANGAN")."',
					   TANGGAL_AWAL	 		= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR		= ".$this->getField("TANGGAL_AKHIR").",
					   TANGGAL_TANDA_TANGAN= ".$this->getField("TANGGAL_TANDA_TANGAN").",
					   JUMLAH_AKTIF			= '".$this->getField("JUMLAH_AKTIF")."',
					   JUMLAH_CADANGAN	 	= '".$this->getField("JUMLAH_CADANGAN")."',
					   TARIF_PER_TAHUN	 	= '".$this->getField("TARIF_PER_TAHUN")."',
					   TARIF_PER_BULAN	 	= '".$this->getField("TARIF_PER_BULAN")."'
				WHERE  KONTRAK_SBPP_ID 		= '".$this->getField("KONTRAK_SBPP_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
    
	function callProsesJamKerjaKontrakSBPP()
	{
		$str= "
				CALL PPI_OPERASIONAL.PROSES_JAM_KERJA_KONTRAK_SBPP('".$this->getField("PERIODE")."') 
		"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
    function callProsesReportKontrakSBPP()
	{
        $str = "
				CALL PPI_OPERASIONAL.PROSES_REPORT_KONTRAK_SBPP('".$this->getField("PERIODE")."') 
		"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
    
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KONTRAK_SBPP
                WHERE 
                  KONTRAK_SBPP_ID = ".$this->getField("KONTRAK_SBPP_ID").""; 
				  
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
	
	function selectByParamsLaporanHarianSbpp($paramsArray=array(),$limit=-1,$from=-1, $hari="", $periode="", $statement="", 
	$order="ORDER BY 
		    E.LOKASI_ID ASC, F.KAPAL_JENIS_ID ASC,
		    CASE WHEN D.PELANGGAN_ID = '1' THEN '(MILIK)' WHEN D.PELANGGAN_ID = '6' THEN '(MILIK)' WHEN D.PELANGGAN_ID IS NULL THEN '' ELSE '(CHARTER)' END DESC,
		    D.MESIN_DAYA ASC, G.NAMA DESC, D.JENIS_PROPULSI DESC"
			)
	{
		$str = "
				SELECT
				CASE WHEN D.PELANGGAN_ID = '1' THEN '(MILIK)' WHEN D.PELANGGAN_ID = '6' THEN '(MILIK)' WHEN D.PELANGGAN_ID IS NULL THEN '' ELSE '(CHARTER)' END KAPAL_KEPEMILIKAN_NAMA,
				F.NAMA JENIS_KAPAL, D.JENIS_PROPULSI, D.TAHUN_BANGUN, D.MESIN_DAYA || ' x ' || G.NAMA HORSE_POWER_NAMA,
				E.NAMA LOKASI_TERAKHIR, C.KAPAL_ID, D.NAMA KAPAL, A.LOKASI_ID, C.KETERANGAN, C.TANGGAL_MASUK, C.TANGGAL_KELUAR, A.KONTRAK_SBPP_ID, C.KONTRAK_ID, C.KAPAL_ID_GANTI, C.HISTORI_PARENT_ID
				FROM PPI_OPERASIONAL.KONTRAK_SBPP A
				LEFT JOIN PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL B ON A.KONTRAK_SBPP_ID = B.KONTRAK_SBPP_ID
				LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI C ON C.KONTRAK_SBPP_ID = B.KONTRAK_SBPP_ID
						  AND (C.KONTRAK_ID = B.KONTRAK_SBPP_KAPAL_ID OR C.KAPAL_ID_GANTI = B.KONTRAK_SBPP_KAPAL_ID)
				LEFT JOIN PPI_OPERASIONAL.KAPAL D ON D.KAPAL_ID = C.KAPAL_ID
				LEFT JOIN PPI_OPERASIONAL.LOKASI E ON A.LOKASI_ID = E.LOKASI_ID
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS F ON D.KAPAL_JENIS_ID = F.KAPAL_JENIS_ID
				LEFT JOIN PPI_OPERASIONAL.HORSE_POWER G ON D.HORSE_POWER_ID = G.HORSE_POWER_ID
				WHERE 1=1
				AND B.STATUS = 'A'
				AND TO_DATE('".$hari.$periode."', 'DDMMYYYY') BETWEEN C.TANGGAL_MASUK AND (CASE WHEN C.TANGGAL_KELUAR IS NULL THEN SYSDATE ELSE C.TANGGAL_KELUAR END)
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsRealisasiProduksiV2($paramsArray=array(),$limit=-1,$from=-1, $periode="", $statement="", $order="ORDER BY A.KONTRAK_SBPP_ID ASC, B.DAYA DESC")
	{
		$str = "
				SELECT 
				A.KONTRAK_SBPP_ID, NOMOR || ' - ' || A.NAMA GROUP_NAMA,
				HP || ' x ' || B.DAYA HP_INFO,
                STATUS, HP, B.DAYA, B.KAPAL_ID, C.NAMA KAPAL_NAMA,
				PPI_OPERASIONAL.AMBIL_KAPAL_PENGGANTI('".$periode."',A.KONTRAK_SBPP_ID, NVL(B.KONTRAK_SBPP_KAPAL_ID_GANTI, B.KONTRAK_SBPP_KAPAL_ID)) KAPAL_PENGGANTI
                FROM PPI_OPERASIONAL.KONTRAK_SBPP A
                INNER JOIN PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL B ON A.KONTRAK_SBPP_ID = B.KONTRAK_SBPP_ID 
                INNER JOIN PPI_OPERASIONAL.KAPAL C ON B.KAPAL_ID = C.KAPAL_ID
                WHERE 1=1 AND B.STATUS = 'A'
				AND (TO_CHAR (A.TANGGAL_AWAL, 'MMYYYY') = '".$periode."' OR TO_DATE ('".$periode."', 'MMYYYY') BETWEEN A.TANGGAL_AWAL AND NVL (A.TANGGAL_AKHIR,SYSDATE))
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsEstimasiTso($paramsArray=array(),$limit=-1,$from=-1, $periode="", $statement="", $order="ORDER BY NVL(B.KONTRAK_SBPP_KAPAL_ID_GANTI, B.KONTRAK_SBPP_KAPAL_ID) ASC, B.STATUS, B.DAYA DESC")
	{
		$str = "
				SELECT 
				A.KONTRAK_SBPP_ID, NOMOR || ' - ' || A.NAMA GROUP_NAMA,
				HP || ' x ' || B.DAYA HP_INFO,
                STATUS, HP, B.DAYA, B.KAPAL_ID, C.NAMA KAPAL_NAMA,
				DECODE(B.STATUS, 'A', 'Kapal Utama', 'Kapal Cadangan') || ' ' || 
				(SELECT X.NAMA FROM PPI_OPERASIONAL.KAPAL X WHERE X.KAPAL_ID = (SELECT Y.KAPAL_ID FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL Y WHERE Y.KONTRAK_SBPP_KAPAL_ID = B.KONTRAK_SBPP_KAPAL_ID_GANTI)) STATUS_KAPAL,
				DECODE(D.JUMLAH_JAM, NULL, '', D.JUMLAH_JAM || ':' || D.JUMLAH_MENIT) JUMLAH_ESTIMASI, D.KAPAL_ESTIMASI_TSO_ID,
				TO_CHAR(D.TANGGAL_MASUK, 'YYYY-MM-DD HH24:MI:SS') TANGGAL_MASUK, TO_CHAR(D.TANGGAL_KELUAR, 'YYYY-MM-DD HH24:MI:SS') TANGGAL_KELUAR
                FROM PPI_OPERASIONAL.KONTRAK_SBPP A
                INNER JOIN PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL B ON A.KONTRAK_SBPP_ID = B.KONTRAK_SBPP_ID 
                INNER JOIN PPI_OPERASIONAL.KAPAL C ON B.KAPAL_ID = C.KAPAL_ID
				LEFT JOIN PPI_OPERASIONAL.KAPAL_ESTIMASI_TSO D ON D.KAPAL_ID = B.KAPAL_ID AND D.PERIODE = '".$periode."'
                WHERE 1=1 AND ( B.STATUS = 'A' OR B.STATUS = 'C' )
				AND (TO_CHAR (A.TANGGAL_AWAL, 'MMYYYY') = '".$periode."' OR TO_DATE ('".$periode."', 'MMYYYY') BETWEEN A.TANGGAL_AWAL AND NVL (A.TANGGAL_AKHIR,SYSDATE))
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
    
    
    function selectByParamsKontrakSbppLaporan($paramsArray=array(),$limit=-1,$from=-1, $periode="", $statement="", $order="ORDER BY LOKASI_ID ASC, KAPAL_JENIS_ID ASC, CASE WHEN PELANGGAN_ID = '1' THEN '(MILIK)' WHEN PELANGGAN_ID = '6' THEN '(MILIK)' WHEN PELANGGAN_ID IS NULL THEN '' ELSE '(CHARTER)' END DESC, MESIN_DAYA ASC, HORSE_POWER DESC, JENIS_PROPULSI DESC, TANGGAL_MASUK ASC, KAPAL_ID_GANTI ASC")
	{
		$str = "
				SELECT 
				KONTRAK_SBPP_ID, LOKASI_TERAKHIR, KAPAL_KEPEMILIKAN_NAMA, JENIS_KAPAL, 
				KAPAL_ID, KAPAL, JENIS_PROPULSI, HORSE_POWER_NAMA, PERIODE, AWAL, AKHIR, 
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 1, AWAL, AKHIR) TGL1,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 2, AWAL, AKHIR) TGL2,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 3, AWAL, AKHIR) TGL3,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 4, AWAL, AKHIR) TGL4,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 5, AWAL, AKHIR) TGL5,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 6, AWAL, AKHIR) TGL6,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 7, AWAL, AKHIR) TGL7,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 8, AWAL, AKHIR) TGL8,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 9, AWAL, AKHIR) TGL9,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 10, AWAL, AKHIR) TGL10,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 11, AWAL, AKHIR) TGL11,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 12, AWAL, AKHIR) TGL12,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 13, AWAL, AKHIR) TGL13,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 14, AWAL, AKHIR) TGL14,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 15, AWAL, AKHIR) TGL15,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 16, AWAL, AKHIR) TGL16,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 17, AWAL, AKHIR) TGL17,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 18, AWAL, AKHIR) TGL18,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 19, AWAL, AKHIR) TGL19,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 20, AWAL, AKHIR) TGL20,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 21, AWAL, AKHIR) TGL21,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 22, AWAL, AKHIR) TGL22,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 23, AWAL, AKHIR) TGL23,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 24, AWAL, AKHIR) TGL24,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 25, AWAL, AKHIR) TGL25,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 26, AWAL, AKHIR) TGL26,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 27, AWAL, AKHIR) TGL27,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 28, AWAL, AKHIR) TGL28,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 29, AWAL, AKHIR) TGL29,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 30, AWAL, AKHIR) TGL30,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI(KAPAL_ID, PERIODE, 31, AWAL, AKHIR) TGL31,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 1, AWAL, AKHIR) TGL_STATUS1,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 2, AWAL, AKHIR) TGL_STATUS2,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 3, AWAL, AKHIR) TGL_STATUS3,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 4, AWAL, AKHIR) TGL_STATUS4,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 5, AWAL, AKHIR) TGL_STATUS5,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 6, AWAL, AKHIR) TGL_STATUS6,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 7, AWAL, AKHIR) TGL_STATUS7,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 8, AWAL, AKHIR) TGL_STATUS8,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 9, AWAL, AKHIR) TGL_STATUS9,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 10, AWAL, AKHIR) TGL_STATUS10,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 11, AWAL, AKHIR) TGL_STATUS11,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 12, AWAL, AKHIR) TGL_STATUS12,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 13, AWAL, AKHIR) TGL_STATUS13,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 14, AWAL, AKHIR) TGL_STATUS14,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 15, AWAL, AKHIR) TGL_STATUS15,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 16, AWAL, AKHIR) TGL_STATUS16,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 17, AWAL, AKHIR) TGL_STATUS17,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 18, AWAL, AKHIR) TGL_STATUS18,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 19, AWAL, AKHIR) TGL_STATUS19,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 20, AWAL, AKHIR) TGL_STATUS20,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 21, AWAL, AKHIR) TGL_STATUS21,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 22, AWAL, AKHIR) TGL_STATUS22,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 23, AWAL, AKHIR) TGL_STATUS23,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 24, AWAL, AKHIR) TGL_STATUS24,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 25, AWAL, AKHIR) TGL_STATUS25,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 26, AWAL, AKHIR) TGL_STATUS26,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 27, AWAL, AKHIR) TGL_STATUS27,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 28, AWAL, AKHIR) TGL_STATUS28,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 29, AWAL, AKHIR) TGL_STATUS29,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 30, AWAL, AKHIR) TGL_STATUS30,
				PPI_OPERASIONAL.AMBIL_KESIAPAN_OPERASI_STATUS(KAPAL_ID, PERIODE, 31, AWAL, AKHIR) TGL_STATUS31
				FROM
				(
				SELECT
					  A.TANGGAL_MASUK, A.KAPAL_ID_GANTI, D.NAMA LOKASI_TERAKHIR, E.NAMA JENIS_KAPAL, B.PELANGGAN_ID, B.KAPAL_JENIS_ID, C.LOKASI_ID,
					  B.JENIS_PROPULSI, B.TAHUN_BANGUN, B.MESIN_DAYA || ' x ' || F.NAMA HORSE_POWER_NAMA, B.MESIN_DAYA, F.NAMA HORSE_POWER, 
					  CASE WHEN B.PELANGGAN_ID = '1' THEN '(MILIK)' WHEN B.PELANGGAN_ID = '6' THEN '(MILIK)' WHEN B.PELANGGAN_ID IS NULL THEN '' ELSE '(CHARTER)' END KAPAL_KEPEMILIKAN_NAMA, 
					  A.KONTRAK_SBPP_ID, A.KAPAL_ID, B.NAMA KAPAL, CASE WHEN TO_CHAR(TANGGAL_MASUK, 'MMYYYY') = '".$periode."' THEN TO_NUMBER(TO_CHAR(TANGGAL_MASUK, 'DD')) ELSE 1 END AWAL, 
					  CASE WHEN TO_CHAR(TANGGAL_KELUAR, 'MMYYYY') = '".$periode."' THEN TO_NUMBER(TO_CHAR(TANGGAL_KELUAR, 'DD')) ELSE TO_NUMBER(TO_CHAR(LAST_DAY(TO_DATE('".$periode."', 'MMYYYY')), 'DD')) END AKHIR,
					  '".$periode."' PERIODE
				FROM PPI_OPERASIONAL.KAPAL_HISTORI  A 
				INNER JOIN PPI_OPERASIONAL.KAPAL B ON A.KAPAL_ID = B.KAPAL_ID
				INNER JOIN PPI_OPERASIONAL.KONTRAK_SBPP C ON C.KONTRAK_SBPP_ID = A.KONTRAK_SBPP_ID
				INNER JOIN PPI_OPERASIONAL.LOKASI D ON D.LOKASI_ID = C.LOKASI_ID
				INNER JOIN PPI_OPERASIONAL.KAPAL_JENIS E ON E.KAPAL_JENIS_ID = B.KAPAL_JENIS_ID
				LEFT JOIN PPI_OPERASIONAL.HORSE_POWER F ON F.HORSE_POWER_ID = B.HORSE_POWER_ID
				WHERE A.KONTRAK_SBPP_ID IS NOT NULL AND (
					  TO_DATE('".$periode."', 'MMYYYY') BETWEEN TANGGAL_MASUK AND NVL(TANGGAL_KELUAR, SYSDATE)
					  OR TO_CHAR(TANGGAL_MASUK, 'MMYYYY') = '".$periode."' OR TO_CHAR(TANGGAL_KELUAR, 'MMYYYY') = '".$periode."'
					  )      
				)
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
    
    function selectByParamsKontrakSbppLaporanRekap($paramsArray=array(),$limit=-1,$from=-1, $periode="", $statement="", $order="ORDER BY LOKASI_ID ASC, KAPAL_JENIS_ID ASC, CASE WHEN PELANGGAN_ID = '1' THEN '(MILIK)' WHEN PELANGGAN_ID = '6' THEN '(MILIK)' WHEN PELANGGAN_ID IS NULL THEN '' ELSE '(CHARTER)' END DESC, MESIN_DAYA ASC, HORSE_POWER DESC, JENIS_PROPULSI DESC, TANGGAL_MASUK ASC, KAPAL_ID_GANTI ASC")
	{
		$str = "
				SELECT 
				PERIODE, KAPAL_ID, LOKASI_TERAKHIR, KAPAL_KEPEMILIKAN_NAMA, JENIS_KAPAL, KAPAL, 
			    JENIS_PROPULSI, HORSE_POWER_NAMA, KAPAL_HISTORI_ID, 
			    TGL_JAM1, TGL_JAM2, TGL_JAM3, TGL_JAM4, TGL_JAM5, TGL_JAM6, 
			    TGL_JAM7, TGL_JAM8, TGL_JAM9, TGL_JAM10, TGL_JAM11, TGL_JAM12, 
			    TGL_JAM13, TGL_JAM14, TGL_JAM15, TGL_JAM16, TGL_JAM17, TGL_JAM18, 
			    TGL_JAM19, TGL_JAM20, TGL_JAM21, TGL_JAM22, TGL_JAM23, TGL_JAM24, 
			    TGL_JAM25, TGL_JAM26, TGL_JAM27, TGL_JAM28, TGL_JAM29, TGL_JAM30, 
			    TGL_JAM31, KAPAL_ID_GANTI, PELANGGAN_ID, MESIN_DAYA, HORSE_POWER, TANGGAL_MASUK
				FROM PPI_OPERASIONAL.KONTRAK_SBPP_REPORT
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
    
	function selectByParamsKontrakSbppJumlahJamRekap($paramsArray=array(),$limit=-1,$from=-1, $periode="", $statement="", $order="ORDER BY LOKASI_ID ASC, KAPAL_JENIS_ID ASC, CASE WHEN PELANGGAN_ID = '1' THEN '(MILIK)' WHEN PELANGGAN_ID = '6' THEN '(MILIK)' WHEN PELANGGAN_ID IS NULL THEN '' ELSE '(CHARTER)' END DESC, MESIN_DAYA ASC, HORSE_POWER DESC, JENIS_PROPULSI DESC, TANGGAL_MASUK ASC, KAPAL_ID_GANTI ASC")
	{
		$str = "
				SELECT 
				PERIODE, KAPAL_ID, LOKASI_TERAKHIR, KAPAL_KEPEMILIKAN_NAMA, JENIS_KAPAL, KAPAL, 
			    JENIS_PROPULSI, HORSE_POWER_NAMA, KAPAL_HISTORI_ID, 
			    TGL_JAM1, TGL_JAM2, TGL_JAM3, TGL_JAM4, TGL_JAM5, TGL_JAM6, 
			    TGL_JAM7, TGL_JAM8, TGL_JAM9, TGL_JAM10, TGL_JAM11, TGL_JAM12, 
			    TGL_JAM13, TGL_JAM14, TGL_JAM15, TGL_JAM16, TGL_JAM17, TGL_JAM18, 
			    TGL_JAM19, TGL_JAM20, TGL_JAM21, TGL_JAM22, TGL_JAM23, TGL_JAM24, 
			    TGL_JAM25, TGL_JAM26, TGL_JAM27, TGL_JAM28, TGL_JAM29, TGL_JAM30, 
			    TGL_JAM31, KAPAL_ID_GANTI, PELANGGAN_ID, MESIN_DAYA, HORSE_POWER, TANGGAL_MASUK
				FROM PPI_OPERASIONAL.KONTRAK_SBPP_JAM_KERJA
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
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY TANGGAL_AKHIR DESC")
	{
		$str = "
				SELECT 
				KONTRAK_SBPP_ID, A.LOKASI_ID, NOMOR, NOMOR_PMS, B.NAMA LOKASI,
				   A.NAMA, A.KETERANGAN, TARIF_PER_TAHUN, TARIF_PER_BULAN,
                   TANGGAL_AWAL, TANGGAL_AKHIR, (SELECT COUNT(KONTRAK_SBPP_KAPAL_ID) FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL X WHERE A.KONTRAK_SBPP_ID = X.KONTRAK_SBPP_ID) JUMLAH_KAPAL, A.TANGGAL_TANDA_TANGAN
                FROM PPI_OPERASIONAL.KONTRAK_SBPP A INNER JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID = B.LOKASI_ID
                WHERE KONTRAK_SBPP_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsKadaluarsa($paramsArray=array(),$limit=-1,$from=-1, $batas_notifikasi="", $statement="", $order="ORDER BY TANGGAL_AKHIR DESC")
	{
		$str = "
				SELECT 
				'Kontrak SBPP' KONTRAK_SBPP,
				CASE 
				 WHEN (A.TANGGAL_AKHIR - INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE AND A.TANGGAL_AKHIR > SYSDATE THEN 1
				 WHEN A.TANGGAL_AKHIR <= SYSDATE THEN 2
			     ELSE 0
                END STATUS,
                CASE 
                    WHEN (A.TANGGAL_AKHIR - INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE AND A.TANGGAL_AKHIR > SYSDATE THEN 'Masa Berlaku Hampir Habis'
                    WHEN A.TANGGAL_AKHIR <= SYSDATE THEN 'Masa Berlaku Habis'
                    ELSE 'Aktif'
                END STATUS_INFO,
                KONTRAK_SBPP_ID, A.LOKASI_ID, NOMOR, B.NAMA LOKASI,
                   A.NAMA, 
                   TANGGAL_AWAL, TANGGAL_AKHIR
                FROM PPI_OPERASIONAL.KONTRAK_SBPP A INNER JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID = B.LOKASI_ID
                WHERE KONTRAK_SBPP_ID IS NOT NULL
                UNION ALL               
                 SELECT
                'Kontrak Time-Charter' KONTRAK_SBPP,
                CASE 
				 WHEN (A.TANGGAL_AKHIR - INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE AND A.TANGGAL_AKHIR > SYSDATE THEN 1
				 WHEN A.TANGGAL_AKHIR <= SYSDATE THEN 2
			     ELSE 0
                END STATUS,
				CASE 
                    WHEN (A.TANGGAL_AKHIR - INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE AND A.TANGGAL_AKHIR > SYSDATE THEN 'Masa Berlaku Hampir Habis'
                    WHEN A.TANGGAL_AKHIR <= SYSDATE THEN 'Masa Berlaku Habis'
                    ELSE 'Aktif'
                END STATUS_INFO,
                KAPAL_PEKERJAAN_ID, A.LOKASI_ID, NO_KONTRAK, B.NAMA LOKASI,
                   A.NAMA, 
                   TANGGAL_AWAL, TANGGAL_AKHIR
                FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN A INNER JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID = B.LOKASI_ID
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
				KONTRAK_SBPP_ID, LOKASI_ID, NOMOR, 
				   NAMA, JENIS, KETERANGAN, 
				   TANGGAL_AWAL, TANGGAL_AKHIR
				FROM PPI_OPERASIONAL.KONTRAK_SBPP
				WHERE KONTRAK_SBPP IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KONTRAK_SBPP ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{ 
		$str = "SELECT COUNT(KONTRAK_SBPP_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KONTRAK_SBPP
		        WHERE KONTRAK_SBPP_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KONTRAK_SBPP) AS ROWCOUNT FROM PPI_OPERASIONAL.KONTRAK_SBPP
		        WHERE KONTRAK_SBPP IS NOT NULL ".$statement; 
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