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

  class Lokasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Lokasi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("LOKASI_ID", $this->getNextId("LOKASI_ID","PPI_ASSET.LOKASI")); 
		$str = "
				INSERT INTO PPI_ASSET.LOKASI (
				   LOKASI_ID, LOKASI_PARENT_ID, KODE, NAMA, ALAMAT,
				   KETERANGAN, X, Y, KODE_GL_PUSAT,SUMBER_DANA) 
				VALUES (
						PPI_ASSET.LOKASI_ID_GENERATE('".$this->getField("LOKASI_ID")."'), 
						'".$this->getField("LOKASI_ID")."', 
						'".$this->getField("KODE_GL_PUSAT")."',  
						'".$this->getField("NAMA")."',  
						'".$this->getField("ALAMAT")."', 
						'".$this->getField("KETERANGAN")."', 
						'".$this->getField("X")."', 
						'".$this->getField("Y")."',
						'".$this->getField("KODE_GL_PUSAT")."',
						'".$this->getField("SUMBER_DANA")."'
						)"; 
		$this->id = $this->getField("LOKASI_ID");
		$this->query = $str;
		//echo $str;exit();
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.LOKASI
				SET    
					   GM						  = '".$this->getField("GM")."',  
					   ASMAN                      = '".$this->getField("ASMAN")."',
					   MANAGER					  = '".$this->getField("MANAGER")."',
					   JABATAN_MANAGER			  = '".$this->getField("JABATAN_MANAGER")."',
					   JABATAN_ASMAN			  = '".$this->getField("JABATAN_ASMAN")."',
					   KODE_GL_PUSAT			  = '".$this->getField("KODE_GL_PUSAT")."',
					   KODE		     			  = '".$this->getField("KODE_GL_PUSAT")."',
					   SUMBER_DANA				  = '".$this->getField("SUMBER_DANA")."'
				WHERE  LOKASI_ID       			  = '".$this->getField("LOKASI_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updatePenandaTangan()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.LOKASI
				SET    
					   GM						  = '".$this->getField("GM")."',  
					   ASMAN                      = '".$this->getField("ASMAN")."',
					   MANAGER					  = '".$this->getField("MANAGER")."',
					   JABATAN_MANAGER			  = '".$this->getField("JABATAN_MANAGER")."',
					   JABATAN_ASMAN			  = '".$this->getField("JABATAN_ASMAN")."',
					   KODE_GL_PUSAT			  = '".$this->getField("KODE_GL_PUSAT")."',
					   SUMBER_DANA				  = '".$this->getField("SUMBER_DANA")."'
				WHERE  LOKASI_ID       			  = '".$this->getField("LOKASI_ID")."',
				"; 
				$this->query = $str;
				//echo $str;
		return $this->execQuery($str);
    }
	
	function uploadFile()
	{
		$str = "
				UPDATE PPI_ASSET.LOKASI
				SET    
					   FILE_GAMBAR		= '".$this->getField("FILE_GAMBAR")."'					   
				WHERE  LOKASI_ID     = '".$this->getField("LOKASI_ID")."'

			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.LOKASI
                WHERE 
                  LOKASI_ID = ".$this->getField("LOKASI_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY LOKASI_ID ASC ")
	{
		$str = "
		SELECT   LOKASI_ID, LOKASI_PARENT_ID, NAMA, KODE, ALAMAT, KETERANGAN,
         FILE_GAMBAR, (SELECT KETERANGAN
                         FROM PPI_ASSET.LOKASI X
                        WHERE X.LOKASI_ID = SUBSTR (A.LOKASI_ID, 1, 3))
                                                                       KEPALA,
         (SELECT NAMA
            FROM PPI_ASSET.LOKASI X
           WHERE X.LOKASI_ID = SUBSTR (A.LOKASI_ID, 1, 3)) LOKASI_INDUK,
         CASE
            WHEN GM IS NULL
               THEN (SELECT KETERANGAN
                       FROM PPI_ASSET.LOKASI X
                      WHERE X.LOKASI_ID = '001')
            ELSE GM
         END GM, MANAGER, ASMAN, JABATAN_MANAGER, JABATAN_ASMAN, X, Y,
         KODE_GL_PUSAT, SUMBER_DANA
    FROM PPI_ASSET.LOKASI A
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
	
	
    function selectByParamsSimple($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY LOKASI_ID ASC ")
	{
		$str = "
		SELECT   LOKASI_ID, LOKASI_PARENT_ID, NAMA, KODE, ALAMAT, KETERANGAN,
         FILE_GAMBAR, (SELECT KETERANGAN
                         FROM PPI_ASSET.LOKASI X
                        WHERE X.LOKASI_ID = SUBSTR (A.LOKASI_ID, 1, 3))
                                                                       KEPALA,
         (SELECT NAMA
            FROM PPI_ASSET.LOKASI X
           WHERE X.LOKASI_ID = SUBSTR (A.LOKASI_ID, 1, 3)) LOKASI_INDUK,
         CASE
            WHEN GM IS NULL
               THEN (SELECT KETERANGAN
                       FROM PPI_ASSET.LOKASI X
                      WHERE X.LOKASI_ID = '001')
            ELSE GM
         END GM, MANAGER, ASMAN, JABATAN_MANAGER, JABATAN_ASMAN, X, Y,
         KODE_GL_PUSAT, SUMBER_DANA
    FROM PPI_ASSET.LOKASI A
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


	
    function selectByParamsAsset($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY NAMA ASC ")
	{
		$str = "
			SELECT 
			INVENTARIS_ID, B.KODE, 
			   A.NAMA
            FROM PPI_ASSET.INVENTARIS A
            INNER JOIN PPI_ASSET.JENIS_INVENTARIS B ON A.JENIS_INVENTARIS_ID = B.JENIS_INVENTARIS_ID
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
	
    function selectByParamsDenah($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY LOKASI_ID ASC ")
	{
		$str = "
				SELECT LOKASI_ID, LOKASI_PARENT_ID, NAMA, KODE, ALAMAT, KETERANGAN, FILE_GAMBAR,
				AMBIL_LOKASI_INVENTARIS3 (A.LOKASI_ID) LOKASI_INDUK,
				X, Y,KODE_GL_PUSAT,SUMBER_DANA,
                (SELECT COUNT(1) FROM PPI_ASSET.INVENTARIS_RUANGAN X WHERE X.LOKASI_ID = A.LOKASI_ID) JUMLAH_INVENTARIS,
                (SELECT COUNT(1) FROM PPI_ASSET.INVENTARIS_PERBAIKAN X INNER JOIN PPI_ASSET.INVENTARIS_RUANGAN Y ON X.INVENTARIS_RUANGAN_ID = Y.INVENTARIS_RUANGAN_ID 
                WHERE Y.LOKASI_ID = A.LOKASI_ID AND PERSETUJUAN = 'Y' AND KONDISI_FISIK_SESUDAH IS NULL) JUMLAH_PERBAIKAN,
                (SELECT COUNT(1) FROM PPI_ASSET.INVENTARIS_RUANGAN X INNER JOIN PPI_ASSET.INVENTARIS_PENYUSUTAN_DETIL Y ON X.INVENTARIS_RUANGAN_ID = Y.INVENTARIS_RUANGAN_ID 
                WHERE X.LOKASI_ID = A.LOKASI_ID) JUMLAH_PENYUSUTAN                
				FROM PPI_ASSET.LOKASI A
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

    function selectByParamsLokasiPerbaikan($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY LOKASI_ID ASC ")
	{
		$str = "
				SELECT A.LOKASI_ID, NAMA,
                AMBIL_LOKASI_INVENTARIS3 (A.LOKASI_ID) LOKASI_INDUK,
                X, Y, A.KETERANGAN,KODE_GL_PUSAT,SUMBER_DANA,
                AMBIL_KERUSAKAN_LOKASI(A.LOKASI_ID) KERUSAKAN
                FROM PPI_ASSET.LOKASI A
                INNER JOIN PPI_ASSET.INVENTARIS_RUANGAN B ON A.LOKASI_ID = B.LOKASI_ID
                INNER JOIN PPI_ASSET.INVENTARIS_PERBAIKAN C ON B.INVENTARIS_RUANGAN_ID = C.INVENTARIS_RUANGAN_ID
                WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.LOKASI_ID, A.NAMA, A.X, A.Y, A.KETERANGAN  ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
			
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT 
				LOKASI_ID, LOKASI_PARENT_ID, NAMA, ALAMAT,
				   KETERANGAN
				FROM PPI_ASSET.LOKASI
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY LOKASI_ID DESC";
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
		$str = "SELECT COUNT(LOKASI_ID) AS ROWCOUNT FROM PPI_ASSET.LOKASI  WHERE 1 = 1 ".$statement; 
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

    function getLokasi($lokasiId)
	{
		$str = "SELECT PPI_ASSET.AMBIL_LOKASI_INVENTARIS('".$lokasiId."') AS ROWCOUNT FROM DUAL WHERE 1 = 1 ".$statement; 
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(LOKASI_ID) AS ROWCOUNT FROM PPI_ASSET.LOKASI WHERE 1 = 1 "; 
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