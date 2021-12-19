<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Lembur extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Lembur()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("LEMBUR_ID", $this->getNextId("LEMBUR_ID","PPI_ABSENSI.LEMBUR")); 
		$str = "
				INSERT INTO PPI_ABSENSI.LEMBUR (
				   LEMBUR_ID, PEGAWAI_ID, NAMA, 
				   KETERANGAN, JAM_AWAL, JAM_AKHIR, 
				   DEPARTEMEN_ID, LAST_CREATE_USER, LAST_CREATE_DATE)  
				VALUES(
					  ".$this->getField("LEMBUR_ID").",
					  '".$this->getField("PEGAWAI_ID")."',
					  '".$this->getField("NAMA")."',
					  '".$this->getField("KETERANGAN")."',
					  ".$this->getField("JAM_AWAL").",
					  ".$this->getField("JAM_AKHIR").",
					  '".$this->getField("DEPARTEMEN_ID")."',
				  	  '".$this->getField("LAST_CREATE_USER")."',
				      ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("ABSENSI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PPI_ABSENSI.LEMBUR
			   SET PEGAWAI_ID   	= '".$this->getField("PEGAWAI_ID")."',
				   NAMA				= '".$this->getField("NAMA")."',
				   KETERANGAN		= '".$this->getField("KETERANGAN")."',
				   JAM_AWAL			= ".$this->getField("JAM_AWAL").",
				   JAM_AKHIR		= ".$this->getField("JAM_AKHIR").",
				   DEPARTEMEN_ID	= '".$this->getField("DEPARTEMEN_ID")."',
				   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
				   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
			 WHERE LEMBUR_ID = ".$this->getField("LEMBUR_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_ABSENSI.LEMBUR
                WHERE 
                  LEMBUR_ID = ".$this->getField("LEMBUR_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				LEMBUR_ID, PEGAWAI_ID, NAMA, 
				   KETERANGAN, JAM_AWAL, JAM_AKHIR, 
				   DEPARTEMEN_ID
				FROM PPI_ABSENSI.LEMBUR
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
	
    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
		SELECT A.LEMBUR_ID LEMBUR_ID, A.PEGAWAI_ID PEGAWAI_ID, A.NAMA LEMBUR, A.KETERANGAN, TO_CHAR(JAM_AWAL, 'DD-MM-YYYY HH24:MI') AS JAM_AWAL, TO_CHAR(JAM_AKHIR, 'DD-MM-YYYY HH24:MI') AS JAM_AKHIR, 
		TO_CHAR(JAM_AWAL, 'HH24:MI') AS JAM_AWAL_EDIT, TO_CHAR(JAM_AKHIR, 'HH24:MI') AS JAM_AKHIR_EDIT,
		TO_CHAR(JAM_AWAL, 'DD-MM-YYYY') AS TANGGAL_AWAL_EDIT, TO_CHAR(JAM_AKHIR, 'DD-MM-YYYY') AS TANGGAL_AKHIR_EDIT,
		A.DEPARTEMEN_ID DEPARTEMEN_ID, B.NRP NRP, B.NAMA NAMA_PEGAWAI, C.NAMA DEPARTEMEN 
			FROM PPI_ABSENSI.LEMBUR A, PPI_SIMPEG.PEGAWAI B, PPI_SIMPEG.DEPARTEMEN C
			WHERE A.PEGAWAI_ID = B.PEGAWAI_ID AND B.DEPARTEMEN_ID = C.DEPARTEMEN_ID
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
				LEMBUR_ID, PEGAWAI_ID, NAMA, 
				   KETERANGAN, JAM_AWAL, JAM_AKHIR, 
				   DEPARTEMEN_ID
				FROM PPI_ABSENSI.LEMBUR
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY LEMBUR_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(LEMBUR_ID) AS ROWCOUNT FROM PPI_ABSENSI.LEMBUR WHERE 1 = 1 ".$statement; 
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

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(LEMBUR_ID) AS ROWCOUNT FROM PPI_ABSENSI.LEMBUR WHERE 1 = 1 "; 
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