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

  class SuratPerintah extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SuratPerintah()
	{
      $this->Entity(); 
    }

	function insertTanpaKontrak()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURAT_PERINTAH_ID", $this->getNextId("SURAT_PERINTAH_ID","PPI_OPERASIONAL.SURAT_PERINTAH"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.SURAT_PERINTAH (
				   SURAT_PERINTAH_ID, NOMOR, PEKERJAAN, 
				   TANGGAL, LOKASI, STATUS, 
				   JENIS) 
				VALUES('".$this->getField("SURAT_PERINTAH_ID")."', '-', 'ROTASI AWAK KAPAL', SYSDATE, '-', 'U', 'ROTASI')

				"; 
		$this->id = $this->getField("SURAT_PERINTAH_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
		
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURAT_PERINTAH_ID", $this->getNextId("SURAT_PERINTAH_ID","PPI_OPERASIONAL.SURAT_PERINTAH"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.SURAT_PERINTAH (
				   SURAT_PERINTAH_ID, NOMOR, PEKERJAAN, 
				   TANGGAL, LOKASI, STATUS, 
				   JENIS) 
				SELECT '".$this->getField("SURAT_PERINTAH_ID")."', NOMOR, A.NAMA, SYSDATE, B.NAMA LOKASI, 'U', '".$this->getField("JENIS")."'  
				FROM PPI_OPERASIONAL.KONTRAK_SBPP A INNER JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID = B.LOKASI_ID WHERE KONTRAK_SBPP_ID = '".$this->getField("KONTRAK_SBPP_ID")."'

				"; 
		$this->id = $this->getField("SURAT_PERINTAH_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function insertKapalPekerjaan()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURAT_PERINTAH_ID", $this->getNextId("SURAT_PERINTAH_ID","PPI_OPERASIONAL.SURAT_PERINTAH"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.SURAT_PERINTAH (
				   SURAT_PERINTAH_ID, NOMOR, PEKERJAAN, 
				   TANGGAL, LOKASI, STATUS, 
				   JENIS) 
				SELECT '".$this->getField("SURAT_PERINTAH_ID")."', NO_KONTRAK, A.NAMA, SYSDATE, B.NAMA LOKASI, 'U', '".$this->getField("JENIS")."'  
				FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN A INNER JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID = B.LOKASI_ID WHERE KAPAL_PEKERJAAN_ID = '".$this->getField("KAPAL_PEKERJAAN_ID")."'

				"; 
		$this->id = $this->getField("SURAT_PERINTAH_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function insertKapalPenugasan()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURAT_PERINTAH_ID", $this->getNextId("SURAT_PERINTAH_ID","PPI_OPERASIONAL.SURAT_PERINTAH"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.SURAT_PERINTAH (
				   SURAT_PERINTAH_ID, NOMOR, PEKERJAAN, 
				   TANGGAL, LOKASI, STATUS, 
				   JENIS) 
				SELECT '".$this->getField("SURAT_PERINTAH_ID")."', NOMOR, A.NAMA, SYSDATE, B.NAMA LOKASI, 'U', '".$this->getField("JENIS")."'  
				FROM PPI_OPERASIONAL.PENUGASAN A INNER JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID = B.LOKASI_ID WHERE PENUGASAN_ID = '".$this->getField("PENUGASAN_ID")."'

				"; 
		$this->id = $this->getField("SURAT_PERINTAH_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function insertKapalKontrakTowing()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURAT_PERINTAH_ID", $this->getNextId("SURAT_PERINTAH_ID","PPI_OPERASIONAL.SURAT_PERINTAH"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.SURAT_PERINTAH (
				   SURAT_PERINTAH_ID, NOMOR, PEKERJAAN, 
				   TANGGAL, LOKASI, STATUS, 
				   JENIS) 
				SELECT '".$this->getField("SURAT_PERINTAH_ID")."', NOMOR, A.NAMA, SYSDATE, B.NAMA LOKASI, 'U', '".$this->getField("JENIS")."'  
				FROM PPI_OPERASIONAL.KONTRAK_TOWING A INNER JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID = B.LOKASI_ID WHERE KONTRAK_TOWING_ID = '".$this->getField("KONTRAK_TOWING_ID")."'

				"; 
		$this->id = $this->getField("SURAT_PERINTAH_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.SURAT_PERINTAH
				SET    
					   NOMOR_PENUGASAN  		= '".$this->getField("NOMOR_PENUGASAN")."',
					   STATUS  		= 'C'
				WHERE  SURAT_PERINTAH_ID  = '".$this->getField("SURAT_PERINTAH_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateStatus()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.SURAT_PERINTAH
				SET    
					   STATUS  		= '".$this->getField("STATUS")."'
				WHERE  SURAT_PERINTAH_ID  = '".$this->getField("SURAT_PERINTAH_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateKeteranganTolak()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.SURAT_PERINTAH
				SET    
					   KETERANGAN_TOLAK  		= '".$this->getField("KETERANGAN_TOLAK")."',
					   STATUS = 'U'
				WHERE  SURAT_PERINTAH_ID  = '".$this->getField("SURAT_PERINTAH_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
		
	function updateData()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.SURAT_PERINTAH
				SET    
					   NOMOR		  	= '".$this->getField("NOMOR")."',
					   PEKERJAAN 		= '".$this->getField("PEKERJAAN")."',
					   NOMOR_PENUGASAN 	= '".$this->getField("NOMOR_PENUGASAN")."',
					   LOKASI  			= '".$this->getField("LOKASI")."',
					   TANGGAL  		= ".$this->getField("TANGGAL").",
					   STATUS			= '".$this->getField("STATUS")."'
				WHERE  SURAT_PERINTAH_ID  = '".$this->getField("SURAT_PERINTAH_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.SURAT_PERINTAH
                WHERE 
                  SURAT_PERINTAH_ID = ".$this->getField("SURAT_PERINTAH_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY TANGGAL DESC")
	{
		$str = "
				SELECT 
					SURAT_PERINTAH_ID, NOMOR, NOMOR_PENUGASAN, PEKERJAAN, TANGGAL, LOKASI, CASE WHEN STATUS = 'U' THEN 'Usulan' WHEN STATUS = 'S' THEN 'Setujui' WHEN STATUS = 'A' THEN 'Approve' ELSE 'Cetak SK' END STATUS, JENIS,
					STATUS STATUS_ALIAS, KETERANGAN_TOLAK
					FROM PPI_OPERASIONAL.SURAT_PERINTAH
					WHERE SURAT_PERINTAH_ID IS NOT NULL
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
				  SELECT SURAT_PERINTAH_ID, KAPAL_ID, KETERANGAN, NOMOR, NOMOR_PENUGASAN, NAMA
				  FROM PPI_OPERASIONAL.SURAT_PERINTAH					
				  WHERE SURAT_PERINTAH_ID IS NOT NULL
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
		$str = "SELECT COUNT(SURAT_PERINTAH_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.SURAT_PERINTAH
		        WHERE SURAT_PERINTAH_ID IS NOT NULL ".$statement; 
		
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
		$str = "  SELECT COUNT(A.SURAT_PERINTAH_ID) ROWCOUNT FROM PPI_OPERASIONAL.SURAT_PERINTAH A
                  LEFT JOIN PPI_OPERASIONAL.LOKASI B ON A.KETERANGAN=B.KETERANGAN
                  LEFT JOIN PPI_OPERASIONAL.KAPAL C ON C.KAPAL_ID=A.KAPAL_ID
                  WHERE SURAT_PERINTAH_ID IS NOT NULL AND EXISTS(SELECT 1 FROM PPI_GAJI.PREMI_SURAT_PERINTAH X WHERE X.SURAT_PERINTAH_ID = A.SURAT_PERINTAH_ID) ".$statement; 
		
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
		$str = "SELECT COUNT(SURAT_PERINTAH_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.SURAT_PERINTAH
		        WHERE SURAT_PERINTAH_ID IS NOT NULL ".$statement; 
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