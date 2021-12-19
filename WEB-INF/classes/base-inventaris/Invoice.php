<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Invoice extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Invoice()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("INVOICE_ID", $this->getNextId("INVOICE_ID","PPI_ASSET.INVOICE")); 
		$str = "
				INSERT INTO PPI_ASSET.INVOICE (
				   INVOICE_ID, INVOICE_NO, NAMA, 
				   TANGGAL)
				VALUES (
						".$this->getField("INVOICE_ID").", 
						'".$this->getField("INVOICE_NO")."', 
						'".$this->getField("NAMA")."', 
						".$this->getField("TANGGAL")."
						)"; 
		$this->id = $this->getField("INVOICE_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVOICE
				SET     
						INVOICE_NO	= '".$this->getField("INVOICE_NO")."', 
						NAMA		= '".$this->getField("NAMA")."', 
						TANGGAL		= ".$this->getField("TANGGAL")."
				WHERE  INVOICE_ID        = '".$this->getField("INVOICE_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.INVOICE
                WHERE 
                  INVOICE_ID = ".$this->getField("INVOICE_ID").""; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				INVOICE_ID, INVOICE_NO, NAMA, 
				   TANGGAL
				FROM PPI_ASSET.INVOICE
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
				SELECT 
				INVOICE_ID, INVOICE_NO, NAMA, 
				   TANGGAL
				FROM PPI_ASSET.INVOICE
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY INVOICE_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(INVOICE_ID) AS ROWCOUNT FROM PPI_ASSET.INVOICE  WHERE 1 = 1 ".$statement; 
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

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(INVOICE_ID) AS ROWCOUNT FROM PPI_ASSET.INVOICE WHERE 1 = 1 "; 
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