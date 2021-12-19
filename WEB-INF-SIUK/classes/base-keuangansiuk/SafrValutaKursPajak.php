
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
  * EntitySIUK-base class untuk mengimplementasikan tabel SAFR_VALUTA_KURS_PAJAK.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class SafrValutaKursPajak extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SafrValutaKursPajak()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SAFR_VALUTA_KURS_PAJAK_ID", $this->getNextId("SAFR_VALUTA_KURS_PAJAK_ID","SAFR_VALUTA_KURS_PAJAK")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO SAFR_VALUTA_KURS_PAJAK (
					   KD_CABANG, NOMOR_SURAT, JENIS_TABLE, ID_TABLE, 
					   KODE_VALUTA, TGL_MULAI_RATE, TGL_AKHIR_RATE, 
					   NILAI_RATE, KET_KETENTUAN_RATE, TGL_KETENTUAN_RATE, 
					   KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY,
					   PROGRAM_NAME) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("NOMOR_SURAT")."', '".$this->getField("JENIS_TABLE")."', 
						'".$this->getField("ID_TABLE")."', '".$this->getField("KODE_VALUTA")."',".$this->getField("TGL_MULAI_RATE").", 
						".$this->getField("TGL_AKHIR_RATE").",'".$this->getField("NILAI_RATE")."', '".$this->getField("KET_KETENTUAN_RATE")."', 
						".$this->getField("TGL_KETENTUAN_RATE").",'".$this->getField("KD_AKTIF")."', ".$this->getField("LAST_UPDATE_DATE").", 
						'".$this->getField("LAST_UPDATED_BY")."','".$this->getField("PROGRAM_NAME")."'
				)";
				
		$this->id = $this->getField("SAFR_VALUTA_KURS_PAJAK_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE SAFR_VALUTA_KURS_PAJAK
				SET    
					   KD_CABANG          = '".$this->getField("KD_CABANG")."',
					   JENIS_TABLE        = '".$this->getField("JENIS_TABLE")."',
					   ID_TABLE           = '".$this->getField("ID_TABLE")."',
					   NOMOR_SURAT        = '".$this->getField("NOMOR_SURAT")."',
					   KODE_VALUTA        = '".$this->getField("KODE_VALUTA")."',
					   TGL_MULAI_RATE     = ".$this->getField("TGL_MULAI_RATE").",
					   TGL_AKHIR_RATE     = ".$this->getField("TGL_AKHIR_RATE").",
					   NILAI_RATE         = '".$this->getField("NILAI_RATE")."',
					   KET_KETENTUAN_RATE = '".$this->getField("KET_KETENTUAN_RATE")."',
					   TGL_KETENTUAN_RATE = ".$this->getField("TGL_KETENTUAN_RATE").",
					   KD_AKTIF           = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE   = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY    = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME       = '".$this->getField("PROGRAM_NAME")."'
				WHERE  TGL_MULAI_RATE     = ".$this->getField("TGL_MULAI_RATE")."
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function updateFileFormat()
	{
		$str = "
				UPDATE SAFR_VALUTA_KURS_PAJAK
				SET    
					   FILE_FORMAT     		  = '".$this->getField("FILE_FORMAT")."'
				WHERE  TGL_MULAI_RATE    	  = ".$this->getField("TGL_MULAI_RATE")."
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function updateFileNama()
	{
		$str = "
				UPDATE SAFR_VALUTA_KURS_PAJAK
				SET    
					   FILE_NAMA     		  = '".$this->getField("FILE_NAMA")."'
				WHERE  TGL_MULAI_RATE    	  = ".$this->getField("TGL_MULAI_RATE")."
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
			
	function delete()
	{
        $str = "DELETE FROM SAFR_VALUTA_KURS_PAJAK
                WHERE 
                  TGL_MULAI_RATE     = ".$this->getField("TGL_MULAI_RATE")."
				  "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
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
				SELECT KD_CABANG, JENIS_TABLE, ID_TABLE, 
				KODE_VALUTA, TGL_MULAI_RATE, TGL_AKHIR_RATE, 
				NILAI_RATE, KET_KETENTUAN_RATE, TGL_KETENTUAN_RATE, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME, TGL_MULAI_RATE ID, (CASE WHEN KD_AKTIF='A' THEN 'AKTIF'
				WHEN KD_AKTIF='D' THEN 'TIDAK AKTIF' END) AS KD_DESC, NOMOR_SURAT, FILE_UPLOAD, FILE_NAMA
				FROM SAFR_VALUTA_KURS_PAJAK
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
				SELECT KD_CABANG, JENIS_TABLE, ID_TABLE, 
				KODE_VALUTA, TGL_MULAI_RATE, TGL_AKHIR_RATE, 
				NILAI_RATE, KET_KETENTUAN_RATE, TGL_KETENTUAN_RATE, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME
				FROM SAFR_VALUTA_KURS_PAJAK
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY TGL_MULAI_RATE DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KODE_VALUTA) AS ROWCOUNT FROM SAFR_VALUTA_KURS_PAJAK
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
		$str = "SELECT COUNT(SAFR_VALUTA_KURS_PAJAK_ID) AS ROWCOUNT FROM SAFR_VALUTA_KURS_PAJAK
		        WHERE SAFR_VALUTA_KURS_PAJAK_ID IS NOT NULL ".$statement; 
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