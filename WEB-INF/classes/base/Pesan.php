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
  * Entity-base class untuk mengimplementasikan tabel PESAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Pesan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Pesan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PESAN_ID", $this->getNextId("PESAN_ID","PESAN"));

		$str = "
					INSERT INTO PESAN (
					   PESAN_ID, NAMA, TANGGAL, USER_LOGIN_ID_PENGIRIM, USER_LOGIN_ID_PENERIMA, KETERANGAN, STATUS, PESAN_PARENT_ID)
 			  	VALUES (
				  ".$this->getField("PESAN_ID").",
				  '".$this->getField("NAMA")."',
				  SYSDATE,
				  ".$this->getField("USER_LOGIN_ID_PENGIRIM").",
				  ".$this->getField("USER_LOGIN_ID_PENERIMA").",
				  '".$this->getField("KETERANGAN")."',
				  0,
				  '".$this->getField("PESAN_ID")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function insertParentId()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PESAN_ID", $this->getNextId("PESAN_ID","PESAN"));

		$str = "
					INSERT INTO PESAN (
					   PESAN_ID, NAMA, TANGGAL, USER_LOGIN_ID_PENGIRIM, USER_LOGIN_ID_PENERIMA, KETERANGAN, STATUS, PESAN_PARENT_ID)
 			  	VALUES (
				  ".$this->getField("PESAN_ID").",
				  '".$this->getField("NAMA")."',
				  SYSDATE,
				  ".$this->getField("USER_LOGIN_ID_PENGIRIM").",
				  ".$this->getField("USER_LOGIN_ID_PENERIMA").",
				  '".$this->getField("KETERANGAN")."',
				  0,
				  '".$this->getField("PESAN_PARENT_ID")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE PESAN
				SET    
					   NAMA          = '".$this->getField("NAMA")."',
					   USER_LOGIN_ID_PENGIRIM= ".$this->getField("USER_LOGIN_ID_PENGIRIM").",
					   DEPARTEMEN_ID_PENERIMA= ".$this->getField("DEPARTEMEN_ID_PENERIMA").",
					   USER_LOGIN_ID_PENERIMA= ".$this->getField("USER_LOGIN_ID_PENERIMA").",
					   KETERANGAN= ".$this->getField("KETERANGAN").",
					   FILE_UPLOAD= ".$this->getField("FILE_UPLOAD")."
				WHERE  PESAN_ID     = '".$this->getField("PESAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PESAN A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE PESAN_ID = ".$this->getField("PESAN_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PESAN
                WHERE 
                  PESAN_ID = ".$this->getField("PESAN_ID").""; 
				  
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
				SELECT   PESAN_ID, A.NAMA, B.USER_LOGIN_ID, B.NAMA USER_LOGIN,
         C.NAMA DEPARTEMEN,
         TO_CHAR (A.TANGGAL, 'YYYY-MM-DD HH24:MI:SS') TANGGAL, A.KETERANGAN,
         FILE_UPLOAD, A.STATUS
 	 	 FROM PESAN A INNER JOIN USER_LOGIN B
         ON A.USER_LOGIN_ID_PENGIRIM = B.USER_LOGIN_ID
         LEFT JOIN PPI_SIMPEG.PEGAWAI D ON B.PEGAWAI_ID = D.PEGAWAI_ID
         LEFT JOIN PPI_SIMPEG.DEPARTEMEN C
         ON D.DEPARTEMEN_ID = C.DEPARTEMEN_ID WHERE PESAN_ID IS NOT NULL
				"; 

		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " ORDER BY TANGGAL DESC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT   MAX(PESAN_ID) PESAN_ID, A.NAMA, B.USER_LOGIN_ID, B.NAMA USER_LOGIN,
					 C.NAMA DEPARTEMEN,
					 TO_CHAR (MAX(A.TANGGAL), 'YYYY-MM-DD HH24:MI:SS') TANGGAL, MIN(A.STATUS) STATUS, PESAN_PARENT_ID, USER_LOGIN_ID_PENGIRIM
				FROM PESAN A INNER JOIN USER_LOGIN B
					 ON A.USER_LOGIN_ID_PENGIRIM = B.USER_LOGIN_ID
					 LEFT JOIN PPI_SIMPEG.PEGAWAI D ON B.PEGAWAI_ID = D.PEGAWAI_ID
					 LEFT JOIN PPI_SIMPEG.DEPARTEMEN C
					 ON D.DEPARTEMEN_ID = C.DEPARTEMEN_ID
			   WHERE PESAN_ID IS NOT NULL
				"; 

		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " GROUP BY PESAN_PARENT_ID, A.NAMA, B.USER_LOGIN_ID, B.NAMA, C.NAMA, PESAN_PARENT_ID, USER_LOGIN_ID_PENGIRIM ORDER BY TANGGAL DESC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	SELECT 
					PESAN_ID, A.NAMA, B.NAMA USER_LOGIN, C.NAMA DEPARTEMEN, TO_CHAR(A.TANGGAL, 'YYYY-MM-DD HH24:MI:SS') TANGGAL, KETERANGAN, FILE_UPLOAD
				    FROM PESAN A INNER JOIN USER_LOGIN B ON A.USER_LOGIN_ID_PENGIRIM = B.USER_LOGIN_ID 
				   INNER JOIN DEPARTEMEN C ON B.DEPARTEMEN_ID = C.DEPARTEMEN_ID WHERE PESAN_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY TANGGAL DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PESAN_ID) AS ROWCOUNT FROM PESAN
		        WHERE PESAN_ID IS NOT NULL ".$statement; 
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
	
    function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{

			$str = "
				SELECT   COUNT(MAX(PESAN_ID))  ROWCOUNT
				FROM PESAN A INNER JOIN USER_LOGIN B
					 ON A.USER_LOGIN_ID_PENGIRIM = B.USER_LOGIN_ID
					 LEFT JOIN PPI_SIMPEG.PEGAWAI D ON B.PEGAWAI_ID = D.PEGAWAI_ID
					 LEFT JOIN PPI_SIMPEG.DEPARTEMEN C
					 ON D.DEPARTEMEN_ID = C.DEPARTEMEN_ID
			   WHERE PESAN_ID IS NOT NULL
				".$statement; 

		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
			
		$str .= " GROUP BY PESAN_PARENT_ID, A.NAMA, B.USER_LOGIN_ID, B.NAMA, C.NAMA, PESAN_PARENT_ID, USER_LOGIN_ID_PENGIRIM ORDER BY TANGGAL DESC";
		$this->query = $str;

		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;  
    }	
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PESAN_ID) AS ROWCOUNT FROM PESAN
		        WHERE PESAN_ID IS NOT NULL ".$statement; 
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