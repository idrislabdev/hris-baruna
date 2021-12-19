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


  class AnggaranAkses extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AnggaranAkses()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("DEPARTEMEN_ID", $this->getNextId("DEPARTEMEN_ID","PEL_ANGGARAN.ANGGARAN_AKSES")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO PEL_ANGGARAN.ANGGARAN_AKSES (
   					DEPARTEMEN_ID, KD_BUKU_PUSAT, KD_BUKU_BESAR, TAHUN, KD_SUB_BANTU, KD_BUKU_BESAR_JRR) 
				VALUES ( 
					'".$this->getField("DEPARTEMEN_ID")."', '".$this->getField("KD_BUKU_PUSAT")."', 
					'".$this->getField("KD_BUKU_BESAR")."', '".$this->getField("TAHUN")."', '".$this->getField("KD_SUB_BANTU")."', '".$this->getField("KD_BUKU_BESAR_JRR")."'
				)";
				
		$this->id = $this->getField("DEPARTEMEN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PEL_ANGGARAN.ANGGARAN_AKSES
				SET    
					   KD_BUKU_PUSAT            = '".$this->getField("KD_BUKU_PUSAT")."',
					   KD_BUKU_BESAR      = '".$this->getField("KD_BUKU_BESAR")."'
				WHERE  DEPARTEMEN_ID = '".$this->getField("DEPARTEMEN_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PEL_ANGGARAN.ANGGARAN_AKSES
                WHERE 
                  DEPARTEMEN_ID = '".$this->getField("DEPARTEMEN_ID")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	
	function deleteSubBantu()
	{
        $str = "DELETE FROM PEL_ANGGARAN.ANGGARAN_AKSES
                WHERE 
                  KD_SUB_BANTU = '".$this->getField("KD_SUB_BANTU")."'"; 
				  
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
				SELECT DEPARTEMEN_ID, KD_BUKU_PUSAT, KD_BUKU_BESAR, TAHUN, KD_SUB_BANTU, KD_BUKU_BESAR_JRR
				FROM PEL_ANGGARAN.ANGGARAN_AKSES
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY DEPARTEMEN_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsExcel($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT TAHUN, KD_BUKU_BESAR, NM_BUKU_BESAR, KD_BUKU_BESAR_PARENT, NM_BUKU_BESAR_PARENT, 
					 KOMERSIAL, OPERASI, TEKNIK, SDM, UMUM, 
					 LOGISTIK, SI, KEUANGAN
				FROM PEL_ANGGARAN.AKSES_ANGGARAN_DEPARTEMEN
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

    function selectByParamsBukuBesar($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT A.KD_BUKU_BESAR, B.NM_BUKU_BESAR
				FROM PEL_ANGGARAN.ANGGARAN_AKSES A INNER JOIN
                KBBR_BUKU_BESAR@KEUANGAN B ON A.KD_BUKU_BESAR = B.KD_BUKU_BESAR 
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
				GROUP BY A.KD_BUKU_BESAR, B.NM_BUKU_BESAR
				ORDER BY KD_BUKU_BESAR ASC ";
				
			
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsBukuPusat($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT A.KD_BUKU_PUSAT, B.NM_BUKU_BESAR
				FROM PEL_ANGGARAN.ANGGARAN_AKSES A INNER JOIN
                KBBR_BUKU_PUSAT@KEUANGAN B ON A.KD_BUKU_PUSAT = B.KD_BUKU_BESAR 
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
				GROUP BY A.KD_BUKU_PUSAT, B.NM_BUKU_BESAR
				ORDER BY KD_BUKU_PUSAT ASC ";
				
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
		
    function selectByParamsEntri($paramsArray=array(),$limit=-1,$from=-1, $statement="", $departemen_id="")
	{
		$str = "
				SELECT A.KD_BUKU_PUSAT, B.KD_BUKU_PUSAT KD_BUKU_PUSAT_AKSES, C.NM_BUKU_BESAR, PEL_ANGGARAN.AMBIL_BUKU_BESAR('".$departemen_id."', A.KD_BUKU_PUSAT) BB_GRUP
				FROM MAINTENANCE_ANGGARAN_TAHUNAN@KEUANGAN A
				LEFT JOIN PEL_ANGGARAN.ANGGARAN_AKSES B ON A.KD_BUKU_PUSAT = B.KD_BUKU_PUSAT AND B.DEPARTEMEN_ID = '".$departemen_id."'
				LEFT JOIN KBBR_BUKU_PUSAT@KEUANGAN C ON A.KD_BUKU_PUSAT = C.KD_BUKU_BESAR
				WHERE 1 = 1 AND SUBSTR(A.KD_BUKU_BESAR, 0, 1) > 7
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
				GROUP BY A.KD_BUKU_PUSAT, B.KD_BUKU_PUSAT, C.NM_BUKU_BESAR
				ORDER BY A.KD_BUKU_PUSAT ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCombo($paramsArray=array(),$limit=-1,$from=-1, $statement="", $departemen_id="", $tahun="")
	{
		$str = "
				SELECT A.KD_BUKU_BESAR, B.KD_BUKU_BESAR KD_BUKU_BESAR_AKSES, C.NM_BUKU_BESAR FROM MAINTENANCE_ANGGARAN_TAHUNAN@KEUANGAN A
				LEFT JOIN PEL_ANGGARAN.ANGGARAN_AKSES B ON A.KD_BUKU_BESAR = B.KD_BUKU_BESAR AND A.KD_BUKU_PUSAT = B.KD_BUKU_PUSAT AND B.DEPARTEMEN_ID = '".$departemen_id."' AND TAHUN = '".$tahun."'
				LEFT JOIN KBBR_BUKU_BESAR@KEUANGAN C ON A.KD_BUKU_BESAR = C.KD_BUKU_BESAR
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
						GROUP BY A.KD_BUKU_BESAR, B.KD_BUKU_BESAR, C.NM_BUKU_BESAR
						ORDER BY A.KD_BUKU_BESAR ";
						
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsComboUangMuka($paramsArray=array(),$limit=-1,$from=-1, $statement="", $departemen_id="", $tahun="")
	{
		$str = "
				SELECT A.KD_BUKU_BESAR, B.KD_BUKU_BESAR KD_BUKU_BESAR_AKSES, A.NM_BUKU_BESAR FROM KBBR_BUKU_BESAR@KEUANGAN A 
                LEFT JOIN PEL_ANGGARAN.ANGGARAN_AKSES B ON A.KD_BUKU_BESAR = B.KD_BUKU_BESAR AND B.DEPARTEMEN_ID = '".$departemen_id."' AND TAHUN = '".$tahun."'
			WHERE A.KD_BUKU_BESAR LIKE '109%' AND NOT A.KD_BUKU_BESAR = '109.00.00'  AND NOT A.NM_BUKU_BESAR LIKE '%TIDAK TERDEFINISI%'
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."
						ORDER BY A.KD_BUKU_BESAR ";
						
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsComboUangMukaSubBantu($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sub_bantu="", $tahun="")
	{
		$str = "
				SELECT A.KD_BUKU_BESAR, B.KD_BUKU_BESAR KD_BUKU_BESAR_AKSES, A.NM_BUKU_BESAR, B.KD_BUKU_BESAR_JRR FROM KBBR_BUKU_BESAR@KEUANGAN A 
                LEFT JOIN PEL_ANGGARAN.ANGGARAN_AKSES B ON A.KD_BUKU_BESAR = B.KD_BUKU_BESAR AND B.KD_SUB_BANTU = '".$sub_bantu."' AND TAHUN = '".$tahun."'
			WHERE A.KD_BUKU_BESAR LIKE '109%' AND NOT A.KD_BUKU_BESAR = '109.00.00'  AND NOT A.NM_BUKU_BESAR LIKE '%TIDAK TERDEFINISI%'
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."
						ORDER BY A.KD_BUKU_BESAR ";
						
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
				
    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT DEPARTEMEN_ID, PUSPEL, KODE_SUB_BANTU, NAMA, PPI_SIMPEG.AMBIL_PEGAWAI_DEPARTEMEN(DEPARTEMEN_ID) NAMA_USER FROM PPI_SIMPEG.DEPARTEMEN A 
				WHERE PUSPEL IS NOT NULL AND LENGTH(DEPARTEMEN_ID) <= 4 AND STATUS_AKTIF = 1 
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
				GROUP BY DEPARTEMEN_ID, KODE_SUB_BANTU, PUSPEL, NAMA
				ORDER BY DEPARTEMEN_ID ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT DEPARTEMEN_ID, KD_BUKU_PUSAT, KD_BUKU_BESAR
				FROM PEL_ANGGARAN.ANGGARAN_AKSES
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KD_BUKU_PUSAT ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(DEPARTEMEN_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_AKSES
		        WHERE DEPARTEMEN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(DEPARTEMEN_ID) AS ROWCOUNT FROM (SELECT DEPARTEMEN_ID, PUSPEL, NAMA FROM PPI_SIMPEG.DEPARTEMEN A 
							WHERE PUSPEL IS NOT NULL AND LENGTH(DEPARTEMEN_ID) <= 4 AND STATUS_AKTIF = 1 								
 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str.= " GROUP BY DEPARTEMEN_ID, PUSPEL, NAMA) A ";
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(DEPARTEMEN_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_AKSES
		        WHERE DEPARTEMEN_ID IS NOT NULL ".$statement; 
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