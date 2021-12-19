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

  class AbsensiImport extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AbsensiImport()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_ABSENSI.ABSENSI_IMPORT
				(FINGER_ID, JAM, STATUS, USER_LOGIN_ID, LAST_CREATE_USER, LAST_CREATE_DATE, MESIN_ID)
				VALUES(
					  ".$this->getField("FINGER_ID").",
					  ".$this->getField("JAM").",
					  '".$this->getField("STATUS")."',
					  ".$this->getField("USER_LOGIN_ID").",
					  '".$this->getField("LAST_CREATE_USER")."',
					  ".$this->getField("LAST_CREATE_DATE").",
					  '".$this->getField("MESIN_ID")."'
				)"; 
		$this->id = $this->getField("ABSENSI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_ABSENSI.ABSENSI_IMPORT
                WHERE 
                  USER_LOGIN_ID = ".$this->getField("USER_LOGIN_ID")."
				  AND STATUS = 0
				  "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				FINGER_ID, JAM, STATUS
				FROM PPI_ABSENSI.ABSENSI_IMPORT
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
	
	function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				A.FINGER_ID, JAM, STATUS, B.NRP NRP, B.NAMA NAMA, C.NAMA DEPARTEMEN, TO_CHAR(JAM, 'DD-MM-YYYY') || ' ' || TO_CHAR(JAM, 'HH24:MI') AS JAM_MONITORING
				FROM PPI_ABSENSI.ABSENSI_IMPORT A
				LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.FINGER_ID = B.FINGER_ID
				LEFT JOIN PPI_SIMPEG.DEPARTEMEN C ON B.DEPARTEMEN_ID=C.DEPARTEMEN_ID
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
				SELECT 
				FINGER_ID, JAM, STATUS
				FROM PPI_ABSENSI.ABSENSI_IMPORT
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY FINGER_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "
		SELECT COUNT(1) AS ROWCOUNT 
		FROM PPI_ABSENSI.ABSENSI_IMPORT A 
		LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.FINGER_ID = B.FINGER_ID
		LEFT JOIN PPI_SIMPEG.DEPARTEMEN C ON B.DEPARTEMEN_ID=C.DEPARTEMEN_ID
		WHERE 1 = 1 ".$statement; 
		
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
	
	function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(FINGER_ID) AS ROWCOUNT FROM PPI_ABSENSI.ABSENSI_IMPORT WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(FINGER_ID) AS ROWCOUNT FROM PPI_ABSENSI.ABSENSI_IMPORT WHERE 1 = 1 "; 
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