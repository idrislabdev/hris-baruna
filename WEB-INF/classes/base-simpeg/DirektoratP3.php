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
  * Entity-base class untuk mengimplementasikan tabel DIREKTORAT_P3.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class DirektoratP3 extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function DirektoratP3()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_SIMPEG.DIREKTORAT_P3 (
				   DIREKTORAT_P3_ID, NAMA, CABANG_P3_ID, DIREKTORAT_P3_PARENT_ID, KETERANGAN
				   ) 
 			  	VALUES (
				  PPI_SIMPEG.DIREKTORAT_P3_ID_GENERATE('".$this->getField("DIREKTORAT_P3_ID")."'),
				  '".$this->getField("NAMA")."',
				  '".$this->getField("CABANG_P3_ID")."',
				  '".$this->getField("DIREKTORAT_P3_ID")."',
				  '".$this->getField("KETERANGAN")."'
				)"; 
		$this->id = $this->getField("DIREKTORAT_P3_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.DIREKTORAT_P3
				SET    
					   NAMA           = '".$this->getField("NAMA")."',
					   KETERANGAN         = '".$this->getField("KETERANGAN")."'
				WHERE  DIREKTORAT_P3_ID     = '".$this->getField("DIREKTORAT_P3_ID")."'
			 "; //FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.DIREKTORAT_P3
                WHERE 
                  DIREKTORAT_P3_ID = ".$this->getField("DIREKTORAT_P3_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				DIREKTORAT_P3_ID, CABANG_P3_ID, NAMA, DIREKTORAT_P3_PARENT_ID, KETERANGAN
				FROM PPI_SIMPEG.DIREKTORAT_P3
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY NAMA DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT DIREKTORAT_P3_ID, NAMA, CABANG_P3_ID, DIREKTORAT_P3_PARENT_ID, KETERANGAN
				FROM PPI_SIMPEG.DIREKTORAT_P3
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
		$str = "SELECT COUNT(DIREKTORAT_P3_ID) AS ROWCOUNT FROM PPI_SIMPEG.DIREKTORAT_P3
		        WHERE DIREKTORAT_P3_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(DIREKTORAT_P3_ID) AS ROWCOUNT FROM PPI_SIMPEG.DIREKTORAT_P3
		        WHERE DIREKTORAT_P3_ID IS NOT NULL ".$statement; 
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