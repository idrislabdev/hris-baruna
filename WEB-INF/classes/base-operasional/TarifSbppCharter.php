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

  class TarifSbppCharter extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TarifSbppCharter()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TARIF_SBPP_CHARTER_ID", $this->getNextId("TARIF_SBPP_CHARTER_ID","PPI_OPERASIONAL.TARIF_SBPP_CHARTER"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.TARIF_SBPP_CHARTER (
				   TARIF_SBPP_CHARTER_ID, KAPAL_JENIS_ID, TAHUN_AWAL, 
				   TAHUN_AKHIR, JUMLAH,
				   LAST_CREATE_USER, LAST_CREATE_DATE, TARIF_SBPP_ID, JENIS_BAHAN, JENIS_PROPULSI, TIPE, POWER_AWAL, POWER_AKHIR) 
 			  	VALUES (
				  ".$this->getField("TARIF_SBPP_CHARTER_ID").",
				  '".$this->getField("KAPAL_JENIS_ID")."',
				  '".$this->getField("TAHUN_AWAL")."',
				  '".$this->getField("TAHUN_AKHIR")."',
				  '".$this->getField("JUMLAH")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("TARIF_SBPP_ID")."',
				  ".$this->getField("JENIS_BAHAN").",
				  ".$this->getField("JENIS_PROPULSI").",
				  ".$this->getField("TIPE").",
				  ".$this->getField("POWER_AWAL").",
				  ".$this->getField("POWER_AKHIR")."
				)"; 
		$this->query = $str;
		$this->id = $this->getField("TARIF_SBPP_CHARTER_ID");
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.TARIF_SBPP_CHARTER
				SET    
					   KAPAL_JENIS_ID   = '".$this->getField("KAPAL_JENIS_ID")."',
					   TAHUN_AWAL       = '".$this->getField("TAHUN_AWAL")."',
					   TAHUN_AKHIR      = '".$this->getField("TAHUN_AKHIR")."',
					   JUMLAH         	= '".$this->getField("JUMLAH")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE").",
					   TARIF_SBPP_ID	= '".$this->getField("TARIF_SBPP_ID")."',
					   JENIS_BAHAN	= '".$this->getField("JENIS_BAHAN")."',
					   JENIS_PROPULSI	= '".$this->getField("JENIS_PROPULSI")."',
						POWER_AWAL	= '".$this->getField("POWER_AWAL")."',
						POWER_AKHIR	= '".$this->getField("POWER_AKHIR")."'
				WHERE  TARIF_SBPP_CHARTER_ID  	= '".$this->getField("TARIF_SBPP_CHARTER_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.TARIF_SBPP_CHARTER
                WHERE 
                  TARIF_SBPP_CHARTER_ID = ".$this->getField("TARIF_SBPP_CHARTER_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY TARIF_SBPP_CHARTER_ID ASC")
	{
		$str = "
				SELECT 
                   TARIF_SBPP_CHARTER_ID, A.KAPAL_JENIS_ID, TAHUN_AWAL, 
                   TAHUN_AKHIR, JUMLAH, TARIF_SBPP_ID,
                   (SELECT X.NAMA FROM PPI_OPERASIONAL.KAPAL_JENIS X WHERE X.KAPAL_JENIS_ID = A.KAPAL_JENIS_ID) KAPAL_JENIS, JENIS_BAHAN, JENIS_PROPULSI, B.NAMA NAMA_JENIS_BAHAN,
                   C.NAMA NAMA_JENIS_PROPULSI, POWER_AWAL, POWER_AKHIR
                FROM PPI_OPERASIONAL.TARIF_SBPP_CHARTER A LEFT JOIN PPI_OPERASIONAL.KAPAL_ITEM_JENIS B ON (A.JENIS_BAHAN = B.ID_ITEM AND B.JENIS = 'BAHAN')
                LEFT JOIN PPI_OPERASIONAL.KAPAL_ITEM_JENIS C ON (A.JENIS_PROPULSI = C.ID_ITEM AND C.JENIS = 'PROPULSI')
                WHERE TARIF_SBPP_CHARTER_ID IS NOT NULL
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
				   TARIF_SBPP_CHARTER_ID, A.KAPAL_JENIS_ID, TAHUN_AWAL, 
				   TAHUN_AKHIR, JUMLAH, 
				   (SELECT X.NAMA FROM PPI_OPERASIONAL.KAPAL_JENIS X WHERE X.KAPAL_JENIS_ID = A.KAPAL_JENIS_ID) KAPAL_JENIS
				FROM PPI_OPERASIONAL.TARIF_SBPP_CHARTER A
				WHERE TARIF_SBPP_CHARTER_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY TARIF_SBPP_CHARTER_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(TARIF_SBPP_CHARTER_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.TARIF_SBPP_CHARTER
		        WHERE TARIF_SBPP_CHARTER_ID IS NOT NULL ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(TARIF_SBPP_CHARTER_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.TARIF_SBPP_CHARTER
		        WHERE TARIF_SBPP_CHARTER_ID IS NOT NULL ".$statement; 
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