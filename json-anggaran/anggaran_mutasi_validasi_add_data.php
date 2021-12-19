<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$anggaran_mutasi = new AnggaranMutasi();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqStatusVerifikasi = httpFilterPost("reqStatusVerifikasi");


if($reqMode == "update")
{		
	$id=$reqId;		
	$anggaran_mutasi->setField("STATUS_VERIFIKASI", setChecked($reqStatusVerifikasi, 1, 1));		
	$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $reqId);
	

	if($anggaran_mutasi->updateStatus())
		echo $id."-Data berhasil disimpan.";
			
}
?>