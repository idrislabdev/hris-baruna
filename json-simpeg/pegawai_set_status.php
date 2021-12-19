<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai = new Pegawai();

$reqId = httpFilterGet("reqId");
$reqNilai = httpFilterGet("reqNilai");


$pegawai->setField('STATUS_PEGAWAI_ID', $reqNilai);
$pegawai->setField('PEGAWAI_ID', $reqId);
if($pegawai->updateStatus())
echo "Data berhasil disimpan.";
?>