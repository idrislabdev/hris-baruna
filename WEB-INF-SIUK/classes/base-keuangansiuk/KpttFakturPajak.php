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
  * EntitySIUK-base class untuk mengimplementasikan tabel KPTT_FAKTUR_PAJAK.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KpttFakturPajak extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KpttFakturPajak()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KPTT_FAKTUR_PAJAK_ID", $this->getNextId("KPTT_FAKTUR_PAJAK_ID","KPTT_FAKTUR_PAJAK")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KPTT_FAKTUR_PAJAK (
					   KD_CABANG, NO_URUT, PERIODE, 
					   TIPE_TRANS, ID_JASA, NO_STOP, 
					   KD_VALUTA, KODE_SEGMEN) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("NO_URUT")."', '".$this->getField("PERIODE")."',
						'".$this->getField("TIPE_TRANS")."', '".$this->getField("ID_JASA")."', '".$this->getField("NO_STOP")."',
						'".$this->getField("KD_VALUTA")."', '".$this->getField("KODE_SEGMEN")."'
						)";
				
		$this->id = $this->getField("KPTT_FAKTUR_PAJAK_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KPTT_FAKTUR_PAJAK
				SET  
					   KD_CABANG   = '".$this->getField("KD_CABANG")."',
					   NO_URUT     = '".$this->getField("NO_URUT")."',
					   PERIODE     = '".$this->getField("PERIODE")."',
					   TIPE_TRANS  = '".$this->getField("TIPE_TRANS")."',
					   ID_JASA     = '".$this->getField("ID_JASA")."',
					   NO_STOP     = '".$this->getField("NO_STOP")."',
					   KD_VALUTA   = '".$this->getField("KD_VALUTA")."',
					   KODE_SEGMEN = '".$this->getField("KODE_SEGMEN")."'
				WHERE  KPTT_FAKTUR_PAJAK_ID = '".$this->getField("KPTT_FAKTUR_PAJAK_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KPTT_FAKTUR_PAJAK
                WHERE 
                  KPTT_FAKTUR_PAJAK_ID = ".$this->getField("KPTT_FAKTUR_PAJAK_ID").""; 
				  
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
				SELECT KD_CABANG, NO_URUT, PERIODE, 
				TIPE_TRANS, ID_JASA, NO_STOP, 
				KD_VALUTA, KODE_SEGMEN
				FROM KPTT_FAKTUR_PAJAK
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KPTT_FAKTUR_PAJAK_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, NO_URUT, PERIODE, 
				TIPE_TRANS, ID_JASA, NO_STOP, 
				KD_VALUTA, KODE_SEGMEN
				FROM KPTT_FAKTUR_PAJAK
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NO_JUDUL ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KPTT_FAKTUR_PAJAK_ID) AS ROWCOUNT FROM KPTT_FAKTUR_PAJAK
		        WHERE KPTT_FAKTUR_PAJAK_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KPTT_FAKTUR_PAJAK_ID) AS ROWCOUNT FROM KPTT_FAKTUR_PAJAK
		        WHERE KPTT_FAKTUR_PAJAK_ID IS NOT NULL ".$statement; 
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