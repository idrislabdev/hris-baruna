<? 
/* *******************************************************************************************************
MODUL NAME 			: PPI
FILE NAME 			: GlobalQuery
AUTHOR				: Mulyono
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Class untuk mengeksekusi query langsung
***************************************************************************************************** */

  include_once("../WEB-INF/classes/db/Entity.php");
  class GlobalQuery extends Entity{ 
	var $query;
    function GlobalQuery()	{
      	$this->Entity(); 
    }
	function eksekusiQuery($sql=''){
		//$this->query = $sql;
		return $this->selectLimit($sql,-1,-1);
	}
  }