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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_BUKU_PUSAT.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrBukuPusat extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrBukuPusat()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("KD_BUKU_BESAR", $this->getNextId("KD_BUKU_BESAR","KBBR_BUKU_PUSAT")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_BUKU_PUSAT (
				   KD_CABANG, KD_BUKU_BESAR, NM_BUKU_BESAR, 
				   TIPE_REKENING, POLA_ENTRY, GRUP_DTL_KODE, 
				   GRUP_LEVEL1, GRUP_LEVEL2, GRUP_LEVEL3, 
				   GRUP_LEVEL4, GRUP_LEVEL5, KD_POSTING_BB, 
				   KD_POSTING_SUB, KODE_VALUTA, COA_ID, 
				   KET_TAMBAHAN, KD_AKTIF, LAST_UPDATE_DATE, 
				   LAST_UPDATED_BY, PROGRAM_NAME) 
				VALUES ( '".$this->getField("KD_CABANG")."', '".$this->getField("KD_BUKU_BESAR")."', '".$this->getField("NM_BUKU_BESAR")."',
					'".$this->getField("TIPE_REKENING")."', '".$this->getField("POLA_ENTRY")."', '".$this->getField("GRUP_DTL_KODE")."',
					'".$this->getField("GRUP_LEVEL1")."', '".$this->getField("GRUP_LEVEL2")."', '".$this->getField("GRUP_LEVEL3")."',
					'".$this->getField("GRUP_LEVEL4")."', '".$this->getField("GRUP_LEVEL5")."', '".$this->getField("KD_POSTING_BB")."', 
					'".$this->getField("KD_POSTING_SUB")."', '".$this->getField("KODE_VALUTA")."', '".$this->getField("COA_ID")."', 
					'".$this->getField("KET_TAMBAHAN")."', '".$this->getField("KD_AKTIF")."', ".$this->getField("LAST_UPDATE_DATE").", 
					'".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."'
				)";
				
		$this->id = $this->getField("KD_BUKU_BESAR");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_BUKU_PUSAT
				SET    
					   KD_CABANG        = '".$this->getField("KD_CABANG")."',
					   KD_BUKU_BESAR    = '".$this->getField("KD_BUKU_BESAR")."',
					   NM_BUKU_BESAR    = '".$this->getField("NM_BUKU_BESAR")."',
					   TIPE_REKENING    = '".$this->getField("TIPE_REKENING")."',
					   POLA_ENTRY       = '".$this->getField("POLA_ENTRY")."',
					   GRUP_DTL_KODE    = '".$this->getField("GRUP_DTL_KODE")."',
					   GRUP_LEVEL1      = '".$this->getField("GRUP_LEVEL1")."',
					   GRUP_LEVEL2      = '".$this->getField("GRUP_LEVEL2")."',
					   GRUP_LEVEL3      = '".$this->getField("GRUP_LEVEL3")."',
					   GRUP_LEVEL4      = '".$this->getField("GRUP_LEVEL4")."',
					   GRUP_LEVEL5      = '".$this->getField("GRUP_LEVEL5")."',
					   KD_POSTING_BB    = '".$this->getField("KD_POSTING_BB")."',
					   KD_POSTING_SUB   = '".$this->getField("KD_POSTING_SUB")."',
					   KODE_VALUTA      = '".$this->getField("KODE_VALUTA")."',
					   COA_ID           = '".$this->getField("COA_ID")."',
					   KET_TAMBAHAN     = '".$this->getField("KET_TAMBAHAN")."',
					   KD_AKTIF         = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."'
				WHERE  KD_BUKU_BESAR = '".$this->getField("KD_BUKU_BESAR_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_BUKU_PUSAT
                WHERE 
                  KD_BUKU_BESAR = '".$this->getField("KD_BUKU_BESAR_ID")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.KD_BUKU_BESAR ASC ")
	{
		$str = "
				SELECT A.KD_CABANG, KD_BUKU_BESAR, NM_BUKU_BESAR, 
				NAMA_GROUP TIPE_REKENING, CASE WHEN POLA_ENTRY = 0 THEN 'Buku Besar' WHEN POLA_ENTRY = 1 THEN 'Buku Besar & Kartu' END POLA_ENTRY, 
				GRUP_DTL_KODE, CASE WHEN GRUP_DTL_KODE='D' THEN 'DETAIL' WHEN GRUP_DTL_KODE='H' THEN 'HEADER' END GRUP_DTL_KODE_DESC,
				GRUP_LEVEL1, GRUP_LEVEL2, GRUP_LEVEL3, 
				GRUP_LEVEL4, GRUP_LEVEL5, KD_POSTING_BB, 
				KD_POSTING_SUB, KODE_VALUTA, COA_ID, 
				KET_TAMBAHAN, A.KD_AKTIF, A.LAST_UPDATE_DATE, 
				A.LAST_UPDATED_BY, A.PROGRAM_NAME, B.ID_GROUP
				FROM KBBR_BUKU_PUSAT A
                LEFT JOIN KBBR_GROUP_REK B ON TIPE_REKENING = ID_GROUP
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, KD_BUKU_BESAR, NM_BUKU_BESAR, 
				NAMA_GROUP TIPE_REKENING, CASE WHEN POLA_ENTRY = 0 THEN 'Buku Besar' WHEN POLA_ENTRY = 1 THEN 'Buku Besar & Kartu' END POLA_ENTRY, GRUP_DTL_KODE, 
				GRUP_LEVEL1, GRUP_LEVEL2, GRUP_LEVEL3, 
				GRUP_LEVEL4, GRUP_LEVEL5, KD_POSTING_BB, 
				KD_POSTING_SUB, KODE_VALUTA, COA_ID, 
				KET_TAMBAHAN, KD_AKTIF, LAST_UPDATE_DATE, 
				LAST_UPDATED_BY, PROGRAM_NAME
				FROM KBBR_BUKU_PUSAT A
                INNER JOIN KBBR_GROUP_REK B ON TIPE_REKENING = ID_GROUP
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
		$str = "SELECT COUNT(KD_BUKU_BESAR) AS ROWCOUNT FROM KBBR_BUKU_PUSAT
		        WHERE KD_BUKU_BESAR IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KD_BUKU_BESAR) AS ROWCOUNT FROM KBBR_BUKU_PUSAT
		        WHERE KD_BUKU_BESAR IS NOT NULL ".$statement; 
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