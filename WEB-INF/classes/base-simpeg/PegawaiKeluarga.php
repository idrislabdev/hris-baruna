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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_KELUARGA.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiKeluarga extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiKeluarga()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_KELUARGA_ID", $this->getNextId("PEGAWAI_KELUARGA_ID","PPI_SIMPEG.PEGAWAI_KELUARGA"));

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_KELUARGA (
				   PEGAWAI_KELUARGA_ID, PENDIDIKAN_ID, PEGAWAI_ID, NAMA,NIK, JENIS_KELAMIN, TEMPAT_LAHIR, 
				   TANGGAL_LAHIR, PEKERJAAN, TANGGAL_WAFAT,
				   STATUS_KAWIN, STATUS_TUNJANGAN, STATUS_TANGGUNG, HUBUNGAN_KELUARGA_ID, LAST_CREATE_USER, LAST_CREATE_DATE 
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_KELUARGA_ID").",
				  '".$this->getField("PENDIDIKAN_ID")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("NIK")."',
				  '".$this->getField("JENIS_KELAMIN")."',
				  '".$this->getField("TEMPAT_LAHIR")."',
				  ".$this->getField("TANGGAL_LAHIR").",
				  '".$this->getField("PEKERJAAN")."',
				  ".$this->getField("TANGGAL_WAFAT").",
				  ".$this->getField("STATUS_KAWIN").",
				  ".$this->getField("STATUS_TUNJANGAN").",
				  ".$this->getField("STATUS_TANGGUNG").",
				  '".$this->getField("HUBUNGAN_KELUARGA_ID")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("PEGAWAI_KELUARGA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_KELUARGA
				SET    
					   PENDIDIKAN_ID        = '".$this->getField("PENDIDIKAN_ID")."',
					   NAMA    				= '".$this->getField("NAMA")."',
					   NIK    				= '".$this->getField("NIK")."',
					   JENIS_KELAMIN        = '".$this->getField("JENIS_KELAMIN")."',
					   TEMPAT_LAHIR			= '".$this->getField("TEMPAT_LAHIR")."',
					   TANGGAL_LAHIR		= ".$this->getField("TANGGAL_LAHIR").",
					   PEKERJAAN			= '".$this->getField("PEKERJAAN")."',
					   TANGGAL_WAFAT		= ".$this->getField("TANGGAL_WAFAT").",
					   STATUS_KAWIN			= ".$this->getField("STATUS_KAWIN").",
					   STATUS_TUNJANGAN		= ".$this->getField("STATUS_TUNJANGAN").",
					   STATUS_TANGGUNG		= ".$this->getField("STATUS_TANGGUNG").",
					   HUBUNGAN_KELUARGA_ID	= '".$this->getField("HUBUNGAN_KELUARGA_ID")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_KELUARGA_ID  = '".$this->getField("PEGAWAI_KELUARGA_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_KELUARGA
                WHERE 
                  PEGAWAI_KELUARGA_ID = ".$this->getField("PEGAWAI_KELUARGA_ID").""; 
				  
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
					PEGAWAI_KELUARGA_ID, A.PENDIDIKAN_ID, PEGAWAI_ID, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, TO_CHAR(TANGGAL_LAHIR, 'DD MONTH YYYY', 'NLS_DATE_LANGUAGE = INDONESIAN') AS TANGGAL_LAHIR_TEK, 
					TANGGAL_LAHIR, PEKERJAAN, TANGGAL_WAFAT, STATUS_KAWIN, STATUS_TUNJANGAN, STATUS_TANGGUNG, A.HUBUNGAN_KELUARGA_ID,
					B.NAMA PENDIDIKAN_NAMA, C.NAMA HUBUNGAN_KELUARGA_NAMA, A.NIK,
					PPI_SIMPEG.AMBIL_STATUS_CHEKLIST(STATUS_KAWIN) STATUS_KAWIN_NAMA, PPI_SIMPEG.AMBIL_STATUS_CHEKLIST(STATUS_TUNJANGAN) STATUS_TUNJANGAN_NAMA, PPI_SIMPEG.AMBIL_STATUS_CHEKLIST(STATUS_TANGGUNG) STATUS_TANGGUNG_NAMA
				FROM PPI_SIMPEG.PEGAWAI_KELUARGA A
				LEFT JOIN PPI_SIMPEG.PENDIDIKAN B ON A.PENDIDIKAN_ID=B.PENDIDIKAN_ID
				LEFT JOIN PPI_SIMPEG.HUBUNGAN_KELUARGA C ON A.HUBUNGAN_KELUARGA_ID=C.HUBUNGAN_KELUARGA_ID
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TANGGAL_LAHIR DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PEGAWAI_KELUARGA_ID, PENDIDIKAN_ID, PEGAWAI_ID, NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, NIK,
				TANGGAL_LAHIR, PEKERJAAN, TANGGAL_WAFAT, STATUS_KAWIN, STATUS_TUNJANGAN, STATUS_TANGGUNG, HUBUNGAN_KELUARGA_ID
				FROM PPI_SIMPEG.PEGAWAI_KELUARGA
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PENDIDIKAN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_KELUARGA_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_KELUARGA
		        WHERE PEGAWAI_KELUARGA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_KELUARGA_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_KELUARGA
		        WHERE PEGAWAI_KELUARGA_ID IS NOT NULL ".$statement; 
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