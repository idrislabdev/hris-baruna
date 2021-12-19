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

  class SurveyPelangganSaran extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SurveyPelangganSaran()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURVEY_PELANGGAN_SARAN_ID", $this->getNextId("SURVEY_PELANGGAN_SARAN_ID","PPI_SURVEY.SURVEY_PELANGGAN_SARAN"));

		$str = "
				INSERT INTO PPI_SURVEY.SURVEY_PELANGGAN_SARAN (
				   SURVEY_PELANGGAN_SARAN_ID, SURVEY_ID, PEGAWAI_ID, 
				   KETERANGAN, PERIODE, LAST_CREATE_USER, LAST_CREATE_DATE)   
 			  	VALUES (
				  ".$this->getField("SURVEY_PELANGGAN_SARAN_ID").",
				  '".$this->getField("SURVEY_ID")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("KETERANGAN")."',
				  (SELECT PERIODE FROM PPI_SURVEY.SURVEY_PERIODE_TERAKHIR),
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id=$this->getField("SURVEY_PELANGGAN_SARAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SURVEY.SURVEY_PELANGGAN_SARAN
				SET    
					   SURVEY_ID 					= '".$this->getField("SURVEY_ID")."',
					   PEGAWAI_ID 					= '".$this->getField("PEGAWAI_ID")."',
					   SURVEY_PERIODE_ID 			= '".$this->getField("SURVEY_PERIODE_ID")."',
					   KETERANGAN 					= '".$this->getField("KETERANGAN")."',
					   LAST_UPDATE_USER				= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE				= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  SURVEY_PELANGGAN_SARAN_ID  	= '".$this->getField("SURVEY_PELANGGAN_SARAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SURVEY.SURVEY_PELANGGAN_SARAN
                WHERE 
                  SURVEY_PELANGGAN_SARAN_ID = ".$this->getField("SURVEY_PELANGGAN_SARAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY SURVEY_PELANGGAN_SARAN_ID ASC")
	{
		$str = "
				SELECT 
				SURVEY_PELANGGAN_SARAN_ID, SURVEY_ID, PEGAWAI_ID, 
				   SURVEY_PERIODE_ID, KETERANGAN
				FROM PPI_SURVEY.SURVEY_PELANGGAN_SARAN		
				WHERE SURVEY_PELANGGAN_SARAN_ID IS NOT NULL
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
				SURVEY_PELANGGAN_SARAN_ID, SURVEY_ID, PEGAWAI_ID, 
				   SURVEY_PERIODE_ID, KETERANGAN
				FROM PPI_SURVEY.SURVEY_PELANGGAN_SARAN		
				WHERE SURVEY_PELANGGAN_SARAN_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY SURVEY_PELANGGAN_SARAN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SURVEY_PELANGGAN_SARAN_ID) AS ROWCOUNT FROM PPI_SURVEY.SURVEY_PELANGGAN_SARAN WHERE SURVEY_PELANGGAN_SARAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(SURVEY_PELANGGAN_SARAN_ID) AS ROWCOUNT FROM PPI_SURVEY.SURVEY_PELANGGAN_SARAN WHERE SURVEY_PELANGGAN_SARAN_ID IS NOT NULL ".$statement; 
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