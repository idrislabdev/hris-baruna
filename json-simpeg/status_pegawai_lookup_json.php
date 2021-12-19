<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/StatusPegawai.php");

$status_pegawai = new StatusPegawai();

$status_pegawai->selectByParams(array(), -1, -1, '');

$i = 0;
while($status_pegawai->nextRow())
{
	$arrID[$i] =  $status_pegawai->getField("STATUS_PEGAWAI_ID");
	$arrName[$i] =  $status_pegawai->getField("NAMA");
	$i += 1;
}
	$arrFinal = array("STATUS_PEGAWAI_ID" => $arrID, 
					  "NAMA" => $arrName);
	echo json_encode($arrFinal);
?>