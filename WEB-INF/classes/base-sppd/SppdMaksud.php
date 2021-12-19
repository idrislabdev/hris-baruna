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

  class SppdMaksud extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SppdMaksud()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SPPD_MAKSUD_ID", $this->getNextId("SPPD_MAKSUD_ID","PPI_SPPD.SPPD_MAKSUD"));
		$str = "INSERT INTO PPI_SPPD.SPPD_MAKSUD (
				   SPPD_MAKSUD_ID, SPPD_ID, NAMA, 
				   KETERANGAN) 
				VALUES(".$this->getField("SPPD_MAKSUD_ID").",
						'".$this->getField("SPPD_ID")."',
						'".$this->getField("NAMA")."', 
				   		'".$this->getField("KETERANGAN")."'
				   )"; 
	
		$this->id = $this->getField("SPPD_MAKSUD_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SPPD.SPPD_MAKSUD
					SET    SPPD_ID        = '".$this->getField("SPPD_ID")."',
						   NAMA           = '".$this->getField("NAMA")."',
						   KETERANGAN     = '".$this->getField("KETERANGAN")."'
				WHERE  SPPD_MAKSUD_ID = '".$this->getField("SPPD_MAKSUD_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.SPPD_MAKSUD
                WHERE 
                  SPPD_ID = ".$this->getField("SPPD_ID").""; 
				  
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
		$str = "SELECT 
					SPPD_MAKSUD_ID, SPPD_ID, NAMA, 
					   KETERANGAN
					FROM PPI_SPPD.SPPD_MAKSUD
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
		$str = "SELECT 
					SPPD_MAKSUD_ID, SPPD_ID, NAMA, 
					   KETERANGAN
					FROM PPI_SPPD.SPPD_MAKSUD
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
		$str = "SELECT COUNT(SPPD_MAKSUD_ID) AS ROWCOUNT FROM PPI_SPPD.SPPD_MAKSUD

		        WHERE SPPD_MAKSUD_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(SPPD_MAKSUD_ID) AS ROWCOUNT FROM PPI_SPPD.SPPD_MAKSUD

		        WHERE SPPD_MAKSUD_ID IS NOT NULL ".$statement; 
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