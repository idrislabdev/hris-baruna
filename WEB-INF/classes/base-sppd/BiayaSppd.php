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

  class BiayaSppd extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function BiayaSppd()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("BIAYA_SPPD_ID", $this->getNextId("BIAYA_SPPD_ID","PPI_SPPD.BIAYA_SPPD"));
		$str = "
				INSERT INTO PPI_SPPD.BIAYA_SPPD (
				   BIAYA_SPPD_ID, BIAYA_SPPD_PARENT_ID, NAMA, 
				   KETERANGAN, JUMLAH) 
				VALUES (PPI_SPPD.BIAYA_SPPD_ID_GENERATE('".$this->getField("BIAYA_SPPD_ID")."'), 
						'".$this->getField("BIAYA_SPPD_ID")."', 
						'".$this->getField("NAMA")."', 
				   		'".$this->getField("KETERANGAN")."', 
						'".$this->getField("JUMLAH")."'
						)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SPPD.BIAYA_SPPD
				SET    NAMA  		= '".$this->getField("NAMA")."',
					   KETERANGAN   = '".$this->getField("KETERANGAN")."',
					   JUMLAH  		= '".$this->getField("JUMLAH")."'
				WHERE  BIAYA_SPPD_ID = '".$this->getField("BIAYA_SPPD_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.BIAYA_SPPD
                WHERE 
                  BIAYA_SPPD_ID = ".$this->getField("BIAYA_SPPD_ID").""; 
				  
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
				BIAYA_SPPD_ID, BIAYA_SPPD_PARENT_ID, NAMA, 
				   KETERANGAN, JUMLAH
				FROM PPI_SPPD.BIAYA_SPPD
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

    function selectByParamsEdit($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqJenisSppdId="")
	{
		$str = "
                SELECT A.BIAYA_SPPD_ID, B.BIAYA_SPPD_ID BIAYA_SPPD_ID_JP, B.JENIS_BIAYA_SPPD_ID, A.BIAYA_SPPD_PARENT_ID, NAMA,
                       (SELECT COUNT(BIAYA_SPPD_ID) FROM PPI_SPPD.BIAYA_SPPD X WHERE X.BIAYA_SPPD_PARENT_ID = A.BIAYA_SPPD_ID) JUMLAH_CHILD
                FROM PPI_SPPD.BIAYA_SPPD A 
                LEFT JOIN PPI_SPPD.JENIS_BIAYA_SPPD B ON A.BIAYA_SPPD_ID = B.BIAYA_SPPD_ID AND JENIS_SPPD_ID = ".$reqJenisSppdId."
                WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.BIAYA_SPPD_ID ASC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				BIAYA_SPPD_ID, BIAYA_SPPD_PARENT_ID, NAMA, 
				   KETERANGAN, JUMLAH
				FROM PPI_SPPD.BIAYA_SPPD
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
		$str = "SELECT COUNT(BIAYA_SPPD_ID) AS ROWCOUNT FROM PPI_SPPD.BIAYA_SPPD
		        WHERE BIAYA_SPPD_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(BIAYA_SPPD_ID) AS ROWCOUNT FROM PPI_SPPD.BIAYA_SPPD
		        WHERE BIAYA_SPPD_ID IS NOT NULL ".$statement; 
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