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

  class Kapal extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Kapal()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_ID", $this->getNextId("KAPAL_ID","PPI_OPERASIONAL.KAPAL"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL (
				   KAPAL_ID, KAPAL_JENIS_ID, 
				   KODE, CALL_SIGN, IMO_NUMBER, 
				   NAMA, PERUSAHAAN_BANGUN, TEMPAT_BANGUN, 
				   TAHUN_BANGUN, GT, NT, 
				   LOA, BREADTH, DEPTH, 
				   DRAFT, MESIN_INDUK, MESIN_BANTU, 
				   MESIN_DAYA, MESIN_RPM, POMPA, 
				   ISI_TANGKI, AIR_BERSIH, KECEPATAN, 
				   STATUS_KESIAPAN, BENDERA, JUMLAH_KRU, LAST_CREATE_USER, LAST_CREATE_DATE, 
				   NO_KARTU, JENIS_PROPULSI, BENDERA_ID, HORSE_POWER_ID, TANDA_SELAR, PELANGGAN_ID,JENIS_BAHAN) 
 			  	VALUES (
				  ".$this->getField("KAPAL_ID").",
				  '".$this->getField("KAPAL_JENIS_ID")."',
				  '".$this->getField("KODE")."',
				  '".$this->getField("CALL_SIGN")."',
				  '".$this->getField("IMO_NUMBER")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("PERUSAHAAN_BANGUN")."',
				  '".$this->getField("TEMPAT_BANGUN")."',
				  '".$this->getField("TAHUN_BANGUN")."',
				  '".$this->getField("GT")."',
				  '".$this->getField("NT")."',
				  '".$this->getField("LOA")."',
				  '".$this->getField("BREADTH")."',
				  '".$this->getField("DEPTH")."',
				  '".$this->getField("DRAFT")."',
				  '".$this->getField("MESIN_INDUK")."',
				  '".$this->getField("MESIN_BANTU")."',
				  '".$this->getField("MESIN_DAYA")."',
				  '".$this->getField("MESIN_RPM")."',
				  '".$this->getField("POMPA")."',
				  '".$this->getField("ISI_TANGKI")."',
				  '".$this->getField("AIR_BERSIH")."',
				  '".$this->getField("KECEPATAN")."',
				  '".$this->getField("STATUS_KESIAPAN")."',
				  '".$this->getField("BENDERA")."',
				  '".$this->getField("JUMLAH_KRU")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("NO_KARTU")."',
				  '".$this->getField("JENIS_PROPULSI")."',
				  '".$this->getField("BENDERA_ID")."',
				  '".$this->getField("HORSE_POWER_ID")."',
				  '".$this->getField("TANDA_SELAR")."',
				  '".$this->getField("PELANGGAN_ID")."',
				  ".$this->getField("JENIS_BAHAN")."				  
				)"; 
		$this->id = $this->getField("KAPAL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL
				SET    
					   KAPAL_JENIS_ID       = '".$this->getField("KAPAL_JENIS_ID")."',
					   KODE	 				= '".$this->getField("KODE")."',
					   CALL_SIGN	 		= '".$this->getField("CALL_SIGN")."',
					   IMO_NUMBER	 		= '".$this->getField("IMO_NUMBER")."',
					   NAMA	 				= '".$this->getField("NAMA")."',
					   PERUSAHAAN_BANGUN	= '".$this->getField("PERUSAHAAN_BANGUN")."',
					   TEMPAT_BANGUN	 	= '".$this->getField("TEMPAT_BANGUN")."',
					   TAHUN_BANGUN	 		= '".$this->getField("TAHUN_BANGUN")."',
					   GT	 				= '".$this->getField("GT")."',
					   NT	 				= '".$this->getField("NT")."',
					   LOA	 				= '".$this->getField("LOA")."',
					   BREADTH	 			= '".$this->getField("BREADTH")."',
					   DEPTH	 			= '".$this->getField("DEPTH")."',
					   DRAFT	 			= '".$this->getField("DRAFT")."',
					   MESIN_INDUK	 		= '".$this->getField("MESIN_INDUK")."',
					   MESIN_BANTU	 		= '".$this->getField("MESIN_BANTU")."',
					   MESIN_DAYA	 		= '".$this->getField("MESIN_DAYA")."',
					   MESIN_RPM	 		= '".$this->getField("MESIN_RPM")."',
					   POMPA	 			= '".$this->getField("POMPA")."',
					   ISI_TANGKI	 		= '".$this->getField("ISI_TANGKI")."',
					   AIR_BERSIH	 		= '".$this->getField("AIR_BERSIH")."',
					   KECEPATAN	 		= '".$this->getField("KECEPATAN")."',
					   STATUS_KESIAPAN	 	= '".$this->getField("STATUS_KESIAPAN")."',
					   BENDERA	 			= '".$this->getField("BENDERA")."',
					   JUMLAH_KRU 			= '".$this->getField("JUMLAH_KRU")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE").",
					   NO_KARTU				= '".$this->getField("NO_KARTU")."',
					   JENIS_PROPULSI		= '".$this->getField("JENIS_PROPULSI")."',
					   BENDERA_ID			= '".$this->getField("BENDERA_ID")."',
					   HORSE_POWER_ID		= '".$this->getField("HORSE_POWER_ID")."',
					   TANDA_SELAR			= '".$this->getField("TANDA_SELAR")."',
					   PELANGGAN_ID			= '".$this->getField("PELANGGAN_ID")."',
					   JENIS_BAHAN			= ".$this->getField("JENIS_BAHAN")."
				WHERE  KAPAL_ID  			= '".$this->getField("KAPAL_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	function updateIdWeb(){
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL 
				SET    
					KAPAL_ID_WEBSITE	= '".$this->getField("KAPAL_ID_WEBSITE")."'
				WHERE  KAPAL_ID     = '".$this->getField("KAPAL_ID")."'

			 ";  
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
	}
	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL
                WHERE 
                  KAPAL_ID = ".$this->getField("KAPAL_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callHitungPremi()
	{
        $str = "
				CALL PPI_GAJI.PROSES_HITUNG_PREMI()
		"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
	
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
	
	
	
    function selectByParamsParseTable($table)
	{
		$str = "
				SELECT 
                A.".$table."_ID, KODE, A.NAMA
                FROM PPI_OPERASIONAL.".$table." A 
                WHERE 1=1
				"; 
		$this->query = $str;
		
		return $this->selectLimit($str,-1,-1); 				
	}
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.KAPAL_ID ASC")
	{
		$str = "
				SELECT 
                A.KAPAL_ID, A.KAPAL_JENIS_ID, A.PELANGGAN_ID KAPAL_KEPEMILIKAN_ID, A.KODE, CALL_SIGN, IMO_NUMBER, A.KAPAL_ID_WEBSITE,
                   A.NAMA, PERUSAHAAN_BANGUN, TEMPAT_BANGUN, TAHUN_BANGUN, GT, NT, 
                   LOA, BREADTH, DEPTH, DRAFT, MESIN_INDUK, MESIN_BANTU, 
                   MESIN_DAYA, MESIN_RPM, POMPA, ISI_TANGKI, AIR_BERSIH, KECEPATAN, NO_KARTU, JENIS_PROPULSI, BENDERA_ID, A.HORSE_POWER_ID, D.NAMA HORSE_POWER_NAMA, CEIL(D.NAMA * 746 / 1000) DAYA_KW,
                   FOTO, STATUS_KESIAPAN, BENDERA, B.NAMA KAPAL_JENIS_NAMA, C.LOKASI_NAMA, (SELECT COUNT(PEGAWAI_ID) FROM PPI_OPERASIONAL.PEGAWAI_KAPAL X WHERE X.KAPAL_ID = A.KAPAL_ID) JUMLAH_KRU, TANDA_SELAR, A.PELANGGAN_ID, E.NAMA PELANGGAN_NAMA, JENIS_BAHAN
                FROM PPI_OPERASIONAL.KAPAL A 
                LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS B ON B.KAPAL_JENIS_ID=A.KAPAL_JENIS_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR C ON A.KAPAL_ID=C.KAPAL_ID
				LEFT JOIN PPI_OPERASIONAL.HORSE_POWER D ON A.HORSE_POWER_ID=D.HORSE_POWER_ID
				LEFT JOIN PPI_OPERASIONAL.PELANGGAN E ON A.PELANGGAN_ID=E.PELANGGAN_ID                
                WHERE 1=1
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
	
    function selectByParamsKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.NAMA ASC")
	{
		$str = "
				SELECT 
                A.KAPAL_ID, A.NAMA
				FROM PPI_OPERASIONAL.KAPAL A          
                WHERE 1=1
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
	
	function selectByParamsKapalPelanggan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NAMA_KAPAL ASC")
	{
		$str = "
				SELECT KODE_KAPAL, JENIS_KAPAL_NAMA, JENIS_PELAYARAN, NAMA_KAPAL, GRT, DWT, LOA 
					   FROM MEKARPUTIH.V_MASTER_KAPAL         
                WHERE 1=1
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

    function selectByParamsKapalTarif($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqTarifSbppId="", $order="ORDER BY A.KAPAL_ID ASC")
	{
		$str = "
				SELECT 
					A.KAPAL_ID, A.NAMA, B.JUMLAH,
					CASE 
					WHEN D.NAMA IS NULL THEN MESIN_DAYA
					ELSE MESIN_DAYA || ' x ' ||   D.NAMA || ' HP'
					END HORSE_POWER_NAMA,
					C.NAMA KAPAL_JENIS_NAMA, B.TARIF_SBPP_ID
                FROM PPI_OPERASIONAL.KAPAL A 
                LEFT JOIN PPI_OPERASIONAL.TARIF_SBPP_KAPAL B ON B.KAPAL_ID=A.KAPAL_ID AND B.TARIF_SBPP_ID = '".$reqTarifSbppId."'
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS C ON C.KAPAL_JENIS_ID=A.KAPAL_JENIS_ID
				LEFT JOIN PPI_OPERASIONAL.HORSE_POWER D ON A.HORSE_POWER_ID=D.HORSE_POWER_ID
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

	
	function selectByParamsPencarianKapalLama($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.NAMA ASC")
	{
		$str = "
 				SELECT A.KAPAL_ID, A.NAMA KAPAL_NAMA, C.NAMA KAPAL_KEPEMILIKAN_NAMA, 
				CASE WHEN D.KONTRAK_SBPP_ID IS NOT NULL 
					 THEN D.NAMA 
					 WHEN F.KAPAL_PEKERJAAN_ID IS NOT NULL 
					 THEN F.NAMA 
					 WHEN G.KONTRAK_TOWING_ID IS NOT NULL 
					 THEN G.NAMA 
					 WHEN H.PENUGASAN_ID IS NOT NULL 
					 THEN H.NAMA  
                     WHEN I.KAPAL_PEKERJAAN_SEWA_ID IS NOT NULL 
					 THEN I.NAMA
                END LOKASI_TERAKHIR, B.TANGGAL_MASUK TANGGAL_AWAL, B.TANGGAL_KELUAR TANGGAL_AKHIR, MESIN_DAYA || ' x ' || E.NAMA HP,
                B.KAPAL_HISTORI_ID
                 FROM PPI_OPERASIONAL.KAPAL A
                LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI_TERAKHIR B ON A.KAPAL_ID = B.KAPAL_ID
                LEFT JOIN PPI_OPERASIONAL.PELANGGAN C ON A.PELANGGAN_ID = C.PELANGGAN_ID
                LEFT JOIN PPI_OPERASIONAL.KONTRAK_SBPP D ON B.KONTRAK_SBPP_ID = D.KONTRAK_SBPP_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL_PEKERJAAN F ON B.KAPAL_PEKERJAAN_ID = F.KAPAL_PEKERJAAN_ID
                LEFT JOIN PPI_OPERASIONAL.KONTRAK_TOWING G ON B.KONTRAK_TOWING_ID = G.KONTRAK_TOWING_ID
                LEFT JOIN PPI_OPERASIONAL.PENUGASAN H ON B.PENUGASAN_ID = H.PENUGASAN_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL_PEKERJAAN_SEWA I ON B.KAPAL_PEKERJAAN_SEWA_ID = I.KAPAL_PEKERJAAN_SEWA_ID
                LEFT JOIN PPI_OPERASIONAL.HORSE_POWER E ON A.HORSE_POWER_ID = E.HORSE_POWER_ID
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
	
	function selectByParamsPencarianKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.NAMA ASC")
	{
		$str = "
 				SELECT A.KAPAL_ID, A.NAMA KAPAL_NAMA, C.NAMA KAPAL_KEPEMILIKAN_NAMA, 
				CASE WHEN D.KONTRAK_SBPP_ID IS NOT NULL 
					 THEN D.NAMA 
					 WHEN F.KAPAL_PEKERJAAN_ID IS NOT NULL 
					 THEN F.NAMA 
					 WHEN G.KONTRAK_TOWING_ID IS NOT NULL 
					 THEN G.NAMA 
					 WHEN H.PENUGASAN_ID IS NOT NULL 
					 THEN H.NAMA
                END LOKASI_TERAKHIR, B.TANGGAL_MASUK TANGGAL_AWAL, B.TANGGAL_KELUAR TANGGAL_AKHIR, MESIN_DAYA || ' x ' || E.NAMA HP,
                B.KAPAL_HISTORI_ID
                 FROM PPI_OPERASIONAL.KAPAL A
                LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI_TERAKHIR B ON A.KAPAL_ID = B.KAPAL_ID AND B.STATUS = 1 AND TANGGAL_KELUAR IS NULL
                LEFT JOIN PPI_OPERASIONAL.PELANGGAN C ON A.PELANGGAN_ID = C.PELANGGAN_ID
                LEFT JOIN PPI_OPERASIONAL.KONTRAK_SBPP D ON B.KONTRAK_SBPP_ID = D.KONTRAK_SBPP_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL_PEKERJAAN F ON B.KAPAL_PEKERJAAN_ID = F.KAPAL_PEKERJAAN_ID
                LEFT JOIN PPI_OPERASIONAL.KONTRAK_TOWING G ON B.KONTRAK_TOWING_ID = G.KONTRAK_TOWING_ID
                LEFT JOIN PPI_OPERASIONAL.PENUGASAN H ON B.PENUGASAN_ID = H.PENUGASAN_ID
                LEFT JOIN PPI_OPERASIONAL.HORSE_POWER E ON A.HORSE_POWER_ID = E.HORSE_POWER_ID
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
	
	function selectByParamsSyncData($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY nvl(b.lokasi_id,C.lokasi_id ), d.nama, a.nama", $reqPeriode="")
	{ 
		$str = "
				SELECT distinct a.kapal_id, a.kode, nvl(b.lokasi_id,C.lokasi_id ) lokasi_id, a.nama KAPAL, 
				D.NAMA JENIS_KAPAL, nvl(B.NAMA, e.nama) LOKASI_TERAKHIR, TO_CHAR(G.LAST_UPDATE_DATE, 'dd MON YYYY HH24:MI') LAST_UPDATE_DATE, G.LAST_UPDATE_BY
				FROM PPI_OPERASIONAL.KAPAL A 
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS D ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID 
				JOIN PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_WS G ON A.KAPAL_ID = G.KAPAL_ID AND PERIODE = '".$reqPeriode."'
				LEFT JOIN PPI_OPERASIONAL.LOKASI B ON G.LOKASI_ID = B.LOKASI_ID
				left join PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR C on C.kapal_id = a.kapal_id
				LEFT JOIN PPI_OPERASIONAL.LOKASI E ON C.LOKASI_ID = E.LOKASI_ID
				WHERE 0=0
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$order;
//									echo $str;exit;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }	
	
    function selectByParamsRealisasiProduksi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KONTRAK_SBPP_ID DESC", $reqPeriode="")
	{ 
		$str = "
				SELECT  A.KAPAL_ID, 
                A.KODE, A.CALL_SIGN, A.NAMA KAPAL, D.NAMA JENIS_KAPAL,
                F.JUMLAH TARIF_PER_TAHUN, ROUND(F.JUMLAH / 12) TARIF_PER_BULAN,
                CASE WHEN H.LOKASI_ID IS NULL THEN 'BELUM DITENTUKAN' ELSE H.LOKASI_NAMA END LOKASI_TERAKHIR, 
                PERIODE, H.LOKASI_ID, D.KAPAL_JENIS_ID,
                SUM(JUMLAH_GERAKAN) JML_GERAK, 
                PPI_OPERASIONAL.AMBIL_REALISASI_GRT(A.KAPAL_ID, PERIODE) GRT,
                PPI_OPERASIONAL.AMBIL_REALISASI_PRODUKSI(A.KAPAL_ID, PERIODE) REALISASI,
                PPI_OPERASIONAL.AMBIL_REALISASI_TUNDA(A.KAPAL_ID, PERIODE) TUNDA,
                PPI_OPERASIONAL.AMBIL_REALISASI_ME(A.KAPAL_ID, PERIODE) ME,
                PPI_OPERASIONAL.AMBIL_REALISASI_AE1(A.KAPAL_ID, PERIODE) AE1,
                PPI_OPERASIONAL.AMBIL_REALISASI_AE2(A.KAPAL_ID, PERIODE) AE2,
                PPI_OPERASIONAL.AMBIL_REALISASI_AW(A.KAPAL_ID, PERIODE) AW,
                PPI_OPERASIONAL.AMBIL_REALISASI_AK(A.KAPAL_ID, PERIODE) AK,
                SUM(BBM_PAKAI) BBM_PAKAI,
                SUM(BBM_BUNKER) BBM_BUNKER, 
                SUM(BBM_SUPPLY) BBM_SUPPLY, 
                (SELECT BBM_SISA FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO X WHERE X.KAPAL_ID = A.KAPAL_ID AND X.PERIODE = G.PERIODE AND HARI = TO_CHAR(LAST_DAY(TO_DATE(G.PERIODE, 'MMYYYY')), 'DD')) BBM_SISA, 
                SUM(AIR_PAKAI) AIR_PAKAI, 
                SUM(AIR_ISI) AIR_ISI, 
                (SELECT AIR_SISA FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO X WHERE X.KAPAL_ID = A.KAPAL_ID AND X.PERIODE = G.PERIODE AND HARI = TO_CHAR(LAST_DAY(TO_DATE(G.PERIODE, 'MMYYYY')), 'DD')) AIR_SISA, 
                SUM(ABK_HADIR) ABK_HADIR, 
                PPI_OPERASIONAL.AMBIL_REALISASI_DOWNTIME(A.KAPAL_ID, PERIODE) DOWNTIME
                FROM PPI_OPERASIONAL.KAPAL A 
                LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS D ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR H ON A.KAPAL_ID = H.KAPAL_ID
                LEFT JOIN PPI_OPERASIONAL.TARIF_SBPP_KAPAL_TERAKHIR F ON A.KAPAL_ID = F.KAPAL_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO G ON A.KAPAL_ID = G.KAPAL_ID AND PERIODE = '".$reqPeriode."'
                WHERE 1 = 1 
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
							GROUP BY A.KAPAL_ID, 
									A.KODE, A.CALL_SIGN, A.NAMA, D.NAMA,
									F.JUMLAH, H.LOKASI_ID, H.LOKASI_NAMA, PERIODE, D.KAPAL_JENIS_ID
									".$order;
//									echo $str;exit;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	function selectByParamsRealisasiUtilisasi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="", $reqPeriode="")
	{ 
		$str = "
				SELECT  A.KAPAL_ID, 
				A.NAMA KAPAL, D.NAMA JENIS_KAPAL,
				PERIODE, H.LOKASI_ID, D.KAPAL_JENIS_ID,
				PPI_OPERASIONAL.AMBIL_REALISASI_PRODUKSI(A.KAPAL_ID, PERIODE) REALISASI,
				ROUND(PPI_OPERASIONAL.CONVERT_TIME_TO_NUMBER(PPI_OPERASIONAL.AMBIL_REALISASI_PRODUKSI(A.KAPAL_ID, PERIODE)),2) JML_WAKTU_PRODUKSI,
				TO_CHAR(LAST_DAY(TO_DATE('01".$reqPeriode."', 'ddmmyyyy')),'DD') * 24 WAKTU_TERSEDIA,
				PPI_OPERASIONAL.AMBIL_PERIODE_PERBAIKAN(A.KAPAL_ID, '".$reqPeriode."') PERBAIKAN,
				PPI_OPERASIONAL.AMBIL_PERIODE_PEMELIHARAAN(A.KAPAL_ID, '".$reqPeriode."') PEMELIHARAAN,
				PPI_OPERASIONAL.AMBIL_PERIODE_RUSAK(A.KAPAL_ID, '".$reqPeriode."') RUSAK
				FROM PPI_OPERASIONAL.KAPAL A 
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS D ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID
				LEFT JOIN PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR H ON A.KAPAL_ID = H.KAPAL_ID
				LEFT JOIN PPI_OPERASIONAL.TARIF_SBPP_KAPAL_TERAKHIR F ON A.KAPAL_ID = F.KAPAL_ID
				LEFT JOIN PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO G ON A.KAPAL_ID = G.KAPAL_ID AND PERIODE = '".$reqPeriode."'
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
							GROUP BY D.KAPAL_JENIS_ID, D.NAMA, A.NAMA, A.KAPAL_ID, F.JUMLAH, H.LOKASI_ID, H.LOKASI_NAMA, PERIODE
									".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsRealisasiUtilisasi1($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KONTRAK_SBPP_ID DESC", $reqMaxBulan="", $reqPeriode="")
	{ 
		$str = "
				SELECT  A.KAPAL_ID, 
                A.NAMA KAPAL, D.NAMA JENIS_KAPAL,
                PERIODE, H.LOKASI_ID, D.KAPAL_JENIS_ID,
                PPI_OPERASIONAL.AMBIL_REALISASI_PRODUKSI(A.KAPAL_ID, PERIODE) REALISASI,
                ROUND(PPI_OPERASIONAL.CONVERT_TIME_TO_NUMBER(PPI_OPERASIONAL.AMBIL_REALISASI_PRODUKSI(A.KAPAL_ID, PERIODE)),2) JML_WAKTU_PRODUKSI,
				24 TOTAL_JAM,
                ROUND(
                    ROUND(PPI_OPERASIONAL.CONVERT_TIME_TO_NUMBER(PPI_OPERASIONAL.AMBIL_REALISASI_PRODUKSI(A.KAPAL_ID, PERIODE)),2)
                    / (".$reqMaxBulan." * 24) * 100, 2) PERSEN_PRODUKSI
                FROM PPI_OPERASIONAL.KAPAL A 
                LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS D ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR H ON A.KAPAL_ID = H.KAPAL_ID
                LEFT JOIN PPI_OPERASIONAL.TARIF_SBPP_KAPAL_TERAKHIR F ON A.KAPAL_ID = F.KAPAL_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO G ON A.KAPAL_ID = G.KAPAL_ID AND PERIODE = '".$reqPeriode."'
                WHERE 1 = 1 
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
							GROUP BY D.KAPAL_JENIS_ID, D.NAMA, A.NAMA, A.KAPAL_ID, F.JUMLAH, H.LOKASI_ID, H.LOKASI_NAMA, PERIODE
									".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsKesiapanKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $periode="", $hari="", $order="ORDER BY A.KAPAL_ID ASC")
	{
		$str = "
					SELECT
							(
								SELECT Z.NAMA
								FROM PPI_OPERASIONAL.PEGAWAI_KAPAL X
								INNER JOIN PPI_OPERASIONAL.KAPAL_KRU Y ON X.KAPAL_KRU_ID = Y.KAPAL_KRU_ID AND Y.KRU_JABATAN_ID = 1
								INNER JOIN PPI_SIMPEG.PEGAWAI Z ON X.PEGAWAI_ID = Z.PEGAWAI_ID
								INNER JOIN
								 (
								 SELECT MAX(X.TANGGAL_MASUK) TANGGAL_MASUK, X.KAPAL_ID
								 FROM PPI_OPERASIONAL.PEGAWAI_KAPAL X
								 INNER JOIN PPI_OPERASIONAL.KAPAL_KRU Y ON X.KAPAL_KRU_ID = Y.KAPAL_KRU_ID AND Y.KRU_JABATAN_ID = 1
								 INNER JOIN PPI_SIMPEG.PEGAWAI Z ON X.PEGAWAI_ID = Z.PEGAWAI_ID
								 GROUP BY X.KAPAL_ID
								 ) W ON W.TANGGAL_MASUK = X.TANGGAL_MASUK AND X.KAPAL_ID = W.KAPAL_ID
								 WHERE X.KAPAL_ID = A.KAPAL_ID AND ROWNUM=1
							) NAHKODA,
							 A.KAPAL_ID, A.KODE, A.CALL_SIGN, A.NAMA KAPAL, D.NAMA JENIS_KAPAL, KONTRAK_SBPP_ID, KONTRAK_TOWING_ID,  KAPAL_PEKERJAAN_ID, PENUGASAN_ID, 
							 F.JUMLAH TARIF_PER_TAHUN, ROUND (F.JUMLAH / 12) TARIF_PER_BULAN,
							 CASE WHEN KONTRAK_SBPP_ID IS NULL THEN         
								CASE WHEN KONTRAK_TOWING_ID IS NOT NULL THEN H.LOKASI_NAMA || ' - TOWING'
									 WHEN KAPAL_PEKERJAAN_ID IS NOT NULL THEN H.LOKASI_NAMA || ' - TIME CHARTER'
									 WHEN PENUGASAN_ID IS NOT NULL THEN H.LOKASI_NAMA || ' - PENUGASAN'      
									 WHEN H.LOKASI_ID IS NULL THEN 'BELUM DITENTUKAN'    
									 ELSE H.LOKASI_NAMA || ' - NON KONTRAK'      
								END
							 ELSE
							 CASE
								WHEN H.LOKASI_ID IS NULL
								   THEN 'BELUM DITENTUKAN'
								ELSE H.LOKASI_NAMA || ' - KONTRAK SBPP'
							 END END LOKASI_TERAKHIR,
						 PERIODE, H.LOKASI_ID, D.KAPAL_JENIS_ID,
						 PPI_OPERASIONAL.AMBIL_REALISASI_DOWNTIME_INFO
																		(A.KAPAL_ID,
																		 '".$periode."',
																		 '".(int)$hari."'
																		) STATUS,
						 PPI_OPERASIONAL.AMBIL_REALISASI_DOWNTIME_INFOD (A.KAPAL_ID,
																			'".$periode."',
																			'".(int)$hari."'
																		   ) JAM
					FROM PPI_OPERASIONAL.KAPAL A LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS D
						 ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID
						 LEFT JOIN PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR H
						 ON A.KAPAL_ID = H.KAPAL_ID
						 LEFT JOIN PPI_OPERASIONAL.TARIF_SBPP_KAPAL_TERAKHIR F
						 ON A.KAPAL_ID = F.KAPAL_ID
						 LEFT JOIN PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO G
						 ON A.KAPAL_ID = G.KAPAL_ID AND PERIODE = '".$periode."'
						 LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI_TERAKHIR K ON A.KAPAL_ID = K.KAPAL_ID  AND TANGGAL_KELUAR IS NULL
				   WHERE 1 = 1				
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.KAPAL_ID,
						 A.KODE,
						 A.CALL_SIGN,
						 A.NAMA,
						 D.NAMA,
						 F.JUMLAH,
						 H.LOKASI_ID,
						 H.LOKASI_NAMA,
						 PERIODE,
						 D.KAPAL_JENIS_ID, KONTRAK_SBPP_ID, KONTRAK_TOWING_ID,  KAPAL_PEKERJAAN_ID, PENUGASAN_ID
				".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsKesiapanKapalVerifikasi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $periode="", $hari="", $order="ORDER BY b.lokasi_nama, b.nama ")
	{
		$str = "select a.kesiapan_id, a.periode, b.nama KAPAL, 
							(
								SELECT Z.NAMA
								FROM PPI_OPERASIONAL.PEGAWAI_KAPAL X
								INNER JOIN PPI_OPERASIONAL.KAPAL_KRU Y ON X.KAPAL_KRU_ID = Y.KAPAL_KRU_ID AND Y.KRU_JABATAN_ID = 1
								INNER JOIN PPI_SIMPEG.PEGAWAI Z ON X.PEGAWAI_ID = Z.PEGAWAI_ID
								INNER JOIN
								 (
								 SELECT MAX(X.TANGGAL_MASUK) TANGGAL_MASUK, X.KAPAL_ID
								 FROM PPI_OPERASIONAL.PEGAWAI_KAPAL X
								 INNER JOIN PPI_OPERASIONAL.KAPAL_KRU Y ON X.KAPAL_KRU_ID = Y.KAPAL_KRU_ID AND Y.KRU_JABATAN_ID = 1
								 INNER JOIN PPI_SIMPEG.PEGAWAI Z ON X.PEGAWAI_ID = Z.PEGAWAI_ID
								 GROUP BY X.KAPAL_ID
								 ) W ON W.TANGGAL_MASUK = X.TANGGAL_MASUK AND X.KAPAL_ID = W.KAPAL_ID
								 WHERE X.KAPAL_ID = A.KAPAL_ID
							) NAHKODA,
                            b.lokasi_nama,
                            CASE 
                            WHEN TSO IS NOT NULL THEN 'TSO' 
                            WHEN OFF IS NOT NULL THEN 'OFF' 
                            WHEN RUSAK IS NOT NULL THEN 'D' 
                            WHEN PERBAIKAN IS NOT NULL THEN 'P' 
                            ELSE 'SO' END STATUS_DOWNTIME,
                            MULAI || ' - ' || SELESAI JAM,
                            keterangan,
							STATUS,
							TO_CHAR(NVL(A.UPDATE_DATE, A.CREATE_DATE), 'DD MON YYYY HH24:MI') TGL_ENTRI
							from PPI_operasional.KESIAPAN_KAPAL A JOIN PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR B ON A.KAPAL_ID = B.KAPAL_ID 
							WHERE PERIODE = '" . $hari.$periode . "'"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$order;
		//echo $str;exit;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsRealisasiProduksiApproval($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KONTRAK_SBPP_ID DESC", $reqPeriode="")
	{ 
		$str = "
				SELECT  A.KAPAL_ID, 
                A.KODE, A.CALL_SIGN, A.NAMA KAPAL, D.NAMA JENIS_KAPAL,
                F.JUMLAH TARIF_PER_TAHUN, ROUND(F.JUMLAH / 12) TARIF_PER_BULAN,
                CASE WHEN H.LOKASI_ID IS NULL THEN 'BELUM DITENTUKAN' ELSE H.LOKASI_NAMA END LOKASI_TERAKHIR, 
                PERIODE, H.LOKASI_ID, D.KAPAL_JENIS_ID,
                SUM(JUMLAH_GERAKAN) JML_GERAK, 
                PPI_OPERASIONAL.AMBIL_REALISASI_GRT(A.KAPAL_ID, PERIODE) GRT,
                PPI_OPERASIONAL.AMBIL_REALISASI_PRODUKSI(A.KAPAL_ID, PERIODE) REALISASI,
                PPI_OPERASIONAL.AMBIL_REALISASI_TUNDA(A.KAPAL_ID, PERIODE) TUNDA,
                PPI_OPERASIONAL.AMBIL_REALISASI_ME(A.KAPAL_ID, PERIODE) ME,
                PPI_OPERASIONAL.AMBIL_REALISASI_AE1(A.KAPAL_ID, PERIODE) AE1,
                PPI_OPERASIONAL.AMBIL_REALISASI_AE2(A.KAPAL_ID, PERIODE) AE2,
                PPI_OPERASIONAL.AMBIL_REALISASI_AW(A.KAPAL_ID, PERIODE) AW,
                PPI_OPERASIONAL.AMBIL_REALISASI_AK(A.KAPAL_ID, PERIODE) AK,
                SUM(BBM_PAKAI) BBM_PAKAI,
                SUM(BBM_BUNKER) BBM_BUNKER, 
                SUM(BBM_SUPPLY) BBM_SUPPLY, 
                (SELECT BBM_SISA FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO X WHERE X.KAPAL_ID = A.KAPAL_ID AND X.PERIODE = G.PERIODE AND HARI = TO_CHAR(LAST_DAY(TO_DATE(G.PERIODE, 'MMYYYY')), 'DD')) BBM_SISA, 
                SUM(AIR_PAKAI) AIR_PAKAI, 
                SUM(AIR_ISI) AIR_ISI, 
                (SELECT AIR_SISA FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO X WHERE X.KAPAL_ID = A.KAPAL_ID AND X.PERIODE = G.PERIODE AND HARI = TO_CHAR(LAST_DAY(TO_DATE(G.PERIODE, 'MMYYYY')), 'DD')) AIR_SISA, 
                SUM(ABK_HADIR) ABK_HADIR, 
                PPI_OPERASIONAL.AMBIL_REALISASI_DOWNTIME(A.KAPAL_ID, PERIODE) DOWNTIME
                FROM PPI_OPERASIONAL.KAPAL A 
                LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS D ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR H ON A.KAPAL_ID = H.KAPAL_ID
                LEFT JOIN PPI_OPERASIONAL.TARIF_SBPP_KAPAL_TERAKHIR F ON A.KAPAL_ID = F.KAPAL_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO G ON A.KAPAL_ID = G.KAPAL_ID AND PERIODE = '".$reqPeriode."'
                WHERE 1 = 1 AND NOT EXISTS(SELECT 1 FROM PPI_OPERASIONAL.KAPAL_PRODUKSI X WHERE A.KAPAL_ID = X.KAPAL_ID AND TO_CHAR(X.TANGGAL_AWAL, 'MMYYYY') = '".$reqPeriode."')
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
							GROUP BY A.KAPAL_ID, 
									A.KODE, A.CALL_SIGN, A.NAMA, D.NAMA,
									F.JUMLAH, H.LOKASI_ID, H.LOKASI_NAMA, PERIODE, D.KAPAL_JENIS_ID
									".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }	
		
	function selectByParamsRealisasiDownTimeBak_02April2014($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KONTRAK_SBPP_ID DESC", $reqPeriode="")
	{ 
		$str = "
				SELECT  A.KAPAL_ID, 
                A.KODE, A.CALL_SIGN, A.NAMA KAPAL, D.NAMA JENIS_KAPAL,
                F.JUMLAH TARIF_PER_TAHUN, ROUND(F.JUMLAH / 12) TARIF_PER_BULAN,
                CASE WHEN H.LOKASI_ID IS NULL THEN 'BELUM DITENTUKAN' ELSE H.LOKASI_NAMA END LOKASI_TERAKHIR, 
                PERIODE, H.LOKASI_ID, D.KAPAL_JENIS_ID,
		";
		$reqTahun= substr($reqPeriode,2,4);
		$reqBulan= substr($reqPeriode,0,2);
		
		$date=$reqTahun.'-'.$reqBulan;
		$date= getDay(date("Y-m-t",strtotime($date)));
		$x_awal=1;
		
		$x=$x_awal;
		while ($x < $date) {
			$str .="
			PPI_OPERASIONAL.AMBIL_REALISASI_DOWNTIME_INFO(A.KAPAL_ID, '".$reqPeriode."', '".$x."') STATUS_".$x.",
			PPI_OPERASIONAL.AMBIL_REALISASI_DOWNTIME_INFOD(A.KAPAL_ID, '".$reqPeriode."', '".$x."') JAM_".$x.",
			";
			$x++;
		}
		
		$str .="
				PPI_OPERASIONAL.AMBIL_REALISASI_DOWNTIME_INFO(A.KAPAL_ID, '".$reqPeriode."', '".$x."') STATUS_".$x.",
				PPI_OPERASIONAL.AMBIL_REALISASI_DOWNTIME_INFOD(A.KAPAL_ID, '".$reqPeriode."', '".$x."') JAM_".$x."
                FROM PPI_OPERASIONAL.KAPAL A 
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS D ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR H ON A.KAPAL_ID = H.KAPAL_ID
                LEFT JOIN PPI_OPERASIONAL.TARIF_SBPP_KAPAL_TERAKHIR F ON A.KAPAL_ID = F.KAPAL_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO G ON A.KAPAL_ID = G.KAPAL_ID AND PERIODE = '".$reqPeriode."'
				LEFT JOIN PPI_OPERASIONAL.HORSE_POWER I ON I.HORSE_POWER_ID = A.HORSE_POWER_ID
                WHERE 1 = 1 
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
							GROUP BY
									A.KAPAL_ID, A.KODE, A.CALL_SIGN, 
									A.NAMA, D.NAMA, F.JUMLAH, H.LOKASI_ID, H.LOKASI_NAMA, PERIODE,
									D.KAPAL_JENIS_ID, A.KAPAL_KEPEMILIKAN_ID, A.MESIN_DAYA, A.JENIS_PROPULSI, I.NAMA
									".$order;
//		echo $str;exit;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsRealisasiDownTime($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KONTRAK_SBPP_ID DESC", $reqPeriode="")
	{ 
	/*Perbaikan pada query untuk mendapatkan status kesiapan kapal berserta jamnya karena Function "selectByParamsRealisasiDownTimeBak_02April2014" lama
	  Tanggal : 02 April 2014
	*/
		$str = "
				SELECT  A.KAPAL_ID, 
                A.KODE, A.CALL_SIGN, A.NAMA KAPAL, D.NAMA JENIS_KAPAL,
                F.JUMLAH TARIF_PER_TAHUN, ROUND(F.JUMLAH / 12) TARIF_PER_BULAN,
                CASE WHEN H.LOKASI_ID IS NULL THEN 'BELUM DITENTUKAN' ELSE H.LOKASI_NAMA END LOKASI_TERAKHIR, 
                PERIODE, H.LOKASI_ID, D.KAPAL_JENIS_ID,
		";
		$reqTahun= substr($reqPeriode,2,4);
		$reqBulan= substr($reqPeriode,0,2);
		
		$date=$reqTahun.'-'.$reqBulan;
		$date= getDay(date("Y-m-t",strtotime($date)));
		$x_awal=1;
		
		$x=$x_awal;
		while ($x < $date) {
			$str .="
			MAX(DECODE(HARI, ".$x.", STATUS_DOWNTIME, '')) STATUS_".$x.",MAX(DECODE(HARI, ".$x.", JAM, '')) JAM_".$x."
			,";
			$x++;
		}
		
		$str .=" 0
				FROM   PPI_OPERASIONAL.KAPAL A
						LEFT JOIN (    SELECT A.KAPAL_ID, A.PERIODE, A.HARI,
										CASE 
											WHEN A.TSO IS NOT NULL THEN 'TSO' 
											WHEN A.OFF IS NOT NULL THEN 'OFF' 
											WHEN A.RUSAK IS NOT NULL THEN 'D' 
											WHEN A.PERBAIKAN IS NOT NULL THEN 'P' 
											ELSE 'SO' END STATUS_DOWNTIME,
											decode(MULAI, null,'',rtrim (xmlagg (xmlelement (e, MULAI || ' - ' || SELESAI || ',')).extract ('//text()'), ',')) JAM
										FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO A LEFT JOIN PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_DETIL B 
										ON A.KAPAL_ID = B.KAPAL_ID AND A.PERIODE = B.PERIODE AND A.HARI = B.HARI 
										GROUP BY A.KAPAL_ID,  A.HARI, A.PERIODE,
										CASE 
											WHEN A.TSO IS NOT NULL THEN 'TSO' 
											WHEN A.OFF IS NOT NULL THEN 'OFF' 
											WHEN A.RUSAK IS NOT NULL THEN 'D' 
											WHEN A.PERBAIKAN IS NOT NULL THEN 'P' 
											ELSE 'SO' END, MULAI) X ON A.KAPAL_ID = X.KAPAL_ID AND X.PERIODE = '".$reqPeriode."'
										   LEFT JOIN
											  PPI_OPERASIONAL.KAPAL_JENIS D
										   ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID
										LEFT JOIN
										   PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR H
										ON A.KAPAL_ID = H.KAPAL_ID
									 LEFT JOIN
										PPI_OPERASIONAL.TARIF_SBPP_KAPAL_TERAKHIR F
									 ON A.KAPAL_ID = F.KAPAL_ID
							   LEFT JOIN
								  PPI_OPERASIONAL.HORSE_POWER I
							   ON I.HORSE_POWER_ID = A.HORSE_POWER_ID
					   WHERE   1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
							GROUP BY
									A.KAPAL_ID, A.KODE, A.CALL_SIGN, 
									A.NAMA, D.NAMA, F.JUMLAH, H.LOKASI_ID, H.LOKASI_NAMA, PERIODE,
									D.KAPAL_JENIS_ID, A.KAPAL_KEPEMILIKAN_ID, A.MESIN_DAYA, A.JENIS_PROPULSI, I.NAMA
									".$order;
//		echo $str;exit;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsPremi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $periode="", $order="ORDER BY A.KAPAL_ID ASC")
	{
		$str = "
				SELECT 
                A.KAPAL_ID, A.KAPAL_JENIS_ID, KODE, CALL_SIGN, IMO_NUMBER, 
                   A.NAMA, STATUS_KESIAPAN, BENDERA, B.NAMA KAPAL_JENIS_NAMA, C.LOKASI_NAMA, (SELECT COUNT(PEGAWAI_ID) FROM PPI_GAJI.PREMI_KAPAL X WHERE X.KAPAL_ID = A.KAPAL_ID AND PERIODE = '".$periode."') JUMLAH_KRU
                FROM PPI_OPERASIONAL.KAPAL A 
                LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS B ON B.KAPAL_JENIS_ID=A.KAPAL_JENIS_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR C ON A.KAPAL_ID=C.KAPAL_ID                
                WHERE 1=1
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
	    
	function selectByParamsSertifikatKapalKadaluarsa($paramsArray=array(),$limit=-1,$from=-1, $batas_notifikasi="", $statement="", $order="ORDER BY A.NAMA ASC")
	{
		$str = "
				SELECT 
				A.NAMA NAMA_KAPAL, B.TANGGAL_TERBIT, B.TANGGAL_KADALUARSA, B.SERTIFIKAT_KAPAL_ID, C.NAMA NAMA_SERTIFIKAT, B.GROUP_KAPAL, B.KETERANGAN,
				SYSDATE TGL_SKARANG, (B.TANGGAL_KADALUARSA - INTERVAL '".$batas_notifikasi."' DAY) BATAS,
				CASE 
					WHEN B.KETERANGAN IS NOT NULL THEN 3
					WHEN (B.TANGGAL_KADALUARSA - INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE AND B.TANGGAL_KADALUARSA > SYSDATE THEN 1
					WHEN B.TANGGAL_KADALUARSA <= SYSDATE THEN 2
					ELSE 0
				END STATUS,
                CASE 
                    WHEN B.KETERANGAN IS NOT NULL THEN 'Ada Catatan'
                    WHEN (B.TANGGAL_KADALUARSA - INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE AND B.TANGGAL_KADALUARSA > SYSDATE THEN 'Masa Berlaku Hampir Habis'
                    WHEN B.TANGGAL_KADALUARSA <= SYSDATE THEN 'Masa Berlaku Habis'
                    ELSE 'Aktif'
                END STATUS_INFO
				FROM PPI_OPERASIONAL.KAPAL A
				INNER JOIN PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL B ON B.KAPAL_ID = A.KAPAL_ID AND B.TANGGAL_KADALUARSA IS NOT NULL
				INNER JOIN PPI_OPERASIONAL.SERTIFIKAT_KAPAL C ON B.SERTIFIKAT_KAPAL_ID = C.SERTIFIKAT_KAPAL_ID
				WHERE 1=1 
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
	function selectByParamsSertifikatKapalKadaluarsaNew($paramsArray=array(),$limit=-1,$from=-1, $batas_notifikasi="", $statement="", $order=""){
		$str = "
			SELECT KAPAL_ID, NAMA_KAPAL, SERT_KEBANGSAAN, SERT_UKUR, SERT_SEMPURNA_SELAMAT, SERT_SKP, SERT_PERANGKAT_RADIO, SERT_PERSETUJUAN_GERAK, SERT_LAUT_TAHUNAN, SERT_CEGAH_CEMAR, SERT_SIKR, SERT_LAMBUNG, SERT_MESIN, SERT_GARIS_MUAT, SERT_ILR, SERT_APAR, SERT_EPIRB, SERT_KRU_LIST, SERT_RPT, SERT_SAVE_MANING,
			LOKASI_KAPAL  
			FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL_MONITORING A 
			WHERE 1=1 
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
	function selectByParamsSertifikatKapalKadaluarsaReport($paramsArray=array(),$limit=-1,$from=-1, $batas_notifikasi="", $statement="", $order="ORDER BY A.LOKASI_KAPAL ASC"){
		$str = "
			SELECT KAPAL_ID, NAMA_KAPAL, LOKASI_KAPAL, SERT_KEBANGSAAN, SERT_KEBANGSAAN_STATUS, SERT_KEBANGSAAN_KET, SERT_UKUR, SERT_UKUR_STATUS, SERT_UKUR_KET, SERT_SEMPURNA_SELAMAT, SERT_SEMPURNA_SELAMAT_STATUS, SERT_SEMPURNA_SELAMAT_KET, SERT_SKP, SERT_SKP_STATUS, SERT_SKP_KET, SERT_PERANGKAT_RADIO, SERT_PERANGKAT_RADIO_STATUS, SERT_PERANGKAT_RADIO_KET, SERT_PERSETUJUAN_GERAK, SERT_PERSETUJUAN_GERAK_STATUS, SERT_PERSETUJUAN_GERAK_KET, SERT_LAUT_TAHUNAN, SERT_LAUT_TAHUNAN_STATUS, SERT_LAUT_TAHUNAN_KET, SERT_CEGAH_CEMAR, SERT_CEGAH_CEMAR_STATUS, SERT_CEGAH_CEMAR_KET, SERT_SIKR, SERT_SIKR_STATUS, SERT_SIKR_KET, SERT_LAMBUNG, SERT_LAMBUNG_STATUS, SERT_LAMBUNG_KET, SERT_MESIN, SERT_MESIN_STATUS, SERT_MESIN_KET, SERT_GARIS_MUAT, SERT_GARIS_MUAT_STATUS, SERT_GARIS_MUAT_KET, SERT_ILR, SERT_ILR_STATUS, SERT_ILR_KET, SERT_APAR, SERT_APAR_STATUS, SERT_APAR_KET, SERT_EPIRB, SERT_EPIRB_STATUS, SERT_EPIRB_KET, SERT_KRU_LIST, SERT_KRU_LIST_STATUS, SERT_KRU_LIST_KET, SERT_RPT, SERT_RPT_STATUS, SERT_RPT_KET, SERT_SAVE_MANING, SERT_SAVE_MANING_STATUS, SERT_SAVE_MANING_KET 
			
			FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL_REPORT A 
			WHERE 1=1 
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
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	
				SELECT 
				KAPAL_ID, KAPAL_JENIS_ID, KODE, CALL_SIGN, IMO_NUMBER, 
				   NAMA, PERUSAHAAN_BANGUN, TEMPAT_BANGUN, TAHUN_BANGUN, GT, NT, 
				   LOA, BREADTH, DEPTH, DRAFT, MESIN_INDUK, MESIN_BANTU, 
				   MESIN_DAYA, MESIN_RPM, POMPA, ISI_TANGKI, AIR_BERSIH, KECEPATAN, 
				   FOTO, STATUS_KESIAPAN, BENDERA, JUMLAH_KRU
				FROM PPI_OPERASIONAL.KAPAL A 
				WHERE KAPAL_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
	function getFotoByParams($id="")
	{
		$str = "SELECT FOTO AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL
		        WHERE KAPAL_ID IS NOT NULL AND KAPAL_ID = ".$id; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
	function getCountByParamsPencarianKapal($paramsArray=array(), $statement="")
	{
		$str = "
				SELECT COUNT(A.KAPAL_ID) AS ROWCOUNT
				FROM PPI_OPERASIONAL.KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR B ON A.KAPAL_ID = B.KAPAL_ID
				WHERE 1=1
				".$statement; 
		
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
				
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL A
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
				
    function getCountSertifikatKapalKadaluarsaNew($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL_MONITORING A
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
	
	    function getCountByParamsKesiapanKapalVerifikasiBak($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KESIAPAN_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL A
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
	
	function getCountByParamsSertifikatKapalKadaluarsa($paramsArray=array(), $statement="")
	{
		$str = "
				SELECT 
				COUNT(A.KAPAL_ID) AS ROWCOUNT
				FROM PPI_OPERASIONAL.KAPAL A
				INNER JOIN PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL B ON B.KAPAL_ID = A.KAPAL_ID AND B.TANGGAL_KADALUARSA IS NOT NULL
				INNER JOIN PPI_OPERASIONAL.SERTIFIKAT_KAPAL C ON B.SERTIFIKAT_KAPAL_ID = C.SERTIFIKAT_KAPAL_ID
				WHERE 1=1 
				".$statement; 
		
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
    function getCountByParamsSertifikatKapalKadaluarsaNew($paramsArray=array(), $statement="")
	{
		$str = "
				SELECT 
				COUNT(*) AS ROWCOUNT
				FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL_MONITORING A 
				WHERE 1=1 
				".$statement; 
		
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
    function getCountByParamsKesiapanKapal($paramsArray=array(), $statement="", $periode="", $hari="")
	{
		$str = "
				SELECT 
				COUNT(1) AS ROWCOUNT
				FROM
				(
				SELECT 
				COUNT(1) AS ROWCOUNT
				FROM PPI_OPERASIONAL.KAPAL A LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS D
			     ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID
				 LEFT JOIN PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR H
				 ON A.KAPAL_ID = H.KAPAL_ID
				 LEFT JOIN PPI_OPERASIONAL.TARIF_SBPP_KAPAL_TERAKHIR F
				 ON A.KAPAL_ID = F.KAPAL_ID
				 LEFT JOIN PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO G
				 ON A.KAPAL_ID = G.KAPAL_ID AND PERIODE = '".$periode."'
				 LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI_TERAKHIR K ON A.KAPAL_ID = K.KAPAL_ID  AND TANGGAL_KELUAR IS NULL
			   WHERE 1 = 1
				".$statement." GROUP BY A.KAPAL_ID,
				 A.KODE,
				 A.CALL_SIGN,
				 A.NAMA,
				 D.NAMA,
				 F.JUMLAH,
				 H.LOKASI_ID,
				 H.LOKASI_NAMA,
				 PERIODE,
				 D.KAPAL_JENIS_ID, KONTRAK_SBPP_ID, KONTRAK_TOWING_ID,  KAPAL_PEKERJAAN_ID, PENUGASAN_ID
				)
				"
				;
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
	
	function getCountByParamsSyncData($paramsArray=array(), $statement="", $reqPeriode="")
	{
		$str = "
				SELECT 
				COUNT(1) AS ROWCOUNT
				FROM PPI_OPERASIONAL.KAPAL A 
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS D ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID 
				JOIN PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_WS G ON A.KAPAL_ID = G.KAPAL_ID AND PERIODE = '".$reqPeriode."'
				LEFT JOIN PPI_OPERASIONAL.LOKASI B ON G.LOKASI_ID = B.LOKASI_ID
				left join PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR C on C.kapal_id = a.kapal_id
				LEFT JOIN PPI_OPERASIONAL.LOKASI E ON C.LOKASI_ID = E.LOKASI_ID
				WHERE 0=0
				".$statement; 
		
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
	
	function getCountByParamsKesiapanKapalVerifikasi($paramsArray=array(), $statement="", $periode="", $hari="")
	{
		$str = "
				SELECT 
				COUNT(1) AS ROWCOUNT
				from PPI_operasional.KESIAPAN_KAPAL A JOIN PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR B ON A.KAPAL_ID = B.KAPAL_ID 
				WHERE PERIODE = '" . $hari.$periode . "'
				".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL
		        WHERE KAPAL_ID IS NOT NULL ".$statement; 
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