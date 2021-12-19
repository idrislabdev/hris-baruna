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
  * Entity-base class untuk mengimplementasikan tabel DEPARTEMEN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Departemen extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Departemen()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_SIMPEG.DEPARTEMEN (
				   DEPARTEMEN_ID, NAMA, CABANG_ID, DEPARTEMEN_PARENT_ID, KETERANGAN, PUSPEL, STATUS_AKTIF, TMT_AKTIF, TMT_NON_AKTIF, KODE_SUB_BANTU,
				   	KODE_BB_PANGKAL, KODE_BB_SPP, KODE_BB_KEGIATAN, KODE_BP_PANGKAL,
				   	KODE_BP_SPP, KODE_BP_KEGIATAN, KATEGORI_SEKOLAH
				   ) 
 			  	VALUES (
				  PPI_SIMPEG.DEPARTEMEN_ID_GENERATE('".$this->getField("DEPARTEMEN_ID")."'),
				  '".$this->getField("NAMA")."',
				  '".$this->getField("CABANG_ID")."',
				  '".$this->getField("DEPARTEMEN_PARENT_ID")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("PUSPEL")."',
				  '".$this->getField("STATUS_AKTIF")."',
				  ".$this->getField("TMT_AKTIF").",
				  ".$this->getField("TMT_NON_AKTIF").",
				  '".$this->getField("KODE_SUB_BANTU")."',
				  '".$this->getField("KODE_BB_PANGKAL")."',
				  '".$this->getField("KODE_BB_SPP")."',
				  '".$this->getField("KODE_BB_KEGIATAN")."',
				  '".$this->getField("KODE_BP_PANGKAL")."',
				  '".$this->getField("KODE_BP_SPP")."',
				  '".$this->getField("KODE_BP_KEGIATAN")."',
				  '".$this->getField("KATEGORI_SEKOLAH")."'
				)"; 
		$this->id = $this->getField("DEPARTEMEN_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.DEPARTEMEN
				SET    
					   NAMA           	= '".$this->getField("NAMA")."',
					   KETERANGAN       = '".$this->getField("KETERANGAN")."',
					   PUSPEL         	= '".$this->getField("PUSPEL")."',
					   STATUS_AKTIF     = '".$this->getField("STATUS_AKTIF")."',
					   TMT_AKTIF     	= ".$this->getField("TMT_AKTIF").",
					   TMT_NON_AKTIF    = ".$this->getField("TMT_NON_AKTIF").",
					   KODE_SUB_BANTU	= '".$this->getField("KODE_SUB_BANTU")."',
				  	   KODE_BB_PANGKAL 	= '".$this->getField("KODE_BB_PANGKAL")."',
				       KODE_BB_SPP 		= '".$this->getField("KODE_BB_SPP")."',
				  	KODE_BB_KEGIATAN 	= '".$this->getField("KODE_BB_KEGIATAN")."',
				  	KODE_BP_PANGKAL 	= '".$this->getField("KODE_BP_PANGKAL")."',
				  	KODE_BP_SPP 		= '".$this->getField("KODE_BP_SPP")."',
				  	KODE_BP_KEGIATAN 	= '".$this->getField("KODE_BP_KEGIATAN")."',
				  	KATEGORI_SEKOLAH 	= '".$this->getField("KATEGORI_SEKOLAH")."'
				WHERE  DEPARTEMEN_ID	= '".$this->getField("DEPARTEMEN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateStatus()
	{
		$str = "
				UPDATE PPI_SIMPEG.DEPARTEMEN
				SET    
					   STATUS_AKTIF     = '".$this->getField("STATUS_AKTIF")."'
				WHERE  DEPARTEMEN_ID	= '".$this->getField("DEPARTEMEN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }	
	
	function updateJumlahStaff()
	{
		$str = "
				UPDATE PPI_SIMPEG.DEPARTEMEN
				SET    
					   JUMLAH_STAFF     = '".$this->getField("JUMLAH_STAFF")."'
				WHERE  DEPARTEMEN_ID	= '".$this->getField("DEPARTEMEN_ID")."'
			 "; 
		$this->query = $str;
		
		return $this->execQuery($str);		
	}
	
	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.DEPARTEMEN
                WHERE 
                  DEPARTEMEN_ID = ".$this->getField("DEPARTEMEN_ID").""; 
				  
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
				SELECT 
				DEPARTEMEN_ID, CABANG_ID, NAMA, DEPARTEMEN_PARENT_ID, KETERANGAN, PUSPEL, STATUS_AKTIF, TMT_AKTIF, TMT_NON_AKTIF, JUMLAH_STAFF, KODE_SUB_BANTU,
					KODE_BB_PANGKAL, KODE_BB_SPP, KODE_BB_KEGIATAN, KODE_BP_PANGKAL,
				   	KODE_BP_SPP, KODE_BP_KEGIATAN, KATEGORI_SEKOLAH
				FROM PPI_SIMPEG.DEPARTEMEN
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str . " ORDER BY NAMA ";
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsImport($paramsArray=array(),$limit=-1,$from=-1, $statement="",$order ="ORDER BY DEPARTEMEN_ID")
	{
		$str = "
				SELECT 
				DEPARTEMEN_ID, CABANG_ID, NAMA, DEPARTEMEN_PARENT_ID, KETERANGAN, PUSPEL, STATUS_AKTIF, TMT_AKTIF, TMT_NON_AKTIF, JUMLAH_STAFF, KODE_SUB_BANTU,
					KODE_BB_PANGKAL, KODE_BB_SPP, KODE_BB_KEGIATAN, KODE_BP_PANGKAL,
				   	KODE_BP_SPP, KODE_BP_KEGIATAN, KATEGORI_SEKOLAH
				FROM PPI_SIMPEG.DEPARTEMEN
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$order;
		$this->query = $str . " ORDER BY DEPARTEMEN_ID ";
		// echo $str;exit();
		return $this->selectLimit($str,$limit,$from); 
    }
	

    function selectByParamsDepartemenHasilRapat($paramsArray=array(),$limit=-1,$from=-1, $statement="", $hasil_rapat_id="")
	{
		$str = "
				SELECT 
					A.DEPARTEMEN_ID, CABANG_ID, NAMA, DEPARTEMEN_PARENT_ID, KETERANGAN, PUSPEL, B.DEPARTEMEN_ID DEPARTEMEN_ID_HASIL_RAPAT,
					KODE_BB_PANGKAL, KODE_BB_SPP, KODE_BB_KEGIATAN, KODE_BP_PANGKAL,
				   	KODE_BP_SPP, KODE_BP_KEGIATAN, KATEGORI_SEKOLAH
				FROM PPI_SIMPEG.DEPARTEMEN A LEFT JOIN HASIL_RAPAT_DEPARTEMEN B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID AND B.HASIL_RAPAT_ID = '".$hasil_rapat_id."'
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsDepartemenDokumen($paramsArray=array(),$limit=-1,$from=-1, $statement="", $dokumen_id="")
	{
		$str = "
				SELECT 
				A.DEPARTEMEN_ID, CABANG_ID, NAMA, DEPARTEMEN_PARENT_ID, KETERANGAN, PUSPEL, B.DEPARTEMEN_ID DEPARTEMEN_ID_DOKUMEN,
					KODE_BB_PANGKAL, KODE_BB_SPP, KODE_BB_KEGIATAN, KODE_BP_PANGKAL,
				   	KODE_BP_SPP, KODE_BP_KEGIATAN, KATEGORI_SEKOLAH
				FROM PPI_SIMPEG.DEPARTEMEN A LEFT JOIN PEL_HUKUM.DOKUMEN_DEPARTEMEN B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID AND B.DOKUMEN_ID = '".$dokumen_id."'
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT DEPARTEMEN_ID, NAMA, CABANG_ID, DEPARTEMEN_PARENT_ID, KETERANGAN,
						KATEGORI_SEKOLAH
				FROM PPI_SIMPEG.DEPARTEMEN
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
		$str = "SELECT COUNT(DEPARTEMEN_ID) AS ROWCOUNT FROM PPI_SIMPEG.DEPARTEMEN
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

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(DEPARTEMEN_ID) AS ROWCOUNT FROM PPI_SIMPEG.DEPARTEMEN
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