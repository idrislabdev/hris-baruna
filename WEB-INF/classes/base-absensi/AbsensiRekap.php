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

  class AbsensiRekap extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AbsensiRekap()
	{
      $this->Entity(); 
    }
	
    function selectByParamsRekapDatangCepat($paramsArray=array(),$limit=-1,$from=-1,$periode="", $hari="", $hari_digit="")
	{
		$str = "
				SELECT NRP, NAMA, PPI_SIMPEG.AMBIL_NAMA_DEPARTEMEN(DEPARTEMEN_ID) DEPARTEMEN, CASE WHEN UPPER(TO_CHAR(TO_DATE('".$hari_digit.$periode."','DDMMYYYY'), 'Dy')) = 'FRI' THEN '07:00' ELSE '08:00' END AWAL_TUGAS, DATANG, 
					   CASE WHEN SUBSTR(DECODE(UPPER(TO_CHAR(TO_DATE('".$hari_digit.$periode."','DDMMYYYY'), 'Dy')), 'FRI', TELAT_JUMAT, TELAT), 0, 1)  = '-' THEN '-' ELSE DECODE(UPPER(TO_CHAR(TO_DATE('".$hari_digit.$periode."','DDMMYYYY'), 'Dy')), 'FRI', TELAT_JUMAT, TELAT) END TELAT,  CASE WHEN SUBSTR(DECODE(UPPER(TO_CHAR(TO_DATE('".$hari_digit.$periode."','DDMMYYYY'), 'Dy')), 'FRI', TELAT_JUMAT, TELAT), 0, 1)  = '-' THEN 'TEPAT WAKTU' ELSE 'TERLAMBAT' END KETERANGAN
					   FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_ABSENSI.REKAP_DATANG_CEPAT B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				WHERE PERIODE = '".$periode."' AND HARI = ".$hari."  AND (
				 		(A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) 
						OR 
						(TANGGAL_PENSIUN > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_MUTASI_KELUAR > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_WAFAT > TO_DATE('".$periode."', 'MMYYYY')) 
						) 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= " ORDER BY TO_DATE(DATANG, 'HH24:MI') ASC";
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsRekapDatangMingguanCepat($paramsArray=array(),$limit=-1,$from=-1,$periode="", $awal_hari="", $akhir_hari="")
	{
		$str = "
				SELECT NRP, NAMA, PPI_SIMPEG.AMBIL_NAMA_DEPARTEMEN(DEPARTEMEN_ID) DEPARTEMEN, '07:00' AWAL_TUGAS, DATANG, 
					   CASE WHEN SUBSTR(TELAT, 0, 1)  = '-' THEN '-' ELSE TELAT END TELAT,  CASE WHEN SUBSTR(TELAT, 0, 1)  = '-' THEN 'TEPAT WAKTU' ELSE 'TERLAMBAT' END KETERANGAN
					   FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_ABSENSI.REKAP_DATANG_CEPAT B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				WHERE PERIODE = '".$periode."' AND (
				 		(A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) 
						OR 
						(TANGGAL_PENSIUN > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_MUTASI_KELUAR > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_WAFAT > TO_DATE('".$periode."', 'MMYYYY')) 
						)  AND HARI BETWEEN ".$awal_hari." AND ".$akhir_hari."
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= " ORDER BY TO_DATE(DATANG, 'HH24:MI') ASC";
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
		/*$str = "
				SELECT
				   ABSENSI_REKAP_ID, NRP, A.NAMA NAMA, IN_1, OUT_1, IN_2, OUT_2, 
				   IN_3, OUT_3, IN_4, OUT_4, IN_5, OUT_5, 
				   IN_6, OUT_6, IN_7,OUT_7, IN_8, OUT_8, 
				   IN_9, OUT_9, IN_10,OUT_10, IN_11, OUT_11, 
				   IN_12, OUT_12, IN_13, OUT_13, IN_14, OUT_14, 
				   IN_15, OUT_15, IN_16, OUT_16, IN_17, OUT_17, 
				   IN_18, OUT_18, IN_19, OUT_19, IN_20, OUT_20, 
				   IN_21, OUT_21, IN_22, OUT_22, IN_23, OUT_23,  
				   IN_24, OUT_24, IN_25, OUT_25, IN_26, OUT_26, 
				   IN_27, OUT_27, IN_28, OUT_28, IN_29, OUT_29, 
				   IN_30, OUT_30, IN_31, OUT_31
				 FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_ABSENSI.ABSENSI_REKAP_MASUK_PULANG B ON A.PEGAWAI_ID = B.PEGAWAI_ID  AND PERIODE = '".$periode."'
				 	  INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
				 WHERE 1 = 1 AND (
				 		(A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) 
						OR 
						(TANGGAL_PENSIUN > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_MUTASI_KELUAR > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_WAFAT > TO_DATE('".$periode."', 'MMYYYY')) 
						) 
			"; */
			/*
			$str = "SELECT DEPARTEMEN_ID, ABSENSI_REKAP_ID, NRP, NAMA, JABATAN, KELAS, PERIODE, IN_1, OUT_1, JJ_1, 
					IN_2, OUT_2, JJ_2, IN_3, OUT_3, JJ_3, IN_4, OUT_4, JJ_4, IN_5, OUT_5, JJ_5, 
					IN_6, OUT_6, JJ_6, IN_7, OUT_7, JJ_7, IN_8, OUT_8, JJ_8, IN_9, OUT_9, JJ_9, 
					IN_10, OUT_10, JJ_10, IN_11, OUT_11, JJ_11, IN_12, OUT_12, JJ_12, IN_13, OUT_13, JJ_13, 
					IN_14, OUT_14, JJ_14, IN_15, OUT_15, JJ_15, IN_16, OUT_16, JJ_16, IN_17, OUT_17, JJ_17, 
					IN_18, OUT_18, JJ_18, IN_19, OUT_19, JJ_19, IN_20, OUT_20, JJ_20, IN_21, OUT_21, JJ_21, 
					IN_22, OUT_22, JJ_22, IN_23, OUT_23, JJ_23, IN_24, OUT_24, JJ_24, IN_25, OUT_25, JJ_25, 
					IN_26, OUT_26, JJ_26, IN_27, OUT_27, JJ_27, IN_28, OUT_28, JJ_28, IN_29, OUT_29, JJ_29, 
					IN_30, OUT_30, JJ_30, IN_31, OUT_31, JJ_31 
				FROM PPI_ABSENSI.ABSENSI_REKAP_JAM_KERJA_V2 A
				WHERE periode = '".$periode."'" ;
		*/
		
		$str = "SELECT * FROM (SELECT DEPARTEMEN_ID, ABSENSI_REKAP_ID, NRP, NAMA, JABATAN, JENIS_PEGAWAI_ID, KELAS, PERIODE, IN_1, OUT_1, JJ_1, 
                    IN_2, OUT_2, JJ_2, IN_3, OUT_3, JJ_3, IN_4, OUT_4, JJ_4, IN_5, OUT_5, JJ_5, 
                    IN_6, OUT_6, JJ_6, IN_7, OUT_7, JJ_7, IN_8, OUT_8, JJ_8, IN_9, OUT_9, JJ_9, 
                    IN_10, OUT_10, JJ_10, IN_11, OUT_11, JJ_11, IN_12, OUT_12, JJ_12, IN_13, OUT_13, JJ_13, 
                    IN_14, OUT_14, JJ_14, IN_15, OUT_15, JJ_15, IN_16, OUT_16, JJ_16, IN_17, OUT_17, JJ_17, 
                    IN_18, OUT_18, JJ_18, IN_19, OUT_19, JJ_19, IN_20, OUT_20, JJ_20, IN_21, OUT_21, JJ_21, 
                    IN_22, OUT_22, JJ_22, IN_23, OUT_23, JJ_23, IN_24, OUT_24, JJ_24, IN_25, OUT_25, JJ_25, 
                    IN_26, OUT_26, JJ_26, IN_27, OUT_27, JJ_27, IN_28, OUT_28, JJ_28, IN_29, OUT_29, JJ_29, 
                    IN_30, OUT_30, JJ_30, IN_31, OUT_31, JJ_31 
                FROM PPI_ABSENSI.ABSENSI_REKAP_JAM_KERJA_V2 A
           		 LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                WHERE periode = '".$periode."' 
                union
                select DEPARTEMEN_ID, 0 ABSENSI_REKAP_ID, NRP, NAMA, JABATAN, JENIS_PEGAWAI_ID, TO_NUMBER(KELAS), '".$periode."' PERIODE,
                null IN_1, null OUT_1, null JJ_1, 
                    null IN_2, null OUT_2, null JJ_2, null IN_3, null OUT_3, null JJ_3, null IN_4, null OUT_4, null JJ_4, null IN_5, null OUT_5, null JJ_5, 
                    null IN_6, null OUT_6, null JJ_6, null IN_7, null OUT_7, null JJ_7, null IN_8, null OUT_8, null JJ_8, null IN_9, null OUT_9, null JJ_9, 
                    null IN_10, null OUT_10, null JJ_10, null IN_11, null OUT_11, null JJ_11, null IN_12, null OUT_12, null JJ_12, null IN_13, null OUT_13, null JJ_13, 
                    null IN_14, null OUT_14, null JJ_14, null IN_15, null OUT_15, null JJ_15, null IN_16, null OUT_16, null JJ_16, null IN_17, null OUT_17, null JJ_17, 
                    null IN_18, null OUT_18, null JJ_18, null IN_19, null OUT_19, null JJ_19, null IN_20, null OUT_20, null JJ_20, null IN_21, null OUT_21, null JJ_21, 
                    null IN_22, null OUT_22, null JJ_22, null IN_23, null OUT_23, null JJ_23, null IN_24, null OUT_24, null JJ_24, null IN_25, null OUT_25, null JJ_25, 
                    null IN_26, null OUT_26, null JJ_26, null IN_27, null OUT_27, null JJ_27, null IN_28, null OUT_28, null JJ_28, null IN_29, null OUT_29, null JJ_29, 
                    null IN_30, null OUT_30, null JJ_30, null IN_31, null OUT_31, null JJ_31
                 from PPI_SIMPEG.PEGAWAI_ALL
                where pegawai_id not in (select pegawai_id FROM PPI_ABSENSI.ABSENSI_REKAP_JAM_KERJA_V2 A
                WHERE periode = '".$periode."')
                and status_pegawai = 'Aktif'
                and jenis_pegawai not in ('Dewan Komisaris', 'Dewan Direksi', 'KSO')) A WHERE 0=0 ";
				
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		//echo $str; exit();
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsRekapAbsensi($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
		$str = "
				SELECT A.PEGAWAI_ID, A.DEPARTEMEN_ID, ABSENSI_REKAP_ID, A.NRP, A.NAMA, JABATAN,
                 KELAS, PERIODE, IN_1, OUT_1, 
				   JJ_1, IN_2, OUT_2, 
				   JJ_2, IN_3, OUT_3, 
				   JJ_3, IN_4, OUT_4, 
				   JJ_4, IN_5, OUT_5, 
				   JJ_5, IN_6, OUT_6, 
				   JJ_6, IN_7, OUT_7, 
				   JJ_7, IN_8, OUT_8, 
				   JJ_8, IN_9, OUT_9, 
				   JJ_9, IN_10, OUT_10, 
				   JJ_10, IN_11, OUT_11, 
				   JJ_11, IN_12, OUT_12, 
				   JJ_12, IN_13, OUT_13, 
				   JJ_13, IN_14, OUT_14, 
				   JJ_14, IN_15, OUT_15, 
				   JJ_15, IN_16, OUT_16, 
				   JJ_16, IN_17, OUT_17, 
				   JJ_17, IN_18, OUT_18, 
				   JJ_18, IN_19, OUT_19, 
                   JJ_19, IN_20, OUT_20, 
                   JJ_20, IN_21, OUT_21, 
                   JJ_21, IN_22, OUT_22, 
                   JJ_22, IN_23, OUT_23, 
                   JJ_23, IN_24, OUT_24, 
                   JJ_24, IN_25, OUT_25, 
                   JJ_25, IN_26, OUT_26, 
                   JJ_26, IN_27, OUT_27, 
                   JJ_27, IN_28, OUT_28, 
                   JJ_28, IN_29, OUT_29, 
                   JJ_29, IN_30, OUT_30, 
                   JJ_30, IN_31, OUT_31, 
                   JJ_31, TOTAL_JAM
                FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_ABSENSI.ABSENSI_REKAP_JAM_KERJA_V2 B
               ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."'
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
	
    function selectByParamsRekapAbsensiCetak($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
	/*
	$str = "
				SELECT
				   ABSENSI_REKAP_ID, NRP, A.NAMA NAMA, IN_1, OUT_1, IN_2, OUT_2, 
				   IN_3, OUT_3, IN_4, OUT_4, IN_5, OUT_5, 
				   IN_6, OUT_6, IN_7,OUT_7, IN_8, OUT_8, 
				   IN_9, OUT_9, IN_10,OUT_10, IN_11, OUT_11, 
				   IN_12, OUT_12, IN_13, OUT_13, IN_14, OUT_14, 
				   IN_15, OUT_15, IN_16, OUT_16, IN_17, OUT_17, 
				   IN_18, OUT_18, IN_19, OUT_19, IN_20, OUT_20, 
				   IN_21, OUT_21, IN_22, OUT_22, IN_23, OUT_23,  
				   IN_24, OUT_24, IN_25, OUT_25, IN_26, OUT_26, 
				   IN_27, OUT_27, IN_28, OUT_28, IN_29, OUT_29, 
				   IN_30, OUT_30, IN_31, OUT_31
				 FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_ABSENSI.ABSENSI_REKAP B ON A.PEGAWAI_ID = B.PEGAWAI_ID  AND PERIODE = '".$periode."'
				 	  INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
				 WHERE 1 = 1 AND (
				 		(A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) 
						OR 
						(TANGGAL_PENSIUN > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_MUTASI_KELUAR > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_WAFAT > TO_DATE('".$periode."', 'MMYYYY')) 
						) 
			"; */
		/*
		$str = "
				SELECT DEPARTEMEN_ID, ABSENSI_REKAP_ID, NRP, NAMA, NAMA_KAPAL, DEPARTEMEN, JABATAN, PERIODE, IN_1, OUT_1, JJ_1, 
					IN_2, OUT_2, JJ_2, IN_3, OUT_3, JJ_3, IN_4, OUT_4, JJ_4, IN_5, OUT_5, JJ_5, 
					IN_6, OUT_6, JJ_6, IN_7, OUT_7, JJ_7, IN_8, OUT_8, JJ_8, IN_9, OUT_9, JJ_9, 
					IN_10, OUT_10, JJ_10, IN_11, OUT_11, JJ_11, IN_12, OUT_12, JJ_12, IN_13, OUT_13, JJ_13, 
					IN_14, OUT_14, JJ_14, IN_15, OUT_15, JJ_15, IN_16, OUT_16, JJ_16, IN_17, OUT_17, JJ_17, 
					IN_18, OUT_18, JJ_18, IN_19, OUT_19, JJ_19, IN_20, OUT_20, JJ_20, IN_21, OUT_21, JJ_21, 
					IN_22, OUT_22, JJ_22, IN_23, OUT_23, JJ_23, IN_24, OUT_24, JJ_24, IN_25, OUT_25, JJ_25, 
					IN_26, OUT_26, JJ_26, IN_27, OUT_27, JJ_27, IN_28, OUT_28, JJ_28, IN_29, OUT_29, JJ_29, 
					IN_30, OUT_30, JJ_30, IN_31, OUT_31, JJ_31 
				FROM PPI_ABSENSI.ABSENSI_REKAP_JAM_KERJA A
				WHERE periode = '".$periode."'
			"; 
		*/
		$str = "select a.DEPARTEMEN_ID, 0 ABSENSI_REKAP_ID, a.NRP, a.NAMA, B.KAPAL NAMA_KAPAL, A.DEPARTEMEN, a.JABATAN, JENIS_PEGAWAI_ID, TO_NUMBER(KELAS) KELAS, '".$periode."' PERIODE,
                null IN_1, null OUT_1, null JJ_1, 
                    null IN_2, null OUT_2, null JJ_2, null IN_3, null OUT_3, null JJ_3, null IN_4, null OUT_4, null JJ_4, null IN_5, null OUT_5, null JJ_5, 
                    null IN_6, null OUT_6, null JJ_6, null IN_7, null OUT_7, null JJ_7, null IN_8, null OUT_8, null JJ_8, null IN_9, null OUT_9, null JJ_9, 
                    null IN_10, null OUT_10, null JJ_10, null IN_11, null OUT_11, null JJ_11, null IN_12, null OUT_12, null JJ_12, null IN_13, null OUT_13, null JJ_13, 
                    null IN_14, null OUT_14, null JJ_14, null IN_15, null OUT_15, null JJ_15, null IN_16, null OUT_16, null JJ_16, null IN_17, null OUT_17, null JJ_17, 
                    null IN_18, null OUT_18, null JJ_18, null IN_19, null OUT_19, null JJ_19, null IN_20, null OUT_20, null JJ_20, null IN_21, null OUT_21, null JJ_21, 
                    null IN_22, null OUT_22, null JJ_22, null IN_23, null OUT_23, null JJ_23, null IN_24, null OUT_24, null JJ_24, null IN_25, null OUT_25, null JJ_25, 
                    null IN_26, null OUT_26, null JJ_26, null IN_27, null OUT_27, null JJ_27, null IN_28, null OUT_28, null JJ_28, null IN_29, null OUT_29, null JJ_29, 
                    null IN_30, null OUT_30, null JJ_30, null IN_31, null OUT_31, null JJ_31, 0 TOTAL_PRESENSI
                 from PPI_SIMPEG.PEGAWAI_ALL a LEFT JOIN PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                where A.pegawai_id not in (select pegawai_id FROM PPI_ABSENSI.ABSENSI_REKAP_JAM_KERJA A
                WHERE periode = '".$periode."')
                and status_pegawai = 'Aktif'
                and jenis_pegawai not in ('Dewan Komisaris', 'Dewan Direksi')";
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$str .= "union SELECT DEPARTEMEN_ID, ABSENSI_REKAP_ID, NRP, NAMA, NAMA_KAPAL, DEPARTEMEN, JABATAN, JENIS_PEGAWAI_ID, KELAS, PERIODE, IN_1, OUT_1, JJ_1, 
                    IN_2, OUT_2, JJ_2, IN_3, OUT_3, JJ_3, IN_4, OUT_4, JJ_4, IN_5, OUT_5, JJ_5, 
                    IN_6, OUT_6, JJ_6, IN_7, OUT_7, JJ_7, IN_8, OUT_8, JJ_8, IN_9, OUT_9, JJ_9, 
                    IN_10, OUT_10, JJ_10, IN_11, OUT_11, JJ_11, IN_12, OUT_12, JJ_12, IN_13, OUT_13, JJ_13, 
                    IN_14, OUT_14, JJ_14, IN_15, OUT_15, JJ_15, IN_16, OUT_16, JJ_16, IN_17, OUT_17, JJ_17, 
                    IN_18, OUT_18, JJ_18, IN_19, OUT_19, JJ_19, IN_20, OUT_20, JJ_20, IN_21, OUT_21, JJ_21, 
                    IN_22, OUT_22, JJ_22, IN_23, OUT_23, JJ_23, IN_24, OUT_24, JJ_24, IN_25, OUT_25, JJ_25, 
                    IN_26, OUT_26, JJ_26, IN_27, OUT_27, JJ_27, IN_28, OUT_28, JJ_28, IN_29, OUT_29, JJ_29, 
                    IN_30, OUT_30, JJ_30, IN_31, OUT_31, JJ_31, (SELECT   SUM (X.TOTAL)
            FROM   PEL_absensi.V_ABSENSI_SUMMARY_MASUK_KERJA X
           WHERE   X.PERIODE = A.periode AND X.PEGAWAI_ID = A.pegawai_id) TOTAL_PRESENSI
                FROM PPI_ABSENSI.ABSENSI_REKAP_JAM_KERJA A
                WHERE periode = '".$periode."'" . $statement." ".$order;
		//echo $str;exit;
		
		$this->query = $str;
		echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

	
	function selectByParamsRekapJamKerja($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
		$str = "
				SELECT A.PEGAWAI_ID, NRP, NAMA, ";
		for($i=1;$i<=31;$i++)
		{
			$str .= " CASE WHEN LENGTH(IN_".$i.") = 5 AND LENGTH(OUT_".$i.") = 5 THEN
					  FLOOR(23 * (TO_DATE(OUT_".$i.", 'HH24:MI') 
						 - TO_DATE(IN_".$i.", 'HH24:MI'))) || ':' ||
					  TO_CHAR(MOD(FLOOR(24 * 60 * (TO_DATE(OUT_".$i.", 'HH24:MI') 
						 - TO_DATE(IN_".$i.", 'HH24:MI'))), 60),'FM09') ELSE '00:00' END AS HARI_".$i.",  
					 ";
		} 
		$str .= " 1 FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_ABSENSI.ABSENSI_REKAP_MASUK_PULANG B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."' 
					INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
					WHERE 1 = 1 AND (
				 		(A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) 
						OR 
						(TANGGAL_PENSIUN > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_MUTASI_KELUAR > TO_DATE('".$periode."', 'MMYYYY') OR TANGGAL_WAFAT > TO_DATE('".$periode."', 'MMYYYY')) 
						) 
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
	
	function selectByParamsRekapKehadiranKoreksi($reqPeriode, $paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$periode = $reqBulan.$reqTahun;
		$str = "
			    SELECT A.PEGAWAI_ID, A.NRP, A.NAMA, NVL(KELOMPOK, '5H') KELOMPOK, (HT + HPC + HTPC) JUMLAH_H, (HT + HPC + HTPC + H) H, HT, HPC, HTPC, (STK + SDK) JUMLAH_S, STK, SDK, (ITK + IDK) JUMLAH_I, ITK, IDK, (CT + CAP + CS + CB) JUMLAH_C, CT, CAP, CS, CB, DL, A JUMLAH_A,
			    (STK + SDK + ITK + IDK + CT + CAP + CS + CB + A) JUMLAH_TM , F.TOTAL_JAM 
                 FROM
                PPI_SIMPEG.PEGAWAI A LEFT JOIN
                (
                SELECT PEGAWAI_ID, NVL(MAX(DECODE(KEHADIRAN, 'H', JUMLAH)), 0) H, NVL(MAX(DECODE(KEHADIRAN, 'HT', JUMLAH)), 0) HT, 
                       NVL(MAX(DECODE(KEHADIRAN, 'HPC', JUMLAH)), 0) HPC, NVL(MAX(DECODE(KEHADIRAN, 'HTPC', JUMLAH)), 0) HTPC, 
                       NVL(MAX(DECODE(KEHADIRAN, 'STK', JUMLAH)), 0) STK, NVL(MAX(DECODE(KEHADIRAN, 'SDK', JUMLAH)), 0) SDK,
                       NVL(MAX(DECODE(KEHADIRAN, 'ITK', JUMLAH)), 0) ITK, NVL(MAX(DECODE(KEHADIRAN, 'IDK', JUMLAH)), 0) IDK,
                       NVL(MAX(DECODE(KEHADIRAN, 'CT', JUMLAH)), 0) CT, NVL(MAX(DECODE(KEHADIRAN, 'CAP', JUMLAH)), 0) CAP,
                       NVL(MAX(DECODE(KEHADIRAN, 'CS', JUMLAH)), 0) CS, NVL(MAX(DECODE(KEHADIRAN, 'CB', JUMLAH)), 0) CB,
                       NVL(MAX(DECODE(KEHADIRAN, 'DL', JUMLAH)), 0) DL, NVL(MAX(DECODE(KEHADIRAN, 'A', JUMLAH)), 0) A
                FROM(
                SELECT PEGAWAI_ID, KEHADIRAN, COUNT(KEHADIRAN) JUMLAH FROM PPI_ABSENSI.REKAP_ABSENSI_KOREKSI WHERE PERIODE = '".$reqPeriode."' GROUP BY PEGAWAI_ID, KEHADIRAN) GROUP BY PEGAWAI_ID
                ) B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                LEFT JOIN PPI_ABSENSI.PEGAWAI_JAM_KERJA_JENIS D ON A.PEGAWAI_ID = D.PEGAWAI_ID       
                LEFT JOIN PPI_ABSENSI.ABSENSI_REKAP_JAM_KERJA_V2 F ON F.PEGAWAI_ID = A.PEGAWAI_ID AND F.PERIODE = '".$reqPeriode."'  
                LEFT JOIN PPI_ABSENSI.JAM_KERJA_JENIS E
                ON D.JAM_KERJA_JENIS_ID = E.JAM_KERJA_JENIS_ID WHERE 1 = 1
                 AND (
				 		(A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) 
						OR 
						(TANGGAL_PENSIUN > TO_DATE('".$reqPeriode."', 'MMYYYY') OR TANGGAL_MUTASI_KELUAR > TO_DATE('".$reqPeriode."', 'MMYYYY') OR TANGGAL_WAFAT > TO_DATE('".$reqPeriode."', 'MMYYYY')) 
						) 
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
    function selectByParamsRekapDetailKehadiranKoreksi($reqPeriode, $paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")	{
		$periode = $reqBulan.$reqTahun;
		$str = "
			    SELECT A.PEGAWAI_ID, A.NRP, A.NAMA, NVL(KELOMPOK, '5H') KELOMPOK, (HT + HPC + HTPC) JUMLAH_H, (HT + HPC + HTPC + H) H, HT, HPC, HTPC, (STK + SDK) JUMLAH_S, STK, SDK, (ITK + IDK) JUMLAH_I, ITK, IDK, (CT + CAP + CS + CB) JUMLAH_C, CT, CAP, CS, CB, DL, A JUMLAH_A,
			    (STK + SDK + ITK + IDK + CT + CAP + CS + CB + A) JUMLAH_TM , F.TOTAL_JAM,
			    PPI_ABSENSI.AMBIL_HARI_BERDASAR_TYPE (A.PEGAWAI_ID, '".$reqPeriode."', 'HT') TGL_HT,
			    PPI_ABSENSI.AMBIL_HARI_BERDASAR_TYPE (A.PEGAWAI_ID, '".$reqPeriode."', 'HPC') TGL_HPC,
			    PPI_ABSENSI.AMBIL_HARI_BERDASAR_TYPE (A.PEGAWAI_ID, '".$reqPeriode."', 'HTPC') TGL_HTPC,
			    PPI_ABSENSI.AMBIL_HARI_BERDASAR_TYPE (A.PEGAWAI_ID, '".$reqPeriode."', 'STK') TGL_STK,
			    PPI_ABSENSI.AMBIL_HARI_BERDASAR_TYPE (A.PEGAWAI_ID, '".$reqPeriode."', 'SDK') TGL_SDK,
			    PPI_ABSENSI.AMBIL_HARI_BERDASAR_TYPE (A.PEGAWAI_ID, '".$reqPeriode."', 'ITK') TGL_ITK,
			    PPI_ABSENSI.AMBIL_HARI_BERDASAR_TYPE (A.PEGAWAI_ID, '".$reqPeriode."', 'IDK') TGL_IDK,
			    PPI_ABSENSI.AMBIL_HARI_BERDASAR_TYPE (A.PEGAWAI_ID, '".$reqPeriode."', 'CT') TGL_CT,
			    PPI_ABSENSI.AMBIL_HARI_BERDASAR_TYPE (A.PEGAWAI_ID, '".$reqPeriode."', 'CAP') TGL_CAP,
			    PPI_ABSENSI.AMBIL_HARI_BERDASAR_TYPE (A.PEGAWAI_ID, '".$reqPeriode."', 'CS') TGL_CS,
			    PPI_ABSENSI.AMBIL_HARI_BERDASAR_TYPE (A.PEGAWAI_ID, '".$reqPeriode."', 'CB') TGL_CB,
			    PPI_ABSENSI.AMBIL_HARI_BERDASAR_TYPE (A.PEGAWAI_ID, '".$reqPeriode."', 'DL') TGL_DL,
			    PPI_ABSENSI.AMBIL_HARI_BERDASAR_TYPE (A.PEGAWAI_ID, '".$reqPeriode."', 'A') TGL_A

                 FROM
                PPI_SIMPEG.PEGAWAI A LEFT JOIN
                (
                SELECT PEGAWAI_ID, NVL(MAX(DECODE(KEHADIRAN, 'H', JUMLAH)), 0) H, NVL(MAX(DECODE(KEHADIRAN, 'HT', JUMLAH)), 0) HT, 
                       NVL(MAX(DECODE(KEHADIRAN, 'HPC', JUMLAH)), 0) HPC, NVL(MAX(DECODE(KEHADIRAN, 'HTPC', JUMLAH)), 0) HTPC, 
                       NVL(MAX(DECODE(KEHADIRAN, 'STK', JUMLAH)), 0) STK, NVL(MAX(DECODE(KEHADIRAN, 'SDK', JUMLAH)), 0) SDK,
                       NVL(MAX(DECODE(KEHADIRAN, 'ITK', JUMLAH)), 0) ITK, NVL(MAX(DECODE(KEHADIRAN, 'IDK', JUMLAH)), 0) IDK,
                       NVL(MAX(DECODE(KEHADIRAN, 'CT', JUMLAH)), 0) CT, NVL(MAX(DECODE(KEHADIRAN, 'CAP', JUMLAH)), 0) CAP,
                       NVL(MAX(DECODE(KEHADIRAN, 'CS', JUMLAH)), 0) CS, NVL(MAX(DECODE(KEHADIRAN, 'CB', JUMLAH)), 0) CB,
                       NVL(MAX(DECODE(KEHADIRAN, 'DL', JUMLAH)), 0) DL, NVL(MAX(DECODE(KEHADIRAN, 'A', JUMLAH)), 0) A
                FROM(
                SELECT PEGAWAI_ID, KEHADIRAN, COUNT(KEHADIRAN) JUMLAH FROM PPI_ABSENSI.REKAP_ABSENSI_KOREKSI WHERE PERIODE = '".$reqPeriode."' GROUP BY PEGAWAI_ID, KEHADIRAN) GROUP BY PEGAWAI_ID
                ) B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                LEFT JOIN PPI_ABSENSI.PEGAWAI_JAM_KERJA_JENIS D ON A.PEGAWAI_ID = D.PEGAWAI_ID       
                LEFT JOIN PPI_ABSENSI.ABSENSI_REKAP_JAM_KERJA_V2 F ON F.PEGAWAI_ID = A.PEGAWAI_ID AND F.PERIODE = '".$reqPeriode."'  
                LEFT JOIN PPI_ABSENSI.JAM_KERJA_JENIS E
                ON D.JAM_KERJA_JENIS_ID = E.JAM_KERJA_JENIS_ID WHERE 1 = 1
                 AND (
				 		(A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) 
						OR 
						(TANGGAL_PENSIUN > TO_DATE('".$reqPeriode."', 'MMYYYY') OR TANGGAL_MUTASI_KELUAR > TO_DATE('".$reqPeriode."', 'MMYYYY') OR TANGGAL_WAFAT > TO_DATE('".$reqPeriode."', 'MMYYYY')) 
						) 
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
	
	function selectByParamsRekapKehadiran($reqTanggalAkhir, $reqBulan, $reqTahun, $paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
		$periode = $reqBulan.$reqTahun;
		$str = "
					SELECT A.PEGAWAI_ID, A.NRP, A.NAMA,  PPI_ABSENSI.HITUNG_HARI_KERJA(TO_DATE('".$reqTahun."-".$reqBulan."-01', 'YYYY-MM-DD'), TO_DATE('".$reqTahun."-".$reqBulan."-".$reqTanggalAkhir."', 'YYYY-MM-DD')) - NVL(PPI_ABSENSI.HITUNG_TANGGAL_MERAH('".$periode."'), 0) HARI_KERJA,  
						   NVL(SUM(MASUK),0) MASUK, NVL(CUTI, 0) CUTI, NVL(IJIN, 0) IJIN
					FROM
					PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_ABSENSI.REKAP_KEHADIRAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND B.PERIODE = '".$periode."'
					LEFT JOIN
					(SELECT A.PEGAWAI_ID, MAX(DECODE(A.IJIN_ID, 1, JUMLAH)) CUTI, MAX(DECODE(A.IJIN_ID, 2, JUMLAH)) IJIN
					FROM
					(
					SELECT A.PEGAWAI_ID, A.IJIN_ID, SUM(JUMLAH) JUMLAH FROM
					(
					SELECT PEGAWAI_ID, IJIN_ID, JUMLAH_IJIN_BULAN_INI JUMLAH FROM PPI_ABSENSI.ABSENSI_IJIN WHERE TO_CHAR(TANGGAL_AWAL, 'MMYYYY') = '".$periode."' AND VALIDASI = 1
					UNION ALL
					SELECT PEGAWAI_ID, IJIN_ID, JUMLAH_IJIN_BULAN_DEPAN JUMLAH FROM PPI_ABSENSI.ABSENSI_IJIN WHERE TO_CHAR(TANGGAL_AKHIR, 'MMYYYY') = '".$periode."' AND VALIDASI = 1
					) A GROUP BY PEGAWAI_ID, A.IJIN_ID
					) A GROUP BY A.PEGAWAI_ID) C ON A.PEGAWAI_ID = C.PEGAWAI_ID
					WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.PEGAWAI_ID, A.NAMA, CUTI, IJIN ".$order;
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsRekapMK($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
						$str = "select a.periode, a.pegawai_id, b.nama, a.kelompok, departemen unit_kerja, jabatan, SUM(DECODE(A.KELOMPOK, 'K', DECODE(LOKASI, '01', TOTAL,0),TOTAL)) TOTAL_PERAK,
                         SUM(DECODE(A.KELOMPOK, 'K', DECODE(LOKASI, '01', 0,TOTAL),0)) TOTAL_DAERAH 
                            from PEL_absensi.V_ABSENSI_SUMMARY_MASUK_KERJA a left join PEL_simpeg.pegawai_all b on a.pegawai_id = b.pegawai_id 
                            left join PEL_operasional.kapal c on a.kapal_id = c.kapal_id
                            left join PEL_OPERASIONAL.LOKASI d on a.lokasi = D.LOKASI_ID
                            WHERE 0=0 and b.jenis_pegawai is not null
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." group by a.periode, a.pegawai_id, a.kelompok, b.nama, jabatan, departemen, JENIS_PEGAWAI ".$order;
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function getCountByParamsMK($paramsArray=array(), $statement="")
	{
		$str = "select count(b.jenis_pegawai) as ROWCOUNT
                            from PEL_absensi.V_ABSENSI_SUMMARY_MASUK_KERJA a left join PEL_simpeg.pegawai_all b on a.pegawai_id = b.pegawai_id 
                            left join PEL_operasional.kapal c on a.kapal_id = c.kapal_id
                            left join PEL_OPERASIONAL.LOKASI d on a.lokasi = D.LOKASI_ID
                            WHERE 0=0
                            and b.jenis_pegawai is not null ".$statement ; 
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
	
		function callGenerateAbsensi($periode)
	{
		$str = " CALL PPI_ABSENSI.GENERATE_ABSENSI_SUMMARY('".$periode."') ";
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }	

	function selectByParamsRekapTerlambatPulangKoreksi($reqPeriode, $paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$periode = $reqBulan.$reqTahun;
		$str = "
				SELECT A.PEGAWAI_ID, A.NRP, A.NAMA, NVL(KELOMPOK, '5H') KELOMPOK, (H + HT + HPC + HTPC) JUMLAH_H, (HT + HTPC) JUMLAH_HT, PPI_ABSENSI.AMBIL_HARI_TERLAMBAT_KOREKSI(A.PEGAWAI_ID, '".$reqPeriode."') HT,
				(HPC + HTPC) JUMLAH_HPC,
				PPI_ABSENSI.AMBIL_HARI_PLG_CEPAT_KOREKSI(A.PEGAWAI_ID, '".$reqPeriode."') PC,
				(STK + SDK + ITK + IDK + CT + CAP + CS + CB + DL + A) JUMLAH_TM,
				PPI_ABSENSI.AMBIL_HARI_TIDAK_MASUK_KOREKSI(A.PEGAWAI_ID, '".$reqPeriode."') TM
				 FROM
				PPI_SIMPEG.PEGAWAI A LEFT JOIN
				(
				SELECT PEGAWAI_ID, NVL(MAX(DECODE(KEHADIRAN, 'H', JUMLAH)), 0) H, NVL(MAX(DECODE(KEHADIRAN, 'HT', JUMLAH)), 0) HT, 
					   NVL(MAX(DECODE(KEHADIRAN, 'HPC', JUMLAH)), 0) HPC, NVL(MAX(DECODE(KEHADIRAN, 'HTPC', JUMLAH)), 0) HTPC, 
					   NVL(MAX(DECODE(KEHADIRAN, 'STK', JUMLAH)), 0) STK, NVL(MAX(DECODE(KEHADIRAN, 'SDK', JUMLAH)), 0) SDK,
					   NVL(MAX(DECODE(KEHADIRAN, 'ITK', JUMLAH)), 0) ITK, NVL(MAX(DECODE(KEHADIRAN, 'IDK', JUMLAH)), 0) IDK,
					   NVL(MAX(DECODE(KEHADIRAN, 'CT', JUMLAH)), 0) CT, NVL(MAX(DECODE(KEHADIRAN, 'CAP', JUMLAH)), 0) CAP,
					   NVL(MAX(DECODE(KEHADIRAN, 'CS', JUMLAH)), 0) CS, NVL(MAX(DECODE(KEHADIRAN, 'CB', JUMLAH)), 0) CB,
					   NVL(MAX(DECODE(KEHADIRAN, 'DL', JUMLAH)), 0) DL, NVL(MAX(DECODE(KEHADIRAN, 'A', JUMLAH)), 0) A
				FROM(
				SELECT PEGAWAI_ID, KEHADIRAN, COUNT(KEHADIRAN) JUMLAH FROM PPI_ABSENSI.REKAP_ABSENSI_KOREKSI WHERE PERIODE = '".$reqPeriode."' GROUP BY PEGAWAI_ID, KEHADIRAN) GROUP BY PEGAWAI_ID
				) B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID 
				LEFT JOIN PPI_ABSENSI.PEGAWAI_JAM_KERJA_JENIS D ON A.PEGAWAI_ID = D.PEGAWAI_ID		
				LEFT JOIN PPI_ABSENSI.JAM_KERJA_JENIS E
				ON D.JAM_KERJA_JENIS_ID = E.JAM_KERJA_JENIS_ID WHERE 1 = 1
				AND (
				 		(A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) 
						OR 
						(TANGGAL_PENSIUN > TO_DATE('".$reqPeriode."', 'MMYYYY') OR TANGGAL_MUTASI_KELUAR > TO_DATE('".$reqPeriode."', 'MMYYYY') OR TANGGAL_WAFAT > TO_DATE('".$reqPeriode."', 'MMYYYY')) 
						) 
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
	
	function selectByParamsRekapTerlambatPulangCepat($reqBulan, $reqTahun, $paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$periode = $reqBulan.$reqTahun;
		$str = "
				SELECT   A.PEGAWAI_ID, A.NAMA, NVL (SUM (MASUK), 0) MASUK, 
						(SELECT NVL(SUM(TERLAMBAT),0) FROM PPI_ABSENSI.REKAP_TERLAMBAT X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID AND X.PERIODE = '".$periode."') TERLAMBAT,
						(SELECT NVL(SUM(PULANG_CEPAT),0) FROM PPI_ABSENSI.REKAP_PULANG_CEPAT X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID AND X.PERIODE = '".$periode."') PULANG_CEPAT,
						PPI_ABSENSI.AMBIL_HARI_TERLAMBAT(A.PEGAWAI_ID, '".$periode."') TERLAMBAT_HARI, 
						PPI_ABSENSI.AMBIL_HARI_PULANG_CEPAT(A.PEGAWAI_ID, '".$periode."') PULANG_CEPAT_HARI
					FROM PPI_SIMPEG.PEGAWAI A 
					LEFT JOIN PPI_ABSENSI.REKAP_KEHADIRAN B
						 ON A.PEGAWAI_ID = B.PEGAWAI_ID AND B.PERIODE = '".$periode."'
				   WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.PEGAWAI_ID, A.NAMA ".$order;
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }


	function selectByParamsRekapTerlambatPulangCepatReport($reqPeriode, $paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY A.DEPARTEMEN_ID ASC")
	{
		$str = "
				SELECT A.PEGAWAI_ID, A.NRP, A.NAMA, PPI_SIMPEG.AMBIL_NAMA_DEPARTEMEN(SUBSTR(A.DEPARTEMEN_ID, 1, 2)) DEPARTEMEN, 
				(SELECT NVL(SUM(TERLAMBAT),0) FROM PPI_ABSENSI.REKAP_TERLAMBAT X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID AND X.PERIODE = '".$reqPeriode."') TERLAMBAT,
				PPI_ABSENSI.AMBIL_HARI_TERLAMBAT(A.PEGAWAI_ID, '".$reqPeriode."') TERLAMBAT_HARI,
				(SELECT NVL(SUM(PULANG_CEPAT),0) FROM PPI_ABSENSI.REKAP_PULANG_CEPAT X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID AND X.PERIODE = '".$reqPeriode."') PULANG_CEPAT,                        
				PPI_ABSENSI.AMBIL_HARI_PULANG_CEPAT(A.PEGAWAI_ID, '".$reqPeriode."') PULANG_CEPAT_HARI
				 FROM PPI_SIMPEG.PEGAWAI A WHERE 1 = 1 AND A.STATUS_PEGAWAI_ID = 1
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
		
	function selectByParamsRekapTerlambat($paramsArray=array(),$limit=-1,$from=-1,$statement="", $tahun='', $satker_id='', $order="")
	{
		
		// PARAMETER KE ABSENSI REKAP
		$str = "
				 SELECT
				   NAMA,
				 "
		;
		
		// PROSES MENGHITUNG BANYAK NYA JUMLAH TERLAMBAT JAN - DES BERDASARKAN JAM KERJA STATUS 1 TANPA HOLIDAY
		// NOTE HARUS HOLIDAY
		$delimeter='';
		for($bln=1;$bln <= 12; $bln++){
			if($bln < 10)	$temp= '0'.$bln;
			else			$temp= $bln;
			
			if($bln=='1')	$delimeter='';
			else			$delimeter=',';
			
			$str .= $delimeter."NVL(( (SELECT ";
			
			for($i=1;$i <= 31; $i++){
				$nama_field='';
				if($i == 1){$parameter = '';}
				else{
					if($i == 31){
						$nama_field = " FROM ABSENSI_REKAP_MASUK_PULANG B WHERE 1=1 AND A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$temp.$tahun."') ),0) DATA_".$temp.$tahun;
					}
					$parameter = '+';
				}
				
				$str .=$parameter."
					 NVL( 
					(
					 SELECT 1 FROM JAM_KERJA X
					 WHERE TO_DATE ('2011/01/01 ' || IN_".$i.", 'YYYY/MM/DD HH24:MI') > TO_DATE ('2011/01/01 ' || X.TERLAMBAT_AWAL, 'YYYY/MM/DD HH24:MI')
					 AND X.JAM_KERJA_ID = (SELECT Z.JAM_KERJA_ID_".$i." FROM ABSENSI_JAM_KERJA Z WHERE Z.SATKER_ID='".$satker_id."' AND Z.PERIODE='".$temp.$tahun."' )
					 AND REGEXP_LIKE (IN_".$i.", '^[0-9]')
					),
					0)
					 ".$nama_field
					 // LENGTH(TRIM(TRANSLATE(IN_".$i.", 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ' '))) > 0
				;
			}
			
		}
		$str .="
				 FROM PEGAWAI A
				 WHERE 1 = 1
			";

		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	function selectByParamsRekapIjin($paramsArray=array(),$limit=-1,$from=-1,$statement="", $tahun='', $ijin_id='', $jml_ijin_id='', $order="")
	{
		$arrIjinId=explode(',',$ijin_id);
		
		$str = "
				 SELECT
				   NAMA
				 "
		;
		for($bln=1;$bln <= 12; $bln++){
			if($bln < 10)	$temp= '0'.$bln;
			else			$temp= $bln;
			
			// PEMBANDING DENGAN BULAN DEPAN KECUALI BULAN AWAL DAN AKHIR
			if($bln==1)	$tempOther=1;
			elseif($bln==12)$tempOther=12;
			else{
				$tempOther=$bln+1;
				if($tempOther < 10)	$tempOther= '0'.$tempOther;
				else				$tempOther= $tempOther;
			}
			for($i=0; $i < $jml_ijin_id; $i++){
			$str .="
					 ,
					 NVL( 
					(
					 (SELECT
					   SUM(
					   (CASE
						WHEN TO_CHAR (TANGGAL_AWAL, 'MMYYYY') = '".$temp.$tahun."' AND TO_CHAR (TANGGAL_AKHIR, 'MMYYYY') = '".$temp.$tahun."'
						   	THEN TO_CHAR ((TANGGAL_AKHIR - TANGGAL_AWAL + 1) )
						WHEN TO_CHAR (TANGGAL_AKHIR, 'MMYYYY') = '".$temp.$tahun."'
						   	THEN TO_CHAR (  (  TANGGAL_AKHIR - TO_DATE ('01' || '".$temp.$tahun."', 'DD-MM-YYYY' ) + 1))
						WHEN TO_CHAR (TANGGAL_AKHIR, 'MMYYYY') != '".$temp.$tahun."' AND TO_CHAR (TANGGAL_AWAL, 'MMYYYY') != '".$temp.$tahun."'
							THEN TO_CHAR (  (  LAST_DAY (TO_DATE ('".$temp.$tahun."', 'MMYYYY' ) ) - TO_DATE ('01' || '".$temp.$tahun."', 'DD-MM-YYYY' ) ) + 1)
						ELSE TO_CHAR (  (  LAST_DAY (TO_DATE ('".$temp.$tahun."', 'MMYYYY' ) ) - TANGGAL_AWAL + 1) )
					   END
					   )
					   ) JML
					FROM ABSENSI_IJIN B
					WHERE 1=1 AND VALIDASI = 1 AND B.PEGAWAI_ID = A.PEGAWAI_ID AND IJIN_ID = ".$arrIjinId[$i]."
					AND TO_DATE('".$temp.$tahun."', 'MMYYYY') BETWEEN TO_DATE(TO_CHAR (TANGGAL_AWAL, 'MMYYYY'),'MMYYYY') AND TO_DATE(TO_CHAR (TANGGAL_AKHIR, 'MMYYYY'),'MMYYYY')
					)
					),0) DATA_".$arrIjinId[$i].$temp.$tahun
			;//AND ROWNUM = 1
			
			// DATA SALAH
			//AND ( TO_CHAR(TANGGAL_AWAL, 'MMYYYY') = '".$tempOther.$tahun."' OR TO_CHAR(TANGGAL_AKHIR, 'MMYYYY') = '".$temp.$tahun."') GROUP BY PEGAWAI_ID
			/*
			WHEN TO_CHAR(TANGGAL_AWAL, 'MMYYYY') = '".$temp.$tahun."' AND TO_CHAR(TANGGAL_AKHIR, 'MMYYYY') = '".$temp.$tahun."' 
		    THEN TO_CHAR((TANGGAL_AKHIR-TANGGAL_AWAL)+1) 
		    WHEN TO_CHAR(TANGGAL_AKHIR, 'MMYYYY') = '".$temp.$tahun."'
		    THEN TO_CHAR((TANGGAL_AKHIR-TO_DATE('01'||'".$temp.$tahun."', 'DD-MM-YYYY'))+1)
		    ELSE TO_CHAR((LAST_DAY(TO_DATE('".$temp.$tahun."', 'MMYYYY'))-TANGGAL_AWAL)+1)
			*/
			}
		}
		
		$str .="
				 FROM PEGAWAI A
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
	
	function selectByParamsRekapDatangAwal($paramsArray=array(),$limit=-1,$from=-1,$statement="", $tahun='', $bulan='', $satker_id='', $order="")
	{
		// PARAMETER KE ABSENSI REKAP
		$str = "
				 SELECT TO_CHAR(A.PEGAWAI_ID), NAMA, B.HARI, B.JAM
				 FROM PEGAWAI A
				 INNER JOIN 
				 (
				 "
		;//SELECT TO_CHAR(A.PEGAWAI_ID), NAMA, TO_CHAR(B.JAM, 'DD') HARI, TO_CHAR(B.JAM, 'HH24:MI:SS') JAM
		
		// PROSES MENGHITUNG BANYAK NYA JUMLAH DATANG AWAL JAN - DES BERDASARKAN JAM KERJA STATUS 1 TANPA HOLIDAY
		$temp= $bulan;
		
		for($i=1;$i <= 31; $i++){
			if($i < 10)	$temp_hari= '0'.$i;
			else		$temp_hari= $i;
		
			if($i == 1)	{$parameter = '';}
			else		{$parameter = ' UNION ALL';}
			
			$str .=$parameter."
			SELECT P.PEGAWAI_ID, P.IN_".$i." JAM, ".$i." HARI
			FROM ABSENSI_REKAP_MASUK_PULANG P,
			(SELECT MIN(IN_".$i.") IN_".$i."
				FROM ABSENSI_REKAP_MASUK_PULANG
				WHERE PERIODE = '".$temp.$tahun."'
				AND SATKER_ID LIKE '".$satker_id."%'
				AND REGEXP_LIKE (IN_".$i.", '^[0-9]')
			) X
			WHERE P.IN_".$i." = X.IN_".$i."
			AND P.SATKER_ID LIKE '".$satker_id."%'AND REGEXP_LIKE (P.IN_".$i.", '^[0-9]') AND P.PERIODE = '".$temp.$tahun."'
			AND ROWNUM=1 
			";
			
			/*$str .=$parameter."
			SELECT P.PEGAWAI_ID, P.JAM
			  FROM ABSENSI P,
				   (  SELECT TO_CHAR (MIN (JAM), 'DD-MM-YYYY HH24:MI:SS') AS JAM, SATKER_ID
						FROM ABSENSI
					   WHERE SATKER_ID LIKE '".$satker_id."%' AND TO_CHAR (JAM, 'MMYYYY') = '".$temp.$tahun."'
                       AND
                       TO_CHAR (JAM, 'DD-MM-YYYY HH24:MI:SS') = (SELECT  TO_CHAR (MIN (JAM), 'DD-MM-YYYY HH24:MI:SS') FROM ABSENSI WHERE SATKER_ID LIKE '".$satker_id."%' AND TO_CHAR (JAM, 'DDMMYYYY') = '".$temp_hari.$temp.$tahun."' )
                       AND ROWNUM = 1
                    GROUP BY TO_CHAR (JAM, 'DD/MM/YYYY'), SATKER_ID
                    ORDER BY SATKER_ID, JAM) X
             WHERE P.SATKER_ID = X.SATKER_ID AND  TO_CHAR (P.JAM, 'DD-MM-YYYY HH24:MI:SS') = X.JAM
             AND
                TO_CHAR (P.JAM, 'DD-MM-YYYY HH24:MI:SS') = (SELECT  TO_CHAR (MIN (P.JAM), 'DD-MM-YYYY HH24:MI:SS') FROM ABSENSI WHERE SATKER_ID LIKE '".$satker_id."%' AND TO_CHAR (P.JAM, 'DDMMYYYY') = '".$temp_hari.$temp.$tahun."' )
                AND ROWNUM = 1
			";*/
		}
			
		$str .="
				)  B
				ON A.PEGAWAI_ID=B.PEGAWAI_ID
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
	
	function selectByParamsRekapTidakMasuk($paramsArray=array(),$limit=-1,$from=-1,$statement="", $paramsMasukKerjaArray=array(), $tahun="", $order="")
	{
		//$bulan=substr($periode,1,2);		$tahun=substr($periode,2,4);
		
		$str = "
				SELECT NAMA ";
		while(list($key,$val) = each($paramsMasukKerjaArray))
		{
			$arrayVal= explode(',',$val);			$state_in='';
			
			// DEKLARASI BULAN UNTUK MENDAPATKAN JUMLAH HARI DALAM BULAN
			if($key < 10)	$temp_bulan= '0'.$key;			else $temp_bulan= $key;
			$tanggal=$tahun.'-'.$temp_bulan;				$maxTanggal= date("Y-m-t",strtotime($tanggal));
			$maxTanggal=explode('-',$maxTanggal);			$maxTanggal=$maxTanggal[2];
			$str .="
			,
			NVL(
			(
			SELECT 
			";

			$plus=$tempOther='';
			for($i=1;$i<=$maxTanggal;$i++)
			{
				if($i < 10)	$tempOther= '0'.$i;			else $tempOther= $i;
				
				if (in_array("'".$tempOther."'", $arrayVal)) {
				}else{
					if($state_in == '')$plus = '';			else		$plus = '+';
					$state_in .= $plus." CASE NVL (B.IN_".$i.", '0') WHEN '0' THEN 1 ELSE 0 END ";
				}
				
			}
			$str .= $state_in.
			"
			FROM ABSENSI_REKAP_MASUK_PULANG B
			WHERE 1 = 1 AND B.PEGAWAI_ID = A.PEGAWAI_ID AND PERIODE='".$temp_bulan.$tahun."') 
			, 0)
			DATA_".$temp_bulan.$tahun;
		}
		$str .= " FROM PEGAWAI A WHERE 1 = 1 "; 
		
		/*while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}*/
		
		$str .= $statement." ".$order;
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsGetHariLibur($paramsArray=array(),$limit=-1,$from=-1,$statement="", $tahun='', $bulan='', $order="")
	{
		// PARAMETER KE ABSENSI REKAP
		$tempBulanTahun=$bulan.$tahun;
		$str = "
				 SELECT
				(CASE
				   WHEN TO_CHAR (TANGGAL_AWAL, 'MMYYYY') = '".$tempBulanTahun."' AND TO_CHAR (TANGGAL_AKHIR, 'MMYYYY') = '".$tempBulanTahun."'
					  THEN RANGE_DATE(TANGGAL_AWAL, TANGGAL_AKHIR )
				   WHEN TO_CHAR (TANGGAL_AKHIR, 'MMYYYY') = '".$tempBulanTahun."'
					  THEN RANGE_DATE(TO_DATE ('01' || '".$tempBulanTahun."', 'DD-MM-YYYY' ), TANGGAL_AKHIR )
				   WHEN TO_CHAR (TANGGAL_AKHIR, 'MMYYYY') != '".$tempBulanTahun."' AND TO_CHAR (TANGGAL_AWAL, 'MMYYYY') != '".$tempBulanTahun."'
					 THEN RANGE_DATE(TO_DATE ('01' || '".$tempBulanTahun."', 'DD-MM-YYYY' ), LAST_DAY (TO_DATE ('".$tempBulanTahun."', 'MMYYYY')) )
				   ELSE RANGE_DATE(TANGGAL_AWAL, LAST_DAY (TO_DATE ('".$tempBulanTahun."', 'MMYYYY')) )
				END) RANGE_HARI_LIBUR, WEEKDAYS_RANGE_DATE(TO_DATE ('01' || '".$tempBulanTahun."', 'DD-MM-YYYY' ), LAST_DAY (TO_DATE ('".$tempBulanTahun."', 'MMYYYY')) ) RANGE_HARI_WEEKEND, RANGE_DATE_HARI_LIBUR_FIX('".$bulan."', '".$tahun."') RANGE_HARI_WEEKEND_FIX
				FROM HARI_LIBUR
				WHERE TO_DATE ('".$tempBulanTahun."', 'MMYYYY') BETWEEN TO_DATE (TO_CHAR (TANGGAL_AWAL, 'MMYYYY'),'MMYYYY') AND TO_DATE (TO_CHAR (TANGGAL_AKHIR, 'MMYYYY'), 'MMYYYY' )
				 "
		;
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsGetWeekend($paramsArray=array(),$limit=-1,$from=-1,$statement="", $tahun='', $bulan='', $order="")
	{
		// PARAMETER KE ABSENSI REKAP
		$tempBulanTahun=$bulan.$tahun;
		$str = "
				 SELECT
				WEEKDAYS_RANGE_DATE(TO_DATE ('01' || '".$tempBulanTahun."', 'DD-MM-YYYY' ), LAST_DAY (TO_DATE ('".$tempBulanTahun."', 'MMYYYY')) ) RANGE_HARI_WEEKEND
				FROM DUAL
				 "
		;
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT A.ABSENSI_ID ABSENSI_ID, A.PEGAWAI_ID PEGAWAI_ID, B.NIK NIK, B.NAMA NAMA, C.SATKER_ID SATKER_ID, C.NAMA SATKER, STATUS, 
				TO_CHAR(JAM, 'HH24:MI') AS JAM, TO_CHAR(JAM, 'DD-MM-YYYY') AS TANGGAL,VALIDASI, B.FOTO FOTO, VALIDATOR
					FROM ABSENSI A, PEGAWAI B, SATKER C 
					WHERE A.PEGAWAI_ID = B.PEGAWAI_ID AND B.SATKER_ID=C.SATKER_ID 
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
				ABSENSI_ID, PEGAWAI_ID, JAM, 
				   STATUS
				FROM ABSENSI
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY ABSENSI_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParamsModif($paramsArray=array(), $statement="", $periode="")
	{
		$str = "
		SELECT COUNT(1) AS ROWCOUNT FROM (SELECT DEPARTEMEN_ID, ABSENSI_REKAP_ID, NRP, NAMA, JABATAN, JENIS_PEGAWAI_ID, KELAS, PERIODE, IN_1, OUT_1, JJ_1, 
                    IN_2, OUT_2, JJ_2, IN_3, OUT_3, JJ_3, IN_4, OUT_4, JJ_4, IN_5, OUT_5, JJ_5, 
                    IN_6, OUT_6, JJ_6, IN_7, OUT_7, JJ_7, IN_8, OUT_8, JJ_8, IN_9, OUT_9, JJ_9, 
                    IN_10, OUT_10, JJ_10, IN_11, OUT_11, JJ_11, IN_12, OUT_12, JJ_12, IN_13, OUT_13, JJ_13, 
                    IN_14, OUT_14, JJ_14, IN_15, OUT_15, JJ_15, IN_16, OUT_16, JJ_16, IN_17, OUT_17, JJ_17, 
                    IN_18, OUT_18, JJ_18, IN_19, OUT_19, JJ_19, IN_20, OUT_20, JJ_20, IN_21, OUT_21, JJ_21, 
                    IN_22, OUT_22, JJ_22, IN_23, OUT_23, JJ_23, IN_24, OUT_24, JJ_24, IN_25, OUT_25, JJ_25, 
                    IN_26, OUT_26, JJ_26, IN_27, OUT_27, JJ_27, IN_28, OUT_28, JJ_28, IN_29, OUT_29, JJ_29, 
                    IN_30, OUT_30, JJ_30, IN_31, OUT_31, JJ_31 
                FROM PPI_ABSENSI.ABSENSI_REKAP_JAM_KERJA_V2 A
           		 LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                WHERE periode = '".$periode."' 
                union
                select DEPARTEMEN_ID, 0 ABSENSI_REKAP_ID, NRP, NAMA, JABATAN, JENIS_PEGAWAI_ID, TO_NUMBER(KELAS), '".$periode."' PERIODE,
                null IN_1, null OUT_1, null JJ_1, 
                    null IN_2, null OUT_2, null JJ_2, null IN_3, null OUT_3, null JJ_3, null IN_4, null OUT_4, null JJ_4, null IN_5, null OUT_5, null JJ_5, 
                    null IN_6, null OUT_6, null JJ_6, null IN_7, null OUT_7, null JJ_7, null IN_8, null OUT_8, null JJ_8, null IN_9, null OUT_9, null JJ_9, 
                    null IN_10, null OUT_10, null JJ_10, null IN_11, null OUT_11, null JJ_11, null IN_12, null OUT_12, null JJ_12, null IN_13, null OUT_13, null JJ_13, 
                    null IN_14, null OUT_14, null JJ_14, null IN_15, null OUT_15, null JJ_15, null IN_16, null OUT_16, null JJ_16, null IN_17, null OUT_17, null JJ_17, 
                    null IN_18, null OUT_18, null JJ_18, null IN_19, null OUT_19, null JJ_19, null IN_20, null OUT_20, null JJ_20, null IN_21, null OUT_21, null JJ_21, 
                    null IN_22, null OUT_22, null JJ_22, null IN_23, null OUT_23, null JJ_23, null IN_24, null OUT_24, null JJ_24, null IN_25, null OUT_25, null JJ_25, 
                    null IN_26, null OUT_26, null JJ_26, null IN_27, null OUT_27, null JJ_27, null IN_28, null OUT_28, null JJ_28, null IN_29, null OUT_29, null JJ_29, 
                    null IN_30, null OUT_30, null JJ_30, null IN_31, null OUT_31, null JJ_31
                 from PPI_SIMPEG.PEGAWAI_ALL
                where pegawai_id not in (select pegawai_id FROM PPI_ABSENSI.ABSENSI_REKAP_JAM_KERJA_V2 A
                WHERE periode = '".$periode."')
                and status_pegawai = 'Aktif'
                and jenis_pegawai not in ('Dewan Komisaris', 'Dewan Direksi', 'KSO')) A WHERE 0=0 ".$statement; 
				
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$this->query = $str;
		$this->select($str);
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
	function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI A INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
		 WHERE 1 = 1  ".$statement; 
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
	
	function getCountByParamsRekapDatangAwal($paramsArray=array(),$statement="", $tahun='', $bulan='', $satker_id='')
	{
		// PARAMETER KE ABSENSI REKAP
		$str = "
				 SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT
				 FROM PEGAWAI A
				 INNER JOIN 
				 (
				 "
		;//SELECT TO_CHAR(A.PEGAWAI_ID), NAMA, TO_CHAR(B.JAM, 'DD') HARI, TO_CHAR(B.JAM, 'HH24:MI:SS') JAM
		
		// PROSES MENGHITUNG BANYAK NYA JUMLAH DATANG AWAL JAN - DES BERDASARKAN JAM KERJA STATUS 1 TANPA HOLIDAY
		$temp= $bulan;
		
		for($i=1;$i <= 31; $i++){
			if($i < 10)	$temp_hari= '0'.$i;
			else		$temp_hari= $i;
		
			if($i == 1)	{$parameter = '';}
			else		{$parameter = ' UNION ALL';}
			
			$str .=$parameter."
			SELECT P.PEGAWAI_ID, P.IN_".$i." JAM, ".$i." HARI
			FROM ABSENSI_REKAP_MASUK_PULANG P,
			(SELECT MIN(IN_".$i.") IN_".$i."
				FROM ABSENSI_REKAP_MASUK_PULANG
				WHERE PERIODE = '".$temp.$tahun."'
				AND SATKER_ID LIKE '".$satker_id."%'
				AND REGEXP_LIKE (IN_".$i.", '^[0-9]')
			) X
			WHERE P.IN_".$i." = X.IN_".$i."
			AND P.SATKER_ID LIKE '".$satker_id."%'AND REGEXP_LIKE (P.IN_".$i.", '^[0-9]') AND P.PERIODE = '".$temp.$tahun."'
			AND ROWNUM=1 
			";
		}
			
		$str .="
				)  B
				ON A.PEGAWAI_ID=B.PEGAWAI_ID
				WHERE 1=1
			";

		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;
    }
	
    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(ABSENSI_ID) AS ROWCOUNT FROM ABSENSI WHERE 1 = 1 "; 
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

    function insertRekapan(){
		$str = "
				INSERT INTO PPI_ABSENSI.ABSENSI_REKAP_MASUK_KERJA (
				   TGL_ABSEN, PEGAWAI_ID, KELOMPOK, KAPAL_ID, 
				   LOKASI, TOTAL)    
				VALUES(
					  ".$this->getField("TGL_ABSEN").",
					  '".$this->getField("PEGAWAI_ID")."',
					  '".$this->getField("KELOMPOK")."',
					  '".$this->getField("KAPAL_ID")."',
					  '".$this->getField("LOKASI")."',
				  	  ".$this->getField("TOTAL")."
				)"; 
		//echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }
    function updateRekapan()	{
		$str = "
				UPDATE PPI_ABSENSI.ABSENSI_REKAP_MASUK_KERJA 
				SET    
					   KELOMPOK		= '".$this->getField("KELOMPOK")."',
					   KAPAL_ID		= '".$this->getField("KAPAL_ID")."',
					   LOKASI	 	= '".$this->getField("LOKASI")."',
					   TOTAL	 	= ".$this->getField("TOTAL")."
				WHERE  TGL_ABSEN	= ".$this->getField("TGL_ABSEN")."
				AND PEGAWAI_ID	= '".$this->getField("PEGAWAI_ID")."' 
			 "; 
		//echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }


  } 
?>