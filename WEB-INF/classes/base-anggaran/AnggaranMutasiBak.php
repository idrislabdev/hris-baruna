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

  class AnggaranMutasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AnggaranMutasi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ANGGARAN_MUTASI_ID", $this->getNextId("ANGGARAN_MUTASI_ID","PEL_ANGGARAN.ANGGARAN_MUTASI")); 
		$str = "
				INSERT INTO PEL_ANGGARAN.ANGGARAN_MUTASI (
				   ANGGARAN_MUTASI_ID, ANGGARAN_ID, PERIODE, TANGGAL, JUMLAH, PPH, TOTAL, STATUS_VERIFIKASI) 
				VALUES(
					  ".$this->getField("ANGGARAN_MUTASI_ID").",
					  '".$this->getField("ANGGARAN_ID")."',
					  '".$this->getField("PERIODE")."',
					  ".$this->getField("TANGGAL").",
					  '".$this->getField("JUMLAH")."',
					  '".$this->getField("PPH")."',
					  '".$this->getField("TOTAL")."',
					  '".$this->getField("STATUS_VERIFIKASI")."'
				)"; 
		$this->id = $this->getField("ANGGARAN_MUTASI_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET ANGGARAN_ID         = '".$this->getField("ANGGARAN_ID")."',
				   TANGGAL= ".$this->getField("TANGGAL").",
				   PPH= '".$this->getField("PPH")."',
				   JUMLAH= '".$this->getField("JUMLAH")."',
				   TOTAL= '".$this->getField("TOTAL")."',
				   STATUS_VERIFIKASI= '".$this->getField("STATUS_VERIFIKASI")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateStatus()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET STATUS_VERIFIKASI= '".$this->getField("STATUS_VERIFIKASI")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PEL_ANGGARAN.ANGGARAN_MUTASI
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
				ANGGARAN_MUTASI_ID, NO_NOTA, A.PEGAWAI_ID, 
				   THN_BUKU, BLN_BUKU, TGL_TRANS, BLN_BUKU || ' ' || THN_BUKU  PERIODE,
				   TGL_ENTRY, KD_VALUTA, TGL_VALUTA, 
				   KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
				   KET_TAMBAH, NO_POSTING, TGL_POSTING, 
				   JML_CETAK, A.LAST_UPDATE_DATE, A.LAST_UPDATED_BY, 
				   PROGRAM_NAME, B.NAMA PEGAWAI, B.NRP, C.NAMA JABATAN 
				FROM PEL_ANGGARAN.ANGGARAN_MUTASI A 
					INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
					INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
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
				ANGGARAN_MUTASI_ID, ANGGARAN_ID, PERIODE, TANGGAL, PPH, JUMLAH, TOTAL, STATUS_VERIFIKASI
				FROM PEL_ANGGARAN.ANGGARAN_MUTASI
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY ANGGARAN_MUTASI_ID DESC";
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
		$str = "SELECT COUNT(ANGGARAN_MUTASI_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_MUTASI  A
                INNER JOIN PEL_ANGGARAN.ANGGARAN B ON B.ANGGARAN_ID=A.ANGGARAN_ID
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
		$str = "SELECT COUNT(ANGGARAN_MUTASI_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_MUTASI WHERE 1 = 1 "; 
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