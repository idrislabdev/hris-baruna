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

  class InventarisPenyusutan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function InventarisPenyusutan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("INVENTARIS_PENYUSUTAN_ID", $this->getNextId("INVENTARIS_PENYUSUTAN_ID","PPI_ASSET.INVENTARIS_PENYUSUTAN")); 
		$str = "
				INSERT INTO PPI_ASSET.INVENTARIS_PENYUSUTAN (
				   INVENTARIS_PENYUSUTAN_ID, JENIS_SUSUT_ID, NAMA, 
				   TANGGAL, TANGGAL_SUSUT, KETERANGAN, 
				   LAST_CREATE_USER, LAST_CREATE_DATE) 
				VALUES (
						".$this->getField("INVENTARIS_PENYUSUTAN_ID").", 
						'".$this->getField("JENIS_SUSUT_ID")."', 
						'".$this->getField("NAMA")."', 
						".$this->getField("TANGGAL").", 
						".$this->getField("TANGGAL_SUSUT").", 
						'".$this->getField("KETERANGAN")."', 
						'".$this->getField("LAST_CREATE_USER")."', 
						".$this->getField("LAST_CREATE_DATE")."
						)"; 
		$this->id = $this->getField("INVENTARIS_PENYUSUTAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVENTARIS_PENYUSUTAN
				SET   
					   JENIS_SUSUT_ID           = '".$this->getField("JENIS_SUSUT_ID")."',
					   NAMA                     = '".$this->getField("NAMA")."',
					   TANGGAL                  = ".$this->getField("TANGGAL").",
					   TANGGAL_SUSUT            = ".$this->getField("TANGGAL_SUSUT").",
					   KETERANGAN               = '".$this->getField("KETERANGAN")."',
					   LAST_UPDATE_USER         = '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE         = ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  INVENTARIS_PENYUSUTAN_ID = '".$this->getField("INVENTARIS_PENYUSUTAN_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str1 = "DELETE FROM PPI_ASSET.INVENTARIS_PENYUSUTAN_DETIL
                WHERE 
                  INVENTARIS_PENYUSUTAN_ID = ".$this->getField("INVENTARIS_PENYUSUTAN_ID").""; 
				  
		$this->query = $str1;
		//echo $str;
        $this->execQuery($str1);
		
        $str = "DELETE FROM PPI_ASSET.INVENTARIS_PENYUSUTAN
                WHERE 
                  INVENTARIS_PENYUSUTAN_ID = ".$this->getField("INVENTARIS_PENYUSUTAN_ID").""; 
				  
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
				INVENTARIS_PENYUSUTAN_ID, JENIS_SUSUT_ID, NAMA, 
				   TANGGAL, TANGGAL_SUSUT, KETERANGAN, 
				   LAST_CREATE_USER, LAST_CREATE_DATE, LAST_UPDATE_USER, 
				   LAST_UPDATE_DATE
				FROM PPI_ASSET.INVENTARIS_PENYUSUTAN
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

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
                SELECT 
                INVENTARIS_PENYUSUTAN_ID, A.JENIS_SUSUT_ID, A.NAMA, 
                   TANGGAL, TANGGAL_SUSUT, A.KETERANGAN, 
                   LAST_CREATE_USER, LAST_CREATE_DATE, LAST_UPDATE_USER, 
                   LAST_UPDATE_DATE, B.NAMA JENIS_SUSUT
                FROM PPI_ASSET.INVENTARIS_PENYUSUTAN A
                INNER JOIN PPI_ASSET.JENIS_SUSUT B ON A.JENIS_SUSUT_ID = B.JENIS_SUSUT_ID
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

    function selectByParamsRekapitulasi($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
                B.NAMA JENIS_SUSUT, E.NAMA || ' - ' || E.SPESIFIKASI INVENTARIS, D.NOMOR, D.BARCODE, D.PEROLEHAN_PERIODE, D.PEROLEHAN_HARGA,
                TANGGAL_SUSUT, A.KETERANGAN 
                FROM PPI_ASSET.INVENTARIS_PENYUSUTAN A
                INNER JOIN PPI_ASSET.JENIS_SUSUT B ON A.JENIS_SUSUT_ID = B.JENIS_SUSUT_ID
                INNER JOIN PPI_ASSET.INVENTARIS_PENYUSUTAN_DETIL C ON A.INVENTARIS_PENYUSUTAN_ID = C.INVENTARIS_PENYUSUTAN_ID
                INNER JOIN PPI_ASSET.INVENTARIS_RUANGAN D ON D.INVENTARIS_RUANGAN_ID = C.INVENTARIS_RUANGAN_ID
                INNER JOIN PPI_ASSET.INVENTARIS E ON E.INVENTARIS_ID = D.INVENTARIS_ID
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
				INVENTARIS_PENYUSUTAN_ID, JENIS_SUSUT_ID, NAMA, 
				   TANGGAL, TANGGAL_SUSUT, KETERANGAN, 
				   LAST_CREATE_USER, LAST_CREATE_DATE, LAST_UPDATE_USER, 
				   LAST_UPDATE_DATE
				FROM PPI_ASSET.INVENTARIS_PENYUSUTAN
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY INVENTARIS_PENYUSUTAN_ID DESC";
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
		$str = "SELECT COUNT(INVENTARIS_PENYUSUTAN_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_PENYUSUTAN  WHERE 1 = 1 ".$statement; 
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

    function getCountByParamsRekapitulasi($paramsArray=array(), $statement="")
	{
		$str = "	SELECT 
                COUNT(INVENTARIS_PENYUSUTAN_ID) AS ROWCOUNT
                FROM PPI_ASSET.INVENTARIS_PENYUSUTAN A
                INNER JOIN PPI_ASSET.JENIS_SUSUT B ON A.JENIS_SUSUT_ID = B.JENIS_SUSUT_ID
                INNER JOIN PPI_ASSET.INVENTARIS_PENYUSUTAN_DETIL C ON A.INVENTARIS_PENYUSUTAN_ID = C.INVENTARIS_PENYUSUTAN_ID
                INNER JOIN PPI_ASSET.INVENTARIS_RUANGAN D ON D.INVENTARIS_RUANGAN_ID = C.INVENTARIS_RUANGAN_ID
                INNER JOIN PPI_ASSET.INVENTARIS E ON E.INVENTARIS_ID = D.INVENTARIS_ID
                WHERE 1 = 1     ".$statement; 
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
		$str = "SELECT COUNT(INVENTARIS_PENYUSUTAN_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_PENYUSUTAN WHERE 1 = 1 "; 
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