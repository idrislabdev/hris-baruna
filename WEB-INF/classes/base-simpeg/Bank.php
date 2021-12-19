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
  * Entity-base class untuk mengimplementasikan tabel AGAMA.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Bank extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Bank()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("BANK_ID", $this->getNextId("BANK_ID","PPI_SIMPEG.BANK")); 		
		$str = "
				INSERT INTO PPI_SIMPEG.BANK (
				   BANK_ID, NAMA, ALAMAT, KOTA, LAST_CREATE_USER, LAST_CREATE_DATE, KODE_BUKU_BESAR) 
 			  	VALUES (
				  ".$this->getField("BANK_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("ALAMAT")."',
				  '".$this->getField("KOTA")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("KODE_BUKU_BESAR")."'
				)"; 
		$this->id = $this->getField("BANK_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.BANK
				SET    
					NAMA   				= '".$this->getField("NAMA")."',
					ALAMAT 				= '".$this->getField("ALAMAT")."',
					KOTA   				= '".$this->getField("KOTA")."',
					LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE").",
					KODE_BUKU_BESAR	= '".$this->getField("KODE_BUKU_BESAR")."'
				WHERE  BANK_ID = '".$this->getField("BANK_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "
				DELETE FROM PPI_SIMPEG.BANK
                WHERE 
                  BANK_ID = '".$this->getField("BANK_ID")."'
			"; 
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
				SELECT 
				BANK_ID, NAMA, ALAMAT, KOTA, KODE_BUKU_BESAR
				FROM PPI_SIMPEG.BANK				
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
				BANK_ID, NAMA, ALAMAT, KOTA
				FROM PPI_SIMPEG.BANK				
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
		$str = "SELECT COUNT(BANK_ID) AS ROWCOUNT FROM PPI_SIMPEG.BANK
		        WHERE BANK_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(BANK_ID) AS ROWCOUNT FROM PPI_SIMPEG.BANK
		        WHERE BANK_ID IS NOT NULL ".$statement; 
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