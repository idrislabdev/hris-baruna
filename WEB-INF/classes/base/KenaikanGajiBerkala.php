<? 
/* *******************************************************************************************************
MODUL NAME 			: PEL
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel AGAMA.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class KenaikanGajiBerkala extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KenaikanGajiBerkala()
	{
      $this->Entity(); 
    }
	
	function callProsesKGB()
	{
        $str = "
				CALL PPI_SIMPEG.PROSES_KGB('".$this->getField("PERIODE")."')
		"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);	
	}
	
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				A.PEGAWAI_ID, A.NRP, A.NAMA ,PERIODE_PROSES, KELAS, 
				   PERIODE_LAMA, MKT_LAMA, MKB_LAMA, 
				   TMT_LAMA, PERIODE_BARU, MKT_BARU, 
				   MKB_BARU
				FROM PPI_SIMPEG.PEGAWAI A INNER JOIN
                     PPI_SIMPEG.KENAIKAN_GAJI_BERKALA B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                     INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID				
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.NAMA ASC";
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				PEGAWAI_ID, PERIODE_PROSES, KELAS, 
				   PERIODE_LAMA, MKT_LAMA, MKB_LAMA, 
				   TMT_LAMA, PERIODE_BARU, MKT_BARU, 
				   MKB_BARU
				FROM PPI_SIMPEG.KENAIKAN_GAJI_BERKALA				
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PEGAWAI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT 
				COUNT(A.PEGAWAI_ID) ROWCOUNT
				FROM PPI_SIMPEG.PEGAWAI A INNER JOIN
                     PPI_SIMPEG.KENAIKAN_GAJI_BERKALA B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                     INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID				
				WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.KENAIKAN_GAJI_BERKALA
		        WHERE PEGAWAI_ID IS NOT NULL ".$statement; 
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