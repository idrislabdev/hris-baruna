<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PejabatPenetap.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pejabat_penetap = new PejabatPenetap();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");


if($reqMode == "insert")
{
	$pejabat_penetap->setField('NAMA', $reqNama);
	$pejabat_penetap->setField('KETERANGAN', $reqKeterangan);
	$pejabat_penetap->setField("LAST_CREATE_USER", $userLogin->nama);
	$pejabat_penetap->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
	if($pejabat_penetap->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$pejabat_penetap->setField('PEJABAT_PENETAP_ID', $reqId); 
	$pejabat_penetap->setField('NAMA', $reqNama);
	$pejabat_penetap->setField('KETERANGAN', $reqKeterangan);
	$pejabat_penetap->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pejabat_penetap->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
	if($pejabat_penetap->update())
		echo "Data berhasil disimpan.";
	
}
?>