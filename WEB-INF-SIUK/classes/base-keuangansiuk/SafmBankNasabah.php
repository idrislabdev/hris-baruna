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
  * EntitySIUK-base class untuk mengimplementasikan tabel SAFM_BANK_NASABAH.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class SafmBankNasabah extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SafmBankNasabah()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SAFM_BANK_NASABAH_ID", $this->getNextId("SAFM_BANK_NASABAH_ID","SAFM_BANK_NASABAH")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO SAFM_BANK_NASABAH (
					   KD_CABANG, JENIS_TABLE, ID_TABLE, 
					   MPLG_KODE, MBANK_KODE, MPLG_NO_REK, 
					   KODE_VALUTA, TGL_EFEKTIF_NOREK, KD_AKTIF_REK, 
					   LAST_UPDATED_DATE, LAST_UPDATED_BY, PROGRAM_NAME) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("JENIS_TABLE")."', '".$this->getField("ID_TABLE")."',
						'".$this->getField("MPLG_KODE")."', '".$this->getField("MBANK_KODE")."', '".$this->getField("MPLG_NO_REK")."',
						'".$this->getField("KODE_VALUTA")."', ".$this->getField("TGL_EFEKTIF_NOREK").", '".$this->getField("KD_AKTIF_REK")."',
						".$this->getField("LAST_UPDATED_DATE").", '".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."'
						)";
				
		$this->id = $this->getField("SAFM_BANK_NASABAH_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE SAFM_BANK_NASABAH
				SET    
					   KD_CABANG         = '".$this->getField("KD_CABANG")."',
					   JENIS_TABLE       = '".$this->getField("JENIS_TABLE")."',
					   ID_TABLE          = '".$this->getField("ID_TABLE")."',
					   MPLG_KODE         = '".$this->getField("MPLG_KODE")."',
					   MBANK_KODE        = '".$this->getField("MBANK_KODE")."',
					   MPLG_NO_REK       = '".$this->getField("MPLG_NO_REK")."',
					   KODE_VALUTA       = '".$this->getField("KODE_VALUTA")."',
					   TGL_EFEKTIF_NOREK = ".$this->getField("TGL_EFEKTIF_NOREK").",
					   KD_AKTIF_REK      = '".$this->getField("KD_AKTIF_REK")."',
					   LAST_UPDATED_DATE = ".$this->getField("LAST_UPDATED_DATE").",
					   LAST_UPDATED_BY   = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME      = '".$this->getField("PROGRAM_NAME")."'
				WHERE  SAFM_BANK_NASABAH_ID = '".$this->getField("SAFM_BANK_NASABAH_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM SAFM_BANK_NASABAH
                WHERE 
                  SAFM_BANK_NASABAH_ID = ".$this->getField("SAFM_BANK_NASABAH_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="",$sOrder="ORDER BY MBANK_KODE ASC")
	{
		$str = "
				SELECT KD_CABANG, JENIS_TABLE, ID_TABLE, 
  			    MPLG_KODE, MBANK_KODE, MPLG_NO_REK, 
			    KODE_VALUTA, TGL_EFEKTIF_NOREK, KD_AKTIF_REK, 
			    LAST_UPDATED_DATE, LAST_UPDATED_BY, PROGRAM_NAME
				FROM SAFM_BANK_NASABAH
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, JENIS_TABLE, ID_TABLE, 
  			    MPLG_KODE, MBANK_KODE, MPLG_NO_REK, 
			    KODE_VALUTA, TGL_EFEKTIF_NOREK, KD_AKTIF_REK, 
			    LAST_UPDATED_DATE, LAST_UPDATED_BY, PROGRAM_NAME
				FROM SAFM_BANK_NASABAH
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY MBANK_KODE ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(MPLG_KODE) AS ROWCOUNT FROM SAFM_BANK_NASABAH
		        WHERE 1 = 1 IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(SAFM_BANK_NASABAH_ID) AS ROWCOUNT FROM SAFM_BANK_NASABAH
		        WHERE SAFM_BANK_NASABAH_ID IS NOT NULL ".$statement; 
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