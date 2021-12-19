<?
/* *******************************************************************************************************
MODUL NAME 			: 
FILE NAME 			: recordcoloring.func.php
AUTHOR				: Ridwan Rismanto
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle coloring the data view
***************************************************************************************************** */

class RowColoring
{
	var $i;
	var $bright;
	var $dark;
	
	function initialize($bright, $dark)
	{
		$this->i = 1;
		$this->bright = $bright;
		$this->dark = $dark;
	}
	
	function style()
	{
		if($this->i % 2 == 0)
			return $this->bright;
		else
			return $this->dark;
		
		$this->i += 1;
	}
}

?>