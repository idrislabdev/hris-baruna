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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBT_TEMPL_LRPUSAT.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbtTemplLrpusat extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbtTemplLrpusat()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBT_TEMPL_LRPUSAT_ID", $this->getNextId("KBBT_TEMPL_LRPUSAT_ID","KBBT_TEMPL_LRPUSAT")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBT_TEMPL_LRPUSAT (
					   NO_JUDUL, NO_URUT, KD_BUKU_BESAR, 
					   SUB_JUDUL1, SUB_JUDUL2, TIPE_REKENING, 
					   NAMA_REKENING, ANGGARAN, MUT_YTD_YYKINI, 
					   MUT_YTD_YYLALU, DEVIASI1, DEVIASI2) 
				VALUES ('".$this->getField("NO_JUDUL")."', '".$this->getField("NO_URUT")."', '".$this->getField("KD_BUKU_BESAR")."',
						'".$this->getField("SUB_JUDUL1")."', '".$this->getField("SUB_JUDUL2")."', '".$this->getField("TIPE_REKENING")."',
						'".$this->getField("NAMA_REKENING")."', '".$this->getField("ANGGARAN")."', '".$this->getField("MUT_YTD_YYKINI")."',
						'".$this->getField("MUT_YTD_YYLALU")."', '".$this->getField("DEVIASI1")."', '".$this->getField("DEVIASI2")."'
				 )";
				
		$this->id = $this->getField("KBBT_TEMPL_LRPUSAT_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBT_TEMPL_LRPUSAT
				SET    
					   NO_JUDUL       = '".$this->getField("NO_JUDUL")."',
					   NO_URUT        = '".$this->getField("NO_URUT")."',
					   KD_BUKU_BESAR  = '".$this->getField("KD_BUKU_BESAR")."',
					   SUB_JUDUL1     = '".$this->getField("SUB_JUDUL1")."',
					   SUB_JUDUL2     = '".$this->getField("SUB_JUDUL2")."',
					   TIPE_REKENING  = '".$this->getField("TIPE_REKENING")."',
					   NAMA_REKENING  = '".$this->getField("NAMA_REKENING")."',
					   ANGGARAN       = '".$this->getField("ANGGARAN")."',
					   MUT_YTD_YYKINI = '".$this->getField("MUT_YTD_YYKINI")."',
					   MUT_YTD_YYLALU = '".$this->getField("MUT_YTD_YYLALU")."',
					   DEVIASI1       = '".$this->getField("DEVIASI1")."',
					   DEVIASI2       = '".$this->getField("DEVIASI2")."'
				WHERE  KBBT_TEMPL_LRPUSAT_ID = '".$this->getField("KBBT_TEMPL_LRPUSAT_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBT_TEMPL_LRPUSAT
                WHERE 
                  KBBT_TEMPL_LRPUSAT_ID = ".$this->getField("KBBT_TEMPL_LRPUSAT_ID").""; 
				  
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
				SELECT NO_JUDUL, NO_URUT, KD_BUKU_BESAR, 
				SUB_JUDUL1, SUB_JUDUL2, TIPE_REKENING, 
				NAMA_REKENING, ANGGARAN, MUT_YTD_YYKINI, 
				MUT_YTD_YYLALU, DEVIASI1, DEVIASI2
				FROM KBBT_TEMPL_LRPUSAT
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KBBT_TEMPL_LRPUSAT_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT NO_JUDUL, NO_URUT, KD_BUKU_BESAR, 
				SUB_JUDUL1, SUB_JUDUL2, TIPE_REKENING, 
				NAMA_REKENING, ANGGARAN, MUT_YTD_YYKINI, 
				MUT_YTD_YYLALU, DEVIASI1, DEVIASI2
				FROM KBBT_TEMPL_LRPUSAT
				WHERE 1 = 1				
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NO_JUDUL ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KBBT_TEMPL_LRPUSAT_ID) AS ROWCOUNT FROM KBBT_TEMPL_LRPUSAT
		        WHERE KBBT_TEMPL_LRPUSAT_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KBBT_TEMPL_LRPUSAT_ID) AS ROWCOUNT FROM KBBT_TEMPL_LRPUSAT
		        WHERE KBBT_TEMPL_LRPUSAT_ID IS NOT NULL ".$statement; 
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