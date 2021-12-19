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
  * Entity-base class untuk mengimplementasikan tabel PANGKAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class AirportTax extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AirportTax()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("AIRPORT_TAX_ID", $this->getNextId("AIRPORT_TAX_ID","PPI_SPPD.AIRPORT_TAX"));
		$str = "
				INSERT INTO PPI_SPPD.AIRPORT_TAX (
					AIRPORT_TAX_ID, KOTA_ID, JUMLAH) 
				VALUES (
				  ".$this->getField("AIRPORT_TAX_ID").",
				  '".$this->getField("KOTA_ID")."',
				  '".$this->getField("JUMLAH")."'
				)"; 
				
		$this->id = $this->getField("AIRPORT_TAX_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SPPD.AIRPORT_TAX
				SET    KOTA_ID 	= '".$this->getField("KOTA_ID")."',
					   JUMLAH  		= '".$this->getField("JUMLAH")."'
				WHERE  AIRPORT_TAX_ID = '".$this->getField("AIRPORT_TAX_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.AIRPORT_TAX
                WHERE 
                  AIRPORT_TAX_ID = ".$this->getField("AIRPORT_TAX_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT AIRPORT_TAX_ID, A.KOTA_ID, JUMLAH, B.NAMA KOTA, C.NAMA PROVINSI
				FROM PPI_SPPD.AIRPORT_TAX A
				INNER JOIN PPI_SPPD.KOTA B ON A.KOTA_ID=B.KOTA_ID
				LEFT JOIN PPI_SPPD.PROVINSI C ON C.PROVINSI_ID=B.PROVINSI_ID
				WHERE 1 = 1
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
				SELECT AIRPORT_TAX_ID, PROVINSI_ID, JUMLAH
				FROM PPI_SPPD.AIRPORT_TAX
				WHERE 1 = 1
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
		$str = "SELECT COUNT(AIRPORT_TAX_ID) AS ROWCOUNT FROM PPI_SPPD.AIRPORT_TAX A
				INNER JOIN PPI_SPPD.KOTA B ON A.KOTA_ID=B.KOTA_ID
		        WHERE AIRPORT_TAX_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(AIRPORT_TAX_ID) AS ROWCOUNT FROM PPI_SPPD.AIRPORT_TAX
		        WHERE AIRPORT_TAX_ID IS NOT NULL ".$statement; 
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