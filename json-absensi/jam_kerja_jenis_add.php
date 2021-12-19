<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/JamKerjaJenis.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$jam_kerja_jenis = new JamKerjaJenis();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama = httpFilterPost("reqNama");
$reqKeterangan = httpFilterPost("reqKeterangan");
$reqKelompok = httpFilterPost("reqKelompok");
$reqWarna = httpFilterPost("reqWarna");

if($reqMode == "insert")
{
	$jam_kerja_jenis->setField("NAMA", $reqNama);
	$jam_kerja_jenis->setField("KETERANGAN", $reqKeterangan);
	$jam_kerja_jenis->setField("WARNA", $reqWarna);
	$jam_kerja_jenis->setField("KELOMPOK", $reqKelompok);
	if($jam_kerja_jenis->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$jam_kerja_jenis->setField("JAM_KERJA_JENIS_ID", $reqId);
	$jam_kerja_jenis->setField("NAMA", $reqNama);
	$jam_kerja_jenis->setField("KETERANGAN", $reqKeterangan);
	$jam_kerja_jenis->setField("KELOMPOK", $reqKelompok);
	$jam_kerja_jenis->setField("WARNA", $reqWarna);
	if($jam_kerja_jenis->update())
		echo "Data berhasil disimpan.";
	
}
?>