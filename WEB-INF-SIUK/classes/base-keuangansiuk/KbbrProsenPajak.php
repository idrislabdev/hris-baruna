<? 
/* *******************************************************************************************************
MODUL NAME 			: IMASYS
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_PROSEN_PAJAK.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrProsenPajak extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrProsenPajak()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBR_PROSEN_PAJAK_ID", $this->getNextId("KBBR_PROSEN_PAJAK_ID","KBBR_PROSEN_PAJAK")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_PROSEN_PAJAK (
				   KD_CABANG, KD_BUKU_BESAR, PROSEN_PAJAK, 
				   KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				   PROGRAM_NAME) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("KD_BUKU_BESAR")."', '".$this->getField("PROSEN_PAJAK")."',
					'".$this->getField("KD_AKTIF")."', ".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."',
					'".$this->getField("PROGRAM_NAME")."'
				)";
				
		$this->id = $this->getField("KBBR_PROSEN_PAJAK_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_PROSEN_PAJAK
				SET   
					   KD_CABANG        = '".$this->getField("KD_CABANG")."',
					   KD_BUKU_BESAR    = '".$this->getField("KD_BUKU_BESAR")."',
					   PROSEN_PAJAK     = '".$this->getField("PROSEN_PAJAK")."',
					   KD_AKTIF         = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."'
				WHERE  KBBR_PROSEN_PAJAK_ID = '".$this->getField("KBBR_PROSEN_PAJAK_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_PROSEN_PAJAK
                WHERE 
                  KBBR_PROSEN_PAJAK_ID = ".$this->getField("KBBR_PROSEN_PAJAK_ID").""; 
				  
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
				SELECT KD_CABANG, KD_BUKU_BESAR, PROSEN_PAJAK, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME
				FROM KBBR_PROSEN_PAJAK
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KBBR_PROSEN_PAJAK_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, KD_BUKU_BESAR, PROSEN_PAJAK, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME
				FROM KBBR_PROSEN_PAJAK
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KD_CABANG ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KBBR_PROSEN_PAJAK_ID) AS ROWCOUNT FROM KBBR_PROSEN_PAJAK
		        WHERE KBBR_PROSEN_PAJAK_ID IS NOT NULL ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KBBR_PROSEN_PAJAK_ID) AS ROWCOUNT FROM KBBR_PROSEN_PAJAK
		        WHERE KBBR_PROSEN_PAJAK_ID IS NOT NULL ".$statement; 
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