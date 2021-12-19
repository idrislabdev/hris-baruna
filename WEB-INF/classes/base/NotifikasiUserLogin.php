<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class NotifikasiUserLogin extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function NotifikasiUserLogin()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO NOTIFIKASI_USER_LOGIN (
				   NOTIFIKASI_ID, USER_LOGIN_ID) 
  			 	VALUES (
				  ".$this->getField("NOTIFIKASI_ID").",
  				  ".$this->getField("USER_LOGIN_ID")."
				  )"; 	
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE NOTIFIKASI_USER_LOGIN
				SET     
					   EMAIL_USER_TERKAIT    = ".$this->getField("EMAIL_USER_TERKAIT").",	
					   KETERANGAN    = '".$this->getField("KETERANGAN")."',
					   NAMA       = '".$this->getField("NAMA")."',
					   KIRIM_HARI_MINUS    = ".$this->getField("KIRIM_HARI_MINUS")."		   
				WHERE  NOTIFIKASI_USER_LOGIN_ID   = ".$this->getField("NOTIFIKASI_USER_LOGIN_ID")."
 				"; 

				$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE NOTIFIKASI_USER_LOGIN A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE NOTIFIKASI_USER_LOGIN_ID = ".$this->getField("NOTIFIKASI_USER_LOGIN_ID")."
				"; 
				$this->query = $str;
	//echo $str;
		return $this->execQuery($str);
    }		
	
	function delete()
	{
        $str = "DELETE FROM NOTIFIKASI_USER_LOGIN_USER_LOGIN
                WHERE 
                  NOTIFIKASI_USER_LOGIN_ID = ".$this->getField("NOTIFIKASI_USER_LOGIN_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","TANGGAL"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder='ORDER BY NAMA ASC')
	{
		$str = "
		SELECT 
		A.NOTIFIKASI_USER_LOGIN_ID, NAMA, KETERANGAN, EMAIL_USER_TERKAIT, KIRIM_HARI_MINUS
		FROM PPI.NOTIFIKASI_USER_LOGIN A
		WHERE 1=1 "; 
		//, PPI.AMBIL_NOTIFIKASI_USER_LOGIN_USER_LOGIN_ID(A.NOTIFIKASI_USER_LOGIN_ID) NOTIFIKASI_USER_LOGIN_USER_LOGIN
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT 
		A.NOTIFIKASI_USER_LOGIN_ID, NAMA, KETERANGAN, EMAIL_USER_TERKAIT, KIRIM_HARI_MINUS
		FROM NOTIFIKASI_USER_LOGIN A
		WHERE 1=1"; 
		
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
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","TANGGAL"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(),$stat="")
	{
		$str = "SELECT COUNT(NOTIFIKASI_USER_LOGIN_ID) AS ROWCOUNT FROM NOTIFIKASI_USER_LOGIN A WHERE NOTIFIKASI_USER_LOGIN_ID IS NOT NULL ".$stat; 
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

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(NOTIFIKASI_USER_LOGIN_ID) AS ROWCOUNT FROM NOTIFIKASI_USER_LOGIN A WHERE NOTIFIKASI_USER_LOGIN_ID IS NOT NULL "; 
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