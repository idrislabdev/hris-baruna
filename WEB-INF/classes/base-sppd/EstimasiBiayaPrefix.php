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
  * Entity-base class untuk mengimplementasikan tabel PANGKAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class EstimasiBiayaPrefix extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function EstimasiBiayaPrefix()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("SPPD_ID", $this->getNextId("SPPD_ID","PPI_SPPD.ESTIMASI_BIAYA_PREFIX"));
		$str = "
				INSERT INTO PPI_SPPD.ESTIMASI_BIAYA_PREFIX (
					SPPD_ID, PREFIX, PROSENTASE) 
				VALUES (
				  '".$this->getField("SPPD_ID")."',
				  '".$this->getField("PREFIX")."',
				  '".$this->getField("PROSENTASE")."'
				)"; 
				
		$this->id = $this->getField("SPPD_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.ESTIMASI_BIAYA_PREFIX WHERE SPPD_ID = '".$this->getField("SPPD_ID")."' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

  } 
?>