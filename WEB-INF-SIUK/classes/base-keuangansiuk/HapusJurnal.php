
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
  * EntitySIUK-base class untuk mengimplementasikan tabel HAPUS_JURNAL_POSTING.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class HapusJurnal extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function HapusJurnal()
	 {
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO HAPUS_JURNAL_POSTING (
					   NO_NOTA, CREATED_BY) 
				VALUES ('".$this->getField("NO_NOTA")."', '".$this->getField("CREATED_BY")."'
				)";
				
		$this->id = $this->getField("HAPUS_JURNAL_POSTING_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT 
				NO_NOTA, BLN_BUKU, THN_BUKU, 
				   DESKRIPSI, NILAI, CREATED_BY, 
				   CREATED_DATE
				FROM HAPUS_JURNAL_POSTING A
				WHERE 1 = 1 
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
    function getCountByParams($paramsArray=array(), $statement="")
	 {
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM HAPUS_JURNAL_POSTING
		        WHERE 1 = 1 ".$statement; 
		
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

  } 
?>