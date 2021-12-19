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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_KARTU_TAMBAH.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrKartuTambah extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrKartuTambah()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBR_KARTU_TAMBAH_ID", $this->getNextId("KBBR_KARTU_TAMBAH_ID","KBBR_KARTU_TAMBAH")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_KARTU_TAMBAH (
				   KD_CABANG, ID_JEN_KARTU, GRUP_KARTU, 
				   KD_SUB_BANTU, NM_SUB_BANTU, REF_MBANTU, 
				   KETERANGAN, FLAG_PELANGGAN, FLAG_KLIENT, 
				   FLAG_DETAIL, KD_AKTIF, LAST_UPDATE_DATE, 
				   LAST_UPDATED_BY, PROGRAM_NAME) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("ID_JEN_KARTU")."', '".$this->getField("GRUP_KARTU")."',
					'".$this->getField("KD_SUB_BANTU")."', '".$this->getField("NM_SUB_BANTU")."', '".$this->getField("REF_MBANTU")."',
					'".$this->getField("KETERANGAN")."', '".$this->getField("FLAG_PELANGGAN")."', '".$this->getField("FLAG_KLIENT")."',
					'".$this->getField("FLAG_DETAIL")."', '".$this->getField("KD_AKTIF")."', ".$this->getField("LAST_UPDATE_DATE").",
					'".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."'
				)";
				
		$this->id = $this->getField("KBBR_KARTU_TAMBAH_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_KARTU_TAMBAH
				SET    
					   KD_CABANG        = '".$this->getField("KD_CABANG")."',
					   ID_JEN_KARTU     = '".$this->getField("ID_JEN_KARTU")."',
					   GRUP_KARTU       = '".$this->getField("GRUP_KARTU")."',
					   KD_SUB_BANTU     = '".$this->getField("KD_SUB_BANTU")."',
					   NM_SUB_BANTU     = '".$this->getField("NM_SUB_BANTU")."',
					   REF_MBANTU       = '".$this->getField("REF_MBANTU")."',
					   KETERANGAN       = '".$this->getField("KETERANGAN")."',
					   FLAG_PELANGGAN   = '".$this->getField("FLAG_PELANGGAN")."',
					   FLAG_KLIENT      = '".$this->getField("FLAG_KLIENT")."',
					   FLAG_DETAIL      = '".$this->getField("FLAG_DETAIL")."',
					   KD_AKTIF         = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."'
				WHERE  KBBR_KARTU_TAMBAH_ID = '".$this->getField("KBBR_KARTU_TAMBAH_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_KARTU_TAMBAH
                WHERE 
                  KBBR_KARTU_TAMBAH_ID = ".$this->getField("KBBR_KARTU_TAMBAH_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT KD_CABANG, ID_JEN_KARTU, GRUP_KARTU, 
				KD_SUB_BANTU, NM_SUB_BANTU, REF_MBANTU, 
				KETERANGAN, FLAG_PELANGGAN, FLAG_KLIENT, 
				FLAG_DETAIL, KD_AKTIF, LAST_UPDATE_DATE, 
				LAST_UPDATED_BY, PROGRAM_NAME
				FROM KBBR_KARTU_TAMBAH
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
				SELECT KD_CABANG, ID_JEN_KARTU, GRUP_KARTU, 
				KD_SUB_BANTU, NM_SUB_BANTU, REF_MBANTU, 
				KETERANGAN, FLAG_PELANGGAN, FLAG_KLIENT, 
				FLAG_DETAIL, KD_AKTIF, LAST_UPDATE_DATE, 
				LAST_UPDATED_BY, PROGRAM_NAME
				FROM KBBR_KARTU_TAMBAH
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
		$str = "SELECT COUNT(KBBR_KARTU_TAMBAH_ID) AS ROWCOUNT FROM KBBR_KARTU_TAMBAH
		        WHERE KBBR_KARTU_TAMBAH_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KBBR_KARTU_TAMBAH_ID) AS ROWCOUNT FROM KBBR_KARTU_TAMBAH
		        WHERE KBBR_KARTU_TAMBAH_ID IS NOT NULL ".$statement; 
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