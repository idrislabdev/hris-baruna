<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/PegawaiKecualiJabatan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_kecuali_jabatan = new PegawaiKecualiJabatan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqPegawaiId = httpFilterPost("reqPegawaiId");
				
if($reqMode == "insert")
{
	$pegawai_kecuali_jabatan->setField("PEGAWAI_ID", $reqPegawaiId);
	$pegawai_kecuali_jabatan->insert();
	echo "Data berhasil disimpan.";
}
else
{
	$pegawai_kecuali_jabatan->setField("PEGAWAI_KECUALI_JABATAN_ID", $reqId);
	$pegawai_kecuali_jabatan->setField("PEGAWAI_ID", $reqPegawaiId);
	$pegawai_kecuali_jabatan->update();
	echo "Data berhasil disimpan.";	
}

?>