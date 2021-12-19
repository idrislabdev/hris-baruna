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
  * Entity-base class untuk mengimplementasikan tabel KAPAL_JENIS.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class GalanganPendapatan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function GalanganPendapatan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("GALANGAN_PENDAPATAN_ID", $this->getNextId("GALANGAN_PENDAPATAN_ID","PPI_GALANGAN.GALANGAN_PENDAPATAN"));

		$str = "
				INSERT INTO PPI_GALANGAN.GALANGAN_PENDAPATAN (
				   GALANGAN_PENDAPATAN_ID, PERIODE, JUMLAH, GALANGAN_ID, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("GALANGAN_PENDAPATAN_ID").",
				  '".$this->getField("PERIODE")."',
				  '".$this->getField("JUMLAH")."',
				  '".$this->getField("GALANGAN_ID")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("GALANGAN_PENDAPATAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_GALANGAN.GALANGAN_PENDAPATAN
				SET    
					   PERIODE         	= '".$this->getField("PERIODE")."',
					   JUMLAH	= '".$this->getField("JUMLAH")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  GALANGAN_PENDAPATAN_ID  = '".$this->getField("GALANGAN_PENDAPATAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_GALANGAN.GALANGAN_PENDAPATAN
                WHERE 
                  GALANGAN_PENDAPATAN_ID = ".$this->getField("GALANGAN_PENDAPATAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY SUBSTR(PERIODE,3,4) DESC, SUBSTR(PERIODE,1,2) DESC")
	{
		$str = "
				  SELECT GALANGAN_PENDAPATAN_ID, PERIODE, A.JUMLAH, GALANGAN_ID
				  FROM PPI_GALANGAN.GALANGAN_PENDAPATAN A
				  WHERE GALANGAN_PENDAPATAN_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	
				  SELECT GALANGAN_PENDAPATAN_ID, PERIODE, A.JUMLAH
				  FROM PPI_GALANGAN.GALANGAN_PENDAPATAN A
				  WHERE GALANGAN_PENDAPATAN_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY GALANGAN_PENDAPATAN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(GALANGAN_PENDAPATAN_ID) AS ROWCOUNT FROM PPI_GALANGAN.GALANGAN_PENDAPATAN
		        WHERE GALANGAN_PENDAPATAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(GALANGAN_PENDAPATAN_ID) AS ROWCOUNT FROM PPI_GALANGAN.GALANGAN_PENDAPATAN
		        WHERE GALANGAN_PENDAPATAN_ID IS NOT NULL ".$statement; 
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