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

  class UangTransportBantuan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function UangTransportBantuan()
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

	function callTransportBantuan()
	{
        $str = "
				CALL PPI_GAJI.PROSES_HITUNG_UANG_TRANS() 
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
					A.PEGAWAI_ID, A.NAMA, A.NRP, A.DEPARTEMEN_ID, B.HARI_KERJA, PERIODE, B.MASUK_KERJA, B.JUMLAH
                FROM PPI_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_GAJI.UANG_TRANSPORT_BANTUAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."'
				INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
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
	
    function selectByParamsReport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = "
				SELECT 
				PEGAWAI_ID, A.NAMA, NRP, 
                   NPWP, A.JENIS_PEGAWAI_ID, PERIODE, 
                   HARI_KERJA, SUM(MASUK_KERJA) MASUK_KERJA, SUM(JUMLAH) JUMLAH, 
                   PROSENTASE_POTONGAN, SUM(BANTUAN_PPH) BANTUAN_PPH, SUM(TOTAL) TOTAL, 
                   SUM(POTONGAN_PPH) POTONGAN_PPH, SUM(DIBAYARKAN) DIBAYARKAN, KELAS, 
                   DEPARTEMEN, DEPARTEMEN_ID, 0 UANG_TRANSPORT, 
                   NO_REKENING, BANK_ID, BANK_NAMA, 
                   BANK_ALAMAT, BANK_KOTA, B.NAMA JENIS_PEGAWAI
				FROM PPI_GAJI.UANG_TRANSPORT_PENGANTAR_RPT A
                INNER JOIN PPI_SIMPEG.JENIS_PEGAWAI B ON A.JENIS_PEGAWAI_ID = B.JENIS_PEGAWAI_ID
                WHERE 1 = 1 AND PERIODE = '".$periode."'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY PEGAWAI_ID, A.NAMA, NRP, 
                   NPWP, A.JENIS_PEGAWAI_ID, PERIODE, 
                   HARI_KERJA, PROSENTASE_POTONGAN, KELAS, 
                   DEPARTEMEN, DEPARTEMEN_ID, 
                   NO_REKENING, BANK_ID, BANK_NAMA, 
                   BANK_ALAMAT, BANK_KOTA, B.NAMA ".$order;
		$this->query = $str;
//		echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsReportCSVHeader($statement="", $periode='',$limit=-1,$from=-1)
	{
		$str = "
				SELECT 
				TO_CHAR(sysdate,'dd/mm/yyyy hh24:mi:ss') TANGGAL_BUAT, 
				SUM(DIBAYARKAN) SUM_TRANSPORT, count(A.PEGAWAI_ID) TOTAL, SUM(substr(A.NO_REKENING, -4)) CEK_AKUN
				FROM PPI_GAJI.UANG_TRANSPORT_PENGANTAR_RPT A
                INNER JOIN PPI_SIMPEG.JENIS_PEGAWAI B ON A.JENIS_PEGAWAI_ID = B.JENIS_PEGAWAI_ID
                WHERE 1 = 1 AND PERIODE = '".$periode."' AND DIBAYARKAN > 0 "; 
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		//exit;
		return $this->selectLimit($str,$limit,$from); 
    }		

    function selectByParamsReportRekap($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = "
				SELECT 
					URUT, PERIODE, KELOMPOK, 
					   DEPARTEMEN_ID, JUMLAH, BANTUAN, 
					   TOTAL, POTONGAN, DIBAYARKAN
					FROM PPI_GAJI.REKAP_UANG_TRANSPORT_REPORT WHERE PERIODE = '".$periode."'			
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

		function replaceSpecialCharacter($strVariable="")
	{
		$strRestrict = array(",", "`", "~", "!", "@", "#", "$", "%", "^", "&", "*", "_", "{", "}", "<", ">", "[", "]", "=", "\\", ";", "'");
		$result = str_replace($strRestrict, " ", $strVariable);
		return $result;
	}
	
  } 
?>