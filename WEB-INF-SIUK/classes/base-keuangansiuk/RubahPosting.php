<? 
/* *******************************************************************************************************
MODUL NAME 			: IMASYS
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel RUBAH_POSTING.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class RubahPosting extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function RubahPosting()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("RUBAH_POSTING_ID", $this->getNextId("RUBAH_POSTING_ID","RUBAH_POSTING")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO RUBAH_POSTING (
   					RUBAH_POSTING_ID, NO_NOTA, TANGGAL_SEBELUM, 
   					TANGGAL_POSTING, CREATED_BY, CREATED_DATE) 
				VALUES ( 
					".$this->getField("RUBAH_POSTING_ID").", '".$this->getField("NO_NOTA")."', ".$this->getField("TANGGAL_SEBELUM").",
					".$this->getField("TANGGAL_POSTING").", '".$this->getField("CREATED_BY")."', SYSDATE
				)";
				
		$this->id = $this->getField("RUBAH_POSTING_ID");
		$this->query = $str;
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
				RUBAH_POSTING_ID, NO_NOTA, TANGGAL_SEBELUM, 
				   TANGGAL_POSTING, CREATED_BY, CREATED_DATE
				FROM  RUBAH_POSTING A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY RUBAH_POSTING_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT RUBAH_POSTING_ID, NO_NOTA, KETERANGAN
				FROM RUBAH_POSTING
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NO_NOTA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(RUBAH_POSTING_ID) AS ROWCOUNT FROM RUBAH_POSTING A
		        WHERE RUBAH_POSTING_ID IS NOT NULL ".$statement; 
		
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
	
	
    function getPostingBulan($posting)
	{
		$str = "SELECT TO_CHAR(".$posting." - INTERVAL '6' MONTH, 'MM')  VKONVERSI FROM DUAL ".$statement; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("VKONVERSI"); 
		else 
			return ""; 
    }

    function getPostingTahun($posting)
	{
		$str = "SELECT TO_CHAR(".$posting." - INTERVAL '6' MONTH, 'YYYY')  VKONVERSI FROM DUAL ".$statement; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("VKONVERSI"); 
		else 
			return ""; 
    }
	
	

    function getStatusPosting($paramsArray=array(), $statement="")
	{
		$str = "SELECT STATUS_CLOSING FROM KBBR_THN_BUKU_D WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("STATUS_CLOSING"); 
		else 
			return ""; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(RUBAH_POSTING_ID) AS ROWCOUNT FROM RUBAH_POSTING
		        WHERE RUBAH_POSTING_ID IS NOT NULL ".$statement; 
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