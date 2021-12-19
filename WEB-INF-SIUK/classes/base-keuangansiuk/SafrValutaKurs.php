
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
  * EntitySIUK-base class untuk mengimplementasikan tabel SAFR_VALUTA_KURS.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class SafrValutaKurs extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SafrValutaKurs()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SAFR_VALUTA_KURS_ID", $this->getNextId("SAFR_VALUTA_KURS_ID","SAFR_VALUTA_KURS")); 		
		//'".$this->getField("FOTO")."',  FOTO,

		$str = "
				INSERT INTO SAFR_VALUTA_KURS (
					   KD_CABANG, JENIS_TABLE, ID_TABLE, 
					   KODE_VALUTA, TGL_MULAI_RATE, TGL_AKHIR_RATE, 
					   NILAI_RATE, KET_KETENTUAN_RATE, TGL_KETENTUAN_RATE, 
					   KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
					   PROGRAM_NAME) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("JENIS_TABLE")."', '".$this->getField("ID_TABLE")."',
						'".$this->getField("KODE_VALUTA")."', ".$this->getField("TGL_MULAI_RATE").", ".$this->getField("TGL_AKHIR_RATE").",
						'".$this->getField("NILAI_RATE")."', '".$this->getField("KET_KETENTUAN_RATE")."', ".$this->getField("TGL_KETENTUAN_RATE").",
						'".$this->getField("KD_AKTIF")."', ".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."',
						'".$this->getField("PROGRAM_NAME")."'
				)";
				
		$this->id = $this->getField("SAFR_VALUTA_KURS_ID");
		$this->query = $str;
		echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE SAFR_VALUTA_KURS
				SET    
					   KD_CABANG          = '".$this->getField("KD_CABANG")."',
					   JENIS_TABLE        = '".$this->getField("JENIS_TABLE")."',
					   ID_TABLE           = '".$this->getField("ID_TABLE")."',
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
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM SAFR_VALUTA_KURS
                WHERE 
                 TGL_MULAI_RATE     = ".$this->getField("TGL_MULAI_RATE")."
				 "; 
				  
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
				SELECT KD_CABANG, JENIS_TABLE, ID_TABLE, 
				KODE_VALUTA, TGL_MULAI_RATE, TGL_AKHIR_RATE, 
				NILAI_RATE, KET_KETENTUAN_RATE, TGL_KETENTUAN_RATE, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME, TGL_MULAI_RATE ID,(CASE WHEN KD_AKTIF='A' THEN 'AKTIF'
				WHEN KD_AKTIF='D' THEN 'TIDAK AKTIF' END) AS KD_DESC
				FROM SAFR_VALUTA_KURS
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
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT KD_CABANG, JENIS_TABLE, ID_TABLE, 
				KODE_VALUTA, TGL_MULAI_RATE, TGL_AKHIR_RATE, 
				NILAI_RATE, KET_KETENTUAN_RATE, TGL_KETENTUAN_RATE, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME
				FROM SAFR_VALUTA_KURS
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KODE_VALUTA) AS ROWCOUNT FROM SAFR_VALUTA_KURS
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
		$str = "SELECT COUNT(SAFR_VALUTA_KURS_ID) AS ROWCOUNT FROM SAFR_VALUTA_KURS
		        WHERE SAFR_VALUTA_KURS_ID IS NOT NULL ".$statement; 
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