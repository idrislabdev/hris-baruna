<? 
/* *******************************************************************************************************
MODUL NAME 			: IMASYS
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel BADAN_USAHA.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KpttSbppRincian extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KpttSbppRincian()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KPTT_SBPP_RINCIAN (
   					NO_NOTA, LINE_SEQ, KET_TAMBAH, TANDA_TRANS, JML_VAL_TRANS) 
				VALUES ( 
					'".$this->getField("NO_NOTA")."', '".$this->getField("LINE_SEQ")."', '".$this->getField("KET_TAMBAH")."', 
					'".$this->getField("TANDA_TRANS")."', '".$this->getField("JML_VAL_TRANS")."'
				)";
				
		$this->id = $this->getField("NO_NOTA");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KPTT_SBPP_RINCIAN
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."'"; 
				  
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
				SELECT NO_NOTA, LINE_SEQ, KET_TAMBAH, TANDA_TRANS, JML_VAL_TRANS
				FROM KPTT_SBPP_RINCIAN
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY NO_NOTA ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT NO_NOTA, LINE_SEQ, KET_TAMBAH, TANDA_TRANS, JML_VAL_TRANS
				FROM KPTT_SBPP_RINCIAN
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY LINE_SEQ ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(NO_NOTA) AS ROWCOUNT FROM KPTT_SBPP_RINCIAN
		        WHERE NO_NOTA IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(NO_NOTA) AS ROWCOUNT FROM KPTT_SBPP_RINCIAN
		        WHERE NO_NOTA IS NOT NULL ".$statement; 
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