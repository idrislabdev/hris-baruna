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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_HUKUMAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiHukuman extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiHukuman()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_HUKUMAN_ID", $this->getNextId("PEGAWAI_HUKUMAN_ID","PPI_SIMPEG.PEGAWAI_HUKUMAN")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_HUKUMAN (
				   PEGAWAI_HUKUMAN_ID, PEGAWAI_ID, KATEGORI_HUKUMAN_ID, JENIS_HUKUMAN_ID, 
				   PEJABAT_PENETAP_ID, TANGGAL_SK, NO_SK, 
				   TMT_SK, KASUS, LAST_CREATE_USER, 
				   LAST_CREATE_DATE, AKHIR_TMT
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_HUKUMAN_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("KATEGORI_HUKUMAN_ID")."',
				  '".$this->getField("JENIS_HUKUMAN_ID")."',
				  '".$this->getField("PEJABAT_PENETAP_ID")."',
				  ".$this->getField("TANGGAL_SK").",
				  '".$this->getField("NO_SK")."',
				  ".$this->getField("TMT_SK").",
				  '".$this->getField("KASUS")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  ".$this->getField("AKHIR_TMT")."
				)"; 
		$this->id = $this->getField("PEGAWAI_HUKUMAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_HUKUMAN
				SET    
					   KATEGORI_HUKUMAN_ID = '".$this->getField("KATEGORI_HUKUMAN_ID")."',
					   JENIS_HUKUMAN_ID    = '".$this->getField("JENIS_HUKUMAN_ID")."',
					   PEJABAT_PENETAP_ID  = '".$this->getField("PEJABAT_PENETAP_ID")."',
					   TANGGAL_SK          = ".$this->getField("TANGGAL_SK").",
					   NO_SK               = '".$this->getField("NO_SK")."',
					   TMT_SK              = ".$this->getField("TMT_SK").",
					   KASUS               = '".$this->getField("KASUS")."',
					   LAST_UPDATE_USER    = '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	   = ".$this->getField("LAST_UPDATE_DATE").",
					   AKHIR_TMT 		   =  ".$this->getField("AKHIR_TMT")."
				WHERE  PEGAWAI_HUKUMAN_ID     = '".$this->getField("PEGAWAI_HUKUMAN_ID")."'
			 "; //FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_HUKUMAN
                WHERE 
                  PEGAWAI_HUKUMAN_ID = ".$this->getField("PEGAWAI_HUKUMAN_ID").""; 
				  
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
				PEGAWAI_HUKUMAN_ID, A.KATEGORI_HUKUMAN_ID, A.JENIS_HUKUMAN_ID, B.NAMA KATEGORI_HUKUMAN, C.NAMA JENIS_HUKUMAN,
				   PEJABAT_PENETAP_ID, TANGGAL_SK, NO_SK, PEGAWAI_ID,
				   TMT_SK, KASUS, AKHIR_TMT
				FROM PPI_SIMPEG.PEGAWAI_HUKUMAN A 
                INNER JOIN PPI_SIMPEG.KATEGORI_HUKUMAN B ON A.KATEGORI_HUKUMAN_ID = B.KATEGORI_HUKUMAN_ID
				INNER JOIN PPI_SIMPEG.JENIS_HUKUMAN C ON A.JENIS_HUKUMAN_ID = C.JENIS_HUKUMAN_ID
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TMT_SK DESC";
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PEGAWAI_HUKUMAN_ID, NAMA, KETERANGAN
				FROM PPI_SIMPEG.PEGAWAI_HUKUMAN
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
		$str = "SELECT COUNT(PEGAWAI_HUKUMAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_HUKUMAN
		        WHERE PEGAWAI_HUKUMAN_ID IS NOT NULL ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_HUKUMAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_HUKUMAN
		        WHERE PEGAWAI_HUKUMAN_ID IS NOT NULL ".$statement; 
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