<?
/* *******************************************************************************************************
MODUL NAME 			: SIMKEU
FILE NAME 			: Validate.php
AUTHOR				: Ridwan Rismanto
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Class that responsible to validate input
***************************************************************************************************** */

class Validate
{
	var $goExecute;
	var $message;
	
	var $varValidate;
	var $varMessage;
	
	var $statNotEmpty;
	var $statMustNumeric;
	var $statNpExist;
	var $statUserGroupLevelNotExist;
	var $statMustBeSame;
	
	/* Constructor */
	function Validate()
	{
		$this->message = array();
		$this->varValidate = array();
		$this->varMessage = array();
	}
	
	
	/* $reqValidate = array yang berisi variabel yang akan di-validasi
	 * $reqMessage = array yang berisi pesan kesalahan jika validasi tidak dipenuhi
	 * array-index dari $reqValidate dan $reqMessage harus sama
	 */
	function setValidate($reqValidate=array())
	{
		while(list($key, $val) = each($reqValidate))
		{
			$this->varValidate[] = $val;
		}
	}
	
	function setMessage($reqMessage=array())
	{
		while(list($key, $val) = each($reqMessage))
		{
			$this->varMessage[] = $val;
		}
	}
	
	/* fungsi untuk memvalidasi input yang tidak boleh kosong */
	function notEmpty()
	{
		while(list($key,$val) = each($this->varValidate))
		{
			if($val == "")
			{	
				$this->message[] = $this->varMessage[$key];
			}
		}
		
		if (in_array("", $this->varValidate))
			$this->statNotEmpty = false;
		else
			$this->statNotEmpty = true;
	}
	
/* fungsi untuk memvalidasi input yang tidak boleh kosong */
	function EmptyMessage()
	{
		while(list($key,$val) = each($this->varValidate))
		{
			if($val == "")
			{	
				$this->message[] = $this->varMessage[$key];
			}
		}
		if (in_array("", $this->varValidate))
			$this->statNotEmpty = false;
		else
			$this->statNotEmpty = true;				
	}	
	/* fungsi untuk memvalidasi 2 input yang harus sama 
	 * varValidate harus merupakan array yang berisi 2 parameter yang akan dibandingkan
	 * jika lebih dari itu maka kelebihannya akan diabaikan
	 * varMessage hanya berisi satu elemen
	 */
	function mustBeSame()
	{
		$i = 0;
		$this->statMustBeSame = true;
		while(list($key,$val) = each($this->varValidate))
		{
			if($i < 2)
				$theVal[$i] = $val;
			
			if($i < 1)
				$theMessage = $this->varMessage[$key];
			
			$i++;
		}
		
		if($theVal[0] !== $theVal[1])
		{
			$this->statMustBeSame = false;
			$this->message[] = $theMessage;
		}
	}
	
	/* fungsi untuk memvalidasi input yang harus berupa data numerik 
	 * $allowBlank = true : skip validasi jika input bernilai kosong
	 				 false : validasi meskipun input bernilai kosong
	 */
	function mustNumeric($allowBlank=true)
	{
		$this->statMustNumeric = true;
		while(list($key,$val) = each($this->varValidate))
		{
			if($allowBlank)
			{
				if($val == "")
					$doValidate = false;
				else
					$doValidate = true;
			}
			else
			{
				$doValidate = true;
			}
			
			if(!is_numeric($val) && $doValidate)
			{	
				$this->message[] = $this->varMessage[$key];
				$this->statMustNumeric = false;
			}
		}
	}
	
	/* cek apakah nomor perkiraan yang dimasukkan ada di data nomor perkiraan 
	 * dependencies : include NomorPerkiraan.php
	 */
	function npExist($allowBlank=true)
	{
		$nomor_perkiraan = new NomorPerkiraan();
		
		$this->statNpExist = true;
		while(list($key,$val) = each($this->varValidate))
		{
			if($allowBlank)
			{
				if($val == "")
					$doValidate = false;
				else
					$doValidate = true;
			}
			else
			{
				$doValidate = true;
			}
			
			$nomor_perkiraan->selectById($val);
			if(!$nomor_perkiraan->firstRow() && $allowBlank)
			{
				$this->statNpExist = false;
				$this->message[] = $this->varMessage[$key];
			}
		}
	}
	
	/* cek apakah level usergroup yang dimasukkan ada di data parameters
	 * dependencies : include UserGroups.php
	 * statUserGroupLevelNotExist return :
	 * true if not exist
	 * false if exist
	 */
	function userGroupLevelNotExist()
	{
		$usergroups = new UserGroups();
		
		$this->statUserGroupLevelNotExist = true;
		while(list($key,$val) = each($this->varValidate))
		{
			if($usergroups->selectById($val) == true)
			{
				$this->statUserGroupLevelNotExist = false;
				$this->message[] = "Usergroup level ada".$val;//$this->varMessage[$key];
			}
		}
	}
	
	/* fungsi untuk menampung pesan yang dihasilkan oleh masing-masing validation method */
	function getMessage()
	{
		while(list($key, $val) = each($this->message))
		{
			$resMessage .= "<li class='highlight'>".$val."</li>";
		}
		
		unset($this->message);
		
		return $resMessage;
	}
}

/* Instantiate the object */
$validate = new Validate();
?>
