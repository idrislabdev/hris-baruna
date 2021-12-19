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
  * Entity-base class untuk mengimplementasikan tabel TRANSAKSI_TIPE.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class TransaksiTipe extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TransaksiTipe()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TRANSAKSI_TIPE_ID", $this->getNextId("TRANSAKSI_TIPE_ID","IMASYS_KEUANGAN.TRANSAKSI_TIPE")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO IMASYS_KEUANGAN.TRANSAKSI_TIPE (
				   TRANSAKSI_TIPE_ID, MODUL_ID, JURNAL_ID, 
				   KODE, NAMA, KETERANGAN, 
				   AUTO_MANUAL, STATUS_POSTING_JURNAL, STATUS_CONTRA_JURNAL, 
				   STATUS_CLOSING_JURNAL, STATUS_PAJAK, KODE_PAJAK1, 
				   KODE_PAJAK2, KODE_BUKU_BESAR_LABA, KODE_BUKU_BESAR_RUGI, 
				   KODE_BUKU_BESAR_LABA_RUGI, STATUS, STATUS_MATERAI, 
				   LAST_UPDATE_DATE, LAST_UPDATE_BY) 
				VALUES ( ".$this->getField("TRANSAKSI_TIPE_ID").", '".$this->getField("MODUL_ID")."', '".$this->getField("JURNAL_ID")."',
					'".$this->getField("KODE")."', '".$this->getField("NAMA")."', '".$this->getField("KETERANGAN")."',
					'".$this->getField("AUTO_MANUAL")."', '".$this->getField("STATUS_POSTING_JURNAL")."', '".$this->getField("STATUS_CONTRA_JURNAL")."',
					'".$this->getField("STATUS_CLOSING_JURNAL")."', '".$this->getField("STATUS_PAJAK")."', '".$this->getField("KODE_PAJAK1")."',
					'".$this->getField("KODE_PAJAK2")."', '".$this->getField("KODE_BUKU_BESAR_LABA")."', '".$this->getField("KODE_BUKU_BESAR_RUGI")."',
					'".$this->getField("KODE_BUKU_BESAR_LABA_RUGI")."', '".$this->getField("STATUS")."', '".$this->getField("STATUS_MATERAI")."',
					".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATE_BY")."'
				)";
				
				
		$this->id = $this->getField("TRANSAKSI_TIPE_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				
				UPDATE IMASYS_KEUANGAN.TRANSAKSI_TIPE
				SET    
					   MODUL_ID                  = '".$this->getField("MODUL_ID")."',
					   JURNAL_ID                 = '".$this->getField("JURNAL_ID")."',
					   KODE                      = '".$this->getField("KODE")."',
					   NAMA                      = '".$this->getField("NAMA")."',
					   KETERANGAN                = '".$this->getField("KETERANGAN")."',
					   AUTO_MANUAL               = '".$this->getField("AUTO_MANUAL")."',
					   STATUS_POSTING_JURNAL     = '".$this->getField("STATUS_POSTING_JURNAL")."',
					   STATUS_CONTRA_JURNAL      = '".$this->getField("STATUS_CONTRA_JURNAL")."',
					   STATUS_CLOSING_JURNAL     = '".$this->getField("STATUS_CLOSING_JURNAL")."',
					   STATUS_PAJAK              = '".$this->getField("STATUS_PAJAK")."',
					   KODE_PAJAK1               = '".$this->getField("KODE_PAJAK1")."',
					   KODE_PAJAK2               = '".$this->getField("KODE_PAJAK2")."',
					   KODE_BUKU_BESAR_LABA      = '".$this->getField("KODE_BUKU_BESAR_LABA")."',
					   KODE_BUKU_BESAR_RUGI      = '".$this->getField("KODE_BUKU_BESAR_RUGI")."',
					   KODE_BUKU_BESAR_LABA_RUGI = '".$this->getField("KODE_BUKU_BESAR_LABA_RUGI")."',
					   STATUS                    = '".$this->getField("STATUS")."',
					   STATUS_MATERAI            = '".$this->getField("STATUS_MATERAI")."',
					   LAST_UPDATE_DATE          = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATE_BY            = '".$this->getField("LAST_UPDATE_BY")."'
				WHERE  TRANSAKSI_TIPE_ID 		 = '".$this->getField("TRANSAKSI_TIPE_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM IMASYS_KEUANGAN.TRANSAKSI_TIPE
                WHERE 
                  TRANSAKSI_TIPE_ID = ".$this->getField("TRANSAKSI_TIPE_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY TRANSAKSI_TIPE_ID ASC")
	{
		$str = "
				SELECT 
				TRANSAKSI_TIPE_ID, A.MODUL_ID, A.JURNAL_ID, A.KODE, A.NAMA, A.KETERANGAN, AUTO_MANUAL, STATUS_POSTING_JURNAL, STATUS_CONTRA_JURNAL, 
				STATUS_CLOSING_JURNAL, STATUS_PAJAK, KODE_PAJAK1, KODE_PAJAK2, KODE_BUKU_BESAR_LABA, KODE_BUKU_BESAR_RUGI, 
				KODE_BUKU_BESAR_LABA_RUGI, STATUS, STATUS_MATERAI, A.LAST_UPDATE_DATE, A.LAST_UPDATE_BY
				FROM IMASYS_KEUANGAN.TRANSAKSI_TIPE A
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
				SELECT TRANSAKSI_TIPE_ID, MODUL_ID, JURNAL_ID, 
				KODE, NAMA, KETERANGAN, 
				AUTO_MANUAL, STATUS_POSTING_JURNAL, STATUS_CONTRA_JURNAL, 
				STATUS_CLOSING_JURNAL, STATUS_PAJAK, KODE_PAJAK1, 
				KODE_PAJAK2, KODE_BUKU_BESAR_LABA, KODE_BUKU_BESAR_RUGI, 
				KODE_BUKU_BESAR_LABA_RUGI, STATUS, STATUS_MATERAI, 
				LAST_UPDATE_DATE, LAST_UPDATE_BY
				FROM IMASYS_KEUANGAN.TRANSAKSI_TIPE
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
		$str = "SELECT COUNT(TRANSAKSI_TIPE_ID) AS ROWCOUNT FROM IMASYS_KEUANGAN.TRANSAKSI_TIPE
		        WHERE TRANSAKSI_TIPE_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(TRANSAKSI_TIPE_ID) AS ROWCOUNT FROM IMASYS_KEUANGAN.TRANSAKSI_TIPE
		        WHERE TRANSAKSI_TIPE_ID IS NOT NULL ".$statement; 
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