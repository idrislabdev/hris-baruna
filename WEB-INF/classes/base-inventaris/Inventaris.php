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

  class Inventaris extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Inventaris()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("INVENTARIS_ID", $this->getNextId("INVENTARIS_ID","PPI_ASSET.INVENTARIS")); 
		$str = "
				INSERT INTO PPI_ASSET.INVENTARIS (
				   INVENTARIS_ID, JENIS_INVENTARIS_ID, KODE, 
				   NAMA, SPESIFIKASI, UMUR_EKONOMIS_INVENTARIS, LAST_CREATE_USER, 
				   LAST_CREATE_DATE) 
				VALUES (
						".$this->getField("INVENTARIS_ID").", 
						'".$this->getField("JENIS_INVENTARIS_ID")."', 
						'".$this->getField("INVENTARIS_ID")."', 
						'".$this->getField("NAMA")."', 
						'".$this->getField("SPESIFIKASI")."', 
						'".$this->getField("UMUR_EKONOMIS_INVENTARIS")."', 
						'".$this->getField("LAST_CREATE_USER")."', 
						".$this->getField("LAST_CREATE_DATE")."
						)"; 
		$this->id = $this->getField("INVENTARIS_ID");
		// echo $str;exit();
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVENTARIS
				SET    
					   JENIS_INVENTARIS_ID = '".$this->getField("JENIS_INVENTARIS_ID")."',
					   KODE                = '".$this->getField("KODE")."',
					   NAMA                = '".$this->getField("NAMA")."',
					   SPESIFIKASI         = '".$this->getField("SPESIFIKASI")."',
					   UMUR_EKONOMIS_INVENTARIS         = '".$this->getField("UMUR_EKONOMIS_INVENTARIS")."',
					   LAST_UPDATE_USER    = '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE    = ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  INVENTARIS_ID       = '".$this->getField("INVENTARIS_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

    function updateSpesifikasi()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVENTARIS
				SET
					   SPESIFIKASI         = '".$this->getField("SPESIFIKASI")."'
				WHERE  INVENTARIS_ID       = '".$this->getField("INVENTARIS_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
		
	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }
	
	function updateFormat()
	{
		$str = "
				UPDATE PPI_ASSET.INVENTARIS
				SET    
					  TIPE=".$this->getField("TIPE").",
				  	  UKURAN=".$this->getField("UKURAN")."
				WHERE  INVENTARIS_ID     = '".$this->getField("INVENTARIS_ID")."'
			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.INVENTARIS
                WHERE 
                  INVENTARIS_ID = ".$this->getField("INVENTARIS_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY A.NAMA")
	{
		$str = "
				SELECT 
				A.INVENTARIS_ID, A.JENIS_INVENTARIS_ID, A.KODE, 
				   A.NAMA INVENTARIS, SPESIFIKASI, FILE_GAMBAR, 
				   UKURAN, TIPE, LAST_CREATE_USER, 
				   B.NAMA JENIS_INVENTARIS, A.NAMA, A.UMUR_EKONOMIS_INVENTARIS,
				   LAST_CREATE_DATE, LAST_UPDATE_USER, LAST_UPDATE_DATE
				FROM PPI_ASSET.INVENTARIS A
				INNER JOIN PPI_ASSET.JENIS_INVENTARIS B ON B.JENIS_INVENTARIS_ID=A.JENIS_INVENTARIS_ID
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo$str;exit();
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsFile($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY A.NAMA")
	{
		$str = "
				SELECT 
				encode(FILE_GAMBAR, 'base64') FILE_GAMBAR, 
				   UKURAN, TIPE
				FROM PPI_ASSET.INVENTARIS A
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


    function selectByParamsNotifikasi($paramsArray=array())
	{
		$str = "
				SELECT 'Terdapat ' || COUNT(1) || ' inventaris menunggu konfirmasi perbaikan.' NOTIFIKASI FROM PPI_ASSET.INVENTARIS_PERBAIKAN A WHERE PERSETUJUAN IS NULL
				UNION ALL
				SELECT 'Terdapat ' || COUNT(1) || ' inventaris sedang diperbaiki.' NOTIFIKASI FROM PPI_ASSET.INVENTARIS_PERBAIKAN A WHERE PERSETUJUAN = 'S' AND KONDISI_FISIK_SESUDAH IS NULL
				UNION ALL
				SELECT 'Terdapat ' || COUNT(1) || ' inventaris selesai perbaikan.' NOTIFIKASI FROM PPI_ASSET.INVENTARIS_PERBAIKAN A WHERE PERSETUJUAN = 'S' AND KONDISI_FISIK_SESUDAH IS NOT NULL
				UNION ALL
				SELECT 'Terdapat ' || COUNT(1) || ' inventaris menunggu konfirmasi pemusnahan.' NOTIFIKASI FROM PPI_ASSET.INVENTARIS_PENYUSUTAN_DETIL A WHERE PERSETUJUAN IS NULL
				UNION ALL
				SELECT 'Terdapat ' || COUNT(1) || ' inventaris telah dimusnahkan.' NOTIFIKASI FROM PPI_ASSET.INVENTARIS_PENYUSUTAN_DETIL A WHERE PERSETUJUAN = 'S'
				UNION ALL
				SELECT 'Terdapat ' || COUNT(1) || ' inventaris dengan kondisi <= 50%.' NOTIFIKASI FROM PPI_ASSET.INVENTARIS_KARTU_KENDALI A
				INNER JOIN
				(
				SELECT INVENTARIS_RUANGAN_ID, TO_CHAR(MAX(TO_DATE(PERIODE, 'MMYYYY')), 'MMYYYY') PERIODE FROM PPI_ASSET.
				INVENTARIS_KARTU_KENDALI X
				GROUP BY INVENTARIS_RUANGAN_ID
				) B ON A.INVENTARIS_RUANGAN_ID = B.INVENTARIS_RUANGAN_ID AND A.PERIODE = B.PERIODE
				WHERE KONDISI_FISIK_PROSENTASE <= 50
				UNION ALL
				SELECT 'Terdapat ' || COUNT(1) || ' inventaris yang belum pernah dicek kondisinya.' NOTIFIKASI FROM PPI_ASSET.INVENTARIS_RUANGAN A 
				WHERE STATUS_HAPUS = '0' AND NOT EXISTS (SELECT 1 FROM PPI_ASSET.INVENTARIS_KARTU_KENDALI X WHERE X.INVENTARIS_RUANGAN_ID = A.INVENTARIS_RUANGAN_ID)			
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }
	
    function selectByParamsPengendalian($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT INVENTARIS_ID, NAMA FROM PPI_ASSET.INVENTARIS A WHERE 1 = 1
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
				INVENTARIS_ID, JENIS_INVENTARIS_ID, KODE, 
				   NAMA, SPESIFIKASI, FILE_GAMBAR, 
				   UKURAN, TIPE, LAST_CREATE_USER, 
				   LAST_CREATE_DATE, LAST_UPDATE_USER, LAST_UPDATE_DATE
				FROM PPI_ASSET.INVENTARIS
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY INVENTARIS_ID DESC";
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
		$str = "SELECT COUNT(INVENTARIS_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS  WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(INVENTARIS_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS WHERE 1 = 1 "; 
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