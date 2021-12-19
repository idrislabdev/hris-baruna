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

  class Anggaran extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Anggaran()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ANGGARAN_ID", $this->getNextId("ANGGARAN_ID","PEL_ANGGARAN.ANGGARAN")); 
		$str = "
				INSERT INTO PEL_ANGGARAN.ANGGARAN (
				   ANGGARAN_ID, TAHUN_BUKU, KD_BUKU_PUSAT, KD_SUB_BANTU, KD_BUKU_BESAR, KD_VALUTA, JUMLAH, JUMLAH_TRIWULAN1, JUMLAH_TRIWULAN2, JUMLAH_TRIWULAN3, JUMLAH_TRIWULAN4) 
				VALUES(
					  ".$this->getField("ANGGARAN_ID").",
					  '".$this->getField("TAHUN_BUKU")."',
					  '".$this->getField("KD_BUKU_PUSAT")."',
					  '".$this->getField("KD_SUB_BANTU")."',
					  '".$this->getField("KD_BUKU_BESAR")."',
					  '".$this->getField("KD_VALUTA")."',
					  '".$this->getField("JUMLAH")."',
					  '".$this->getField("JUMLAH_TRIWULAN1")."',
					  '".$this->getField("JUMLAH_TRIWULAN2")."',
					  '".$this->getField("JUMLAH_TRIWULAN3")."',
					  '".$this->getField("JUMLAH_TRIWULAN4")."'
				)"; 
		$this->id = $this->getField("ANGGARAN_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN
			   SET TAHUN_BUKU         = '".$this->getField("TAHUN_BUKU")."',
				   KD_BUKU_PUSAT	= '".$this->getField("KD_BUKU_PUSAT")."',
				   KD_SUB_BANTU= '".$this->getField("KD_SUB_BANTU")."',
				   KD_BUKU_BESAR= '".$this->getField("KD_BUKU_BESAR")."',
				   KD_VALUTA= '".$this->getField("KD_VALUTA")."',
				   JUMLAH= '".$this->getField("JUMLAH")."',
				   JUMLAH_TRIWULAN1= '".$this->getField("JUMLAH_TRIWULAN1")."',
				   JUMLAH_TRIWULAN2= '".$this->getField("JUMLAH_TRIWULAN2")."',
				   JUMLAH_TRIWULAN3= '".$this->getField("JUMLAH_TRIWULAN3")."',
				   JUMLAH_TRIWULAN4= '".$this->getField("JUMLAH_TRIWULAN4")."'
			 WHERE ANGGARAN_ID = ".$this->getField("ANGGARAN_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PEL_ANGGARAN.ANGGARAN
                WHERE 
                  ANGGARAN_ID = ".$this->getField("ANGGARAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				ANGGARAN_ID, A.TAHUN_BUKU, A.KD_BUKU_PUSAT, A.KD_SUB_BANTU, A.KD_BUKU_BESAR, A.KD_VALUTA, A.JUMLAH, B.JUMLAH_MUTASI, B.D_K, B.REALISASI, JUMLAH_TRIWULAN1, JUMLAH_TRIWULAN2, JUMLAH_TRIWULAN3, JUMLAH_TRIWULAN4
                FROM PEL_ANGGARAN.ANGGARAN A INNER JOIN PEL_ANGGARAN.MONITORING_ANGGARAN B ON A.TAHUN_BUKU = B.TAHUN_BUKU AND A.KD_BUKU_PUSAT = B.KD_BUKU_PUSAT AND A.KD_SUB_BANTU = B.KD_SUB_BANTU AND A.KD_BUKU_BESAR = B.KD_BUKU_BESAR 
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
				ANGGARAN_ID, TAHUN_BUKU, KD_BUKU_PUSAT, KD_SUB_BANTU, KD_BUKU_BESAR, KD_VALUTA, JUMLAH, JUMLAH_TRIWULAN1, JUMLAH_TRIWULAN2, JUMLAH_TRIWULAN3, JUMLAH_TRIWULAN4
				FROM PEL_ANGGARAN.ANGGARAN
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY ANGGARAN_ID DESC";
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
		$str = "SELECT COUNT(A.ANGGARAN_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN A WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(ANGGARAN_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN WHERE 1 = 1 "; 
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