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
  * Entity-base class untuk mengimplementasikan tabel KAPAL_SERTIFIKAT_KAPAL_FILE.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class KapalSertifikatKapalFile extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalSertifikatKapalFile()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_SERTIFIKAT_KAPAL_FILE_ID", $this->getNextId("KAPAL_SERTIFIKAT_KAPAL_FILE_ID","PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL_FILE"));

		$str = "
					INSERT INTO PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL_FILE (
					   KAPAL_SERTIFIKAT_KAPAL_FILE_ID, KAPAL_ID, SERTIFIKAT_KAPAL_ID, NAMA, FILE_UPLOAD, FILE_NAMA, FILE_UKURAN, FILE_FORMAT, LAST_CREATE_USER, LAST_CREATE_DATE)
 			  	VALUES (
				  '".$this->getField("KAPAL_SERTIFIKAT_KAPAL_FILE_ID")."',
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("SERTIFIKAT_KAPAL_ID")."',
				  '".$this->getField("NAMA")."',
				  empty_blob(),
				  '".$this->getField("FILE_NAMA")."',
				  '".$this->getField("FILE_UKURAN")."',
				  '".$this->getField("FILE_FORMAT")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->query = $str;
		$this->id = $this->getField("KAPAL_SERTIFIKAT_KAPAL_FILE_ID");
		//echo $str;
		return $this->execQuery($str);
    }

	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }
	
    function update()
	{
		$str = "
				UPDATE KAPAL_SERTIFIKAT_KAPAL_FILE
				SET    
					   KAPAL_ID          = '".$this->getField("KAPAL_ID")."',
					   SERTIFIKAT_KAPAL_ID= ".$this->getField("SERTIFIKAT_KAPAL_ID").",
					   NAMA= ".$this->getField("NAMA").",
					   FILE_NAMA= ".$this->getField("FILE_NAMA").",
					   FILE_UKURAN= ".$this->getField("FILE_UKURAN")."
				WHERE  KAPAL_SERTIFIKAT_KAPAL_FILE_ID     = '".$this->getField("KAPAL_SERTIFIKAT_KAPAL_FILE_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL_FILE
                WHERE 
                  KAPAL_SERTIFIKAT_KAPAL_FILE_ID = ".$this->getField("KAPAL_SERTIFIKAT_KAPAL_FILE_ID").""; 
				  
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
					KAPAL_SERTIFIKAT_KAPAL_FILE_ID, KAPAL_ID, SERTIFIKAT_KAPAL_ID, NAMA, FILE_UPLOAD, FILE_NAMA, FILE_UKURAN, FILE_FORMAT
					FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL_FILE WHERE KAPAL_SERTIFIKAT_KAPAL_FILE_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KAPAL_ID DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	SELECT 
					KAPAL_SERTIFIKAT_KAPAL_FILE_ID, KAPAL_ID, SERTIFIKAT_KAPAL_ID, NAMA, FILE_NAMA, FILE_UKURAN
					FROM KAPAL_SERTIFIKAT_KAPAL_FILE WHERE KAPAL_SERTIFIKAT_KAPAL_FILE_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_SERTIFIKAT_KAPAL_FILE_ID) AS ROWCOUNT FROM KAPAL_SERTIFIKAT_KAPAL_FILE
		        WHERE KAPAL_SERTIFIKAT_KAPAL_FILE_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_SERTIFIKAT_KAPAL_FILE_ID) AS ROWCOUNT FROM KAPAL_SERTIFIKAT_KAPAL_FILE
		        WHERE KAPAL_SERTIFIKAT_KAPAL_FILE_ID IS NOT NULL ".$statement; 
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