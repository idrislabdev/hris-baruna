<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/AsuransiPegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$asuransi_pegawai = new AsuransiPegawai();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqJumlah= httpFilterPost("reqJumlah");
$reqAsuransiId= httpFilterPost("reqAsuransiId");
	
if($reqMode == "insert")
{
	$asuransi_pegawai->setField("JUMLAH", dotToNo($reqJumlah));
	$asuransi_pegawai->setField("ASURANSI_ID", $reqAsuransiId);
	$asuransi_pegawai->setField("PEGAWAI_ID", $reqId);
	
	if($asuransi_pegawai->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$asuransi_pegawai->setField("PEGAWAI_ID", $reqId);
	$asuransi_pegawai->setField("JUMLAH", dotToNo($reqJumlah));
	$asuransi_pegawai->setField("ASURANSI_ID", $reqAsuransiId);
	
	if($asuransi_pegawai->update())
		echo "Data berhasil disimpan.";
	
}
?>