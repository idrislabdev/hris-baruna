<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/JenisInventaris.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$jenis_inventaris = new JenisInventaris();
$reqId 				= httpFilterPost("reqId");
$reqMode 			= httpFilterPost("reqMode");
$reqKeterangan = httpFilterPost("reqKeterangan");
$reqNama= httpFilterPost("reqNama");
$reqKode= httpFilterPost("reqKode");


if($reqMode == "insert")
{
	$jenis_inventaris->setField("NAMA", $reqNama);
	$jenis_inventaris->setField("KODE", $reqKode);
	$jenis_inventaris->setField("KETERANGAN", $reqKeterangan);
	$jenis_inventaris->setField("NILAI_RESIDU", $reqNilaiResidu);
	$jenis_inventaris->setField("JENIS_INVENTARIS_ID", $reqId);
	if($jenis_inventaris->insert())
		echo "Data berhasil disimpan.";
	// echo $jenis_inventaris->query;exit();
}
else
{
	$jenis_inventaris->setField("JENIS_INVENTARIS_ID", $reqId);
	$jenis_inventaris->setField("NAMA", $reqNama);
	$jenis_inventaris->setField("KODE", $reqKode);
	$jenis_inventaris->setField("KETERANGAN", $reqKeterangan);
	$jenis_inventaris->setField("NILAI_RESIDU", $reqNilaiResidu);
		
	if($jenis_inventaris->update())
		echo "Data berhasil disimpan.";
	
}
?>