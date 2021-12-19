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
  * Entity-base class untuk mengimplementasikan tabel SURVEY.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Survey extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Survey()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
					INSERT INTO PPI_SURVEY.SURVEY (
					   SURVEY_ID, NAMA, SURVEY_PARENT_ID, NO_URUT)
 			  	VALUES (
				  PPI_SURVEY.SURVEY_ID_GENERATE('".$this->getField("SURVEY_ID")."'),
				  '".$this->getField("NAMA")."',
				  '".$this->getField("SURVEY_ID")."',
				  '".$this->getField("NO_URUT")."'
				)"; 
		$this->id=$this->getField("SURVEY_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SURVEY.SURVEY
				SET    
					   NAMA         	= '".$this->getField("NAMA")."',
					   NO_URUT         	= '".$this->getField("NO_URUT")."'
				WHERE  SURVEY_ID  = '".$this->getField("SURVEY_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SURVEY.SURVEY WHERE SURVEY_ID  = '".$this->getField("SURVEY_ID")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY SURVEY_ID ASC")
	{
		$str = "
                 SELECT 
					SURVEY_ID, NAMA, SURVEY_PARENT_ID, NO_URUT, (SELECT COUNT(SURVEY_ID) FROM PPI_SURVEY.SURVEY X WHERE X.SURVEY_PARENT_ID =A.SURVEY_ID) JUMLAH
					FROM PPI_SURVEY.SURVEY A WHERE SURVEY_ID IS NOT NULL
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
					SURVEY_ID, NAMA, SURVEY_PARENT_ID
					FROM PPI_SURVEY.SURVEY A WHERE SURVEY_ID IS NOT NULL
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
		$str = "SELECT COUNT(SURVEY_ID) AS ROWCOUNT FROM PPI_SURVEY.SURVEY
		        WHERE SURVEY_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(SURVEY_ID) AS ROWCOUNT FROM PPI_SURVEY.SURVEY
		        WHERE SURVEY_ID IS NOT NULL ".$statement; 
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