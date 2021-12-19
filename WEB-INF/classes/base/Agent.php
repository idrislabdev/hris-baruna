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

  class Agent extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Agent()
	{
      $this->Entity(); 
    }

    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE ".$this->getField("TABEL")." SET
				  STATUS_NOTIF = 0
				WHERE ".$this->getField("TABEL_ID")." = ".$this->getField("TABEL_ID_VALUE")."
				"; 
				$this->query = $str;
	//echo $str;
		return $this->execQuery($str);
    }		
	
    function selectByParamsNotifikasiJob($paramsArray=array(),$limit=-1,$from=-1, $statement="", $batas="")
	{
		$str = "
				SELECT 'Notifikasi kontrak PKWT' STATUS, COUNT (*) JUMLAH
				  FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G
					   ON A.PEGAWAI_ID = G.PEGAWAI_ID       
				 WHERE NVL (G.STATUS_NOTIF, 1) = 1
				   AND (       
						(G.TANGGAL_KONTRAK_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
						 AND G.TANGGAL_KONTRAK_AKHIR > SYSDATE
						 OR G.TANGGAL_KONTRAK_AKHIR <= SYSDATE
					   )
				   AND A.STATUS_PEGAWAI_ID IN (1, 5)
				   AND G.JENIS_PEGAWAI_ID = 3
				UNION ALL
				SELECT 'Notifikasi sertifikat kapal' STATUS, COUNT (*) JUMLAH
				  FROM PEL_OPERASIONAL.KAPAL A INNER JOIN PEL_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL B
					   ON B.KAPAL_ID = A.KAPAL_ID AND B.TANGGAL_KADALUARSA IS NOT NULL
					   INNER JOIN PEL_OPERASIONAL.SERTIFIKAT_KAPAL C
					   ON B.SERTIFIKAT_KAPAL_ID = C.SERTIFIKAT_KAPAL_ID
				 WHERE NVL (B.STATUS_NOTIF, 1) = 1
				   AND (       (B.TANGGAL_KADALUARSA - INTERVAL '".$batas."' DAY) < SYSDATE
						   AND B.TANGGAL_KADALUARSA > SYSDATE
						OR B.TANGGAL_KADALUARSA <= SYSDATE
					   )
				UNION ALL
				SELECT 'Notifikasi sertifikat awak kapal' STATUS, COUNT (*) JUMLAH
				  FROM PPI_SIMPEG.PEGAWAI A INNER JOIN PEL_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL B
					   ON B.PEGAWAI_ID = A.PEGAWAI_ID
					 AND B.TANGGAL_TERBIT IS NOT NULL
					 AND B.TANGGAL_KADALUARSA IS NOT NULL
					   INNER JOIN PEL_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL C
					   ON B.SERTIFIKAT_AWAK_KAPAL_ID = C.SERTIFIKAT_AWAK_KAPAL_ID
				 WHERE NVL (B.STATUS_NOTIF, 1) = 1
				   AND (       (B.TANGGAL_KADALUARSA - INTERVAL '".$batas."' DAY) < SYSDATE
						   AND B.TANGGAL_KADALUARSA > SYSDATE
						OR B.TANGGAL_KADALUARSA <= SYSDATE
					   )
				UNION ALL
				SELECT 'Notifikasi kontrak' STATUS, SUM (A.JUMLAH)
				  FROM (SELECT 'KONTRAK SBPP' KONTRAK_SBPP, COUNT (*) JUMLAH
						  FROM PEL_OPERASIONAL.KONTRAK_SBPP A INNER JOIN PEL_OPERASIONAL.LOKASI B
							   ON A.LOKASI_ID = B.LOKASI_ID
						 WHERE KONTRAK_SBPP_ID IS NOT NULL
						   AND NVL (A.STATUS_NOTIF, 1) = 1
						   AND (       (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
								   AND A.TANGGAL_AKHIR > SYSDATE
								OR A.TANGGAL_AKHIR <= SYSDATE
							   )
						UNION ALL
						SELECT 'KONTRAK TIME-CHARTER' KONTRAK_SBPP, COUNT (*) JUMLAH
						  FROM PEL_OPERASIONAL.KAPAL_PEKERJAAN A INNER JOIN PEL_OPERASIONAL.LOKASI B
							   ON A.LOKASI_ID = B.LOKASI_ID
						 WHERE NVL (A.STATUS_NOTIF, 1) = 1
						   AND (       (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
								   AND A.TANGGAL_AKHIR > SYSDATE
								OR A.TANGGAL_AKHIR <= SYSDATE
							   )
						UNION ALL
						SELECT 'TIME-CHARTER SEWA' KONTRAK_SBPP, COUNT (*) JUMLAH
						  FROM PEL_OPERASIONAL.KAPAL_PEKERJAAN_SEWA A INNER JOIN PEL_OPERASIONAL.LOKASI B
							   ON A.LOKASI_ID = B.LOKASI_ID
						 WHERE NVL (A.STATUS_NOTIF, 1) = 1
						   AND (       (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
								   AND A.TANGGAL_AKHIR > SYSDATE
								OR A.TANGGAL_AKHIR <= SYSDATE
				)) A WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
    function selectByParamsNotifikasiJobPkwt($paramsArray=array(),$limit=-1,$from=-1, $statement="", $batas="")
	{
		$str = "
				SELECT COUNT (*) JUMLAH
				  FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G
					   ON A.PEGAWAI_ID = G.PEGAWAI_ID       
				 WHERE NVL (G.STATUS_NOTIF, 1) = 1
				   AND (       
						(G.TANGGAL_KONTRAK_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
						 AND G.TANGGAL_KONTRAK_AKHIR > SYSDATE
						 OR G.TANGGAL_KONTRAK_AKHIR <= SYSDATE
					   )
				   AND A.STATUS_PEGAWAI_ID IN (1, 5)
				   AND G.JENIS_PEGAWAI_ID = 3
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }		
			
    function selectByParamsNotifikasiJobSertifikatKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $batas="")
	{
		$str = "
				SELECT COUNT (*) JUMLAH
				  FROM PEL_OPERASIONAL.KAPAL A INNER JOIN PEL_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL B
					   ON B.KAPAL_ID = A.KAPAL_ID AND B.TANGGAL_KADALUARSA IS NOT NULL
					   INNER JOIN PEL_OPERASIONAL.SERTIFIKAT_KAPAL C
					   ON B.SERTIFIKAT_KAPAL_ID = C.SERTIFIKAT_KAPAL_ID
				 WHERE NVL (B.STATUS_NOTIF, 1) = 1
				   AND (       (B.TANGGAL_KADALUARSA - INTERVAL '".$batas."' DAY) < SYSDATE
						   AND B.TANGGAL_KADALUARSA > SYSDATE
						OR B.TANGGAL_KADALUARSA <= SYSDATE
					   )
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsNotifikasiJobSertifikatAwakKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $batas="")
	{
		$str = "				
				SELECT COUNT (*) JUMLAH
				  FROM PPI_SIMPEG.PEGAWAI A INNER JOIN PEL_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL B
					   ON B.PEGAWAI_ID = A.PEGAWAI_ID
					 AND B.TANGGAL_TERBIT IS NOT NULL
					 AND B.TANGGAL_KADALUARSA IS NOT NULL
					   INNER JOIN PEL_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL C
					   ON B.SERTIFIKAT_AWAK_KAPAL_ID = C.SERTIFIKAT_AWAK_KAPAL_ID
				 WHERE NVL (B.STATUS_NOTIF, 1) = 1
				   AND (       (B.TANGGAL_KADALUARSA - INTERVAL '".$batas."' DAY) < SYSDATE
						   AND B.TANGGAL_KADALUARSA > SYSDATE
						OR B.TANGGAL_KADALUARSA <= SYSDATE
					   )
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsNotifikasiJobKontrakSbpp($paramsArray=array(),$limit=-1,$from=-1, $statement="", $batas="")
	{
		$str = "SELECT COUNT (*) JUMLAH
				FROM PEL_OPERASIONAL.KONTRAK_SBPP A INNER JOIN PEL_OPERASIONAL.LOKASI B
					 ON A.LOKASI_ID = B.LOKASI_ID
			   WHERE KONTRAK_SBPP_ID IS NOT NULL
				 AND NVL (A.STATUS_NOTIF, 1) = 1
				 AND (       (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
						 AND A.TANGGAL_AKHIR > SYSDATE
					  OR A.TANGGAL_AKHIR <= SYSDATE
					 )			 
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsNotifikasiJobTimeCharter($paramsArray=array(),$limit=-1,$from=-1, $statement="", $batas="")
	{
		$str = "
			  SELECT 'KONTRAK TIME-CHARTER' KONTRAK_SBPP, COUNT (*) JUMLAH
				FROM PEL_OPERASIONAL.KAPAL_PEKERJAAN A INNER JOIN PEL_OPERASIONAL.LOKASI B
					 ON A.LOKASI_ID = B.LOKASI_ID
			   WHERE NVL (A.STATUS_NOTIF, 1) = 1
				 AND (       (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
						 AND A.TANGGAL_AKHIR > SYSDATE
					  OR A.TANGGAL_AKHIR <= SYSDATE
					 )
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsNotifikasiJobTimeCharterSewa($paramsArray=array(),$limit=-1,$from=-1, $statement="", $batas="")
	{
		$str = "
			  SELECT 'TIME-CHARTER SEWA' KONTRAK_SBPP, COUNT (*) JUMLAH
				FROM PEL_OPERASIONAL.KAPAL_PEKERJAAN_SEWA A INNER JOIN PEL_OPERASIONAL.LOKASI B
					 ON A.LOKASI_ID = B.LOKASI_ID
			   WHERE NVL (A.STATUS_NOTIF, 1) = 1
				 AND (       (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
						 AND A.TANGGAL_AKHIR > SYSDATE
					  OR A.TANGGAL_AKHIR <= SYSDATE
			  )
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
		
    function selectByParamsNotifikasiPkwt($paramsArray=array(),$limit=-1,$from=-1, $statement="", $batas="")
	{
		$str = "
				SELECT G.PEGAWAI_JENIS_PEGAWAI_ID, A.NAMA,
					   TO_CHAR (G.TANGGAL_KONTRAK_AWAL, 'DD MON YYYY') TANGGAL_AWAL,
					   TO_CHAR (G.TANGGAL_KONTRAK_AKHIR, 'DD MON YYYY') TANGGAL_AKHIR,
					   CASE
						  WHEN (G.TANGGAL_KONTRAK_AKHIR - INTERVAL '".$batas."' DAY) <
																			 SYSDATE
						  AND G.TANGGAL_KONTRAK_AKHIR > SYSDATE
							 THEN 'Warning'
						  WHEN G.TANGGAL_KONTRAK_AKHIR <= SYSDATE
							 THEN 'Expired'
					   END STATUS
				  FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G
					   ON A.PEGAWAI_ID = G.PEGAWAI_ID
				 WHERE NVL (G.STATUS_NOTIF, 1) = 1
				   AND (       (G.TANGGAL_KONTRAK_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
						   AND G.TANGGAL_KONTRAK_AKHIR > SYSDATE
						OR G.TANGGAL_KONTRAK_AKHIR <= SYSDATE
					   )
				   AND A.STATUS_PEGAWAI_ID IN (1, 5)
				   AND G.JENIS_PEGAWAI_ID = 3
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsNotifikasiSertifikatKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $batas="")
	{
		$str = "
					SELECT   B.KAPAL_SERTIFIKAT_KAPAL_ID, A.NAMA, C.NAMA SERTIFIKAT,
							 TO_CHAR (B.TANGGAL_TERBIT, 'DD MON YYYY') AS TANGGAL_AWAL,
							 TO_CHAR (B.TANGGAL_KADALUARSA, 'DD MON YYYY') TANGGAL_AKHIR,
							 CASE
								WHEN (B.TANGGAL_KADALUARSA - INTERVAL '".$batas."' DAY) <
																				 SYSDATE
								AND B.TANGGAL_KADALUARSA > SYSDATE
								   THEN 'Warning'
								WHEN B.TANGGAL_KADALUARSA <= SYSDATE
								   THEN 'Expired'
							 END STATUS
						FROM PEL_OPERASIONAL.KAPAL A INNER JOIN PEL_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL B
							 ON B.KAPAL_ID = A.KAPAL_ID AND B.TANGGAL_KADALUARSA IS NOT NULL
							 INNER JOIN PEL_OPERASIONAL.SERTIFIKAT_KAPAL C
							 ON B.SERTIFIKAT_KAPAL_ID = C.SERTIFIKAT_KAPAL_ID
					   WHERE NVL (B.STATUS_NOTIF, 1) = 1
						 AND (       (B.TANGGAL_KADALUARSA - INTERVAL '".$batas."' DAY) < SYSDATE
								 AND B.TANGGAL_KADALUARSA > SYSDATE
							  OR B.TANGGAL_KADALUARSA <= SYSDATE
							 )
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY B.TANGGAL_KADALUARSA ASC, A.NAMA ASC ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
    function selectByParamsNotifikasiSertifikatAwakKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $batas="")
	{
		$str = "
				SELECT   B.PEGAWAI_SERTIFIKAT_AWAK_KPL_ID, A.NAMA, C.NAMA SERTIFIKAT,
						 TO_CHAR (B.TANGGAL_TERBIT, 'DD MON YYYY') AS TANGGAL_AWAL,
						 TO_CHAR (B.TANGGAL_KADALUARSA, 'DD MON YYYY') TANGGAL_AKHIR,
						 CASE
							WHEN (B.TANGGAL_KADALUARSA - INTERVAL '".$batas."' DAY) <
																			 SYSDATE
							AND B.TANGGAL_KADALUARSA > SYSDATE
							   THEN 'Warning'
							WHEN B.TANGGAL_KADALUARSA <= SYSDATE
							   THEN 'Expired'
						 END STATUS
					FROM PPI_SIMPEG.PEGAWAI A INNER JOIN PEL_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL B
						 ON B.PEGAWAI_ID = A.PEGAWAI_ID
					   AND B.TANGGAL_TERBIT IS NOT NULL
					   AND B.TANGGAL_KADALUARSA IS NOT NULL
						 INNER JOIN PEL_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL C
						 ON B.SERTIFIKAT_AWAK_KAPAL_ID = C.SERTIFIKAT_AWAK_KAPAL_ID
				   WHERE NVL (B.STATUS_NOTIF, 1) = 1
					 AND (       (B.TANGGAL_KADALUARSA - INTERVAL '".$batas."' DAY) < SYSDATE
							 AND B.TANGGAL_KADALUARSA > SYSDATE
						  OR B.TANGGAL_KADALUARSA <= SYSDATE
						 )
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY B.TANGGAL_KADALUARSA ASC, A.NAMA ASC ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsNotifikasiKontrak($paramsArray=array(),$limit=-1,$from=-1, $statement="", $batas="")
	{
		$str = "
					SELECT KONTRAK_SBPP_ID ID_KONTRAK, 'KONTRAK SBPP' TIPE_KONTRAK,
						   NOMOR NOMOR, B.NAMA LOKASI,
						   TO_CHAR (TANGGAL_AWAL, 'DD MON YYYY') AS TANGGAL_AWAL,
						   TO_CHAR (TANGGAL_AKHIR, 'DD MON YYYY') AS TANGGAL_AKHIR,
						   CASE
							  WHEN (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
							  AND A.TANGGAL_AKHIR > SYSDATE
								 THEN 'Warning'
							  WHEN A.TANGGAL_AKHIR <= SYSDATE
								 THEN 'Expired'
						   END STATUS
					  FROM PEL_OPERASIONAL.KONTRAK_SBPP A INNER JOIN PEL_OPERASIONAL.LOKASI B
						   ON A.LOKASI_ID = B.LOKASI_ID
					 WHERE NVL (A.STATUS_NOTIF, 1) = 1
					   AND (       (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
							   AND A.TANGGAL_AKHIR > SYSDATE
							OR A.TANGGAL_AKHIR <= SYSDATE
						   )
					UNION ALL
					SELECT KAPAL_PEKERJAAN_ID ID_KONTRAK, 'KONTRAK TIME-CHARTER' TIPE_KONTRAK,
						   NO_KONTRAK NOMOR, B.NAMA LOKASI,
						   TO_CHAR (TANGGAL_AWAL, 'DD MON YYYY') AS TANGGAL_AWAL,
						   TO_CHAR (TANGGAL_AKHIR, 'DD MON YYYY') AS TANGGAL_AKHIR,
						   CASE
							  WHEN (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
							  AND A.TANGGAL_AKHIR > SYSDATE
								 THEN 'Warning'
							  WHEN A.TANGGAL_AKHIR <= SYSDATE
								 THEN 'Expired'
						   END STATUS
					  FROM PEL_OPERASIONAL.KAPAL_PEKERJAAN A INNER JOIN PEL_OPERASIONAL.LOKASI B
						   ON A.LOKASI_ID = B.LOKASI_ID
					 WHERE NVL (A.STATUS_NOTIF, 1) = 1
					   AND (       (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
							   AND A.TANGGAL_AKHIR > SYSDATE
							OR A.TANGGAL_AKHIR <= SYSDATE
						   )
					UNION ALL
					SELECT KAPAL_PEKERJAAN_SEWA_ID ID_KONTRAK, 'TIME-CHARTER SEWA' TIPE_KONTRAK,
						   NO_KONTRAK NOMOR, B.NAMA LOKASI,
						   TO_CHAR (TANGGAL_AWAL, 'DD MON YYYY') AS TANGGAL_AWAL,
						   TO_CHAR (TANGGAL_AKHIR, 'DD MON YYYY') AS TANGGAL_AKHIR,
						   CASE
							  WHEN (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
							  AND A.TANGGAL_AKHIR > SYSDATE
								 THEN 'Warning'
							  WHEN A.TANGGAL_AKHIR <= SYSDATE
								 THEN 'Expired'
						   END STATUS
					  FROM PEL_OPERASIONAL.KAPAL_PEKERJAAN_SEWA A INNER JOIN PEL_OPERASIONAL.LOKASI B
						   ON A.LOKASI_ID = B.LOKASI_ID
					 WHERE NVL (A.STATUS_NOTIF, 1) = 1
					   AND (       (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
							   AND A.TANGGAL_AKHIR > SYSDATE
							OR A.TANGGAL_AKHIR <= SYSDATE
						   )
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TANGGAL_AKHIR ASC ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsNotifikasiKontrakSbpp($paramsArray=array(),$limit=-1,$from=-1, $statement="", $batas="")
	{
		$str = "
					SELECT KONTRAK_SBPP_ID ID_KONTRAK, 'KONTRAK SBPP' TIPE_KONTRAK,
						   NOMOR NOMOR, B.NAMA LOKASI,
						   TO_CHAR (TANGGAL_AWAL, 'DD MON YYYY') AS TANGGAL_AWAL,
						   TO_CHAR (TANGGAL_AKHIR, 'DD MON YYYY') AS TANGGAL_AKHIR,
						   CASE
							  WHEN (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
							  AND A.TANGGAL_AKHIR > SYSDATE
								 THEN 'Warning'
							  WHEN A.TANGGAL_AKHIR <= SYSDATE
								 THEN 'Expired'
						   END STATUS
					  FROM PEL_OPERASIONAL.KONTRAK_SBPP A INNER JOIN PEL_OPERASIONAL.LOKASI B
						   ON A.LOKASI_ID = B.LOKASI_ID
					 WHERE NVL (A.STATUS_NOTIF, 1) = 1
					   AND (       (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
							   AND A.TANGGAL_AKHIR > SYSDATE
							OR A.TANGGAL_AKHIR <= SYSDATE
						   )
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TANGGAL_AKHIR ASC ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsNotifikasiKontrakPekerjaan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $batas="")
	{
		$str = "
					SELECT KAPAL_PEKERJAAN_ID ID_KONTRAK, 'KONTRAK TIME-CHARTER' TIPE_KONTRAK,
						   NO_KONTRAK NOMOR, B.NAMA LOKASI,
						   TO_CHAR (TANGGAL_AWAL, 'DD MON YYYY') AS TANGGAL_AWAL,
						   TO_CHAR (TANGGAL_AKHIR, 'DD MON YYYY') AS TANGGAL_AKHIR,
						   CASE
							  WHEN (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
							  AND A.TANGGAL_AKHIR > SYSDATE
								 THEN 'Warning'
							  WHEN A.TANGGAL_AKHIR <= SYSDATE
								 THEN 'Expired'
						   END STATUS
					  FROM PEL_OPERASIONAL.KAPAL_PEKERJAAN A INNER JOIN PEL_OPERASIONAL.LOKASI B
						   ON A.LOKASI_ID = B.LOKASI_ID
					 WHERE NVL (A.STATUS_NOTIF, 1) = 1
					   AND (       (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
							   AND A.TANGGAL_AKHIR > SYSDATE
							OR A.TANGGAL_AKHIR <= SYSDATE
						   )
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TANGGAL_AKHIR ASC ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsNotifikasiKontrakKapalPekerjaanSewa($paramsArray=array(),$limit=-1,$from=-1, $statement="", $batas="")
	{
		$str = "
					SELECT KAPAL_PEKERJAAN_SEWA_ID ID_KONTRAK, 'TIME-CHARTER SEWA' TIPE_KONTRAK,
						   NO_KONTRAK NOMOR, B.NAMA LOKASI,
						   TO_CHAR (TANGGAL_AWAL, 'DD MON YYYY') AS TANGGAL_AWAL,
						   TO_CHAR (TANGGAL_AKHIR, 'DD MON YYYY') AS TANGGAL_AKHIR,
						   CASE
							  WHEN (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
							  AND A.TANGGAL_AKHIR > SYSDATE
								 THEN 'Warning'
							  WHEN A.TANGGAL_AKHIR <= SYSDATE
								 THEN 'Expired'
						   END STATUS
					  FROM PEL_OPERASIONAL.KAPAL_PEKERJAAN_SEWA A INNER JOIN PEL_OPERASIONAL.LOKASI B
						   ON A.LOKASI_ID = B.LOKASI_ID
					 WHERE NVL (A.STATUS_NOTIF, 1) = 1
					   AND (       (A.TANGGAL_AKHIR - INTERVAL '".$batas."' DAY) < SYSDATE
							   AND A.TANGGAL_AKHIR > SYSDATE
							OR A.TANGGAL_AKHIR <= SYSDATE
						   )
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TANGGAL_AKHIR ASC ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
									
  } 
?>