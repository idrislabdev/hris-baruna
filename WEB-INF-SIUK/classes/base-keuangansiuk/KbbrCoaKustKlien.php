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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_COA_KUST_KLIEN.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrCoaKustKlien extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrCoaKustKlien()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("BADAN_USAHA", $this->getNextId("BADAN_USAHA","KBBR_COA_KUST_KLIEN")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_COA_KUST_KLIEN (
				   KD_CABANG, KD_KUST_KLIEN, BADAN_USAHA, 
				   ID_REF_BD_USAHA, COA1, COA2, 
				   COA3, COA4, COA5, 
				   COA6, COA7, COA8, 
				   COA9, COA10, KD_AKTIF, 
				   LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME) 
				VALUES ( '".$this->getField("KD_CABANG")."', '".$this->getField("KD_KUST_KLIEN")."', '".$this->getField("BADAN_USAHA")."',
					'".$this->getField("ID_REF_BD_USAHA")."', '".$this->getField("COA1")."', '".$this->getField("COA2")."',
					'".$this->getField("COA3")."', '".$this->getField("COA4")."', '".$this->getField("COA5")."',
					'".$this->getField("COA6")."', '".$this->getField("COA7")."', '".$this->getField("COA8")."', 
					'".$this->getField("COA9")."', '".$this->getField("COA10")."', '".$this->getField("KD_AKTIF")."', 
					".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."'
				)";
				
		$this->id = $this->getField("BADAN_USAHA");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_COA_KUST_KLIEN
				SET    
					   KD_CABANG        = '".$this->getField("KD_CABANG")."',
					   KD_KUST_KLIEN    = '".$this->getField("KD_KUST_KLIEN")."',
					   BADAN_USAHA      = '".$this->getField("BADAN_USAHA")."',
					   ID_REF_BD_USAHA  = '".$this->getField("ID_REF_BD_USAHA")."',
					   COA1             = '".$this->getField("COA1")."',
					   COA2             = '".$this->getField("COA2")."',
					   COA3             = '".$this->getField("COA3")."',
					   COA4             = '".$this->getField("COA4")."',
					   COA5             = '".$this->getField("COA5")."',
					   COA6             = '".$this->getField("COA6")."',
					   COA7             = '".$this->getField("COA7")."',
					   COA8             = '".$this->getField("COA8")."',
					   COA9             = '".$this->getField("COA9")."',
					   COA10            = '".$this->getField("COA10")."',
					   KD_AKTIF         = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."'
				WHERE  BADAN_USAHA = '".$this->getField("BADAN_USAHA")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_COA_KUST_KLIEN
                WHERE 
                  BADAN_USAHA = ".$this->getField("BADAN_USAHA").""; 
				  
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
				SELECT KD_CABANG, KD_KUST_KLIEN, BADAN_USAHA, 
				ID_REF_BD_USAHA, COA1, COA2, 
				COA3, COA4, COA5, 
				COA6, COA7, COA8, 
				COA9, COA10, KD_AKTIF, 
				LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME
				FROM KBBR_COA_KUST_KLIEN
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY BADAN_USAHA ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, KD_KUST_KLIEN, BADAN_USAHA, 
				ID_REF_BD_USAHA, COA1, COA2, 
				COA3, COA4, COA5, 
				COA6, COA7, COA8, 
				COA9, COA10, KD_AKTIF, 
				LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME
				FROM KBBR_COA_KUST_KLIEN
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
	

    function getKdBbKusto($reqValutaNama, $reqBadanUsaha)
	{
		$str = "SELECT DECODE('".$reqValutaNama."', 'IDR', COA1, COA2) KODE FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = 1 AND BADAN_USAHA = '".$reqBadanUsaha."' "; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("KODE"); 
		else 
			return ""; 
    }
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(BADAN_USAHA) AS ROWCOUNT FROM KBBR_COA_KUST_KLIEN
		        WHERE BADAN_USAHA IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(BADAN_USAHA) AS ROWCOUNT FROM KBBR_COA_KUST_KLIEN
		        WHERE BADAN_USAHA IS NOT NULL ".$statement; 
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