<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisPenanggungJawab.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$inventaris_penanggung_jawab = new InventarisPenanggungJawab();

$reqId = httpFilterPost("reqId");
$reqLokasiId = httpFilterPost("reqLokasiId");
$reqMode = httpFilterPost("reqMode");
$reqPenanggungJawab = httpFilterPost("reqPenanggungJawab");
$reqTanggal = httpFilterPost("reqTanggal");
	
$inventaris_penanggung_jawab->setField("INVENTARIS_RUANGAN_ID", $reqId);
$inventaris_penanggung_jawab->setField("PEGAWAI_ID", $reqPenanggungJawab);
$inventaris_penanggung_jawab->setField("LOKASI_ID", $reqLokasiId);
$inventaris_penanggung_jawab->setField("TMT", dateToDBCheck($reqTanggal));
$inventaris_penanggung_jawab->insert();
	
echo $reqId."-Data berhasil disimpan.";

?>