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
  * Entity-base class untuk mengimplementasikan tabel KAPAL_JENIS.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class DaftarJagaPiket extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function DaftarJagaPiket()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PIKET_ID", $this->getNextId("PIKET_ID","PPI_ABSENSI.ABSENSI_JADWAL_PIKET"));

		$str = "
				INSERT INTO PPI_ABSENSI.ABSENSI_JADWAL_PIKET (
				   PIKET_ID, DEPARTEMEN_ID, PEGAWAI_ID, TANGGAL, SHIFT, LAST_CREATE_USER, LAST_CREATE_DATE)  
 			  	VALUES (
				  ".$this->getField("PIKET_ID").",
				  ".$this->getField("DEPARTEMEN_ID").",
				  ".$this->getField("PEGAWAI_ID").",
				  TO_DATE('".$this->getField("TANGGAL")."', 'DD-MM-YYYY'),
				  '".$this->getField("SHIFT")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id=$this->getField("PIKET_ID");
		$this->query = $str;
		//return $str;
		return $this->execQuery($str);
    }

	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }

    function update()
	{
		$str = "
				UPDATE PPI_ABSENSI.KRU_JADWAL_PIKET
				SET    
					   DEPARTEMEN_ID         	= ".$this->getField("DEPARTEMEN_ID").",
					   PEGAWAI_ID         		= ".$this->getField("PEGAWAI_ID").",
					   TANGGAL   = TO_DATE('".$this->getField("TANGGAL")."', 'DD-MM-YYYY'),
					   SHIFT      = '".$this->getField("SHIFT")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PIKET_ID  		= ".$this->getField("PIKET_ID")."

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_ABSENSI.ABSENSI_JADWAL_PIKET
                WHERE 
                  DEPARTEMEN_ID = ".$this->getField("DEPARTEMEN_ID")."
				  AND TO_CHAR(TANGGAL, 'MM-YYYY') = '".$this->getField("PERIODE")."' "; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NAMA ASC")
	{
		$str = "
                SELECT A.PIKET_ID, A.PEGAWAI_ID, A.DEPARTEMEN_ID, C.NAMA DEPARTEMEN, B.NAMA PEGAWAI, TANGGAL, TO_CHAR(A.TANGGAL, 'fmDD') TGL, SHIFT
                FROM PPI_ABSENSI.ABSENSI_JADWAL_PIKET A 
                LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                WHERE 0=0
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
    function selectByParamsWithTanggal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NAMA ASC")
	{
		$str = "
                SELECT A.PIKET_ID, A.PEGAWAI_ID, A.DEPARTEMEN_ID, C.NAMA DEPARTEMEN, B.NAMA PEGAWAI, 
                TANGGAL, TO_CHAR(A.TANGGAL, 'fmDD') TGL, SHIFT,
                TO_CHAR(A.TANGGAL, 'DDMMYYYY') AS TANGGAL_BANDING 
                FROM PPI_ABSENSI.ABSENSI_JADWAL_PIKET A 
                LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                WHERE 0=0
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	   function selectByParamsHeader($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NAMA ASC")
		{
			$str = "
					SELECT DISTINCT A.DEPARTEMEN_ID, B.NAMA NAMA, TO_CHAR(A.TANGGAL, 'MMYYYY') PERIODE 
					FROM PPI_ABSENSI.ABSENSI_JADWAL_PIKET A, PPI_SIMPEG.DEPARTEMEN B
					WHERE A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
					"; 
			
			while(list($key,$val) = each($paramsArray))
			{
				$str .= " AND $key = '$val' ";
			}
			
			$str .= $statement." GROUP BY A.DEPARTEMEN_ID, B.NAMA, TO_CHAR(A.TANGGAL, 'MMYYYY') ".$order;
			$this->query = $str;
			return $this->selectLimit($str,$limit,$from); 
		}
		
	function selectDaftarJaga($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY B.NAMA ASC")
	{
		$str = "
                SELECT DISTINCT A.PEGAWAI_ID, A.DEPARTEMEN_ID, B.NAMA PEGAWAI, UPPER(C.NAMA) DEPARTEMEN 
				FROM PPI_ABSENSI.ABSENSI_JADWAL_PIKET A 
					LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID 
					LEFT JOIN PPI_SIMPEG.DEPARTEMEN C ON A.DEPARTEMEN_ID = C.DEPARTEMEN_ID 
				WHERE 0=0 				
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.PEGAWAI_ID, A.DEPARTEMEN_ID, B.NAMA, C.NAMA ".$order;
		$this->query = $str;
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
			
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	
				SELECT PIKET_ID, DEPARTEMEN_ID, PEGAWAI_ID, TANGGAL, SHIFT, A.LOKASI_ID
                FROM PPI_ABSENSI.KRU_JADWAL_PIKET A INNER JOIN PPI_ABSENSI.LOKASI B 
                ON A.LOKASI_ID = B.LOKASI_ID
                WHERE 0=0

			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PIKET_ID) AS ROWCOUNT FROM PPI_ABSENSI.ABSENSI_JADWAL_PIKET
		        WHERE 0=0 ".$statement; 
		
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
	
	 function getCountByParamsHeader($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(DISTINCT A.DEPARTEMEN_ID) AS ROWCOUNT
					FROM PPI_ABSENSI.ABSENSI_JADWAL_PIKET A, PPI_SIMPEG.DEPARTEMEN B
					WHERE A.DEPARTEMEN_ID = B.DEPARTEMEN_ID ";
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement; 
		$this->select($str); 

		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PIKET_ID) AS ROWCOUNT FROM PPI_ABSENSI.KRU_JADWAL_PIKET
		        WHERE 0=0 ".$statement; 
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