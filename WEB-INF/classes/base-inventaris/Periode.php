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

  class Periode extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Periode()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PERIODE_ID", $this->getNextId("PERIODE_ID","PPI_ASSET.PERIODE")); 
		$str = "
				INSERT INTO PPI_ASSET.PERIODE(
				   PERIODE_ID, PERIODE) 
 			  	VALUES (
				  ".$this->getField("PERIODE_ID").",
				  '".$this->getField("PERIODE")."'
				)"; 
		$this->id = $this->getField("PERIODE_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_ASSET.PERIODE
				SET    
					   NAMA           = '".$this->getField("NAMA")."'
				WHERE  PERIODE_ID     = '".$this->getField("PERIODE_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.PERIODE
                WHERE 
                  PERIODE_ID = ".$this->getField("PERIODE_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY PERIODE_ID ASC")
	{
		$str = "
				SELECT 
				PERIODE_ID, PERIODE
				FROM PPI_ASSET.PERIODE			
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order ;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function getPeriodeAkhir()
	{
		$str = "
				SELECT 
				PERIODE_ID, PERIODE
				FROM PPI_ASSET.PERIODE
				WHERE 1 = 1 ORDER BY PERIODE_ID DESC
				"; 
		$this->select($str);
		if($this->firstRow()) 
			return $this->getField("PERIODE"); 
		else 
			return ""; 

    }
	
	function getPeriodeMax()
	{
		$str = "
				SELECT 
                TO_CHAR(MAX(TO_DATE(PERIODE, 'MMYYYY')), 'MMYYYY') PERIODE
                FROM PPI_ASSET.PERIODE
                WHERE 1 = 1
				"; 
		$this->select($str);
		if($this->firstRow()) 
			return $this->getField("PERIODE"); 
		else 
			return ""; 

    }
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PERIODE_ID) AS ROWCOUNT FROM PPI_ASSET.PERIODE
		        WHERE PERIODE_ID IS NOT NULL ".$statement; 
		
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