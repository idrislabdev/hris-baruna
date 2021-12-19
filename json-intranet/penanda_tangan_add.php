<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/PenandaTangan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$penanda_tangan = new PenandaTangan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama 	= httpFilterPost("reqNama");
$reqJabatan 	= httpFilterPost("reqJabatan");

if($reqMode == "insert")
{
	$penanda_tangan->setField("NAMA", $reqNama);
	$penanda_tangan->setField("JABATAN", $reqJabatan);
	
	if($penanda_tangan->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$penanda_tangan->setField("PENANDA_TANGAN_ID", $reqId);
	$penanda_tangan->setField("NAMA", $reqNama);
	$penanda_tangan->setField("JABATAN", $reqJabatan);
	
	if($penanda_tangan->update())
		echo "Data berhasil disimpan.";
	
}
?>