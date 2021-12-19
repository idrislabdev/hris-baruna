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
  * Entity-base class untuk mengimplementasikan tabel PENDIDIKAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiKontrakPkwt extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiKontrakPkwt()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_KONTRAK_PKWT_ID", $this->getNextId("PEGAWAI_KONTRAK_PKWT_ID","PPI_SIMPEG.PEGAWAI_KONTRAK_PKWT")); 		

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_KONTRAK_PKWT (
				   PEGAWAI_KONTRAK_PKWT_ID, PEGAWAI_ID, NOMOR, 
   					TANGGAL_AWAL, TANGAL_AKHIR)  
 			  	VALUES (
				  ".$this->getField("PEGAWAI_KONTRAK_PKWT_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("NOMOR")."',
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGAL_AKHIR")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_KONTRAK_PKWT
				SET    
					   NOMOR    		= '".$this->getField("NOMOR")."',
					   TANGGAL_AWAL		= ".$this->getField("TANGGAL_AWAL").",
					   TANGAL_AKHIR		= ".$this->getField("TANGAL_AKHIR")."
				WHERE  PEGAWAI_KONTRAK_PKWT_ID     	= '".$this->getField("PEGAWAI_KONTRAK_PKWT_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_KONTRAK_PKWT
                WHERE 
                  PEGAWAI_KONTRAK_PKWT_ID = ".$this->getField("PEGAWAI_KONTRAK_PKWT_ID").""; 
				  
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
				SELECT PEGAWAI_KONTRAK_PKWT_ID, PEGAWAI_ID, NOMOR, 
   				TANGGAL_AWAL, TANGAL_AKHIR
				FROM PPI_SIMPEG.PEGAWAI_KONTRAK_PKWT
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KODE ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PEGAWAI_KONTRAK_PKWT_ID, PEGAWAI_ID, NOMOR, 
   				TANGGAL_AWAL, TANGAL_AKHIR
				FROM PPI_SIMPEG.PEGAWAI_KONTRAK_PKWT
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
		$str = "SELECT COUNT(PEGAWAI_KONTRAK_PKWT_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_KONTRAK_PKWT
		        WHERE PEGAWAI_KONTRAK_PKWT_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_KONTRAK_PKWT_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_KONTRAK_PKWT
		        WHERE PEGAWAI_KONTRAK_PKWT_ID IS NOT NULL ".$statement; 
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