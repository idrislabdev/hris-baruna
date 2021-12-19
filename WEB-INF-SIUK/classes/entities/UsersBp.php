<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class UsersBp extends Users{ 

	var $query;
    /**
    * Class constructor.
    **/
    function UsersBp()
	{
      $this->Users(); 
    }
	
	function getSearchCountBpByParams($paramsArray=array(),$varStatement=""){
      $str = "SELECT COUNT(u.USER_NAME) AS ROWCOUNT FROM Users u WHERE u.USER_NAME IS NOT NULL ".$varStatement; 
      while(list($key,$val)=each($paramsArray)){
        $str .= " AND $key LIKE '%$val%' ";
      }
      $this->select($str); 
	  echo $str;
      if($this->firstRow()) 
        return $this->getField("ROWCOUNT"); 
      else 
         return 0; 
    }
	
  } 
?>