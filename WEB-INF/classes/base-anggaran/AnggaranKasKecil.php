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


  class AnggaranKasKecil extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AnggaranKasKecil()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("TAHUN", $this->getNextId("TAHUN","PEL_ANGGARAN.ANGGARAN_KAS_KECIL")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO PEL_ANGGARAN.ANGGARAN_KAS_KECIL (
   					TAHUN, PUSPEL, JUMLAH) 
				VALUES ( 
					'".$this->getField("TAHUN")."', '".$this->getField("PUSPEL")."', '".$this->getField("JUMLAH")."'
				)";
				
		$this->id = $this->getField("TAHUN");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PEL_ANGGARAN.ANGGARAN_KAS_KECIL
				SET    JUMLAH      = '".$this->getField("JUMLAH")."',
					   PUSPEL      = '".$this->getField("PUSPEL")."'
				WHERE  TAHUN = '".$this->getField("TAHUN")."' AND 
					   PUSPEL = '".$this->getField("PUSPEL_TEMP")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PEL_ANGGARAN.ANGGARAN_KAS_KECIL
                WHERE 
                  TAHUN = ".$this->getField("TAHUN").""; 
				  
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
				SELECT TAHUN, PUSPEL, NM_BUKU_BESAR NAMA, JUMLAH
				FROM PEL_ANGGARAN.ANGGARAN_KAS_KECIL A INNER JOIN KBBR_BUKU_PUSAT@KEUANGAN B ON A.PUSPEL = B.KD_BUKU_BESAR
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TAHUN ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsMain($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT DEPARTEMEN_ID, A.PUSPEL, NAMA, B.JUMLAH, B.TAHUN 
				FROM PPI_SIMPEG.DEPARTEMEN A 
				LEFT JOIN PEL_ANGGARAN.ANGGARAN_KAS_KECIL B ON A.PUSPEL = B.PUSPEL
				WHERE A.PUSPEL IS NOT NULL AND LENGTH(DEPARTEMEN_ID) <= 4 AND STATUS_AKTIF = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
				GROUP BY DEPARTEMEN_ID, A.PUSPEL, NAMA, B.JUMLAH, B.TAHUN
				ORDER BY B.TAHUN, PUSPEL ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $reqTahun="", $statement="")
	{
		$str = "
				SELECT DEPARTEMEN_ID, A.PUSPEL, NAMA, B.JUMLAH, B.TAHUN 
				FROM PPI_SIMPEG.DEPARTEMEN A 
				LEFT JOIN PEL_ANGGARAN.ANGGARAN_KAS_KECIL B ON A.PUSPEL = B.PUSPEL AND B.TAHUN = '".$reqTahun."'
				WHERE A.PUSPEL IS NOT NULL AND LENGTH(DEPARTEMEN_ID) <= 4 AND STATUS_AKTIF = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
				GROUP BY DEPARTEMEN_ID, A.PUSPEL, NAMA, B.JUMLAH, B.TAHUN
				ORDER BY DEPARTEMEN_ID ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT TAHUN, PUSPEL, JUMLAH
				FROM PEL_ANGGARAN.ANGGARAN_KAS_KECIL
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PUSPEL ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	function getCountByParamsMain($paramsArray=array(), $statement="")
	{
		$str = "
				SELECT COUNT(1) AS ROWCOUNT
				FROM
				( 
				SELECT 1 
				FROM PPI_SIMPEG.DEPARTEMEN A 
				LEFT JOIN PEL_ANGGARAN.ANGGARAN_KAS_KECIL B ON A.PUSPEL = B.PUSPEL
				WHERE A.PUSPEL IS NOT NULL AND LENGTH(DEPARTEMEN_ID) <= 4 AND STATUS_AKTIF = 1
				"; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
				GROUP BY DEPARTEMEN_ID, A.PUSPEL, NAMA, B.JUMLAH, B.TAHUN
				)
				";
				
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
	function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(TAHUN) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_KAS_KECIL
		        WHERE TAHUN IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(TAHUN) AS ROWCOUNT FROM (SELECT TAHUN, PUSPEL, NAMA FROM PPI_SIMPEG.DEPARTEMEN A 
							WHERE PUSPEL IS NOT NULL AND LENGTH(TAHUN) <= 4 AND STATUS_AKTIF = 1 								
 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str.= " GROUP BY TAHUN, PUSPEL, NAMA) A ";
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(TAHUN) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_KAS_KECIL
		        WHERE TAHUN IS NOT NULL ".$statement; 
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