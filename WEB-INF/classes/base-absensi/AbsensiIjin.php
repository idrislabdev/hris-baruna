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

  class AbsensiIjin extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AbsensiIjin()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ABSENSI_IJIN_ID", $this->getNextId("ABSENSI_IJIN_ID","PPI_ABSENSI.ABSENSI_IJIN")); 
		$str = "
				INSERT INTO PPI_ABSENSI.ABSENSI_IJIN (
				   ABSENSI_IJIN_ID, IJIN_ID, PEGAWAI_ID,
				   TANGGAL_AWAL, TANGGAL_AKHIR, KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE) 
				VALUES(
					  ".$this->getField("ABSENSI_IJIN_ID").",
					  '".$this->getField("IJIN_ID")."',
					  '".$this->getField("PEGAWAI_ID")."',
					  ".$this->getField("TANGGAL_AWAL").",
					  ".$this->getField("TANGGAL_AKHIR").",
					  '".$this->getField("KETERANGAN")."',
				  	  '".$this->getField("LAST_CREATE_USER")."',
				      ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("ABSENSI_IJIN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PPI_ABSENSI.ABSENSI_IJIN
			   SET IJIN_ID         	= ".$this->getField("IJIN_ID").",
				   PEGAWAI_ID		= '".$this->getField("PEGAWAI_ID")."',
				   TANGGAL_AWAL		= ".$this->getField("TANGGAL_AWAL").",
				   TANGGAL_AKHIR	= ".$this->getField("TANGGAL_AKHIR").",
				   KETERANGAN= '".$this->getField("KETERANGAN")."',
				   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
				   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
			 WHERE ABSENSI_IJIN_ID = ".$this->getField("ABSENSI_IJIN_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ABSENSI.ABSENSI_IJIN A SET
				  ".$this->getField("FIELD")." 		= '".$this->getField("FIELD_VALUE")."',
				  ".$this->getField("FIELD_VALIDATOR")." 	= '".$this->getField("FIELD_VALUE_VALIDATOR")."'
				WHERE ABSENSI_IJIN_ID = ".$this->getField("ABSENSI_IJIN_ID")."
				"; 
				$this->query = $str;
				//echo $str;
		return $this->execQuery($str);
    }		
	
	function delete()
	{
        $str = "DELETE FROM PPI_ABSENSI.ABSENSI_IJIN
                WHERE 
                  ABSENSI_IJIN_ID = ".$this->getField("ABSENSI_IJIN_ID").""; 
				  
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
				ABSENSI_IJIN_ID, IJIN_ID, PEGAWAI_ID, DEPARTEMEN_ID, 
				   TANGGAL_AWAL, TANGGAL_AKHIR, KETERANGAN
				FROM PPI_ABSENSI.ABSENSI_IJIN
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
	
    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY TANGGAL_AWAL DESC ")
	{
		$str = "
                SELECT A.ABSENSI_IJIN_ID ABSENSI_IJIN_ID, A.IJIN_ID IJIN_ID, A.PEGAWAI_ID PEGAWAI_ID, TO_CHAR(TANGGAL_AWAL,'DD-FMMM-YYYY') AS TANGGAL_AWAL, 
                    TO_CHAR(TANGGAL_AKHIR,'DD-FMMM-YYYY') AS TANGGAL_AKHIR,
                    B.NAMA JENIS_IJIN, C.NRP NRP, C.NAMA NAMA_PEGAWAI, C.DEPARTEMEN_ID DEPARTEMEN_ID, D.NAMA DEPARTEMEN, A.KETERANGAN
                        FROM PPI_ABSENSI.ABSENSI_IJIN A, PPI_ABSENSI.IJIN_KOREKSI B, PPI_SIMPEG.PEGAWAI C, PPI_SIMPEG.DEPARTEMEN D
                            WHERE     A.IJIN_ID = B.IJIN_KOREKSI_ID AND 
                                    A.PEGAWAI_ID = C.PEGAWAI_ID AND 
                                    C.DEPARTEMEN_ID = D.DEPARTEMEN_ID
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
    }	
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT 
				ABSENSI_IJIN_ID, IJIN_ID, PEGAWAI_ID, 
				   TANGGAL_AWAL, TANGGAL_AKHIR
				FROM PPI_ABSENSI.ABSENSI_IJIN
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY ABSENSI_IJIN_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM PPI_ABSENSI.ABSENSI_IJIN A, PPI_ABSENSI.IJIN_KOREKSI B, PPI_SIMPEG.PEGAWAI C, PPI_SIMPEG.DEPARTEMEN D
		WHERE     A.IJIN_ID = B.IJIN_KOREKSI_ID AND 
				A.PEGAWAI_ID = C.PEGAWAI_ID AND 
				C.DEPARTEMEN_ID = D.DEPARTEMEN_ID
									
		FROM PPI_ABSENSI.ABSENSI_IJIN WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(ABSENSI_IJIN_ID) AS ROWCOUNT FROM PPI_ABSENSI.ABSENSI_IJIN WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(ABSENSI_IJIN_ID) AS ROWCOUNT FROM PPI_ABSENSI.ABSENSI_IJIN WHERE 1 = 1 "; 
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