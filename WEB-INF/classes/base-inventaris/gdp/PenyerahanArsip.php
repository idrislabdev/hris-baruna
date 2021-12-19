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
  * Entity-base class untuk mengimplementasikan tabel PENYERAHAN_ARSIP.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PenyerahanArsip extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PenyerahanArsip()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PENYERAHAN_ARSIP_ID", $this->getNextId("PENYERAHAN_ARSIP_ID","PPI_ASSET.PENYERAHAN_ARSIP")); 		

		$str = "
				INSERT INTO PPI_ASSET.PENYERAHAN_ARSIP (
				   PENYERAHAN_ARSIP_ID, PENYERAHAN_ID, ARSIP_ID) 
 			  	VALUES (
				  ".$this->getField("PENYERAHAN_ARSIP_ID").",
				  ".$this->getField("PENYERAHAN_ID").",
  				  ".$this->getField("ARSIP_ID")."
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_ASSET.PENYERAHAN_ARSIP
				SET    
					   PENYERAHAN_ID 	= ".$this->getField("PENYERAHAN_ID").",
					   ARSIP_ID 		= ".$this->getField("ARSIP_ID")."			   
				WHERE  PENYERAHAN_ARSIP_ID     = '".$this->getField("PENYERAHAN_ARSIP_ID")."'

			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ASSET.PENYERAHAN_ARSIP A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE PENYERAHAN_ARSIP_ID = ".$this->getField("PENYERAHAN_ARSIP_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.PENYERAHAN_ARSIP
                WHERE 
                  PENYERAHAN_ID = ".$this->getField("PENYERAHAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PENYERAHAN_ARSIP_ID DESC ")
	{
		$str = "
					SELECT 
						   PENYERAHAN_ARSIP_ID, ARSIP_ID, PENYERAHAN_ID
					FROM PPI_ASSET.PENYERAHAN_ARSIP A WHERE PENYERAHAN_ARSIP_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PENYERAHAN_ARSIP_ID ASC ")
	{
		$str = "
					SELECT 
						   PENYERAHAN_ARSIP_ID, A.ARSIP_ID, B.NAMA || ' - ' || C.NAMA ARSIP_BOKS, PENYERAHAN_ID
                    FROM PPI_ASSET.PENYERAHAN_ARSIP A 
                    LEFT JOIN PPI_ASSET.ARSIP B ON A.ARSIP_ID=B.ARSIP_ID
                    LEFT JOIN PPI_ASSET.BOKS_PENYIMPANAN C ON B.BOKS_PENYIMPANAN_ID=C.BOKS_PENYIMPANAN_ID
                    WHERE PENYERAHAN_ARSIP_ID IS NOT NULL
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
						   PENYERAHAN_ARSIP_ID, ARSIP_ID, PENYERAHAN_ID
					FROM PPI_ASSET.PENYERAHAN_ARSIP A WHERE PENYERAHAN_ARSIP_ID IS NOT NULL
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
		$str = "SELECT COUNT(PENYERAHAN_ARSIP_ID) AS ROWCOUNT FROM PPI_ASSET.PENYERAHAN_ARSIP A
		        WHERE PENYERAHAN_ARSIP_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PENYERAHAN_ARSIP_ID) AS ROWCOUNT FROM PPI_ASSET.PENYERAHAN_ARSIP A
		        WHERE PENYERAHAN_ARSIP_ID IS NOT NULL ".$statement; 
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