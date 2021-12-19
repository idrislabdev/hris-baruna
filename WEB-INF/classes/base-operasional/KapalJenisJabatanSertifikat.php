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
  * Entity-base class untuk mengimplementasikan tabel DEPARTEMEN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class KapalJenisJabatanSertifikat extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalJenisJabatanSertifikat()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_JENIS_JABATAN_SERT_ID", $this->getNextId("KAPAL_JENIS_JABATAN_SERT_ID","PPI_OPERASIONAL.KAPAL_JENIS_JABATAN_SERT"));
		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_JENIS_JABATAN_SERT (
				   KAPAL_JENIS_JABATAN_SERT_ID, KAPAL_JENIS_ID, SERTIFIKAT_AWAK_KAPAL_ID, KRU_JABATAN_ID, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("KAPAL_JENIS_JABATAN_SERT_ID").",
				  '".$this->getField("KAPAL_JENIS_ID")."',
				  '".$this->getField("SERTIFIKAT_AWAK_KAPAL_ID")."',
				  ".$this->getField("KRU_JABATAN_ID").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("KAPAL_JENIS_JABATAN_SERT_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_JENIS_JABATAN_SERT
				SET    
					   NAMA           = '".$this->getField("NAMA")."'
				WHERE  POTONGAN_KONDISI_ID     = '".$this->getField("POTONGAN_KONDISI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_JENIS_JABATAN_SERT
                WHERE 
				  KAPAL_JENIS_ID= '".$this->getField("KAPAL_JENIS_ID")."' AND KRU_JABATAN_ID= '".$this->getField("KRU_JABATAN_ID")."' "; 
				  
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
				SELECT KAPAL_JENIS_JABATAN_SERT_ID, KAPAL_JENIS_ID, SERTIFIKAT_AWAK_KAPAL_ID, KRU_JABATAN_ID
				FROM PPI_OPERASIONAL.KAPAL_JENIS_JABATAN_SERT A				
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KAPAL_JENIS_JABATAN_SERT_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsPencarian($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqKapalJenisId="", $reqKruJabatanId='')
	{
		$str = "
				SELECT 
				KAPAL_JENIS_JABATAN_SERT_ID, B.KAPAL_JENIS_ID, A.SERTIFIKAT_AWAK_KAPAL_ID, A.NAMA
				FROM PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS_JABATAN_SERT B ON A.SERTIFIKAT_AWAK_KAPAL_ID=B.SERTIFIKAT_AWAK_KAPAL_ID AND B.KAPAL_JENIS_ID='".$reqKapalJenisId."' AND B.KRU_JABATAN_ID='".$reqKruJabatanId."'
				WHERE 1=1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.NAMA ASC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT POTONGAN_KONDISI_ID, POTONGAN_KONDISI_PARENT_ID, NAMA
				FROM PPI_OPERASIONAL.KAPAL_JENIS_JABATAN_SERT				
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
		$str = "SELECT COUNT(POTONGAN_KONDISI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_JENIS_JABATAN_SERT
		        WHERE POTONGAN_KONDISI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(POTONGAN_KONDISI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_JENIS_JABATAN_SERT
		        WHERE POTONGAN_KONDISI_ID IS NOT NULL ".$statement; 
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