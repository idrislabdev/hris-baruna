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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_PUSPPI.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiPuspel extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiPuspel()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_PUSPEL_ID", $this->getNextId("PEGAWAI_PUSPEL_ID","PPI_SIMPEG.PEGAWAI_PUSPEL"));

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_PUSPEL (
				   PEGAWAI_PUSPEL_ID, DEPARTEMEN_ID, PEGAWAI_ID, CABANG_ID, TMT_PUSPEL, TANGGAL_PUSPEL,
				   KODE_PUSPEL1, KODE_PUSPEL2, KODE_PUSPEL3, LAST_CREATE_USER, LAST_CREATE_DATE
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_PUSPEL_ID").",
				  '".$this->getField("DEPARTEMEN_ID")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("CABANG_ID")."',
				  ".$this->getField("TMT_PUSPEL").",
				  ".$this->getField("TANGGAL_PUSPEL").",
				  '".$this->getField("KODE_PUSPEL1")."',
				  '".$this->getField("KODE_PUSPEL2")."',
				  '".$this->getField("KODE_PUSPEL3")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("PEGAWAI_PUSPEL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_PUSPEL
				SET    
					   DEPARTEMEN_ID        = '".$this->getField("DEPARTEMEN_ID")."',
					   PEGAWAI_ID      		= '".$this->getField("PEGAWAI_ID")."',
					   CABANG_ID    		= '".$this->getField("CABANG_ID")."',
					   TMT_PUSPEL         	= ".$this->getField("TMT_PUSPEL").",
					   TANGGAL_PUSPEL		= ".$this->getField("TANGGAL_PUSPEL").",
					   KODE_PUSPEL1			= '".$this->getField("KODE_PUSPEL1")."',
					   KODE_PUSPEL2			= '".$this->getField("KODE_PUSPEL2")."',
					   KODE_PUSPEL3			= '".$this->getField("KODE_PUSPEL3")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_PUSPEL_ID	= '".$this->getField("PEGAWAI_PUSPEL_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_PUSPEL
                WHERE 
                  PEGAWAI_PUSPEL_ID = ".$this->getField("PEGAWAI_PUSPEL_ID").""; 
				  
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
					PEGAWAI_PUSPEL_ID, A.DEPARTEMEN_ID, PEGAWAI_ID, A.CABANG_ID, TMT_PUSPEL, TANGGAL_PUSPEL, KODE_PUSPEL1, KODE_PUSPEL2, KODE_PUSPEL3,
					B.NAMA CABANG_NAMA, C.NAMA DEPARTEMEN_NAMA
				FROM PPI_SIMPEG.PEGAWAI_PUSPEL A
				LEFT JOIN PPI_SIMPEG.CABANG B ON A.CABANG_ID=B.CABANG_ID
				LEFT JOIN PPI_SIMPEG.DEPARTEMEN C ON A.DEPARTEMEN_ID=C.DEPARTEMEN_ID
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TMT_PUSPEL DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PEGAWAI_PUSPEL_ID, DEPARTEMEN_ID, PEGAWAI_ID, CABANG_ID, TMT_PUSPEL, TANGGAL_PUSPEL, KODE_PUSPEL1, KODE_PUSPEL2, KODE_PUSPEL3
				FROM PPI_SIMPEG.PEGAWAI_PUSPEL
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY DEPARTEMEN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_PUSPEL_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_PUSPEL
		        WHERE PEGAWAI_PUSPEL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_PUSPEL_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_PUSPEL
		        WHERE PEGAWAI_PUSPEL_ID IS NOT NULL ".$statement; 
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