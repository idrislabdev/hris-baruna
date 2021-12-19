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

  class KategoriMenuGroup extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KategoriMenuGroup()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("KATEGORI_MENU_GROUP_ID", $this->getNextId("KATEGORI_MENU_GROUP_ID","PPI_HUKUM.KATEGORI_MENU_GROUP"));
		$str = "
				INSERT INTO PPI_HUKUM.KATEGORI_MENU_GROUP (
				   KATEGORI_ID, MENU_GROUP_ID) 
				SELECT '".$this->getField("KATEGORI_ID")."' KATEGORI_ID, MENU_GROUP_ID FROM PPI.MENU_GROUP WHERE  NAMA IN 
				(SELECT REGEXP_SUBSTR('".$this->getField("MENU_GROUP_ID")."','[^,]+', 1, LEVEL) FROM DUAL CONNECT BY 
				REGEXP_SUBSTR('".$this->getField("MENU_GROUP_ID")."', '[^,]+', 1, LEVEL) IS NOT NULL)	
				"; 
				
		$this->id = $this->getField("KATEGORI_MENU_GROUP_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_HUKUM.KATEGORI_MENU_GROUP
				SET    KATEGORI_ID    = '".$this->getField("KATEGORI_ID")."',
					   MENU_GROUP_ID = '".$this->getField("MENU_GROUP_ID")."'
				WHERE  KATEGORI_ID = '".$this->getField("KATEGORI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_HUKUM.KATEGORI_MENU_GROUP
                WHERE 
                  KATEGORI_ID = ".$this->getField("KATEGORI_ID").""; 
				  
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
                A.KATEGORI_ID, MENU_GROUP_ID, B.NAMA, CASE WHEN B.LINK_FILE IS NULL THEN CASE WHEN STATUS_TMT = 'TMT' THEN 'hukum_kontrak_tmt.php' ELSE 'hukum_kontrak_masa_berlaku.php' END ELSE B.LINK_FILE END  LINK_FILE
                FROM PPI_HUKUM.KATEGORI_MENU_GROUP A INNER JOIN PPI_HUKUM.KATEGORI B ON A.KATEGORI_ID = B.KATEGORI_ID
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
				KATEGORI_ID, MENU_GROUP_ID
				FROM PPI_HUKUM.KATEGORI_MENU_GROUP
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KATEGORI_MENU_GROUP_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KATEGORI_ID) AS ROWCOUNT FROM PPI_HUKUM.KATEGORI_MENU_GROUP
		        WHERE 1=1 ".$statement; 
		
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
		$str = "SELECT COUNT(KATEGORI_ID) AS ROWCOUNT FROM PPI_HUKUM.KATEGORI_MENU_GROUP
		        WHERE 1=1 ".$statement; 
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