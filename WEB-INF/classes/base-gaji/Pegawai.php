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

  class Pegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Pegawai()
	{
      $this->Entity(); 
    }
	
    function sinkronisasi()
	{

		$str = " alter session set nls_numeric_characters=',.' ";
		
		$this->execQuery($str);
		

        $str = "
				CALL PPI_GAJI.SINKRONISASI_PEGAWAI('".$this->getField("PERIODE")."')
		"; 
				  
		$this->query = $str;
		// echo $str; exit;
        return $this->execQuery($str);
    }	


	function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder=" ORDER BY P.NAMA ASC ", $periode="", $periode_lalu="")
	{
		$str = "
				SELECT 
				PERIODE, PEGAWAI_ID, A.CABANG_ID, 
				   A.DEPARTEMEN_ID, A.KATEGORI_SEKOLAH, NRP, 
				   A.NAMA, JENIS_KELAMIN, JENIS_PEGAWAI_ID, 
				   PENDIDIKAN_ID, MASA_KERJA, JABATAN_ID, 
				   JABATAN, KELAS, KELOMPOK, 
				   STATUS_CALPEG, A.LAST_CREATE_USER, A.LAST_CREATE_DATE, B.NAMA NAMA_DEPARTEMEN,
				   CASE WHEN STATUS_CALPEG = 'Y' THEN 'Ya' ELSE 'Tidak' END STATUS_CALPEG_DESC
				FROM PPI_GAJI.PEGAWAI A
				LEFT JOIN PPI_SIMPEG.DEPARTEMEN B ON A.CABANG_ID = B.CABANG_ID AND A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
				WHERE 1=1 
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	

	function getCountByParamsMonitoring($paramsArray=array(), $statement="", $periode="", $periode_lalu="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
				FROM PPI_GAJI.PEGAWAI A
				LEFT JOIN PPI_SIMPEG.DEPARTEMEN B ON A.CABANG_ID = B.CABANG_ID AND A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
				WHERE 1=1  ".$statement; 
		
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
		

  } 
?>