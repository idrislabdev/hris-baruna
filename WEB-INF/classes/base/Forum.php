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
  * Entity-base class untuk mengimplementasikan tabel FORUM.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Forum extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Forum()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("FORUM_ID", $this->getNextId("FORUM_ID","FORUM"));

		$str = "
					INSERT INTO FORUM (
					   FORUM_ID, NAMA, FORUM_KATEGORI_ID, USER_LOGIN_ID, TANGGAL, KETERANGAN, STATUS)
 			  	VALUES (
				  '".$this->getField("FORUM_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("FORUM_KATEGORI_ID")."',
				  '".$this->getField("USER_LOGIN_ID")."',
				  SYSDATE,
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("STATUS")."'
				)"; 
		$this->id = $this->getField("FORUM_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE FORUM
				SET    
					   NAMA          = '".$this->getField("NAMA")."',
					   FORUM_KATEGORI_ID= ".$this->getField("FORUM_KATEGORI_ID").",
					   USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID").",
					   TANGGAL= ".$this->getField("TANGGAL").",
					   KETERANGAN= ".$this->getField("KETERANGAN").",
					   STATUS= ".$this->getField("STATUS")."
				WHERE  FORUM_ID     = '".$this->getField("FORUM_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM FORUM
                WHERE 
                  FORUM_ID = ".$this->getField("FORUM_ID").""; 
				  
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
					FORUM_ID, A.NAMA, FORUM_KATEGORI_ID, B.NAMA USER_LOGIN, TO_CHAR(A.TANGGAL, 'YYYY-MM-DD HH24:MI:SS') TANGGAL, A.KETERANGAN, A.STATUS
					FROM FORUM A LEFT JOIN USER_LOGIN B ON A.USER_LOGIN_ID = B.USER_LOGIN_ID WHERE FORUM_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.TANGGAL DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	SELECT 
					FORUM_ID, NAMA, FORUM_KATEGORI_ID, USER_LOGIN_ID, TANGGAL, KETERANGAN, STATUS
					FROM FORUM WHERE FORUM_ID IS NOT NULL
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
		$str = "SELECT COUNT(FORUM_ID) AS ROWCOUNT FROM FORUM
		        WHERE FORUM_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(FORUM_ID) AS ROWCOUNT FROM FORUM
		        WHERE FORUM_ID IS NOT NULL ".$statement; 
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