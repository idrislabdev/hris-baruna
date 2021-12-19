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

  class AnggaranOverBudget extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AnggaranOverBudget()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PEL_ANGGARAN.ANGGARAN_OVERBUDGET (
				   ANGGARAN_MUTASI_ID, NO_NOTA, KD_BUKU_BESAR, KD_BUKU_PUSAT, JUMLAH) 
				VALUES(
					  ".$this->getField("ANGGARAN_MUTASI_ID").",
					  '".$this->getField("NO_NOTA")."',
					  '".$this->getField("KD_BUKU_BESAR")."',
					  '".$this->getField("KD_BUKU_PUSAT")."',
					  '".$this->getField("JUMLAH")."'
				)"; 
		$this->id = $this->getField("NO_NOTA");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_OVERBUDGET
			   SET NO_NOTA         = '".$this->getField("NO_NOTA")."',
				   KD_BUKU_BESAR	= '".$this->getField("KD_BUKU_BESAR")."',
				   KD_BUKU_PUSAT= '".$this->getField("KD_BUKU_PUSAT")."',
				   JUMLAH= '".$this->getField("JUMLAH")."'
			 WHERE NO_NOTA = ".$this->getField("NO_NOTA")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function deleteOverbudgetByField()
	{
        $str = "DELETE FROM PEL_ANGGARAN.ANGGARAN_OVERBUDGET
                WHERE 
                  ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")." AND
				  KD_BUKU_BESAR 	 = '".$this->getField("KD_BUKU_BESAR")."' AND
				  KD_BUKU_PUSAT 	 = '".$this->getField("KD_BUKU_PUSAT")."' AND
				  JUMLAH 			 = '".$this->getField("JUMLAH")."'
				  "; 				  
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
		
	function delete()
	{
        $str = "DELETE FROM PEL_ANGGARAN.ANGGARAN_OVERBUDGET
                WHERE 
                  ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit KD_BUKU_BESAR maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				ANGGARAN_MUTASI_ID, NO_NOTA, KD_BUKU_BESAR, 
				   KD_BUKU_PUSAT, JUMLAH
				FROM PEL_ANGGARAN.ANGGARAN_OVERBUDGET A
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
				NO_NOTA, NO_NOTA, KD_BUKU_BESAR, KD_BUKU_PUSAT, JUMLAH
				FROM PEL_ANGGARAN.ANGGARAN_OVERBUDGET
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY NO_NOTA DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung KD_BUKU_BESAR record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long KD_BUKU_BESAR record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(NO_NOTA) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_OVERBUDGET A
                WHERE 1 = 1 ".$statement; 
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

    function getSumByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT SUM(JUMLAH) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_OVERBUDGET A
                 INNER JOIN PEL_ANGGARAN.ANGGARAN_MUTASI B
				   ON A.ANGGARAN_MUTASI_ID = B.ANGGARAN_MUTASI_ID AND THN_BUKU = TO_CHAR(SYSDATE, 'YYYY')
			 WHERE 1 = 1 ".$statement; 
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
	
    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(NO_NOTA) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_OVERBUDGET WHERE 1 = 1 "; 
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