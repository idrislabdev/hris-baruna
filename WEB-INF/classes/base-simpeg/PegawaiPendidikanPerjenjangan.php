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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_PEND_PERJENJANGAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiPendidikanPerjenjangan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiPendidikanPerjenjangan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_PEND_PERJENJANGAN_ID", $this->getNextId("PEGAWAI_PEND_PERJENJANGAN_ID","PPI_SIMPEG.PEGAWAI_PEND_PERJENJANGAN")); 		

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_PEND_PERJENJANGAN (
				   PEGAWAI_PEND_PERJENJANGAN_ID, PEGAWAI_ID, TANGGAL_AWAL, TANGGAL_AKHIR, NAMA, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_PEND_PERJENJANGAN_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->query = $str;
		$this->id = $this->getField("PEGAWAI_PEND_PERJENJANGAN_ID");
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_PEND_PERJENJANGAN
				SET
					   TANGGAL_AWAL           		= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR    	= ".$this->getField("TANGGAL_AKHIR").",
					   NAMA= '".$this->getField("NAMA")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_PEND_PERJENJANGAN_ID     	= '".$this->getField("PEGAWAI_PEND_PERJENJANGAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_PEND_PERJENJANGAN
                WHERE 
                  PEGAWAI_PEND_PERJENJANGAN_ID = ".$this->getField("PEGAWAI_PEND_PERJENJANGAN_ID").""; 
				  
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
				SELECT PEGAWAI_PEND_PERJENJANGAN_ID, PEGAWAI_ID, TANGGAL_AWAL, TANGGAL_AKHIR, NAMA
				FROM PPI_SIMPEG.PEGAWAI_PEND_PERJENJANGAN
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TANGGAL_AWAL DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PEGAWAI_PEND_PERJENJANGAN_ID, PEGAWAI_ID, TANGGAL_AWAL, TANGGAL_AKHIR, NAMA
				FROM PPI_SIMPEG.PEGAWAI_PEND_PERJENJANGAN
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY TANGGAL_AWAL DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_PEND_PERJENJANGAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_PEND_PERJENJANGAN
		        WHERE PEGAWAI_PEND_PERJENJANGAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_PEND_PERJENJANGAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_PEND_PERJENJANGAN
		        WHERE PEGAWAI_PEND_PERJENJANGAN_ID IS NOT NULL ".$statement; 
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