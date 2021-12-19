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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiJamKerjaJenis extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiJamKerjaJenis()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_JAM_KERJA_JENIS_ID", $this->getNextId("PEGAWAI_JAM_KERJA_JENIS_ID","PPI_ABSENSI.PEGAWAI_JAM_KERJA_JENIS")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO PPI_ABSENSI.PEGAWAI_JAM_KERJA_JENIS (
				   PEGAWAI_JAM_KERJA_JENIS_ID, JAM_KERJA_JENIS_ID, PEGAWAI_ID
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_JAM_KERJA_JENIS_ID").",
				  '".$this->getField("JAM_KERJA_JENIS_ID")."',
				  '".$this->getField("PEGAWAI_ID")."'
				)"; 
		$this->id = $this->getField("PEGAWAI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_ABSENSI.PEGAWAI_JAM_KERJA_JENIS
                WHERE 
                  PEGAWAI_ID = ".$this->getField("PEGAWAI_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder='')
	{
		$str = "
				SELECT 
				D.KELAS, D.NAMA JABATAN_NAMA, A.PEGAWAI_ID, NRP, NIPP, A.NAMA,
                A.DEPARTEMEN_ID, B.NAMA DEPARTEMEN, CASE WHEN F.NAMA IS NULL THEN 'Normal' ELSE F.NAMA END JENIS_JAM_KERJA, F.WARNA
                FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_ABSENSI.PEGAWAI_JAM_KERJA_JENIS E ON A.PEGAWAI_ID = E.PEGAWAI_ID
                LEFT JOIN PPI_ABSENSI.JAM_KERJA_JENIS F ON E.JAM_KERJA_JENIS_ID = F.JAM_KERJA_JENIS_ID 
                WHERE 1 = 1
				"; 

		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				PEGAWAI_ID, NRP, NIPP, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, STATUS_KAWIN, GOLONGAN_DARAH, ALAMAT, TELEPON, EMAIL,
				A.DEPARTEMEN_ID, B.NAMA DEPARTEMEN
				FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN DEPARTEMEN B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY A.NAMA DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
	function getFotoByParams($id="")
	{
		$str = "SELECT FOTO AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI
		        WHERE PEGAWAI_ID IS NOT NULL AND PEGAWAI_ID = ".$id; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI A
		        WHERE PEGAWAI_ID IS NOT NULL ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI
		        WHERE PEGAWAI_ID IS NOT NULL ".$statement; 
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