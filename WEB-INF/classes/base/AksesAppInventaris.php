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
  * Entity-base class untuk mengimplementasikan tabel AKSES_APP_INVENTARIS.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class AksesAppInventaris extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AksesAppInventaris()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("AKSES_APP_INVENTARIS_ID", $this->getNextId("AKSES_APP_INVENTARIS_ID","AKSES_APP_INVENTARIS"));

		$str = "
					INSERT INTO AKSES_APP_INVENTARIS (
					   AKSES_APP_INVENTARIS_ID, NAMA) 
 			  	VALUES (
				  ".$this->getField("AKSES_APP_INVENTARIS_ID")."
				  ".$this->getField("NAMA")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE AKSES_APP_INVENTARIS
				SET    
					   NAMA          = '".$this->getField("NAMA")."'
				WHERE  AKSES_APP_INVENTARIS_ID     = '".$this->getField("AKSES_APP_INVENTARIS_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM AKSES_APP_INVENTARIS
                WHERE 
                  AKSES_APP_INVENTARIS_ID = ".$this->getField("AKSES_APP_INVENTARIS_ID").""; 
				  
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
					AKSES_APP_INVENTARIS_ID, NAMA
					FROM AKSES_APP_INVENTARIS WHERE AKSES_APP_INVENTARIS_ID IS NOT NULL
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
					AKSES_APP_INVENTARIS_ID, NAMA
					FROM AKSES_APP_INVENTARIS WHERE AKSES_APP_INVENTARIS_ID IS NOT NULL
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
		$str = "SELECT COUNT(AKSES_APP_INVENTARIS_ID) AS ROWCOUNT FROM AKSES_APP_INVENTARIS
		        WHERE AKSES_APP_INVENTARIS_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(AKSES_APP_INVENTARIS_ID) AS ROWCOUNT FROM AKSES_APP_INVENTARIS
		        WHERE AKSES_APP_INVENTARIS_ID IS NOT NULL ".$statement; 
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