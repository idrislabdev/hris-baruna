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
  * Entity-base class untuk mengimplementasikan tabel USER_GROUP.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class UserGroup extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function UserGroup()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("USER_GROUP_ID", $this->getNextId("USER_GROUP_ID","USER_GROUP"));

		$str = "
					INSERT INTO USER_GROUP (
					   USER_GROUP_ID, NAMA,  AKSES_LOGIN_KEPEGAWAIAN, AKSES_LOGIN_PRESENSI, AKSES_LOGIN_PENGHASILAN,
					   AKSES_LOGIN_KEUANGAN, AKSES_LOGIN_FIXED_ASSET, AKSES_LOGIN_PEMBAYARAN, AKSES_LOGIN_PENGATURAN)
 			  	VALUES (
					".$this->getField("USER_GROUP_ID").",
					'".$this->getField("NAMA")."',
					'".$this->getField("AKSES_LOGIN_KEPEGAWAIAN")."',
					'".$this->getField("AKSES_LOGIN_PRESENSI")."',
					'".$this->getField("AKSES_LOGIN_PENGHASILAN")."',
					'".$this->getField("AKSES_LOGIN_KEUANGAN")."',
					'".$this->getField("AKSES_LOGIN_FIXED_ASSET")."',
					'".$this->getField("AKSES_LOGIN_PEMBAYARAN")."',
					'".$this->getField("AKSES_LOGIN_PENGATURAN")."'		  			  
				)"; 
		$this->query = $str;

		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE USER_GROUP
				SET    
					   NAMA         	= '".$this->getField("NAMA")."',
					   AKSES_LOGIN_KEPEGAWAIAN= '".$this->getField("AKSES_LOGIN_KEPEGAWAIAN")."',
					   AKSES_LOGIN_PRESENSI= '".$this->getField("AKSES_LOGIN_PRESENSI")."',
					   AKSES_LOGIN_PENGHASILAN= '".$this->getField("AKSES_LOGIN_PENGHASILAN")."',
					   AKSES_LOGIN_KEUANGAN= '".$this->getField("AKSES_LOGIN_KEUANGAN")."',
					   AKSES_LOGIN_FIXED_ASSET= '".$this->getField("AKSES_LOGIN_FIXED_ASSET")."',
					   AKSES_LOGIN_PEMBAYARAN= '".$this->getField("AKSES_LOGIN_PEMBAYARAN")."',
					   AKSES_LOGIN_PENGATURAN= '".$this->getField("AKSES_LOGIN_PENGATURAN")."'
				WHERE  USER_GROUP_ID     = ".$this->getField("USER_GROUP_ID")."

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
		// return $str;
    }

	function delete()
	{
        $str = "DELETE FROM USER_GROUP
                WHERE 
                  USER_GROUP_ID = ".$this->getField("USER_GROUP_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY NAMA ASC")
	{
		$str = "
				SELECT 
				USER_GROUP_ID, NAMA, KETERANGAN, AKSES_LOGIN_KEPEGAWAIAN, AKSES_LOGIN_PRESENSI, AKSES_LOGIN_PENGHASILAN,
				AKSES_LOGIN_KEUANGAN, AKSES_LOGIN_FIXED_ASSET, AKSES_LOGIN_PEMBAYARAN, AKSES_LOGIN_PENGATURAN 
				FROM USER_GROUP WHERE USER_GROUP_ID IS NOT NULL
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
				USER_GROUP_ID, NAMA, KETERANGAN, AKSES_LOGIN_KEPEGAWAIAN, AKSES_LOGIN_PRESENSI, AKSES_LOGIN_PENGHASILAN,
				AKSES_LOGIN_KEUANGAN, AKSES_LOGIN_FIXED_ASSET, AKSES_LOGIN_PEMBAYARAN, AKSES_LOGIN_PENGATURAN 
				FROM USER_GROUP WHERE USER_GROUP_ID IS NOT NULL
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
		$str = "SELECT COUNT(USER_GROUP_ID) AS ROWCOUNT FROM USER_GROUP
		        WHERE USER_GROUP_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(USER_GROUP_ID) AS ROWCOUNT FROM USER_GROUP
		        WHERE USER_GROUP_ID IS NOT NULL ".$statement; 
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