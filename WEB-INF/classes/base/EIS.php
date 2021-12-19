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

  class EIS extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function EIS()
	{
      $this->Entity(); 
    }

    function selectByParamsPemenuhanAwakKapalJenis($paramsArray=array(),$limit=-1,$from=-1, $periode="", $statement="")
	{
		$str = "
					SELECT A.KAPAL_JENIS_ID, A.NAMA, NVL(ROUND(SUM(RATIO) / COUNT(KAPAL_ID), 4), 0) * 100 RATIO FROM 
					PEL_OPERASIONAL.KAPAL_JENIS A LEFT JOIN
					(
					SELECT A.KAPAL_ID, A.KAPAL_JENIS_ID, NAMA, JUMLAH_PEMENUHAN, JUMLAH_DIPENUHI, ROUND(JUMLAH_DIPENUHI / JUMLAH_PEMENUHAN, 4) RATIO FROM PEL_OPERASIONAL.KAPAL A 
					INNER JOIN (SELECT KAPAL_ID, COUNT(KAPAL_KRU_ID) JUMLAH_PEMENUHAN FROM PEL_OPERASIONAL.KAPAL_KRU GROUP BY KAPAL_ID) B ON A.KAPAL_ID = B.KAPAL_ID
					INNER JOIN (SELECT KAPAL_ID, COUNT(PEGAWAI_ID) JUMLAH_DIPENUHI FROM PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI WHERE TO_DATE('".$periode."', 'MMYYYY') BETWEEN TANGGAL_MASUK AND NVL(TANGGAL_KELUAR, SYSDATE) GROUP BY KAPAL_ID) C ON A.KAPAL_ID = C.KAPAL_ID
					) B ON A.KAPAL_JENIS_ID = B.KAPAL_JENIS_ID GROUP BY A.KAPAL_JENIS_ID, A.NAMA			
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.KAPAL_JENIS_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
		
    function selectByParamsPemenuhanAwakKapal($paramsArray=array(),$limit=-1,$from=-1, $periode="", $statement="")
	{
		$str = "
				SELECT A.KAPAL_ID, A.KAPAL_JENIS_ID, NAMA, JUMLAH_PEMENUHAN, JUMLAH_DIPENUHI, ROUND(JUMLAH_DIPENUHI / JUMLAH_PEMENUHAN, 4) * 100 RATIO FROM PEL_OPERASIONAL.KAPAL A 
				INNER JOIN (SELECT KAPAL_ID, COUNT(KAPAL_KRU_ID) JUMLAH_PEMENUHAN FROM PEL_OPERASIONAL.KAPAL_KRU GROUP BY KAPAL_ID) B ON A.KAPAL_ID = B.KAPAL_ID
				INNER JOIN (SELECT KAPAL_ID, COUNT(PEGAWAI_ID) JUMLAH_DIPENUHI FROM PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI WHERE TO_DATE('".$periode."', 'MMYYYY') BETWEEN TANGGAL_MASUK AND NVL(TANGGAL_KELUAR, SYSDATE) GROUP BY KAPAL_ID) C ON A.KAPAL_ID = C.KAPAL_ID				
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY NAMA DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPemenuhanFormasiSDM($paramsArray=array(),$limit=-1,$from=-1, $periode="", $statement="")
	{
		$str = "
				SELECT   A.DEPARTEMEN_ID, A.NAMA, A.DEPARTEMEN_PARENT_ID,
					 PPI_SIMPEG.AMBIL_JUMLAH_PEGAWAI_DEPT (A.DEPARTEMEN_ID,
															  '".$periode."'
															 ) PEMENUHAN,
					 NVL(JUMLAH_STAFF, 0) FORMASI,
					 NVL(ROUND(
						 PPI_SIMPEG.AMBIL_JUMLAH_PEGAWAI_DEPT (A.DEPARTEMEN_ID,'".$periode."') / DECODE (JUMLAH_STAFF, 0, 1, JUMLAH_STAFF)
						 ,
						 4
						) * 100, 0) LEVEL_3,
					  DECODE(LENGTH(DEPARTEMEN_ID), 4, NVL(ROUND(PPI_SIMPEG.AMBIL_JUMLAH_PEGAWAI_DEPT_LIKE(A.DEPARTEMEN_ID,'".$periode."') / PPI_SIMPEG.AMBIL_JUMLAH_FORMASI(DEPARTEMEN_ID), 4), 0) * 100, 0) LEVEL_2,
					  DECODE(LENGTH(DEPARTEMEN_ID), 2, NVL(ROUND(PPI_SIMPEG.AMBIL_JUMLAH_PEGAWAI_DEPT_LIKE(A.DEPARTEMEN_ID,'".$periode."') / PPI_SIMPEG.AMBIL_JUMLAH_FORMASI(DEPARTEMEN_ID), 4), 0) * 100, 0) LEVEL_1,
					  DECODE(LENGTH(DEPARTEMEN_ID), 2, NVL(ROUND(PPI_SIMPEG.AMBIL_JUMLAH_PEGAWAI_DEPT_LIKE('','".$periode."') / PPI_SIMPEG.AMBIL_JUMLAH_FORMASI(''), 4), 0) * 100, 0) LEVEL_0,
					  PPI_SIMPEG.AMBIL_JUMLAH_ROW_DEPARTEMEN(DEPARTEMEN_ID) JUMLAH_ROW                                                                                    
				FROM PPI_SIMPEG.DEPARTEMEN A
			   WHERE 1 = 1
				 AND NOT A.DEPARTEMEN_ID IN ('66', '77', '88')
				 AND STATUS_AKTIF = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.DEPARTEMEN_ID ASC";
		
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }	
	

    function selectByParamsPemenuhanFormasiSDMCabang($paramsArray=array(),$limit=-1,$from=-1, $periode="", $statement="")
	{
		$str = "
				SELECT A.CABANG_ID, A.NAMA, PPI_SIMPEG.AMBIL_JUMLAH_PEGAWAI_CAB(A.CABANG_ID, '".$periode."') PEMENUHAN, 
						NVL(PPI_SIMPEG.AMBIL_JUMLAH_FORMASI_CAB(CABANG_ID), 0) FORMASI,  
					   ROUND(PPI_SIMPEG.AMBIL_JUMLAH_PEGAWAI_CAB(A.CABANG_ID, '".$periode."') / NVL(PPI_SIMPEG.AMBIL_JUMLAH_FORMASI_CAB(CABANG_ID), 1), 4) * 100 RATIO
				FROM PPI_SIMPEG.CABANG A WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.CABANG_ID ASC";
		
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }	
    function selectByParamsJumlahMPPPensiun($paramsArray=array(),$limit=-1,$from=-1, $periode="", $batas_umur="", $statement="")
	{
		$str = "
				SELECT A.DEPARTEMEN_ID, A.NAMA, A.DEPARTEMEN_PARENT_ID, PPI_SIMPEG.AMBIL_JUMLAH_PEGAWAI_PENSIUN(DEPARTEMEN_ID, '".$periode."', ".$batas_umur.") JUMLAH FROM 
				PPI_SIMPEG.DEPARTEMEN A WHERE 1 = 1 AND NOT A.DEPARTEMEN_ID IN ('66', '77', '88') AND STATUS_AKTIF = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.DEPARTEMEN_ID ASC";
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsMPPPensiun($paramsArray=array(),$limit=-1,$from=-1, $periode="", $batas_umur="", $departemen_id, $statement="")
	{
		$str = "
					SELECT NRP, NAMA, DEPARTEMEN_ID, PPI_SIMPEG.AMBIL_UNIT_KERJA(DEPARTEMEN_ID) DEPARTEMEN FROM
					(
					SELECT PEGAWAI_ID, NRP, NAMA, DEPARTEMEN_ID, STATUS_PEGAWAI_ID, 
					CASE WHEN (TO_NUMBER(TO_CHAR(TO_DATE('01' || '".$periode."', 'DDMMYYYY'), 'MM'))-TO_NUMBER(TO_CHAR(TANGGAL_LAHIR, 'MM')))<0 THEN
                            TO_NUMBER(TO_CHAR(TO_DATE('01' || '".$periode."', 'DDMMYYYY'), 'YYYY'))-TO_NUMBER(TO_CHAR(TANGGAL_LAHIR, 'YYYY'))-1
                        ELSE TO_NUMBER(TO_CHAR(TO_DATE('01' || '".$periode."', 'DDMMYYYY'), 'YYYY'))-TO_NUMBER(TO_CHAR(TANGGAL_LAHIR, 'YYYY')) END TAHUN,
                    CASE WHEN (TO_NUMBER(TO_CHAR(TO_DATE('01' || '".$periode."', 'DDMMYYYY'), 'MM'))-TO_NUMBER(TO_CHAR(TANGGAL_LAHIR, 'MM')))<0 THEN
                            12+TO_NUMBER(TO_CHAR(TO_DATE('01' || '".$periode."', 'DDMMYYYY'), 'MM'))-TO_NUMBER(TO_CHAR(TANGGAL_LAHIR, 'MM'))
                        ELSE TO_NUMBER(TO_CHAR(TO_DATE('01' || '".$periode."', 'DDMMYYYY'), 'MM'))-TO_NUMBER(TO_CHAR(TANGGAL_LAHIR, 'MM')) END AS BULAN
					/*TO_CHAR(TRUNC(MONTHS_BETWEEN(TO_DATE('01' || '".$periode."', 'DDMMYYYY'),TANGGAL_LAHIR)/12)) TAHUN,
                    TO_CHAR(TRUNC(MOD(MONTHS_BETWEEN (TO_DATE('01' || '".$periode."', 'DDMMYYYY'), TANGGAL_LAHIR),12))) BULAN*/
					FROM PPI_SIMPEG.PEGAWAI A
					) X
					WHERE DEPARTEMEN_ID LIKE '".$departemen_id."%'  AND NOT X.DEPARTEMEN_ID IN ('66', '77', '88') AND STATUS_PEGAWAI_ID = 1 AND TAHUN = ".$batas_umur." AND BULAN = 0
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY DEPARTEMEN_ID ";
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }		



	
	
    function selectByParamsDisiplinSDM($paramsArray=array(),$limit=-1,$from=-1, $periode="", $statement="")
	{
		$str = "
				SELECT DEPARTEMEN_ID, DEPARTEMEN_PARENT_ID, NAMA, 
						CASE WHEN PPI_ABSENSI.AMBIL_KOREKSI_ABSENSI(DEPARTEMEN_ID,  '".$periode."') = 0 THEN 0 ELSE ROUND(PPI_ABSENSI.AMBIL_KOREKSI_TERLAMBAT(DEPARTEMEN_ID,  '".$periode."') / PPI_ABSENSI.AMBIL_KOREKSI_ABSENSI(DEPARTEMEN_ID,  '".$periode."'), 4) * 100 END RATIO					    
				FROM PPI_SIMPEG.DEPARTEMEN A WHERE 1 = 1 AND NOT A.DEPARTEMEN_ID IN ('66', '77', '88') AND STATUS_AKTIF = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.DEPARTEMEN_ID ASC";
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsPulangCepatSDM($paramsArray=array(),$limit=-1,$from=-1, $periode="", $statement="")
	{
		$str = "
				SELECT DEPARTEMEN_ID, DEPARTEMEN_PARENT_ID, NAMA, 
						CASE WHEN PPI_ABSENSI.AMBIL_KOREKSI_ABSENSI(DEPARTEMEN_ID,  '".$periode."') = 0 THEN 0 ELSE ROUND(PPI_ABSENSI.AMBIL_KOREKSI_PULANG_CEPAT(DEPARTEMEN_ID,  '".$periode."') / PPI_ABSENSI.AMBIL_KOREKSI_ABSENSI(DEPARTEMEN_ID,  '".$periode."'), 4) * 100 END RATIO					    
				FROM PPI_SIMPEG.DEPARTEMEN A WHERE 1 = 1 AND NOT A.DEPARTEMEN_ID IN ('66', '77', '88') AND STATUS_AKTIF = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.DEPARTEMEN_ID ASC";
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
			
    function selectByParamsKehadiranSDM($paramsArray=array(),$limit=-1,$from=-1, $periode="", $statement="")
	{
		$str = "
				SELECT DEPARTEMEN_ID, DEPARTEMEN_PARENT_ID, NAMA, 
						CASE WHEN PPI_ABSENSI.AMBIL_KOREKSI_ABSENSI(DEPARTEMEN_ID,  '".$periode."') = 0 THEN 0 ELSE ROUND(PPI_ABSENSI.AMBIL_KOREKSI_KEHADIRAN(DEPARTEMEN_ID,  '".$periode."') / PPI_ABSENSI.AMBIL_KOREKSI_ABSENSI(DEPARTEMEN_ID,  '".$periode."'), 4) * 100 END RATIO					    
				FROM PPI_SIMPEG.DEPARTEMEN A WHERE 1 = 1 AND NOT A.DEPARTEMEN_ID IN ('66', '77', '88') AND STATUS_AKTIF = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.DEPARTEMEN_ID ASC";
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
			
		
  } 
?>