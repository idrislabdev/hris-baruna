<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class InventarisLokasiHistori extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function InventarisLokasiHistori()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_ASSET.INVENTARIS_LOKASI_HISTORI (
				   INVENTARIS_RUANGAN_ID, LOKASI_ID, NOMOR, BARCODE,
				   TMT) 
				VALUES (
						'".$this->getField("INVENTARIS_RUANGAN_ID")."', 
						'".$this->getField("LOKASI_ID")."',  
						'".$this->getField("NOMOR")."',  
						'".$this->getField("BARCODE")."', 
						".$this->getField("TMT")."
						)"; 
		$this->id = $this->getField("INVENTARIS_LOKASI_HISTORI_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function insertLokasi()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_ASSET.INVENTARIS_LOKASI_HISTORI (
				   INVENTARIS_RUANGAN_ID, LOKASI_ID, 
				   NOMOR, BARCODE, TMT, LAST_CREATE_USER, LAST_CREATE_DATE) 
				SELECT INVENTARIS_RUANGAN_ID, LOKASI_ID, 
				   NOMOR, BARCODE, PEROLEHAN_TANGGAL, '".$this->getField("LAST_CREATE_USER")."', CURRENT_DATE FROM PPI_ASSET.INVENTARIS_RUANGAN
				   WHERE INVENTARIS_RUANGAN_ID = '".$this->getField("INVENTARIS_RUANGAN_ID")."'"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function insertLokasiPindah()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_ASSET.INVENTARIS_LOKASI_HISTORI (
				   INVENTARIS_RUANGAN_ID, LOKASI_ID, 
				   NOMOR, BARCODE, TMT, LAST_CREATE_USER, LAST_CREATE_DATE) 
				SELECT INVENTARIS_RUANGAN_ID, LOKASI_ID, 
				   NOMOR, BARCODE, ".$this->getField("TMT").", '".$this->getField("LAST_CREATE_USER")."', CURRENT_DATE FROM PPI_ASSET.INVENTARIS_RUANGAN
				   WHERE INVENTARIS_RUANGAN_ID = '".$this->getField("INVENTARIS_RUANGAN_ID")."'"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
		
    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVENTARIS_LOKASI_HISTORI
				SET    
					   LOKASI_ID						  = '".$this->getField("LOKASI_ID")."',  
					   NOMOR                       = '".$this->getField("NOMOR")."',
					   BARCODE					  = '".$this->getField("BARCODE")."',
					   TMT                 = '".$this->getField("TMT")."'
				WHERE  INVENTARIS_RUANGAN_ID       			  = '".$this->getField("INVENTARIS_RUANGAN_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.INVENTARIS_LOKASI_HISTORI
                WHERE 
                  INVENTARIS_RUANGAN_ID = ".$this->getField("INVENTARIS_RUANGAN_ID").""; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","NOMOR"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				INVENTARIS_RUANGAN_ID, NOMOR, LOKASI_ID, BARCODE, TMT
				FROM PPI_ASSET.INVENTARIS_LOKASI_HISTORI
				WHERE 1 = 1
			"; 
		
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
				SELECT 
				INVENTARIS_RUANGAN_ID, NOMOR, BARCODE,
				   TMT
				FROM PPI_ASSET.INVENTARIS_LOKASI_HISTORI
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY INVENTARIS_RUANGAN_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","NOMOR"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(INVENTARIS_RUANGAN_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_LOKASI_HISTORI  WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getINVENTARIS_LOKASI_HISTORI($INVENTARIS_LOKASI_HISTORIId)
	{
		$str = "SELECT AMBIL_INVENTARIS_LOKASI_HISTORI_INVENTARIS('".$INVENTARIS_LOKASI_HISTORIId."') AS ROWCOUNT FROM PPI_ASSET.DUAL  WHERE 1 = 1 ".$statement; 
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(INVENTARIS_RUANGAN_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_LOKASI_HISTORI WHERE 1 = 1 "; 
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