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

  class InventarisKartuKendali extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function InventarisKartuKendali()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("INVENTARIS_KARTU_KENDALI_ID", $this->getNextId("INVENTARIS_KARTU_KENDALI_ID","PPI_ASSET.INVENTARIS_KARTU_KENDALI")); 
		$str = "
				INSERT INTO PPI_ASSET.INVENTARIS_KARTU_KENDALI (
				   INVENTARIS_KARTU_KENDALI_ID, KONDISI_FISIK_ID, INVENTARIS_RUANGAN_ID, 
				   TANGGAL, KETERANGAN, PENYUSUTAN, KONDISI_FISIK_PROSENTASE, PERIODE,
				   NILAI_BUKU, LAST_CREATE_USER, LAST_CREATE_DATE) 
				VALUES (
						".$this->getField("INVENTARIS_KARTU_KENDALI_ID").", 
						".$this->getField("KONDISI_FISIK_ID").", 
						".$this->getField("INVENTARIS_RUANGAN_ID").", 
						".$this->getField("TANGGAL").", 
						'".$this->getField("KETERANGAN")."', 
						".$this->getField("PENYUSUTAN").", 
						".$this->getField("KONDISI_FISIK_PROSENTASE").", 
						'".$this->getField("PERIODE")."',
						".$this->getField("NILAI_BUKU").", 
						'".$this->getField("LAST_CREATE_USER")."', 
						".$this->getField("LAST_CREATE_DATE")."
						)"; 
		$this->id = $this->getField("INVENTARIS_KARTU_KENDALI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVENTARIS_KARTU_KENDALI
				SET   
					   KONDISI_FISIK_ID            = '".$this->getField("KONDISI_FISIK_ID")."',
					   INVENTARIS_RUANGAN_ID       = '".$this->getField("INVENTARIS_RUANGAN_ID")."',
					   TANGGAL                     = ".$this->getField("TANGGAL").",
					   KETERANGAN                  = '".$this->getField("KETERANGAN")."',
					   PENYUSUTAN                  = '".$this->getField("PENYUSUTAN")."',
					   KONDISI_FISIK_PROSENTASE	   = '".$this->getField("KONDISI_FISIK_PROSENTASE")."', 
					   PERIODE					   = '".$this->getField("PERIODE")."',
					   NILAI_BUKU                  = '".$this->getField("NILAI_BUKU")."',
					   LAST_UPDATE_USER            = '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE            = ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  INVENTARIS_KARTU_KENDALI_ID = '".$this->getField("INVENTARIS_KARTU_KENDALI_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.INVENTARIS_KARTU_KENDALI
                WHERE 
                  INVENTARIS_KARTU_KENDALI_ID = ".$this->getField("INVENTARIS_KARTU_KENDALI_ID").""; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }

	function deleteByInventarisPeriode()
	{
        $str = "DELETE FROM PPI_ASSET.INVENTARIS_KARTU_KENDALI
                WHERE 
                  INVENTARIS_RUANGAN_ID = '".$this->getField("INVENTARIS_RUANGAN_ID")."' AND PERIODE = '".$this->getField("PERIODE")."'"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
	
	function deleteByLokasi()
	{
        $str = "DELETE FROM PPI_ASSET.INVENTARIS_KARTU_KENDALI A
                WHERE PERIODE = '".$this->getField("PERIODE")."' AND EXISTS(SELECT 1 FROM PPI_ASSET.INVENTARIS_RUANGAN X WHERE X.INVENTARIS_RUANGAN_ID = A.INVENTARIS_RUANGAN_ID AND X.LOKASI_ID = '".$this->getField("LOKASI_ID")."')
               "; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
	
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				INVENTARIS_KARTU_KENDALI_ID, KONDISI_FISIK_ID, INVENTARIS_RUANGAN_ID, 
				   TANGGAL, KETERANGAN, PENYUSUTAN, 
				   NILAI_BUKU, LAST_CREATE_USER, LAST_CREATE_DATE, 
				   LAST_UPDATE_USER, LAST_UPDATE_DATE, KONDISI_FISIK_PROSENTASE, PERIODE
				FROM PPI_ASSET.INVENTARIS_KARTU_KENDALI A
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
				INVENTARIS_KARTU_KENDALI_ID, KONDISI_FISIK_ID, INVENTARIS_RUANGAN_ID, 
				   TANGGAL, KETERANGAN, PENYUSUTAN, 
				   NILAI_BUKU, LAST_CREATE_USER, LAST_CREATE_DATE, 
				   LAST_UPDATE_USER, LAST_UPDATE_DATE
				FROM PPI_ASSET.INVENTARIS_KARTU_KENDALI
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY INVENTARIS_KARTU_KENDALI_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(INVENTARIS_KARTU_KENDALI_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_KARTU_KENDALI  WHERE 1 = 1 ".$statement; 
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

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(INVENTARIS_KARTU_KENDALI_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_KARTU_KENDALI WHERE 1 = 1 "; 
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