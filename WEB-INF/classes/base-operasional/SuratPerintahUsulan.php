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
  * Entity-base class untuk mengimplementasikan tabel KAPAL_JENIS.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class SuratPerintahUsulan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SuratPerintahUsulan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURAT_PERINTAH_USULAN_ID", $this->getNextId("SURAT_PERINTAH_USULAN_ID","PPI_OPERASIONAL.SURAT_PERINTAH_USULAN"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.SURAT_PERINTAH_USULAN (
				   SURAT_PERINTAH_USULAN_ID, SURAT_PERINTAH_ID, SURAT_PERINTAH_PEGAWAI_ID) 
				VALUES ('".$this->getField("SURAT_PERINTAH_USULAN_ID")."', '".$this->getField("SURAT_PERINTAH_ID")."', '".$this->getField("SURAT_PERINTAH_PEGAWAI_ID")."')"; 
		$this->id = $this->getField("SURAT_PERINTAH_USULAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.SURAT_PERINTAH_USULAN
				SET    
					   KAPAL_ID			= '".$this->getField("KAPAL_ID")."',
					   KETERANGAN   		= '".$this->getField("KETERANGAN")."',
					   NOMOR  		= '".$this->getField("NOMOR")."',
					   NAMA	 			= '".$this->getField("NAMA")."',
					   JUMLAH			= ".$this->getField("JUMLAH").",
					   TANGGAL_AWAL		= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR				= ".$this->getField("TANGGAL_AKHIR").",
					   LAST_UPDATE_USER				= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE				= ".$this->getField("LAST_UPDATE_DATE").",
					   PROSENTASE_PREMI 			= '".$this->getField("PROSENTASE_PREMI")."',
					   TANGGAL_AWAL_REALISASI= ".$this->getField("TANGGAL_AWAL_REALISASI").",
				  	   TANGGAL_AKHIR_REALISASI= ".$this->getField("TANGGAL_AKHIR_REALISASI")."
				WHERE  SURAT_PERINTAH_USULAN_ID  = '".$this->getField("SURAT_PERINTAH_USULAN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.SURAT_PERINTAH_USULAN
                WHERE 
                  SURAT_PERINTAH_USULAN_ID = ".$this->getField("SURAT_PERINTAH_USULAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_AWAL ASC")
	{
		$str = "
				  SELECT B.SURAT_PERINTAH_USULAN_ID, NRP, NAMA, KELAS, JABATAN_AWAL, KAPAL_AWAL, JABATAN_AKHIR, KAPAL_AKHIR 
				  FROM PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI A INNER JOIN PPI_OPERASIONAL.SURAT_PERINTAH_USULAN B 
				  ON A.SURAT_PERINTAH_PEGAWAI_ID = B.SURAT_PERINTAH_PEGAWAI_ID
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
				  SELECT SURAT_PERINTAH_USULAN_ID, KAPAL_ID, KETERANGAN, NOMOR, NAMA
				  FROM PPI_OPERASIONAL.SURAT_PERINTAH_USULAN					
				  WHERE SURAT_PERINTAH_USULAN_ID IS NOT NULL
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
		$str = "SELECT COUNT(SURAT_PERINTAH_USULAN_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.SURAT_PERINTAH_USULAN
		        WHERE SURAT_PERINTAH_USULAN_ID IS NOT NULL ".$statement; 
		
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

    function getCountByParamsKapalKhususPremi($paramsArray=array(), $statement="")
	{
		$str = "  SELECT COUNT(A.SURAT_PERINTAH_USULAN_ID) ROWCOUNT FROM PPI_OPERASIONAL.SURAT_PERINTAH_USULAN A
                  LEFT JOIN PPI_OPERASIONAL.LOKASI B ON A.KETERANGAN=B.KETERANGAN
                  LEFT JOIN PPI_OPERASIONAL.KAPAL C ON C.KAPAL_ID=A.KAPAL_ID
                  WHERE SURAT_PERINTAH_USULAN_ID IS NOT NULL AND EXISTS(SELECT 1 FROM PPI_GAJI.PREMI_SURAT_PERINTAH_USULAN X WHERE X.SURAT_PERINTAH_USULAN_ID = A.SURAT_PERINTAH_USULAN_ID) ".$statement; 
		
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
		$str = "SELECT COUNT(SURAT_PERINTAH_USULAN_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.SURAT_PERINTAH_USULAN
		        WHERE SURAT_PERINTAH_USULAN_ID IS NOT NULL ".$statement; 
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