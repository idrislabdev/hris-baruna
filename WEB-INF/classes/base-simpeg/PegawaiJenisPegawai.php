<? 
/* *******************************************************************************************************
MODUL NAME 			: PEL
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_JENIS_PEGAWAI.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiJenisPegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiJenisPegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_JENIS_PEGAWAI_ID", $this->getNextId("PEGAWAI_JENIS_PEGAWAI_ID","PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI"));

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI (
				   PEGAWAI_JENIS_PEGAWAI_ID, JENIS_PEGAWAI_ID, PEGAWAI_ID, JENIS_PEGAWAI_PERUBAH_KODE_ID, TMT_JENIS_PEGAWAI, KETERANGAN,
				   MPP, ASAL_PERUSAHAAN, TMT_MPP, NO_SK_MPP, LAST_CREATE_USER, LAST_CREATE_DATE, TANGGAL_KONTRAK_AWAL, TANGGAL_KONTRAK_AKHIR, DOKUMEN_ID, JUMLAH_SPP, DEPARTEMEN_KELAS_ID, STATUS_CALPEG
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_JENIS_PEGAWAI_ID").",
				  '".$this->getField("JENIS_PEGAWAI_ID")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("JENIS_PEGAWAI_PERUBAH_KODE_ID")."',
				  ".$this->getField("TMT_JENIS_PEGAWAI").",
				  '".$this->getField("KETERANGAN")."',
				  ".$this->getField("MPP").",
				  '".$this->getField("ASAL_PERUSAHAAN")."',
				  ".$this->getField("TMT_MPP").",
				  ".$this->getField("NO_SK_MPP").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  ".$this->getField("TANGGAL_KONTRAK_AWAL").",
				  ".$this->getField("TANGGAL_KONTRAK_AKHIR").",
				  '".$this->getField("DOKUMEN_ID")."',
				  '".$this->getField("JUMLAH_SPP")."',
				  '".$this->getField("DEPARTEMEN_KELAS_ID")."',
				  '".$this->getField("STATUS_CALPEG")."'
				)"; 
		$this->id = $this->getField("PEGAWAI_JENIS_PEGAWAI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function insertKadet()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_JENIS_PEGAWAI_ID", $this->getNextId("PEGAWAI_JENIS_PEGAWAI_ID","PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI"));

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI (
				   PEGAWAI_JENIS_PEGAWAI_ID, JENIS_PEGAWAI_ID, PEGAWAI_ID, TMT_JENIS_PEGAWAI, 
				   KELAS_SEKOLAH, JURUSAN, LAST_CREATE_USER, LAST_CREATE_DATE , JUMLAH_SPP,
				   DEPARTEMEN_KELAS_ID
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_JENIS_PEGAWAI_ID").",
				  '8',
				  '".$this->getField("PEGAWAI_ID")."',
				  ".$this->getField("TMT_JENIS_PEGAWAI").",
				  '".$this->getField("KELAS_SEKOLAH")."',
				  '".$this->getField("JURUSAN")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("JUMLAH_SPP")."',
				  '".$this->getField("DEPARTEMEN_KELAS_ID")."'
				)"; 
		$this->id = $this->getField("PEGAWAI_JENIS_PEGAWAI_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }


    function importKadet()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_JENIS_PEGAWAI_ID", $this->getNextId("PEGAWAI_JENIS_PEGAWAI_ID","PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI"));

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI (
				   PEGAWAI_JENIS_PEGAWAI_ID, JENIS_PEGAWAI_ID, PEGAWAI_ID, TMT_JENIS_PEGAWAI, 
				   KELAS_SEKOLAH, JURUSAN, JUMLAH_SPP, DEPARTEMEN_KELAS_ID
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_JENIS_PEGAWAI_ID").",
				  '8',
				  '".$this->getField("PEGAWAI_ID")."',
				  ".$this->getField("TMT_JENIS_PEGAWAI").",
				  '".$this->getField("KELAS_SEKOLAH")."',
				  '".$this->getField("JURUSAN")."',
				  '".$this->getField("JUMLAH_SPP")."',
				  '".$this->getField("DEPARTEMEN_KELAS_ID")."'
				)"; 
		$this->id = $this->getField("PEGAWAI_JENIS_PEGAWAI_ID");
		$this->query = $str;
		// echo $str;exit();
		
		return $this->execQuery($str);
    }



	function deleteKadet()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI
                WHERE 
                  PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }


	function insertNonPegawai()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_JENIS_PEGAWAI_ID", $this->getNextId("PEGAWAI_JENIS_PEGAWAI_ID","PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI"));

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI (
				   PEGAWAI_JENIS_PEGAWAI_ID, JENIS_PEGAWAI_ID, PEGAWAI_ID, TMT_JENIS_PEGAWAI, LAST_CREATE_USER, LAST_CREATE_DATE 
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_JENIS_PEGAWAI_ID").",
				  '".$this->getField("JENIS_PEGAWAI_ID")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  ".$this->getField("TMT_JENIS_PEGAWAI").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("PEGAWAI_JENIS_PEGAWAI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
		
    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI
				SET    
					   TANGGAL_KONTRAK_AWAL				= ".$this->getField("TANGGAL_KONTRAK_AWAL").",
					   TANGGAL_KONTRAK_AKHIR			= ".$this->getField("TANGGAL_KONTRAK_AKHIR").",
					   JENIS_PEGAWAI_ID           		= '".$this->getField("JENIS_PEGAWAI_ID")."',
					   JENIS_PEGAWAI_PERUBAH_KODE_ID	= '".$this->getField("JENIS_PEGAWAI_PERUBAH_KODE_ID")."',
					   TMT_JENIS_PEGAWAI         		= ".$this->getField("TMT_JENIS_PEGAWAI").",
					   KETERANGAN						= '".$this->getField("KETERANGAN")."',
					   MPP								= ".$this->getField("MPP").",
					   ASAL_PERUSAHAAN					= '".$this->getField("ASAL_PERUSAHAAN")."',
					   TMT_MPP							= ".$this->getField("TMT_MPP").",
					   NO_SK_MPP						= ".$this->getField("NO_SK_MPP").",
					   LAST_UPDATE_USER					= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE					= ".$this->getField("LAST_UPDATE_DATE").",
					   DOKUMEN_ID						= '".$this->getField("DOKUMEN_ID")."',
					   STATUS_CALPEG					= '".$this->getField("STATUS_CALPEG")."'
				WHERE  PEGAWAI_JENIS_PEGAWAI_ID     	= '".$this->getField("PEGAWAI_JENIS_PEGAWAI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateKontrak()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI
				SET    
					   TANGGAL_KONTRAK_AWAL				= ".$this->getField("TANGGAL_KONTRAK_AWAL").",
					   TANGGAL_KONTRAK_AKHIR			= ".$this->getField("TANGGAL_KONTRAK_AKHIR").",
					   KETERANGAN						= '".$this->getField("KETERANGAN")."',
					   LAST_UPDATE_USER					= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE					= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_JENIS_PEGAWAI_ID     	= '".$this->getField("PEGAWAI_JENIS_PEGAWAI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }	
	
	function updateKadet()
	{ 
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI
				SET    
   KELAS_SEKOLAH					= '".$this->getField("KELAS_SEKOLAH")."',
   JURUSAN							= '".$this->getField("JURUSAN")."',
   TMT_JENIS_PEGAWAI         		= ".$this->getField("TMT_JENIS_PEGAWAI").",
		JUMLAH_SPP 						= '".$this->getField("JUMLAH_SPP")."',
		DEPARTEMEN_KELAS_ID 		= '".$this->getField("DEPARTEMEN_KELAS_ID")."'
				WHERE  PEGAWAI_JENIS_PEGAWAI_ID     	= '".$this->getField("PEGAWAI_JENIS_PEGAWAI_ID")."'

			 "; 
		//echo $str;
		return $this->execQuery($str);
    }

	function updateNonPegawai()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI
				SET    
					   TMT_JENIS_PEGAWAI         		= ".$this->getField("TMT_JENIS_PEGAWAI").",
					   JENIS_PEGAWAI_ID					= '".$this->getField("JENIS_PEGAWAI_ID")."'
				WHERE  PEGAWAI_JENIS_PEGAWAI_ID     	= '".$this->getField("PEGAWAI_JENIS_PEGAWAI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI
                WHERE 
                  PEGAWAI_JENIS_PEGAWAI_ID = ".$this->getField("PEGAWAI_JENIS_PEGAWAI_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
					PEGAWAI_JENIS_PEGAWAI_ID, A.JENIS_PEGAWAI_ID, PEGAWAI_ID, A.JENIS_PEGAWAI_PERUBAH_KODE_ID, TMT_JENIS_PEGAWAI, A.KETERANGAN,
					B.NAMA JENIS_PEGAWAI_NAMA, C.NAMA JENIS_PEGAWAI_PERUBAH_KODE_NM,
					MPP, ASAL_PERUSAHAAN, TMT_MPP, NO_SK_MPP, TANGGAL_KONTRAK_AWAL, TANGGAL_KONTRAK_AKHIR, DOKUMEN_ID, JUMLAH_SPP, DEPARTEMEN_KELAS_ID,
					STATUS_CALPEG, DECODE(STATUS_CALPEG, 'Y', 'Ya', 'T', 'Tidak') STATUS_CALPEG_DESC
				FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI A
				LEFT JOIN PPI_SIMPEG.JENIS_PEGAWAI B ON A.JENIS_PEGAWAI_ID=B.JENIS_PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.JENIS_PEGAWAI_PERUBAHAN_KODE C ON A.JENIS_PEGAWAI_PERUBAH_KODE_ID=C.JENIS_PEGAWAI_PERUBAH_KODE_ID
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TMT_JENIS_PEGAWAI DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsTerakhir($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
					A.JENIS_PEGAWAI_ID
				FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI A
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	
	function selectByParamsKadetRiwayat($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY TMT_JENIS_PEGAWAI ASC")
	{
		$str = "
				SELECT 
				PEGAWAI_JENIS_PEGAWAI_ID, TMT_JENIS_PEGAWAI, TANGGAL_KONTRAK_AWAL, TANGGAL_KONTRAK_AKHIR, ASAL_SEKOLAH, KELAS_SEKOLAH, JURUSAN, PEGAWAI_ID, JUMLAH_SPP, DEPARTEMEN_KELAS_ID, STATUS_CALPEG
				FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsKadet($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY TMT_JENIS_PEGAWAI ASC")
	{
		$str = "
				SELECT 
				PEGAWAI_JENIS_PEGAWAI_ID, TMT_JENIS_PEGAWAI, TANGGAL_KONTRAK_AWAL, TANGGAL_KONTRAK_AKHIR, ASAL_SEKOLAH, KELAS_SEKOLAH, JURUSAN, STATUS_CALPEG
				FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
  	
	function selectByParamsPegawaiJenisPegawaiTerakhir($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT * FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	  
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PEGAWAI_JENIS_PEGAWAI_ID, JENIS_PEGAWAI_ID, PEGAWAI_ID, JENIS_PEGAWAI_PERUBAH_KODE_ID, TMT_JENIS_PEGAWAI, KETERANGAN, JUMLAH_SPP, STATUS_CALPEG
				FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY JENIS_PEGAWAI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_JENIS_PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI
		        WHERE PEGAWAI_JENIS_PEGAWAI_ID IS NOT NULL ".$statement; 
		
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

    function getIdByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT (PEGAWAI_JENIS_PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI
		        WHERE PEGAWAI_JENIS_PEGAWAI_ID IS NOT NULL ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return (int)$this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }


    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_JENIS_PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI
		        WHERE PEGAWAI_JENIS_PEGAWAI_ID IS NOT NULL ".$statement; 
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