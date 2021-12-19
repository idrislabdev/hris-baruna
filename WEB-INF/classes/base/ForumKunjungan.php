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
  * Entity-base class untuk mengimplementasikan tabel FORUM_KUNJUNGAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class ForumKunjungan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function ForumKunjungan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("FORUM_KUNJUNGAN_ID", $this->getNextId("FORUM_KUNJUNGAN_ID","FORUM_KUNJUNGAN"));

		$str = "
					INSERT INTO FORUM_KUNJUNGAN (
					   FORUM_KUNJUNGAN_ID, FORUM_ID, IP_ADDRESS)
 			  	VALUES (
				  ".$this->getField("FORUM_KUNJUNGAN_ID")."
				  ".$this->getField("FORUM_ID").",
				  '".$this->getField("IP_ADDRESS")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM FORUM_KUNJUNGAN
                WHERE 
                  FORUM_KUNJUNGAN_ID = ".$this->getField("FORUM_KUNJUNGAN_ID").""; 
				  
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
					FORUM_KUNJUNGAN_ID, FORUM_ID, IP_ADDRESS
					FROM FORUM_KUNJUNGAN WHERE FORUM_KUNJUNGAN_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY FORUM_ID DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	SELECT 
					FORUM_KUNJUNGAN_ID, FORUM_ID, IP_ADDRESS
					FROM FORUM_KUNJUNGAN WHERE FORUM_KUNJUNGAN_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY FORUM_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(FORUM_KUNJUNGAN_ID) AS ROWCOUNT FROM FORUM_KUNJUNGAN
		        WHERE FORUM_KUNJUNGAN_ID IS NOT NULL ".$statement; 
		
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

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(FORUM_KUNJUNGAN_ID) AS ROWCOUNT FROM FORUM_KUNJUNGAN
		        WHERE FORUM_KUNJUNGAN_ID IS NOT NULL ".$statement; 
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