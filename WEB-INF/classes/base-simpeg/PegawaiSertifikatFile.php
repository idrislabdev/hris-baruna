<? 
/* *******************************************************************************************************
MODUL NAME 			: PEL
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_SERTIFIKAT_FILE.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiSertifikatFile extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiSertifikatFile()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_SERTIFIKAT_FILE_ID", $this->getNextId("PEGAWAI_SERTIFIKAT_FILE_ID","PPI_SIMPEG.PEGAWAI_SERTIFIKAT_FILE"));

		$str = "
					INSERT INTO PPI_SIMPEG.PEGAWAI_SERTIFIKAT_FILE (
					   PEGAWAI_SERTIFIKAT_FILE_ID, PEGAWAI_SERTIFIKAT_ID, NAMA, FILE_UPLOAD, FILE_NAMA, FILE_UKURAN, FILE_FORMAT)
 			  	VALUES (
				  '".$this->getField("PEGAWAI_SERTIFIKAT_FILE_ID")."',
				  '".$this->getField("PEGAWAI_SERTIFIKAT_ID")."',
				  '".$this->getField("NAMA")."',
				  empty_blob(),
				  '".$this->getField("FILE_NAMA")."',
				  '".$this->getField("FILE_UKURAN")."',
				  '".$this->getField("FILE_FORMAT")."'
				)"; 
		$this->query = $str;
		$this->id = $this->getField("PEGAWAI_SERTIFIKAT_FILE_ID");
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
				UPDATE PEGAWAI_SERTIFIKAT_FILE
				SET    
					   PEGAWAI_SERTIFIKAT_ID          = '".$this->getField("PEGAWAI_SERTIFIKAT_ID")."',
					   NAMA= ".$this->getField("NAMA").",
					   FILE_NAMA= ".$this->getField("FILE_NAMA").",
					   FILE_UKURAN= ".$this->getField("FILE_UKURAN")."
				WHERE  PEGAWAI_SERTIFIKAT_FILE_ID     = '".$this->getField("PEGAWAI_SERTIFIKAT_FILE_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_SERTIFIKAT_FILE
                WHERE 
                  PEGAWAI_SERTIFIKAT_FILE_ID = ".$this->getField("PEGAWAI_SERTIFIKAT_FILE_ID").""; 
				  
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
					PEGAWAI_SERTIFIKAT_FILE_ID, PEGAWAI_SERTIFIKAT_ID, NAMA, FILE_UPLOAD, FILE_NAMA, FILE_UKURAN, FILE_FORMAT
					FROM PPI_SIMPEG.PEGAWAI_SERTIFIKAT_FILE WHERE PEGAWAI_SERTIFIKAT_FILE_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY PEGAWAI_SERTIFIKAT_ID DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	SELECT 
					PEGAWAI_SERTIFIKAT_FILE_ID, PEGAWAI_SERTIFIKAT_ID, NAMA, FILE_NAMA, FILE_UKURAN
					FROM PEGAWAI_SERTIFIKAT_FILE WHERE PEGAWAI_SERTIFIKAT_FILE_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PEGAWAI_SERTIFIKAT_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_SERTIFIKAT_FILE_ID) AS ROWCOUNT FROM PEGAWAI_SERTIFIKAT_FILE
		        WHERE PEGAWAI_SERTIFIKAT_FILE_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_SERTIFIKAT_FILE_ID) AS ROWCOUNT FROM PEGAWAI_SERTIFIKAT_FILE
		        WHERE PEGAWAI_SERTIFIKAT_FILE_ID IS NOT NULL ".$statement; 
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