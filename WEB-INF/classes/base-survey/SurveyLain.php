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

  class SurveyLain extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SurveyLain()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURVEY_LAIN_ID", $this->getNextId("SURVEY_LAIN_ID","PPI_SURVEY.SURVEY_LAIN"));

		$str = "
				INSERT INTO PPI_SURVEY.SURVEY_LAIN (
				   SURVEY_LAIN_ID, PERTANYAAN, SURVEY_PERIODE_ID) 
 			  	VALUES (
				  ".$this->getField("SURVEY_LAIN_ID").",
				  '".$this->getField("PERTANYAAN")."',
				  '".$this->getField("SURVEY_PERIODE_ID")."'
				)"; 
		$this->id=$this->getField("SURVEY_LAIN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SURVEY.SURVEY_LAIN
				SET    
					   PERTANYAAN 			= '".$this->getField("PERTANYAAN")."',
					   SURVEY_PERIODE_ID 	= '".$this->getField("SURVEY_PERIODE_ID")."'
				WHERE  SURVEY_LAIN_ID  		= '".$this->getField("SURVEY_LAIN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SURVEY.SURVEY_LAIN
                WHERE 
                  SURVEY_LAIN_ID = ".$this->getField("SURVEY_LAIN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY SURVEY_LAIN_ID ASC")
	{
		$str = "
				SELECT 
                A.SURVEY_LAIN_ID, A.PERTANYAAN, A.SURVEY_PERIODE_ID, B.PERIODE
                FROM PPI_SURVEY.SURVEY_LAIN A LEFT JOIN PPI_SURVEY.SURVEY_PERIODE B ON A.SURVEY_PERIODE_ID = B.SURVEY_PERIODE_ID  
                WHERE SURVEY_LAIN_ID IS NOT NULL
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
				SURVEY_LAIN_ID, PERTANYAAN, SURVEY_PERIODE_ID
				FROM PPI_SURVEY.SURVEY_LAIN		
				WHERE SURVEY_LAIN_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY SURVEY_LAIN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SURVEY_LAIN_ID) AS ROWCOUNT FROM PPI_SURVEY.SURVEY_LAIN WHERE SURVEY_LAIN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(SURVEY_LAIN_ID) AS ROWCOUNT FROM PPI_SURVEY.SURVEY_LAIN WHERE SURVEY_LAIN_ID IS NOT NULL ".$statement; 
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