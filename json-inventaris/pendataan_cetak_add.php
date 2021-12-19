<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Lokasi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$lokasi = new Lokasi();

$reqId	 = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqGM	 = httpFilterPost("reqGM");
$reqManager = httpFilterPost("reqManager");
$reqAsman= httpFilterPost("reqAsman");;
$reqJabatanAsman= httpFilterPost("reqJabatanAsman");;
$reqJabatanManager= httpFilterPost("reqJabatanManager");
 
$lokasi->setField("LOKASI_ID", $reqId);
$lokasi->setField("GM", $reqGM);
$lokasi->setField("MANAGER", $reqManager);
$lokasi->setField("ASMAN", $reqAsman);
$lokasi->setField("JABATAN_MANAGER", $reqJabatanManager);
$lokasi->setField("JABATAN_ASMAN", $reqJabatanAsman);
if($lokasi->updatePenandaTangan())
	echo "Data berhasil disimpan.";
//echo $lokasi->query;
?>