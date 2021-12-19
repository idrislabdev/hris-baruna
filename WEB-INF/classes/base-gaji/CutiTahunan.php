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

  class CutiTahunan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function CutiTahunan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("CUTI_TAHUNAN_ID", $this->getNextId("CUTI_TAHUNAN_ID","PPI_GAJI.CUTI_TAHUNAN")); 		
		$str = "
				INSERT INTO PPI_GAJI.CUTI_TAHUNAN (
				   CUTI_TAHUNAN_ID, PEGAWAI_ID, JENIS_PEGAWAI_ID, 
				   PERIODE, TANGGAL) 
				VALUES (".$this->getField("CUTI_TAHUNAN_ID").", ".$this->getField("PEGAWAI_ID").", (SELECT JENIS_PEGAWAI_ID FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR X WHERE X.PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."'),
					'".$this->getField("PERIODE")."', ".$this->getField("TANGGAL").")"; 
				
		$this->id = $this->getField("CUTI_TAHUNAN_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function insertPegawai()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("CUTI_TAHUNAN_ID", $this->getNextId("CUTI_TAHUNAN_ID","PPI_GAJI.CUTI_TAHUNAN")); 		
		$str = "
				INSERT INTO PPI_GAJI.CUTI_TAHUNAN (
				   CUTI_TAHUNAN_ID, PEGAWAI_ID, JENIS_PEGAWAI_ID, 
				   PERIODE, TANGGAL, STATUS_BAYAR_MUTASI) 
				VALUES (".$this->getField("CUTI_TAHUNAN_ID").", ".$this->getField("PEGAWAI_ID").", (SELECT JENIS_PEGAWAI_ID FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR X WHERE X.PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."'),
					'".$this->getField("PERIODE")."', ".$this->getField("TANGGAL").", '".$this->getField("STATUS_BAYAR_MUTASI")."')"; 
				
		$this->id = $this->getField("CUTI_TAHUNAN_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
		
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_GAJI.GAJI_AWAL_BULAN SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")." AND BULANTAHUN = ".$this->getField("BULANTAHUN")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }	
	
	 function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "  
				UPDATE PPI_GAJI.CUTI_TAHUNAN
				SET    PEGAWAI_ID          = '".$this->getField("PEGAWAI_ID")."',
					   JENIS_PEGAWAI_ID    = (SELECT JENIS_PEGAWAI_ID FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR X WHERE X.PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."'),
					   TANGGAL             = ".$this->getField("TANGGAL")."
				WHERE CUTI_TAHUNAN_ID 	   = '".$this->getField("CUTI_TAHUNAN_ID")."' 
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }	

	 function updateTanggalApprove()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "  
				UPDATE PPI_GAJI.CUTI_TAHUNAN_DETIL
				SET    TANGGAL_APPROVE     = SYSDATE
				WHERE TANGGAL_APPROVE IS NULL AND JUMLAH IS NOT NULL 
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateCutiTahunanData($reqData, $noNotaDinas)
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "  
				UPDATE PPI_GAJI.CUTI_TAHUNAN_DETIL
				SET    NO_NOTA_DINAS		= '" . $noNotaDinas . "'
				WHERE TANGGAL_APPROVE IS NULL AND JUMLAH IS NOT NULL 
				AND CUTI_TAHUNAN_ID IN (" .$reqData . ")"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateCutiTahunanApprove($noNotaDinas)
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "  
				UPDATE PPI_GAJI.CUTI_TAHUNAN_DETIL
				SET    TANGGAL_APPROVE     = SYSDATE
				WHERE TANGGAL_APPROVE IS NULL AND JUMLAH IS NOT NULL 
				AND NO_NOTA_DINAS		= '" . $noNotaDinas . "' "; 
		$this->query = $str;
		return $this->execQuery($str);
    }


	function delete()
	{
        $str = "
				DELETE PPI_GAJI.CUTI_TAHUNAN
                WHERE 
                  CUTI_TAHUNAN_ID 	   = '".$this->getField("CUTI_TAHUNAN_ID")."' 
			"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }

	function deletePegawai()
	{
        $str = "
				DELETE PPI_GAJI.CUTI_TAHUNAN
                WHERE 
                  PEGAWAI_ID 	   = '".$this->getField("PEGAWAI_ID")."' AND STATUS_BAYAR_MUTASI IS NOT NULL
			"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
	
	function callCutiTahunan()
	{
        $str = "
				CALL PPI_GAJI.PROSES_HITUNG_CUTI_TAHUNAN() 
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


	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = "
				SELECT 
                    B.TANGGAL_APPROVE, B.CUTI_TAHUNAN_ID, A.PEGAWAI_ID, B.JENIS_PEGAWAI_ID, A.NAMA NAMA, A.NRP, A.DEPARTEMEN_ID, B.JUMLAH, PERIODE, (SELECT SUM(LAMA_CUTI) FROM PPI_GAJI.CUTI_TAHUNAN_DETIL X WHERE X.CUTI_TAHUNAN_ID = B.CUTI_TAHUNAN_ID AND STATUS_TUNDA = 0) LAMA_CUTI, B.TANGGAL, B.JUMLAH_POTONGAN, B.TANGGAL_AWAL, B.TANGGAL_AKHIR,
                    D.PANGKAT, E.NAMA JABATAN, E.KELAS, LAMA_CUTI || ' (' || REPLACE(PPI_GAJI.NOMINAL_TERBILANG(LAMA_CUTI), 'RUPIAH', '') || ')' LAMA_CUTI_HURUF, F.TANGGAL_CETAK, G.NAMA AS DEPARTEMEN
                FROM PPI_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_GAJI.CUTI_TAHUNAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."'
                INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_PANGKAT_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR E ON A.PEGAWAI_ID = E.PEGAWAI_ID
                LEFT JOIN PPI_GAJI.CUTI_TAHUNAN_TERAKHIR F ON B.CUTI_TAHUNAN_ID = F.CUTI_TAHUNAN_ID
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN G ON G.DEPARTEMEN_ID = A.DEPARTEMEN_ID
                WHERE 1 = 1
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

    function selectByParamsGaji($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = "
				SELECT 
                    G.TANGGAL_APPROVE, G.CUTI_TAHUNAN_ID, A.PEGAWAI_ID, B.JENIS_PEGAWAI_ID, A.NAMA, A.NRP, A.DEPARTEMEN_ID, G.JUMLAH, 
                    PERIODE, G.LAMA_CUTI, G.TANGGAL, G.JUMLAH_POTONGAN, B.TANGGAL_AWAL, B.TANGGAL_AKHIR,
                    D.PANGKAT, E.NAMA JABATAN, E.KELAS, G.TANGGAL_CETAK
                FROM PPI_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_GAJI.CUTI_TAHUNAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."' AND NOT NVL(B.STATUS_BAYAR_MUTASI, 'X') = 'F'
                INNER JOIN PPI_GAJI.CUTI_TAHUNAN_DETIL G ON G.CUTI_TAHUNAN_ID = B.CUTI_TAHUNAN_ID AND NOT NVL(G.JUMLAH, 1) = 0 AND G.STATUS_BAYAR_MUTASI IS NULL
                INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_PANGKAT_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR E ON A.PEGAWAI_ID = E.PEGAWAI_ID
                WHERE 1 = 1 AND G.TANGGAL_CETAK IS NOT NULL 
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
	
    function selectByParamsPegawai($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = "
				SELECT 
                    B.TANGGAL_APPROVE, B.CUTI_TAHUNAN_ID, STATUS_BAYAR_MUTASI, DECODE(STATUS_BAYAR_MUTASI, 'D', 'Sesuai Hari', 'Full') STATUS_BAYAR_MUTASI_KET, A.PEGAWAI_ID, B.JENIS_PEGAWAI_ID, A.NAMA, A.NRP, A.DEPARTEMEN_ID, B.JUMLAH, PERIODE, 
					(SELECT SUM(LAMA_CUTI) FROM PPI_GAJI.CUTI_TAHUNAN_DETIL X WHERE X.CUTI_TAHUNAN_ID = B.CUTI_TAHUNAN_ID AND X.TANGGAL IS NULL) LAMA_CUTI, 
					(SELECT SUM(LAMA_CUTI_TERBAYAR) FROM PPI_GAJI.CUTI_TAHUNAN_DETIL X WHERE X.CUTI_TAHUNAN_ID = B.CUTI_TAHUNAN_ID AND X.TANGGAL IS NULL) LAMA_CUTI_TERBAYAR,
					B.TANGGAL, B.JUMLAH_POTONGAN, B.TANGGAL_AWAL, B.TANGGAL_AKHIR,
                    D.PANGKAT, E.NAMA JABATAN, E.KELAS, LAMA_CUTI || ' (' || REPLACE(PPI_GAJI.NOMINAL_TERBILANG(LAMA_CUTI), 'RUPIAH', '') || ')' LAMA_CUTI_HURUF, F.TANGGAL_CETAK
                FROM PPI_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_GAJI.CUTI_TAHUNAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_PANGKAT_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR E ON A.PEGAWAI_ID = E.PEGAWAI_ID
                LEFT JOIN PPI_GAJI.CUTI_TAHUNAN_TERAKHIR F ON B.CUTI_TAHUNAN_ID = F.CUTI_TAHUNAN_ID
                WHERE 1 = 1
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
		
    function selectByParamsTanggalApprove($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT TANGGAL_APPROVE, nvl(NO_NOTA_DINAS, TO_CHAR(TANGGAL_APPROVE, 'DDMMYYYY')) NO_NOTA_DINAS, NVL (REPLACE (REPLACE(REPLACE(NO_NOTA_DINAS,' ',''), '&','dan'), ' & ', 'dan'),
                 TO_CHAR (TANGGAL_APPROVE, 'DDMMYYYY')) NO_NOTA_DINAS2, TO_CHAR(TANGGAL_APPROVE, 'DDMMYYYY') TANGGAL_APPROVE_ID
                FROM PPI_GAJI.CUTI_TAHUNAN_DETIL    
                WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY TANGGAL_APPROVE, NO_NOTA_DINAS ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsReport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				PEGAWAI_ID, NAMA, NRP, 
				   NPWP, JENIS_PEGAWAI_ID, PERIODE, 
				   HARI_KERJA, MASUK_KERJA, JUMLAH, 
				   PROSENTASE_POTONGAN, BANTUAN_PPH, TOTAL, 
				   POTONGAN_PPH, DIBAYARKAN, KELAS, 
				   DEPARTEMEN, DEPARTEMEN_ID, UANG_TRANSPORT, 
				   NO_REKENING, BANK_ID, BANK_NAMA, 
				   BANK_ALAMAT, BANK_KOTA
				FROM PPI_GAJI.UANG_TRANSPORT_PENGANTAR_RPT	
                WHERE 1 = 1 AND PERIODE = '".$periode."'
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
	
	
	 function selectByParamsCutiTunda($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = "
				SELECT PERIODE, CUTI_TAHUNAN_ID, A.PEGAWAI_ID, A.NRP, A.NAMA, PERMOHONAN, 
 					TUNDA, DILAKSANAKAN FROM PPI_GAJI.CUTI_TAHUNAN_TUNDA_MONITORING A
                WHERE 1 = 1 
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
	
	function selectByParamsCutiTundaDetail($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = "
				SELECT LAMA_CUTI, CASE WHEN(A.STATUS_TUNDA = 1) THEN 'Cuti Tunda' ELSE 'Cuti Normal' END TYPE, A.TANGGAL_NOTA_DINAS_TUNDA, A.NOTA_DINAS_TUNDA, 
                CASE WHEN(A.STATUS_TUNDA = 1) THEN to_char(A.KETERANGAN_TUNDA) ELSE 'Dilaksanakan dari tanggal ' || TO_CHAR(TANGGAL_AWAL, 'DD-MM-YYYY') || ' sampai ' || TO_CHAR(TANGGAL_AKHIR, 'DD-MM-YYYY') END KETERANGAN_TUNDA, 
                A.TANGGAL, ROWNUM AS NO 
                FROM PPI_GAJI.CUTI_TAHUNAN_DETIL A 
                WHERE 1 = 1 
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
				SELECT A.PEGAWAI_ID, A.NAMA, A.DEPARTEMEN_ID, BULANTAHUN, KELAS, PERIODE, STATUS_BAYAR, GAJI_JSON
                FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_GAJI.GAJI_AWAL_BULAN B 
                ON A.PEGAWAI_ID = B.PEGAWAI_ID
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY PEGAWAI_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="", $periode='')
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT
				FROM PPI_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_GAJI.CUTI_TAHUNAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."'
				INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_PANGKAT_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR E ON A.PEGAWAI_ID = E.PEGAWAI_ID
				LEFT JOIN PPI_GAJI.CUTI_TAHUNAN_TERAKHIR F ON B.CUTI_TAHUNAN_ID = F.CUTI_TAHUNAN_ID
                WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsGaji($paramsArray=array(), $statement="", $periode='')
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT
				FROM PPI_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_GAJI.CUTI_TAHUNAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."' AND NOT NVL(B.STATUS_BAYAR_MUTASI, 'X') = 'F'
                INNER JOIN PPI_GAJI.CUTI_TAHUNAN_DETIL G ON G.CUTI_TAHUNAN_ID = B.CUTI_TAHUNAN_ID AND NOT NVL(G.JUMLAH, 1) = 0 AND G.STATUS_BAYAR_MUTASI IS NULL
                INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_PANGKAT_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR E ON A.PEGAWAI_ID = E.PEGAWAI_ID
                WHERE 1 = 1 AND G.TANGGAL_CETAK IS NOT NULL  ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
	function getCountByParamsCutiTunda($paramsArray=array(), $statement="", $periode='')
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT
                FROM PPI_GAJI.CUTI_TAHUNAN_TUNDA_MONITORING A 
                WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }


    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI A WHERE 1 = 1 "; 
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

    function selectPegawaiBelumMengajukanCuti($periode='', $limit=-1,$from=-1, $paramsArray=array(), $statement='', $order='' )	{
    	$str = "
				SELECT '' AS TANGGAL_APPROVE, '' AS CUTI_TAHUNAN_ID, A.PEGAWAI_ID, B.JENIS_PEGAWAI_NAMA AS JENIS_PEGAWAI_ID, 
				A.NAMA NAMA, A.NRP, A.DEPARTEMEN_ID,  '' AS JUMLAH, '' AS PERIODE, '' AS LAMA_CUTI, '' AS TANGGAL,
				'' AS JUMLAH_POTONGAN, '' AS TANGGAL_AWAL, '' AS TANGGAL_AKHIR, '' AS PANGKAT, '' AS JABATAN,
				'' AS KELAS, '' AS LAMA_CUTI_HURUF, '' AS TANGGAL_CETAK, C.NAMA AS DEPARTEMEN 
				FROM PPI_SIMPEG.PEGAWAI A
				INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID 
				INNER JOIN PPI_SIMPEG.DEPARTEMEN C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID 
				WHERE NOT EXISTS 
				    (SELECT * FROM PPI_GAJI.CUTI_TAHUNAN 
				        WHERE PEGAWAI_ID = A.PEGAWAI_ID AND PERIODE = '". $periode ."')
				AND B.JENIS_PEGAWAI_ID IN (1,2,6,7) AND A.STATUS_PEGAWAI_ID = 1 
			"; 
/*
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		*/
		$str .= $statement . " " . $order;
		$this->query = $str;
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
    function getCountBelumAjukan($periode='', $paramsArray=array(), $statement='')
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT 
		FROM PPI_SIMPEG.PEGAWAI A
				INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID 
				WHERE NOT EXISTS 
				    (SELECT * FROM PPI_GAJI.CUTI_TAHUNAN 
				        WHERE PEGAWAI_ID = A.PEGAWAI_ID AND PERIODE = '". $periode ."')
				AND B.JENIS_PEGAWAI_ID IN (1,2,6,7)  AND A.STATUS_PEGAWAI_ID = 1 "; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '%$val%' ";
		}
		$str .= $statement;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
  
  function selectPegawaiBerhakCuti($periode='', $limit=-1,$from=-1, $paramsArray=array(), $statement='', $order='' )	{
    	$str = "
				SELECT '' AS TANGGAL_APPROVE, '' AS CUTI_TAHUNAN_ID, A.PEGAWAI_ID, B.JENIS_PEGAWAI_NAMA AS JENIS_PEGAWAI_ID, 
			    A.NAMA NAMA, A.NRP, A.DEPARTEMEN_ID,  '' AS JUMLAH, '' AS PERIODE, '' AS LAMA_CUTI, '' AS TANGGAL,
			    '' AS JUMLAH_POTONGAN, '' AS TANGGAL_AWAL, '' AS TANGGAL_AKHIR, '' AS PANGKAT, '' AS JABATAN,
			    '' AS KELAS, '' AS LAMA_CUTI_HURUF, '' AS TANGGAL_CETAK, C.NAMA AS DEPARTEMEN,
			    CASE WHEN B.JENIS_PEGAWAI_ID = 2 THEN ( D.TPP_PMS +  D.MERIT_PMS + D.TUNJANGAN_PERBANTUAN + D.TUNJANGAN_JABATAN) 
			    ELSE ( D.TPP_PMS +  D.MERIT_PMS  + D.TUNJANGAN_JABATAN) END AS UANG_CUTI, 
			    CASE WHEN B.JENIS_PEGAWAI_ID = 2 THEN ( D.TPP_PMS +  D.MERIT_PMS + D.TUNJANGAN_PERBANTUAN + D.TUNJANGAN_JABATAN) 
			    ELSE ( D.TPP_PMS +  D.MERIT_PMS  + D.TUNJANGAN_JABATAN) END AS UANG_CUTI_ANGKA, E.TMT_JENIS_PEGAWAI,
			    CASE WHEN B.JENIS_PEGAWAI_ID = 2 THEN CEIL(0.15 * ( D.TPP_PMS +  D.MERIT_PMS + D.TUNJANGAN_PERBANTUAN + D.TUNJANGAN_JABATAN)) 
			    ELSE CEIL (0.15 * ( D.TPP_PMS +  D.MERIT_PMS  + D.TUNJANGAN_JABATAN)) END AS PPH,
			    CASE WHEN B.JENIS_PEGAWAI_ID = 2 THEN CEIL(0.15 * ( D.TPP_PMS +  D.MERIT_PMS + D.TUNJANGAN_PERBANTUAN + D.TUNJANGAN_JABATAN)) 
			    ELSE CEIL (0.15 * ( D.TPP_PMS +  D.MERIT_PMS  + D.TUNJANGAN_JABATAN)) END AS PPH_ANGKA,
			    CASE WHEN A.DEPARTEMEN_ID LIKE '02%' THEN 'Langsung' ELSE 'Tidak Langsung' END AS TIPE_LANGSUNG
			    FROM PPI_SIMPEG.PEGAWAI A
			    INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID 
			    INNER JOIN PPI_SIMPEG.DEPARTEMEN C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID 
			   	LEFT JOIN PPI_GAJI.GAJI_AWAL_BULAN_REPORT D ON A.PEGAWAI_ID = D.PEGAWAI_ID AND D.PERIODE =  PPI_SIMPEG.KURANGI_BULAN(TO_NUMBER(TO_CHAR(SYSDATE , 'MM')), ". $periode .")
			   	LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI E ON A.PEGAWAI_ID = E.PEGAWAI_ID
			    WHERE NOT EXISTS 
			        (SELECT * FROM PPI_GAJI.CUTI_TAHUNAN 
			            WHERE PEGAWAI_ID = A.PEGAWAI_ID AND PERIODE = '". $periode ."')
			  AND B.JENIS_PEGAWAI_ID IN (2,6) AND A.STATUS_PEGAWAI_ID = 1 ";
		$str .= $statement;
		
		$str .= " UNION ALL 
			  
			  SELECT '' AS TANGGAL_APPROVE, '' AS CUTI_TAHUNAN_ID, A.PEGAWAI_ID, B.JENIS_PEGAWAI_NAMA AS JENIS_PEGAWAI_ID, 
			    A.NAMA NAMA, A.NRP, A.DEPARTEMEN_ID,  '' AS JUMLAH, '' AS PERIODE, '' AS LAMA_CUTI, '' AS TANGGAL,
			    '' AS JUMLAH_POTONGAN, '' AS TANGGAL_AWAL, '' AS TANGGAL_AKHIR, '' AS PANGKAT, '' AS JABATAN,
			    '' AS KELAS, '' AS LAMA_CUTI_HURUF, '' AS TANGGAL_CETAK, C.NAMA AS DEPARTEMEN,
			    ( D.TPP_PMS +  D.MERIT_PMS  + D.TUNJANGAN_JABATAN) AS UANG_CUTI, 
			    ( D.TPP_PMS +  D.MERIT_PMS  + D.TUNJANGAN_JABATAN) AS UANG_CUTI_ANGKA, E.TMT_JENIS_PEGAWAI,
			    CEIL (( D.TPP_PMS +  D.MERIT_PMS  + D.TUNJANGAN_JABATAN) * 0.15) AS PPH,
			    CEIL (( D.TPP_PMS +  D.MERIT_PMS  + D.TUNJANGAN_JABATAN) * 0.15) AS PPH_ANGKA,
			    CASE WHEN A.DEPARTEMEN_ID LIKE '02%' THEN 'Langsung' ELSE 'Tidak Langsung' END AS TIPE_LANGSUNG
			    FROM PPI_SIMPEG.PEGAWAI A
			    INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID 
			    INNER JOIN PPI_SIMPEG.DEPARTEMEN C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID 
			   LEFT JOIN PPI_GAJI.GAJI_AWAL_BULAN_REPORT D ON A.PEGAWAI_ID = D.PEGAWAI_ID AND D.PERIODE =  PPI_SIMPEG.KURANGI_BULAN(TO_NUMBER(TO_CHAR(SYSDATE , 'MM')), ". $periode .")
			    INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI E ON A.PEGAWAI_ID = E.PEGAWAI_ID AND E.JENIS_PEGAWAI_ID = 1 AND TO_CHAR(E.TMT_JENIS_PEGAWAI, 'YYYY') < TO_CHAR(SYSDATE, 'YYYY')
			    WHERE NOT EXISTS 
			        (SELECT * FROM PPI_GAJI.CUTI_TAHUNAN 
			            WHERE PEGAWAI_ID = A.PEGAWAI_ID AND PERIODE = '". $periode ."')
			  AND B.JENIS_PEGAWAI_ID =1  AND A.STATUS_PEGAWAI_ID = 1 
			"; 
/*
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		*/
		$str .= $statement;
		$this->query = $str;
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
 }
?>