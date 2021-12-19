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

  class PegawaiSurveyData extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiSurveyData()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_SURVEY_DATA_ID", $this->getNextId("PEGAWAI_SURVEY_DATA_ID","PPI_SURVEY.PEGAWAI_SURVEY_DATA"));

		$str = "
				INSERT INTO PPI_SURVEY.PEGAWAI_SURVEY_DATA (
				   PEGAWAI_SURVEY_DATA_ID, PEGAWAI_ID, JENIS_PEGAWAI_ID, 
				   DEPARTEMEN_ID, USIA_RANGE, JABATAN_FUNGSI, PENDIDIKAN, KARIR_LAMA, PERIODE, LAST_CREATE_USER, LAST_CREATE_DATE,
				   JENIS_KELAMIN, STATUS_KAWIN, LAMA_KERJA_TAHUN, LAMA_KERJA_BULAN, LOKASI_ID, KELOMPOK)  
 			  	VALUES (
				  ".$this->getField("PEGAWAI_SURVEY_DATA_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("JENIS_PEGAWAI_ID")."',
				  '".$this->getField("DEPARTEMEN_ID")."',
				  '".$this->getField("USIA_RANGE")."',
				  '".$this->getField("JABATAN_FUNGSI")."',
				  '".$this->getField("PENDIDIKAN")."',
				  '".$this->getField("KARIR_LAMA")."',
				  (SELECT PERIODE FROM PPI_SURVEY.SURVEY_PERIODE_TERAKHIR),
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("JENIS_KELAMIN")."',
				  '".$this->getField("STATUS_KAWIN")."',
				  ".$this->getField("LAMA_KERJA_TAHUN").",
				  ".$this->getField("LAMA_KERJA_BULAN").",
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("KELOMPOK")."'
				)"; 
		$this->id=$this->getField("PEGAWAI_SURVEY_DATA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
		function insertSurveyPeriode()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURVEY_PERIODE_PEGAWAI_ID", $this->getNextId("SURVEY_PERIODE_PEGAWAI_ID","PPI_SURVEY.SURVEY_PERIODE_PEGAWAI"));

		$str = "
				INSERT INTO PPI_SURVEY.SURVEY_PERIODE_PEGAWAI (
				   SURVEY_PERIODE_PEGAWAI_ID, SURVEY_PERIODE_ID, PEGAWAI_ID)  
 			  	VALUES (
				  ".$this->getField("SURVEY_PERIODE_PEGAWAI_ID").",
				  (SELECT SURVEY_PERIODE_ID FROM PPI_SURVEY.SURVEY_PERIODE_TERAKHIR),
				  ".$this->getField("PEGAWAI_ID")."
				)"; 
		$this->id=$this->getField("PEGAWAI_SURVEY_DATA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SURVEY.PEGAWAI_SURVEY_DATA
				SET    
					   PEGAWAI_ID 				= '".$this->getField("PEGAWAI_ID")."',
					   JENIS_PEGAWAI_ID 		= '".$this->getField("JENIS_PEGAWAI_ID")."',
					   DEPARTEMEN_ID 			= '".$this->getField("DEPARTEMEN_ID")."',
					   USIA_RANGE 				= '".$this->getField("USIA_RANGE")."',
					   JABATAN_FUNGSI 			= '".$this->getField("JABATAN_FUNGSI")."',
					   PENDIDIKAN 				= '".$this->getField("PENDIDIKAN")."',
					   KARIR_LAMA				= '".$this->getField("KARIR_LAMA")."',
					   LAST_UPDATE_USER			= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE			= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_SURVEY_DATA_ID  	= '".$this->getField("PEGAWAI_SURVEY_DATA_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SURVEY.PEGAWAI_SURVEY_DATA
                WHERE 
                  PEGAWAI_SURVEY_DATA_ID = ".$this->getField("PEGAWAI_SURVEY_DATA_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY PEGAWAI_SURVEY_DATA_ID ASC")
	{
		$str = "
				SELECT 
				PEGAWAI_SURVEY_DATA_ID, PEGAWAI_ID, JENIS_PEGAWAI_ID, 
				   DEPARTEMEN_ID, USIA_RANGE, JABATAN_FUNGSI, PENDIDIKAN, KARIR_LAMA
				FROM PPI_SURVEY.PEGAWAI_SURVEY_DATA					
				WHERE PEGAWAI_SURVEY_DATA_ID IS NOT NULL
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
				PEGAWAI_SURVEY_DATA_ID, PEGAWAI_ID, JENIS_PEGAWAI_ID, 
				   DEPARTEMEN_ID, USIA_RANGE, JABATAN_FUNGSI, PENDIDIKAN, KARIR_LAMA
				FROM PPI_SURVEY.PEGAWAI_SURVEY_DATA					
				WHERE PEGAWAI_SURVEY_DATA_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PEGAWAI_SURVEY_DATA_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_SURVEY_DATA_ID) AS ROWCOUNT FROM PPI_SURVEY.PEGAWAI_SURVEY_DATA WHERE PEGAWAI_SURVEY_DATA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_SURVEY_DATA_ID) AS ROWCOUNT FROM PPI_SURVEY.PEGAWAI_SURVEY_DATA WHERE PEGAWAI_SURVEY_DATA_ID IS NOT NULL ".$statement; 
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