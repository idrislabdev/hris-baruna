<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/ParameterPotonganWajib.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$parameter_potongan_wajib = new ParameterPotonganWajib();

$reqId = httpFilterPost("reqId");
$reqRowId = httpFilterPost("reqRowId");
$reqMode = httpFilterPost("reqMode");
$reqKelas = httpFilterPost("reqKelas");
$reqJenisPotongan = httpFilterPost("reqJenisPotongan");
$reqJumlah = httpFilterPost("reqJumlah");

if($reqMode == "insert")
{
	
	$parameter_potongan_wajib->setField("JENIS_POTONGAN", $reqJenisPotongan);
	$parameter_potongan_wajib->setField("KELAS", $reqKelas);
	$parameter_potongan_wajib->setField("JUMLAH", dotToNo($reqJumlah));
	
	if($parameter_potongan_wajib->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$parameter_potongan_wajib->setField("JENIS_POTONGAN_ID", $reqId);
	$parameter_potongan_wajib->setField("KELAS_ID", $reqRowId);
	$parameter_potongan_wajib->setField("JENIS_POTONGAN", $reqJenisPotongan);
	$parameter_potongan_wajib->setField("KELAS", $reqKelas);
	$parameter_potongan_wajib->setField("JUMLAH", dotToNo($reqJumlah));
	
	if($parameter_potongan_wajib->update())
		echo "Data berhasil disimpan.";
	
}
?>