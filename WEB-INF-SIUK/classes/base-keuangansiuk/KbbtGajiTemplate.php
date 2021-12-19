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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBT_GAJI_TEMPLATE.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbtGajiTemplate extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbtGajiTemplate()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBT_GAJI_TEMPLATE_ID", $this->getNextId("KBBT_GAJI_TEMPLATE_ID","KBBT_GAJI_TEMPLATE")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBT_GAJI_TEMPLATE (
					   KD_CABANG, THN_BUKU, BLN_BUKU, 
					   KODE_REK_BB, KODE_SUB_BANTU, KODE_REK_PUSBIAYA, 
					   KOREK_BANK, NILAI_TRANS) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("THN_BUKU")."', '".$this->getField("BLN_BUKU")."',
						'".$this->getField("KODE_REK_BB")."', '".$this->getField("KODE_SUB_BANTU")."', '".$this->getField("KODE_REK_PUSBIAYA")."', 
						'".$this->getField("KOREK_BANK")."', '".$this->getField("NILAI_TRANS")."'
				)";
				
		$this->id = $this->getField("KBBT_GAJI_TEMPLATE_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBT_GAJI_TEMPLATE
				SET    
					   KD_CABANG         = '".$this->getField("KD_CABANG")."',
					   THN_BUKU          = '".$this->getField("THN_BUKU")."',
					   BLN_BUKU          = '".$this->getField("BLN_BUKU")."',
					   KODE_REK_BB       = '".$this->getField("KODE_REK_BB")."',
					   KODE_SUB_BANTU    = '".$this->getField("KODE_SUB_BANTU")."',
					   KODE_REK_PUSBIAYA = '".$this->getField("KODE_REK_PUSBIAYA")."',
					   KOREK_BANK        = '".$this->getField("KOREK_BANK")."',
					   NILAI_TRANS       = '".$this->getField("NILAI_TRANS")."'
				WHERE  KBBT_GAJI_TEMPLATE_ID = '".$this->getField("KBBT_GAJI_TEMPLATE_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBT_GAJI_TEMPLATE
                WHERE 
                  KBBT_GAJI_TEMPLATE_ID = ".$this->getField("KBBT_GAJI_TEMPLATE_ID").""; 
				  
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
				KODE_REK_BB, KODE_SUB_BANTU, KODE_REK_PUSBIAYA, 
				KOREK_BANK, NILAI_TRANS
				FROM KBBT_GAJI_TEMPLATE
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KBBT_GAJI_TEMPLATE_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, THN_BUKU, BLN_BUKU, 
				KODE_REK_BB, KODE_SUB_BANTU, KODE_REK_PUSBIAYA, 
				KOREK_BANK, NILAI_TRANS
				FROM KBBT_GAJI_TEMPLATE
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
		$str = "SELECT COUNT(KBBT_GAJI_TEMPLATE_ID) AS ROWCOUNT FROM KBBT_GAJI_TEMPLATE
		        WHERE KBBT_GAJI_TEMPLATE_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KBBT_GAJI_TEMPLATE_ID) AS ROWCOUNT FROM KBBT_GAJI_TEMPLATE
		        WHERE KBBT_GAJI_TEMPLATE_ID IS NOT NULL ".$statement; 
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