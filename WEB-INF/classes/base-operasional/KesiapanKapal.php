<? 
/* *******************************************************************************************************
MODUL NAME 			: PPI
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel KAPAL_JENIS.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class KesiapanKapal extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KesiapanKapal()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("KESIAPAN_ID", $this->getNextId("KESIAPAN_ID","PPI_OPERASIONAL.KESIAPAN_KAPAL"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KESIAPAN_KAPAL (
				   KESIAPAN_ID, KAPAL_ID, PERIODE, STATUS_KAPAL, MULAI, SELESAI, KETERANGAN, CREATE_USER, CREATE_DATE, STATUS, TSO, OFF, SO, PERBAIKAN, RUSAK) 
 			  	VALUES ( 0,
				  ".$this->getField("KAPAL_ID").",
				  '".$this->getField("PERIODE")."',
				  '".$this->getField("STATUS_KAPAL")."',
				  '".$this->getField("MULAI")."',
				  '".$this->getField("SELESAI")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("CREATE_USER")."',
				  ".$this->getField("CREATE_DATE").",
				  '".$this->getField("STATUS")."',
				  '".$this->getField("TSO")."',
				  '".$this->getField("OFF")."',
				  '".$this->getField("SO")."',
				  '".$this->getField("PERBAIKAN")."',
				  '".$this->getField("RUSAK")."'
				)"; 
		//$this->id = $this->getField("KESIAPAN_ID");
		//echo "insert";
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KESIAPAN_KAPAL
				SET    STATUS_KAPAL = '".$this->getField("STATUS_KAPAL")."', 
					   MULAI = '".$this->getField("MULAI")."', 
					   SELESAI = '".$this->getField("SELESAI")."', 
					   KETERANGAN = '".$this->getField("KETERANGAN")."', 
					   STATUS = '".$this->getField("STATUS")."',
					   TSO = '".$this->getField("TSO")."', 
					   OFF = '".$this->getField("OFF")."', 
					   SO = '".$this->getField("SO")."', 
					   PERBAIKAN ='".$this->getField("PERBAIKAN")."' , 
					   RUSAK = '".$this->getField("RUSAK")."',
					   UPDATE_USER = '".$this->getField("CREATE_USER")."',
					   UPDATE_DATE = ".$this->getField("CREATE_DATE")."
				WHERE  KESIAPAN_ID  	= ".$this->getField("KESIAPAN_ID")."
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function validateKesiapan()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KESIAPAN_KAPAL
				SET    VALIDATE_USER = '".$this->getField("VALIDATE_USER")."', 
					   VALIDATE_DATE = ".$this->getField("VALIDATE_DATE").", 
					   STATUS = '".$this->getField("STATUS")."'
				WHERE  KESIAPAN_ID  	= ".$this->getField("KESIAPAN_ID")."
			 "; 
		$this->query = $str;

		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KESIAPAN_KAPAL
                WHERE 
                  KESIAPAN_ID = ".$this->getField("KESIAPAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KESIAPAN_ID ASC")
	{
		$str = "
				  SELECT 
				  KESIAPAN_ID, KAPAL_ID, PERIODE, STATUS_KAPAL, MULAI, SELESAI, KETERANGAN, CREATE_USER, CREATE_DATE, VALIDATE_USER, VALIDATE_DATE, STATUS,
				  CASE 
                            WHEN TSO IS NOT NULL THEN 'TSO' 
                            WHEN OFF IS NOT NULL THEN 'OFF' 
                            WHEN RUSAK IS NOT NULL THEN 'D' 
                            WHEN PERBAIKAN IS NOT NULL THEN 'P' 
                            ELSE 'SO' END STATUS_DOWNTIME
				  FROM PPI_OPERASIONAL.KESIAPAN_KAPAL				  
				  WHERE 0=0 
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
				  KESIAPAN_ID, KAPAL_ID, PERIODE, STATUS_KAPAL, MULAI, SELESAI, KETERANGAN, CREATE_USER, CREATE_DATE, VALIDATE_USER, VALIDATE_DATE, STATUS
				  FROM PPI_OPERASIONAL.KESIAPAN_KAPAL				  
				  WHERE 0=0
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KESIAPAN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KESIAPAN_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KESIAPAN_KAPAL
		        WHERE 0=0 ".$statement; 
		
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
	
	function getKesiapanIdParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT KESIAPAN_ID FROM PPI_OPERASIONAL.KESIAPAN_KAPAL
		        WHERE 0=0 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$this->select($str);
		if($this->firstRow()) 
			return 	$this->getField("KESIAPAN_ID");
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KESIAPAN_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KESIAPAN_KAPAL
		        WHERE 0=0 ".$statement; 
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