<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: math.func.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle math operations
***************************************************************************************************** */

function equalFloat($float1,$float2){
    return (abs($float1 - $float2) < 0.0001);
}

function div($p,$q){
    $rest=$p % $q;
    return (($p-$rest)/$q);
}
?>