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

  class Dokumen extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Dokumen()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("DOKUMEN_ID", $this->getNextId("DOKUMEN_ID","PPI_HUKUM.DOKUMEN"));
		$str = "
				INSERT INTO PPI_HUKUM.DOKUMEN (
				   DOKUMEN_ID, KATEGORI_ID, NOMOR, 
				   TAHUN, KETERANGAN, ISI_FILE, NAMA, NOMOR_CLIENT, 
				   TANGGAL_SK, TMT_SK, MASA_BERLAKU_AWAL, 
				   MASA_BERLAKU_AKHIR, LOKASI_ID) 
				VALUES (
				  ".$this->getField("DOKUMEN_ID").",
				  '".$this->getField("KATEGORI_ID")."',
				  '".$this->getField("NOMOR")."',
				  '".$this->getField("TAHUN")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("ISI_FILE")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("NOMOR_CLIENT")."',
				  ".$this->getField("TANGGAL_SK").",
				  ".$this->getField("TMT_SK").",
				  ".$this->getField("MASA_BERLAKU_AWAL").",
				  ".$this->getField("MASA_BERLAKU_AKHIR").",
				  '".$this->getField("LOKASI_ID")."'
				)"; 
				
		$this->id = $this->getField("DOKUMEN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_HUKUM.DOKUMEN
				SET    
					   KATEGORI_ID = '".$this->getField("KATEGORI_ID")."',
					   NOMOR       = '".$this->getField("NOMOR")."',
					   TAHUN       = '".$this->getField("TAHUN")."',
					   KETERANGAN  = '".$this->getField("KETERANGAN")."',
					   ISI_FILE    = '".$this->getField("ISI_FILE")."',
					   NAMA= '".$this->getField("NAMA")."',
					   NOMOR_CLIENT= '".$this->getField("NOMOR_CLIENT")."',
					   TANGGAL_SK= ".$this->getField("TANGGAL_SK").",
					   TMT_SK= ".$this->getField("TMT_SK").",
					   MASA_BERLAKU_AWAL= ".$this->getField("MASA_BERLAKU_AWAL").",
					   MASA_BERLAKU_AKHIR= ".$this->getField("MASA_BERLAKU_AKHIR").",
					   LOKASI_ID= '".$this->getField("LOKASI_ID")."'
				WHERE  DOKUMEN_ID = '".$this->getField("DOKUMEN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updatePindah()
	{
		$str = "
				UPDATE PPI_HUKUM.DOKUMEN
				SET    
					   KATEGORI_ID = '".$this->getField("KATEGORI_ID_BARU")."'
				WHERE  KATEGORI_ID = '".$this->getField("KATEGORI_ID_LAMA")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str1 = "DELETE FROM PPI_HUKUM.DOKUMEN_ATTACHMENT
                WHERE 
                  DOKUMEN_ID = ".$this->getField("DOKUMEN_ID").""; 
				  
		$this->query = $str1;
        $this->execQuery($str1);

		$str2 = "DELETE FROM PPI_HUKUM.DOKUMEN_DEPARTEMEN
                WHERE 
                  DOKUMEN_ID = ".$this->getField("DOKUMEN_ID").""; 
				  
		$this->query = $str2;
        $this->execQuery($str2);

		$str3 = "DELETE FROM PPI_HUKUM.DOKUMEN_JABATAN
                WHERE 
                  DOKUMEN_ID = ".$this->getField("DOKUMEN_ID").""; 
				  
		$this->query = $str3;
        $this->execQuery($str3);

		
		$str = "DELETE FROM PPI_HUKUM.DOKUMEN
                WHERE 
                  DOKUMEN_ID = ".$this->getField("DOKUMEN_ID").""; 
				  
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
				SELECT 
				A.DOKUMEN_ID, NOMOR,
				NVL(PPI_HUKUM.AMBIL_DEPARTEMEN_DOKUMEN(A.DOKUMEN_ID), 'Kantor Pusat PT. PMS') DEPARTEMEN, 
				NVL(PPI_HUKUM.AMBIL_JABATAN_DOKUMEN(A.DOKUMEN_ID), '-') JABATAN,
				PPI_HUKUM.AMBIL_DOKUMEN_ATTACHMENT(DOKUMEN_ID) KETERANGAN_ATC, 
				A.KATEGORI_ID, TAHUN, A.KETERANGAN, ISI_FILE, PPI_HUKUM.AMBIL_KATEGORI(A.KATEGORI_ID) KATEGORI,
				(SELECT COUNT(DOKUMEN_ATTACHMENT_ID) FROM PPI_HUKUM.DOKUMEN_ATTACHMENT DA WHERE DA.DOKUMEN_ID = A.DOKUMEN_ID) JUMLAH_DOKUMEN,
				(SELECT MAX(DOKUMEN_ATTACHMENT_ID) FROM PPI_HUKUM.DOKUMEN_ATTACHMENT DAA WHERE DAA.DOKUMEN_ID = A.DOKUMEN_ID) DOKUMEN_ATTACHMENT_AWAL,
				A.NAMA, NOMOR_CLIENT,  TANGGAL_SK, TMT_SK, MASA_BERLAKU_AWAL, MASA_BERLAKU_AKHIR, A.LOKASI_ID, C.NAMA LOKASI_NAMA, B.STATUS_TMT
				FROM PPI_HUKUM.DOKUMEN A 
				INNER JOIN PPI_HUKUM.KATEGORI B ON B.KATEGORI_ID=A.KATEGORI_ID
				LEFT JOIN PPI_OPERASIONAL.LOKASI C ON C.LOKASI_ID = A.LOKASI_ID  
				WHERE A.DOKUMEN_ID IS NOT NULL
				"; 
			
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
	
		
		$str .= $statement." ".$order;
		
			
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsMasaBerlakuHabis($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="", $batas_notifikasi="30")
	{
		$str = "
				SELECT 
				A.DOKUMEN_ID, NOMOR,
				NVL(PPI_HUKUM.AMBIL_DEPARTEMEN_DOKUMEN(A.DOKUMEN_ID), 'Kantor Pusat PT. PMS') DEPARTEMEN, 
				NVL(PPI_HUKUM.AMBIL_JABATAN_DOKUMEN(A.DOKUMEN_ID), '-') JABATAN,
				PPI_HUKUM.AMBIL_DOKUMEN_ATTACHMENT(DOKUMEN_ID) KETERANGAN_ATC, 
				A.KATEGORI_ID, TAHUN, A.KETERANGAN, ISI_FILE, PPI_HUKUM.AMBIL_KATEGORI(A.KATEGORI_ID) KATEGORI,
				(SELECT COUNT(DOKUMEN_ATTACHMENT_ID) FROM PPI_HUKUM.DOKUMEN_ATTACHMENT DA WHERE DA.DOKUMEN_ID = A.DOKUMEN_ID) JUMLAH_DOKUMEN,
				(SELECT MAX(DOKUMEN_ATTACHMENT_ID) FROM PPI_HUKUM.DOKUMEN_ATTACHMENT DAA WHERE DAA.DOKUMEN_ID = A.DOKUMEN_ID) DOKUMEN_ATTACHMENT_AWAL,
				A.NAMA, NOMOR_CLIENT,  TANGGAL_SK, TMT_SK, MASA_BERLAKU_AWAL, MASA_BERLAKU_AKHIR, A.LOKASI_ID, C.NAMA LOKASI_NAMA, B.STATUS_TMT,
				CASE 
					WHEN (A.MASA_BERLAKU_AKHIR - INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE AND A.MASA_BERLAKU_AKHIR > SYSDATE THEN 1
					WHEN A.MASA_BERLAKU_AKHIR <= SYSDATE THEN 2
					ELSE 0
				END STATUS
				FROM PPI_HUKUM.DOKUMEN A 
				INNER JOIN PPI_HUKUM.KATEGORI B ON B.KATEGORI_ID=A.KATEGORI_ID
				LEFT JOIN PPI_OPERASIONAL.LOKASI C ON C.LOKASI_ID = A.LOKASI_ID  
				WHERE A.DOKUMEN_ID IS NOT NULL AND 
				((A.MASA_BERLAKU_AKHIR - INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE AND A.MASA_BERLAKU_AKHIR > SYSDATE OR
				  A.MASA_BERLAKU_AKHIR <= SYSDATE)
				"; 
			
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
	
		
		$str .= $statement." ".$order;
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
    function selectByParamsNotifikasi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="", $batas_notifikasi="30")
	{
		$str = "
				SELECT 
				A.DOKUMEN_ID, NOMOR,
				NVL(PPI_HUKUM.AMBIL_DEPARTEMEN_DOKUMEN(A.DOKUMEN_ID), 'Kantor Pusat PT. PMS') DEPARTEMEN, 
				NVL(PPI_HUKUM.AMBIL_JABATAN_DOKUMEN(A.DOKUMEN_ID), '-') JABATAN,
				PPI_HUKUM.AMBIL_DOKUMEN_ATTACHMENT(DOKUMEN_ID) KETERANGAN_ATC, 
				A.KATEGORI_ID, TAHUN, A.KETERANGAN, ISI_FILE, PPI_HUKUM.AMBIL_KATEGORI(A.KATEGORI_ID) KATEGORI,
				(SELECT COUNT(DOKUMEN_ATTACHMENT_ID) FROM PPI_HUKUM.DOKUMEN_ATTACHMENT DA WHERE DA.DOKUMEN_ID = A.DOKUMEN_ID) JUMLAH_DOKUMEN,
				(SELECT MAX(DOKUMEN_ATTACHMENT_ID) FROM PPI_HUKUM.DOKUMEN_ATTACHMENT DAA WHERE DAA.DOKUMEN_ID = A.DOKUMEN_ID) DOKUMEN_ATTACHMENT_AWAL,
				A.NAMA, NOMOR_CLIENT,  TANGGAL_SK, TMT_SK, MASA_BERLAKU_AWAL, MASA_BERLAKU_AKHIR, A.LOKASI_ID, C.NAMA LOKASI_NAMA, B.STATUS_TMT,
				CASE 
					WHEN (A.MASA_BERLAKU_AKHIR - INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE AND A.MASA_BERLAKU_AKHIR > SYSDATE THEN 1
					WHEN A.MASA_BERLAKU_AKHIR <= SYSDATE THEN 2
					ELSE 0
				END STATUS
				FROM PPI_HUKUM.DOKUMEN A 
				INNER JOIN PPI_HUKUM.KATEGORI B ON B.KATEGORI_ID=A.KATEGORI_ID
				LEFT JOIN PPI_OPERASIONAL.LOKASI C ON C.LOKASI_ID = A.LOKASI_ID  
				WHERE A.DOKUMEN_ID IS NOT NULL
				"; 
			
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
	
		
		$str .= $statement." ".$order;
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJenisPegawai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="", $batas_notifikasi)
	{
		$str = "
				SELECT 
				A.DOKUMEN_ID, NOMOR,
				NVL(PPI_HUKUM.AMBIL_DEPARTEMEN_DOKUMEN(A.DOKUMEN_ID), 'Kantor Pusat PT. PMS') DEPARTEMEN, 
				NVL(PPI_HUKUM.AMBIL_JABATAN_DOKUMEN(A.DOKUMEN_ID), '-') JABATAN,
				PPI_HUKUM.AMBIL_DOKUMEN_ATTACHMENT(DOKUMEN_ID) KETERANGAN_ATC, 
				A.KATEGORI_ID, TAHUN, A.KETERANGAN, ISI_FILE, PPI_HUKUM.AMBIL_KATEGORI(A.KATEGORI_ID) KATEGORI,
				(SELECT COUNT(DOKUMEN_ATTACHMENT_ID) FROM PPI_HUKUM.DOKUMEN_ATTACHMENT DA WHERE DA.DOKUMEN_ID = A.DOKUMEN_ID) JUMLAH_DOKUMEN,
				(SELECT MAX(DOKUMEN_ATTACHMENT_ID) FROM PPI_HUKUM.DOKUMEN_ATTACHMENT DAA WHERE DAA.DOKUMEN_ID = A.DOKUMEN_ID) DOKUMEN_ATTACHMENT_AWAL,
				A.NAMA, NOMOR_CLIENT,  TANGGAL_SK, TMT_SK, MASA_BERLAKU_AWAL, MASA_BERLAKU_AKHIR, A.LOKASI_ID, C.NAMA LOKASI_NAMA, B.STATUS_TMT,
                E.NAMA PEGAWAI, E.NRP, PPI_SIMPEG.AMBIL_UNIT_KERJA(E.DEPARTEMEN_ID) DEPARTEMEN_PEGAWAI,
				CASE 
					WHEN (A.MASA_BERLAKU_AKHIR - INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE AND A.MASA_BERLAKU_AKHIR > SYSDATE THEN 1
					WHEN A.MASA_BERLAKU_AKHIR <= SYSDATE THEN 2
					ELSE 0
				END STATUS
				FROM PPI_HUKUM.DOKUMEN A 
				INNER JOIN PPI_HUKUM.KATEGORI B ON B.KATEGORI_ID=A.KATEGORI_ID
				LEFT JOIN PPI_OPERASIONAL.LOKASI C ON C.LOKASI_ID = A.LOKASI_ID
                INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI D ON A.DOKUMEN_ID = D.DOKUMEN_ID 
                INNER JOIN PPI_SIMPEG.PEGAWAI E ON E.PEGAWAI_ID = D.PEGAWAI_ID 
				WHERE A.DOKUMEN_ID IS NOT NULL
				"; 
			
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
	
		
		$str .= $statement." ".$order;
		
			
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsTahun($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY TAHUN DESC ")
	{
		$str = "
				SELECT TAHUN FROM PPI_HUKUM.DOKUMEN A WHERE 1 = 1	
				";  
			
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
	
		
		$str .= $statement." GROUP BY TAHUN ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.DOKUMEN_ID ASC")
	{
		$str = "
				SELECT 
                    A.DOKUMEN_ID, NOMOR,
                    PPI_HUKUM.AMBIL_DEPARTEMEN_DOKUMEN(A.DOKUMEN_ID) DEPARTEMEN, 
                    PPI_HUKUM.AMBIL_JABATAN_DOKUMEN(A.DOKUMEN_ID) JABATAN,
                    PPI_HUKUM.AMBIL_DOKUMEN_ATTACHMENT(DOKUMEN_ID) KETERANGAN_ATC, 
                    A.KATEGORI_ID, TAHUN, A.KETERANGAN, ISI_FILE, B.NAMA KATEGORI,
                    (SELECT COUNT(DOKUMEN_ATTACHMENT_ID) FROM PPI_HUKUM.DOKUMEN_ATTACHMENT DA WHERE DA.DOKUMEN_ID = A.DOKUMEN_ID) JUMLAH_DOKUMEN,
                    (SELECT MAX(DOKUMEN_ATTACHMENT_ID) FROM PPI_HUKUM.DOKUMEN_ATTACHMENT DAA WHERE DAA.DOKUMEN_ID = A.DOKUMEN_ID) DOKUMEN_ATTACHMENT_AWAL
                    FROM PPI_HUKUM.DOKUMEN A 
                    LEFT JOIN PPI_HUKUM.KATEGORI B ON B.KATEGORI_ID=A.KATEGORI_ID 
                    WHERE A.DOKUMEN_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		$this->query = $str;
		$str .= $statement." ".$order;
		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.DOKUMEN_ID) AS ROWCOUNT FROM PPI_HUKUM.DOKUMEN A 
				INNER JOIN PPI_HUKUM.KATEGORI B ON B.KATEGORI_ID=A.KATEGORI_ID
				LEFT JOIN PPI_OPERASIONAL.LOKASI C ON C.LOKASI_ID = A.LOKASI_ID  
				WHERE A.DOKUMEN_ID IS NOT NULL ".$statement; 
		
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

    function getCountByParamsMasaBerlakuHabis($paramsArray=array(), $statement="", $batas_notifikasi="30")
	{
		$str = "SELECT COUNT(A.DOKUMEN_ID) AS ROWCOUNT FROM PPI_HUKUM.DOKUMEN A 
				INNER JOIN PPI_HUKUM.KATEGORI B ON B.KATEGORI_ID=A.KATEGORI_ID
				LEFT JOIN PPI_OPERASIONAL.LOKASI C ON C.LOKASI_ID = A.LOKASI_ID  
				WHERE A.DOKUMEN_ID IS NOT NULL AND 
				((A.MASA_BERLAKU_AKHIR - INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE AND A.MASA_BERLAKU_AKHIR > SYSDATE OR
				  A.MASA_BERLAKU_AKHIR <= SYSDATE) ".$statement; 
		
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
	
    function getCountByParamsJenisPegawai($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.DOKUMEN_ID) AS ROWCOUNT 
				FROM PPI_HUKUM.DOKUMEN A 
				INNER JOIN PPI_HUKUM.KATEGORI B ON B.KATEGORI_ID=A.KATEGORI_ID
				LEFT JOIN PPI_OPERASIONAL.LOKASI C ON C.LOKASI_ID = A.LOKASI_ID
                INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI D ON A.DOKUMEN_ID = D.DOKUMEN_ID 
                INNER JOIN PPI_SIMPEG.PEGAWAI E ON E.PEGAWAI_ID = D.PEGAWAI_ID 
				WHERE A.DOKUMEN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(DOKUMEN_ID) AS ROWCOUNT FROM PPI_HUKUM.DOKUMEN A
		        WHERE A.DOKUMEN_ID IS NOT NULL ".$statement; 
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