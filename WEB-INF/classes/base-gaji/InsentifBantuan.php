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

  class InsentifBantuan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function InsentifBantuan()
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

	function callInsentifBantuan()
	{
        $str = "
				CALL PPI_GAJI.PROSES_HITUNG_INSENTIF() 
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
					A.PEGAWAI_ID, A.NAMA, A.NRP, A.DEPARTEMEN_ID, PERIODE, B.JUMLAH, B.PROSENTASE_POTONGAN, B.JUMLAH_POTONGAN, (B.JUMLAH - B.JUMLAH_POTONGAN) JUMLAH_BERSIH, B.DIBAYARKAN,
					B.PROSENTASE_PPH, B.JUMLAH_PPH
                FROM PPI_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_GAJI.INSENTIF_BANTUAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."'
				INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
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
	
    function selectByParamsDepartemen($jenis_pegawai_id="", $periode="")
	{
		$str = "
                SELECT 
                DEPARTEMEN, DEPARTEMEN_ID
                FROM PPI_GAJI.INSENTIF_REPORT
                WHERE NAMA IS NOT NULL AND JENIS_PEGAWAI_ID = '".$jenis_pegawai_id."' AND PERIODE = '".$periode."'
                GROUP BY DEPARTEMEN_ID, DEPARTEMEN
			"; 
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,-1, -1); 
    }		
	
    /*function selectByParamsReport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = "
				SELECT 
				NAMA, DEPARTEMEN, DEPARTEMEN_ID, 
				   NPWP, JABATAN, KELAS, 
				   JUMLAH, JUMLAH_POTONGAN, JUMLAH_PPH, DIBAYARKAN, 
				   PERIODE, JENIS_PEGAWAI_ID
				FROM PPI_GAJI.INSENTIF_REPORT
				WHERE NAMA IS NOT NULL AND PERIODE = '".$periode."'			
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }*/	
	
    function selectByParamsReport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = "
				SELECT 
				NRP, NAMA, DEPARTEMEN, DEPARTEMEN_ID, 
				   NPWP, JABATAN, KELAS, NO_REKENING, BANK_NAMA,
				   JUMLAH, JUMLAH_POTONGAN, JUMLAH_PPH, DIBAYARKAN, 
				   PERIODE, JENIS_PEGAWAI_ID, JENIS_PEGAWAI
				FROM PPI_GAJI.INSENTIF_REPORT
				WHERE NAMA IS NOT NULL AND PERIODE = '".$periode."'			
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
	
	function selectByParamsReportCSVHeader($statement="", $periode='')
	{
		$str = "
				SELECT TO_CHAR(sysdate,'dd/mm/yyyy hh24:mi:ss') TANGGAL_BUAT, 
				COUNT(DIBAYARKAN) TOTAL, SUM(DIBAYARKAN) SUM_INSENTIF, SUM(substr(A.REKENING_NO, -4)) CEK_AKUN
				FROM PPI_GAJI.INSENTIF_REPORT
				WHERE NAMA IS NOT NULL AND DIBAYARKAN > 0 AND PERIODE = '".$periode."'"; 
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,-1,-1); 
    }	
	
    function selectByParamsReportRekap($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = "
				SELECT 
				URUT, PERIODE, KELOMPOK, 
				   DEPARTEMEN_ID, DEPARTEMEN_URUT, JUMLAH, 
				   POTONGAN, TOTAL, POTONGAN_PPH, 
				   DIBAYARKAN
				FROM PPI_GAJI.REKAP_INSENTIF_REPORT
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
				INNER JOIN PPI_GAJI.INSENTIF_BANTUAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."'
				INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                WHERE 1 = 1 ".$statement; 
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