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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_THN_BUKU_D.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrThnBukuD extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrThnBukuD()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBR_THN_BUKU_D", $this->getNextId("KBBR_THN_BUKU_D","KBBR_THN_BUKU_D")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_THN_BUKU_D (
				   KD_CABANG, THN_BUKU, BLN_BUKU, 
				   NM_BLN_BUKU, TGL_AWAL, TGL_AKHIR, 
				   STATUS_CLOSING, KALI_CLOSING, LAST_UPDATE_DATE, 
				   LAST_UPDATED_BY, PROGRAM_NAME, POSTING_VALUASI, 
				   STATUS_CLOSING_MK, STATUS_CLOSING_GM) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("THN_BUKU")."', '".$this->getField("BLN_BUKU")."',
					'".$this->getField("NM_BLN_BUKU")."', ".$this->getField("TGL_AWAL").", ".$this->getField("TGL_AKHIR").",
					'".$this->getField("STATUS_CLOSING")."', '".$this->getField("KALI_CLOSING")."', ".$this->getField("LAST_UPDATE_DATE").",
					'".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."', '".$this->getField("POSTING_VALUASI")."',
					'".$this->getField("STATUS_CLOSING_MK")."', '".$this->getField("STATUS_CLOSING_GM")."'
				)";
				
		$this->id = $this->getField("KBBR_THN_BUKU_D");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_THN_BUKU_D
				SET    
					   STATUS_CLOSING    = '".$this->getField("STATUS_CLOSING")."',
					   LAST_UPDATE_DATE  = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY   = '".$this->getField("LAST_UPDATED_BY")."'
				WHERE  THN_BUKU          = '".$this->getField("THN_BUKU")."'  AND BLN_BUKU          = '".$this->getField("BLN_BUKU")."'
			";
		
		/*KD_CABANG         = '".$this->getField("KD_CABANG")."',
	    THN_BUKU          = '".$this->getField("THN_BUKU")."',					   
	    BLN_BUKU          = '".$this->getField("BLN_BUKU")."',
	    NM_BLN_BUKU       = '".$this->getField("NM_BLN_BUKU")."',
	    TGL_AWAL          = ".$this->getField("TGL_AWAL").",
	    TGL_AKHIR         = ".$this->getField("TGL_AKHIR").",
		KALI_CLOSING      = '".$this->getField("KALI_CLOSING")."',
		PROGRAM_NAME      = '".$this->getField("PROGRAM_NAME")."',
		POSTING_VALUASI   = '".$this->getField("POSTING_VALUASI")."',
		STATUS_CLOSING_MK = '".$this->getField("STATUS_CLOSING_MK")."',
		STATUS_CLOSING_GM = '".$this->getField("STATUS_CLOSING_GM")."'*/
		
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_THN_BUKU_D
                WHERE 
                  KBBR_THN_BUKU_D = ".$this->getField("KBBR_THN_BUKU_D").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY THN_BUKU ASC")
	{
		$str = "
				SELECT KD_CABANG, THN_BUKU, BLN_BUKU, 
				NM_BLN_BUKU, TGL_AWAL, TGL_AKHIR, 
				STATUS_CLOSING, KALI_CLOSING, LAST_UPDATE_DATE, 
				LAST_UPDATED_BY, PROGRAM_NAME, POSTING_VALUASI, 
				STATUS_CLOSING_MK, STATUS_CLOSING_GM,
				BLN_BUKU || THN_BUKU PERIODE
				FROM KBBR_THN_BUKU_D
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

    function selectByParamsCombo($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder=" ORDER BY TGL_AWAL DESC ")
	{
		$str = "
				SELECT THN_BUKU || BLN_BUKU TAHUN_BULAN, BLN_BUKU || THN_BUKU BULAN_TAHUN, NM_BLN_BUKU NAMA  FROM KBBR_THN_BUKU_D
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
    

    function selectByParamsKodeCabang($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder=" ORDER BY KODE_CABANG ASC ")
	{
		$str = "
				SELECT 
				KODE_CABANG
				FROM CABANG_PUSAT
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
		



    function selectByParamsSekolah($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder=" ORDER BY SEKOLAH ASC ")
	{
		$str = "
				SELECT DISTINCT SEKOLAH KODE_CABANG FROM SISWA_SPP_TERAKHIR
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
		


    function selectByParamsSekolahKelas($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder=" ORDER BY KELAS ASC ")
	{
		$str = "
				SELECT DISTINCT KELAS FROM SISWA_SPP_TERAKHIR
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
				SELECT KD_CABANG, THN_BUKU, BLN_BUKU, 
				NM_BLN_BUKU, TGL_AWAL, TGL_AKHIR, 
				STATUS_CLOSING, KALI_CLOSING, LAST_UPDATE_DATE, 
				LAST_UPDATED_BY, PROGRAM_NAME, POSTING_VALUASI, 
				STATUS_CLOSING_MK, STATUS_CLOSING_GM
				FROM KBBR_THN_BUKU_D
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

    function getStatusClosing($paramsArray=array(), $statement="")
	{
		$str = "SELECT STATUS_CLOSING FROM KBBR_THN_BUKU_D
		        WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("STATUS_CLOSING"); 
		else 
			return "C"; 
    }
		
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
    function getPeriodeAkhir()
	{
		$str = "SELECT PERIODE FROM PERIODE_TERAKHIR
		        WHERE 1 = 1 ".$statement; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("PERIODE"); 
		else 
			return ""; 
    }


    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(THN_BUKU) AS ROWCOUNT FROM KBBR_THN_BUKU_D
		        WHERE 1 = 1 ".$statement; 
		
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
		$str = "SELECT COUNT(KBBR_THN_BUKU_D) AS ROWCOUNT FROM KBBR_THN_BUKU_D
		        WHERE 1 = 1 ".$statement; 
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