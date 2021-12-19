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

  class UangMilJenisKru extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function UangMilJenisKru()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("UANG_MIL_JENIS_KRU_ID", $this->getNextId("UANG_MIL_JENIS_KRU_ID","PPI_GAJI.UANG_MIL_JENIS_KRU")); 
		$str = "
				INSERT INTO PPI_GAJI.UANG_MIL_JENIS_KRU (
				   UANG_MIL_JENIS_KRU_ID, KAPAL_JENIS_ID, KRU_JABATAN_ID, 
				   PROSENTASE) 
				VALUES (
				  ".$this->getField("UANG_MIL_JENIS_KRU_ID").",
				  '".$this->getField("KAPAL_JENIS_ID")."',
				  '".$this->getField("KRU_JABATAN_ID")."',
				  '".$this->getField("PROSENTASE")."'
				)"; 
		$this->id = $this->getField("UANG_MIL_JENIS_KRU_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.UANG_MIL_JENIS_KRU
			   SET 
			   		KAPAL_JENIS_ID  	= '".$this->getField("KAPAL_JENIS_ID")."',
					KRU_JABATAN_ID 		= '".$this->getField("KRU_JABATAN_ID")."',
					PROSENTASE  		= '".$this->getField("PROSENTASE")."'
			 WHERE UANG_MIL_JENIS_KRU_ID = ".$this->getField("UANG_MIL_JENIS_KRU_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.UANG_MIL_JENIS_KRU
                WHERE 
                  UANG_MIL_JENIS_KRU_ID = ".$this->getField("UANG_MIL_JENIS_KRU_ID").""; 
				  
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
                UANG_MIL_JENIS_KRU_ID, A.KAPAL_JENIS_ID, A.KRU_JABATAN_ID, PROSENTASE, B.NAMA KAPAL_JENIS, C.NAMA KRU_JABATAN 
				FROM PPI_GAJI.UANG_MIL_JENIS_KRU A
                INNER JOIN PEL_OPERASIONAL.KAPAL_JENIS B ON A.KAPAL_JENIS_ID = B.KAPAL_JENIS_ID
				INNER JOIN PEL_OPERASIONAL.KRU_JABATAN  C ON A.KRU_JABATAN_ID = C.KRU_JABATAN_ID
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
                UANG_MIL_JENIS_KRU_ID, A.KAPAL_JENIS_ID, A.KRU_JABATAN_ID, PROSENTASE, B.NAMA KAPAL_JENIS, C.NAMA KRU_JABATAN 
				FROM PPI_GAJI.UANG_MIL_JENIS_KRU A
				INNER JOIN PEL_OPERASIONAL.KRU_JABATAN  B ON A.KRU_JABATAN_ID = B.KRU_JABATAN_ID
                INNER JOIN PEL_OPERASIONAL.KAPAL_JENIS C ON A.KAPAL_JENIS_ID = C.KAPAL_JENIS_ID
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY UANG_MIL_JENIS_KRU_ID DESC";
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
		$str = "
				SELECT COUNT(UANG_MIL_JENIS_KRU_ID) AS ROWCOUNT 
				FROM PPI_GAJI.UANG_MIL_JENIS_KRU A
                INNER JOIN PEL_OPERASIONAL.KAPAL_JENIS B ON A.KAPAL_JENIS_ID = B.KAPAL_JENIS_ID
				INNER JOIN PEL_OPERASIONAL.KRU_JABATAN  C ON A.KRU_JABATAN_ID = C.KRU_JABATAN_ID
			 ".$statement; 
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
		$str = "SELECT COUNT(UANG_MIL_JENIS_KRU_ID) AS ROWCOUNT FROM PPI_GAJI.UANG_MIL_JENIS_KRU WHERE 1 = 1 "; 
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