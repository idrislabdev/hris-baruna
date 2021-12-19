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

  class Insentif extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Insentif()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("INSENTIF_ID", $this->getNextId("INSENTIF_ID","PPI_GAJI.INSENTIF")); 
		$str = "
				INSERT INTO PPI_GAJI.INSENTIF (
				   INSENTIF_ID, JABATAN_ID, KELAS, JUMLAH) 
				VALUES(
					  ".$this->getField("INSENTIF_ID").",
					  '".$this->getField("JABATAN_ID")."',
					  '".$this->getField("KELAS")."',
					  '".$this->getField("JUMLAH")."'
				)"; 
		$this->id = $this->getField("INSENTIF_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.INSENTIF
			   SET 
			   		JABATAN_ID			= '".$this->getField("JABATAN_ID")."',
			   		KELAS  				= '".$this->getField("KELAS")."',
				   	JUMLAH				= '".$this->getField("JUMLAH")."'
			 WHERE INSENTIF_ID = ".$this->getField("INSENTIF_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.INSENTIF
                WHERE 
                  INSENTIF_ID = ".$this->getField("INSENTIF_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="", $reqBulan="", $reqTahun="")
	{
		$str = "
				SELECT 
				INSENTIF_ID, A.JUMLAH, A.LAST_CREATE_USER, A.LAST_CREATE_DATE, A.LAST_UPDATE_USER, A.LAST_UPDATE_DATE, A.JABATAN_ID, B.NAMA JABATAN, B.KELAS KELAS
				FROM PPI_GAJI.INSENTIF A,PPI_SIMPEG.JABATAN B
				WHERE A.JABATAN_ID = B.JABATAN_ID
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
				INSENTIF_ID, JENIS_PEGAWAI_ID, KELAS, JUMLAH
				FROM PPI_GAJI.INSENTIF				
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY INSENTIF_ID DESC";
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
		$str = "SELECT COUNT(INSENTIF_ID) AS ROWCOUNT FROM PPI_GAJI.INSENTIF A WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(INSENTIF_ID) AS ROWCOUNT FROM PPI_GAJI.INSENTIF WHERE 1 = 1 "; 
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