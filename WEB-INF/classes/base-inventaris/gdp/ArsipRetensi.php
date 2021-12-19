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
  * Entity-base class untuk mengimplementasikan tabel ARSIP_RETENSI.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class ArsipRetensi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function ArsipRetensi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ARSIP_RETENSI_ID", $this->getNextId("ARSIP_RETENSI_ID","PPI_ASSET.ARSIP_RETENSI")); 		

		$str = "
				INSERT INTO PPI_ASSET.ARSIP_RETENSI (
				   ARSIP_RETENSI_ID, TANGGAL, ARSIP_ID) 
 			  	VALUES (
				  ".$this->getField("ARSIP_RETENSI_ID").",
				  ".$this->getField("TANGGAL").",
  				  ".$this->getField("ARSIP_ID")."
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_ASSET.ARSIP_RETENSI
				SET    
					   TANGGAL 			= ".$this->getField("TANGGAL").",
					   ARSIP_ID 		= ".$this->getField("ARSIP_ID")."				   
				WHERE  ARSIP_RETENSI_ID = '".$this->getField("ARSIP_RETENSI_ID")."'

			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ASSET.ARSIP_RETENSI A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE ARSIP_RETENSI_ID = ".$this->getField("ARSIP_RETENSI_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.ARSIP_RETENSI
                WHERE 
                  ARSIP_RETENSI_ID = ".$this->getField("ARSIP_RETENSI_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.ARSIP_RETENSI_ID DESC ")
	{
		$str = "
					SELECT 
						   ARSIP_RETENSI_ID, ARSIP_ID, TANGGAL
					FROM PPI_ASSET.ARSIP_RETENSI A WHERE ARSIP_RETENSI_ID IS NOT NULL
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
						   ARSIP_RETENSI_ID, ARSIP_ID, TANGGAL
					FROM PPI_ASSET.ARSIP_RETENSI A WHERE ARSIP_RETENSI_ID IS NOT NULL
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
		$str = "SELECT COUNT(ARSIP_RETENSI_ID) AS ROWCOUNT FROM PPI_ASSET.ARSIP_RETENSI A
		        WHERE ARSIP_RETENSI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(ARSIP_RETENSI_ID) AS ROWCOUNT FROM PPI_ASSET.ARSIP_RETENSI A
		        WHERE ARSIP_RETENSI_ID IS NOT NULL ".$statement; 
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