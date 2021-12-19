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

  class TunjanganHariRaya extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TunjanganHariRaya()
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

	function callTunjanganHariRaya($periode="")
	{
        $str = "
				CALL PPI_GAJI.PROSES_HITUNG_THR_V2('".$periode."') 
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
					A.PEGAWAI_ID, A.NAMA, A.NRP, A.DEPARTEMEN_ID, B.PROSENTASE_POTONGAN*100 PROSENTASE_POTONGAN, B.JUMLAH, B.JENIS_PEGAWAI_ID, HADIR, JUMLAH_POTONGAN, B.JUMLAH + B.JUMLAH_POTONGAN JUMLAH_TOTAL, MASUK_KERJA, C.NAMA JENIS_PEGAWAI
                FROM PPI_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_GAJI.TUNJANGAN_HARI_RAYA B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."'
                INNER JOIN PPI_SIMPEG.JENIS_PEGAWAI C ON B.JENIS_PEGAWAI_ID = C.JENIS_PEGAWAI_ID
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
	
	   function selectByParamsReportRekap($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = "
				SELECT 
						URUT, PERIODE, KELOMPOK, DEPARTEMEN_ID, 
						DEPARTEMEN_URUT, JUMLAH, BANTUAN_PPH, 
            			TOTAL, POTONGAN_PPH, DIBAYARKAN
    			FROM PPI_GAJI.REKAP_THR_REPORT
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
                    A.PEGAWAI_ID, A.NAMA, A.NRP, A.DEPARTEMEN_ID, A.REKENING_NO, C.NAMA AS BANK, B.JUMLAH, B.JENIS_PEGAWAI_ID, HADIR, JUMLAH_POTONGAN, B.JUMLAH + B.JUMLAH_POTONGAN JUMLAH_TOTAL, MASUK_KERJA
                FROM PPI_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_GAJI.TUNJANGAN_HARI_RAYA B ON A.PEGAWAI_ID = B.PEGAWAI_ID
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
				INNER JOIN PPI_GAJI.TUNJANGAN_HARI_RAYA B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."'
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