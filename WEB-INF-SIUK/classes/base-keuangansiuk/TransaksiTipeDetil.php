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
  * Entity-base class untuk mengimplementasikan tabel TRANSAKSI_TIPE_DETIL.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class TransaksiTipeDetil extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TransaksiTipeDetil()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TRANSAKSI_TIPE_DETIL_ID", $this->getNextId("TRANSAKSI_TIPE_DETIL_ID","IMASYS_KEUANGAN.TRANSAKSI_TIPE_DETIL")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
		
				INSERT INTO IMASYS_KEUANGAN.TRANSAKSI_TIPE_DETIL (
				   TRANSAKSI_TIPE_DETIL_ID, TRANSAKSI_TIPE_ID, NAMA, 
				   KETERANGAN, KODE_BUKU_BESAR1, KODE_BUKU_BESAR2, 
				   KODE_BUKU_BESAR3, STATUS, STATUS_PAJAK, 
				   STATUS_JURNAL, LAST_UPDATE_DATE, LAST_UPDATE_BY) 
				VALUES ( ".$this->getField("TRANSAKSI_TIPE_DETIL_ID").", '".$this->getField("TRANSAKSI_TIPE_ID")."', '".$this->getField("NAMA")."',
					'".$this->getField("KETERANGAN")."', '".$this->getField("KODE_BUKU_BESAR1")."', '".$this->getField("KODE_BUKU_BESAR2")."',
					'".$this->getField("KODE_BUKU_BESAR3")."', '".$this->getField("STATUS")."', '".$this->getField("STATUS_PAJAK")."',
					'".$this->getField("STATUS_JURNAL")."', ".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATE_BY")."'
				)";
				
				
		$this->id = $this->getField("TRANSAKSI_TIPE_DETIL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "				
				UPDATE IMASYS_KEUANGAN.TRANSAKSI_TIPE_DETIL
				SET    
					   TRANSAKSI_TIPE_ID       = '".$this->getField("TRANSAKSI_TIPE_ID")."',
					   NAMA                    = '".$this->getField("NAMA")."',
					   KETERANGAN              = '".$this->getField("KETERANGAN")."',
					   KODE_BUKU_BESAR1        = '".$this->getField("KODE_BUKU_BESAR1")."',
					   KODE_BUKU_BESAR2        = '".$this->getField("KODE_BUKU_BESAR2")."',
					   KODE_BUKU_BESAR3        = '".$this->getField("KODE_BUKU_BESAR3")."',
					   STATUS                  = '".$this->getField("STATUS")."',
					   STATUS_PAJAK            = '".$this->getField("STATUS_PAJAK")."',
					   STATUS_JURNAL           = '".$this->getField("STATUS_JURNAL")."',
					   LAST_UPDATE_DATE        = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATE_BY          = '".$this->getField("LAST_UPDATE_BY")."'
				WHERE  TRANSAKSI_TIPE_DETIL_ID = '".$this->getField("TRANSAKSI_TIPE_DETIL_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM IMASYS_KEUANGAN.TRANSAKSI_TIPE_DETIL
                WHERE 
                  TRANSAKSI_TIPE_DETIL_ID = ".$this->getField("TRANSAKSI_TIPE_DETIL_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY TRANSAKSI_TIPE_DETIL_ID ASC")
	{
		$str = "
				SELECT TRANSAKSI_TIPE_DETIL_ID, A.TRANSAKSI_TIPE_ID, NAMA, KETERANGAN, KODE_BUKU_BESAR1, KODE_BUKU_BESAR2, KODE_BUKU_BESAR3, STATUS, STATUS_PAJAK, STATUS_JURNAL, LAST_UPDATE_DATE, LAST_UPDATE_BY
				FROM IMASYS_KEUANGAN.TRANSAKSI_TIPE_DETIL A
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT TRANSAKSI_TIPE_DETIL_ID, TRANSAKSI_TIPE_ID, NAMA, 
			    KETERANGAN, KODE_BUKU_BESAR1, KODE_BUKU_BESAR2, 
				KODE_BUKU_BESAR3, STATUS, STATUS_PAJAK, 
				STATUS_JURNAL, LAST_UPDATE_DATE, LAST_UPDATE_BY
				FROM IMASYS_KEUANGAN.TRANSAKSI_TIPE_DETIL
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
		$str = "SELECT COUNT(TRANSAKSI_TIPE_DETIL_ID) AS ROWCOUNT FROM IMASYS_KEUANGAN.TRANSAKSI_TIPE_DETIL
		        WHERE TRANSAKSI_TIPE_DETIL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(TRANSAKSI_TIPE_DETIL_ID) AS ROWCOUNT FROM IMASYS_KEUANGAN.TRANSAKSI_TIPE_DETIL
		        WHERE TRANSAKSI_TIPE_DETIL_ID IS NOT NULL ".$statement; 
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