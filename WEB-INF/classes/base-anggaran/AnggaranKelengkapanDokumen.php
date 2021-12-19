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
  * Entity-base class untuk mengimplementasikan tabel BADAN_USAHA.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");


  class AnggaranKelengkapanDokumen extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AnggaranKelengkapanDokumen()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("ANGGARAN_MUTASI_ID", $this->getNextId("ANGGARAN_MUTASI_ID","PEL_ANGGARAN.ANGGARAN_KELENGKAPAN_DOKUMEN")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO PEL_ANGGARAN.ANGGARAN_KELENGKAPAN_DOKUMEN (
   					ANGGARAN_MUTASI_ID, KELENGKAPAN_DOKUMEN_ID) 
				VALUES ( 
					'".$this->getField("ANGGARAN_MUTASI_ID")."', '".$this->getField("KELENGKAPAN_DOKUMEN_ID")."'
				)";
		$this->id = $this->getField("ANGGARAN_MUTASI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PEL_ANGGARAN.ANGGARAN_KELENGKAPAN_DOKUMEN
				SET    
					   KELENGKAPAN_DOKUMEN_ID            = '".$this->getField("KELENGKAPAN_DOKUMEN_ID")."'
				WHERE  ANGGARAN_MUTASI_ID = '".$this->getField("ANGGARAN_MUTASI_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PEL_ANGGARAN.ANGGARAN_KELENGKAPAN_DOKUMEN
                WHERE 
                  ANGGARAN_MUTASI_ID = '".$this->getField("ANGGARAN_MUTASI_ID")."'"; 
				  
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
				SELECT ANGGARAN_MUTASI_ID, KELENGKAPAN_DOKUMEN_ID
				FROM PEL_ANGGARAN.ANGGARAN_KELENGKAPAN_DOKUMEN
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY ANGGARAN_MUTASI_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsCombo($id="")
	{
		$str = "
				SELECT 
				A.KELENGKAPAN_DOKUMEN_ID, NAMA, KETERANGAN, B.KELENGKAPAN_DOKUMEN_ID KELENGKAPAN_ANGGARAN_ID
				FROM PEL_ANGGARAN.KELENGKAPAN_DOKUMEN  A 
				LEFT JOIN PEL_ANGGARAN.ANGGARAN_KELENGKAPAN_DOKUMEN B ON A.KELENGKAPAN_DOKUMEN_ID = B.KELENGKAPAN_DOKUMEN_ID AND B.ANGGARAN_MUTASI_ID = '".$id."'
				"; 
		
						
		$this->query = $str;
		return $this->selectLimit($str,-1, -1); 
    }
	    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT ANGGARAN_MUTASI_ID, KELENGKAPAN_DOKUMEN_ID, KD_BUKU_BESAR
				FROM PEL_ANGGARAN.ANGGARAN_KELENGKAPAN_DOKUMEN
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KELENGKAPAN_DOKUMEN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(ANGGARAN_MUTASI_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_KELENGKAPAN_DOKUMEN
		        WHERE ANGGARAN_MUTASI_ID IS NOT NULL ".$statement; 
		
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

    function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(ANGGARAN_MUTASI_ID) AS ROWCOUNT FROM (SELECT ANGGARAN_MUTASI_ID, PUSPEL, NAMA FROM PPI_SIMPEG.DEPARTEMEN A 
							WHERE PUSPEL IS NOT NULL AND LENGTH(ANGGARAN_MUTASI_ID) <= 4 AND STATUS_AKTIF = 1 								
 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str.= " GROUP BY ANGGARAN_MUTASI_ID, PUSPEL, NAMA) A ";
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(ANGGARAN_MUTASI_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_KELENGKAPAN_DOKUMEN
		        WHERE ANGGARAN_MUTASI_ID IS NOT NULL ".$statement; 
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