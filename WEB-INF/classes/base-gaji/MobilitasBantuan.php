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

  class MobilitasBantuan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function MobilitasBantuan()
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

	function callMobilitasBantuan()
	{
        $str = "
				CALL PPI_GAJI.PROSES_HITUNG_MOBILITAS() 
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
					A.PEGAWAI_ID, A.NAMA, A.NRP, A.DEPARTEMEN_ID, PERIODE, E.NAMA NAMA_BANK, A.REKENING_NO, B.JUMLAH, B.PROSENTASE_POTONGAN, B.JUMLAH_POTONGAN, B.DIBAYARKAN
                FROM PPI_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_GAJI.MOBILITAS_BANTUAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."'
				INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
				INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
				INNER JOIN PPI_SIMPEG.BANK E ON A.BANK_ID = E.BANK_ID
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
				INNER JOIN PPI_GAJI.MOBILITAS_BANTUAN B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."'
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
  } 
?>