<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$anggaran_mutasi = new AnggaranMutasi();

$reqId = httpFilterPost("reqId");

$anggaran_mutasi->setField("APPROVED_KADIV_BY", $userLogin->nama);
$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $reqId);
$anggaran_mutasi->updateApprovedKadiv();

echo $reqId."-Anggaran telah mengetahui kadiv yang bersangkutan.";

?>