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

  class AnggaranMutasiDetil extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AnggaranMutasiDetil()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ANGGARAN_MUTASI_DETIL_ID", $this->getNextId("ANGGARAN_MUTASI_DETIL_ID","PEL_ANGGARAN.ANGGARAN_MUTASI_DETIL")); 
		$str = "
				INSERT INTO PEL_ANGGARAN.ANGGARAN_MUTASI_DETIL (
				   ANGGARAN_MUTASI_DETIL_ID, ANGGARAN_MUTASI_ID, NAMA, UNIT, HARGA_SATUAN, JUMLAH, STATUS_VERIFIKASI) 
				VALUES(
					  ".$this->getField("ANGGARAN_MUTASI_DETIL_ID").",
					  '".$this->getField("ANGGARAN_MUTASI_ID")."',
					  '".$this->getField("NAMA")."',
					  '".$this->getField("UNIT")."',
					  '".$this->getField("HARGA_SATUAN")."',
					  '".$this->getField("JUMLAH")."',
					  '".$this->getField("STATUS_VERIFIKASI")."'
				)"; 
		$this->id = $this->getField("ANGGARAN_MUTASI_DETIL_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI_DETIL
			   SET ANGGARAN_MUTASI_ID         = '".$this->getField("ANGGARAN_MUTASI_ID")."',
				   NAMA	= '".$this->getField("NAMA")."',
				   UNIT= '".$this->getField("UNIT")."',
				   JUMLAH= '".$this->getField("JUMLAH")."',
				   HARGA_SATUAN= '".$this->getField("HARGA_SATUAN")."',
				   STATUS_VERIFIKASI= '".$this->getField("STATUS_VERIFIKASI")."'
			 WHERE ANGGARAN_MUTASI_DETIL_ID = ".$this->getField("ANGGARAN_MUTASI_DETIL_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateStatus()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI_DETIL
			   SET STATUS_VERIFIKASI= '".$this->getField("STATUS_VERIFIKASI")."'
			 WHERE ANGGARAN_MUTASI_DETIL_ID = ".$this->getField("ANGGARAN_MUTASI_DETIL_ID")."
 				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PEL_ANGGARAN.ANGGARAN_MUTASI_DETIL
                WHERE 
                  ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID").""; 
				  
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
				ANGGARAN_MUTASI_DETIL_ID, ANGGARAN_MUTASI_ID, NAMA, UNIT, JUMLAH, HARGA_SATUAN, STATUS_VERIFIKASI, 
				DECODE(STATUS_VERIFIKASI, 1, 'SETUJU', DECODE(STATUS_VERIFIKASI, 2, 'TIDAK SETUJU', 'PERMOHONAN')) VERIFIKASI
				FROM PEL_ANGGARAN.ANGGARAN_MUTASI_DETIL
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
				ANGGARAN_MUTASI_DETIL_ID, ANGGARAN_MUTASI_ID, NAMA, UNIT, JUMLAH, HARGA_SATUAN, STATUS_VERIFIKASI
				FROM PEL_ANGGARAN.ANGGARAN_MUTASI_DETIL
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY ANGGARAN_MUTASI_DETIL_ID DESC";
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
		$str = "SELECT COUNT(ANGGARAN_MUTASI_DETIL_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_MUTASI_DETIL WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(ANGGARAN_MUTASI_DETIL_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_MUTASI_DETIL WHERE 1 = 1 "; 
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