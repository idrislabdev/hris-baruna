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

  class Integrasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Integrasi()
	{
      $this->Entity(); 
    }
	
    function selectByParamsAgama($statement="")
	{
		$str = "
				SELECT A.AGAMA_ID, NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KELOMPOK = 'D' THEN JUMLAH END), 0) JUMLAH_PS,
                COALESCE(SUM(CASE WHEN KELOMPOK = 'K' THEN JUMLAH END), 0) JUMLAH_OPS
                FROM PPI_SIMPEG.AGAMA A 
                LEFT JOIN (
                                    SELECT  AGAMA_ID, KELOMPOK, COUNT(1) JUMLAH
                                    FROM PPI_SIMPEG.PEGAWAI A INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                                    WHERE 1 = 1  AND STATUS_PEGAWAI_ID IN (1,5) AND MAGANG_TIPE IS NULL ".$statement."
                                    GROUP BY KELOMPOK, A.AGAMA_ID
                                ) B ON A.AGAMA_ID = B.AGAMA_ID
                WHERE A.AGAMA_ID IS NOT NULL
                GROUP BY A.AGAMA_ID, NAMA        	
				"; 
		
		
		$str .= " ORDER BY A.AGAMA_ID ";
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsUnitKerja($statement="")
	{
		$str = "
				SELECT A.DEPARTEMEN_ID, A.NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KELOMPOK = 'D' THEN JUMLAH END), 0) JUMLAH_PS,
								COALESCE(SUM(CASE WHEN KELOMPOK = 'K' THEN JUMLAH END), 0) JUMLAH_OPS
				FROM PPI_SIMPEG.DEPARTEMEN A
                INNER JOIN 
				(								
                SELECT SUBSTR(A.DEPARTEMEN_ID, 0, 2) DEPARTEMEN_ID, A.NAMA, C.KELOMPOK, COUNT(1) JUMLAH 
				FROM PPI_SIMPEG.DEPARTEMEN A 
				INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
				INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON B.PEGAWAI_ID = C.PEGAWAI_ID
				INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR E ON B.PEGAWAI_ID = E.PEGAWAI_ID
				WHERE 1 = 1 AND STATUS_PEGAWAI_ID IN (1,5)  AND NOT NVL(E.JENIS_PEGAWAI_ID, 1) = 8 ".$statement."
				GROUP BY SUBSTR(A.DEPARTEMEN_ID, 0, 2), A.NAMA, C.KELOMPOK
				ORDER BY SUBSTR(A.DEPARTEMEN_ID, 0, 2)                
				) B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID 
				GROUP BY  A.DEPARTEMEN_ID, A.NAMA        
                ORDER BY A.DEPARTEMEN_ID
				"; 
		
		
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsJenisPekerjaan($statement="")
	{
		$str = "
				SELECT A.JABATAN_ID, A.NAMA, COUNT(1) TOTAL FROM PPI_SIMPEG.JABATAN A INNER JOIN
				PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.JABATAN_ID = B.JABATAN_ID INNER JOIN 
				PPI_SIMPEG.PEGAWAI C ON B.PEGAWAI_ID = C.PEGAWAI_ID AND STATUS_PEGAWAI_ID = 1 
				WHERE A.KELOMPOK = 'O' ".$statement."
				GROUP BY A.JABATAN_ID, A.NAMA
				ORDER BY A.KATEGORI, JABATAN_ID
				"; 
		
		
		$str .= "  ";
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

	function getCountByParamsJenisPekerjaan($statement="")
	{
		$str = "SELECT SUM(1) JUMLAH FROM PPI_SIMPEG.JABATAN A INNER JOIN
				PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.JABATAN_ID = B.JABATAN_ID INNER JOIN
				PPI_SIMPEG.PEGAWAI C ON B.PEGAWAI_ID = C.PEGAWAI_ID AND STATUS_PEGAWAI_ID = 1
				WHERE A.KELOMPOK = 'O' ".$statement;
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("JUMLAH"); 
		else 
			return 0; 
    }
			
    function selectByParamsKelamin($statement)
	{
		$str = "SELECT A.JENIS_KELAMIN IDKETERANGAN, CASE WHEN A.JENIS_KELAMIN = 'P' THEN 'Perempuan' WHEN A.JENIS_KELAMIN = 'L' THEN 'Laki-laki' ELSE ' ' END NAMA, 
				COALESCE(COUNT(1), 0) TOTAL, COALESCE(COUNT(CASE WHEN KELOMPOK = 'D' THEN 1 END), 0) JUMLAH_PS,
				COALESCE(COUNT(CASE WHEN KELOMPOK = 'K' THEN 1 END), 0) JUMLAH_OPS
									FROM PPI_SIMPEG.PEGAWAI A INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
									WHERE 1 = 1 AND STATUS_PEGAWAI_ID IN (1,5) AND MAGANG_TIPE IS NULL ".$statement."
									GROUP BY A.JENIS_KELAMIN 
				"; 
		
		
		$str .= " ORDER BY A.JENIS_KELAMIN ";
		$this->query = $str;
		
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsPendidikan($statement)
	{
		$str = "SELECT   NAMA, COALESCE (SUM (JUMLAH), 0) TOTAL,
                   COALESCE (SUM (CASE
                                     WHEN KELOMPOK = 'D'
                                        THEN JUMLAH
                                  END),
                             0
                            ) JUMLAH_PS,
                   COALESCE (SUM (CASE
                                     WHEN KELOMPOK = 'K'
                                        THEN JUMLAH
                                  END),
                             0
                            ) JUMLAH_OPS, A.KODE
					  FROM PPI_SIMPEG.PENDIDIKAN A
						   LEFT JOIN
						   (                                                        
						   SELECT   CASE WHEN D.KODE IS NULL THEN '00000' ELSE SUBSTR(D.KODE, 0, 2)  || '000' END KODE, C.KELOMPOK, COUNT (1) JUMLAH
								FROM PPI_SIMPEG.PEGAWAI A
									 LEFT JOIN
									 (SELECT PEGAWAI_ID, PENDIDIKAN_ID
										FROM PPI_SIMPEG.PEGAWAI_PENDIDIKAN_TERAKHIR) B
									 ON A.PEGAWAI_ID = B.PEGAWAI_ID
									 INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C
									 ON A.PEGAWAI_ID = C.PEGAWAI_ID
									 LEFT JOIN PPI_SIMPEG.PENDIDIKAN D
									 ON B.PENDIDIKAN_ID = D.PENDIDIKAN_ID
							   WHERE STATUS_PEGAWAI_ID IN (1, 5) AND MAGANG_TIPE IS NULL ".$statement."
							GROUP BY D.KODE, C.KELOMPOK                                                            
							) B
						   ON A.KODE = B.KODE
						   WHERE A.KODE LIKE '%000'
				  GROUP BY A.PENDIDIKAN_ID, NAMA, A.KODE                  
				"; 
		
		
		$str .= " ORDER BY KODE ASC ";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsUsia($statement)
	{
		$str = "
			SELECT '30' IDKETERANGAN, '<= 30' NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KELOMPOK = 'D' THEN JUMLAH END), 0) JUMLAH_PS,
				COALESCE(SUM(CASE WHEN KELOMPOK = 'K' THEN JUMLAH END), 0) JUMLAH_OPS,
				COALESCE(SUM(CASE WHEN COALESCE(KELOMPOK, '') = '' THEN JUMLAH END), 0) JUMLAH_INTERNAL
							FROM (
								SELECT KELOMPOK, COUNT(A.PEGAWAI_ID) JUMLAH
								FROM PPI_SIMPEG.PEGAWAI  A, (
									SELECT X.PEGAWAI_ID, PPI_SIMPEG.AMBIL_MASA_KERJA(TANGGAL_LAHIR, CURRENT_DATE) AS USIA, KELOMPOK
										FROM PPI_SIMPEG.PEGAWAI  X INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR Y ON X.PEGAWAI_ID = Y.PEGAWAI_ID
									) B
								WHERE STATUS_PEGAWAI_ID IN (1,5) AND A.PEGAWAI_ID = B.PEGAWAI_ID AND B.USIA < 31 AND MAGANG_TIPE IS NULL ".$statement."
								GROUP BY KELOMPOK
							) Y   
			UNION ALL				
			SELECT '3135' IDKETERANGAN, '31 - 35' NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KELOMPOK = 'D' THEN JUMLAH END), 0) JUMLAH_PS,
				COALESCE(SUM(CASE WHEN KELOMPOK = 'K' THEN JUMLAH END), 0) JUMLAH_OPS,
				COALESCE(SUM(CASE WHEN COALESCE(KELOMPOK, '') = '' THEN JUMLAH END), 0) JUMLAH_INTERNAL
							FROM (
								SELECT KELOMPOK, COUNT(A.PEGAWAI_ID) JUMLAH
								FROM PPI_SIMPEG.PEGAWAI  A, (
									SELECT X.PEGAWAI_ID, PPI_SIMPEG.AMBIL_MASA_KERJA(TANGGAL_LAHIR, CURRENT_DATE) AS USIA, KELOMPOK
										FROM PPI_SIMPEG.PEGAWAI  X INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR Y ON X.PEGAWAI_ID = Y.PEGAWAI_ID
                                    ) B
                                WHERE STATUS_PEGAWAI_ID IN (1,5) AND A.PEGAWAI_ID = B.PEGAWAI_ID AND B.USIA >= 31 AND B.USIA < 36 AND MAGANG_TIPE IS NULL ".$statement."
                                GROUP BY KELOMPOK
                            ) Y     
            UNION ALL                
            SELECT '3640' IDKETERANGAN, '36 - 40' NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KELOMPOK = 'D' THEN JUMLAH END), 0) JUMLAH_PS,
                COALESCE(SUM(CASE WHEN KELOMPOK = 'K' THEN JUMLAH END), 0) JUMLAH_OPS,
                COALESCE(SUM(CASE WHEN COALESCE(KELOMPOK, '') = '' THEN JUMLAH END), 0) JUMLAH_INTERNAL
                            FROM (
                                SELECT KELOMPOK, COUNT(A.PEGAWAI_ID) JUMLAH
                                FROM PPI_SIMPEG.PEGAWAI  A, (
                                    SELECT X.PEGAWAI_ID, PPI_SIMPEG.AMBIL_MASA_KERJA(TANGGAL_LAHIR, CURRENT_DATE) AS USIA, KELOMPOK
                                        FROM PPI_SIMPEG.PEGAWAI  X INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR Y ON X.PEGAWAI_ID = Y.PEGAWAI_ID
                                    ) B
                                WHERE STATUS_PEGAWAI_ID IN (1,5) AND A.PEGAWAI_ID = B.PEGAWAI_ID AND B.USIA >= 36 AND B.USIA < 41 AND MAGANG_TIPE IS NULL ".$statement."
                                GROUP BY KELOMPOK
                            ) Y   
            UNION ALL                
            SELECT '4145' IDKETERANGAN, '41 - 45' NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KELOMPOK = 'D' THEN JUMLAH END), 0) JUMLAH_PS,
                COALESCE(SUM(CASE WHEN KELOMPOK = 'K' THEN JUMLAH END), 0) JUMLAH_OPS,
                COALESCE(SUM(CASE WHEN COALESCE(KELOMPOK, '') = '' THEN JUMLAH END), 0) JUMLAH_INTERNAL
                            FROM (
                                SELECT KELOMPOK, COUNT(A.PEGAWAI_ID) JUMLAH
                                FROM PPI_SIMPEG.PEGAWAI  A, (
                                    SELECT X.PEGAWAI_ID, PPI_SIMPEG.AMBIL_MASA_KERJA(TANGGAL_LAHIR, CURRENT_DATE) AS USIA, KELOMPOK
                                        FROM PPI_SIMPEG.PEGAWAI  X INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR Y ON X.PEGAWAI_ID = Y.PEGAWAI_ID
                                    ) B
                                WHERE STATUS_PEGAWAI_ID IN (1,5) AND A.PEGAWAI_ID = B.PEGAWAI_ID AND B.USIA >= 41 AND B.USIA < 46 AND MAGANG_TIPE IS NULL ".$statement."
                                GROUP BY KELOMPOK
                            ) Y    
            UNION ALL                
            SELECT '4650' IDKETERANGAN, '46 - 50' NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KELOMPOK = 'D' THEN JUMLAH END), 0) JUMLAH_PS,
                COALESCE(SUM(CASE WHEN KELOMPOK = 'K' THEN JUMLAH END), 0) JUMLAH_OPS,
                COALESCE(SUM(CASE WHEN COALESCE(KELOMPOK, '') = '' THEN JUMLAH END), 0) JUMLAH_INTERNAL
                            FROM (
                                SELECT KELOMPOK, COUNT(A.PEGAWAI_ID) JUMLAH
                                FROM PPI_SIMPEG.PEGAWAI  A, (
                                    SELECT X.PEGAWAI_ID, PPI_SIMPEG.AMBIL_MASA_KERJA(TANGGAL_LAHIR, CURRENT_DATE) AS USIA, KELOMPOK
                                        FROM PPI_SIMPEG.PEGAWAI  X INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR Y ON X.PEGAWAI_ID = Y.PEGAWAI_ID
                                    ) B
                                WHERE STATUS_PEGAWAI_ID IN (1,5) AND A.PEGAWAI_ID = B.PEGAWAI_ID AND B.USIA >= 46 AND B.USIA <= 50 AND MAGANG_TIPE IS NULL ".$statement."
                                GROUP BY KELOMPOK
                            ) Y     
            UNION ALL        
            SELECT '50' IDKETERANGAN, '> 50' NAMA, COALESCE(SUM(JUMLAH), 0) TOTAL, COALESCE(SUM(CASE WHEN KELOMPOK = 'D' THEN JUMLAH END), 0) JUMLAH_PS,
                COALESCE(SUM(CASE WHEN KELOMPOK = 'K' THEN JUMLAH END), 0) JUMLAH_OPS,
                COALESCE(SUM(CASE WHEN COALESCE(KELOMPOK, '') = '' THEN JUMLAH END), 0) JUMLAH_INTERNAL
                            FROM (
                                SELECT KELOMPOK, COUNT(A.PEGAWAI_ID) JUMLAH
                                FROM PPI_SIMPEG.PEGAWAI  A, (
                                    SELECT X.PEGAWAI_ID, PPI_SIMPEG.AMBIL_MASA_KERJA(TANGGAL_LAHIR, CURRENT_DATE) AS USIA, KELOMPOK
                                        FROM PPI_SIMPEG.PEGAWAI  X INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR Y ON X.PEGAWAI_ID = Y.PEGAWAI_ID
                                    ) B
                                WHERE STATUS_PEGAWAI_ID IN (1,5) AND A.PEGAWAI_ID = B.PEGAWAI_ID AND B.USIA > 50 AND MAGANG_TIPE IS NULL ".$statement."
                                GROUP BY KELOMPOK
                            ) Y      	   
				"; 
		
		
		$str .= "  ";
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsJenisPegawai($statement)
	{
		$str = "SELECT A.JENIS_PEGAWAI_ID, NAMA, COALESCE(JUMLAH, 0) JUMLAH, COALESCE(JUMLAH, 0) / 100 JUMLAH_PER_100
				FROM PPI_SIMPEG.JENIS_PEGAWAI  A 
				LEFT JOIN (
									SELECT  B.JENIS_PEGAWAI_ID, COUNT(1) JUMLAH
									FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN (SELECT PEGAWAI_ID, JENIS_PEGAWAI_ID, TMT_JENIS_PEGAWAI FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR) B
									ON A.PEGAWAI_ID = B.PEGAWAI_ID WHERE STATUS_PEGAWAI_ID IN (1,5) ".$statement."
									GROUP BY B.JENIS_PEGAWAI_ID
								) B ON A.JENIS_PEGAWAI_ID = B.JENIS_PEGAWAI_ID
				WHERE A.JENIS_PEGAWAI_ID IS NOT NULL AND A.NAMA IS NOT NULL   
				"; 
		
		
		$str .= " ORDER BY A.JENIS_PEGAWAI_ID ";
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }
		
  } 
?>