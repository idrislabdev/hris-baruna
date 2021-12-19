<? 
/* *******************************************************************************************************
MODUL NAME 			: PPI
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel PANGKAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class SppdPeserta extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SppdPeserta()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SPPD_PESERTA_ID", $this->getNextId("SPPD_PESERTA_ID","PPI_SPPD.SPPD_PESERTA"));
		$str = "INSERT INTO PPI_SPPD.SPPD_PESERTA (
				   SPPD_PESERTA_ID, SPPD_ID, PEGAWAI_ID, 
				   STATUS, JABATAN_KONSINYERING_ID, JABATAN_DOCKING_REPAIR_ID, KRU_JABATAN_ID, KAPAL_ID, 
				   NAMA_PENGGANTI, KELAS_PENGGANTI, JABATAN_ID_PENGGANTI, JABATAN_NAMA_PENGGANTI, 
				   KOTA_ID_BERANGKAT_PESERTA, AIRPORT_TAX_BERANGKAT_PESERTA, KOTA_ID_TUJUAN_PESERTA, AIRPORT_TAX_TUJUAN_PESERTA,
				   ANGKUTAN_ID_PESERTA) 
				VALUES (".$this->getField("SPPD_PESERTA_ID").",
						'".$this->getField("SPPD_ID")."',
						'".$this->getField("PEGAWAI_ID")."', 
				   		'".$this->getField("STATUS")."', 
				   		'".$this->getField("JABATAN_KONSINYERING_ID")."', 
				   		'".$this->getField("JABATAN_DOCKING_REPAIR_ID")."', 
				   		'".$this->getField("KRU_JABATAN_ID")."', 
				   		'".$this->getField("KAPAL_ID")."', 
				   		'".$this->getField("NAMA_PENGGANTI")."', 
				   		'".$this->getField("KELAS_PENGGANTI")."',
						'".$this->getField("JABATAN_ID_PENGGANTI")."',
						'".$this->getField("JABATAN_NAMA_PENGGANTI")."',
						'".$this->getField("KOTA_ID_BERANGKAT_PESERTA")."',
						'".$this->getField("AIRPORT_TAX_BERANGKAT_PESERTA")."',
						'".$this->getField("KOTA_ID_TUJUAN_PESERTA")."',
						'".$this->getField("AIRPORT_TAX_TUJUAN_PESERTA")."',
						'".$this->getField("ANGKUTAN_ID_PESERTA")."'
						)"; 
						
		$this->id = $this->getField("SPPD_PESERTA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function insertPerpanjangan()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SPPD_PESERTA_ID", $this->getNextId("SPPD_PESERTA_ID","PPI_SPPD.SPPD_PESERTA"));
		$str = "INSERT INTO PPI_SPPD.SPPD_PESERTA (
				   SPPD_PESERTA_ID, SPPD_ID, PEGAWAI_ID, 
				   STATUS, JABATAN_KONSINYERING_ID, JABATAN_DOCKING_REPAIR_ID, KRU_JABATAN_ID, KAPAL_ID) 
				SELECT (SELECT MAX(SPPD_PESERTA_ID) FROM PPI_SPPD.SPPD_PESERTA) + ROWNUM SPPD_PESERTA_ID, '".$this->getField("SPPD_ID")."' SPPD_ID, PEGAWAI_ID, 
				   STATUS, JABATAN_KONSINYERING_ID, JABATAN_DOCKING_REPAIR_ID, KRU_JABATAN_ID, KAPAL_ID
				 FROM PPI_SPPD.SPPD_PESERTA WHERE SPPD_ID = '".$this->getField("SPPD_ID_LAST")."'
				"; 
						
		$this->id = $this->getField("SPPD_PESERTA_ID");
		//echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE PPI_SPPD.SPPD_PESERTA
				SET    SPPD_ID         = '".$this->getField("SPPD_ID")."',
					   PEGAWAI_ID      = '".$this->getField("PEGAWAI_ID")."',
					   STATUS          = '".$this->getField("STATUS")."', 
				   	   JABATAN_KONSINYERING_ID = '".$this->getField("JABATAN_KONSINYERING_ID")."', 
	     		   	   JABATAN_DOCKING_REPAIR_ID = '".$this->getField("JABATAN_DOCKING_REPAIR_ID")."', 
				   	   NAMA_PENGGANTI = '".$this->getField("NAMA_PENGGANTI")."', 
				   	   KELAS_PENGGANTI = '".$this->getField("KELAS_PENGGANTI")."', 
				   	   JABATAN_ID_PENGGANTI = '".$this->getField("JABATAN_ID_PENGGANTI")."',
					   JABATAN_NAMA_PENGGANTI = '".$this->getField("JABATAN_NAMA_PENGGANTI")."',
					   KOTA_ID_BERANGKAT_PESERTA = '".$this->getField("KOTA_ID_BERANGKAT_PESERTA")."',
					   AIRPORT_TAX_BERANGKAT_PESERTA = '".$this->getField("AIRPORT_TAX_BERANGKAT_PESERTA")."',
					   KOTA_ID_TUJUAN_PESERTA = '".$this->getField("KOTA_ID_TUJUAN_PESERTA")."',
					   AIRPORT_TAX_TUJUAN_PESERTA = '".$this->getField("AIRPORT_TAX_TUJUAN_PESERTA")."',
					   ANGKUTAN_ID_PESERTA = '".$this->getField("ANGKUTAN_ID_PESERTA")."'
				WHERE  SPPD_PESERTA_ID = '".$this->getField("SPPD_PESERTA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateRealisasi()
	{
		$str = "
				UPDATE PPI_SPPD.SPPD_PESERTA
				SET    TANGGAL_BERANGKAT_REALISASI 		= ".$this->getField("TANGGAL_BERANGKAT_REALISASI").",
					   TANGGAL_KEMBALI_REALISASI   		= ".$this->getField("TANGGAL_KEMBALI_REALISASI").",
					   TANGGAL_BERANGKAT_BERIKUTNYA_R   = ".$this->getField("TANGGAL_BERANGKAT_BERIKUTNYA_R").",
					   LAMA_PERJALANAN_REALISASI   		= '".$this->getField("LAMA_PERJALANAN_REALISASI")."'
				WHERE  SPPD_PESERTA_ID 			 = '".$this->getField("SPPD_PESERTA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateRealisasiBatal()
	{
		$str = "
				UPDATE PPI_SPPD.SPPD_PESERTA
				SET    
					   LAMA_PERJALANAN_REALISASI   		= 0
				WHERE  SPPD_ID = '".$this->getField("SPPD_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateTanggalKembaliRealisasi()
	{
		$str = "
				UPDATE PPI_SPPD.SPPD_PESERTA
				SET    TANGGAL_KEMBALI_REALISASI   		= ".$this->getField("TANGGAL_KEMBALI_REALISASI")."
				WHERE  SPPD_PESERTA_ID 			 = '".$this->getField("SPPD_PESERTA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateLamaPerjalananRealisasi()
	{
		$str = "
				UPDATE PPI_SPPD.SPPD_PESERTA
				SET    LAMA_PERJALANAN_REALISASI   		= '".$this->getField("LAMA_PERJALANAN_REALISASI")."'
				WHERE  SPPD_PESERTA_ID 			 = '".$this->getField("SPPD_PESERTA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
		
    function updateData()
	{
		$str = "
				UPDATE PPI_SPPD.SPPD_PESERTA
				SET    SPPD_ID         = '".$this->getField("SPPD_ID")."',
					   PEGAWAI_ID      = '".$this->getField("PEGAWAI_ID")."',
				   	   JABATAN_KONSINYERING_ID = '".$this->getField("JABATAN_KONSINYERING_ID")."', 
	     		   	   JABATAN_DOCKING_REPAIR_ID = '".$this->getField("JABATAN_DOCKING_REPAIR_ID")."'
				WHERE  SPPD_PESERTA_ID = '".$this->getField("SPPD_PESERTA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.SPPD_PESERTA
                WHERE 
                  SPPD_PESERTA_ID = ".$this->getField("SPPD_PESERTA_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteUtama()
	{
        $str = "DELETE FROM PPI_SPPD.SPPD_PESERTA
                WHERE 
                  SPPD_ID = ".$this->getField("SPPD_ID")." AND 
				  STATUS = '".$this->getField("STATUS")."' "; 
				  
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
		$str = "SELECT 
                    A.SPPD_PESERTA_ID, A.SPPD_ID, A.PEGAWAI_ID, A.JABATAN_KONSINYERING_ID, D.NAMA JABATAN_KONSINYERING,
                        A.JABATAN_DOCKING_REPAIR_ID, NVL(E.NAMA, F.NAMA) JABATAN_DOCKING_REPAIR, A.AIRPORT_TAX_BERANGKAT_PESERTA AIRPORT_TAX_BERANGKAT_PESERTA,
                        A.KOTA_ID_BERANGKAT_PESERTA KOTA_ID_BERANGKAT_PESERTA, 
                       A.STATUS, B.NAMA PEGAWAI, C.KETERANGAN, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(B.DEPARTEMEN_ID,0)) DEPARTEMEN,
                       C.KELAS, C.NAMA JABATAN, DECODE(STATUS, 'U', 'Utama', 'Peserta') STATUS_INFO, B.NRP, A.KOTA_ID_TUJUAN_PESERTA, A.AIRPORT_TAX_TUJUAN_PESERTA, ANGKUTAN_ID_PESERTA
                    FROM PPI_SPPD.SPPD_PESERTA A
                    INNER JOIN PPI_SIMPEG.PEGAWAI B ON B.PEGAWAI_ID=A.PEGAWAI_ID                   
                    LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON B.PEGAWAI_ID = C.PEGAWAI_ID
                    LEFT JOIN PPI_SPPD.JABATAN_KONSINYERING D ON A.JABATAN_KONSINYERING_ID=D.JABATAN_KONSINYERING_ID
                    LEFT JOIN PPI_SPPD.JABATAN_DOCKING_REPAIR E ON A.JABATAN_DOCKING_REPAIR_ID=E.JABATAN_DOCKING_REPAIR_ID
                    LEFT JOIN PPI_OPERASIONAL.KRU_JABATAN F ON A.KRU_JABATAN_ID = F.KRU_JABATAN_ID
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
	
    function selectByParamsDinas($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT 
                    A.SPPD_PESERTA_ID, A.SPPD_ID, A.PEGAWAI_ID, A.JABATAN_KONSINYERING_ID, D.NAMA JABATAN_KONSINYERING,
                        A.JABATAN_DOCKING_REPAIR_ID, NVL(E.NAMA, F.NAMA) JABATAN_DOCKING_REPAIR, NVL(A.AIRPORT_TAX_BERANGKAT_PESERTA, G.AIRPORT_TAX_BERANGKAT) AIRPORT_TAX_BERANGKAT_PESERTA,
                        NVL(A.KOTA_ID_BERANGKAT_PESERTA, G.KOTA_ID_BERANGKAT) KOTA_ID_BERANGKAT_PESERTA, H.NAMA KOTA,
                       A.STATUS, B.NAMA PEGAWAI, C.KETERANGAN, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(B.DEPARTEMEN_ID,0)) DEPARTEMEN,
                       C.KELAS, C.NAMA JABATAN, DECODE(STATUS, 'U', 'Utama', 'Peserta') STATUS_INFO, B.NRP
                    FROM PPI_SPPD.SPPD_PESERTA A
                    INNER JOIN PPI_SIMPEG.PEGAWAI B ON B.PEGAWAI_ID=A.PEGAWAI_ID                   
                    LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON B.PEGAWAI_ID = C.PEGAWAI_ID
                    LEFT JOIN PPI_SPPD.JABATAN_KONSINYERING D ON A.JABATAN_KONSINYERING_ID=D.JABATAN_KONSINYERING_ID
                    LEFT JOIN PPI_SPPD.JABATAN_DOCKING_REPAIR E ON A.JABATAN_DOCKING_REPAIR_ID=E.JABATAN_DOCKING_REPAIR_ID
                    LEFT JOIN PPI_OPERASIONAL.KRU_JABATAN F ON A.KRU_JABATAN_ID = F.KRU_JABATAN_ID
                    LEFT JOIN PPI_SPPD.SPPD G ON A.SPPD_ID = G.SPPD_ID
                    LEFT JOIN PPI_SPPD.KOTA H ON NVL(A.KOTA_ID_BERANGKAT_PESERTA, G.KOTA_ID_BERANGKAT) = H.KOTA_ID
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
	
	function selectByParamsDinasModif($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT 
                    A.SPPD_PESERTA_ID, A.SPPD_ID, A.PEGAWAI_ID, A.JABATAN_KONSINYERING_ID, D.NAMA JABATAN_KONSINYERING,
                        A.JABATAN_DOCKING_REPAIR_ID, NVL(E.NAMA, F.NAMA) JABATAN_DOCKING_REPAIR, NVL(A.AIRPORT_TAX_BERANGKAT_PESERTA, G.AIRPORT_TAX_BERANGKAT) AIRPORT_TAX_BERANGKAT_PESERTA,
                        NVL(A.KOTA_ID_BERANGKAT_PESERTA, G.KOTA_ID_BERANGKAT) KOTA_ID_BERANGKAT_PESERTA, H.NAMA KOTA,
                       A.STATUS, NVL(B.NAMA, A.NAMA_PENGGANTI) PEGAWAI, C.KETERANGAN, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(B.DEPARTEMEN_ID,0)) DEPARTEMEN,
                       C.KELAS, C.NAMA JABATAN, DECODE(STATUS, 'U', 'Utama', 'Peserta') STATUS_INFO, B.NRP,
					   A.KELAS_PENGGANTI, A.JABATAN_ID_PENGGANTI, A.JABATAN_NAMA_PENGGANTI,
					   A.KOTA_ID_TUJUAN_PESERTA, A.AIRPORT_TAX_TUJUAN_PESERTA, ANGKUTAN_ID_PESERTA
                    FROM PPI_SPPD.SPPD_PESERTA A
                    LEFT JOIN PPI_SIMPEG.PEGAWAI B ON B.PEGAWAI_ID=A.PEGAWAI_ID                   
                    LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON B.PEGAWAI_ID = C.PEGAWAI_ID
                    LEFT JOIN PPI_SPPD.JABATAN_KONSINYERING D ON A.JABATAN_KONSINYERING_ID=D.JABATAN_KONSINYERING_ID
                    LEFT JOIN PPI_SPPD.JABATAN_DOCKING_REPAIR E ON A.JABATAN_DOCKING_REPAIR_ID=E.JABATAN_DOCKING_REPAIR_ID
                    LEFT JOIN PPI_OPERASIONAL.KRU_JABATAN F ON A.KRU_JABATAN_ID = F.KRU_JABATAN_ID
                    LEFT JOIN PPI_SPPD.SPPD G ON A.SPPD_ID = G.SPPD_ID
                    LEFT JOIN PPI_SPPD.KOTA H ON NVL(A.KOTA_ID_BERANGKAT_PESERTA, G.KOTA_ID_BERANGKAT) = H.KOTA_ID
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
	
	function selectByParamsPengganti($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT 
                    A.SPPD_PESERTA_ID, A.SPPD_ID, A.PEGAWAI_ID, A.JABATAN_KONSINYERING_ID, D.NAMA JABATAN_KONSINYERING,
                        A.JABATAN_DOCKING_REPAIR_ID, NVL(E.NAMA, F.NAMA) JABATAN_DOCKING_REPAIR,
						NVL(E.NAMA, F.NAMA) JABATAN_DOCKING_REPAIR, NVL(A.AIRPORT_TAX_BERANGKAT_PESERTA, G.AIRPORT_TAX_BERANGKAT) AIRPORT_TAX_BERANGKAT_PESERTA,
                        NVL(A.KOTA_ID_BERANGKAT_PESERTA, G.KOTA_ID_BERANGKAT) KOTA_ID_BERANGKAT_PESERTA, H.NAMA KOTA,
                       A.STATUS, DECODE(STATUS, 'U', 'Utama', 'Peserta') STATUS_INFO,
					   A.NAMA_PENGGANTI, A.KELAS_PENGGANTI, A.JABATAN_ID_PENGGANTI, A.JABATAN_NAMA_PENGGANTI,
					   A.KOTA_ID_TUJUAN_PESERTA, A.AIRPORT_TAX_TUJUAN_PESERTA, ANGKUTAN_ID_PESERTA
                    FROM PPI_SPPD.SPPD_PESERTA A
                    LEFT JOIN PPI_SPPD.JABATAN_KONSINYERING D ON A.JABATAN_KONSINYERING_ID=D.JABATAN_KONSINYERING_ID
                    LEFT JOIN PPI_SPPD.JABATAN_DOCKING_REPAIR E ON A.JABATAN_DOCKING_REPAIR_ID=E.JABATAN_DOCKING_REPAIR_ID
                    LEFT JOIN PPI_OPERASIONAL.KRU_JABATAN F ON A.KRU_JABATAN_ID = F.KRU_JABATAN_ID
                    LEFT JOIN PPI_SPPD.SPPD G ON A.SPPD_ID = G.SPPD_ID
                    LEFT JOIN PPI_SPPD.KOTA H ON NVL(A.KOTA_ID_BERANGKAT_PESERTA, G.KOTA_ID_BERANGKAT) = H.KOTA_ID
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

    function selectByParamsTggJawab($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.SPPD_PESERTA_ID, A.STATUS DESC, B.TANGGAL_BERANGKAT ASC ")
	{
		$str = " SELECT A.SPPD_PESERTA_ID, NVL(E.NAMA, A.NAMA_PENGGANTI) PEGAWAI, D.NAMA KOTA, B.KOTA_ID,
                        NVL(F.TANGGAL_BERANGKAT_REALISASI, B.TANGGAL_BERANGKAT) TANGGAL_BERANGKAT, 
                        NVL(A.TANGGAL_KEMBALI_REALISASI, C.TANGGAL_KEMBALI) TANGGAL_KEMBALI, NVL(A.LAMA_PERJALANAN_REALISASI, C.LAMA_PERJALANAN) LAMA_PERJALANAN
                 FROM PPI_SPPD.SPPD_PESERTA A
                 INNER JOIN PPI_SPPD.SPPD_TUJUAN B ON A.SPPD_ID = B.SPPD_ID
                 INNER JOIN PPI_SPPD.SPPD C ON A.SPPD_ID = C.SPPD_ID
                 INNER JOIN PPI_SPPD.KOTA D ON B.KOTA_ID = D.KOTA_ID
                 LEFT JOIN PPI_SIMPEG.PEGAWAI E ON A.PEGAWAI_ID = E.PEGAWAI_ID
                 LEFT JOIN PPI_SPPD.SPPD_TUJUAN_REALISASI F ON F.SPPD_PESERTA_ID = A.SPPD_PESERTA_ID AND F.KOTA_ID = B.KOTA_ID
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
	
    function selectByParamsPenugasanPeserta($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT A.PEGAWAI_ID, A.KRU_JABATAN_ID, A.KAPAL_ID FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI A
                INNER JOIN PPI_OPERASIONAL.PENUGASAN_KAPAL B ON A.KAPAL_ID = B.KAPAL_ID 
                INNER JOIN PPI_OPERASIONAL.PENUGASAN C ON B.PENUGASAN_ID = C.PENUGASAN_ID
                WHERE C.TANGGAL_AWAL BETWEEN A.TANGGAL_MASUK AND NVL(A.TANGGAL_KELUAR, SYSDATE)
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
		$str = "SELECT 
					SPPD_PESERTA_ID, SPPD_ID, PEGAWAI_ID, 
					   STATUS
					FROM PPI_SPPD.SPPD_PESERTA
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SPPD_PESERTA_ID) AS ROWCOUNT FROM PPI_SPPD.SPPD_PESERTA A
                    INNER JOIN PPI_SIMPEG.PEGAWAI B ON B.PEGAWAI_ID=A.PEGAWAI_ID
                    LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON B.PEGAWAI_ID = C.PEGAWAI_ID
					LEFT JOIN PPI_SPPD.JABATAN_KONSINYERING D ON A.JABATAN_KONSINYERING_ID=D.JABATAN_KONSINYERING_ID
					LEFT JOIN PPI_SPPD.JABATAN_DOCKING_REPAIR E ON A.JABATAN_DOCKING_REPAIR_ID=E.JABATAN_DOCKING_REPAIR_ID
                WHERE 1 = 1 ".$statement; 
		
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

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SPPD_PESERTA_ID) AS ROWCOUNT FROM PPI_SPPD.SPPD_PESERTA

		        WHERE SPPD_PESERTA_ID IS NOT NULL ".$statement; 
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