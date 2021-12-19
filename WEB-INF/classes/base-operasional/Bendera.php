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

  class Bendera extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Bendera()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("BENDERA_ID", $this->getNextId("BENDERA_ID","PPI_OPERASIONAL.BENDERA"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.BENDERA (
				   BENDERA_ID, KODE, NAMA) 
 			  	VALUES (
				  ".$this->getField("BENDERA_ID").",
				  '".$this->getField("KODE")."',
				  '".$this->getField("NAMA")."'
				)"; 
		$this->id = $this->getField("BENDERA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.BENDERA
				SET    
					   KODE     	= '".$this->getField("KODE")."',
					   NAMA	 		= '".$this->getField("NAMA")."'
				WHERE  BENDERA_ID  	= '".$this->getField("BENDERA_ID")."'
			 "; 
		$this->query = $str;
		echo $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.BENDERA
                WHERE 
                  BENDERA_ID = ".$this->getField("BENDERA_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY BENDERA_ID ASC")
	{
		$str = "
				  SELECT 
				  BENDERA_ID, KODE, NAMA
				  FROM PPI_OPERASIONAL.BENDERA				  
				  WHERE BENDERA_ID IS NOT NULL
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
				  SELECT 
				  BENDERA_ID, KODE, NAMA
				  FROM PPI_OPERASIONAL.BENDERA				  
				  WHERE BENDERA_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY BENDERA_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(BENDERA_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.BENDERA
		        WHERE BENDERA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(BENDERA_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.BENDERA
		        WHERE BENDERA_ID IS NOT NULL ".$statement; 
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