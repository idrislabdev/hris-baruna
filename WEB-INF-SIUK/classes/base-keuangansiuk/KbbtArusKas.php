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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBT_ARUS_KAS.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbtArusKas extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbtArusKas()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBT_ARUS_KAS_ID", $this->getNextId("KBBT_ARUS_KAS_ID","KBBT_ARUS_KAS")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBT_ARUS_KAS (
					   KD_CABANG, THN_BUKU, BLN_BUKU, 
					   KD_BUKU_BESAR, CASH_IN_AWAL, CASH_OUT_AWAL, 
					   CASH_IN_MUTASI, CASH_OUT_MUTASI, CASH_IN_AKHIR, 
					   CASH_OUT_AKHIR, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
					   PROGRAM_NAME, KD_SUB_LAPORAN, KD_KELOMPOK, 
					   KD_BUKU_AKHIR) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("THN_BUKU")."', '".$this->getField("BLN_BUKU")."',
						'".$this->getField("KD_BUKU_BESAR")."', '".$this->getField("CASH_IN_AWAL")."', '".$this->getField("CASH_OUT_AWAL")."',
						'".$this->getField("CASH_IN_MUTASI")."', '".$this->getField("CASH_OUT_MUTASI")."', '".$this->getField("CASH_IN_AKHIR")."',
						'".$this->getField("CASH_OUT_AKHIR")."', ".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."',
						'".$this->getField("PROGRAM_NAME")."', '".$this->getField("KD_SUB_LAPORAN")."', '".$this->getField("KD_KELOMPOK")."',
						'".$this->getField("KD_BUKU_AKHIR")."'
					)";
				
		$this->id = $this->getField("KBBT_ARUS_KAS_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBT_ARUS_KAS
				SET    
					   KD_CABANG        = '".$this->getField("KD_CABANG")."',
					   THN_BUKU         = '".$this->getField("THN_BUKU")."',
					   BLN_BUKU         = '".$this->getField("BLN_BUKU")."',
					   KD_BUKU_BESAR    = '".$this->getField("KD_BUKU_BESAR")."',
					   CASH_IN_AWAL     = '".$this->getField("CASH_IN_AWAL")."',
					   CASH_OUT_AWAL    = '".$this->getField("CASH_OUT_AWAL")."',
					   CASH_IN_MUTASI   = '".$this->getField("CASH_IN_MUTASI")."',
					   CASH_OUT_MUTASI  = '".$this->getField("CASH_OUT_MUTASI")."',
					   CASH_IN_AKHIR    = '".$this->getField("CASH_IN_AKHIR")."',
					   CASH_OUT_AKHIR   = '".$this->getField("CASH_OUT_AKHIR")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."',
					   KD_SUB_LAPORAN   = '".$this->getField("KD_SUB_LAPORAN")."',
					   KD_KELOMPOK      = '".$this->getField("KD_KELOMPOK")."',
					   KD_BUKU_AKHIR    = '".$this->getField("KD_BUKU_AKHIR")."'
				WHERE  KBBT_ARUS_KAS_ID = '".$this->getField("KBBT_ARUS_KAS_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBT_ARUS_KAS
                WHERE 
                  KBBT_ARUS_KAS_ID = ".$this->getField("KBBT_ARUS_KAS_ID").""; 
				  
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
				KD_BUKU_BESAR, CASH_IN_AWAL, CASH_OUT_AWAL, 
				CASH_IN_MUTASI, CASH_OUT_MUTASI, CASH_IN_AKHIR, 
				CASH_OUT_AKHIR, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME, KD_SUB_LAPORAN, KD_KELOMPOK, 
				KD_BUKU_AKHIR
				FROM KBBT_ARUS_KAS
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KBBT_ARUS_KAS_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, THN_BUKU, BLN_BUKU, 
				KD_BUKU_BESAR, CASH_IN_AWAL, CASH_OUT_AWAL, 
				CASH_IN_MUTASI, CASH_OUT_MUTASI, CASH_IN_AKHIR, 
				CASH_OUT_AKHIR, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME, KD_SUB_LAPORAN, KD_KELOMPOK, 
				KD_BUKU_AKHIR
				FROM KBBT_ARUS_KAS
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
		$str = "SELECT COUNT(KBBT_ARUS_KAS_ID) AS ROWCOUNT FROM KBBT_ARUS_KAS
		        WHERE KBBT_ARUS_KAS_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KBBT_ARUS_KAS_ID) AS ROWCOUNT FROM KBBT_ARUS_KAS
		        WHERE KBBT_ARUS_KAS_ID IS NOT NULL ".$statement; 
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