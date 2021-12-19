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

  class KapalProduksiInfo extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalProduksiInfo()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO (
				   HARI, KAPAL_ID, LOKASI_ID, 
				   PERIODE, JUMLAH_GERAKAN, TOTAL_GRT, 
				   TOTAL_JAM_OPS, JAM_TUNDA, JAM_ME, 
				   JAM_AE1, JAM_AE2, DT_AW, 
				   DT_AK, BBM_PAKAI, BBM_BUNKER, 
				   BBM_SUPPLY, BBM_SISA, AIR_PAKAI, 
				   AIR_ISI, AIR_SISA, ABK_HADIR, 
				   KETERANGAN, DOWNTIME) 
 			  	VALUES (
				  ".$this->getField("HARI").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("PERIODE")."',
				  '".$this->getField("JUMLAH_GERAKAN")."',
				  '".$this->getField("TOTAL_GRT")."',
				  '".$this->getField("TOTAL_JAM_OPS")."',
				  '".$this->getField("JAM_TUNDA")."',
				  '".$this->getField("JAM_ME")."',
				  '".$this->getField("JAM_AE1")."',
				  '".$this->getField("JAM_AE2")."',
				  '".$this->getField("DT_AW")."',
				  '".$this->getField("DT_AK")."',
				  '".$this->getField("BBM_PAKAI")."',
				  '".$this->getField("BBM_BUNKER")."',
				  '".$this->getField("BBM_SUPPLY")."',
				  '".$this->getField("BBM_SISA")."',
				  '".$this->getField("AIR_PAKAI")."',
				  '".$this->getField("AIR_ISI")."',
				  '".$this->getField("AIR_SISA")."',
				  '".$this->getField("ABK_HADIR")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("DOWNTIME")."'
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
    function insertSynch()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_WS (
				   HARI, KAPAL_ID, LOKASI_ID, 
				   PERIODE, JUMLAH_GERAKAN, TOTAL_GRT, 
				   TOTAL_JAM_OPS, JAM_TUNDA, JAM_ME, 
				   JAM_AE1, JAM_AE2, DT_AW, 
				   DT_AK, BBM_PAKAI, BBM_BUNKER, 
				   BBM_SUPPLY, BBM_SISA, AIR_PAKAI, 
				   AIR_ISI, AIR_SISA, ABK_HADIR, 
				   KETERANGAN, DOWNTIME) 
 			  	VALUES (
				  ".$this->getField("HARI").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("PERIODE")."',
				  '".$this->getField("JUMLAH_GERAKAN")."',
				  '".$this->getField("TOTAL_GRT")."',
				  '".$this->getField("TOTAL_JAM_OPS")."',
				  '".$this->getField("JAM_TUNDA")."',
				  '".$this->getField("JAM_ME")."',
				  '".$this->getField("JAM_AE1")."',
				  '".$this->getField("JAM_AE2")."',
				  '".$this->getField("DT_AW")."',
				  '".$this->getField("DT_AK")."',
				  '".$this->getField("BBM_PAKAI")."',
				  '".$this->getField("BBM_BUNKER")."',
				  '".$this->getField("BBM_SUPPLY")."',
				  '".$this->getField("BBM_SISA")."',
				  '".$this->getField("AIR_PAKAI")."',
				  '".$this->getField("AIR_ISI")."',
				  '".$this->getField("AIR_SISA")."',
				  '".$this->getField("ABK_HADIR")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("DOWNTIME")."'
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function insertDowntime()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO (
				   HARI, KAPAL_ID, LOKASI_ID, 
				   PERIODE, RUSAK, PERBAIKAN, TSO, SO, OFF, HASIL, KESIAPAN_OPERASI,
				   PEMELIHARAAN, KETERANGAN_DOWNTIME, DOWNTIME2) 
 			  	VALUES (
				  ".$this->getField("HARI").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("PERIODE")."',
				  '".$this->getField("RUSAK")."',
				  '".$this->getField("PERBAIKAN")."',
				  '".$this->getField("TSO")."',
				  '".$this->getField("SO")."',
				  '".$this->getField("OFF")."',
				  '".$this->getField("HASIL")."',
				  '".$this->getField("KESIAPAN_OPERASI")."',
				  '".$this->getField("PEMELIHARAAN")."',
				  '".$this->getField("KETERANGAN_DOWNTIME")."',
				  '".$this->getField("DOWNTIME2")."'
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }


    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO 
				SET    
					   LOKASI_ID		= '".$this->getField("LOKASI_ID")."',
					   JUMLAH_GERAKAN	= '".$this->getField("JUMLAH_GERAKAN")."',
					   TOTAL_GRT	 	= '".$this->getField("TOTAL_GRT")."',
					   TOTAL_JAM_OPS	= '".$this->getField("TOTAL_JAM_OPS")."',
					   JAM_TUNDA	 	= '".$this->getField("JAM_TUNDA")."',
					   JAM_ME	 		= '".$this->getField("JAM_ME")."',
					   JAM_AE1	 		= '".$this->getField("JAM_AE1")."',
					   JAM_AE2	 		= '".$this->getField("JAM_AE2")."',
					   DT_AW	 		= '".$this->getField("DT_AW")."',
					   DT_AK	 		= '".$this->getField("DT_AK")."',
					   BBM_PAKAI	 	= '".$this->getField("BBM_PAKAI")."',
					   BBM_BUNKER	 	= '".$this->getField("BBM_BUNKER")."',
					   BBM_SUPPLY	 	= '".$this->getField("BBM_SUPPLY")."',
					   BBM_SISA	 		= '".$this->getField("BBM_SISA")."',
					   AIR_PAKAI	 	= '".$this->getField("AIR_PAKAI")."',
					   AIR_ISI	 		= '".$this->getField("AIR_ISI")."',
					   AIR_SISA	 		= '".$this->getField("AIR_SISA")."',
					   ABK_HADIR	 	= '".$this->getField("ABK_HADIR")."',
					   KETERANGAN	 	= '".$this->getField("KETERANGAN")."',
					   DOWNTIME	 		= '".$this->getField("DOWNTIME")."'
				WHERE  HARI	= '".$this->getField("HARI")."' AND KAPAL_ID	= '".$this->getField("KAPAL_ID")."' AND PERIODE	= '".$this->getField("PERIODE")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateSynch()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_WS  
				SET    
					   LOKASI_ID		= '".$this->getField("LOKASI_ID")."',
					   JUMLAH_GERAKAN	= '".$this->getField("JUMLAH_GERAKAN")."',
					   TOTAL_GRT	 	= '".$this->getField("TOTAL_GRT")."',
					   TOTAL_JAM_OPS	= '".$this->getField("TOTAL_JAM_OPS")."',
					   JAM_TUNDA	 	= '".$this->getField("JAM_TUNDA")."',
					   JAM_ME	 		= '".$this->getField("JAM_ME")."',
					   JAM_AE1	 		= '".$this->getField("JAM_AE1")."',
					   JAM_AE2	 		= '".$this->getField("JAM_AE2")."',
					   DT_AW	 		= '".$this->getField("DT_AW")."',
					   DT_AK	 		= '".$this->getField("DT_AK")."',
					   BBM_PAKAI	 	= '".$this->getField("BBM_PAKAI")."',
					   BBM_BUNKER	 	= '".$this->getField("BBM_BUNKER")."',
					   BBM_SUPPLY	 	= '".$this->getField("BBM_SUPPLY")."',
					   BBM_SISA	 		= '".$this->getField("BBM_SISA")."',
					   AIR_PAKAI	 	= '".$this->getField("AIR_PAKAI")."',
					   AIR_ISI	 		= '".$this->getField("AIR_ISI")."',
					   AIR_SISA	 		= '".$this->getField("AIR_SISA")."',
					   ABK_HADIR	 	= '".$this->getField("ABK_HADIR")."',
					   KETERANGAN	 	= '".$this->getField("KETERANGAN")."',
					   DOWNTIME	 		= '".$this->getField("DOWNTIME")."'
				WHERE  HARI	= '".$this->getField("HARI")."' AND KAPAL_ID	= '".$this->getField("KAPAL_ID")."' AND PERIODE	= '".$this->getField("PERIODE")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function resetProduksiKapal()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO 
				SET    
					   JUMLAH_GERAKAN	= NULL,
					   TOTAL_GRT	 	= NULL,
					   TOTAL_JAM_OPS	= NULL,
					   JAM_TUNDA	 	= NULL,
					   JAM_ME	 		= NULL,
					   JAM_AE1	 		= NULL,
					   JAM_AE2	 		= NULL,
					   DT_AW	 		= NULL,
					   DT_AK	 		= NULL,
					   BBM_PAKAI	 	= NULL,
					   BBM_BUNKER	 	= NULL,
					   BBM_SUPPLY	 	= NULL,
					   BBM_SISA	 		= NULL,
					   AIR_PAKAI	 	= NULL,
					   AIR_ISI	 		= NULL,
					   AIR_SISA	 		= NULL,
					   ABK_HADIR	 	= NULL,
					   KETERANGAN	 	= NULL,
					   DOWNTIME	 		= NULL
				WHERE  KAPAL_ID	= '".$this->getField("KAPAL_ID")."' AND PERIODE	= '".$this->getField("PERIODE")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateDowntimeSetNull()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO 
				SET    
					   RUSAK  				= NULL,
					   SO					= NULL,
					   TSO					= NULL,
					   PERBAIKAN			= NULL,
					   PEMELIHARAAN			= NULL,
					   OFF					= NULL
				WHERE  HARI	= '".$this->getField("HARI")."' AND KAPAL_ID	= '".$this->getField("KAPAL_ID")."' AND PERIODE	= '".$this->getField("PERIODE")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateDowntime()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO 
				SET    
					   RUSAK  				= '".$this->getField("RUSAK")."',
					   SO					= '".$this->getField("SO")."',
					   TSO					= '".$this->getField("TSO")."',
					   PERBAIKAN			= '".$this->getField("PERBAIKAN")."',
					   PEMELIHARAAN			= '".$this->getField("PEMELIHARAAN")."',
					   OFF					= '".$this->getField("OFF")."',
					   KETERANGAN_DOWNTIME	= '".$this->getField("KETERANGAN_DOWNTIME")."',
					   HASIL				= '".$this->getField("HASIL")."',
					   KESIAPAN_OPERASI		= '".$this->getField("KESIAPAN_OPERASI")."',
					   DOWNTIME2			= '".$this->getField("DOWNTIME2")."'
				WHERE  HARI	= '".$this->getField("HARI")."' AND KAPAL_ID	= '".$this->getField("KAPAL_ID")."' AND PERIODE	= '".$this->getField("PERIODE")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
		
		
	function delete()
	{
        $str = "
				DELETE FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO 
                	WHERE 
                  	PERIODE = '".$this->getField("PERIODE")."' AND KAPAL_ID = '".$this->getField("KAPAL_ID")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY HARI ASC")
	{
		$str = "
				SELECT 
				KAPAL_ID, LOKASI_ID, 
				   PERIODE, JUMLAH_GERAKAN, TOTAL_GRT, 
				   TOTAL_JAM_OPS, JAM_TUNDA, JAM_ME, JAM_ME2,
				   JAM_AE1, JAM_AE2, DT_AW, 
				   DT_AK, BBM_PAKAI, BBM_BUNKER, 
				   BBM_SUPPLY, BBM_SISA, AIR_PAKAI, 
				   AIR_ISI, AIR_SISA, ABK_HADIR, 
				   KETERANGAN, DOWNTIME, HARI, RUSAK, PERBAIKAN, PEMELIHARAAN, TSO, KETERANGAN_DOWNTIME, SO, HASIL, KESIAPAN_OPERASI, OFF, DOWNTIME2,
				   URAIAN_PROGRES_PEKERJAAN, ESTIMASI_PENYELESAIAN, HAL_LAIN
				FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO				
				WHERE KAPAL_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		//echo $str;exit;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
		
    }
	
	function selectByParamsWs($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY HARI ASC")
	{
		$str = "
				SELECT 
				KAPAL_ID, LOKASI_ID, 
				   PERIODE, JUMLAH_GERAKAN, TOTAL_GRT, 
				   TOTAL_JAM_OPS, JAM_TUNDA, JAM_ME, JAM_ME2,
				   JAM_AE1, JAM_AE2, DT_AW, 
				   DT_AK, BBM_PAKAI, BBM_BUNKER, 
				   BBM_SUPPLY, BBM_SISA, AIR_PAKAI, 
				   AIR_ISI, AIR_SISA, ABK_HADIR, 
				   KETERANGAN, DOWNTIME, HARI, RUSAK, PERBAIKAN, PEMELIHARAAN, TSO, KETERANGAN_DOWNTIME, SO, HASIL, KESIAPAN_OPERASI, OFF, DOWNTIME2,
				   URAIAN_PROGRES_PEKERJAAN, ESTIMASI_PENYELESAIAN, HAL_LAIN
				FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_WS		
				WHERE KAPAL_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		//echo $str;exit;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
		
    }
	
    function selectByParamsRealisasiProduksi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
                SELECT 
                A.KAPAL_ID, LOKASI_ID, 
                   PERIODE, JUMLAH_GERAKAN, TOTAL_GRT, 
                   TOTAL_JAM_OPS, JAM_TUNDA, JAM_ME, 
                   JAM_AE1, JAM_AE2, DT_AW, 
                   DT_AK, BBM_PAKAI, BBM_BUNKER, 
                   BBM_SUPPLY, BBM_SISA, AIR_PAKAI, 
                   AIR_ISI, AIR_SISA, ABK_HADIR, 
                   KETERANGAN, DOWNTIME, HARI, RUSAK, PERBAIKAN, PEMELIHARAAN, KETERANGAN_DOWNTIME, B.NAMA NAMA_KAPAL, B.KODE
                FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO A
                LEFT JOIN PPI_OPERASIONAL.KAPAL B ON A.KAPAL_ID = B.KAPAL_ID
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
	
    function selectByParamsKesiapanOperasiAlatApung($paramsArray=array(), $limit=-1, $from=-1, $statement="", $order="")
	{
		$str = "
				SELECT 
				KAPAL_ID, PERIODE, NAMA, 
				   KAPAL_JENIS, HORSE_POWER, TERSEDIA, 
				   SIAP_OPERASI, SIAP_OPERASI_PROSENTASE, TIDAK_SIAP_OPERASI_PROSENTASE, 
				   TIDAK_SIAP_OPERASI, RUSAK, PERBAIKAN, 
				   PEMELIHARAAN
				FROM PPI_OPERASIONAL.KESIAPAN_OPERASI_ALAT_APUNG		
				WHERE KAPAL_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }	
	
    function selectByParamsReportBbm($paramsArray=array(),$limit=-1,$from=-1, $statement="", $tahun="", $order="")
	{
		$str = "
				SELECT 
                A.KAPAL_ID, A.KODE, A.NAMA, TAHUN, 
                   GRK_01, JAMOPS_01, PAKAI_01, 
                   ISI_01, SISA_01, GRK_02, 
                   JAMOPS_02, PAKAI_02, ISI_02, 
                   SISA_02, GRK_03, JAMOPS_03, 
                   PAKAI_03, ISI_03, SISA_03, 
                   GRK_04, JAMOPS_04, PAKAI_04, 
                   ISI_04, SISA_04, GRK_05, 
                   JAMOPS_05, PAKAI_05, ISI_05, 
                   SISA_05, GRK_06, JAMOPS_06, 
                   PAKAI_06, ISI_06, SISA_06, 
                   GRK_07, JAMOPS_07, PAKAI_07, 
                   ISI_07, SISA_07, GRK_08, 
                   JAMOPS_08, PAKAI_08, ISI_08, 
                   SISA_08, GRK_09, JAMOPS_09, 
                   PAKAI_09, ISI_09, SISA_09, 
                   GRK_10, JAMOPS_10, PAKAI_10, 
                   ISI_10, SISA_10, GRK_11, 
                   JAMOPS_11, PAKAI_11, ISI_11, 
                   SISA_11, GRK_12, JAMOPS_12, 
                   PAKAI_12, ISI_12, SISA_12
                FROM PPI_OPERASIONAL.KAPAL A LEFT JOIN PPI_OPERASIONAL.KONSUMSI_BBM_TAHUN_REPORT B ON A.KAPAL_ID = B.KAPAL_ID AND TAHUN = '".$tahun."'       
                WHERE A.KAPAL_ID IS NOT NULL 
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

    function selectByParamsReportAir($paramsArray=array(),$limit=-1,$from=-1, $statement="", $tahun="", $order="")
	{
		$str = "
				SELECT 
                A.KAPAL_ID, A.KODE, A.NAMA, TAHUN, 
                   GRK_01, JAMOPS_01, PAKAI_01, 
                   ISI_01, SISA_01, GRK_02, 
                   JAMOPS_02, PAKAI_02, ISI_02, 
                   SISA_02, GRK_03, JAMOPS_03, 
                   PAKAI_03, ISI_03, SISA_03, 
                   GRK_04, JAMOPS_04, PAKAI_04, 
                   ISI_04, SISA_04, GRK_05, 
                   JAMOPS_05, PAKAI_05, ISI_05, 
                   SISA_05, GRK_06, JAMOPS_06, 
                   PAKAI_06, ISI_06, SISA_06, 
                   GRK_07, JAMOPS_07, PAKAI_07, 
                   ISI_07, SISA_07, GRK_08, 
                   JAMOPS_08, PAKAI_08, ISI_08, 
                   SISA_08, GRK_09, JAMOPS_09, 
                   PAKAI_09, ISI_09, SISA_09, 
                   GRK_10, JAMOPS_10, PAKAI_10, 
                   ISI_10, SISA_10, GRK_11, 
                   JAMOPS_11, PAKAI_11, ISI_11, 
                   SISA_11, GRK_12, JAMOPS_12, 
                   PAKAI_12, ISI_12, SISA_12
                FROM PPI_OPERASIONAL.KAPAL A LEFT JOIN PPI_OPERASIONAL.KONSUMSI_AIR_TAHUN_REPORT B ON A.KAPAL_ID = B.KAPAL_ID AND TAHUN = '".$tahun."'       
                WHERE A.KAPAL_ID IS NOT NULL 
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
	
	function selectByParamsLaporanHarianSbpp($paramsArray=array(), $limit=-1, $from=-1, $statement="", $periode="", $hari="", $hari1="", $order=
	"
	ORDER BY H.LOKASI_ID ASC, D.KAPAL_JENIS_ID ASC,
                CASE WHEN A.PELANGGAN_ID = '1' THEN '(MILIK)' WHEN A.PELANGGAN_ID = '6' THEN '(MILIK)' WHEN A.PELANGGAN_ID IS NULL THEN '' ELSE '(CHARTER)' END DESC,
                A.MESIN_DAYA ASC, I.NAMA ASC, A.JENIS_PROPULSI DESC
	")
	{
		$str = "
				SELECT  
					A.KAPAL_ID, A.KAPAL_KEPEMILIKAN_ID,
					CASE WHEN H.LOKASI_ID IS NULL THEN 'BELUM DITENTUKAN' ELSE (SELECT X.NAMA FROM PPI_OPERASIONAL.LOKASI X WHERE H.LOKASI_ID = X.LOKASI_ID) END LOKASI_TERAKHIR,
					CASE WHEN A.PELANGGAN_ID = '1' THEN '(MILIK)' WHEN A.PELANGGAN_ID = '6' THEN '(MILIK)' WHEN A.PELANGGAN_ID IS NULL THEN '' ELSE '(CHARTER)' END KAPAL_KEPEMILIKAN_NAMA,
					A.NAMA KAPAL, D.NAMA JENIS_KAPAL, H.LOKASI_ID, D.KAPAL_JENIS_ID,
					J.NAMA JENIS_PROPULSI, A.TAHUN_BANGUN, A.MESIN_DAYA || ' x ' || I.NAMA HORSE_POWER_NAMA,
					G.SO, G.TSO, G.PERBAIKAN, G.RUSAK, G.OFF, G.KETERANGAN_DOWNTIME, G.KESIAPAN_OPERASI, G.PEMELIHARAAN, G.HASIL, G.DOWNTIME2,
                    CASE WHEN G.SO IS NOT NULL THEN 'Operasi'
                    ELSE 'Tidak Operasi' END STATUS_OPERASI
				FROM PPI_OPERASIONAL.KAPAL A 
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS D ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID
				LEFT JOIN PPI_OPERASIONAL.KAPAL_LOKASI H ON A.KAPAL_ID = H.KAPAL_ID AND TO_DATE('".$hari1.$periode."', 'DDMMYYYY') BETWEEN H.TANGGAL_AWAL AND (CASE WHEN H.TANGGAL_AKHIR IS NULL THEN SYSDATE ELSE H.TANGGAL_AKHIR END)
				LEFT JOIN PPI_OPERASIONAL.TARIF_SBPP_KAPAL_TERAKHIR F ON A.KAPAL_ID = F.KAPAL_ID
				LEFT JOIN PPI_OPERASIONAL.HORSE_POWER I ON I.HORSE_POWER_ID = A.HORSE_POWER_ID
				LEFT JOIN PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO G ON A.KAPAL_ID = G.KAPAL_ID AND PERIODE = '".$periode."' AND HARI = '".$hari."'
				LEFT JOIN PPI_OPERASIONAL.KAPAL_ITEM_JENIS J ON A.JENIS_PROPULSI = J.ID_ITEM AND J.JENIS='PROPULSI'
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		//echo $str;exit;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	
				SELECT 
				KAPAL_PRODUKSI_INFO_ID, KAPAL_ID, LOKASI_ID, 
				   PERIODE, JUMLAH_GERAKAN, TOTAL_GRT, 
				   TOTAL_JAM_OPS, JAM_TUNDA, JAM_ME, 
				   JAM_AE1, JAM_AE2, DT_AW, 
				   DT_AK, BBM_PAKAI, BBM_BUNKER, 
				   BBM_SUPPLY, BBM_SISA, AIR_PAKAI, 
				   AIR_ISI, AIR_SISA, ABK_HADIR, 
				   KETERANGAN, DOWNTIME
				FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO				
				WHERE KAPAL_PRODUKSI_INFO_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_PRODUKSI_INFO_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParamsKapalProduksi($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO  A
		        WHERE KAPAL_ID IS NOT NULL ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
		
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL  A
		        WHERE KAPAL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_PRODUKSI_INFO_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL
		        WHERE KAPAL_PRODUKSI_INFO_ID IS NOT NULL ".$statement; 
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
	
	function callProsesDataProduksi()
	{

        $str = "CALL PPI_OPERASIONAL.PROSES_DATA_PRODUKSI('" . $this->getField("PERIODE") . "', '". $this->getField("KAPAL_ID") ."', '". $this->getField("LAST_CREATE_USER")."')";
  		//echo $str;exit;
		$this->query = $str;
        return $this->execQuery($str);
    }
	
  } 
?>