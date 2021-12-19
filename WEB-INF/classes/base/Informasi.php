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
  * Entity-base class untuk mengimplementasikan tabel INFORMASI.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Informasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Informasi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("INFORMASI_ID", $this->getNextId("INFORMASI_ID","INFORMASI"));

		$str = "
				INSERT INTO INFORMASI (
				   INFORMASI_ID, DEPARTEMEN_ID, USER_LOGIN_ID, NAMA, NAMA_INGGRIS, TANGGAL, KETERANGAN, KETERANGAN_INGGRIS, STATUS, STATUS_PUBLISH, INFORMASI_ID_WEBSITE, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("INFORMASI_ID").",
				  '".$this->getField("DEPARTEMEN_ID")."',
				  ".$this->getField("USER_LOGIN_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("NAMA_INGGRIS")."',
				  ".$this->getField("TANGGAL").",
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("KETERANGAN_INGGRIS")."',
				  '".$this->getField("STATUS")."',
				  '".$this->getField("STATUS_PUBLISH")."',
				  '".$this->getField("INFORMASI_ID_WEBSITE")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("INFORMASI_ID");		
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE INFORMASI
				SET    
					   DEPARTEMEN_ID	= '".$this->getField("DEPARTEMEN_ID")."',
					   USER_LOGIN_ID	= ".$this->getField("USER_LOGIN_ID").",
					   NAMA				= '".$this->getField("NAMA")."',
					   NAMA_INGGRIS		= '".$this->getField("NAMA_INGGRIS")."',
					   TANGGAL			= ".$this->getField("TANGGAL").",
					   KETERANGAN		= '".$this->getField("KETERANGAN")."',
					   KETERANGAN_INGGRIS	= '".$this->getField("KETERANGAN_INGGRIS")."',
					   STATUS			= '".$this->getField("STATUS")."',
					   STATUS_PUBLISH	= '".$this->getField("STATUS_PUBLISH")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."					   
				WHERE  INFORMASI_ID     = '".$this->getField("INFORMASI_ID")."'

			 ";
		$this->id = $this->getField("INFORMASI_ID");	  
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	function updateIdWeb(){
		$str = "
				UPDATE INFORMASI
				SET    
					INFORMASI_ID_WEBSITE	= '".$this->getField("INFORMASI_ID_WEBSITE")."'
				WHERE  INFORMASI_ID     = '".$this->getField("INFORMASI_ID")."'

			 ";  
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
	}
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE INFORMASI A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE INFORMASI_ID = ".$this->getField("INFORMASI_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function update_file()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE INFORMASI SET
				  LINK_FOTO = '".$this->getField("LINK_FOTO")."'
				WHERE INFORMASI_ID = '".$this->getField("INFORMASI_ID")."'
				"; 
				$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM INFORMASI
                WHERE 
                  INFORMASI_ID = ".$this->getField("INFORMASI_ID").""; 
				  
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
					SELECT   INFORMASI_ID, A.NAMA,  B.NAMA USER_LOGIN,
						 A.USER_LOGIN_ID, TO_CHAR (TANGGAL, 'DD-MM-YYYY') AS TANGGAL_INPUT,
						 TANGGAL, A.KETERANGAN, 
						 LINK_FOTO, FILE_UPLOAD,
						 PPI_SIMPEG.AMBIL_NAMA_DEPARTEMEN (A.DEPARTEMEN_ID) DEPARTEMEN,
						 A.DEPARTEMEN_ID, 
						 CASE
							WHEN A.STATUS = 1
							   THEN 'AKTIF'
							ELSE 'NON-AKTIF'
						 END STATUS
					FROM INFORMASI A LEFT JOIN USER_LOGIN B ON A.USER_LOGIN_ID = B.USER_LOGIN_ID
				   WHERE INFORMASI_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TANGGAL DESC";
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsSeputarDepartemen($departemen_id, $limit=-1,$from=-1, $statement="")
	{
		$str = "
					SELECT INFORMASI_ID ID, 'info-terbaru' GROUP_STYLE, A.NAMA, TO_CHAR(TANGGAL, 'YYYY-MM-DD HH24:MI:SS') TANGGAL, dbms_lob.substr(KETERANGAN, 100, 1) KETERANGAN, B.NAMA USER_LOGIN FROM INFORMASI A 
					LEFT JOIN USER_LOGIN B ON A.USER_LOGIN_ID = B.USER_LOGIN_ID WHERE A.DEPARTEMEN_ID LIKE '".$departemen_id."%' AND A.STATUS = 1
					UNION ALL
					SELECT HASIL_RAPAT_ID ID, 'hasil-rapat' GROUP_STYLE, NAMA, TO_CHAR(TANGGAL, 'YYYY-MM-DD HH24:MI:SS') TANGGAL, AMBIL_HASIL_RAPAT_ATTACHMENT(HASIL_RAPAT_ID), '' USER_LOGIN FROM HASIL_RAPAT WHERE DEPARTEMEN_ID LIKE '".$departemen_id."%' AND STATUS = 1
					UNION ALL
					SELECT AGENDA_ID ID, 'agenda-kegiatan' GROUP_STYLE, NAMA, TO_CHAR(TANGGAL, 'YYYY-MM-DD HH24:MI:SS') TANGGAL, dbms_lob.substr(KETERANGAN, 100, 1) KETERANGAN, '' USER_LOGIN FROM AGENDA WHERE DEPARTEMEN_ID LIKE '".$departemen_id."%' AND STATUS = 1
				"; 
		
		$str .= $statement." ORDER BY TANGGAL DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	SELECT 
					INFORMASI_ID, NAMA, DEPARTEMEN_ID, USER_LOGIN_ID, TANGGAL, KETERANGAN, STATUS, LINK_FOTO, FILE_UPLOAD
					FROM INFORMASI WHERE INFORMASI_ID IS NOT NULL
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
	
	
	
	function getCountByParamsSeputarDepartemen($departemen_id)
	{
		$str = "	 SELECT COUNT(ID) ROWCOUNT FROM
					(SELECT INFORMASI_ID ID, 'info-terbaru' GROUP_STYLE, A.NAMA, TO_CHAR(TANGGAL, 'YYYY-MM-DD HH24:MI:SS') TANGGAL, dbms_lob.substr(KETERANGAN, 100, 1) KETERANGAN, B.NAMA USER_LOGIN FROM INFORMASI A 
					LEFT JOIN USER_LOGIN B ON A.USER_LOGIN_ID = B.USER_LOGIN_ID WHERE A.DEPARTEMEN_ID LIKE '".$departemen_id."%'
					UNION ALL
					SELECT HASIL_RAPAT_ID ID, 'hasil-rapat' GROUP_STYLE, NAMA, TO_CHAR(TANGGAL, 'YYYY-MM-DD HH24:MI:SS') TANGGAL, AMBIL_HASIL_RAPAT_ATTACHMENT(HASIL_RAPAT_ID), '' USER_LOGIN FROM HASIL_RAPAT WHERE DEPARTEMEN_ID LIKE '".$departemen_id."%'
					UNION ALL
					SELECT AGENDA_ID ID, 'agenda-kegiatan' GROUP_STYLE, NAMA, TO_CHAR(TANGGAL, 'YYYY-MM-DD HH24:MI:SS') TANGGAL, dbms_lob.substr(KETERANGAN, 100, 1) KETERANGAN, '' USER_LOGIN FROM AGENDA WHERE DEPARTEMEN_ID LIKE '".$departemen_id."%')
				"; 
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(INFORMASI_ID) AS ROWCOUNT FROM INFORMASI A
		        WHERE INFORMASI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(INFORMASI_ID) AS ROWCOUNT FROM INFORMASI
		        WHERE INFORMASI_ID IS NOT NULL ".$statement; 
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