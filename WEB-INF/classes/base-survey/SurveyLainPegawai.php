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

  class SurveyLainPegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SurveyLainPegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURVEY_LAIN_PEGAWAI_ID", $this->getNextId("SURVEY_LAIN_PEGAWAI_ID","PPI_SURVEY.SURVEY_LAIN_PEGAWAI"));

		$str = "
				INSERT INTO PPI_SURVEY.SURVEY_LAIN_PEGAWAI (
				   SURVEY_LAIN_PEGAWAI_ID, SURVEY_LAIN_ID, PEGAWAI_ID, 
				    KETERANGAN, PERIODE) 
 			  	VALUES (
				  ".$this->getField("SURVEY_LAIN_PEGAWAI_ID").",
				  '".$this->getField("SURVEY_LAIN_ID")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("KETERANGAN")."',
				  (SELECT PERIODE FROM PPI_SURVEY.SURVEY_PERIODE_TERAKHIR)
				)"; 
		$this->id=$this->getField("SURVEY_LAIN_PEGAWAI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SURVEY.SURVEY_LAIN_PEGAWAI
				SET    
					   SURVEY_LAIN_ID 			= '".$this->getField("SURVEY_LAIN_ID")."',
					   PEGAWAI_ID 				= '".$this->getField("PEGAWAI_ID")."',
					   KETERANGAN 				= '".$this->getField("KETERANGAN")."'
				WHERE  SURVEY_LAIN_PEGAWAI_ID  	= '".$this->getField("SURVEY_LAIN_PEGAWAI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SURVEY.SURVEY_LAIN_PEGAWAI
                WHERE 
                  SURVEY_LAIN_PEGAWAI_ID = ".$this->getField("SURVEY_LAIN_PEGAWAI_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY SURVEY_LAIN_PEGAWAI_ID ASC")
	{
		$str = "
				SELECT 
				SURVEY_LAIN_PEGAWAI_ID, SURVEY_LAIN_ID, PEGAWAI_ID, 
				   KETERANGAN
				FROM PPI_SURVEY.SURVEY_LAIN_PEGAWAI		
				WHERE SURVEY_LAIN_PEGAWAI_ID IS NOT NULL
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
				SURVEY_LAIN_PEGAWAI_ID, SURVEY_LAIN_ID, PEGAWAI_ID, 
				   KETERANGAN
				FROM PPI_SURVEY.SURVEY_LAIN_PEGAWAI		
				WHERE SURVEY_LAIN_PEGAWAI_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY SURVEY_LAIN_PEGAWAI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SURVEY_LAIN_PEGAWAI_ID) AS ROWCOUNT FROM PPI_SURVEY.SURVEY_LAIN_PEGAWAI WHERE SURVEY_LAIN_PEGAWAI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(SURVEY_LAIN_PEGAWAI_ID) AS ROWCOUNT FROM PPI_SURVEY.SURVEY_LAIN_PEGAWAI WHERE SURVEY_LAIN_PEGAWAI_ID IS NOT NULL ".$statement; 
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