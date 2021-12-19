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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBT_GAJI_JNSPST_D.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbtGajiJnspstD extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbtGajiJnspstD()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBT_GAJI_JNSPST_D_ID", $this->getNextId("KBBT_GAJI_JNSPST_D_ID","KBBT_GAJI_JNSPST_D")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBT_GAJI_JNSPST_D (
					   KD_CABANG, THN_BUKU, BLN_BUKU, 
					   PEG_ID, JNS_PENGH, REK_REKAP, 
					   KOREK_PENGHASILAN, PENGHASILAN, KOREK_TUNJ_PREST, 
					   TUNJ_PREST, KOREK_TUNJ_JAB, TUNJ_JAB, 
					   KOREK_LUMPSUM_KEND, LUMPSUM_KENDARAAN, KOREK_TUNJ_MOBIL, 
					   TUNJ_MOBIL, KOREK_TUNJ_KEST, TUNJ_KESEHATAN, 
					   KOREK_TUNJ_PERALIHAN, TUNJ_PERALIHAN, KOREK_PPH21, 
					   PPH21_PEG, KD_BANK_PEGAWAI, KD_BANK_PELINDO, 
					   LAST_UPDATED_BY, PROGRAM_NAME, TGL_PAYROLL) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("THN_BUKU")."', '".$this->getField("BLN_BUKU")."',
						'".$this->getField("PEG_ID")."', '".$this->getField("JNS_PENGH")."', '".$this->getField("REK_REKAP")."',
						'".$this->getField("KOREK_PENGHASILAN")."', '".$this->getField("PENGHASILAN")."', '".$this->getField("KOREK_TUNJ_PREST")."',
						'".$this->getField("TUNJ_PREST")."', '".$this->getField("KOREK_TUNJ_JAB")."', '".$this->getField("TUNJ_JAB")."',
						'".$this->getField("KOREK_LUMPSUM_KEND")."', '".$this->getField("LUMPSUM_KENDARAAN")."', '".$this->getField("KOREK_TUNJ_MOBIL")."',
						'".$this->getField("TUNJ_MOBIL")."', '".$this->getField("KOREK_TUNJ_KEST")."', '".$this->getField("TUNJ_KESEHATAN")."',
						'".$this->getField("KOREK_TUNJ_PERALIHAN")."', '".$this->getField("TUNJ_PERALIHAN")."', '".$this->getField("KOREK_PPH21")."',
						'".$this->getField("PPH21_PEG")."', '".$this->getField("KD_BANK_PEGAWAI")."', '".$this->getField("KD_BANK_PELINDO")."',
						'".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."', ".$this->getField("TGL_PAYROLL")."
				)";
				
		$this->id = $this->getField("KBBT_GAJI_JNSPST_D_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBT_GAJI_JNSPST_D
				SET    
					   KD_CABANG            = '".$this->getField("KD_CABANG")."',
					   THN_BUKU             = '".$this->getField("THN_BUKU")."',
					   BLN_BUKU             = '".$this->getField("BLN_BUKU")."',
					   PEG_ID               = '".$this->getField("PEG_ID")."',
					   JNS_PENGH            = '".$this->getField("JNS_PENGH")."',
					   REK_REKAP            = '".$this->getField("REK_REKAP")."',
					   KOREK_PENGHASILAN    = '".$this->getField("KOREK_PENGHASILAN")."',
					   PENGHASILAN          = '".$this->getField("PENGHASILAN")."',
					   KOREK_TUNJ_PREST     = '".$this->getField("KOREK_TUNJ_PREST")."',
					   TUNJ_PREST           = '".$this->getField("TUNJ_PREST")."',
					   KOREK_TUNJ_JAB       = '".$this->getField("KOREK_TUNJ_JAB")."',
					   TUNJ_JAB             = '".$this->getField("TUNJ_JAB")."',
					   KOREK_LUMPSUM_KEND   = '".$this->getField("KOREK_LUMPSUM_KEND")."',
					   LUMPSUM_KENDARAAN    = '".$this->getField("LUMPSUM_KENDARAAN")."',
					   KOREK_TUNJ_MOBIL     = '".$this->getField("KOREK_TUNJ_MOBIL")."',
					   TUNJ_MOBIL           = '".$this->getField("TUNJ_MOBIL")."',
					   KOREK_TUNJ_KEST      = '".$this->getField("KOREK_TUNJ_KEST")."',
					   TUNJ_KESEHATAN       = '".$this->getField("TUNJ_KESEHATAN")."',
					   KOREK_TUNJ_PERALIHAN = '".$this->getField("KOREK_TUNJ_PERALIHAN")."',
					   TUNJ_PERALIHAN       = '".$this->getField("TUNJ_PERALIHAN")."',
					   KOREK_PPH21          = '".$this->getField("KOREK_PPH21")."',
					   PPH21_PEG            = '".$this->getField("PPH21_PEG")."',
					   KD_BANK_PEGAWAI      = '".$this->getField("KD_BANK_PEGAWAI")."',
					   KD_BANK_PELINDO      = '".$this->getField("KD_BANK_PELINDO")."',
					   LAST_UPDATED_BY      = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME         = '".$this->getField("PROGRAM_NAME")."',
					   TGL_PAYROLL          = ".$this->getField("TGL_PAYROLL")."
				WHERE  KBBT_GAJI_JNSPST_D_ID = '".$this->getField("KBBT_GAJI_JNSPST_D_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBT_GAJI_JNSPST_D
                WHERE 
                  KBBT_GAJI_JNSPST_D_ID = ".$this->getField("KBBT_GAJI_JNSPST_D_ID").""; 
				  
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
				PEG_ID, JNS_PENGH, REK_REKAP, 
				KOREK_PENGHASILAN, PENGHASILAN, KOREK_TUNJ_PREST, 
				TUNJ_PREST, KOREK_TUNJ_JAB, TUNJ_JAB, 
				KOREK_LUMPSUM_KEND, LUMPSUM_KENDARAAN, KOREK_TUNJ_MOBIL, 
				TUNJ_MOBIL, KOREK_TUNJ_KEST, TUNJ_KESEHATAN, 
				KOREK_TUNJ_PERALIHAN, TUNJ_PERALIHAN, KOREK_PPH21, 
				PPH21_PEG, KD_BANK_PEGAWAI, KD_BANK_PELINDO, 
				LAST_UPDATED_BY, PROGRAM_NAME, TGL_PAYROLL
				FROM KBBT_GAJI_JNSPST_D
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KBBT_GAJI_JNSPST_D_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, THN_BUKU, BLN_BUKU, 
				PEG_ID, JNS_PENGH, REK_REKAP, 
				KOREK_PENGHASILAN, PENGHASILAN, KOREK_TUNJ_PREST, 
				TUNJ_PREST, KOREK_TUNJ_JAB, TUNJ_JAB, 
				KOREK_LUMPSUM_KEND, LUMPSUM_KENDARAAN, KOREK_TUNJ_MOBIL, 
				TUNJ_MOBIL, KOREK_TUNJ_KEST, TUNJ_KESEHATAN, 
				KOREK_TUNJ_PERALIHAN, TUNJ_PERALIHAN, KOREK_PPH21, 
				PPH21_PEG, KD_BANK_PEGAWAI, KD_BANK_PELINDO, 
				LAST_UPDATED_BY, PROGRAM_NAME, TGL_PAYROLL
				FROM KBBT_GAJI_JNSPST_D
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
		$str = "SELECT COUNT(KBBT_GAJI_JNSPST_D_ID) AS ROWCOUNT FROM KBBT_GAJI_JNSPST_D
		        WHERE KBBT_GAJI_JNSPST_D_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KBBT_GAJI_JNSPST_D_ID) AS ROWCOUNT FROM KBBT_GAJI_JNSPST_D
		        WHERE KBBT_GAJI_JNSPST_D_ID IS NOT NULL ".$statement; 
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