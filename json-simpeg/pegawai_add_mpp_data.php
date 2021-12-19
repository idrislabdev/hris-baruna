<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai = new Pegawai();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqNoSKMPP= httpFilterPost("reqNoSKMPP");
$reqTMTMPP= httpFilterPost("reqTMTMPP");

if($reqMode == "update")
{
	$pegawai->setField('PEGAWAI_ID', $reqId);
	$pegawai->setField('NO_MPP', $reqNoSKMPP);
	$pegawai->setField('TANGGAL_MPP', dateToDBCheck($reqTMTMPP));
	$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	if($pegawai->updateMPP())
	{
		$id = $reqId;
		echo $id."-Data berhasil disimpan.";
	}
}
?>