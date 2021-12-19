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

  class KenaikanJabatan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KenaikanJabatan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KENAIKAN_JABATAN_ID", $this->getNextId("KENAIKAN_JABATAN_ID","PPI_SIMPEG.KENAIKAN_JABATAN"));

		$str = "
				INSERT INTO PPI_SIMPEG.KENAIKAN_JABATAN (
				   KENAIKAN_JABATAN_ID, PEGAWAI_ID, TANGGAL, 
				   DEPARTEMEN_ID_SEBELUM, JABATAN_ID_SEBELUM, DEPARTEMEN_ID_SESUDAH, JABATAN_ID_SESUDAH) 
 			  	VALUES (
				  ".$this->getField("KENAIKAN_JABATAN_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  ".$this->getField("TANGGAL").",
				  '".$this->getField("DEPARTEMEN_ID_SEBELUM")."',
				  '".$this->getField("JABATAN_ID_SEBELUM")."',
				  '".$this->getField("DEPARTEMEN_ID_SESUDAH")."',
				  '".$this->getField("JABATAN_ID_SESUDAH")."'
				)"; 
		$this->id = $this->getField("KENAIKAN_JABATAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.KENAIKAN_JABATAN
				SET    
					   PEGAWAI_ID      			= '".$this->getField("PEGAWAI_ID")."',
					   TANGGAL		    		= ".$this->getField("TANGGAL").",
					   DEPARTEMEN_ID_SEBELUM    = '".$this->getField("DEPARTEMEN_ID_SEBELUM")."',
					   JABATAN_ID_SEBELUM		= '".$this->getField("JABATAN_ID_SEBELUM")."',
					   DEPARTEMEN_ID_SESUDAH	= '".$this->getField("DEPARTEMEN_ID_SESUDAH")."',
					   JABATAN_ID_SESUDAH		= '".$this->getField("JABATAN_ID_SESUDAH")."'
				WHERE  KENAIKAN_JABATAN_ID   	= '".$this->getField("KENAIKAN_JABATAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateStatus()
	{
		$str = "
				UPDATE PPI_SIMPEG.KENAIKAN_JABATAN
				SET    
					   STATUS = '".$this->getField("STATUS")."'
				WHERE  KENAIKAN_JABATAN_ID   	= '".$this->getField("KENAIKAN_JABATAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.KENAIKAN_JABATAN
                WHERE 
                  KENAIKAN_JABATAN_ID = ".$this->getField("KENAIKAN_JABATAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		/*
		*/
		$str = "
				SELECT
    			NRP, NIPP, B.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR,
                KENAIKAN_JABATAN_ID, A.PEGAWAI_ID, A.TANGGAL, 
                   DEPARTEMEN_ID_SEBELUM,
                   JABATAN_ID_SEBELUM,
                   DEPARTEMEN_ID_SESUDAH,
                   JABATAN_ID_SESUDAH,
				   PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(DEPARTEMEN_ID_SEBELUM,0)) DEPARTEMEN_ID_SEBELUM_NAMA,
					(SELECT X.NAMA FROM PPI_SIMPEG.JABATAN X WHERE X.JABATAN_ID = A.JABATAN_ID_SEBELUM) JABATAN_ID_SEBELUM_NAMA, 
					PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(DEPARTEMEN_ID_SESUDAH,0)) DEPARTEMEN_ID_SESUDAH_NAMA,
					(SELECT X.NAMA FROM PPI_SIMPEG.JABATAN X WHERE X.JABATAN_ID = A.JABATAN_ID_SESUDAH) JABATAN_ID_SESUDAH_NAMA
                FROM PPI_SIMPEG.KENAIKAN_JABATAN A
                LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID=B.PEGAWAI_ID
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
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				KENAIKAN_JABATAN_ID, PEGAWAI_ID, TANGGAL, 
				   DEPARTEMEN_ID_SEBELUM, JABATAN_ID_SEBELUM, DEPARTEMEN_ID_SESUDAH, 
				   JABATAN_ID_SESUDAH
				FROM PPI_SIMPEG.KENAIKAN_JABATAN				
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KENAIKAN_JABATAN_ID DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KENAIKAN_JABATAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.KENAIKAN_JABATAN
		        WHERE KENAIKAN_JABATAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KENAIKAN_JABATAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.KENAIKAN_JABATAN
		        WHERE KENAIKAN_JABATAN_ID IS NOT NULL ".$statement; 
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