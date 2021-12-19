<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: recordcoloring.func.php
AUTHOR				: Ridwan Rismanto
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle coloring the data view
***************************************************************************************************** */

function recordcoloring($i,$bright,$dark)
{
	if($i % 2 == 0)
		return $bright;
	else
		return $dark;
}

?>