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

  class InventarisPerbaikan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function InventarisPerbaikan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("INVENTARIS_PERBAIKAN_ID", $this->getNextId("INVENTARIS_PERBAIKAN_ID","PPI_ASSET.INVENTARIS_PERBAIKAN")); 
		$str = "
				INSERT INTO PPI_ASSET.INVENTARIS_PERBAIKAN (
				   INVENTARIS_PERBAIKAN_ID, INVENTARIS_RUANGAN_ID, TANGGAL, 
				   KETERANGAN, TANGGAL_AWAL, TANGGAL_AKHIR, 
				   LAST_CREATE_USER, LAST_CREATE_DATE, KONDISI_FISIK_SEBELUM, KONDISI_FISIK_SESUDAH) 
				VALUES (
						".$this->getField("INVENTARIS_PERBAIKAN_ID").", 
						'".$this->getField("INVENTARIS_RUANGAN_ID")."', 
						".$this->getField("TANGGAL").", 
						'".$this->getField("KETERANGAN")."', 
						".$this->getField("TANGGAL_AWAL").", 
						".$this->getField("TANGGAL_AKHIR").", 
						'".$this->getField("LAST_CREATE_USER")."', 
						".$this->getField("LAST_CREATE_DATE").", 
						".$this->getField("KONDISI_FISIK_SEBELUM").", 
						".$this->getField("KONDISI_FISIK_SESUDAH")."
						)"; 
		$this->id = $this->getField("INVENTARIS_PERBAIKAN_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVENTARIS_PERBAIKAN
				SET    
					   INVENTARIS_RUANGAN_ID   = '".$this->getField("INVENTARIS_RUANGAN_ID")."',
					   TANGGAL                 = ".$this->getField("TANGGAL").",
					   KETERANGAN              = '".$this->getField("KETERANGAN")."',
					   KONDISI_FISIK_SEBELUM   = ".$this->getField("KONDISI_FISIK_SEBELUM").",
					   KONDISI_FISIK_SESUDAH   = ".$this->getField("KONDISI_FISIK_SESUDAH").",
					   TANGGAL_AWAL            = ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR           = ".$this->getField("TANGGAL_AKHIR").",
					   LAST_UPDATE_USER        = '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE        = ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  INVENTARIS_PERBAIKAN_ID = '".$this->getField("INVENTARIS_PERBAIKAN_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateValidasi()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVENTARIS_PERBAIKAN
				SET    
					   PERSETUJUAN			   = '".$this->getField("PERSETUJUAN")."',
					   PERSETUJUAN_OLEH		   = '".$this->getField("PERSETUJUAN_OLEH")."',
					   LAST_UPDATE_USER        = '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE        = ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  INVENTARIS_PERBAIKAN_ID = '".$this->getField("INVENTARIS_PERBAIKAN_ID")."'
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
		$str1 = "DELETE FROM PPI_ASSET.INVENTARIS_PERBAIKAN_DETIL
                WHERE 
                  INVENTARIS_PERBAIKAN_ID = ".$this->getField("INVENTARIS_PERBAIKAN_ID").""; 
				  
		$this->query = $str1;
		$this->execQuery($str1);
		
        $str = "DELETE FROM PPI_ASSET.INVENTARIS_PERBAIKAN
                WHERE 
                  INVENTARIS_PERBAIKAN_ID = ".$this->getField("INVENTARIS_PERBAIKAN_ID").""; 
				  
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
				INVENTARIS_PERBAIKAN_ID, A.INVENTARIS_RUANGAN_ID, TANGGAL, 
				  A.KETERANGAN, TANGGAL_AWAL, TANGGAL_AKHIR, C.NAMA INVENTARIS, B.NOMOR,
                   A.LAST_CREATE_USER, A.LAST_CREATE_DATE, A.LAST_UPDATE_USER, D.NAMA LOKASI,
                   A.LAST_UPDATE_DATE, A.KONDISI_FISIK_SEBELUM, A.KONDISI_FISIK_SESUDAH, E.NAMA KONDISI_SEBELUM, F.NAMA KONDISI_SESUDAH, B.PEROLEHAN_HARGA
                FROM PPI_ASSET.INVENTARIS_PERBAIKAN A
                INNER JOIN PPI_ASSET.INVENTARIS_RUANGAN B ON B.INVENTARIS_RUANGAN_ID=A.INVENTARIS_RUANGAN_ID
                INNER JOIN PPI_ASSET.INVENTARIS C ON C.INVENTARIS_ID = B.INVENTARIS_ID
                LEFT JOIN PPI_ASSET.LOKASI D ON B.LOKASI_ID = D.LOKASI_ID
                LEFT JOIN PPI_ASSET.KONDISI_FISIK E ON E.PROSENTASE = A.KONDISI_FISIK_SEBELUM
                LEFT JOIN PPI_ASSET.KONDISI_FISIK F ON F.PROSENTASE = A.KONDISI_FISIK_SESUDAH
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
				INVENTARIS_PERBAIKAN_ID, A.INVENTARIS_RUANGAN_ID, TANGGAL, 
				  A.KETERANGAN, TANGGAL_AWAL, TANGGAL_AKHIR, C.NAMA INVENTARIS, B.NOMOR,
                   A.LAST_CREATE_USER, A.LAST_CREATE_DATE, A.LAST_UPDATE_USER, D.NAMA LOKASI,
                   A.LAST_UPDATE_DATE, A.KONDISI_FISIK_SEBELUM, A.KONDISI_FISIK_SESUDAH, E.NAMA KONDISI_SEBELUM, F.NAMA KONDISI_SESUDAH, B.PEROLEHAN_HARGA
                FROM PPI_ASSET.INVENTARIS_PERBAIKAN A
				INNER JOIN PPI_ASSET.INVENTARIS_RUANGAN B ON A.INVENTARIS_RUANGAN_ID = B.INVENTARIS_RUANGAN_ID
				INNER JOIN PPI_ASSET.INVENTARIS C ON B.INVENTARIS_ID = C.INVENTARIS_ID
                LEFT JOIN PPI_ASSET.LOKASI D ON B.LOKASI_ID = D.LOKASI_ID
                LEFT JOIN PPI_ASSET.KONDISI_FISIK E ON E.PROSENTASE = A.KONDISI_FISIK_SEBELUM
                LEFT JOIN PPI_ASSET.KONDISI_FISIK F ON F.PROSENTASE = A.KONDISI_FISIK_SESUDAH
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
				C.NAMA || ' - ' || C.SPESIFIKASI INVENTARIS, NOMOR, BARCODE, AMBIL_LOKASI_INVENTARIS(B.LOKASI_ID) LOKASI, TANGGAL_AWAL, TANGGAL_AKHIR, A.KETERANGAN
				FROM PPI_ASSET.INVENTARIS_PERBAIKAN A 
				INNER JOIN PPI_ASSET.INVENTARIS_RUANGAN B ON A.INVENTARIS_RUANGAN_ID = B.INVENTARIS_RUANGAN_ID
				INNER JOIN PPI_ASSET.INVENTARIS C ON B.INVENTARIS_ID = C.INVENTARIS_ID
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
				INVENTARIS_PERBAIKAN_ID, INVENTARIS_RUANGAN_ID, TANGGAL, 
				   KETERANGAN, TANGGAL_AWAL, TANGGAL_AKHIR, 
				   LAST_CREATE_USER, LAST_CREATE_DATE, LAST_UPDATE_USER, 
				   LAST_UPDATE_DATE
				FROM PPI_ASSET.INVENTARIS_PERBAIKAN
				WHERE 1 = 1

			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY INVENTARIS_PERBAIKAN_ID DESC";
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
		$str = "SELECT COUNT(INVENTARIS_PERBAIKAN_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_PERBAIKAN A 
				INNER JOIN PPI_ASSET.INVENTARIS_RUANGAN B ON A.INVENTARIS_RUANGAN_ID = B.INVENTARIS_RUANGAN_ID
				INNER JOIN PPI_ASSET.INVENTARIS C ON B.INVENTARIS_ID = C.INVENTARIS_ID  WHERE 1 = 1 ".$statement; 
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
		
    function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(INVENTARIS_PERBAIKAN_ID) AS ROWCOUNT 
				FROM PPI_ASSET.INVENTARIS_PERBAIKAN A
				INNER JOIN PPI_ASSET.INVENTARIS_RUANGAN B ON A.INVENTARIS_RUANGAN_ID = B.INVENTARIS_RUANGAN_ID
				INNER JOIN PPI_ASSET.INVENTARIS C ON B.INVENTARIS_ID = C.INVENTARIS_ID
                LEFT JOIN PPI_ASSET.LOKASI D ON B.LOKASI_ID = D.LOKASI_ID
                LEFT JOIN PPI_ASSET.KONDISI_FISIK E ON E.PROSENTASE = A.KONDISI_FISIK_SEBELUM
                LEFT JOIN PPI_ASSET.KONDISI_FISIK F ON F.PROSENTASE = A.KONDISI_FISIK_SESUDAH
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

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(INVENTARIS_PERBAIKAN_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_PERBAIKAN WHERE 1 = 1 "; 
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