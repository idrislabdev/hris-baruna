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
  * Entity-base class untuk mengimplementasikan tabel HASIL_RAPAT_ATTACHMENT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class HasilRapatAttachment extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function HasilRapatAttachment()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("HASIL_RAPAT_ATTACHMENT_ID", $this->getNextId("HASIL_RAPAT_ATTACHMENT_ID","HASIL_RAPAT_ATTACHMENT"));

		$str = "
					INSERT INTO HASIL_RAPAT_ATTACHMENT (
					   HASIL_RAPAT_ATTACHMENT_ID, NAMA, HASIL_RAPAT_ID, FILE_UPLOAD, FILE_NAMA, UKURAN, FORMAT)
 			  	VALUES (
				  '".$this->getField("HASIL_RAPAT_ATTACHMENT_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("HASIL_RAPAT_ID")."',
				  empty_blob(),
				  '".$this->getField("FILE_NAMA")."',
				  '".$this->getField("UKURAN")."',
				  '".$this->getField("FORMAT")."'
				)"; 
		$this->query = $str;
		$this->id = $this->getField("HASIL_RAPAT_ATTACHMENT_ID");
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
				UPDATE HASIL_RAPAT_ATTACHMENT
				SET    
					   NAMA          = '".$this->getField("NAMA")."',
					   HASIL_RAPAT_ID= ".$this->getField("HASIL_RAPAT_ID").",
					   FILE_UPLOAD= ".$this->getField("FILE_UPLOAD").",
					   UKURAN= ".$this->getField("UKURAN").",
					   FORMAT= ".$this->getField("FORMAT")."
				WHERE  HASIL_RAPAT_ATTACHMENT_ID     = '".$this->getField("HASIL_RAPAT_ATTACHMENT_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM HASIL_RAPAT_ATTACHMENT
                WHERE 
                  HASIL_RAPAT_ATTACHMENT_ID = ".$this->getField("HASIL_RAPAT_ATTACHMENT_ID").""; 
				  
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
					HASIL_RAPAT_ATTACHMENT_ID, NAMA, HASIL_RAPAT_ID, FILE_UPLOAD, FILE_NAMA, UKURAN, FORMAT
					FROM HASIL_RAPAT_ATTACHMENT WHERE HASIL_RAPAT_ATTACHMENT_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY NAMA DESC";
		
	
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	SELECT 
					HASIL_RAPAT_ATTACHMENT_ID, NAMA, HASIL_RAPAT_ID, FILE_UPLOAD, UKURAN, FORMAT
					FROM HASIL_RAPAT_ATTACHMENT WHERE HASIL_RAPAT_ATTACHMENT_ID IS NOT NULL
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
		$str = "SELECT COUNT(HASIL_RAPAT_ATTACHMENT_ID) AS ROWCOUNT FROM HASIL_RAPAT_ATTACHMENT
		        WHERE HASIL_RAPAT_ATTACHMENT_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(HASIL_RAPAT_ATTACHMENT_ID) AS ROWCOUNT FROM HASIL_RAPAT_ATTACHMENT
		        WHERE HASIL_RAPAT_ATTACHMENT_ID IS NOT NULL ".$statement; 
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