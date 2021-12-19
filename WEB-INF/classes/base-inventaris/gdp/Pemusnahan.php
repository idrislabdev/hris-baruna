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
  * Entity-base class untuk mengimplementasikan tabel PEMUSNAHAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Pemusnahan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Pemusnahan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEMUSNAHAN_ID", $this->getNextId("PEMUSNAHAN_ID","PPI_ASSET.PEMUSNAHAN")); 		

		$str = "
				INSERT INTO PPI_ASSET.PEMUSNAHAN (
				   PEMUSNAHAN_ID, KODE, NAMA, TANGGAL, KETERANGAN, UPDATED_BY, UPDATED_DATE) 
 			  	VALUES (
				  ".$this->getField("PEMUSNAHAN_ID").",
				  '".$this->getField("KODE")."',
				  '".$this->getField("NAMA")."',
				  ".$this->getField("TANGGAL").",
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("UPDATED_BY")."',
				  ".$this->getField("UPDATED_DATE")."
				)"; 
		$this->id = $this->getField("PEMUSNAHAN_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_ASSET.PEMUSNAHAN
				SET    
					KODE				= '".$this->getField("KODE")."',
				  	NAMA				= '".$this->getField("NAMA")."',
				  	TANGGAL				= ".$this->getField("TANGGAL").",
				  	KETERANGAN			= '".$this->getField("KETERANGAN")."',
				  	UPDATED_DATE		= ".$this->getField("UPDATED_DATE").",
				  	UPDATED_BY			= '".$this->getField("UPDATED_BY")."'					   
				WHERE  PEMUSNAHAN_ID     = '".$this->getField("PEMUSNAHAN_ID")."'

			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ASSET.PEMUSNAHAN A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE PEMUSNAHAN_ID = ".$this->getField("PEMUSNAHAN_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.PEMUSNAHAN
                WHERE 
                  PEMUSNAHAN_ID = ".$this->getField("PEMUSNAHAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PEMUSNAHAN_ID DESC ")
	{
		$str = "
					SELECT 
						   PEMUSNAHAN_ID, KODE, NAMA, TANGGAL, 
						   KETERANGAN, UPDATED_BY, UPDATED_DATE
					FROM PPI_ASSET.PEMUSNAHAN A WHERE PEMUSNAHAN_ID IS NOT NULL
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
		$str = "	SELECT 
						   PEMUSNAHAN_ID, KODE, NAMA, TANGGAL, 
						   KETERANGAN, UPDATED_BY, UPDATED_DATE
					FROM PPI_ASSET.PEMUSNAHAN A WHERE PEMUSNAHAN_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY A.NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEMUSNAHAN_ID) AS ROWCOUNT FROM PPI_ASSET.PEMUSNAHAN A
		        WHERE PEMUSNAHAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEMUSNAHAN_ID) AS ROWCOUNT FROM PPI_ASSET.PEMUSNAHAN A
		        WHERE PEMUSNAHAN_ID IS NOT NULL ".$statement; 
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