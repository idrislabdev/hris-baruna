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

  class WebService extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Kapal()
	{
      $this->Entity(); 
    }
	
	function selectWaktuServer()
		{
				$str = "SELECT TO_CHAR(SYSDATE, 'DDMMYYYY HH24:MI:SS') WAKTU FROM DUAL " ; 
				$this->query = $str;
				
				return $this->selectLimit($str,-1,-1); 
				
		}
	
	function insertDataProduksiInfo()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_WS (
				   HARI, KAPAL_ID, LOKASI_ID, 
				   PERIODE, JUMLAH_GERAKAN, TOTAL_GRT, 
				   TOTAL_JAM_OPS, JAM_TUNDA, JAM_ME, JAM_ME2, 
				   JAM_AE1, JAM_AE2, DT_AW, 
				   DT_AK, BBM_PAKAI, BBM_BUNKER, 
				   BBM_SUPPLY, BBM_SISA, AIR_PAKAI, 
				   AIR_ISI, AIR_SISA, ABK_HADIR, 
				   KETERANGAN, DOWNTIME, URAIAN_PROGRES_PEKERJAAN, ESTIMASI_PENYELESAIAN, HAL_LAIN, TSO, SO, HASIL, KESIAPAN_OPERASI, DOWNTIME2, KETERANGAN_DOWNTIME,
				   LAST_UPDATE_DATE, LAST_UPDATE_BY
				   ) 
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
				  '".$this->getField("JAM_ME2")."',
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
				  '".$this->getField("DOWNTIME")."',
				  '".$this->getField("URAIAN_PROGRES_PEKERJAAN")."',
				  '".$this->getField("ESTIMASI_PENYELESAIAN")."',
				  '".$this->getField("HAL_LAIN")."',
				  '".$this->getField("TSO")."',
				  '".$this->getField("SO")."',
				  '".$this->getField("HASIL")."',
				  '".$this->getField("KESIAPAN_OPERASI")."',
				  '".$this->getField("DOWNTIME2")."',
				  '".$this->getField("KETERANGAN_DOWNTIME")."',
				  ".$this->getField("LAST_UPDATE_DATE").",
				  '".$this->getField("LAST_UPDATE_BY")."'
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function updateDataProduksiInfo()
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
	
	function DeleteDataProduksiInfo()
			{
		$str = "DELETE FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_WS
				WHERE  KAPAL_ID         	= '".$this->getField("KAPAL_ID")."'
				AND PERIODE	 			= '".$this->getField("PERIODE")."'
				AND APPROVED_DATE IS NULL
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    		}
	
	function selectDataProduksiInfo($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY HARI ASC")
	{
			$str = "
					SELECT 
					KAPAL_ID, LOKASI_ID, 
					   PERIODE, JUMLAH_GERAKAN, TOTAL_GRT, 
					   TOTAL_JAM_OPS, JAM_TUNDA, JAM_ME, 
					   JAM_AE1, JAM_AE2, DT_AW, 
					   DT_AK, BBM_PAKAI, BBM_BUNKER, 
					   BBM_SUPPLY, BBM_SISA, AIR_PAKAI, 
					   AIR_ISI, AIR_SISA, ABK_HADIR, 
					   KETERANGAN, DOWNTIME, HARI, RUSAK, PERBAIKAN, PEMELIHARAAN, TSO, KETERANGAN_DOWNTIME, SO, HASIL, KESIAPAN_OPERASI, OFF, DOWNTIME2, UPDATED_DATE, UPDATED_BY
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
	
	function insertDataProduksi()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_PRODUKSI_ID", $this->getNextId("KAPAL_PRODUKSI_ID","PPI_OPERASIONAL.KAPAL_PRODUKSI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_PRODUKSI (
				   KAPAL_PRODUKSI_ID, KAPAL_ID, LOKASI_ID, 
				   PERIODE, TANGGAL_AWAL, TANGGAL_AKHIR, 
				   REALISASI_PRODUKSI, REALISASI_PRODUKSI_MENIT, LAST_CREATE_USER, LAST_CREATE_DATE)   
 			  	VALUES (
				  ".$this->getField("KAPAL_PRODUKSI_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("PERIODE")."',
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  '".$this->getField("REALISASI_PRODUKSI")."',
				  '".$this->getField("REALISASI_PRODUKSI_MENIT")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("KAPAL_PRODUKSI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateDataProduksi()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_PRODUKSI
				SET    
					   KAPAL_ID         	= '".$this->getField("KAPAL_ID")."',
					   LOKASI_ID	 		= '".$this->getField("LOKASI_ID")."',
					   PERIODE	 			= '".$this->getField("PERIODE")."',
					   TANGGAL_AWAL	 		= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR		= ".$this->getField("TANGGAL_AKHIR").",
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  KAPAL_PRODUKSI_ID 	= '".$this->getField("KAPAL_PRODUKSI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function selectDataProduksi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.KAPAL_ID ASC")
	{
		$str = "
				SELECT KAPAL_PRODUKSI_ID, KAPAL_ID, LOKASI_ID, PERIODE, TO_CHAR(TANGGAL_AWAL, 'DDMMYYYY') TANGGAL_AWAL, TO_CHAR(TANGGAL_AKHIR, 'DDMMYYYY') TANGGAL_AKHIR, REALISASI_PRODUKSI, 
						LAST_CREATE_USER, TO_CHAR(LAST_CREATE_DATE, 'DDMMYYYY HH24:MI') LAST_CREATE_DATE, LAST_UPDATE_USER, TO_CHAR(LAST_UPDATE_DATE, 'DDMMYYYY HH24:MI') LAST_UPDATE_DATE,
						REALISASI_PRODUKSI_MENIT
				FROM LOH.KAPAL_PRODUKSI A
				WHERE KAPAL_PRODUKSI_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
	function selectDataSystemParameter($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KODE ASC")
		{
				$str = "SELECT KODE, NILAI, KETERANGAN FROM PPI.SETTING_APLIKASI
						WHERE KODE LIKE 'WS_%'
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
	
		function selectDataKapalLokasi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY HARI ASC")
		{
				$str = "
						SELECT KAPAL_LOKASI_ID, KAPAL_ID, LOKASI_ID, TO_CHAR(TANGGAL_AWAL, 'DDMMYYYY') TANGGAL_AWAL, TO_CHAR(TANGGAL_AKHIR, 'DDMMYYYY') TANGGAL_AKHIR, 
								LAST_CREATE_USER, TO_CHAR(LAST_CREATE_DATE, 'DDMMYYYY HH24:MI') LAST_CREATE_DATE,
								LAST_UPDATE_USER, TO_CHAR(LAST_UPDATE_DATE , 'DDMMYYYY HH24:MI') LAST_UPDATE_DATE
						FROM PPI_OPERASIONAL.KAPAL_LOKASI
						WHERE 0=0 
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
		
		function selectDataMasterKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY HARI ASC")
		{
				$str = "SELECT KAPAL_ID, KAPAL_JENIS_ID, KAPAL_KEPEMILIKAN_ID, KODE, CALL_SIGN, IMO_NUMBER, NAMA, PERUSAHAAN_BANGUN, TEMPAT_BANGUN, TAHUN_BANGUN, GT, NT, LOA, BREADTH, DEPTH, DRAFT, MESIN_INDUK, MESIN_BANTU, MESIN_DAYA, MESIN_RPM, POMPA, ISI_TANGKI, AIR_BERSIH, KECEPATAN, STATUS_KESIAPAN, BENDERA, JUMLAH_KRU, LAST_CREATE_USER, TO_CHAR(LAST_CREATE_DATE, 'DDMMYYYY HH24:MI') LAST_CREATE_DATE, LAST_UPDATE_USER, TO_CHAR(LAST_UPDATE_DATE, 'DDMMYYYY HH24:MI') LAST_UPDATE_DATE, NO_KARTU, JENIS_PROPULSI, HORSE_POWER_ID, BENDERA_ID, TANDA_SELAR, PELANGGAN_ID, PUSPEL, JENIS_BAHAN
						FROM PPI_OPERASIONAL.KAPAL
						WHERE 0=0
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
		
		function selectDataUserLogin($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY HARI ASC")
		{
				$str = "SELECT USER_LOGIN_ID, DEPARTEMEN_ID, USER_GROUP_ID, NAMA, JABATAN, EMAIL, TELEPON, STATUS, 
						USER_LOGIN, USER_PASS, LAST_CREATE_USER, TO_CHAR(LAST_CREATE_DATE, 'DDMMYYYY HH24:MI') LAST_CREATE_DATE, LAST_UPDATE_USER, TO_CHAR(LAST_UPDATE_DATE, 'DDMMYYYY HH24:MI') LAST_UPDATE_DATE, PEGAWAI_ID, KAPAL_ID FROM PPI.USER_LOGIN
						WHERE 0=0
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
		
		function selectDataPeriodeProduksi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY TAGIHAN_PERIODE_ID ASC")
		{
				$str = "SELECT TAGIHAN_PERIODE_ID, PERIODE FROM PPI_OPERASIONAL.TAGIHAN_PERIODE
						WHERE 0=0
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
	
  } 
?>