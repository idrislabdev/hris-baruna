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
                    B.TANGGAL_APPROVE, B.CUTI_TAHUNAN_ID, A.PEGAWAI_ID, B.JENIS_PEGAWAI_ID, A.NAMA, A.NRP, A.DEPARTEMEN_ID, B.JUMLAH, PERIODE, (SELECT SUM(LAMA_CUTI) FROM PPI_GAJI.CUTI_TAHUNAN_DETIL X WHERE X.CUTI_TAHUNAN_ID = B.CUTI_TAHUNAN_ID AND STATUS_TUNDA = 0) LAMA_CUTI, B.TANGGAL, B.JUMLAH_POTONGAN, B.TANGGAL_AWAL, B.TANGGAL_AKHIR,
                    D.PANGKAT, E.NAMA JABATAN, E.KELAS, LAMA_CUTI || ' (' || REPLACE(PPI_GAJI.NOMINAL_TERBILANG(LAMA_CUTI), 'RUPIAH', '') || ')' LAMA_CUTI_HURUF, F.TANGGAL_CETAK
                FROM PPI_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_GAJI.CUTI_TAHUNAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."'
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
                    B.TANGGAL_APPROVE, B.CUTI_TAHUNAN_ID, STATUS_BAYAR_MUTASI, DECODE(STATUS_BAYAR_MUTASI, 'D', 'Sesuai Hari', 'Full') STATUS_BAYAR_MUTASI_KET, A.PEGAWAI_ID, B.JENIS_PEGAWAI_ID, A.NAMA, A.NRP, A.DEPARTEMEN_ID, B.JUMLAH, PERIODE, (SELECT SUM(LAMA_CUTI) FROM PPI_GAJI.CUTI_TAHUNAN_DETIL X WHERE X.CUTI_TAHUNAN_ID = B.CUTI_TAHUNAN_ID AND X.TANGGAL IS NULL) LAMA_CUTI, B.TANGGAL, B.JUMLAH_POTONGAN, B.TANGGAL_AWAL, B.TANGGAL_AKHIR,
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
				SELECT TANGGAL_APPROVE, TO_CHAR(TANGGAL_APPROVE, 'DDMMYYYY') TANGGAL_APPROVE_ID
				FROM PPI_GAJI.CUTI_TAHUNAN_DETIL	
                WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY TANGGAL_APPROVE ".$order;
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
                INNER JOIN PPI_GAJI.CUTI_TAHUNAN_DETIL G ON G.CUTI_TAHUNAN_ID = B.CUTI_TAHUNAN_ID AND G.STATUS_BAYAR_MUTASI IS NULL
                INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_PANGKAT_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR E ON A.PEGAWAI_ID = E.PEGAWAI_ID
                WHERE 1 = 1 AND G.TANGGAL_CETAK IS NOT NULL ".$statement; 
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
  } 
?>