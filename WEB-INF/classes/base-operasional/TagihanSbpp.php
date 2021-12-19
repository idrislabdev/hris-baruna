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

  class TagihanSbpp extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TagihanSbpp()
	{
      $this->Entity(); 
    }

	function callPerhitunganSBPP()
	{
        $str = "
				CALL PPI_OPERASIONAL.PROSES_HITUNG_TAGIHAN_SBPP_V4() 
		"; 
		$this->execQuery($str);

        $str = "
				CALL PPI_OPERASIONAL.PROSES_KOREKSI_TAGIHAN_SBPP() 
		"; 
		
	
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }	

	function callPerhitunganSBPPDummy()
	{
        $str = "
				CALL PPI_OPERASIONAL.PROSES_HITUNG_DUMMY() 
		"; 
		$this->execQuery($str);

        $str = "
				CALL PPI_OPERASIONAL.PROSES_KOREKSI_DUMMY() 
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_ID ASC")
	{
		$str = "
                SELECT 
                   A.NAMA KAPAL, A.TAHUN_BANGUN, PERIODE, A.KAPAL_ID, C.NAMA LOKASI, A.MESIN_DAYA || ' x ' || D.NAMA || ' HP' HP, JENIS_PROPULSI, E.NAMA JENIS_KAPAL, 
                   TARIF_TAHUN, TARIF_BULAN, TARIF_JAM, B.BATAS_MAKS,
                   HARI_TERSEDIA, JAM_TERSEDIA, JAM_TSO,  ESTIMASI_TSO, 
                   JAM_SO, TOLERANSI_MAX, TOLERANSI_KELEBIHAN, 
                   DOWNTIME_KELEBIHAN, TAGIHAN_KOTOR, DENDA_1, 
                   DENDA_2, (DENDA_1 + DENDA_2) JUMLAH_DENDA, DIBAYAR, B.KONTRAK_SBPP_ID, F.NAMA || ' - ' || B.KAPAL_UTAMA KONTRAK, PPI_GAJI.NOMINAL_TERBILANG(NVL(DIBAYAR, 0)) TERBILANG,
				   TO_CHAR(B.TANGGAL_AWAL, 'YYYY-MM-DD HH24:MI:SS') TANGGAL_AWAL, TO_CHAR(B.TANGGAL_AKHIR, 'YYYY-MM-DD HH24:MI:SS') TANGGAL_AKHIR, 
				   TO_CHAR(B.TANGGAL_AWAL, 'DD-MM-YYYY HH24:MI:SS') ||' - '|| TO_CHAR(B.TANGGAL_AKHIR, 'DD-MM-YYYY HH24:MI:SS') AS TANGGAL_SBPP,
				   TO_CHAR(B.TANGGAL_AWAL, 'DD-MM-YYYY HH24:MI:SS') ||' s.d\n'|| TO_CHAR(B.TANGGAL_AKHIR, 'DD-MM-YYYY HH24:MI:SS') AS TANGGAL_SBPP1,
				   GROUP_KAPAL_ID, CASE WHEN B.STATUS = 'K' THEN '(Koreksi)' END STATUS, F.NO_KARTU
                FROM PPI_OPERASIONAL.KAPAL A 
                INNER JOIN PPI_OPERASIONAL.TAGIHAN_SBPP B ON A.KAPAL_ID = B.KAPAL_ID              
                INNER JOIN PPI_OPERASIONAL.LOKASI C ON B.LOKASI_ID = C.LOKASI_ID
                LEFT JOIN PPI_OPERASIONAL.HORSE_POWER D ON A.HORSE_POWER_ID = D.HORSE_POWER_ID
                INNER JOIN PPI_OPERASIONAL.KAPAL_JENIS E ON A.KAPAL_JENIS_ID = E.KAPAL_JENIS_ID
                INNER JOIN PPI_OPERASIONAL.KONTRAK_SBPP F ON B.KONTRAK_SBPP_ID = F.KONTRAK_SBPP_ID
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

    function selectByParamsRekap($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KONTRAK_SBPP_ID")
	{
		$str = "
                SELECT A.KONTRAK_SBPP_ID, PERIODE, A.NAMA, SUM(TAGIHAN_KOTOR) KOTOR, SUM(DENDA_1) DENDA1, SUM(DENDA_2) DENDA2, SUM(DENDA_1) + SUM(DENDA_2) JUMLAH_DENDA,  
				SUM(DIBAYAR) TAGIHAN 
				FROM PPI_OPERASIONAL.KONTRAK_SBPP A INNER JOIN PPI_OPERASIONAL.TAGIHAN_SBPP B ON A.KONTRAK_SBPP_ID = B.KONTRAK_SBPP_ID
                 WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.KONTRAK_SBPP_ID,A.NAMA, B.PERIODE ".$order;
		$this->query = $str;
	
		
		return $this->selectLimit($str,$limit,$from); 
    }
	    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	
				SELECT 
				PERIODE, KAPAL_ID, LOKASI_ID, 
				   TARIF_TAHUN, TARIF_BULAN, TARIF_JAM, 
				   HARI_TERSEDIA, JAM_TERSEDIA, JAM_TSO, 
				   JAM_SO, TOLERANSI_MAX, TOLERANSI_KELEBIHAN, 
				   DOWNTIME_KELEBIHAN, TAGIHAN_KOTOR, DENDA_1, 
				   DENDA_2, DIBAYAR, KONTRAK_SBPP_ID
				FROM PPI_OPERASIONAL.TAGIHAN_SBPP				  
  			    WHERE 1 = 1
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
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL A INNER JOIN PPI_OPERASIONAL.TAGIHAN_SBPP B ON A.KAPAL_ID = B.KAPAL_ID
		        WHERE A.KAPAL_ID IS NOT NULL ".$statement; 
		
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

    function getCountByParamsRekap($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.KONTRAK_SBPP_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KONTRAK_SBPP A WHERE 1 = 1 ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.TAGIHAN_SBPP
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