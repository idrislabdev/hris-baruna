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
  * Entity-base class untuk mengimplementasikan tabel HASIL_RAPAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class HasilRapat extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function HasilRapat()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("HASIL_RAPAT_ID", $this->getNextId("HASIL_RAPAT_ID","HASIL_RAPAT"));

		$str = "
					INSERT INTO HASIL_RAPAT (
					   HASIL_RAPAT_ID, NAMA, USER_LOGIN_ID, TANGGAL, KETERANGAN, STATUS, DEPARTEMEN_ID, LAST_CREATE_USER, LAST_CREATE_DATE)
 			  	VALUES (
				  '".$this->getField("HASIL_RAPAT_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("USER_LOGIN_ID")."',
				  ".$this->getField("TANGGAL").",
				  '".$this->getField("KETERANGAN")."',
				  1,
				  '".$this->getField("DEPARTEMEN_ID")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		//echo $str;
		$this->id = $this->getField("HASIL_RAPAT_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE HASIL_RAPAT
				SET    
					   NAMA          	= '".$this->getField("NAMA")."',
					   USER_LOGIN_ID	= '".$this->getField("USER_LOGIN_ID")."',
					   DEPARTEMEN_ID	= '".$this->getField("DEPARTEMEN_ID")."',
					   TANGGAL			= ".$this->getField("TANGGAL").",
					   KETERANGAN		= '".$this->getField("KETERANGAN")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  HASIL_RAPAT_ID    = '".$this->getField("HASIL_RAPAT_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE HASIL_RAPAT A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE HASIL_RAPAT_ID = ".$this->getField("HASIL_RAPAT_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM HASIL_RAPAT
                WHERE 
                  HASIL_RAPAT_ID = ".$this->getField("HASIL_RAPAT_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteAttachment()
	{
        $str = "DELETE FROM HASIL_RAPAT_ATTACHMENT
                WHERE 
                  HASIL_RAPAT_ID = ".$this->getField("HASIL_RAPAT_ID").""; 
				  
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
					HASIL_RAPAT_ID, A.NAMA, 
					AMBIL_PUSAT_HASIL_RAPAT(DEPARTEMEN_ID) || AMBIL_DEPARTEMEN_HASIL_RAPAT(A.HASIL_RAPAT_ID) DEPARTEMEN, 
					AMBIL_JABATAN_HASIL_RAPAT(A.HASIL_RAPAT_ID) JABATAN,
					USER_LOGIN_ID, TANGGAL, 
					AMBIL_HASIL_RAPAT_ATTACHMENT(HASIL_RAPAT_ID) KETERANGAN, CASE WHEN STATUS = 1 THEN 'Aktif' ELSE 'Non-Aktif' END STATUS, A.DEPARTEMEN_ID
					FROM HASIL_RAPAT A WHERE HASIL_RAPAT_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ORDER BY TANGGAL DESC";

		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
    function selectByParamsAndroid($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
					SELECT 
					HASIL_RAPAT_ID, A.NAMA,
					USER_LOGIN_ID, TANGGAL, 
                    CASE WHEN NVL((SELECT COUNT(HASIL_RAPAT_ID) FROM HASIL_RAPAT_ATTACHMENT X WHERE X.HASIL_RAPAT_ID = A.HASIL_RAPAT_ID), 0) = 1 THEN 
                    (SELECT HASIL_RAPAT_ATTACHMENT_ID FROM HASIL_RAPAT_ATTACHMENT X WHERE X.HASIL_RAPAT_ID = A.HASIL_RAPAT_ID) ELSE 0 END HASIL_RAPAT_ATTACHMENT_ID
					FROM HASIL_RAPAT A WHERE HASIL_RAPAT_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ORDER BY TANGGAL DESC";
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	SELECT 
					HASIL_RAPAT_ID, NAMA, DEPARTEMEN_ID, USER_LOGIN_ID, TANGGAL, KETERANGAN, STATUS
					FROM HASIL_RAPAT WHERE HASIL_RAPAT_ID IS NOT NULL
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
		$str = "SELECT COUNT(HASIL_RAPAT_ID) AS ROWCOUNT FROM HASIL_RAPAT A
		        WHERE HASIL_RAPAT_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(HASIL_RAPAT_ID) AS ROWCOUNT FROM HASIL_RAPAT
		        WHERE HASIL_RAPAT_ID IS NOT NULL ".$statement; 
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