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
  * Entity-base class untuk mengimplementasikan tabel JENIS_PENILAIAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Bobot extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Bobot()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("BOBOT_PENILAIAN_ID", $this->getNextId("BOBOT_PENILAIAN_ID","PPI_PENILAIAN.BOBOT_PENILAIAN")); 
		
		$str = "
				INSERT INTO PPI_PENILAIAN.BOBOT_PENILAIAN (
				   BOBOT_PENILAIAN_ID, JENIS_BOBOT, KELOMPOK, NAMA, NILAI, PERIODE, LAST_CREATED_BY, LAST_CREATED_DATE
				) 
 			  	VALUES (
				  ".$this->getField("BOBOT_PENILAIAN_ID").",
				  '".$this->getField("JENIS_BOBOT")."',
				  '".$this->getField("KELOMPOK")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("NILAI")."',
				  '".$this->getField("PERIODE")."',
				  '".$this->getField("LAST_CREATED_BY")."',
				  SYSDATE 
				)"; 
		$this->id = $this->getField("BOBOT_PENILAIAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_PENILAIAN.BOBOT_PENILAIAN
				SET    
					   JENIS_BOBOT		= '".$this->getField("JENIS_BOBOT")."',
					   KELOMPOK			= '".$this->getField("KELOMPOK")."',
					   NAMA				= '".$this->getField("NAMA")."',
					   NILAI			= '".$this->getField("NILAI")."',
					   PERIODE			= '".$this->getField("PERIODE")."',
					   LAST_UPDATED_BY	= '".$this->getField("LAST_UPDATED_BY")."',
					   LAST_UPDATED_DATE = SYSDATE 

				WHERE  BOBOT_PENILAIAN_ID  = '".$this->getField("BOBOT_PENILAIAN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_PENILAIAN.BOBOT_PENILAIAN
                WHERE 
                  BOBOT_PENILAIAN_ID = ".$this->getField("BOBOT_PENILAIAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $where="", $statement="")
	{
		$str = "
				SELECT 
				BOBOT_PENILAIAN_ID, JENIS_BOBOT, KELOMPOK, NAMA, NILAI, PERIODE, LAST_CREATED_BY, LAST_CREATED_DATE, LAST_UPDATED_BY, LAST_UPDATED_DATE
				FROM PPI_PENILAIAN.BOBOT_PENILAIAN 		
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $where .  $statement;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
    function selectByParamsJenisBobot($paramsArray=array(),$limit=-1,$from=-1, $where="", $statement="")
	{
		$str = "
				SELECT DISTINCT JENIS_BOBOT NAMA 
				FROM PPI_PENILAIAN.BOBOT_PENILAIAN 		
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $where .  $statement;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
    function selectByParamsKelompokBobot($paramsArray=array(),$limit=-1,$from=-1, $where="", $statement="")
	{
		$str = "
				SELECT DISTINCT KELOMPOK NAMA 
				FROM PPI_PENILAIAN.BOBOT_PENILAIAN 		
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $where .  $statement;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				BOBOT_PENILAIAN_ID, JENIS_BOBOT, KELOMPOK, NAMA, NILAI, PERIODE, LAST_CREATED_BY, LAST_CREATED_DATE, LAST_UPDATED_BY, LAST_UPDATED_DATE
				FROM PPI_PENILAIAN.BOBOT_PENILAIAN 		
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY BOBOT_PENILAIAN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(BOBOT_PENILAIAN_ID) AS ROWCOUNT FROM PPI_PENILAIAN.BOBOT_PENILAIAN
		        WHERE BOBOT_PENILAIAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(BOBOT_PENILAIAN_ID) AS ROWCOUNT FROM PPI_PENILAIAN.BOBOT_PENILAIAN
		        WHERE BOBOT_PENILAIAN_ID IS NOT NULL ".$statement; 
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