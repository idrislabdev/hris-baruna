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

  class PertanyaanPeriodePegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PertanyaanPeriodePegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PERTANYAAN_PERIODE_PEGAWAI_ID", $this->getNextId("PERTANYAAN_PERIODE_PEGAWAI_ID","PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI")); 
		
		$str = "
				INSERT INTO PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI (
				   PERTANYAAN_PERIODE_PEGAWAI_ID, PERTANYAAN_PERIODE_ID, JAWABAN_ID, SARAN,
				   RANGE_NILAI, PEGAWAI_ID_DINILAI, TYPE_PEGAWAI_DINILAI, PEGAWAI_ID_PENILAI, TYPE_PEGAWAI_PENILAI, PERTANYAAN_ID, PERIODE, LAST_CREATED_DATE, LAST_CREATED_BY,
				   LAST_IMPORTED_BY, STATUS_IMPORT) 
 			  	VALUES (
					".$this->getField("PERTANYAAN_PERIODE_PEGAWAI_ID").",
					'".$this->getField("PERTANYAAN_PERIODE_ID")."',
					'".$this->getField("JAWABAN_ID")."',
					'".$this->getField("SARAN")."',
					'".$this->getField("RANGE_NILAI")."',
					'".$this->getField("PEGAWAI_ID_DINILAI")."',
					'".$this->getField("TYPE_PEGAWAI_DINILAI")."',
					'".$this->getField("PEGAWAI_ID_PENILAI")."',
					'".$this->getField("TYPE_PEGAWAI_PENILAI")."',
					'".$this->getField("PERTANYAAN_ID")."',
					'".$this->getField("PERIODE")."',
				  	SYSDATE,
				  	'".$this->getField("LAST_CREATED_BY")."' ,
				  	'".$this->getField("LAST_IMPORTED_BY")."' ,
				  	'".$this->getField("STATUS_IMPORT")."' 
				)"; 
		$this->id = $this->getField("PERTANYAAN_PERIODE_PEGAWAI_ID");
		$this->query = $str;
		//echo $str; exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI
				SET    
					   PERTANYAAN_PERIODE_ID	= '".$this->getField("PERTANYAAN_PERIODE_ID")."',
					   JAWABAN_ID				= '".$this->getField("JAWABAN_ID")."',
					   RANGE_NILAI				= '".$this->getField("RANGE_NILAI")."',
					   SARAN					= '".$this->getField("SARAN")."',
					   PEGAWAI_ID_DINILAI		= '".$this->getField("PEGAWAI_ID_DINILAI")."',
					   TYPE_PEGAWAI_DINILAI		= '".$this->getField("TYPE_PEGAWAI_DINILAI")."',
					   PEGAWAI_ID_PENILAI		= '".$this->getField("PEGAWAI_ID_PENILAI")."',
					   TYPE_PEGAWAI_PENILAI		= '".$this->getField("TYPE_PEGAWAI_PENILAI")."',
					   PERTANYAAN_ID			= '".$this->getField("PERTANYAAN_ID")."',
					   PERIODE					= '".$this->getField("PERIODE")."',
					   LAST_UPDATED_BY			= '".$this->getField("LAST_UPDATED_BY")."',
					   LAST_IMPORTED_BY			= '".$this->getField("LAST_IMPORTED_BY")."',
					   STATUS_IMPORT			= '".$this->getField("STATUS_IMPORT")."',
					   LAST_UPDATED_DATE		= SYSDATE 
				WHERE  PERTANYAAN_PERIODE_PEGAWAI_ID	= '".$this->getField("PERTANYAAN_PERIODE_PEGAWAI_ID")."'
			 "; 
		$this->query = $str;
		//echo $str; 
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI
                WHERE 
                  PERTANYAAN_PERIODE_PEGAWAI_ID = ".$this->getField("PERTANYAAN_PERIODE_PEGAWAI_ID").""; 
				  
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
					PERTANYAAN_PERIODE_PEGAWAI_ID, PERTANYAAN_PERIODE_ID, JAWABAN_ID, RANGE_NILAI, PEGAWAI_ID_DINILAI, 
					TYPE_PEGAWAI_DINILAI, PEGAWAI_ID_PENILAI, PERTANYAAN_ID, PERIODE, SARAN,
					LAST_CREATED_DATE, LAST_CREATED_BY, LAST_UPDATED_DATE, LAST_UPDATED_BY
				FROM PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI A			
				WHERE 1 = 1
				"; 
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
				SELECT 
				PERTANYAAN_PERIODE_PEGAWAI_ID, PERTANYAAN_PERIODE_ID, JAWABAN_ID, 
				   RANGE_NILAI, PEGAWAI_ID_DINILAI, PEGAWAI_ID_PENILAI
				FROM PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI				
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PERTANYAAN_PERIODE_PEGAWAI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PERTANYAAN_PERIODE_PEGAWAI_ID) AS ROWCOUNT FROM PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI
		        WHERE PERTANYAAN_PERIODE_PEGAWAI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PERTANYAAN_PERIODE_PEGAWAI_ID) AS ROWCOUNT FROM PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI
		        WHERE PERTANYAAN_PERIODE_PEGAWAI_ID IS NOT NULL ".$statement; 
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