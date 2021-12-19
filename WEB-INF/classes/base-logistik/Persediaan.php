<? 
/* *******************************************************************************************************
MODUL NAME 			: PPI
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel KAPAL_JENIS.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Persediaan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Persediaan()
	{
      $this->Entity(); 
    }
	/*
	function insert()
	{*/
		/*Auto-generate primary key(s) by next max value (integer) */
/*		$this->setField("KAPAL_JENIS_ID", $this->getNextId("KAPAL_JENIS_ID","PPI_OPERASIONAL.KAPAL_JENIS"));

		$str = "
					INSERT INTO PPI_OPERASIONAL.KAPAL_JENIS (
					   KAPAL_JENIS_ID, NAMA, KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE)
 			  	VALUES (
				  ".$this->getField("KAPAL_JENIS_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id=$this->getField("KAPAL_JENIS_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
*/
/*
    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_JENIS
				SET    
					   NAMA         	= '".$this->getField("NAMA")."',
					   KETERANGAN	 	= '".$this->getField("KETERANGAN")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  KAPAL_JENIS_ID  	= '".$this->getField("KAPAL_JENIS_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_JENIS
                WHERE 
                  KAPAL_JENIS_ID = ".$this->getField("KAPAL_JENIS_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
*/
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectDaftarPermintaanKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ")
	{
		$str = "
					SELECT rownum ID, TO_CHAR(transfer_date, 'DD-MM-YYYY') TANGGAL, kd_buku_besar, stock_type, stock_name, qty, unit_type, unit_price, qty * unit_price total_biaya 
					FROM V_MON_PERMINTAAN_SPAREPART@conpms
					WHERE 0=0 
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
//		echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
    }

    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(TRANS_NO) AS ROWCOUNT FROM V_MON_PERMINTAAN_SPAREPART@conpms
		        WHERE TRANS_NO IS NOT NULL ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;exit;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(TRANS_NO) AS ROWCOUNT FROM V_MON_PERMINTAAN_SPAREPART@conpms
		        WHERE TRANS_NO IS NOT NULL ".$statement; 
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