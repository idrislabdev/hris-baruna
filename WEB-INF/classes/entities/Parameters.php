<? 
/* *******************************************************************************************************
MODUL NAME 			: SIMKeu
FILE NAME 			: Parameters.php
AUTHOR				: W2N
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Entity-base class for tabel tipe_np implementation
***************************************************************************************************** */

  /***
  * Entity-class untuk mengimplementasikan tabel tipe_np.
  * 
  * @author Wawan
  ***/
  include_once("../WEB-INF/classes/base/ParametersBase.php");

  class Parameters extends ParametersBase{ 
	
	var $query;
    /************************** <STANDARD METHODS> **************************************/
    /**
    * Class constructor.
    * @author M Reza Faisal
    **/
    function Parameters(){
      /** !!DO NOT REMOVE/CHANGE CODES IN THIS SECTION!! **/
      $this->ParametersBase(); //execute Entity constructor
      /** YOU CAN INSERT/CHANGE CODES IN THIS SECTION **/				
			
	
    }

    /************************** </STANDARD METHODS> **********************************/

    /************************** <ADDITIONAL METHODS> *********************************/
	function updateByParamKey()
	{
		if(!$this->canUpdate())
			showMessageDlg("Data parameters tidak dapat diupdate",true);
		else
		{
			$str = "UPDATE parameters 
					SET 
					  VALUE = '".$this->getField("VALUE")."',
					  MEMBER_OF = '".$this->getField("MEMBER_OF")."',
					  KETERANGAN = '".$this->getField("KETERANGAN")."'
					WHERE";
			$str .=	" PARAM_KEY = '".$this->getField("PARAM_KEY")."'"; 
			$this->query = $str;
			return $this->execQuery($str);
		}
    }
	
	function updateLRAK(){
      if(!$this->canUpdate())
        showMessageDlg("Data parameters tidak dapat diupdate",true);
      else{
        $str = "UPDATE parameters 
                SET 
                  VALUE = '".$this->getField("VALUE")."',
				  KETERANGAN = '".$this->getField("KETERANGAN")."'
                WHERE 
                  ID_PARAMETERS = '".$this->getField("ID_PARAMETERS")."'"; 
        
		$this->query = $str;
		return $this->execQuery($str);
      }
    }
	
	function getParamValue($param_key)
	{
		$this->selectByParams(array('PARAM_KEY' => $param_key));
		
		if($this->firstRow())
			return $this->getField('VALUE');
		else
			return 'sdsd';
	}
    /************************** </ADDITIONAL METHODS> *******************************/
  } //end of class nomor_perkiraan
?>