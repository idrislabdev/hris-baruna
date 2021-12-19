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

  class Absensi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Absensi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ABSENSI_ID", $this->getNextId("ABSENSI_ID","PPI_ABSENSI.ABSENSI")); 
		$str = "
				INSERT INTO PPI_ABSENSI.ABSENSI (
				   ABSENSI_ID, PEGAWAI_ID, DEPARTEMEN_ID, JAM, 
				   STATUS, VALIDASI, LAST_CREATE_USER, LAST_CREATE_DATE)    
				VALUES(
					  ".$this->getField("ABSENSI_ID").",
					  '".$this->getField("PEGAWAI_ID")."',
					  '".$this->getField("DEPARTEMEN_ID")."',
					  ".$this->getField("JAM").",
					  '".$this->getField("STATUS")."',
					  '".$this->getField("VALIDASI")."',
				  	  '".$this->getField("LAST_CREATE_USER")."',
				      ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("ABSENSI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function insertImport()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ABSENSI_ID", $this->getNextId("ABSENSI_ID","PPI_ABSENSI.ABSENSI")); 
		$str = "
				INSERT INTO PPI_ABSENSI.ABSENSI (
				   ABSENSI_ID, PEGAWAI_ID, DEPARTEMEN_ID, JAM, 
				   STATUS, VALIDASI, LAST_CREATE_USER, LAST_CREATE_DATE, MESIN_ID)    
				  SELECT NVL((SELECT MAX(ABSENSI_ID) FROM PPI_ABSENSI.ABSENSI X), 0) + ROWNUM, B.PEGAWAI_ID, 
				  B.DEPARTEMEN_ID, A.JAM, STATUS, 1, 'IMPORT', SYSDATE, MESIN_ID FROM PPI_ABSENSI.ABSENSI_IMPORT A
				  INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.FINGER_ID = B.FINGER_ID WHERE USER_LOGIN_ID = '".$this->getField("USER_LOGIN_ID")."'  
				"; 
		$this->id = $this->getField("ABSENSI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PPI_ABSENSI.ABSENSI
			   SET 
			   		PEGAWAI_ID  		= '".$this->getField("PEGAWAI_ID")."',
			   		DEPARTEMEN_ID  		= '".$this->getField("DEPARTEMEN_ID")."',
				   	JAM					= ".$this->getField("JAM").",
				   	STATUS				= '".$this->getField("STATUS")."',
				   	VALIDASI			= '".$this->getField("VALIDASI")."',
				   	VALIDATOR			= '".$this->getField("VALIDATOR")."',
					LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
			 WHERE ABSENSI_ID 			= ".$this->getField("ABSENSI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ABSENSI.ABSENSI A SET
				  ".$this->getField("FIELD")." 		= '".$this->getField("FIELD_VALUE")."',
				  ".$this->getField("FIELD_VALIDATOR")." 	= '".$this->getField("FIELD_VALUE_VALIDATOR")."'
				WHERE ABSENSI_ID = ".$this->getField("ABSENSI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }	
	
	function delete()
	{
        $str = "DELETE FROM PPI_ABSENSI.ABSENSI
                WHERE 
                  ABSENSI_ID = ".$this->getField("ABSENSI_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
    function deleteAbsensiImport()
	{
        $str = "DELETE FROM PPI_ABSENSI.ABSENSI_IMPORT "; 
				  
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
				ABSENSI_ID, PEGAWAI_ID, JAM, STATUS, VALIDASI, VALIDATOR
				FROM PPI_ABSENSI.ABSENSI
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
	
    function selectByParamsFingerScan($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="", $tanggal="", $mesin="")
	{
		$str = "
                SELECT NRP, NAMA, PPI_SIMPEG.AMBIL_UNIT_KERJA(DEPARTEMEN_ID) DEPARTEMEN, 
				";
				$arrMesin = explode(",", $mesin);
				for($i=0;$i<count($arrMesin);$i++)
				{
					$str .= "
					  PPI_ABSENSI.AMBIL_JAM_ABSENSI(PEGAWAI_ID, TO_DATE('".$tanggal."', 'DDMMYYYY'), 'I', '".$arrMesin[$i]."') JAM_MASUK_".$arrMesin[$i].", 
					  PPI_ABSENSI.AMBIL_JAM_ABSENSI(PEGAWAI_ID, TO_DATE('".$tanggal."', 'DDMMYYYY'), 'O', '".$arrMesin[$i]."') JAM_PULANG_".$arrMesin[$i].",
					  ";
				}
		$str .= " 
				1
				FROM PPI_SIMPEG.PEGAWAI A 
				WHERE EXISTS(SELECT 1 FROM PPI_ABSENSI.ABSENSI X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID AND TO_CHAR(JAM, 'DDMMYYYY') = '".$tanggal."')
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
    }	

	
    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
                SELECT A.ABSENSI_ID ABSENSI_ID, A.PEGAWAI_ID PEGAWAI_ID, B.NRP NRP, B.NAMA NAMA, C.DEPARTEMEN_ID DEPARTEMEN_ID, C.NAMA DEPARTEMEN, STATUS, 
                TO_CHAR(JAM, 'HH24:MI') AS JAM, TO_CHAR(JAM, 'DD-MM-YYYY') AS TANGGAL,VALIDASI, B.FOTO FOTO, VALIDATOR
                    FROM PPI_ABSENSI.ABSENSI A, PPI_SIMPEG.PEGAWAI B, PPI_SIMPEG.DEPARTEMEN C 
                    WHERE A.PEGAWAI_ID = B.PEGAWAI_ID AND B.DEPARTEMEN_ID=C.DEPARTEMEN_ID 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT 
				ABSENSI_ID, PEGAWAI_ID, JAM, 
				   STATUS
				FROM PPI_ABSENSI.ABSENSI
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY ABSENSI_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(ABSENSI_ID) AS ROWCOUNT FROM PPI_ABSENSI.ABSENSI WHERE 1 = 1 ".$statement; 
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

    function getCountByParamsFingerScan($paramsArray=array(), $statement="", $tanggal="", $mesin="")
	{
		$str = "SELECT COUNT(NRP) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI A 
				WHERE EXISTS(SELECT 1 FROM PPI_ABSENSI.ABSENSI X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID AND TO_CHAR(JAM, 'DDMMYYYY') = '".$tanggal."') ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

				
    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(ABSENSI_ID) AS ROWCOUNT FROM PPI_ABSENSI.ABSENSI WHERE 1 = 1 "; 
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