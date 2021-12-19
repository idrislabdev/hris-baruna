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
  * Entity-base class untuk mengimplementasikan tabel ARSIP.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Arsip extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Arsip()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ARSIP_ID", $this->getNextId("ARSIP_ID","PPI_ASSET.ARSIP")); 		

		$str = "
				INSERT INTO PPI_ASSET.ARSIP (
				   ARSIP_ID, KATEGORI_ID, SIFAT_ID, 
				   LOKASI_ID, BOKS_PENYIMPANAN_ID, KODE_ARSIP, 
				   NOMOR_SURAT, TANGGAL, TANGGAL_TMT, 
				   MASA_BERLAKU_AWAL, MASA_BERLAKU_AKHIR, NAMA, 
				   KETERANGAN, KATA_KUNCI, RINGKASAN, 
				   NAMA_ASAL, ALAMAT_ASAL, NAMA_TUJUAN, 
				   ALAMAT_TUJUAN, PUBLISH_ARSIP, STATUS_HAPUS, UPDATED_BY, UPDATED_DATE) 
 			  	VALUES (
				  ".$this->getField("ARSIP_ID").",
				  ".$this->getField("KATEGORI_ID").",
  				  ".$this->getField("SIFAT_ID").",
				  '".$this->getField("LOKASI_ID")."',
   				  ".$this->getField("BOKS_PENYIMPANAN_ID").",
				  '".$this->getField("KODE_ARSIP")."',
				  '".$this->getField("NOMOR_SURAT")."',
				  ".$this->getField("TANGGAL").",
				  ".$this->getField("TANGGAL_TMT").",
				  ".$this->getField("MASA_BERLAKU_AWAL").",
				  ".$this->getField("MASA_BERLAKU_AKHIR").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("KATA_KUNCI")."',
				  '".$this->getField("RINGKASAN")."',
				  '".$this->getField("NAMA_ASAL")."',
				  '".$this->getField("ALAMAT_ASAL")."',
				  '".$this->getField("NAMA_TUJUAN")."',
				  '".$this->getField("ALAMAT_TUJUAN")."',
				  '".$this->getField("PUBLISH_ARSIP")."',
				  '".$this->getField("STATUS_HAPUS")."',
				  '".$this->getField("UPDATED_BY")."',
				  ".$this->getField("UPDATED_DATE")."
				)"; 
		$this->id = $this->getField("ARSIP_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_ASSET.ARSIP
				SET    
						KATEGORI_ID		= ".$this->getField("KATEGORI_ID").",
  				  		SIFAT_ID		= ".$this->getField("SIFAT_ID").",
				  		LOKASI_ID		= '".$this->getField("LOKASI_ID")."',
   				  		BOKS_PENYIMPANAN_ID = ".$this->getField("BOKS_PENYIMPANAN_ID").",
				  		KODE_ARSIP		= '".$this->getField("KODE_ARSIP")."',
				  		NOMOR_SURAT		= '".$this->getField("NOMOR_SURAT")."',
				  		TANGGAL			= ".$this->getField("TANGGAL").",
				  		TANGGAL_TMT		= ".$this->getField("TANGGAL_TMT").",
				  		MASA_BERLAKU_AWAL = ".$this->getField("MASA_BERLAKU_AWAL").",
				  		MASA_BERLAKU_AKHIR = ".$this->getField("MASA_BERLAKU_AKHIR").",
				  		NAMA			= '".$this->getField("NAMA")."',
				  		KETERANGAN		= '".$this->getField("KETERANGAN")."',
				  		KATA_KUNCI		= '".$this->getField("KATA_KUNCI")."',
				  		RINGKASAN		= '".$this->getField("RINGKASAN")."',
				  		NAMA_ASAL		= '".$this->getField("NAMA_ASAL")."',
				  		ALAMAT_ASAL		= '".$this->getField("ALAMAT_ASAL")."',
				  		NAMA_TUJUAN		= '".$this->getField("NAMA_TUJUAN")."',
				  		ALAMAT_TUJUAN	= '".$this->getField("ALAMAT_TUJUAN")."',
				  		PUBLISH_ARSIP	= '".$this->getField("PUBLISH_ARSIP")."',
				  		STATUS_HAPUS	= '".$this->getField("STATUS_HAPUS")."',
					   	UPDATED_BY		= '".$this->getField("UPDATED_BY")."',
					   	UPDATED_DATE	= ".$this->getField("UPDATED_DATE")."					   
				WHERE  ARSIP_ID     = '".$this->getField("ARSIP_ID")."'

			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ASSET.ARSIP A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE ARSIP_ID = ".$this->getField("ARSIP_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.ARSIP
                WHERE 
                  ARSIP_ID = ".$this->getField("ARSIP_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.ARSIP_ID DESC ")
	{
		$str = "
					SELECT 
						   ARSIP_ID, KATEGORI_ID, SIFAT_ID, 
						   LOKASI_ID, BOKS_PENYIMPANAN_ID, KODE_ARSIP, 
						   NOMOR_SURAT, TANGGAL, TANGGAL_TMT, 
						   MASA_BERLAKU_AWAL, MASA_BERLAKU_AKHIR, NAMA, 
						   KETERANGAN, KATA_KUNCI, RINGKASAN, 
						   NAMA_ASAL, ALAMAT_ASAL, NAMA_TUJUAN, 
						   ALAMAT_TUJUAN, PUBLISH_ARSIP, STATUS_HAPUS, 
						   UPDATED_BY, UPDATED_DATE
					FROM PPI_ASSET.ARSIP A WHERE ARSIP_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.ARSIP_ID DESC ")
	{
		$str = "
					SELECT 
                           ARSIP_ID, A.KATEGORI_ID, B.NAMA KATEGORI, A.SIFAT_ID, C.NAMA SIFAT,
                           A.LOKASI_ID, D.NAMA LOKASI, A.BOKS_PENYIMPANAN_ID, E.NAMA BOKS_PENYIMPANAN, KODE_ARSIP, 
                           NOMOR_SURAT, TANGGAL, TANGGAL_TMT, 
                           MASA_BERLAKU_AWAL, MASA_BERLAKU_AKHIR, A.NAMA, 
                           A.KETERANGAN, KATA_KUNCI, RINGKASAN, 
                           NAMA_ASAL, ALAMAT_ASAL, NAMA_TUJUAN, 
                           ALAMAT_TUJUAN, PUBLISH_ARSIP, STATUS_HAPUS
                    FROM PPI_ASSET.ARSIP A 
                    LEFT JOIN PPI_ASSET.KATEGORI B ON A.KATEGORI_ID=B.KATEGORI_ID
                    LEFT JOIN PPI_ASSET.SIFAT C ON A.SIFAT_ID=C.SIFAT_ID
                    LEFT JOIN PPI_ASSET.LOKASI D ON A.LOKASI_ID=D.LOKASI_ID
                    LEFT JOIN PPI_ASSET.BOKS_PENYIMPANAN E ON A.BOKS_PENYIMPANAN_ID=E.BOKS_PENYIMPANAN_ID
                    WHERE ARSIP_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsPencarian($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.ARSIP_ID DESC ")
	{
		$str = "
					SELECT 
                           ARSIP_ID, A.NAMA || ' - '|| B.NAMA ARSIP_BOKS
                    FROM PPI_ASSET.ARSIP A 
                    LEFT JOIN PPI_ASSET.BOKS_PENYIMPANAN B ON A.BOKS_PENYIMPANAN_ID=B.BOKS_PENYIMPANAN_ID
                    WHERE ARSIP_ID IS NOT NULL
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
		$str = "	SELECT 
						   ARSIP_ID, KATEGORI_ID, SIFAT_ID, 
						   LOKASI_ID, BOKS_PENYIMPANAN_ID, KODE_ARSIP, 
						   NOMOR_SURAT, TANGGAL, TANGGAL_TMT, 
						   MASA_BERLAKU_AWAL, MASA_BERLAKU_AKHIR, NAMA, 
						   KETERANGAN, KATA_KUNCI, RINGKASAN, 
						   NAMA_ASAL, ALAMAT_ASAL, NAMA_TUJUAN, 
						   ALAMAT_TUJUAN, PUBLISH_ARSIP, STATUS_HAPUS, 
						   UPDATED_BY, UPDATED_DATE
					FROM PPI_ASSET.ARSIP A WHERE ARSIP_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY A.NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(ARSIP_ID) AS ROWCOUNT FROM PPI_ASSET.ARSIP A
		        WHERE ARSIP_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(ARSIP_ID) AS ROWCOUNT FROM PPI_ASSET.ARSIP A 
                    LEFT JOIN PPI_ASSET.KATEGORI B ON A.KATEGORI_ID=B.KATEGORI_ID
                    LEFT JOIN PPI_ASSET.SIFAT C ON A.SIFAT_ID=C.SIFAT_ID
                    LEFT JOIN PPI_ASSET.LOKASI D ON A.LOKASI_ID=D.LOKASI_ID
                    LEFT JOIN PPI_ASSET.BOKS_PENYIMPANAN E ON A.BOKS_PENYIMPANAN_ID=E.BOKS_PENYIMPANAN_ID
                    WHERE ARSIP_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(ARSIP_ID) AS ROWCOUNT FROM PPI_ASSET.ARSIP A
		        WHERE ARSIP_ID IS NOT NULL ".$statement; 
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