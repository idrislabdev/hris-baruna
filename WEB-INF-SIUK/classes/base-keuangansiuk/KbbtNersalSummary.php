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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBT_NERSAL_SUMMARY.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbtNersalSummary extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbtNersalSummary()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBT_NERSAL_SUMMARY_ID", $this->getNextId("KBBT_NERSAL_SUMMARY_ID","KBBT_NERSAL_SUMMARY")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBT_NERSAL_SUMMARY (
					   KD_CABANG, THN_BUKU, BLN_BUKU, 
					   KD_BUKU_BESAR, KD_VALUTA, SALDO_DEBET, 
					   SALDO_KREDIT) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("THN_BUKU")."', '".$this->getField("BLN_BUKU")."',
						'".$this->getField("KD_BUKU_BESAR")."', '".$this->getField("KD_VALUTA")."', '".$this->getField("SALDO_DEBET")."', 
						'".$this->getField("SALDO_KREDIT")."'
				)";
				
		$this->id = $this->getField("KBBT_NERSAL_SUMMARY_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBT_NERSAL_SUMMARY
				SET    
					   KD_CABANG     = '".$this->getField("KD_CABANG")."',
					   THN_BUKU      = '".$this->getField("THN_BUKU")."',
					   BLN_BUKU      = '".$this->getField("BLN_BUKU")."',
					   KD_BUKU_BESAR = '".$this->getField("KD_BUKU_BESAR")."',
					   KD_VALUTA     = '".$this->getField("KD_VALUTA")."',
					   SALDO_DEBET   = '".$this->getField("SALDO_DEBET")."',
					   SALDO_KREDIT  = '".$this->getField("SALDO_KREDIT")."'
				WHERE  KBBT_NERSAL_SUMMARY_ID = '".$this->getField("KBBT_NERSAL_SUMMARY_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBT_NERSAL_SUMMARY
                WHERE 
                  KBBT_NERSAL_SUMMARY_ID = ".$this->getField("KBBT_NERSAL_SUMMARY_ID").""; 
				  
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
				SELECT KD_CABANG, THN_BUKU, BLN_BUKU, 
				KD_BUKU_BESAR, KD_VALUTA, SALDO_DEBET, 
				SALDO_KREDIT
				FROM KBBT_NERSAL_SUMMARY
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KBBT_NERSAL_SUMMARY_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, THN_BUKU, BLN_BUKU, 
				KD_BUKU_BESAR, KD_VALUTA, SALDO_DEBET, 
				SALDO_KREDIT
				FROM KBBT_NERSAL_SUMMARY
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
		$str = "SELECT COUNT(KBBT_NERSAL_SUMMARY_ID) AS ROWCOUNT FROM KBBT_NERSAL_SUMMARY
		        WHERE KBBT_NERSAL_SUMMARY_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KBBT_NERSAL_SUMMARY_ID) AS ROWCOUNT FROM KBBT_NERSAL_SUMMARY
		        WHERE KBBT_NERSAL_SUMMARY_ID IS NOT NULL ".$statement; 
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