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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_SERTIFIKAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiSertifikat extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiSertifikat()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_SERTIFIKAT_ID", $this->getNextId("PEGAWAI_SERTIFIKAT_ID","PPI_SIMPEG.PEGAWAI_SERTIFIKAT"));

		$str = "
					INSERT INTO PPI_SIMPEG.PEGAWAI_SERTIFIKAT (
					   PEGAWAI_SERTIFIKAT_ID, NAMA, PEGAWAI_ID, TANGGAL_TERBIT, TANGGAL_KADALUARSA, GROUP_SERTIFIKAT, KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE)
 			  	VALUES (
				  ".$this->getField("PEGAWAI_SERTIFIKAT_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  ".$this->getField("TANGGAL_TERBIT").",
				  ".$this->getField("TANGGAL_KADALUARSA").",
				  '".$this->getField("GROUP_SERTIFIKAT")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id=$this->getField("PEGAWAI_SERTIFIKAT_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_SERTIFIKAT
				SET    
					   PEGAWAI_ID         	= '".$this->getField("PEGAWAI_ID")."',
					   SERTIFIKAT_PEGAWAI_ID	 	= '".$this->getField("SERTIFIKAT_PEGAWAI_ID")."'
				WHERE  PEGAWAI_SERTIFIKAT_ID  = '".$this->getField("PEGAWAI_SERTIFIKAT_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_SERTIFIKAT
                WHERE 
                  PEGAWAI_ID = ".$this->getField("PEGAWAI_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.NAMA ASC")
	{
		$str = "
					SELECT 
					PEGAWAI_SERTIFIKAT_ID, PEGAWAI_ID, NAMA, KETERANGAN, TANGGAL_TERBIT, 
					TO_CHAR(TANGGAL_TERBIT, 'DD MONTH YYYY', 'NLS_DATE_LANGUAGE = INDONESIAN') AS TANGGAL_TERBIT_TEK,
					TANGGAL_KADALUARSA, GROUP_SERTIFIKAT
					FROM PPI_SIMPEG.PEGAWAI_SERTIFIKAT A
					WHERE 1=1
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
					PEGAWAI_SERTIFIKAT_ID, PEGAWAI_ID, SERTIFIKAT_PEGAWAI_ID
					FROM PPI_SIMPEG.PEGAWAI_SERTIFIKAT A WHERE PEGAWAI_SERTIFIKAT_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PEGAWAI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_SERTIFIKAT_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_SERTIFIKAT
		        WHERE PEGAWAI_SERTIFIKAT_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_SERTIFIKAT_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_SERTIFIKAT
		        WHERE PEGAWAI_SERTIFIKAT_ID IS NOT NULL ".$statement; 
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