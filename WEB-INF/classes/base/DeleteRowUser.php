<? 
/* *******************************************************************************************************
MODUL NAME 			: PEL
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel KATA_MUTIARA.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class DeleteRowUser extends Entity{ 

	var $query; 
    /**
    * Class constructor.
    **/
    function DeleteRowUser()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		$str = "
				INSERT INTO DELETE_ROW_USER (
				   TABEL_NAMA, TABEL_ROW_ID, USER_NAMA, TABEL_ROW_ID_INDUK) 
 			  	VALUES (
				  '".$this->getField("TABEL_NAMA")."',
				  '".$this->getField("TABEL_ROW_ID")."',
				  '".$this->getField("USER_NAMA")."',
				  '".$this->getField("TABEL_ROW_ID_INDUK")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

  } 
?>