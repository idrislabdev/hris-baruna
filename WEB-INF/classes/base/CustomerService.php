<? 
/* *******************************************************************************************************
MODUL NO_TELEPON 			: MTSN LAWANG
FILE NO_TELEPON 			: 
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

  class CustomerService extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function CustomerService()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("NO_TELEPON", $this->getNextId("NO_TELEPON","PPI.CUSTOMER_SERVICE"));
		$str = "			
			INSERT INTO PPI.CUSTOMER_SERVICE (
   					NO_TELEPON, PESAN, TANGGAL) 
			VALUES ( 
				   '".$this->getField("NO_TELEPON")."',
				   '".$this->getField("PESAN")."'
				   ".$this->getField("TANGGAL")."
				)"; 
		$this->id = $this->getField("NO_TELEPON");
		$this->query = $str;
		//$this->mysql_query($str);
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			    UPDATE PPI.CUSTOMER_SERVICE
				SET    
					   NO_TELEPON       = '".$this->getField("NO_TELEPON")."',
					   TANGGAL        = ".$this->getField("TANGGAL").",
					   PESAN     = '".$this->getField("PESAN")."'
				WHERE  NO_TELEPON = '".$this->getField("NO_TELEPON_ID")."'
				";
		$this->id = $this->getField("NO_TELEPON"); 
		$this->query = $str;	
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE PPI.CUSTOMER_SERVICE
                WHERE 
                  NO_TELEPON = '".$this->getField("NO_TELEPON")."'
				  "; 
				  
		$this->query = $str;
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
					NO_TELEPON, TANGGAL, PESAN
				FROM PPI.CUSTOMER_SERVICE 
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
					NO_TELEPON, TANGGAL, PESAN
				FROM PPI.CUSTOMER_SERVICE 
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY NO_TELEPON DESC";
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
		$str = "SELECT COUNT(NO_TELEPON) AS ROWCOUNT FROM PPI.CUSTOMER_SERVICE WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(NO_TELEPON) AS ROWCOUNT FROM PPI.CUSTOMER_SERVICE WHERE 1 = 1 "; 
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