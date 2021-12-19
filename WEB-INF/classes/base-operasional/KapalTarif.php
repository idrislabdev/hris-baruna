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

  class KapalTarif extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalTarif()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_TARIF_ID", $this->getNextId("KAPAL_TARIF_ID","PPI_OPERASIONAL.KAPAL_TARIF"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_TARIF (
				   KAPAL_TARIF_ID, KAPAL_ID, JUMLAH, 
				   TMT_TARIF, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("KAPAL_TARIF_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("JUMLAH")."',
				  ".$this->getField("TMT_TARIF").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("KAPAL_TARIF_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_TARIF
				SET    
					   KAPAL_ID     	= '".$this->getField("KAPAL_ID")."',
					   JUMLAH	 		= '".$this->getField("JUMLAH")."',
					   TMT_TARIF		= ".$this->getField("TMT_TARIF").",
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  KAPAL_TARIF_ID  	= '".$this->getField("KAPAL_TARIF_ID")."'
			 "; 
		$this->query = $str;
		echo $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_TARIF
                WHERE 
                  KAPAL_TARIF_ID = ".$this->getField("KAPAL_TARIF_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_TARIF_ID ASC")
	{
		$str = "
				  SELECT KAPAL_TARIF_ID, KAPAL_ID, JUMLAH, TMT_TARIF
				  FROM PPI_OPERASIONAL.KAPAL_TARIF				  
				  WHERE KAPAL_TARIF_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsTarif($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY D.TANGGAL_SK ASC")
	{
		$str = "
				  SELECT D.TANGGAL_SK, D.NO_SK, NVL(MESIN_DAYA, 0) * NVL(C.NAMA, 0) * JUMLAH JUMLAH FROM PPI_OPERASIONAL.TARIF_SBPP_CHARTER A 
					INNER JOIN PPI_OPERASIONAL.KAPAL B ON NVL(TAHUN_BANGUN, 1901) BETWEEN NVL(TAHUN_AWAL, 1900) AND NVL(TAHUN_AKHIR, TO_NUMBER(TO_CHAR(SYSDATE, 'YYYY'))) AND A.KAPAL_JENIS_ID = B.KAPAL_JENIS_ID AND A.JENIS_PROPULSI = B.JENIS_PROPULSI 
					INNER JOIN PPI_OPERASIONAL.HORSE_POWER C ON B.HORSE_POWER_ID = C.HORSE_POWER_ID
					INNER JOIN PPI_OPERASIONAL.TARIF_SBPP D ON A.TARIF_SBPP_ID = D.TARIF_SBPP_ID
					WHERE 1 = 1 AND  C.NAMA BETWEEN POWER_AWAL AND POWER_AKHIR
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
				  SELECT KAPAL_TARIF_ID, KAPAL_ID, JUMLAH, TMT_TARIF
				  FROM PPI_OPERASIONAL.KAPAL_TARIF				  
				  WHERE KAPAL_TARIF_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_TARIF_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_TARIF_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_TARIF
		        WHERE KAPAL_TARIF_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_TARIF_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_TARIF
		        WHERE KAPAL_TARIF_ID IS NOT NULL ".$statement; 
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