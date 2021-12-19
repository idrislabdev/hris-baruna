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
  * Entity-base class untuk mengimplementasikan tabel ATRIBUT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Atribut extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Atribut()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_PENILAIAN.ATRIBUT (
				   ATRIBUT_ID, NAMA, JENIS_PENILAIAN_ID, ATRIBUT_PARENT_ID, KETERANGAN, BOBOT, NILAI_STANDAR
				   , LAST_CREATE_USER, LAST_CREATE_DATE)   
 			  	VALUES (
				  PPI_PENILAIAN.ATRIBUT_ID_GENERATE('".$this->getField("ATRIBUT_ID")."'),
				  '".$this->getField("NAMA")."',
				  '".$this->getField("JENIS_PENILAIAN_ID")."',
				  '".$this->getField("ATRIBUT_ID")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("BOBOT")."',
				  '".$this->getField("NILAI_STANDAR")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("ATRIBUT_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_PENILAIAN.ATRIBUT
				SET    
					   NAMA           = '".$this->getField("NAMA")."',
					   KETERANGAN     = '".$this->getField("KETERANGAN")."',
					   BOBOT          = '".$this->getField("BOBOT")."',
					   NILAI_STANDAR  = '".$this->getField("NILAI_STANDAR")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  ATRIBUT_ID     = '".$this->getField("ATRIBUT_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_PENILAIAN.ATRIBUT
                WHERE 
                  ATRIBUT_ID = ".$this->getField("ATRIBUT_ID").""; 
				  
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
				ATRIBUT_ID, JENIS_PENILAIAN_ID, NAMA, ATRIBUT_PARENT_ID, KETERANGAN, BOBOT, NILAI_STANDAR
				FROM PPI_PENILAIAN.ATRIBUT
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT ATRIBUT_ID, NAMA, JENIS_PENILAIAN_ID, ATRIBUT_PARENT_ID, KETERANGAN, BOBOT, NILAI_STANDAR
				FROM PPI_PENILAIAN.ATRIBUT
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
		$str = "SELECT COUNT(ATRIBUT_ID) AS ROWCOUNT FROM PPI_PENILAIAN.ATRIBUT
		        WHERE ATRIBUT_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(ATRIBUT_ID) AS ROWCOUNT FROM PPI_PENILAIAN.ATRIBUT
		        WHERE ATRIBUT_ID IS NOT NULL ".$statement; 
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