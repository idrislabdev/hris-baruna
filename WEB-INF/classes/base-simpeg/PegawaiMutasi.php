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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_JABATAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiMutasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiMutasi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_MUTASI_ID", $this->getNextId("PEGAWAI_MUTASI_ID","PPI_SIMPEG.PEGAWAI_MUTASI"));

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_MUTASI (
				   PEGAWAI_MUTASI_ID, PEJABAT_PENETAP_ID, PEGAWAI_ID, NO_SK, DEPARTEMEN_ID_LAMA, DEPARTEMEN_ID_BARU, 
				   TMT_SK, TANGGAL_SK, LAST_CREATE_USER, LAST_CREATE_DATE 
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_MUTASI_ID").",
				  '".$this->getField("PEJABAT_PENETAP_ID")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("NO_SK")."',
				  '".$this->getField("DEPARTEMEN_ID_LAMA")."',
				  '".$this->getField("DEPARTEMEN_ID_BARU")."',
				  ".$this->getField("TMT_SK").",
				  ".$this->getField("TANGGAL_SK").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("PEGAWAI_MUTASI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_JABATAN
				SET    
					   NAMA           		= (SELECT NAMA FROM PPI_SIMPEG.JABATAN WHERE JABATAN_ID = '".$this->getField("JABATAN_ID")."'),
					   PEGAWAI_ID      		= '".$this->getField("PEGAWAI_ID")."',
					   DEPARTEMEN_ID    	= '".$this->getField("DEPARTEMEN_ID")."',
					   CABANG_ID         	= '".$this->getField("CABANG_ID")."',
					   JABATAN_ID			= '".$this->getField("JABATAN_ID")."',
					   PEJABAT_PENETAP_ID	= '".$this->getField("PEJABAT_PENETAP_ID")."',
					   NO_SK				= '".$this->getField("NO_SK")."',
					   TANGGAL_SK			= ".$this->getField("TANGGAL_SK").",
					   TMT_JABATAN			= ".$this->getField("TMT_JABATAN").",
					   KETERANGAN			= '".$this->getField("KETERANGAN")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_JABATAN_ID   = '".$this->getField("PEGAWAI_JABATAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_JABATAN
                WHERE 
                  PEGAWAI_JABATAN_ID = ".$this->getField("PEGAWAI_JABATAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY TMT_SK DESC")
	{
		$str = "
				SELECT 
				   PEGAWAI_MUTASI_ID, PEGAWAI_ID, PEJABAT_PENETAP_ID, 
				   NO_SK, TMT_SK, TANGGAL_SK, 
				   DEPARTEMEN_ID_LAMA, DEPARTEMEN_ID_BARU
				FROM PPI_SIMPEG.PEGAWAI_MUTASI
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
				SELECT 
					PEGAWAI_JABATAN_ID, A.NAMA, PEGAWAI_ID, A.DEPARTEMEN_ID, A.CABANG_ID, A.JABATAN_ID, A.PEJABAT_PENETAP_ID,
					NO_SK, TANGGAL_SK, TMT_JABATAN, A.KETERANGAN,
					B.NAMA JABATAN_NAMA, C.NAMA CABANG_NAMA, D.NAMA DEPARTEMEN_NAMA, E.NAMA PEJABAT_PENETAP_NAMA
				FROM PPI_SIMPEG.PEGAWAI_JABATAN A
				LEFT JOIN PPI_SIMPEG.JABATAN B ON A.JABATAN_ID=B.JABATAN_ID
				LEFT JOIN PPI_SIMPEG.CABANG C ON A.CABANG_ID=C.CABANG_ID
				LEFT JOIN PPI_SIMPEG.DEPARTEMEN D ON A.DEPARTEMEN_ID=D.DEPARTEMEN_ID
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
		$str = "SELECT COUNT(PEGAWAI_JABATAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_JABATAN
		        WHERE PEGAWAI_JABATAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_JABATAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_JABATAN
		        WHERE PEGAWAI_JABATAN_ID IS NOT NULL ".$statement; 
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