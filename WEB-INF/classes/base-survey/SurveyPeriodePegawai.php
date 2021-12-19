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

  class SurveyPeriodePegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SurveyPeriodePegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURVEY_PERIODE_PEGAWAI_ID", $this->getNextId("SURVEY_PERIODE_PEGAWAI_ID","PPI_SURVEY.SURVEY_PERIODE_PEGAWAI"));

		$str = "
				INSERT INTO PPI_SURVEY.SURVEY_PERIODE_PEGAWAI (
				   SURVEY_PERIODE_PEGAWAI_ID, PERIODE_ID, PEGAWAI_ID) 
 			  	VALUES (
				  ".$this->getField("SURVEY_PERIODE_PEGAWAI_ID").",
				  '".$this->getField("PERIODE_ID")."',
				  '".$this->getField("PEGAWAI_ID")."'
				)"; 
		$this->id=$this->getField("SURVEY_PERIODE_PEGAWAI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SURVEY.SURVEY_PERIODE_PEGAWAI
				SET    
					   PERIODE 		= '".$this->getField("PERIODE")."'
				WHERE  SURVEY_PERIODE_PEGAWAI_ID  	= '".$this->getField("SURVEY_PERIODE_PEGAWAI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SURVEY.SURVEY_PERIODE_PEGAWAI
                WHERE 
                  SURVEY_PERIODE_PEGAWAI_ID = ".$this->getField("SURVEY_PERIODE_PEGAWAI_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY SURVEY_PERIODE_PEGAWAI_ID ASC")
	{
		$str = "
				SELECT 
				SURVEY_PERIODE_PEGAWAI_ID, A.SURVEY_PERIODE_ID, PEGAWAI_ID
				FROM PPI_SURVEY.SURVEY_PERIODE_PEGAWAI A INNER JOIN PPI_SURVEY.SURVEY_PERIODE B ON A.SURVEY_PERIODE_ID = B.SURVEY_PERIODE_ID	
				WHERE SURVEY_PERIODE_PEGAWAI_ID IS NOT NULL AND STATUS = 1
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
				SURVEY_PERIODE_PEGAWAI_ID, PERIODE
				FROM PPI_SURVEY.SURVEY_PERIODE_PEGAWAI		
				WHERE SURVEY_PERIODE_PEGAWAI_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY SURVEY_PERIODE_PEGAWAI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SURVEY_PERIODE_PEGAWAI_ID) AS ROWCOUNT FROM PPI_SURVEY.SURVEY_PERIODE_PEGAWAI WHERE SURVEY_PERIODE_PEGAWAI_ID IS NOT NULL ".$statement; 
		
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

    function getPeriodeAkhir($paramsArray=array(), $statement="")
	{
		$str = "SELECT PERIODE FROM PPI_SURVEY.SURVEY_PERIODE_PEGAWAI_TERAKHIR WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
		{
			if((int)$this->getField("PERIODE") == 0)
				return date('Y'); 
			else
				return (int)$this->getField("PERIODE") + 1; 
		}
	}
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SURVEY_PERIODE_PEGAWAI_ID) AS ROWCOUNT FROM PPI_SURVEY.SURVEY_PERIODE_PEGAWAI WHERE SURVEY_PERIODE_PEGAWAI_ID IS NOT NULL ".$statement; 
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