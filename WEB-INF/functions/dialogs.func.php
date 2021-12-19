<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: dialog.func.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle show message to user
***************************************************************************************************** */

function showMessageDlg($messageStr,$continueLoad=true,$redirectUrl="",$pPage=""){
	if(!$continueLoad){
		echo "<script language='javascript'>";
      	echo "  alert('".$messageStr."');";
      	if(trim($redirectUrl)=="")
        	echo "  history.go(-1);";
      	else
        	echo "  ". $pPage."location.href = '".$redirectUrl."';";
      	echo "</script>";
      exit;
	}else{
      	echo "<script language='javascript'>";
      	echo "  alert('".$messageStr."');";
      	echo "</script>";
    }
}
?>