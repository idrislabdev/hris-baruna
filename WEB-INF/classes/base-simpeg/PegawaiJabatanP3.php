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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_JABATAN_P3.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiJabatanP3 extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiJabatanP3()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_JABATAN_P3_ID", $this->getNextId("PEGAWAI_JABATAN_P3_ID","PPI_SIMPEG.PEGAWAI_JABATAN_P3"));

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_JABATAN_P3 (
				   PEGAWAI_JABATAN_P3_ID, NAMA, PEGAWAI_ID, DIREKTORAT_P3_ID, CABANG_P3_ID, JABATAN_ID, 
				   PEJABAT_PENETAP_ID, NO_SK, TANGGAL_SK, 
   				   TMT_JABATAN, KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE 
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_JABATAN_P3_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("DIREKTORAT_P3_ID")."',
				  '".$this->getField("CABANG_P3_ID")."',
				  '".$this->getField("JABATAN_ID")."',
				  '".$this->getField("PEJABAT_PENETAP_ID")."',
				  '".$this->getField("NO_SK")."',
				  ".$this->getField("TANGGAL_SK").",
				  ".$this->getField("TMT_JABATAN").",
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("PEGAWAI_JABATAN_P3_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_JABATAN_P3
				SET    
					   NAMA           			= '".$this->getField("NAMA")."',
					   DIREKTORAT_P3_ID    		= '".$this->getField("DIREKTORAT_P3_ID")."',
					   CABANG_P3_ID         	= '".$this->getField("CABANG_P3_ID")."',
					   JABATAN_ID				= '".$this->getField("JABATAN_ID")."',
					   PEJABAT_PENETAP_ID		= '".$this->getField("PEJABAT_PENETAP_ID")."',
					   NO_SK					= '".$this->getField("NO_SK")."',
					   TANGGAL_SK				= ".$this->getField("TANGGAL_SK").",
					   TMT_JABATAN				= ".$this->getField("TMT_JABATAN").",
					   KETERANGAN				= '".$this->getField("KETERANGAN")."',
					   LAST_UPDATE_USER			= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE			= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_JABATAN_P3_ID	= '".$this->getField("PEGAWAI_JABATAN_P3_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_JABATAN_P3
                WHERE 
                  PEGAWAI_JABATAN_P3_ID = ".$this->getField("PEGAWAI_JABATAN_P3_ID").""; 
				  
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
					PEGAWAI_JABATAN_P3_ID, A.NAMA, PEGAWAI_ID, A.DIREKTORAT_P3_ID, A.CABANG_P3_ID, A.JABATAN_ID, A.PEJABAT_PENETAP_ID,
					NO_SK, TANGGAL_SK, TMT_JABATAN, A.KETERANGAN,
					B.NAMA JABATAN_NAMA, C.NAMA CABANG_NAMA, D.NAMA DEPARTEMEN_NAMA, E.NAMA PEJABAT_PENETAP_NAMA, B.NO_URUT, B.KELAS,
					C.KODE CABANG_P3_KODE
				FROM PPI_SIMPEG.PEGAWAI_JABATAN_P3 A
				LEFT JOIN PPI_SIMPEG.JABATAN B ON A.JABATAN_ID=B.JABATAN_ID
				LEFT JOIN PPI_SIMPEG.CABANG_P3 C ON A.CABANG_P3_ID=C.CABANG_P3_ID
				LEFT JOIN PPI_SIMPEG.DIREKTORAT_P3 D ON A.DIREKTORAT_P3_ID=D.DIREKTORAT_P3_ID
				LEFT JOIN PPI_SIMPEG.PEJABAT_PENETAP E ON A.PEJABAT_PENETAP_ID=E.PEJABAT_PENETAP_ID
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TMT_JABATAN DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
					PEGAWAI_JABATAN_P3_ID, A.NAMA, PEGAWAI_ID, A.DIREKTORAT_P3_ID, A.CABANG_P3_ID, A.JABATAN_ID, A.PEJABAT_PENETAP_ID,
					NO_SK, TANGGAL_SK, TMT_JABATAN, A.KETERANGAN,
					B.NAMA JABATAN_NAMA, C.NAMA CABANG_NAMA, D.NAMA DEPARTEMEN_NAMA, E.NAMA PEJABAT_PENETAP_NAMA
				FROM PPI_SIMPEG.PEGAWAI_JABATAN_P3 A
				LEFT JOIN PPI_SIMPEG.JABATAN B ON A.JABATAN_ID=B.JABATAN_ID
				LEFT JOIN PPI_SIMPEG.CABANG C ON A.CABANG_P3_ID=C.CABANG_P3_ID
				LEFT JOIN PPI_SIMPEG.DEPARTEMEN D ON A.DIREKTORAT_P3_ID=D.DIREKTORAT_P3_ID
				LEFT JOIN PPI_SIMPEG.PEJABAT_PENETAP E ON A.PEJABAT_PENETAP_ID=E.PEJABAT_PENETAP_ID
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY TANGGAL_SK DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_JABATAN_P3_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_JABATAN_P3
		        WHERE PEGAWAI_JABATAN_P3_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_JABATAN_P3_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_JABATAN_P3
		        WHERE PEGAWAI_JABATAN_P3_ID IS NOT NULL ".$statement; 
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