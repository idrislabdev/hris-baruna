<? 
/* *******************************************************************************************************
MODUL NAME 			: IMASYS
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

  class Agenda extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Agenda()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("AGENDA_ID", $this->getNextId("AGENDA_ID","PPI_ASSET.AGENDA")); 		

		$str = "
				INSERT INTO PPI_ASSET.AGENDA (
				   AGENDA_ID, DEPARTEMEN_ID, USER_LOGIN_ID, NAMA, TANGGAL, KETERANGAN, STATUS, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("AGENDA_ID").",
				  ".$this->getField("DEPARTEMEN_ID").",
  				  ".$this->getField("USER_LOGIN_ID").",
				  '".$this->getField("NAMA")."',
   				  ".$this->getField("TANGGAL").",
				  '".$this->getField("KETERANGAN")."',
				  ".$this->getField("STATUS").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_ASSET.AGENDA
				SET    DEPARTEMEN_ID 	= ".$this->getField("DEPARTEMEN_ID").",
					   USER_LOGIN_ID 	= '".$this->getField("USER_LOGIN_ID")."',
					   NAMA          	= '".$this->getField("NAMA")."',
					   TANGGAL       	= ".$this->getField("TANGGAL").",
					   KETERANGAN    	= '".$this->getField("KETERANGAN")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."					   
				WHERE  AGENDA_ID     = '".$this->getField("AGENDA_ID")."'

			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ASSET.AGENDA A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE AGENDA_ID = ".$this->getField("AGENDA_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.AGENDA
                WHERE 
                  AGENDA_ID = ".$this->getField("AGENDA_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.AGENDA_ID DESC ")
	{
		$str = "
					SELECT 
						   A.AGENDA_ID, A.NAMA, A.DEPARTEMEN_ID,
						   pds_simpeg.AMBIL_NAMA_DEPARTEMEN(A.DEPARTEMEN_ID) DEPARTEMEN,
						   TO_CHAR(A.TANGGAL, 'YYYY-MM-DD') TANGGAL, A.KETERANGAN, 
						   A.FILE_UPLOAD, CASE WHEN A.STATUS = 1 THEN 'Aktif' ELSE 'Non-aktif' END STATUS
					FROM PPI_ASSET.AGENDA A WHERE AGENDA_ID IS NOT NULL
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
		$str = "	SELECT 
						   AGENDA_ID, DEPARTEMEN_ID, USER_LOGIN_ID, 
						   NAMA, TANGGAL, KETERANGAN, 
						   FILE_UPLOAD, STATUS
					FROM PPI_ASSET.AGENDA A WHERE AGENDA_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY A.NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(AGENDA_ID) AS ROWCOUNT FROM PPI_ASSET.AGENDA A
		        WHERE AGENDA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(AGENDA_ID) AS ROWCOUNT FROM PPI_ASSET.AGENDA A
		        WHERE AGENDA_ID IS NOT NULL ".$statement; 
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