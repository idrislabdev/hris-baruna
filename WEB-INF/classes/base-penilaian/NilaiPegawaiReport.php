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
  * Entity-base class untuk mengimplementasikan tabel JENIS_PENILAIAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class NilaiPegawaiReport extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
	function callHitungNilai($reqPeriode= '012015')
	{
		$str = " CALL PPI_PENILAIAN.PROSES_HITUNG_NILAI_NEW('". $reqPeriode ."') ";
		
        return $this->execQuery($str);
    }	
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT 
				ROWNUM AS NO, A.PEGAWAI_ID,  B.NAMA, C.NAMA DEPARTEMEN, CASE WHEN A.STATUS_PEGAWAI = 'S' THEN 'STRUKTURAL' WHEN A.STATUS_PEGAWAI = 'P' THEN 'PELAKSANA' ELSE 'FUNGSIONAL' END TYPE_PEGAWAI,
				A.NILAI_REPORT_ID, A.DIRI_SENDIRI, A.ATASAN, A.REKAN1, A.REKAN2, A.BAWAHAN1, A.BAWAHAN2, TO_CHAR( A.NILAI_TOTAL, '9999.99') NILAI_TOTAL, A.SARAN_ATASAN, 
				A.SARAN_REKAN, A.SARAN_BAWAHAN, A.KET_DIRI_SENDIRI, A.KET_ATASAN, A.KET_REKAN1, A.KET_REKAN2, A.KET_BAWAHAN1, A.KET_BAWAHAN2
				FROM PPI_PENILAIAN.NILAI_PEGAWAI_REPORT_NEW A
				INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID 
				LEFT JOIN PPI_SIMPEG.DEPARTEMEN C ON SUBSTR(B.DEPARTEMEN_ID, 0,2) = C.DEPARTEMEN_ID 
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
	
    function selectByParamsPidanSKi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="", $reqPeriode='')
	{
		$str = "
			SELECT A.PEGAWAI_ID, A.NAMA, E.NAMA DEPARTEMEN, F.NAMA JABATAN, 
			CASE WHEN NVL(B.NILAI_TOTAL,0) = 0 THEN '0' ELSE  TO_CHAR(NVL(B.NILAI_TOTAL,0), '999.99') END  NILAI_PI,
			NVL(C.NILAI,0) NILAI_SKI , 
			CASE WHEN ((NVL(B.NILAI_TOTAL,0) + NVL(C.NILAI,0)) / 2) = 0 THEN '0' ELSE 
			TO_CHAR(((NVL(B.NILAI_TOTAL,0) + NVL(C.NILAI,0)) / 2), '999.99') END TOTAL 
			FROM PPI_SIMPEG.PEGAWAI A
			LEFT JOIN PPI_PENILAIAN.NILAI_PEGAWAI_REPORT_NEW B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND B.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.SKI_PERIODE_PEGAWAI C ON A.PEGAWAI_ID = C.PEGAWAI_ID AND C.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI D ON A.STATUS_PEGAWAI_ID = D.STATUS_PEGAWAI_ID 
			LEFT JOIN PPI_SIMPEG.DEPARTEMEN E ON A.DEPARTEMEN_ID = E.DEPARTEMEN_ID 
			LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR F ON A.PEGAWAI_ID = F.PEGAWAI_ID 
			LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID 
			WHERE 1=1 
			AND D.STATUS_PEGAWAI_ID IN (1,5) AND G.JENIS_PEGAWAI_ID NOT IN (8,9,10)  
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsPidanSKiNew($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="", $reqPeriode='')
	{
		$str = "
			SELECT A.PEGAWAI_ID, A.NAMA, E.NAMA DEPARTEMEN, F.NAMA JABATAN, 
            CASE WHEN NVL(B.NILAI_TOTAL,0) = 0 THEN '0' ELSE  TO_CHAR(NVL(B.NILAI_TOTAL,0), '999.99') END  NILAI_PI,
            NVL(C.NILAI,0) NILAI_SKI , 
            CASE WHEN ((NVL(B.NILAI_TOTAL,0) + NVL(C.NILAI,0)) / 2) = 0 THEN '0' ELSE 
            TO_CHAR(((NVL(B.NILAI_TOTAL,0) + NVL(C.NILAI,0)) / 2), '999.99') END TOTAL 
            FROM PPI_SIMPEG.PEGAWAI A
            INNER JOIN (SELECT DISTINCT PEGAWAI_ID FROM 
                (SELECT Y.PEGAWAI_ID
                FROM PPI_PENILAIAN.PEGAWAI_PENILAI Y
                WHERE Y.PEGAWAI_PENILAI_PARENT_ID = 0
                UNION ALL 
                SELECT DISTINCT A.PEGAWAI_ID
                FROM PPI_SIMPEG.PEGAWAI A
                INNER JOIN (
                    SELECT X.PEGAWAI_ID, MAX(X.TMT_SK) TMT_SK 
                    FROM PPI_SIMPEG.PEGAWAI_STATUS_PEGAWAI X 
                    GROUP BY X.PEGAWAI_ID ) 
                    B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND B.TMT_SK >= TO_DATE('01012014', 'DDMMYYYY')
                WHERE A.STATUS_PEGAWAI_ID IN (3,5)
                )) H ON A.PEGAWAI_ID = H.PEGAWAI_ID
            LEFT JOIN PPI_PENILAIAN.NILAI_PEGAWAI_REPORT_NEW B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND B.PERIODE = '". $reqPeriode ."' 
            LEFT JOIN PPI_PENILAIAN.SKI_PERIODE_PEGAWAI C ON A.PEGAWAI_ID = C.PEGAWAI_ID AND C.PERIODE = '". $reqPeriode ."' 
            LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI D ON A.STATUS_PEGAWAI_ID = D.STATUS_PEGAWAI_ID 
            LEFT JOIN PPI_SIMPEG.DEPARTEMEN E ON A.DEPARTEMEN_ID = E.DEPARTEMEN_ID 
            LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR F ON A.PEGAWAI_ID = F.PEGAWAI_ID 
            LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID 
            WHERE F.KELAS > 0 
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsReport($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY PEGAWAI_ID ASC")
	{
		$str = "
				SELECT 
				PEGAWAI_ID, KATEGORI, PERTANYAAN, BOBOT,
				   NILAI_1, TOTAL_NILAI_1, NILAI_2, TOTAL_NILAI_2, 
				   NILAI_3, TOTAL_NILAI_3, NILAI_4, TOTAL_NILAI_4, 
				   NILAI_5, TOTAL_NILAI_5, NILAI_6, TOTAL_NILAI_6, 
				   NILAI_7, TOTAL_NILAI_7, NILAI_8, TOTAL_NILAI_8
				FROM PPI_PENILAIAN.NILAI_PEGAWAI_REKAP				
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

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY PERTANYAAN_ID ASC")
	{
		$str = "
				SELECT 
                A.PEGAWAI_ID, A.NAMA, A.NRP, B.NAMA JABATAN_NAMA, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(A.DEPARTEMEN_ID,0)) DEPARTEMEN, 
                CASE WHEN NVL((SELECT SUM(1) FROM PPI_PENILAIAN.NILAI_PEGAWAI_REPORT X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID), 0) > 0 THEN  NILAI_ANGKA END NILAI_ANGKA, 
                CASE WHEN NVL((SELECT SUM(1) FROM PPI_PENILAIAN.NILAI_PEGAWAI_REPORT X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID), 0) > 0 THEN  NILAI_HURUF END NILAI_HURUF
                FROM PPI_SIMPEG.PEGAWAI A
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                LEFT JOIN (SELECT PEGAWAI_ID_DINILAI PEGAWAI_ID, CASE WHEN NILAI >= 90 THEN  'A'
                WHEN NILAI < 90 AND NILAI >= 75 THEN 'B'
                WHEN NILAI < 75 AND NILAI >= 60 THEN 'C'
                WHEN NILAI < 60 AND NILAI >= 35 THEN 'D'
                WHEN NILAI < 35 AND NILAI >= 0  THEN 'E' END NILAI_HURUF, NILAI NILAI_ANGKA
                FROM (
                SELECT PEGAWAI_ID_DINILAI, ROUND(SUM(TOTAL_NILAI) / CASE WHEN SUM(JUMLAH_PENILAI)  = 0 THEN 1 ELSE SUM(JUMLAH_PENILAI) END, 2) NILAI FROM
                (
                SELECT PEGAWAI_ID_DINILAI, PEGAWAI_ID_PENILAI, SUM(BOBOT * (RANGE / 100)) TOTAL_NILAI, 1 JUMLAH_PENILAI FROM PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI A 
                INNER JOIN PPI_PENILAIAN.PERTANYAAN B ON A.PERTANYAAN_ID = B.PERTANYAAN_ID
                WHERE 1 = 1 GROUP BY PEGAWAI_ID_PENILAI, PEGAWAI_ID_DINILAI
                ) A GROUP BY PEGAWAI_ID_DINILAI) X) C ON A.PEGAWAI_ID = C.PEGAWAI_ID
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
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				PERTANYAAN_ID, PEGAWAI_ID, PERIODE, 
				   NILAI_1, TOTAL_NILAI_1, NILAI_2, TOTAL_NILAI_2, 
				   NILAI_3, TOTAL_NILAI_3, NILAI_4, TOTAL_NILAI_4, 
				   NILAI_5, TOTAL_NILAI_5, NILAI_6, TOTAL_NILAI_6, 
				   NILAI_7, TOTAL_NILAI_7, NILAI_8, TOTAL_NILAI_8
				FROM PPI_PENILAIAN.NILAI_PEGAWAI_REPORT
				WHERE 1 = 1	
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PERTANYAAN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT 
			COUNT(A.PEGAWAI_ID) ROWCOUNT
			FROM PPI_PENILAIAN.NILAI_PEGAWAI_REPORT_NEW A 
			INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID 
			LEFT JOIN PPI_SIMPEG.DEPARTEMEN C ON SUBSTR(B.DEPARTEMEN_ID,0,2) = C.DEPARTEMEN_ID 
			WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		//ECHO $str; exit;
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountPiSkiByParams($paramsArray=array(), $statement="", $reqPeriode='')
	{
		$str = "SELECT 
			COUNT(A.PEGAWAI_ID) ROWCOUNT
			FROM PPI_SIMPEG.PEGAWAI A
			LEFT JOIN PPI_PENILAIAN.NILAI_PEGAWAI_REPORT_NEW B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND B.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.SKI_PERIODE_PEGAWAI C ON A.PEGAWAI_ID = C.PEGAWAI_ID AND C.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI D ON A.STATUS_PEGAWAI_ID = D.STATUS_PEGAWAI_ID 
			LEFT JOIN PPI_SIMPEG.DEPARTEMEN E ON A.DEPARTEMEN_ID = E.DEPARTEMEN_ID 
			LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR F ON A.PEGAWAI_ID = F.PEGAWAI_ID 
			LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID 
			WHERE 1=1 
			AND D.STATUS_PEGAWAI_ID IN (1,5) AND G.JENIS_PEGAWAI_ID NOT IN (8,9,10)   ".$statement; 
		
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

    function getCountPiSkiByParamsNew($paramsArray=array(), $statement="", $reqPeriode='')
	{
		$str = "SELECT 
			COUNT(A.PEGAWAI_ID) ROWCOUNT
			FROM PPI_SIMPEG.PEGAWAI A
            INNER JOIN (SELECT DISTINCT PEGAWAI_ID FROM 
                (SELECT Y.PEGAWAI_ID
                FROM PPI_PENILAIAN.PEGAWAI_PENILAI Y
                WHERE Y.PEGAWAI_PENILAI_PARENT_ID = 0
                UNION ALL 
                SELECT DISTINCT A.PEGAWAI_ID
                FROM PPI_SIMPEG.PEGAWAI A
                INNER JOIN (
                    SELECT X.PEGAWAI_ID, MAX(X.TMT_SK) TMT_SK 
                    FROM PPI_SIMPEG.PEGAWAI_STATUS_PEGAWAI X 
                    GROUP BY X.PEGAWAI_ID ) 
                    B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND B.TMT_SK >= TO_DATE('01012014', 'DDMMYYYY')
                WHERE A.STATUS_PEGAWAI_ID IN (3,5)
                )) H ON A.PEGAWAI_ID = H.PEGAWAI_ID 
			LEFT JOIN PPI_PENILAIAN.NILAI_PEGAWAI_REPORT_NEW B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND B.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.SKI_PERIODE_PEGAWAI C ON A.PEGAWAI_ID = C.PEGAWAI_ID AND C.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI D ON A.STATUS_PEGAWAI_ID = D.STATUS_PEGAWAI_ID 
			LEFT JOIN PPI_SIMPEG.DEPARTEMEN E ON A.DEPARTEMEN_ID = E.DEPARTEMEN_ID 
			LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR F ON A.PEGAWAI_ID = F.PEGAWAI_ID 
			LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID 
			WHERE F.KELAS > 0    ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str; exit;
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PERTANYAAN_ID) AS ROWCOUNT FROM PPI_PENILAIAN.NILAI_PEGAWAI_REPORT
		        WHERE PERTANYAAN_ID IS NOT NULL ".$statement; 
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