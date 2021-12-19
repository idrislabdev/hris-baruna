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
  * Entity-base class untuk mengimplementasikan tabel PANGKAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class DokumenAttachment extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function DokumenAttachment()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("DOKUMEN_ATTACHMENT_ID", $this->getNextId("DOKUMEN_ATTACHMENT_ID","PPI_HUKUM.DOKUMEN_ATTACHMENT"));
		$str = "
				INSERT INTO PPI_HUKUM.DOKUMEN_ATTACHMENT (
				   DOKUMEN_ATTACHMENT_ID, DOKUMEN_ID, NAMA, 
				   FILE_UPLOAD, FILE_NAMA, UKURAN, 
				   FORMAT) 
				VALUES (
				  ".$this->getField("DOKUMEN_ATTACHMENT_ID").",
				  '".$this->getField("DOKUMEN_ID")."',
				  '".$this->getField("NAMA")."',
				  empty_blob(),
				  '".$this->getField("FILE_NAMA")."',
				  '".$this->getField("UKURAN")."',
				  '".$this->getField("FORMAT")."'
				)"; 
				
		$this->id = $this->getField("DOKUMEN_ATTACHMENT_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }

    function update()
	{
		$str = "
				UPDATE PPI_HUKUM.DOKUMEN_ATTACHMENT
				SET    DOKUMEN_ID            = '".$this->getField("DOKUMEN_ID")."',
					   NAMA                  = '".$this->getField("NAMA")."',
					   FILE_UPLOAD           = '".$this->getField("FILE_UPLOAD")."',
					   FILE_NAMA             = '".$this->getField("FILE_NAMA")."',
					   UKURAN                = '".$this->getField("UKURAN")."',
					   FORMAT                = '".$this->getField("FORMAT")."'
				WHERE  DOKUMEN_ATTACHMENT_ID = '".$this->getField("DOKUMEN_ATTACHMENT_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_HUKUM.DOKUMEN_ATTACHMENT
                WHERE 
                  DOKUMEN_ATTACHMENT_ID = ".$this->getField("DOKUMEN_ATTACHMENT_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT DOKUMEN_ATTACHMENT_ID, DOKUMEN_ID, NAMA, 
				   FILE_UPLOAD, FILE_NAMA, UKURAN, 
				   FORMAT
				FROM PPI_HUKUM.DOKUMEN_ATTACHMENT
				WHERE 1 = 1
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
				SELECT DOKUMEN_ATTACHMENT_ID, DOKUMEN_ID, NAMA, 
				   FILE_UPLOAD, FILE_NAMA, UKURAN, 
				   FORMAT
				FROM PPI_HUKUM.DOKUMEN_ATTACHMENT
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY DOKUMEN_ATTACHMENT_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(DOKUMEN_ATTACHMENT_ID) AS ROWCOUNT FROM PPI_HUKUM.DOKUMEN_ATTACHMENT
		        WHERE DOKUMEN_ATTACHMENT_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(DOKUMEN_ATTACHMENT_ID) AS ROWCOUNT FROM PPI_HUKUM.DOKUMEN_ATTACHMENT
		        WHERE DOKUMEN_ATTACHMENT_ID IS NOT NULL ".$statement; 
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