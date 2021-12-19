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
  * Entity-base class untuk mengimplementasikan tabel PENANDA_TANGAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PenandaTangan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PenandaTangan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PENANDA_TANGAN_ID", $this->getNextId("PENANDA_TANGAN_ID","PENANDA_TANGAN"));

		$str = "
				INSERT INTO PENANDA_TANGAN (
				   PENANDA_TANGAN_ID, NAMA, JABATAN) 
 			  	VALUES (
				  ".$this->getField("PENANDA_TANGAN_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("JABATAN")."'
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PENANDA_TANGAN
				SET    
					   NAMA	= '".$this->getField("NAMA")."',
					   JABATAN	 	= '".$this->getField("JABATAN")."'
				WHERE  PENANDA_TANGAN_ID  		= '".$this->getField("PENANDA_TANGAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PENANDA_TANGAN
                WHERE 
                  PENANDA_TANGAN_ID = ".$this->getField("PENANDA_TANGAN_ID").""; 
				  
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
					SELECT PENANDA_TANGAN_ID, NAMA, JABATAN
					FROM PENANDA_TANGAN A WHERE PENANDA_TANGAN_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
					SELECT PENANDA_TANGAN_ID, NAMA, JABATAN
					FROM PENANDA_TANGAN A WHERE PENANDA_TANGAN_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NO_URUT ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PENANDA_TANGAN_ID) AS ROWCOUNT FROM PENANDA_TANGAN
		        WHERE PENANDA_TANGAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PENANDA_TANGAN_ID) AS ROWCOUNT FROM PENANDA_TANGAN
		        WHERE PENANDA_TANGAN_ID IS NOT NULL ".$statement; 
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