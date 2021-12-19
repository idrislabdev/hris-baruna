<? 
/* *******************************************************************************************************
MODUL NAME 			: PPI
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

  class KapalJenisKru extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalJenisKru()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_JENIS_KRU_ID", $this->getNextId("KAPAL_JENIS_KRU_ID","PPI_OPERASIONAL.KAPAL_JENIS_KRU"));

		$str = "
					INSERT INTO PPI_OPERASIONAL.KAPAL_JENIS_KRU (
					   KAPAL_JENIS_KRU_ID, KAPAL_JENIS_ID, KRU_JABATAN_ID, LAST_CREATE_USER, LAST_CREATE_DATE)
 			  	VALUES (
				  ".$this->getField("KAPAL_JENIS_KRU_ID").",
				  '".$this->getField("KAPAL_JENIS_ID")."',
				  '".$this->getField("KRU_JABATAN_ID")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_JENIS_KRU
				SET    
					   KAPAL_JENIS_ID         	= '".$this->getField("KAPAL_JENIS_ID")."',
					   KRU_JABATAN_ID	 	= '".$this->getField("KRU_JABATAN_ID")."'
				WHERE  KAPAL_JENIS_KRU_ID  = '".$this->getField("KAPAL_JENIS_KRU_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_JENIS_KRU
                WHERE 
                  KAPAL_JENIS_ID = ".$this->getField("KAPAL_JENIS_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_JENIS_KRU_ID ASC")
	{
		$str = "
					SELECT 
					KAPAL_JENIS_KRU_ID, A.KAPAL_JENIS_ID, KRU_JABATAN_ID, PPI_OPERASIONAL.AMBIL_JNS_JBTN_SERTIFIKAT_ID(A.KAPAL_JENIS_ID, KRU_JABATAN_ID) NAMA_SERTIFIKAT, B.NAMA KAPAL_JENIS_NAMA
					FROM PPI_OPERASIONAL.KAPAL_JENIS_KRU A
					LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS B ON A.KAPAL_JENIS_ID = B.KAPAL_JENIS_ID 
					WHERE KAPAL_JENIS_KRU_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsEdit($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqKapalJenisId="")
	{
		$str = "
				SELECT 
				KAPAL_JENIS_SERTIFIKAT_KPL_ID, B.KAPAL_JENIS_ID, A.KAPAL_JENIS_KRU_ID, A.KAPAL_JENIS_ID
				FROM PPI_OPERASIONAL.KAPAL_JENIS_KRU A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS_SERTIFIKAT_KPL B ON A.KAPAL_JENIS_KRU_ID=B.KAPAL_JENIS_KRU_ID AND B.KAPAL_JENIS_ID='".$reqKapalJenisId."'
				WHERE 1=1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.KAPAL_JENIS_ID ASC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	
					SELECT 
					KAPAL_JENIS_KRU_ID, KAPAL_JENIS_ID, KRU_JABATAN_ID
					FROM PPI_OPERASIONAL.KAPAL_JENIS_KRU A WHERE KAPAL_JENIS_KRU_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_JENIS_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_JENIS_KRU_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_JENIS_KRU
		        WHERE KAPAL_JENIS_KRU_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_JENIS_KRU_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_JENIS_KRU
		        WHERE KAPAL_JENIS_KRU_ID IS NOT NULL ".$statement; 
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