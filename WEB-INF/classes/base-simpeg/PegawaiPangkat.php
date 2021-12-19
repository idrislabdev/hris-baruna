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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_PANGKAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiPangkat extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiPangkat()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_PANGKAT_ID", $this->getNextId("PEGAWAI_PANGKAT_ID","PPI_SIMPEG.PEGAWAI_PANGKAT"));
	
		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_PANGKAT (
				   PEGAWAI_PANGKAT_ID, PANGKAT_ID, PEGAWAI_ID, PEJABAT_PENETAP_ID, NO_SK, TANGGAL_SK, 
				   GAJI_POKOK, MASA_KERJA_TAHUN, MASA_KERJA_BULAN,
				   KETERANGAN, PANGKAT_KODE_ID, PANGKAT_PERUBAHAN_KODE_ID, JABATAN_ID, TMT_PANGKAT, LAST_CREATE_USER, LAST_CREATE_DATE 
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_PANGKAT_ID").",
				  '".$this->getField("PANGKAT_ID")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("PEJABAT_PENETAP_ID")."',
				  '".$this->getField("NO_SK")."',
				  ".$this->getField("TANGGAL_SK").",
				  '".$this->getField("GAJI_POKOK")."',
				  '".$this->getField("MASA_KERJA_TAHUN")."',
				  '".$this->getField("MASA_KERJA_BULAN")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("PANGKAT_KODE_ID")."',
				  '".$this->getField("PANGKAT_PERUBAHAN_KODE_ID")."',
				  '".$this->getField("JABATAN_ID")."',
				  ".$this->getField("TMT_PANGKAT").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("PEGAWAI_PANGKAT_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_PANGKAT
				SET    
					   PANGKAT_ID           		= '".$this->getField("PANGKAT_ID")."',
					   PEJABAT_PENETAP_ID    		= '".$this->getField("PEJABAT_PENETAP_ID")."',
					   NO_SK         				= '".$this->getField("NO_SK")."',
					   TANGGAL_SK					= ".$this->getField("TANGGAL_SK").",
					   GAJI_POKOK					= '".$this->getField("GAJI_POKOK")."',
					   MASA_KERJA_TAHUN				= '".$this->getField("MASA_KERJA_TAHUN")."',
					   MASA_KERJA_BULAN				= '".$this->getField("MASA_KERJA_BULAN")."',
					   KETERANGAN					= '".$this->getField("KETERANGAN")."',
					   PANGKAT_KODE_ID				= '".$this->getField("PANGKAT_KODE_ID")."',
					   PANGKAT_PERUBAHAN_KODE_ID	= '".$this->getField("PANGKAT_PERUBAHAN_KODE_ID")."',
					   JABATAN_ID					= '".$this->getField("JABATAN_ID")."',
					   TMT_PANGKAT					= ".$this->getField("TMT_PANGKAT").",
					   LAST_UPDATE_USER				= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE				= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_PANGKAT_ID     		= '".$this->getField("PEGAWAI_PANGKAT_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_PANGKAT
                WHERE 
                  PEGAWAI_PANGKAT_ID = ".$this->getField("PEGAWAI_PANGKAT_ID").""; 
				  
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
					PEGAWAI_PANGKAT_ID, A.PANGKAT_ID, PEGAWAI_ID, A.PEJABAT_PENETAP_ID, NO_SK, TANGGAL_SK,
					GAJI_POKOK, MASA_KERJA_TAHUN, MASA_KERJA_BULAN, A.KETERANGAN,
					A.PANGKAT_KODE_ID, A.PANGKAT_PERUBAHAN_KODE_ID, A.JABATAN_ID, TMT_PANGKAT,
					B.NAMA PANGKAT_NAMA, B.KETERANGAN PANGKAT_KETERANGAN, C.NAMA PEJABAT_PENETAP_NAMA, D.NAMA PANGKAT_KODE_NAMA, E.NAMA PANGKAT_PERUBAHAN_KODE_NAMA, F.NAMA JABATAN_NAMA, F.KELAS
				FROM PPI_SIMPEG.PEGAWAI_PANGKAT A
				LEFT JOIN PPI_SIMPEG.PANGKAT B ON A.PANGKAT_ID=B.PANGKAT_ID
				LEFT JOIN PPI_SIMPEG.PEJABAT_PENETAP C ON A.PEJABAT_PENETAP_ID=C.PEJABAT_PENETAP_ID
				LEFT JOIN PPI_SIMPEG.PANGKAT_KODE D ON A.PANGKAT_KODE_ID=D.PANGKAT_KODE_ID
				LEFT JOIN PPI_SIMPEG.PANGKAT_PERUBAHAN_KODE E ON A.PANGKAT_PERUBAHAN_KODE_ID=E.PANGKAT_PERUBAHAN_KODE_ID
				LEFT JOIN PPI_SIMPEG.JABATAN F ON A.JABATAN_ID=F.JABATAN_ID
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TMT_PANGKAT DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PEGAWAI_PANGKAT_ID, PANGKAT_ID, PEGAWAI_ID, PEJABAT_PENETAP_ID, NO_SK, TANGGAL_SK,
				GAJI_POKOK, MASA_KERJA_TAHUN, MASA_KERJA_BULAN, KETERANGAN,
				PANGKAT_KODE_ID, PANGKAT_PERUBAHAN_KODE_ID, JABATAN_ID, TMT_PANGKAT
				FROM PPI_SIMPEG.PEGAWAI_PANGKAT
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PANGKAT_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_PANGKAT_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_PANGKAT
		        WHERE PEGAWAI_PANGKAT_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_PANGKAT_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_PANGKAT
		        WHERE PEGAWAI_PANGKAT_ID IS NOT NULL ".$statement; 
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