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
  * Entity-base class untuk mengimplementasikan tabel AGENDA.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class BackupDatabase extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function BackupDatabase()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("BACKUP_DATABASE_ID", $this->getNextId("BACKUP_DATABASE_ID","BACKUP_DATABASE")); 		

		$str = "
				INSERT INTO BACKUP_DATABASE (
				   BACKUP_DATABASE_ID, FITUR, MENU, TANGGAL, 
				   SCHEMA_NAMA, FILE_NAMA, HARIAN, 
				   BULANAN, TAHUNAN) 
 			  	VALUES (
				  ".$this->getField("BACKUP_DATABASE_ID").",
				  '".$this->getField("FITUR")."',
				  '".$this->getField("MENU")."',
   				  ".$this->getField("TANGGAL").",
				  '".$this->getField("SCHEMA_NAMA")."',
				  '".$this->getField("FILE_NAMA")."',
				  '".$this->getField("HARIAN")."',
				  '".$this->getField("BULANAN")."',
				  '".$this->getField("TAHUNAN")."'
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE BACKUP_DATABASE
				SET    FITUR 		= '".$this->getField("FITUR")."',
					   MENU 		= '".$this->getField("MENU")."',
					   TANGGAL 		= ".$this->getField("TANGGAL").",
					   SCHEMA_NAMA  = '".$this->getField("SCHEMA_NAMA")."',
					   FILE_NAMA    = '".$this->getField("FILE_NAMA")."',
					   HARIAN    	= '".$this->getField("HARIAN")."',
					   BULANAN		= '".$this->getField("BULANAN")."',
					   TAHUNAN		= '".$this->getField("TAHUNAN")."'
				WHERE  BACKUP_DATABASE_ID    = '".$this->getField("BACKUP_DATABASE_ID")."'

			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE BACKUP_DATABASE A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE BACKUP_DATABASE_ID = ".$this->getField("BACKUP_DATABASE_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM BACKUP_DATABASE
                WHERE 
                  BACKUP_DATABASE_ID = ".$this->getField("BACKUP_DATABASE_ID").""; 
				  
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
				BACKUP_DATABASE_ID, FITUR, MENU, TANGGAL, 
				   SCHEMA_NAMA, FILE_NAMA, HARIAN, 
				   BULANAN, TAHUNAN
				FROM BACKUP_DATABASE A 
				WHERE BACKUP_DATABASE_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY BACKUP_DATABASE_ID DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				BACKUP_DATABASE_ID, FITUR, MENU, TANGGAL, 
				   SCHEMA_NAMA, FILE_NAMA, HARIAN, 
				   BULANAN, TAHUNAN
				FROM BACKUP_DATABASE A 
				WHERE BACKUP_DATABASE_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY BACKUP_DATABASE_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(BACKUP_DATABASE_ID) AS ROWCOUNT FROM BACKUP_DATABASE A
		        WHERE BACKUP_DATABASE_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(BACKUP_DATABASE_ID) AS ROWCOUNT FROM BACKUP_DATABASE A
		        WHERE BACKUP_DATABASE_ID IS NOT NULL ".$statement; 
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