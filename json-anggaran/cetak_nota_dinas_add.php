<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$anggaran_mutasi = new AnggaranMutasi();

$reqId = httpFilterPost("reqId");
$reqNotaDinas1 = httpFilterPost("reqNotaDinas1");
$reqNotaDinas2 = httpFilterPost("reqNotaDinas2");
$reqNotaDinas3 = httpFilterPost("reqNotaDinas3");
$reqNoRef3 = httpFilterPost("reqNoRef3");
$reqNama1 = httpFilterPost("reqNama1");
$reqJabatan1 = httpFilterPost("reqJabatan1");
$reqNama2 = httpFilterPost("reqNama2");
$reqJabatan2 = httpFilterPost("reqJabatan2");


$anggaran_mutasi->setField("NO_REF3", $reqNoRef3);
$anggaran_mutasi->setField("NOTA_DINAS_1", $reqNotaDinas1);
$anggaran_mutasi->setField("NOTA_DINAS_2", $reqNotaDinas2);
$anggaran_mutasi->setField("NOTA_DINAS_3", $reqNotaDinas3);
$anggaran_mutasi->setField("TTD_1", $reqNama1);
$anggaran_mutasi->setField("TTD_JABATAN_1", $reqJabatan1);
$anggaran_mutasi->setField("TTD_2", $reqNama2);
$anggaran_mutasi->setField("TTD_JABATAN_2", $reqJabatan2);
$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $reqId);

$anggaran_mutasi->updateNotaDinas();

echo "Data berhasil disimpan.";
?>