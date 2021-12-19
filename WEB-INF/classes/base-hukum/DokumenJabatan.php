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

  class DokumenJabatan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function DokumenJabatan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("DOKUMEN_JABATAN_ID", $this->getNextId("DOKUMEN_JABATAN_ID","PPI_HUKUM.DOKUMEN_JABATAN"));
		$str = "
				INSERT INTO PPI_HUKUM.DOKUMEN_JABATAN (
				   DOKUMEN_ID, JABATAN_ID) 
				SELECT '".$this->getField("DOKUMEN_ID")."' DOKUMEN_ID, JABATAN_ID FROM PPI_SIMPEG.JABATAN WHERE  NAMA IN 
				(SELECT REGEXP_SUBSTR('".$this->getField("JABATAN")."','[^,]+', 1, LEVEL) FROM DUAL CONNECT BY 
				REGEXP_SUBSTR('".$this->getField("JABATAN")."', '[^,]+', 1, LEVEL) IS NOT NULL)	
				"; 
				
		$this->id = $this->getField("DOKUMEN_JABATAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_HUKUM.DOKUMEN_JABATAN
				SET    DOKUMEN_ID    = '".$this->getField("DOKUMEN_ID")."',
					   JABATAN_ID = '".$this->getField("JABATAN_ID")."'
				WHERE  DOKUMEN_ID = '".$this->getField("DOKUMEN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_HUKUM.DOKUMEN_JABATAN
                WHERE 
                  DOKUMEN_ID = ".$this->getField("DOKUMEN_ID").""; 
				  
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
				DOKUMEN_ID, JABATAN_ID
				FROM PPI_HUKUM.DOKUMEN_JABATAN
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
				DOKUMEN_ID, JABATAN_ID
				FROM PPI_HUKUM.DOKUMEN_JABATAN
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY DOKUMEN_JABATAN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(DOKUMEN_ID) AS ROWCOUNT FROM PPI_HUKUM.DOKUMEN_JABATAN
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
		$str = "SELECT COUNT(DOKUMEN_ID) AS ROWCOUNT FROM PPI_HUKUM.DOKUMEN_JABATAN
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