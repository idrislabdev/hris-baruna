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

  class AbsensiKoreksi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AbsensiKoreksi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_ABSENSI.ABSENSI_KOREKSI (
				   PEGAWAI_ID, PERIODE, 
				   HARI_1, HARI_2, HARI_3, 
				   HARI_4, HARI_5, HARI_6, 
				   HARI_7, HARI_8, HARI_9, 
				   HARI_10, HARI_11, HARI_12, 
				   HARI_13, HARI_14, HARI_15, 
				   HARI_16, HARI_17, HARI_18, 
				   HARI_19, HARI_20, HARI_21, 
				   HARI_22, HARI_23, HARI_24, 
				   HARI_25, HARI_26, HARI_27, 
				   HARI_28, HARI_29, HARI_30, 
				   HARI_31, KOREKSI_MANUAL_HARI, KATEGORI) 
				VALUES(
					  '".$this->getField("PEGAWAI_ID")."', '".$this->getField("PERIODE")."',
					  '".$this->getField("HARI_1")."', '".$this->getField("HARI_2")."', '".$this->getField("HARI_3")."',
					  '".$this->getField("HARI_4")."', '".$this->getField("HARI_5")."', '".$this->getField("HARI_6")."',
					  '".$this->getField("HARI_7")."', '".$this->getField("HARI_8")."', '".$this->getField("HARI_9")."',
					  '".$this->getField("HARI_10")."', '".$this->getField("HARI_11")."', '".$this->getField("HARI_12")."',
					  '".$this->getField("HARI_13")."', '".$this->getField("HARI_14")."', '".$this->getField("HARI_15")."',
					  '".$this->getField("HARI_16")."', '".$this->getField("HARI_17")."', '".$this->getField("HARI_18")."',
					  '".$this->getField("HARI_19")."', '".$this->getField("HARI_20")."', '".$this->getField("HARI_21")."',
					  '".$this->getField("HARI_22")."', '".$this->getField("HARI_23")."', '".$this->getField("HARI_24")."',
					  '".$this->getField("HARI_25")."', '".$this->getField("HARI_26")."', '".$this->getField("HARI_27")."',
					  '".$this->getField("HARI_28")."', '".$this->getField("HARI_29")."', '".$this->getField("HARI_30")."',
					  '".$this->getField("HARI_31")."', '".$this->getField("KOREKSI_MANUAL_HARI")."', '".$this->getField("KATEGORI")."'
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PPI_ABSENSI.ABSENSI_KOREKSI
			   SET 
				   PERIODE      = '".$this->getField("PERIODE")."',
				   HARI_1		= '".$this->getField("HARI_1")."',
				   HARI_2		= '".$this->getField("HARI_2")."',
				   HARI_3		= '".$this->getField("HARI_3")."',
				   HARI_4		= '".$this->getField("HARI_4")."',
				   HARI_5		= '".$this->getField("HARI_5")."',
				   HARI_6		= '".$this->getField("HARI_6")."',
				   HARI_7		= '".$this->getField("HARI_7")."',
				   HARI_8		= '".$this->getField("HARI_8")."',
				   HARI_9		= '".$this->getField("HARI_9")."',
				   HARI_10		= '".$this->getField("HARI_10")."',
				   HARI_11		= '".$this->getField("HARI_11")."',
				   HARI_12		= '".$this->getField("HARI_12")."',
				   HARI_13		= '".$this->getField("HARI_13")."',
				   HARI_14		= '".$this->getField("HARI_14")."',
				   HARI_15		= '".$this->getField("HARI_15")."',
				   HARI_16		= '".$this->getField("HARI_16")."',
				   HARI_17		= '".$this->getField("HARI_17")."',
				   HARI_18		= '".$this->getField("HARI_18")."',
				   HARI_19		= '".$this->getField("HARI_19")."',
				   HARI_20		= '".$this->getField("HARI_20")."',
				   HARI_21		= '".$this->getField("HARI_21")."',
				   HARI_22		= '".$this->getField("HARI_22")."',
				   HARI_23		= '".$this->getField("HARI_23")."',
				   HARI_24		= '".$this->getField("HARI_24")."',
				   HARI_25		= '".$this->getField("HARI_25")."',
				   HARI_26		= '".$this->getField("HARI_26")."',
				   HARI_27		= '".$this->getField("HARI_27")."',
				   HARI_28		= '".$this->getField("HARI_28")."',
				   HARI_29		= '".$this->getField("HARI_29")."',
				   HARI_30		= '".$this->getField("HARI_30")."',
				   HARI_31		= '".$this->getField("HARI_31")."'
			   WHERE PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_ABSENSI.ABSENSI_KOREKSI
                WHERE 
                  PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")." AND PERIODE = '".$this->getField("PERIODE")."' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callProsesAbsensiKoreksi()
	{
        $str = "
				CALL PPI_ABSENSI.PROSES_ABSENSI_KOREKSI_V2('".$this->getField("PERIODE")."')
		"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }	

	function callProsesAbsensiKoreksiAwakKapal()
	{
        $str = "
				CALL PPI_ABSENSI.PROSES_ABSENSI_KOREKSI_AWAK('".$this->getField("PERIODE")."')
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
		$str = "
				SELECT 
				A.PEGAWAI_ID, A.NRP, A.NAMA ,PERIODE, NVL(KELOMPOK, '5H') KELOMPOK, 
				";
		for($i=1;$i<=cal_days_in_month(CAL_GREGORIAN, (int)substr($periode, 0, 2), substr($periode, 3, 4));$i++)
		{
			if($i < 10)
				$day = "0".$i;
			else
				$day = $i;
		$str .= "
				   CASE WHEN NVL(KELOMPOK, '5H') = '5H' AND (TRIM(TO_CHAR(TO_DATE('".$day.$periode."','DDMMYYYY'), 'DAY')) = 'SATURDAY' OR TRIM(TO_CHAR(TO_DATE('".$day.$periode."','DDMMYYYY'), 'DAY')) = 'SUNDAY') THEN '' ELSE HARI_".$i." END HARI_".$i.", 		
				";		
		}
        
		$str .= " 1         
				FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_ABSENSI.ABSENSI_KOREKSI B
                ON A.PEGAWAI_ID = B.PEGAWAI_ID	AND PERIODE = '".$periode."'	
				LEFT JOIN PPI_ABSENSI.PEGAWAI_JAM_KERJA_JENIS C
                ON A.PEGAWAI_ID = C.PEGAWAI_ID		
                LEFT JOIN PPI_ABSENSI.JAM_KERJA_JENIS D
                ON C.JAM_KERJA_JENIS_ID = D.JAM_KERJA_JENIS_ID
				INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR E
				ON A.PEGAWAI_ID = E.PEGAWAI_ID
				WHERE 1 = 1  AND (
				 		(A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) 
						OR 
						(TANGGAL_PENSIUN > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_MUTASI_KELUAR > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_WAFAT > TO_DATE('".$periode."', 'MMYYYY')) 
						) 
				AND E.JENIS_PEGAWAI_ID NOT IN (8,11)
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
	function selectByParamsNew($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
		$str = "SELECT TO_CHAR(A.TGL_ABSEN, 'DD-MM-YYYY') AS TGL_ABSEN, A.PEGAWAI_ID, A.KELOMPOK, A.KAPAL_ID, A.LOKASI, A.TOTAL 
			FROM PPI_ABSENSI.ABSENSI_REKAP_MASUK_KERJA A WHERE 1=1 "; 	
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    function selectByParamsAwakKapal($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
		$str = "
				SELECT 
				NVL(KAPAL, 'TIDAK DIKETAHUI') KAPAL, A.PEGAWAI_ID, A.NRP, A.NAMA ,PERIODE, NVL(KELOMPOK, '5H') KELOMPOK, 
				";
		for($i=1;$i<=cal_days_in_month(CAL_GREGORIAN, (int)substr($periode, 0, 2), substr($periode, 3, 4));$i++)
		{
			if($i < 10)
				$day = "0".$i;
			else
				$day = $i;
		$str .= "
				   CASE WHEN NVL(KELOMPOK, '5H') = '5H' AND (TRIM(TO_CHAR(TO_DATE('".$day.$periode."','DDMMYYYY'), 'DAY')) = 'SATURDAY' OR TRIM(TO_CHAR(TO_DATE('".$day.$periode."','DDMMYYYY'), 'DAY')) = 'SUNDAY') THEN '' ELSE HARI_".$i." END HARI_".$i.", 		
				";		
		}
        
		$str .= " 1         
				FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_ABSENSI.ABSENSI_KOREKSI B
                ON A.PEGAWAI_ID = B.PEGAWAI_ID	AND PERIODE = '".$periode."'	
				LEFT JOIN PPI_ABSENSI.PEGAWAI_JAM_KERJA_JENIS C
                ON A.PEGAWAI_ID = C.PEGAWAI_ID		
                LEFT JOIN PPI_ABSENSI.JAM_KERJA_JENIS D
                ON C.JAM_KERJA_JENIS_ID = D.JAM_KERJA_JENIS_ID
				INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR E
				ON A.PEGAWAI_ID = E.PEGAWAI_ID
				LEFT JOIN PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR F ON 
				A.PEGAWAI_ID = F.PEGAWAI_ID
				LEFT JOIN 
                KAPAL_LOKASI_TERAKHIR G 
                ON F.KAPAL_ID = G.KAPAL_ID
				WHERE 1 = 1  AND (
				 		(A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) 
						OR 
						(TGL_NON_AKTIF > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_PENSIUN > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_MUTASI_KELUAR > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_WAFAT > TO_DATE('".$periode."', 'MMYYYY')) 
						) 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
    }	
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT 
				PEGAWAI_ID, PERIODE, 
				   HARI_1, HARI_2, HARI_3, 
				   HARI_4, HARI_5, HARI_6, 
				   HARI_7, HARI_8, HARI_9, 
				   HARI_10, HARI_11, HARI_12, 
				   HARI_13, HARI_14, HARI_15, 
				   HARI_16, HARI_17, HARI_18, 
				   HARI_19, HARI_20, HARI_21, 
				   HARI_22, HARI_23, HARI_24, 
				   HARI_25, HARI_26, HARI_27, 
				   HARI_28, HARI_29, HARI_30, 
				   HARI_31
				FROM PPI_ABSENSI.ABSENSI_KOREKSI
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY ABSENSI_KOREKSI_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 

    function getHariLibur($bulan, $tahun)
	{
		$str = "SELECT PPI_ABSENSI.AMBIL_HARI_LIBUR('".$bulan."', '".$tahun."') HARI_LIBUR FROM DUAL "; 
		$this->select($str); 
		$this->query = $str;
		if($this->firstRow()) 
			return $this->getField("HARI_LIBUR"); 
		else 
			return ""; 
    }
		
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI A 
				LEFT JOIN PPI_ABSENSI.PEGAWAI_JAM_KERJA_JENIS C
                ON A.PEGAWAI_ID = C.PEGAWAI_ID		
                LEFT JOIN PPI_ABSENSI.JAM_KERJA_JENIS D
                ON C.JAM_KERJA_JENIS_ID = D.JAM_KERJA_JENIS_ID INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR E ON A.PEGAWAI_ID = E.PEGAWAI_ID WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$this->select($str); 
		$this->query = $str;
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsValidasi($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT FROM PPI_ABSENSI.ABSENSI_KOREKSI A
				LEFT JOIN PPI_ABSENSI.PEGAWAI_JAM_KERJA_JENIS B ON A.PEGAWAI_ID = B.PEGAWAI_ID WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(PEGAWAI_ID) AS ROWCOUNT FROM PPI_ABSENSI.ABSENSI_KOREKSI WHERE 1 = 1 "; 
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