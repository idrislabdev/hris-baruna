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
  * Entity-base class untuk mengimplementasikan tabel FORUM_DETIL.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class ForumDetil extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function ForumDetil()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("FORUM_DETIL_ID", $this->getNextId("FORUM_DETIL_ID","FORUM_DETIL"));

		$str = "
					INSERT INTO FORUM_DETIL (
					   FORUM_DETIL_ID, FORUM_ID, USER_LOGIN_ID, TANGGAL, KETERANGAN)
 			  	VALUES (
				  '".$this->getField("FORUM_DETIL_ID")."',
				  '".$this->getField("FORUM_ID")."',
				  '".$this->getField("USER_LOGIN_ID")."',
				  SYSDATE,
				  '".$this->getField("KETERANGAN")."'
				)"; 
		$this->query = $str;
		
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE FORUM_DETIL
				SET    
					   FORUM_ID          = '".$this->getField("FORUM_ID")."'
					   USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID").",
					   TANGGAL= ".$this->getField("TANGGAL").",
					   KETERANGAN= ".$this->getField("KETERANGAN")."
				WHERE  FORUM_DETIL_ID     = '".$this->getField("FORUM_DETIL_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM FORUM_DETIL
                WHERE 
                  FORUM_DETIL_ID = ".$this->getField("FORUM_DETIL_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY FORUM_DETIL_ID ASC")
	{
		$str = "
					SELECT 
					FORUM_DETIL_ID, FORUM_ID, B.NAMA USER_LOGIN, B.JABATAN, C.NAMA DEPARTEMEN, TO_CHAR(A.TANGGAL, 'YYYY-MM-DD HH24:MI:SS') TANGGAL, 
                    A.KETERANGAN, (SELECT COUNT(FORUM_DETIL_ID) FROM FORUM_DETIL X WHERE X.USER_LOGIN_ID = B.USER_LOGIN_ID) JUMLAH_POSTING
					FROM FORUM_DETIL A LEFT JOIN USER_LOGIN B ON A.USER_LOGIN_ID = B.USER_LOGIN_ID LEFT JOIN PPI_SIMPEG.DEPARTEMEN C ON B.DEPARTEMEN_ID = C.DEPARTEMEN_ID 
					WHERE FORUM_DETIL_ID IS NOT NULL
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
					FORUM_DETIL_ID, FORUM_ID, USER_LOGIN_ID, TANGGAL, KETERANGAN
					FROM FORUM_DETIL WHERE FORUM_DETIL_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY FORUM_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(FORUM_DETIL_ID) AS ROWCOUNT FROM FORUM_DETIL
		        WHERE FORUM_DETIL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(FORUM_DETIL_ID) AS ROWCOUNT FROM FORUM_DETIL
		        WHERE FORUM_DETIL_ID IS NOT NULL ".$statement; 
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