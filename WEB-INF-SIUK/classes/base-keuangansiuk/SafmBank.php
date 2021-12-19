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
  * EntitySIUK-base class untuk mengimplementasikan tabel SAFM_BANK.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class SafmBank extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SafmBank()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SAFM_BANK_ID", $this->getNextId("SAFM_BANK_ID","SAFM_BANK")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO SAFM_BANK (
					   KD_CABANG, JENIS_TABLE, ID_TABLE, 
					   MBANK_KODE, MBANK_NAMA, MBANK_CABANG, 
					   MBANK_ALAMAT, MBANK_NO_TELEPON, MBANK_CONT_PERSON_1, 
					   MBANK_CONT_PERSON_2, MBANK_CONT_PERSON_3, MBANK_JAB_PERSON_1, 
					   MBANK_JAB_PERSON_2, MBANK_JAB_PERSON_3, MBANK_NOTELP_PERSON_1, 
					   MBANK_NOTELP_PERSON_2, MBANK_NOTELP_PERSON_3, KD_AKTIF, 
					   LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
					   MBANK_KODE_BB, NO_REK_PELINDO, MBANK_KARTU_BB, 
					   NO_URUT) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("JENIS_TABLE")."', '".$this->getField("ID_TABLE")."',
						'".$this->getField("MBANK_KODE")."', '".$this->getField("MBANK_NAMA")."', '".$this->getField("MBANK_CABANG")."',
						'".$this->getField("MBANK_ALAMAT")."', '".$this->getField("MBANK_NO_TELEPON")."', '".$this->getField("MBANK_CONT_PERSON_1")."',
						'".$this->getField("MBANK_CONT_PERSON_2")."', '".$this->getField("MBANK_CONT_PERSON_3")."', '".$this->getField("MBANK_JAB_PERSON_1")."',
						'".$this->getField("MBANK_JAB_PERSON_2")."', '".$this->getField("MBANK_JAB_PERSON_3")."', '".$this->getField("MBANK_NOTELP_PERSON_1")."',
						'".$this->getField("MBANK_NOTELP_PERSON_2")."', '".$this->getField("MBANK_NOTELP_PERSON_3")."', 'A',
						".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."',
						'".$this->getField("MBANK_KODE_BB")."', '".$this->getField("NO_REK_PELINDO")."', '".$this->getField("MBANK_KARTU_BB")."',
						'".$this->getField("NO_URUT")."'
						)";
				
		$this->id = $this->getField("SAFM_BANK_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE SAFM_BANK
				SET    
					   KD_CABANG	         = '".$this->getField("KD_CABANG")."',
					   JENIS_TABLE   	     = '".$this->getField("JENIS_TABLE")."',
					   ID_TABLE         	 = '".$this->getField("ID_TABLE")."',
					   MBANK_KODE            = '".$this->getField("MBANK_KODE")."',
					   MBANK_NAMA            = '".$this->getField("MBANK_NAMA")."',
					   MBANK_CABANG          = '".$this->getField("MBANK_CABANG")."',
					   MBANK_ALAMAT          = '".$this->getField("MBANK_ALAMAT")."',
					   MBANK_NO_TELEPON      = '".$this->getField("MBANK_NO_TELEPON")."',
					   MBANK_CONT_PERSON_1   = '".$this->getField("MBANK_CONT_PERSON_1")."',
					   MBANK_CONT_PERSON_2   = '".$this->getField("MBANK_CONT_PERSON_2")."',
					   MBANK_CONT_PERSON_3   = '".$this->getField("MBANK_CONT_PERSON_3")."',
					   MBANK_JAB_PERSON_1    = '".$this->getField("MBANK_JAB_PERSON_1")."',
					   MBANK_JAB_PERSON_2    = '".$this->getField("MBANK_JAB_PERSON_2")."',
					   MBANK_JAB_PERSON_3    = '".$this->getField("MBANK_JAB_PERSON_3")."',
					   MBANK_NOTELP_PERSON_1 = '".$this->getField("MBANK_NOTELP_PERSON_1")."',
					   MBANK_NOTELP_PERSON_2 = '".$this->getField("MBANK_NOTELP_PERSON_2")."',
					   MBANK_NOTELP_PERSON_3 = '".$this->getField("MBANK_NOTELP_PERSON_3")."',
					   LAST_UPDATE_DATE      = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY       = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME          = '".$this->getField("PROGRAM_NAME")."',
					   MBANK_KODE_BB         = '".$this->getField("MBANK_KODE_BB")."',
					   NO_REK_PELINDO        = '".$this->getField("NO_REK_PELINDO")."',
					   MBANK_KARTU_BB        = '".$this->getField("MBANK_KARTU_BB")."',
					   NO_URUT               = '".$this->getField("NO_URUT")."'
				WHERE   MBANK_KODE            = '".$this->getField("MBANK_KODE")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM SAFM_BANK
                WHERE 
                   MBANK_KODE            = '".$this->getField("MBANK_KODE")."'"; 
				  
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
				MBANK_KODE, MBANK_NAMA, MBANK_CABANG, 
				MBANK_ALAMAT, MBANK_NO_TELEPON, MBANK_CONT_PERSON_1, 
				MBANK_CONT_PERSON_2, MBANK_CONT_PERSON_3, MBANK_JAB_PERSON_1, 
				MBANK_JAB_PERSON_2, MBANK_JAB_PERSON_3, MBANK_NOTELP_PERSON_1, 
				MBANK_NOTELP_PERSON_2, MBANK_NOTELP_PERSON_3, KD_AKTIF, 
				LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
				MBANK_KODE_BB, NO_REK_PELINDO, MBANK_KARTU_BB, 
				NO_URUT
				FROM SAFM_BANK
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

    function selectByParamsPencarian($paramsArray=array(),$limit=-1,$from=-1, $statement="",$sOrder="ORDER BY MBANK_KODE ASC")
	{
		$str = "
				SELECT MBANK_KODE_BB, MBANK_KODE, MBANK_NAMA 
				FROM SAFM_BANK A, KBBR_BUKU_BESAR B
				WHERE A.KD_AKTIF = 'A' AND A.MBANK_KODE_BB = B.KD_BUKU_BESAR
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
				MBANK_KODE, MBANK_NAMA, MBANK_CABANG, 
				MBANK_ALAMAT, MBANK_NO_TELEPON, MBANK_CONT_PERSON_1, 
				MBANK_CONT_PERSON_2, MBANK_CONT_PERSON_3, MBANK_JAB_PERSON_1, 
				MBANK_JAB_PERSON_2, MBANK_JAB_PERSON_3, MBANK_NOTELP_PERSON_1, 
				MBANK_NOTELP_PERSON_2, MBANK_NOTELP_PERSON_3, KD_AKTIF, 
				LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
				MBANK_KODE_BB, NO_REK_PELINDO, MBANK_KARTU_BB, 
				NO_URUT
				FROM SAFM_BANK
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
	
	function selectByParamsBank($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT MBANK_KODE KODE, MBANK_NAMA BANK 
				FROM SAFM_BANK
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." GROUP BY MBANK_KODE, MBANK_NAMA ORDER BY MBANK_KODE ASC,  MBANK_NAMA ASC ";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(MBANK_NAMA) AS ROWCOUNT FROM SAFM_BANK
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

    function getCountByParamsPencarian($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(MBANK_NAMA) AS ROWCOUNT FROM SAFM_BANK A, KBBR_BUKU_BESAR B
				WHERE SAFM_BANK.KD_AKTIF = 'A' AND A.MBANK_KODE_BB = B.KD_BUKU_BESAR ".$statement; 
		
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
		$str = "SELECT COUNT(SAFM_BANK_ID) AS ROWCOUNT FROM SAFM_BANK
		        WHERE SAFM_BANK_ID IS NOT NULL ".$statement; 
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