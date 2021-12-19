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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_PROSEN_PAJAK.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class DynamicQuery extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function DynamicQuery()
	{
      $this->EntitySIUK(); 
    }
	

    function getQueryScalar($str, $field)
	{
				
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField($field); 
		else 
			return 0; 
    }

  } 
?>