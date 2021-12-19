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
  * Entity-base class untuk mengimplementasikan tabel AKSES_ADM_WEBSITE.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class AksesAdmWebsite extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AksesAdmWebsite()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("AKSES_ADM_WEBSITE_ID", $this->getNextId("AKSES_ADM_WEBSITE_ID","AKSES_ADM_WEBSITE")); 		

		$str = "
					INSERT INTO AKSES_ADM_WEBSITE (
					   AKSES_ADM_WEBSITE_ID, NAMA) 
 			  	VALUES (
				  ".$this->getField("AKSES_ADM_WEBSITE_ID")."
				  ".$this->getField("NAMA")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE AKSES_ADM_WEBSITE
				SET    
					   NAMA          = '".$this->getField("NAMA")."'
				WHERE  AKSES_ADM_WEBSITE_ID     = '".$this->getField("AKSES_ADM_WEBSITE_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM AKSES_ADM_WEBSITE
                WHERE 
                  AKSES_ADM_WEBSITE_ID = ".$this->getField("AKSES_ADM_WEBSITE_ID").""; 
				  
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
					AKSES_ADM_WEBSITE_ID, NAMA
					FROM AKSES_ADM_WEBSITE WHERE AKSES_ADM_WEBSITE_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY NAMA DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	SELECT 
					AKSES_ADM_WEBSITE_ID, NAMA
					FROM AKSES_ADM_WEBSITE WHERE AKSES_ADM_WEBSITE_ID IS NOT NULL
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
		$str = "SELECT COUNT(AKSES_ADM_WEBSITE_ID) AS ROWCOUNT FROM AKSES_ADM_WEBSITE
		        WHERE AKSES_ADM_WEBSITE_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(AKSES_ADM_WEBSITE_ID) AS ROWCOUNT FROM AKSES_ADM_WEBSITE
		        WHERE AKSES_ADM_WEBSITE_ID IS NOT NULL ".$statement; 
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