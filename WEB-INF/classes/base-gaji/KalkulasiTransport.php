<? 
/* *******************************************************************************************************
MODUL NAME 			: PPI
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel DEPARTEMEN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class KalkulasiTransport extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KalkulasiTransport()
	{
      $this->Entity(); 
    }
    
	function callKalkulasi()
	{
        $str = "
				CALL PPI_GAJI.PROSES_KALKULASI_TRANSPORT('".$this->getField("PERIODE")."')
		"; 
				  
		$this->query = $str;
		// echo $str; exit;
        return $this->execQuery($str);
    }	

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
	
	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqId="")
	{
		$str = "
				SELECT 
					A.PERIODE, A.PEGAWAI_ID, A.JUMLAH_HADIR, 
				    A.TARIF, A.LAST_CREATE_USER, A.LAST_CREATE_DATE,B.NRP, B.NAMA NAMA_PEGAWAI, B.JABATAN, ( A.JUMLAH_HADIR* A.TARIF) as TOTAL
				FROM PPI_GAJI.KALKULASI_TRANSPORT A
				LEFT JOIN PPI_GAJI.PEGAWAI B ON A.PEGAWAI_ID=B.PEGAWAI_ID AND A.PERIODE = B.PERIODE
				 WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY PEGAWAI_ID ASC";
		$this->query = $str;
		// echo $str;exit();
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				PERIODE, PEGAWAI_ID, JUMLAH_HADIR, 
				   TARIF, LAST_CREATE_USER, LAST_CREATE_DATE, 
				   LAST_UPDATE_USER, LAST_UPDATE_DATE, B.NAMA, B.NRP, B.JABATAN
				FROM PPI_GAJI.KALKULASI_TRANSPORT A
				LEFT JOIN PPI_GAJI.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND A.PERIODE = B.PERIODE
				 WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
				FROM PPI_GAJI.KALKULASI_TRANSPORT A
				LEFT JOIN PPI_GAJI.PEGAWAI B ON A.PEGAWAI_ID=B.PEGAWAI_ID AND A.PERIODE = B.PERIODE
		        WHERE 1=1  ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		// echo $str;exit();
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
				FROM PPI_GAJI.KALKULASI_TRANSPORT A
				LEFT JOIN PPI_GAJI.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND A.PERIODE = B.PERIODE
		        WHERE 1=1 ".$statement; 
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