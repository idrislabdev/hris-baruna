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
  * Entity-base class untuk mengimplementasikan tabel JENIS_PEGAWAI_PERUBAHAN_KODE.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class JenisPegawaiPerubahanKode extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function JenisPegawaiPerubahanKode()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JENIS_PEGAWAI_PERUBAH_KODE_ID", $this->getNextId("JENIS_PEGAWAI_PERUBAH_KODE_ID","PPI_SIMPEG.JENIS_PEGAWAI_PERUBAHAN_KODE")); 		

		$str = "
				INSERT INTO PPI_SIMPEG.JENIS_PEGAWAI_PERUBAHAN_KODE (
				   JENIS_PEGAWAI_PERUBAH_KODE_ID, NAMA, KODE, KETERANGAN) 
 			  	VALUES (
				  ".$this->getField("JENIS_PEGAWAI_PERUBAH_KODE_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KODE")."',
				  '".$this->getField("KETERANGAN")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.JENIS_PEGAWAI_PERUBAHAN_KODE
				SET    
					   NAMA           = '".$this->getField("NAMA")."',
					   KODE      = '".$this->getField("KODE")."',
					   KETERANGAN    = '".$this->getField("KETERANGAN")."'
				WHERE  JENIS_PEGAWAI_PERUBAH_KODE_ID     = '".$this->getField("JENIS_PEGAWAI_PERUBAH_KODE_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.JENIS_PEGAWAI_PERUBAHAN_KODE
                WHERE 
                  JENIS_PEGAWAI_PERUBAH_KODE_ID = ".$this->getField("JENIS_PEGAWAI_PERUBAH_KODE_ID").""; 
				  
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
				SELECT JENIS_PEGAWAI_PERUBAH_KODE_ID, NAMA, KODE, KETERANGAN
				FROM PPI_SIMPEG.JENIS_PEGAWAI_PERUBAHAN_KODE
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY JENIS_PEGAWAI_PERUBAH_KODE_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT JENIS_PEGAWAI_PERUBAH_KODE_ID, NAMA, KODE, KETERANGAN
				FROM PPI_SIMPEG.JENIS_PEGAWAI_PERUBAHAN_KODE
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(JENIS_PEGAWAI_PERUBAH_KODE_ID) AS ROWCOUNT FROM PPI_SIMPEG.JENIS_PEGAWAI_PERUBAHAN_KODE
		        WHERE JENIS_PEGAWAI_PERUBAH_KODE_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(JENIS_PEGAWAI_PERUBAH_KODE_ID) AS ROWCOUNT FROM PPI_SIMPEG.JENIS_PEGAWAI_PERUBAHAN_KODE
		        WHERE JENIS_PEGAWAI_PERUBAH_KODE_ID IS NOT NULL ".$statement; 
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