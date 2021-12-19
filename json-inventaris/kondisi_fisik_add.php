<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/KondisiFisik.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$kondisi_fisik = new KondisiFisik();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKeterangan = httpFilterPost("reqKeterangan");
$reqNama= httpFilterPost("reqNama");
$reqProsentase= httpFilterPost("reqProsentase");
	
if($reqMode == "insert")
{
	$kondisi_fisik->setField("NAMA", $reqNama);
	$kondisi_fisik->setField("PROSENTASE", ValToNullDB($reqProsentase));
	$kondisi_fisik->setField("KETERANGAN", $reqKeterangan);
	
	if($kondisi_fisik->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$kondisi_fisik->setField("KONDISI_FISIK_ID", $reqId);
	$kondisi_fisik->setField("NAMA", $reqNama);
	$kondisi_fisik->setField("PROSENTASE", ValToNullDB($reqProsentase));
	$kondisi_fisik->setField("KETERANGAN", $reqKeterangan);
	
	if($kondisi_fisik->update())
		echo "Data berhasil disimpan.";
	
}
?>