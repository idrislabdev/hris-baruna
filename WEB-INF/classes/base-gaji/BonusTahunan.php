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

  class BonusTahunan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function BonusTahunan()
	{
      $this->Entity(); 
    }
	

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.GAJI_AWAL_BULAN
			   SET 
			   		DEPARTEMEN_ID  	= '".$this->getField("DEPARTEMEN_ID")."',
				   	BULANTAHUN		= '".$this->getField("BULANTAHUN")."',
				   	KELAS			= '".$this->getField("KELAS")."',
				   	PERIODE			= '".$this->getField("PERIODE")."',
				   	STATUS_BAYAR	= '".$this->getField("STATUS_BAYAR")."',
					GAJI_JSON		= '".$this->getField("GAJI_JSON")."'
			   WHERE PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")."
				"; 
				$this->query = $str;
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

	function delete()
	{
        $str = "
				DELETE FROM PPI_GAJI.GAJI_AWAL_BULAN
                WHERE 
                  PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")."
			"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callBonusTahunan()
	{
        $str = "
				CALL PPI_GAJI.PROSES_HITUNG_BONUS_TAHUNAN() 
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
					A.PEGAWAI_ID, A.NAMA, A.NRP, A.DEPARTEMEN_ID, B.JUMLAH, B.JENIS_PEGAWAI_ID, JUMLAH_POTONGAN, B.JUMLAH + B.JUMLAH_POTONGAN JUMLAH_TOTAL, PROSENTASE_POTONGAN
                FROM PPI_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_GAJI.BONUS_TAHUNAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."'
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
	
    function selectByParamsNew($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
					ROWNUM AS NO, NVL(A.NAMA, B.NAMA) NAMA, B.NRP, C.KELAS, F.NAMA JENIS_PEGAWAI, A.PEGAWAI_ID, A.NILAI_PI, 
					A.NILAI_SKI, A.NILAI_TOTAL, A.NILAI_KATEGORI, A.JUMLAH_BONUS, A.PPH_PERSEN, 
					A.PPH_KALI, A.PPH_NILAI, A.PERIODE , B.NPWP, NVL(A.REKENING_BANK, G.NAMA) BANK, NVL(A.REKENING_NO, B.REKENING_NO) REKENING_NO, NVL(NVL(A.REKENING_NAMA, B.REKENING_NAMA), A.NAMA) REKENING_NAMA,
					E.NAMA DEPARTEMEN , (A.JUMLAH_BONUS - A.PPH_NILAI) JUMLAH_DIBAYAR
                FROM PPI_GAJI.BONUS_NEW A 
                LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID 
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID 
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID 
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN E ON SUBSTR(B.DEPARTEMEN_ID,0,2) = E.DEPARTEMEN_ID 
                LEFT JOIN PPI_SIMPEG.JENIS_PEGAWAI F ON A.JENIS_PEGAWAI = F.JENIS_PEGAWAI_ID 
                LEFT JOIN PPI_SIMPEG.BANK G ON B.BANK_ID = G.BANK_ID
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
	
    function selectByParamsReport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
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
	
	function selectByParamsDaftarPengantarBankReport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
		$str = "
				SELECT 
                    A.PEGAWAI_ID, A.NAMA, A.NRP, A.DEPARTEMEN_ID, A.REKENING_NO, C.NAMA AS BANK, B.JUMLAH, B.JENIS_PEGAWAI_ID, JUMLAH_POTONGAN, B.JUMLAH + B.JUMLAH_POTONGAN JUMLAH_TOTAL
                FROM PPI_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_GAJI.BONUS_TAHUNAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                INNER JOIN PPI_SIMPEG.BANK C ON C.BANK_ID=A.BANK_ID
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
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 

    function getCountByParams($paramsArray=array(), $statement="", $periode='')
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT
				FROM PPI_SIMPEG.PEGAWAI A 
				INNER JOIN PPI_GAJI.UANG_TRANSPORT_BANTUAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."'
				INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                WHERE (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) ".$statement; 
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

    function getCountByParamsNew($paramsArray=array(), $statement="" )
	{
		$str = "SELECT COUNT(*) AS ROWCOUNT
				FROM PPI_GAJI.BONUS_NEW A 
                LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID 
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID 
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID 
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN E ON SUBSTR(C.DEPARTEMEN_ID,0,2) = E.DEPARTEMEN_ID 
                LEFT JOIN PPI_SIMPEG.JENIS_PEGAWAI F ON A.JENIS_PEGAWAI = F.JENIS_PEGAWAI_ID  
                WHERE 1 = 1  ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->query = $str;
		$this->select($str); 
		//echo $str; exit;
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