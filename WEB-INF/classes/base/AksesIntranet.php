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
  * Entity-base class untuk mengimplementasikan tabel AKSES_INTRANET.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class AksesIntranet extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AksesIntranet()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("AKSES_INTRANET_ID", $this->getNextId("AKSES_INTRANET_ID","AKSES_INTRANET"));

		$str = "
					INSERT INTO AKSES_INTRANET (
					   AKSES_INTRANET_ID, NAMA, INFORMASI, HASIL_RAPAT, AGENDA, FORUM, KATA_MUTIARA, KALENDER_KERJA)
 			  	VALUES (
				  ".$this->getField("AKSES_INTRANET_ID")."
				  ".$this->getField("NAMA").",
				  ".$this->getField("INFORMASI").",
				  ".$this->getField("HASIL_RAPAT").",
				  ".$this->getField("AGENDA").",
				  ".$this->getField("FORUM").",
				  ".$this->getField("KATA_MUTIARA").",
				  ".$this->getField("KALENDER_KERJA")."
				  
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE AKSES_INTRANET
				SET    
					   NAMA          = '".$this->getField("NAMA")."',
					   INFORMASI= ".$this->getField("INFORMASI").",
					   HASIL_RAPAT= ".$this->getField("HASIL_RAPAT").",
					   AGENDA= ".$this->getField("AGENDA").",
					   FORUM= ".$this->getField("FORUM").",
					   KATA_MUTIARA= ".$this->getField("KATA_MUTIARA").",
					   KALENDER_KERJA= ".$this->getField("KALENDER_KERJA")."
				WHERE  AKSES_INTRANET_ID     = '".$this->getField("AKSES_INTRANET_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM AKSES_INTRANET
                WHERE 
                  AKSES_INTRANET_ID = ".$this->getField("AKSES_INTRANET_ID").""; 
				  
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
					AKSES_INTRANET_ID, NAMA, INFORMASI, HASIL_RAPAT, AGENDA, FORUM, KATA_MUTIARA, KALENDER_KERJA
					FROM AKSES_INTRANET WHERE AKSES_INTRANET_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY NAMA DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	SELECT 
					AKSES_INTRANET_ID, NAMA, INFORMASI, HASIL_RAPAT, AGENDA, FORUM, KATA_MUTIARA, KALENDER_KERJA
					FROM AKSES_INTRANET WHERE AKSES_INTRANET_ID IS NOT NULL
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
		$str = "SELECT COUNT(AKSES_INTRANET_ID) AS ROWCOUNT FROM AKSES_INTRANET
		        WHERE AKSES_INTRANET_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(AKSES_INTRANET_ID) AS ROWCOUNT FROM AKSES_INTRANET
		        WHERE AKSES_INTRANET_ID IS NOT NULL ".$statement; 
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