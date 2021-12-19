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

  class GajiPokok extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function GajiPokok()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("GAJI_POKOK_ID", $this->getNextId("GAJI_POKOK_ID","PPI_GAJI.GAJI_POKOK")); 
		$str = "
				INSERT INTO PPI_GAJI.GAJI_POKOK (
				   GAJI_POKOK_ID, PANGKAT_ID, MASA_KERJA, JUMLAH) 
				VALUES(
					  ".$this->getField("GAJI_POKOK_ID").",
					  '".$this->getField("PANGKAT_ID")."',
					  '".$this->getField("MASA_KERJA")."',
					  '".$this->getField("JUMLAH")."'
				)"; 
		$this->id = $this->getField("PPI_GAJI.GAJI_POKOK");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.GAJI_POKOK
			   SET 
			   		PANGKAT_ID		= '".$this->getField("PANGKAT_ID")."',
					MASA_KERJA		= '".$this->getField("MASA_KERJA")."',
				   	JUMLAH			= '".$this->getField("JUMLAH")."'
			 WHERE GAJI_POKOK_ID 	= ".$this->getField("GAJI_POKOK_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.GAJI_POKOK
                WHERE 
                  GAJI_POKOK_ID = ".$this->getField("GAJI_POKOK_ID").""; 
				  
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
				SELECT GAJI_POKOK_ID, PANGKAT_ID, MASA_KERJA,JUMLAH
				FROM PPI_GAJI.GAJI_POKOK				
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
				SELECT GAJI_POKOK_ID, PANGKAT_ID, MASA_KERJA,JUMLAH
				FROM PPI_GAJI.GAJI_POKOK		
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY GAJI_POKOK_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getGajiPokok($pangkat="", $masa_kerja="")
	{
		$str = "SELECT JUMLAH FROM PPI_GAJI.GAJI_POKOK WHERE PANGKAT_ID = '".$pangkat."' AND MASA_KERJA = '".$masa_kerja."'  "; 
		$this->select($str); 
		
		if($this->firstRow()) 
			return $this->getField("JUMLAH"); 
		else 
			return 0; 
    }


    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(GAJI_POKOK_ID) AS ROWCOUNT FROM PPI_GAJI.GAJI_POKOK WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(GAJI_POKOK_ID) AS ROWCOUNT FROM PPI_GAJI.GAJI_POKOK WHERE 1 = 1 "; 
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