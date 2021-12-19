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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_LAPORAN_LB4_NEW.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrLaporanLb4New extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrLaporanLb4New()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBR_LAPORAN_LB4_NEW_ID", $this->getNextId("KBBR_LAPORAN_LB4_NEW_ID","KBBR_LAPORAN_LB4_NEW")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_LAPORAN_LB4_NEW (
				   KD_CABANG, KD_SUB_LAPORAN, KD_REK, 
				   NM_SUB_LAPORAN, IN_AWAL, OUT_AWAL, 
				   IN_MUTASI, OUT_MUTASI, IN_AKHIR, 
				   OUT_AKHIR, THN_BUKU, BLN_BUKU, 
				   LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME) 
				VALUES ( '".$this->getField("KD_CABANG")."', '".$this->getField("KD_SUB_LAPORAN")."', '".$this->getField("KD_REK")."',
					'".$this->getField("NM_SUB_LAPORAN")."', '".$this->getField("IN_AWAL")."', '".$this->getField("OUT_AWAL")."',
					'".$this->getField("IN_MUTASI")."', '".$this->getField("OUT_MUTASI")."', '".$this->getField("IN_AKHIR")."',
					'".$this->getField("OUT_AKHIR")."', '".$this->getField("THN_BUKU")."', '".$this->getField("BLN_BUKU")."',
					".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."'
				)";
				
		$this->id = $this->getField("KBBR_LAPORAN_LB4_NEW_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_LAPORAN_LB4_NEW
				SET    
					   KD_CABANG        = '".$this->getField("KD_CABANG")."',
					   KD_SUB_LAPORAN   = '".$this->getField("KD_SUB_LAPORAN")."',
					   KD_REK           = '".$this->getField("KD_REK")."',
					   NM_SUB_LAPORAN   = '".$this->getField("NM_SUB_LAPORAN")."',
					   IN_AWAL          = '".$this->getField("IN_AWAL")."',
					   OUT_AWAL         = '".$this->getField("OUT_AWAL")."',
					   IN_MUTASI        = '".$this->getField("IN_MUTASI")."',
					   OUT_MUTASI       = '".$this->getField("OUT_MUTASI")."',
					   IN_AKHIR         = '".$this->getField("IN_AKHIR")."',
					   OUT_AKHIR        = '".$this->getField("OUT_AKHIR")."',
					   THN_BUKU         = '".$this->getField("THN_BUKU")."',
					   BLN_BUKU         = '".$this->getField("BLN_BUKU")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."'
				WHERE  KBBR_LAPORAN_LB4_NEW_ID = '".$this->getField("KBBR_LAPORAN_LB4_NEW_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_LAPORAN_LB4_NEW
                WHERE 
                  KBBR_LAPORAN_LB4_NEW_ID = ".$this->getField("KBBR_LAPORAN_LB4_NEW_ID").""; 
				  
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
				SELECT KD_CABANG, KD_SUB_LAPORAN, KD_REK, 
				NM_SUB_LAPORAN, IN_AWAL, OUT_AWAL, 
				IN_MUTASI, OUT_MUTASI, IN_AKHIR, 
				OUT_AKHIR, THN_BUKU, BLN_BUKU, 
				LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME
				FROM KBBR_LAPORAN_LB4_NEW
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KBBR_LAPORAN_LB4_NEW_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, KD_SUB_LAPORAN, KD_REK, 
				NM_SUB_LAPORAN, IN_AWAL, OUT_AWAL, 
				IN_MUTASI, OUT_MUTASI, IN_AKHIR, 
				OUT_AKHIR, THN_BUKU, BLN_BUKU, 
				LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME
				FROM KBBR_LAPORAN_LB4_NEW
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
		$str = "SELECT COUNT(KBBR_LAPORAN_LB4_NEW_ID) AS ROWCOUNT FROM KBBR_LAPORAN_LB4_NEW
		        WHERE KBBR_LAPORAN_LB4_NEW_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KBBR_LAPORAN_LB4_NEW_ID) AS ROWCOUNT FROM KBBR_LAPORAN_LB4_NEW
		        WHERE KBBR_LAPORAN_LB4_NEW_ID IS NOT NULL ".$statement; 
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