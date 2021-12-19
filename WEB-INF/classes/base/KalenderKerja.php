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
  * Entity-base class untuk mengimplementasikan tabel KALENDER_KERJA.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class KalenderKerja extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KalenderKerja()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KALENDER_KERJA_ID", $this->getNextId("KALENDER_KERJA_ID","KALENDER_KERJA"));

		$str = "
				INSERT INTO KALENDER_KERJA (
				   KALENDER_KERJA_ID, DEPARTEMEN_ID, USER_LOGIN_ID, NAMA, TANGGAL_AWAL, TANGGAL_AKHIR, WARNA, STATUS, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("KALENDER_KERJA_ID").",
				  '".$this->getField("DEPARTEMEN_ID")."',
				  ".$this->getField("USER_LOGIN_ID").",
				  '".$this->getField("NAMA")."',
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  '".$this->getField("WARNA")."',
				  ".$this->getField("STATUS").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KALENDER_KERJA
				SET    
					   DEPARTEMEN_ID    = '".$this->getField("DEPARTEMEN_ID")."',
					   USER_LOGIN_ID	= ".$this->getField("USER_LOGIN_ID").",
					   NAMA				= '".$this->getField("NAMA")."',
					   TANGGAL_AWAL		= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR	= ".$this->getField("TANGGAL_AKHIR").",
					   WARNA			= '".$this->getField("WARNA")."',
					   STATUS			= '".$this->getField("STATUS")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  KALENDER_KERJA_ID     = '".$this->getField("KALENDER_KERJA_ID")."'

			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE KALENDER_KERJA A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE KALENDER_KERJA_ID = ".$this->getField("KALENDER_KERJA_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM KALENDER_KERJA
                WHERE 
                  KALENDER_KERJA_ID = ".$this->getField("KALENDER_KERJA_ID").""; 
				  
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
					KALENDER_KERJA_ID,
					PPI_SIMPEG.AMBIL_NAMA_DEPARTEMEN(A.DEPARTEMEN_ID) DEPARTEMEN,
					USER_LOGIN_ID, 
					   A.NAMA, A.KETERANGAN, TANGGAL_AWAL, 
					   TANGGAL_AKHIR, JAM, WARNA, A.DEPARTEMEN_ID,
					   CASE WHEN A.STATUS = 1 THEN 'Aktif' ELSE 'Non-Aktif' END STATUS
                    FROM KALENDER_KERJA A WHERE KALENDER_KERJA_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TANGGAL_AWAL ASC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	SELECT 
					KALENDER_KERJA_ID, NAMA, DEPARTEMEN_ID, USER_LOGIN_ID, JAM, KETERANGAN, STATUS, JAM_AWAL, JAM_AKHIR, WARNA
					FROM KALENDER_KERJA WHERE KALENDER_KERJA_ID IS NOT NULL
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
		$str = "SELECT COUNT(KALENDER_KERJA_ID) AS ROWCOUNT FROM KALENDER_KERJA A
		        WHERE KALENDER_KERJA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KALENDER_KERJA_ID) AS ROWCOUNT FROM KALENDER_KERJA
		        WHERE KALENDER_KERJA_ID IS NOT NULL ".$statement; 
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