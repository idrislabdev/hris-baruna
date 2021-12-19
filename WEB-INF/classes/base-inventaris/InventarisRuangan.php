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

  class InventarisRuangan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function InventarisRuangan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("INVENTARIS_RUANGAN_ID", $this->getNextId("INVENTARIS_RUANGAN_ID","PPI_ASSET.INVENTARIS_RUANGAN")); 
		$str = "
				INSERT INTO PPI_ASSET.INVENTARIS_RUANGAN (
				   INVENTARIS_RUANGAN_ID, INVENTARIS_ID, LOKASI_ID, 
				   KONDISI_FISIK_ID, NOMOR, PEROLEHAN_TAHUN, 
				   PEROLEHAN_HARGA, PENYUSUTAN, NILAI_BUKU, 
				   KETERANGAN, BARCODE, 
				   NO_URUT, KONDISI_FISIK_PROSENTASE, PEROLEHAN_PERIODE, PEROLEHAN_TANGGAL, NO_INVOICE, INVOICE_ID, LAST_CREATE_USER, LAST_CREATE_DATE, UMUR_EKONOMIS) 
				VALUES (
						".$this->getField("INVENTARIS_RUANGAN_ID").", 
						".$this->getField("INVENTARIS_ID").", 
						'".$this->getField("LOKASI_ID")."', 
						".$this->getField("KONDISI_FISIK_ID").",
						".$this->getField("NOMOR").", 
						'".$this->getField("PEROLEHAN_TAHUN")."', 
						".$this->getField("PEROLEHAN_HARGA").", 
						".$this->getField("PENYUSUTAN").", 
						".$this->getField("NILAI_BUKU").", 
						'".$this->getField("KETERANGAN")."', 
						".$this->getField("BARCODE").", 
						".$this->getField("NO_URUT").", 
						".$this->getField("KONDISI_FISIK_PROSENTASE").", 
						'".$this->getField("PEROLEHAN_PERIODE")."', 
						".$this->getField("PEROLEHAN_TANGGAL").", 
						'".$this->getField("NO_INVOICE")."', 
						".$this->getField("INVOICE_ID").", 
						'".$this->getField("LAST_CREATE_USER")."', 
						CURRENT_DATE,
						'".$this->getField("UMUR_EKONOMIS")."'
						)"; 
		$this->id = $this->getField("INVENTARIS_RUANGAN_ID");
		//echo $str;exit();
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVENTARIS_RUANGAN
				SET    
					   INVENTARIS_ID            = '".$this->getField("INVENTARIS_ID")."',
					   LOKASI_ID                = '".$this->getField("LOKASI_ID")."',
					   KONDISI_FISIK_ID         = '".$this->getField("KONDISI_FISIK_ID")."',
					   NOMOR                    = '".$this->getField("NOMOR")."',
					   PEROLEHAN_TAHUN          = '".$this->getField("PEROLEHAN_TAHUN")."',
					   PEROLEHAN_HARGA          = '".$this->getField("PEROLEHAN_HARGA")."',
					   PENYUSUTAN               = '".$this->getField("PENYUSUTAN")."',
					   NILAI_BUKU               = '".$this->getField("NILAI_BUKU")."',
					   KETERANGAN               = '".$this->getField("KETERANGAN")."',
					   BARCODE                  = '".$this->getField("BARCODE")."',
					   STATUS_HAPUS             = '".$this->getField("STATUS_HAPUS")."',
					   NO_URUT                  = '".$this->getField("NO_URUT")."',
					   UMUR_EKONOMIS            = '".$this->getField("UMUR_EKONOMIS")."',
					   KONDISI_FISIK_PROSENTASE = '".$this->getField("KONDISI_FISIK_PROSENTASE")."',
					   PEROLEHAN_PERIODE        = '".$this->getField("PEROLEHAN_PERIODE")."'
				WHERE  INVENTARIS_RUANGAN_ID    = '".$this->getField("INVENTARIS_RUANGAN_ID")."'
				"; 
				$this->query = $str;
				// echo $str;exit();
		return $this->execQuery($str);
    }
	
	
	function updatePendataanDetil()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVENTARIS_RUANGAN
				SET    
					   NOMOR                    = '".$this->getField("NOMOR")."',
					   PEROLEHAN_HARGA          = ".$this->getField("PEROLEHAN_HARGA").",
					   PEROLEHAN_TANGGAL          = ".$this->getField("PEROLEHAN_TANGGAL").",
					   KETERANGAN               = '".$this->getField("KETERANGAN")."',
					   KONDISI_FISIK_PROSENTASE = ".$this->getField("KONDISI_FISIK_PROSENTASE").", 
					   NO_INVOICE = '".$this->getField("NO_INVOICE")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE = CURRENT_DATE
				WHERE  INVENTARIS_RUANGAN_ID    = '".$this->getField("INVENTARIS_RUANGAN_ID")."'
				"; 
				$this->query = $str;
				//echo $str;
		return $this->execQuery($str);
    }

	function updatePendataanLokasi()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVENTARIS_RUANGAN
				SET    
					   LOKASI_ID        = '".$this->getField("LOKASI_ID")."',
					   NOMOR			= '".$this->getField("NOMOR")."',
					   BARCODE		    = '".$this->getField("BARCODE")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE = CURRENT_DATE
				WHERE  INVENTARIS_RUANGAN_ID    = '".$this->getField("INVENTARIS_RUANGAN_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateLokasi()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVENTARIS_RUANGAN
				SET    
					   LOKASI_ID        = '".$this->getField("LOKASI_ID_BARU")."',
					   LOKASI_SEBELUM	= '".$this->getField("LOKASI_ID")."', 
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE = CURRENT_DATE
				WHERE  INVENTARIS_ID    = '".$this->getField("INVENTARIS_ID")."' AND
					   LOKASI_ID   	    = '".$this->getField("LOKASI_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	
	function uploadFile()
	{
		$str = "
				UPDATE PPI_ASSET.INVENTARIS_RUANGAN
				SET    
					   FILE_GAMBAR				= '".$this->getField("FILE_GAMBAR")."'					   
				WHERE  INVENTARIS_RUANGAN_ID   	= '".$this->getField("INVENTARIS_RUANGAN_ID")."'

			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = " UPDATE PPI_ASSET.INVENTARIS_RUANGAN
				SET STATUS_HAPUS = 1,
					ALASAN_HAPUS = '".$this->getField("ALASAN_HAPUS")."'
                WHERE 
                  INVENTARIS_RUANGAN_ID = ".$this->getField("INVENTARIS_RUANGAN_ID").""; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
	
	/*function deleteLokasi()
	{
		
        $str = "DELETE FROM PPI_ASSET.INVENTARIS_RUANGAN
                WHERE 
                  INVENTARIS_ID= '".$this->getField("INVENTARIS_ID")."' AND
                  LOKASI_ID = '".$this->getField("LOKASI_ID")."'
                "; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }*/
	
	function deleteLokasi()
	{	
		$str2 = "DELETE FROM PPI_ASSET.INVENTARIS_LOKASI_HISTORI
					WHERE 
					  INVENTARIS_RUANGAN_ID IN (SELECT INVENTARIS_RUANGAN_ID FROM PPI_ASSET.INVENTARIS_RUANGAN WHERE INVENTARIS_ID= '".$this->getField("INVENTARIS_ID")."' AND
					  LOKASI_ID = '".$this->getField("LOKASI_ID")."')"; 
					  
		$this->query = $str2;
		$this->execQuery($str2);		
	
		$str1 = "DELETE FROM PPI_ASSET.INVENTARIS_PENANGGUNG_JAWAB
				WHERE 
				  INVENTARIS_RUANGAN_ID IN (SELECT INVENTARIS_RUANGAN_ID FROM PPI_ASSET.INVENTARIS_RUANGAN WHERE INVENTARIS_ID= '".$this->getField("INVENTARIS_ID")."' AND
				  LOKASI_ID = '".$this->getField("LOKASI_ID")."')
				";
		$this->query = $str1;
		$this->execQuery($str1);
		
		$str = "DELETE FROM PPI_ASSET.INVENTARIS_RUANGAN
				WHERE 
				  INVENTARIS_ID= '".$this->getField("INVENTARIS_ID")."' AND
				  LOKASI_ID = '".$this->getField("LOKASI_ID")."'
		"; 
				  
		$this->query = $str;
		return $this->execQuery($str);
	}

	function deleteByInvoiceInventaris()
	{
        $str = "DELETE FROM PPI_ASSET.INVENTARIS_RUANGAN
                WHERE 
                  INVOICE_ID = '".$this->getField("INVOICE_ID")."' AND
				  LOKASI_ID IS NULL
                "; 
				  
		$this->query = $str;
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
                SELECT A.INVENTARIS_RUANGAN_ID, A.INVENTARIS_ID, A.LOKASI_ID, C.NAMA LOKASI,
                       KONDISI_FISIK_ID, NOMOR, PEROLEHAN_TAHUN, A.PEROLEHAN_HARGA, NILAI_BUKU, A.KETERANGAN,
                       BARCODE, STATUS_HAPUS, NO_URUT,
                            A.KONDISI_FISIK_PROSENTASE
                            KONDISI_FISIK_PROSENTASE,
                       (
                            (SELECT NAMA
                               FROM PPI_ASSET.KONDISI_FISIK X
                              WHERE X.PROSENTASE = A.KONDISI_FISIK_PROSENTASE)
                           ) KONDISI,
                       B.NAMA INVENTARIS, PEROLEHAN_PERIODE,
                       PPI_ASSET.AMBIL_LOKASI_INVENTARIS
                                                               (A.LOKASI_ID)
                                                                            LOKASI_KETERANGAN,
                       PEROLEHAN_TANGGAL, NO_INVOICE, COALESCE(SPESIFIKASI, '-') SPESIFIKASI, C.WARNA, C.WARNA_CAPTION, F.NAMA JENIS,
                       A.FILE_GAMBAR
                  FROM PPI_ASSET.INVENTARIS_RUANGAN A INNER JOIN PPI_ASSET.INVENTARIS B
                       ON A.INVENTARIS_ID = B.INVENTARIS_ID
                       LEFT JOIN PPI_ASSET.LOKASI C ON A.LOKASI_ID = C.LOKASI_ID
                       LEFT JOIN PPI_ASSET.JENIS_INVENTARIS F
                       ON F.JENIS_INVENTARIS_ID = B.JENIS_INVENTARIS_ID
                 WHERE 1 = 1 AND A.STATUS_HAPUS = '0'			
                 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsDetil($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
                SELECT INVENTARIS_RUANGAN_ID, NOMOR, BARCODE, PEROLEHAN_PERIODE, PEROLEHAN_HARGA, KONDISI_FISIK_PROSENTASE, KETERANGAN, FILE_GAMBAR
                  FROM PPI_ASSET.INVENTARIS_RUANGAN A INNER JOIN PPI_ASSET.INVENTARIS B
                       ON A.INVENTARIS_ID = B.INVENTARIS_ID
                       LEFT JOIN PPI_ASSET.LOKASI C ON A.LOKASI_ID = C.LOKASI_ID
                       LEFT JOIN PPI_ASSET.JENIS_INVENTARIS F
                       ON F.JENIS_INVENTARIS_ID = B.JENIS_INVENTARIS_ID
                 WHERE 1 = 1 AND A.STATUS_HAPUS = '0'			
                 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParams20032019($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT A.INVENTARIS_RUANGAN_ID, A.INVENTARIS_ID, A.LOKASI_ID, C.NAMA LOKASI,
					   KONDISI_FISIK_ID, NOMOR, PEROLEHAN_TAHUN, A.PEROLEHAN_HARGA,
					   coalesce (E.PENYUSUTAN, A.PENYUSUTAN) PENYUSUTAN, NILAI_BUKU, A.KETERANGAN,
					   BARCODE, STATUS_HAPUS, NO_URUT,
					   coalesce (E.KONDISI_FISIK_PROSENTASE,
							A.KONDISI_FISIK_PROSENTASE
						   ) KONDISI_FISIK_PROSENTASE,
					   coalesce (E.KONDISI,
							(SELECT NAMA
							   FROM PPI_ASSET.KONDISI_FISIK X
							  WHERE X.PROSENTASE = A.KONDISI_FISIK_PROSENTASE)
						   ) KONDISI,
					   B.NAMA INVENTARIS, PEROLEHAN_PERIODE, D.NRP || ' - ' || D.NAMA PEGAWAI,
					   AMBIL_LOKASI_INVENTARIS2
															   (A.LOKASI_ID)
																			LOKASI_KETERANGAN,
					   PEROLEHAN_TANGGAL, NO_INVOICE, COALESCE(SPESIFIKASI, '-') SPESIFIKASI, C.WARNA, C.WARNA_CAPTION, F.NAMA JENIS,
					   A.FILE_GAMBAR
				  FROM PPI_ASSET.INVENTARIS_RUANGAN A INNER JOIN PPI_ASSET.INVENTARIS B
					   ON A.INVENTARIS_ID = B.INVENTARIS_ID
					   LEFT JOIN PPI_ASSET.LOKASI C ON A.LOKASI_ID = C.LOKASI_ID
					   LEFT JOIN PPI_ASSET.INVENTARIS_TGJAWAB_TERAKHIR D
					   ON A.INVENTARIS_RUANGAN_ID = D.INVENTARIS_RUANGAN_ID
					   LEFT JOIN PPI_ASSET.INVENTARIS_KONDISI_FISIK E
					   ON A.INVENTARIS_RUANGAN_ID = E.INVENTARIS_RUANGAN_ID					   
					   LEFT JOIN PPI_ASSET.JENIS_INVENTARIS F
					   ON F.JENIS_INVENTARIS_ID = B.JENIS_INVENTARIS_ID
				 WHERE 1 = 1 AND A.STATUS_HAPUS = '0'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsDataRiwayat($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				A.BARCODE, A.INVENTARIS_RUANGAN_ID, A.INVENTARIS_ID, A.LOKASI_ID, C.NAMA LOKASI,
				NOMOR, B.NAMA INVENTARIS, F.NAMA JENIS, 
				COALESCE(SPESIFIKASI, '-') SPESIFIKASI, 
				D.NRP || ' - ' || D.NAMA PEGAWAI, A.PEROLEHAN_TANGGAL,
				COALESCE
				(
				E.KONDISI,
				(SELECT NAMA FROM PPI_ASSET.KONDISI_FISIK X WHERE X.PROSENTASE = A.KONDISI_FISIK_PROSENTASE)
				) KONDISI,
				A.PEROLEHAN_HARGA
				FROM PPI_ASSET.INVENTARIS_RUANGAN A 
				INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
				LEFT JOIN PPI_ASSET.LOKASI C ON A.LOKASI_ID = C.LOKASI_ID
				LEFT JOIN PPI_ASSET.INVENTARIS_TGJAWAB_TERAKHIR D ON A.INVENTARIS_RUANGAN_ID = D.INVENTARIS_RUANGAN_ID
				LEFT JOIN PPI_ASSET.INVENTARIS_KONDISI_FISIK E ON A.INVENTARIS_RUANGAN_ID = E.INVENTARIS_RUANGAN_ID					   
				LEFT JOIN PPI_ASSET.JENIS_INVENTARIS F ON F.JENIS_INVENTARIS_ID = B.JENIS_INVENTARIS_ID
				WHERE 1 = 1 AND A.STATUS_HAPUS = '0'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsCekRiwayat($paramsArray=array(),$limit=-1,$from=-1,$statement="", $sekarang="", $lalu="", $lusa="", $order="")
	{
		$str = "
				SELECT A.INVENTARIS_RUANGAN_ID, A.INVENTARIS_ID, A.LOKASI_ID, C.NAMA LOKASI,
					   KONDISI_FISIK_ID, NOMOR, PEROLEHAN_TAHUN, A.PEROLEHAN_HARGA,
					   coalesce (E.PENYUSUTAN, A.PENYUSUTAN) PENYUSUTAN, NILAI_BUKU, A.KETERANGAN,
					   BARCODE, STATUS_HAPUS, NO_URUT,
					   coalesce (E.KONDISI_FISIK_PROSENTASE,
							A.KONDISI_FISIK_PROSENTASE
						   ) KONDISI_FISIK_PROSENTASE,
						   A.KONDISI_FISIK_PROSENTASE KONDISI_AWAL,
					   coalesce (E.KONDISI,
							(SELECT NAMA
							   FROM PPI_ASSET.KONDISI_FISIK X
							  WHERE X.PROSENTASE = A.KONDISI_FISIK_PROSENTASE)
						   ) KONDISI,
					   B.NAMA INVENTARIS, PEROLEHAN_PERIODE, D.NRP || ' - ' || D.NAMA PEGAWAI,
					   AMBIL_LOKASI_INVENTARIS2
															   (A.LOKASI_ID)
																			LOKASI_KETERANGAN,
					   PEROLEHAN_TANGGAL, NO_INVOICE, COALESCE(SPESIFIKASI, '-') SPESIFIKASI, C.WARNA, C.WARNA_CAPTION, F.NAMA JENIS,					   
                   AMBIL_KENDALI_PERIODE(A.INVENTARIS_RUANGAN_ID, '".$sekarang."') SEKARANG,
                   AMBIL_KENDALI_PERIODE(A.INVENTARIS_RUANGAN_ID, '".$lalu."') LALU,
                   AMBIL_KENDALI_PERIODE(A.INVENTARIS_RUANGAN_ID, '".$lusa."') LUSA
				  FROM PPI_ASSET.INVENTARIS_RUANGAN A INNER JOIN PPI_ASSET.INVENTARIS B
					   ON A.INVENTARIS_ID = B.INVENTARIS_ID
					   LEFT JOIN PPI_ASSET.LOKASI C ON A.LOKASI_ID = C.LOKASI_ID
					   LEFT JOIN PPI_ASSET.INVENTARIS_TGJAWAB_TERAKHIR D
					   ON A.INVENTARIS_RUANGAN_ID = D.INVENTARIS_RUANGAN_ID
					   LEFT JOIN PPI_ASSET.INVENTARIS_KONDISI_FISIK E
					   ON A.INVENTARIS_RUANGAN_ID = E.INVENTARIS_RUANGAN_ID					   
					   LEFT JOIN PPI_ASSET.JENIS_INVENTARIS F
					   ON F.JENIS_INVENTARIS_ID = B.JENIS_INVENTARIS_ID
				 WHERE 1 = 1 AND A.STATUS_HAPUS = '0'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsSimple($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				A.PEROLEHAN_HARGA, A.INVENTARIS_RUANGAN_ID, A.FILE_GAMBAR
                FROM PPI_ASSET.INVENTARIS_RUANGAN A
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
	
    function selectByParamsInventarisInvoice($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				A.INVENTARIS_RUANGAN_ID, A.INVENTARIS_ID, A.LOKASI_ID, C.NAMA LOKASI,
                   KONDISI_FISIK_ID, NOMOR, PEROLEHAN_TAHUN, 
                   A.PEROLEHAN_HARGA,  
                   A.KETERANGAN, BARCODE, STATUS_HAPUS,
                   NO_URUT, B.NAMA INVENTARIS, PEROLEHAN_PERIODE,
                   PEROLEHAN_TANGGAL, NO_INVOICE
                FROM PPI_ASSET.INVENTARIS_RUANGAN A
                INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
                LEFT JOIN PPI_ASSET.LOKASI C ON A.LOKASI_ID = C.LOKASI_ID
                WHERE 1 = 1 AND A.STATUS_HAPUS = '0'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsRekapInventaris($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
                B.NAMA || CASE WHEN B.SPESIFIKASI IS NULL THEN '' ELSE  ' - ' || B.SPESIFIKASI END INVENTARIS,NOMOR, BARCODE, 
				PPI_ASSET.AMBIL_LOKASI_INVENTARIS(A.LOKASI_ID) LOKASI, PEROLEHAN_TAHUN, 
                   PEROLEHAN_HARGA,PEROLEHAN_PERIODE
                FROM PPI_ASSET.INVENTARIS_RUANGAN A
                INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
                WHERE 1 = 1 AND A.STATUS_HAPUS = '0'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsInvoice($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT A.INVENTARIS_ID, COUNT(A.INVENTARIS_ID) JUMLAH, UMUR_EKONOMIS, PEROLEHAN_HARGA, COUNT(LOKASI_ID) JUMLAH_LOKASI FROM PPI_ASSET.INVENTARIS_RUANGAN A 
                WHERE 1 = 1 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY INVENTARIS_ID, PEROLEHAN_HARGA, UMUR_EKONOMIS ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
    function selectByParamsRekapInventarisPindahHistori($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
					SELECT 
					B.NAMA || CASE WHEN B.SPESIFIKASI IS NULL THEN '' ELSE  ' - ' || B.SPESIFIKASI END INVENTARIS, C.NOMOR, C.BARCODE, C.TMT,
					AMBIL_LOKASI_INVENTARIS(C.LOKASI_ID) LOKASI, PEROLEHAN_TAHUN, 
					   PEROLEHAN_HARGA,PEROLEHAN_PERIODE, C.LAST_CREATE_USER
					FROM PPI_ASSET.INVENTARIS_RUANGAN A
					INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
					INNER JOIN PPI_ASSET.INVENTARIS_LOKASI_HISTORI C ON A.INVENTARIS_RUANGAN_ID = C.INVENTARIS_RUANGAN_ID
					WHERE 1 = 1 AND A.STATUS_HAPUS = '0' AND EXISTS(SELECT 1 FROM PPI_ASSET.INVENTARIS_JUMLAH_HISTORI X WHERE X.INVENTARIS_RUANGAN_ID = A.INVENTARIS_RUANGAN_ID AND JUMLAH > 1)
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsRekapPenanggungJawab($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
					SELECT 
					D.NAMA || ' (NRP: ' || D.NRP || ')' PEGAWAI, B.NAMA || ' - ' || B.SPESIFIKASI INVENTARIS, C.NOMOR, C.BARCODE, D.TMT,
					AMBIL_LOKASI_INVENTARIS(C.LOKASI_ID) LOKASI, PEROLEHAN_TAHUN
                    FROM PPI_ASSET.INVENTARIS_RUANGAN A
                    INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
                    INNER JOIN PPI_ASSET.INVENTARIS_LOKASI_HISTORI C ON A.INVENTARIS_RUANGAN_ID = C.INVENTARIS_RUANGAN_ID
                    INNER JOIN PPI_ASSET.INVENTARIS_TGJAWAB_TERAKHIR D ON A.INVENTARIS_RUANGAN_ID = D.INVENTARIS_RUANGAN_ID
                    WHERE 1 = 1 AND A.STATUS_HAPUS = '0' 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
		
    function selectByParamsRekapInventarisRuangan($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
                PPI_ASSET.AMBIL_LOKASI_INVENTARIS(A.LOKASI_ID) || ' - ' || (SELECT COUNT(INVENTARIS_ID) FROM PPI_ASSET.INVENTARIS_RUANGAN X WHERE X.LOKASI_ID = A.LOKASI_ID) || ' item' LOKASI, B.NAMA INVENTARIS, B.SPESIFIKASI,NOMOR, BARCODE, 
				PEROLEHAN_TAHUN, A.LOKASI_ID,
                   PEROLEHAN_HARGA,PEROLEHAN_PERIODE
                FROM PPI_ASSET.INVENTARIS_RUANGAN A
                INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
                WHERE 1 = 1 AND A.STATUS_HAPUS = '0'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	function selectByParamsRekapHapusInventaris($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
                AMBIL_LOKASI_INVENTARIS(A.LOKASI_ID) || ' - ' || (SELECT COUNT(INVENTARIS_ID) FROM PPI_ASSET.INVENTARIS_RUANGAN X WHERE X.LOKASI_ID = A.LOKASI_ID AND X.STATUS_HAPUS = '1') || ' item' LOKASI, B.NAMA INVENTARIS, B.SPESIFIKASI,NOMOR, BARCODE, 
				PEROLEHAN_TAHUN, A.LOKASI_ID,
                   PEROLEHAN_HARGA,PEROLEHAN_PERIODE, ALASAN_HAPUS
                FROM PPI_ASSET.INVENTARIS_RUANGAN A
                INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
                WHERE 1 = 1 AND A.STATUS_HAPUS = '1'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }		

    function selectByParamsPendataan($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
                A.INVENTARIS_ID, B.NAMA INVENTARIS, C.NAMA JENIS_INVENTARIS, B.SPESIFIKASI, COUNT(A.INVENTARIS_ID) JUMLAH, B.UMUR_EKONOMIS_INVENTARIS UMUR_EKONOMIS
				FROM PPI_ASSET.INVENTARIS_RUANGAN A
				INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
                INNER JOIN PPI_ASSET.JENIS_INVENTARIS C ON B.JENIS_INVENTARIS_ID = C.JENIS_INVENTARIS_ID
				WHERE 1 = 1  AND A.STATUS_HAPUS = '0'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.INVENTARIS_ID, B.NAMA, B.SPESIFIKASI, B.UMUR_EKONOMIS_INVENTARIS,C.NAMA ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsPengendalian($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="", $tahun="2013")
	{
		$str = "
 				SELECT 
				INVENTARIS_RUANGAN_ID, A.INVENTARIS_ID, LOKASI_ID, AMBIL_LOKASI_INVENTARIS(A.LOKASI_ID) LOKASI, 
				   KONDISI_FISIK_ID, NOMOR, PEROLEHAN_TAHUN, 
				   PEROLEHAN_HARGA, PENYUSUTAN, NILAI_BUKU, 
				   KETERANGAN, BARCODE, STATUS_HAPUS, 
				   NO_URUT, KONDISI_FISIK_PROSENTASE || '%' KONDISI_FISIK_PROSENTASE, B.NAMA INVENTARIS, PEROLEHAN_PERIODE, 
                   AMBIL_KENDALI_PERIODE(INVENTARIS_RUANGAN_ID, '01".$tahun."') JAN,
                   AMBIL_KENDALI_PERIODE(INVENTARIS_RUANGAN_ID, '02".$tahun."') FEB,
                   AMBIL_KENDALI_PERIODE(INVENTARIS_RUANGAN_ID, '03".$tahun."') MAR,
                   AMBIL_KENDALI_PERIODE(INVENTARIS_RUANGAN_ID, '04".$tahun."') APR,
                   AMBIL_KENDALI_PERIODE(INVENTARIS_RUANGAN_ID, '05".$tahun."') MEI,
                   AMBIL_KENDALI_PERIODE(INVENTARIS_RUANGAN_ID, '06".$tahun."') JUN,
                   AMBIL_KENDALI_PERIODE(INVENTARIS_RUANGAN_ID, '07".$tahun."') JUL,
                   AMBIL_KENDALI_PERIODE(INVENTARIS_RUANGAN_ID, '08".$tahun."') AGT,
                   AMBIL_KENDALI_PERIODE(INVENTARIS_RUANGAN_ID, '09".$tahun."') SEP,
                   AMBIL_KENDALI_PERIODE(INVENTARIS_RUANGAN_ID, '10".$tahun."') OKT,
                   AMBIL_KENDALI_PERIODE(INVENTARIS_RUANGAN_ID, '11".$tahun."') NOV,
                   AMBIL_KENDALI_PERIODE(INVENTARIS_RUANGAN_ID, '12".$tahun."') DES
				FROM PPI_ASSET.INVENTARIS_RUANGAN A
				INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
				WHERE 1 = 1 AND A.STATUS_HAPUS = '0'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY A.LOKASI_PARENT_ID")
	{
		$str = "
				SELECT LOKASI_ID, KODE_GL_PUSAT KODE, PPI_ASSET.AMBIL_LOKASI_INVENTARIS(LOKASI_ID) || ' (' || SUMBER_DANA || ')' NAMA, (SELECT NAMA FROM PPI_ASSET.LOKASI X WHERE X.LOKASI_ID = A.LOKASI_PARENT_ID) LOKASI,  
				(SELECT COUNT(INVENTARIS_ID) FROM PPI_ASSET.INVENTARIS_RUANGAN X WHERE X.LOKASI_ID = A.LOKASI_ID AND X.STATUS_HAPUS = '0') JUMLAH
				FROM PPI_ASSET.LOKASI A WHERE 1 = 1
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
				INVENTARIS_RUANGAN_ID, INVENTARIS_ID, LOKASI_ID, 
				   KONDISI_FISIK_ID, NOMOR, COLUMN_4, 
				   COLUMN_5, COLUMN_6, COLUMN_7, 
				   COLUMN_8, COLUMN_9, COLUMN_10, 
				   COLUMN_11
				FROM PPI_ASSET.INVENTARIS_RUANGAN
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
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(INVENTARIS_RUANGAN_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_RUANGAN A  WHERE 1 = 1 AND A.STATUS_HAPUS = '0' ".$statement; 
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
	
	function getCountByParamsRekapHapusInventaris($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(INVENTARIS_RUANGAN_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_RUANGAN A
                INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
                WHERE 1 = 1 AND A.STATUS_HAPUS = '1' ".$statement; 
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

    function getCountByParamsRekapPenanggungJawab($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.INVENTARIS_RUANGAN_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_RUANGAN A
                    INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
                    INNER JOIN PPI_ASSET.INVENTARIS_LOKASI_HISTORI C ON A.INVENTARIS_RUANGAN_ID = C.INVENTARIS_RUANGAN_ID
                    INNER JOIN PPI_ASSET.INVENTARIS_TGJAWAB_TERAKHIR D ON A.INVENTARIS_RUANGAN_ID = D.INVENTARIS_RUANGAN_ID
                    WHERE 1 = 1 AND A.STATUS_HAPUS = '0' ".$statement; 
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
		
    function getCountByParamsRekapInventarisPindahHistori($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.INVENTARIS_RUANGAN_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_RUANGAN A
					INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
					INNER JOIN PPI_ASSET.INVENTARIS_LOKASI_HISTORI C ON A.INVENTARIS_RUANGAN_ID = C.INVENTARIS_RUANGAN_ID
					WHERE 1 = 1 AND A.STATUS_HAPUS = '0' AND EXISTS(SELECT 1 FROM PPI_ASSET.INVENTARIS_JUMLAH_HISTORI X WHERE X.INVENTARIS_RUANGAN_ID = A.INVENTARIS_RUANGAN_ID AND JUMLAH > 1) ".$statement; 
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

    function getNomorInventaris($reqInventaris, $reqLokasi, $reqTahun)
	{
		$str = "SELECT PPI_ASSET.INVENTARIS_PENOMORAN('".$reqInventaris."','".$reqLokasi."','".$reqTahun."') NOMOR FROM DUAL"; 
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("NOMOR"); 
		else 
			return ""; 
    }

    function getBarcodeInventaris($reqInventaris, $reqLokasi, $reqTahun)
	{
		$str = "SELECT PPI_ASSET.INVENTARIS_BARCODE('".$reqInventaris."','".$reqLokasi."','".$reqTahun."') BARCODE FROM DUAL"; 
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("BARCODE"); 
		else 
			return ""; 
    }
		
	function getCountByParamsPengendalian($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(INVENTARIS_RUANGAN_ID) AS ROWCOUNT 
				FROM PPI_ASSET.INVENTARIS_RUANGAN A
				INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
				WHERE 1 = 1  AND A.STATUS_HAPUS = '0' ".$statement; 
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
				
    function getCountByParamsPendataan($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(INVENTARIS_ID) AS ROWCOUNT FROM ( SELECT COUNT(A.INVENTARIS_ID) INVENTARIS_ID FROM PPI_ASSET.INVENTARIS_RUANGAN A
				INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
                INNER JOIN PPI_ASSET.JENIS_INVENTARIS C ON B.JENIS_INVENTARIS_ID = C.JENIS_INVENTARIS_ID
				WHERE 1 = 1 AND A.STATUS_HAPUS = '0'  ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= " GROUP BY A.INVENTARIS_ID, B.NAMA, C.NAMA ) A ";
		//echo $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	
	

    function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(LOKASI_ID) AS ROWCOUNT FROM PPI_ASSET.LOKASI A WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(INVENTARIS_RUANGAN_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_RUANGAN WHERE 1 = 1 "; 
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