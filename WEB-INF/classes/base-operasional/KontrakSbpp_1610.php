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