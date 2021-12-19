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

  class Notifikasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Notifikasi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("NOTIFIKASI_ID", $this->getNextId("NOTIFIKASI_ID","NOTIFIKASI")); 

		$str = "
				INSERT INTO NOTIFIKASI (
				   NOTIFIKASI_ID, EMAIL_USER_TERKAIT, KETERANGAN, NAMA, KIRIM_HARI_MINUS) 
  			 	VALUES (
				  ".$this->getField("NOTIFIKASI_ID").",
  				  ".$this->getField("EMAIL_USER_TERKAIT").",
				  '".$this->getField("KETERANGAN")."', 	
    			  '".$this->getField("NAMA")."',
      			  ".$this->getField("KIRIM_HARI_MINUS")."
				  )"; 	
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE NOTIFIKASI
				SET     
					   EMAIL_USER_TERKAIT    = ".$this->getField("EMAIL_USER_TERKAIT").",	
					   KETERANGAN    = '".$this->getField("KETERANGAN")."',
					   NAMA       = '".$this->getField("NAMA")."',
					   KIRIM_HARI_MINUS    = ".$this->getField("KIRIM_HARI_MINUS")."		   
				WHERE  NOTIFIKASI_ID   = ".$this->getField("NOTIFIKASI_ID")."
 				"; 

				$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE NOTIFIKASI A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE NOTIFIKASI_ID = ".$this->getField("NOTIFIKASI_ID")."
				"; 
				$this->query = $str;
	//echo $str;
		return $this->execQuery($str);
    }		
	
	function delete()
	{
        $str = "DELETE FROM NOTIFIKASI_USER_LOGIN
                WHERE 
                  NOTIFIKASI_ID = ".$this->getField("NOTIFIKASI_ID")."
				  "; 
				  
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
		A.NOTIFIKASI_ID, NAMA, KETERANGAN, EMAIL_USER_TERKAIT, KIRIM_HARI_MINUS, AMBIL_NOTIFIKASI_USER_LOGIN(A.NOTIFIKASI_ID) AS NOTIFIKASI_USER_LOGIN, AMBIL_NOTIFIKASI_USER_LOGIN_ID(A.NOTIFIKASI_ID) AS NOTIFIKASI_USER_LOGIN_ID
		FROM PPI.NOTIFIKASI A
		WHERE 1=1 "; 
		//
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
		A.NOTIFIKASI_ID, NAMA, KETERANGAN, EMAIL_USER_TERKAIT, KIRIM_HARI_MINUS
		FROM NOTIFIKASI A
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
		$str = "SELECT COUNT(NOTIFIKASI_ID) AS ROWCOUNT FROM NOTIFIKASI A WHERE NOTIFIKASI_ID IS NOT NULL ".$stat; 
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
	
    function getNotifikasiBatas($param="")
	{
		$str = "SELECT KIRIM_HARI_MINUS FROM NOTIFIKASI A WHERE NAMA = '".$param."' ".$stat; 
		
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("KIRIM_HARI_MINUS"); 
		else 
			return 0; 
    }	

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(NOTIFIKASI_ID) AS ROWCOUNT FROM NOTIFIKASI A WHERE NOTIFIKASI_ID IS NOT NULL "; 
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