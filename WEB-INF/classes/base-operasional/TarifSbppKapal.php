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
  * Entity-base class untuk mengimplementasikan tabel KRU_JABATAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class TarifSbppKapal extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TarifSbppKapal()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TARIF_SBPP_KAPAL_ID", $this->getNextId("TARIF_SBPP_KAPAL_ID","PPI_OPERASIONAL.TARIF_SBPP_KAPAL"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.TARIF_SBPP_KAPAL (
				   TARIF_SBPP_KAPAL_ID, TARIF_SBPP_ID, KAPAL_ID, 
				   JUMLAH) 
 			  	VALUES (
				  ".$this->getField("TARIF_SBPP_KAPAL_ID").",
				  '".$this->getField("TARIF_SBPP_ID")."',
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("JUMLAH")."'
				)"; 
		$this->id=$this->getField("TARIF_SBPP_KAPAL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.TARIF_SBPP_KAPAL
				SET    
					   TARIF_SBPP_ID	= '".$this->getField("TARIF_SBPP_ID")."',
					   KAPAL_ID	 		= '".$this->getField("KAPAL_ID")."',
					   JUMLAH			= '".$this->getField("JUMLAH")."'
				WHERE  TARIF_SBPP_KAPAL_ID  	= '".$this->getField("TARIF_SBPP_KAPAL_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.TARIF_SBPP_KAPAL
                WHERE 
                  TARIF_SBPP_ID = '".$this->getField("TARIF_SBPP_ID")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY TARIF_SBPP_KAPAL_ID ASC")
	{
		$str = "
				SELECT 
				TARIF_SBPP_KAPAL_ID, TARIF_SBPP_ID, KAPAL_ID, 
				   JUMLAH
				FROM PPI_OPERASIONAL.TARIF_SBPP_KAPAL					
				WHERE TARIF_SBPP_KAPAL_ID IS NOT NULL
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
				TARIF_SBPP_KAPAL_ID, TARIF_SBPP_ID, KAPAL_ID, 
				   JUMLAH
				FROM PPI_OPERASIONAL.TARIF_SBPP_KAPAL					
				WHERE TARIF_SBPP_KAPAL_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY TARIF_SBPP_KAPAL_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(TARIF_SBPP_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.TARIF_SBPP_KAPAL
		        WHERE TARIF_SBPP_KAPAL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(TARIF_SBPP_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.TARIF_SBPP_KAPAL
		        WHERE TARIF_SBPP_KAPAL_ID IS NOT NULL ".$statement; 
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