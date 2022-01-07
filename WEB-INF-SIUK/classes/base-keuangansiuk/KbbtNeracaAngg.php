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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBT_NERACA_ANGG.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbtNeracaAngg extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbtNeracaAngg()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO PPI_SIUK.KBBT_NERACA_ANGG (
						   KD_CABANG, THN_BUKU, KD_BUKU_BESAR, 
						   KD_SUB_BANTU, KD_BUKU_PUSAT, KD_VALUTA, 
						   ANGG_TAHUNAN, MUTA_TAHUNAN, LAST_UPDATE_DATE, 
						   LAST_UPDATED_BY, PROGRAM_NAME, 
						   P01_ANGG, P02_ANGG, P03_ANGG, P04_ANGG, P05_ANGG, P06_ANGG,
						   P07_ANGG, P08_ANGG, P09_ANGG, P10_ANGG, P11_ANGG, P12_ANGG) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("THN_BUKU")."', '".$this->getField("KD_BUKU_BESAR")."',
							'".$this->getField("KD_SUB_BANTU")."', '".$this->getField("KD_BUKU_PUSAT")."', '".$this->getField("KD_VALUTA")."',
							'".$this->getField("ANGG_TAHUNAN")."', '".$this->getField("MUTA_TAHUNAN")."', ".$this->getField("LAST_UPDATE_DATE").",
							'".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."', 
							'".$this->getField("P01_ANGG")."', '".$this->getField("P02_ANGG")."', '".$this->getField("P03_ANGG")."',
							'".$this->getField("P04_ANGG")."', '".$this->getField("P05_ANGG")."', '".$this->getField("P06_ANGG")."',
							'".$this->getField("P07_ANGG")."', '".$this->getField("P08_ANGG")."', '".$this->getField("P09_ANGG")."',
							'".$this->getField("P10_ANGG")."', '".$this->getField("P11_ANGG")."', '".$this->getField("P12_ANGG")."'	
				)";
				
		$this->id = $this->getField("KBBT_NERACA_ANGG_ID");
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIUK.KBBT_NERACA_ANGG
				SET    ANGG_TAHUNAN     = '".$this->getField("ANGG_TAHUNAN")."',
					   MUTA_TAHUNAN     = '".$this->getField("MUTA_TAHUNAN")."',
					   P01_ANGG        = '".$this->getField("P01_ANGG")."',
					   P02_ANGG        = '".$this->getField("P02_ANGG")."',
					   P03_ANGG        = '".$this->getField("P03_ANGG")."',
					   P04_ANGG        = '".$this->getField("P04_ANGG")."',
					   P05_ANGG        = '".$this->getField("P05_ANGG")."',
					   P06_ANGG        = '".$this->getField("P06_ANGG")."',
					   P07_ANGG        = '".$this->getField("P07_ANGG")."',
					   P08_ANGG        = '".$this->getField("P08_ANGG")."',
					   P09_ANGG        = '".$this->getField("P09_ANGG")."',
					   P10_ANGG        = '".$this->getField("P10_ANGG")."',
					   P11_ANGG        = '".$this->getField("P11_ANGG")."',
					   P12_ANGG        = '".$this->getField("P12_ANGG")."'
				WHERE  THN_BUKU = '".$this->getField("THN_BUKU_1")."' AND
					   KD_BUKU_BESAR = '".$this->getField("KD_BUKU_BESAR_1")."' AND
					   KD_BUKU_PUSAT = '".$this->getField("KD_BUKU_PUSAT_1")."'
			";
	
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function deleteTahun()
	{
        $str = "DELETE FROM KBBT_NERACA_ANGG
                WHERE 
                  THN_BUKU = '".$this->getField("THN_BUKU")."' 
				 "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBT_NERACA_ANGG
                WHERE 
                  KD_BUKU_PUSAT = '".$this->getField("KD_BUKU_PUSAT")."' AND KD_BUKU_BESAR = '".$this->getField("KD_BUKU_BESAR")."' AND THN_BUKU = '".$this->getField("THN_BUKU")."' "; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT A.KD_CABANG, THN_BUKU, A.KD_BUKU_BESAR, 
				KD_SUB_BANTU, KD_BUKU_PUSAT, KD_VALUTA, 
				ANGG_TAHUNAN, MUTA_TAHUNAN, P01_ANGG, 
				P01_MUTA, P02_ANGG, P02_MUTA, 
				P03_ANGG, P03_MUTA, P04_ANGG, 
				P04_MUTA, P05_ANGG, P05_MUTA, 
				P06_ANGG, P06_MUTA, P07_ANGG, 
				P07_MUTA, P08_ANGG, P08_MUTA, 
				P09_ANGG, P09_MUTA, P10_ANGG, 
				P10_MUTA, P11_ANGG, P11_MUTA, 
				P12_ANGG, P12_MUTA, P13_ANGG, 
				P13_MUTA, P14_ANGG, P14_MUTA, 
				STATUS_CLOSING, TGL_CLOSING, A.LAST_UPDATE_DATE, 
                A.LAST_UPDATED_BY, A.PROGRAM_NAME, ANGG_TRW1, 
                ANGG_TRW2, ANGG_TRW3, ANGG_TRW4, NM_BUKU_BESAR
                FROM KBBT_NERACA_ANGG A LEFT JOIN KBBR_BUKU_PUSAT B ON A.KD_BUKU_PUSAT = B.KD_BUKU_BESAR
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsBukuBesar($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT A.KD_CABANG, THN_BUKU, A.KD_BUKU_BESAR, B.NM_BUKU_BESAR FROM KBBT_NERACA_ANGG A INNER JOIN KBBR_BUKU_BESAR B ON A.KD_BUKU_BESAR = B.KD_BUKU_BESAR
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."  GROUP BY A.KD_CABANG, THN_BUKU, A.KD_BUKU_BESAR, B.NM_BUKU_BESAR ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

	function selectByParamsBukuBesarAll($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT A.KD_BUKU_BESAR, A.NM_BUKU_BESAR FROM KBBR_BUKU_BESAR A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."   ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
		
	function selectByParamsMaintenanceAnggaran($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT THN_BUKU, KD_BUKU_BESAR, KD_BUKU_BESAR || ' - ' || NM_BUKU_BESAR NM_BUKU_BESAR, KD_SUB_BANTU, 
				KD_BUKU_PUSAT, KD_BUKU_PUSAT || ' - ' || NM_BUKU_PUSAT NM_BUKU_PUSAT, NVL(ANGG_TAHUNAN, 0) ANGG_TAHUNAN, 
				NVL(ANGG_TRW1, 0) ANGG_TRW1, NVL(ANGG_TRW2, 0) ANGG_TRW2, NVL(ANGG_TRW3, 0) ANGG_TRW3, NVL(ANGG_TRW4, 0) ANGG_TRW4,
                 NVL(JUMLAH_MUTASI, 0) JUMLAH_MUTASI, NVL(JUMLAH_MUTASI_REAL, 0) JUMLAH_MUTASI_REAL, 
                 NVL(ANGG_TAHUNAN, 0) - NVL(JUMLAH_MUTASI_REAL, 0) SISA, D_K, REALISASI FROM MAINTENANCE_ANGGARAN_TAHUNAN
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsMaintenanceAnggaranTriwulan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT A.THN_BUKU, A.KD_BUKU_BESAR || ' - ' || A.NM_BUKU_BESAR KD_BUKU_BESAR, A.KD_SUB_BANTU || ' - ' || A.NM_SUB_BANTU KD_SUB_BANTU,  A.KD_BUKU_PUSAT || ' - ' || A.NM_BUKU_BESAR KD_BUKU_PUSAT, 
					NVL(ANGG_TRW1, 0) ANGG_TRW1, NVL(ABS(MUTASI_TRW1), 0) MUTASI_TRW1, 
					D_K_TRW1, REALISASI_TRW1,
					NVL(ANGG_TRW2, 0) ANGG_TRW2, NVL(ABS(MUTASI_TRW2), 0) MUTASI_TRW2, 
					D_K_TRW2, REALISASI_TRW2,
					NVL(ANGG_TRW3, 0) ANGG_TRW3, NVL(ABS(MUTASI_TRW3), 0) MUTASI_TRW3, 
					D_K_TRW3, REALISASI_TRW3,
					NVL(ANGG_TRW4, 0) ANGG_TRW4, NVL(ABS(MUTASI_TRW4), 0) MUTASI_TRW4, 
					D_K_TRW4, REALISASI_TRW4
				FROM MAINTENANCE_ANGGARAN_TAHUNAN A            
				WHERE 1 = 1
				"; 
		//, FOTO
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
				SELECT KD_CABANG, THN_BUKU, KD_BUKU_BESAR, 
				KD_SUB_BANTU, KD_BUKU_PUSAT, KD_VALUTA, 
				ANGG_TAHUNAN, MUTA_TAHUNAN, P01_ANGG, 
				P01_MUTA, P02_ANGG, P02_MUTA, 
				P03_ANGG, P03_MUTA, P04_ANGG, 
				P04_MUTA, P05_ANGG, P05_MUTA, 
				P06_ANGG, P06_MUTA, P07_ANGG, 
				P07_MUTA, P08_ANGG, P08_MUTA, 
				P09_ANGG, P09_MUTA, P10_ANGG, 
				P10_MUTA, P11_ANGG, P11_MUTA, 
				P12_ANGG, P12_MUTA, P13_ANGG, 
				P13_MUTA, P14_ANGG, P14_MUTA, 
				STATUS_CLOSING, TGL_CLOSING, LAST_UPDATE_DATE, 
				LAST_UPDATED_BY, PROGRAM_NAME, ANGG_TRW1, 
				ANGG_TRW2, ANGG_TRW3, ANGG_TRW4
				FROM KBBT_NERACA_ANGG
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KD_CABANG ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KBBT_NERACA_ANGG_ID) AS ROWCOUNT FROM KBBT_NERACA_ANGG
		        WHERE KBBT_NERACA_ANGG_ID IS NOT NULL ".$statement; 
		
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
	
	function getCountByParamsMaintenanceAnggaran($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KD_BUKU_BESAR) AS ROWCOUNT FROM MAINTENANCE_ANGGARAN_TAHUNAN
		        WHERE 1=1 ".$statement; 
		
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

	function getCountByParamsMaintenanceAnggaranTriwulan($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) ROWCOUNT
				FROM MAINTENANCE_ANGGARAN_TAHUNAN A INNER JOIN KBBR_BUKU_BESAR B ON A.KD_BUKU_BESAR = B.KD_BUKU_BESAR
					 INNER JOIN KBBR_BUKU_PUSAT C ON A.KD_BUKU_PUSAT = C.KD_BUKU_BESAR                
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
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KBBT_NERACA_ANGG_ID) AS ROWCOUNT FROM KBBT_NERACA_ANGG
		        WHERE KBBT_NERACA_ANGG_ID IS NOT NULL ".$statement; 
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