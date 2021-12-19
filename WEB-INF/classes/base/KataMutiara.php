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
  * Entity-base class untuk mengimplementasikan tabel KATA_MUTIARA.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class KataMutiara extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KataMutiara()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KATA_MUTIARA_ID", $this->getNextId("KATA_MUTIARA_ID","KATA_MUTIARA"));

		$str = "
					INSERT INTO KATA_MUTIARA (
					   KATA_MUTIARA_ID, NAMA, USER_LOGIN_ID, KETERANGAN, STATUS)
 			  	VALUES (
				  ".$this->getField("KATA_MUTIARA_ID").",
				  '".$this->getField("NAMA")."',
				  ".$this->getField("USER_LOGIN_ID").",
				  '".$this->getField("KETERANGAN")."',
				  ".$this->getField("STATUS")."
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KATA_MUTIARA
				SET    
					   NAMA         	= '".$this->getField("NAMA")."',
					   USER_LOGIN_ID 	= ".$this->getField("USER_LOGIN_ID").",
					   KETERANGAN	 	= '".$this->getField("KETERANGAN")."'
				WHERE  KATA_MUTIARA_ID  = '".$this->getField("KATA_MUTIARA_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE KATA_MUTIARA A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE KATA_MUTIARA_ID = ".$this->getField("KATA_MUTIARA_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM KATA_MUTIARA
                WHERE 
                  KATA_MUTIARA_ID = ".$this->getField("KATA_MUTIARA_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NAMA ASC")
	{
		$str = "
					SELECT 
					KATA_MUTIARA_ID, NAMA, USER_LOGIN_ID, KETERANGAN, CASE WHEN STATUS = 1 THEN 'Aktif' ELSE 'Non-Aktif' END STATUS
					FROM KATA_MUTIARA A WHERE KATA_MUTIARA_ID IS NOT NULL
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
					KATA_MUTIARA_ID, NAMA, USER_LOGIN_ID, KETERANGAN, STATUS
					FROM KATA_MUTIARA WHERE KATA_MUTIARA_ID IS NOT NULL
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
		$str = "SELECT COUNT(KATA_MUTIARA_ID) AS ROWCOUNT FROM KATA_MUTIARA
		        WHERE KATA_MUTIARA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KATA_MUTIARA_ID) AS ROWCOUNT FROM KATA_MUTIARA
		        WHERE KATA_MUTIARA_ID IS NOT NULL ".$statement; 
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