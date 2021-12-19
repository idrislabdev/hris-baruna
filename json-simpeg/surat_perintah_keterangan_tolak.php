<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-operasional/SuratPerintah.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$surat_perintah = new SuratPerintah();

$reqId = httpFilterPost("reqId");
$reqKeterangan = httpFilterPost("reqKeterangan");
$surat_perintah->setField('SURAT_PERINTAH_ID', $reqId); 
$surat_perintah->setField('KETERANGAN_TOLAK', $reqKeterangan);

if($surat_perintah->updateKeteranganTolak())
	echo "Data berhasil disimpan.";

?>