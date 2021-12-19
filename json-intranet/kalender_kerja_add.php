<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/KalenderKerja.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$kalender_kerja = new KalenderKerja();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqDepartemen = httpFilterPost("reqDepartemen");
$reqTanggalAwal = httpFilterPost("reqTanggalAwal");
$reqTanggalAkhir = httpFilterPost("reqTanggalAkhir");
$reqWarna = httpFilterPost("reqWarna");
$reqNama = httpFilterPost("reqNama");
$reqKeterangan = httpFilterPost("reqKeterangan");
$reqSubmit = httpFilterPost("reqSubmit");

if($reqDepartemen == 0)
	$reqDepartemen = "CAB1";
else
	$reqDepartemen = $reqDepartemen;

if($reqMode == "insert")
{
	$kalender_kerja->setField("DEPARTEMEN_ID", $reqDepartemen);
	$kalender_kerja->setField("NAMA", $reqNama);
	$kalender_kerja->setField("KETERANGAN", $reqKeterangan);
	$kalender_kerja->setField("TANGGAL_AWAL", dateToDBCheck($reqTanggalAwal));
	$kalender_kerja->setField("TANGGAL_AKHIR", dateToDBCheck($reqTanggalAkhir));
	$kalender_kerja->setField("WARNA", $reqWarna);
	$kalender_kerja->setField("USER_LOGIN_ID", $userLogin->UID);
	$kalender_kerja->setField("STATUS", 1);
	$kalender_kerja->setField("LAST_CREATE_USER", $userLogin->nama);
	$kalender_kerja->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
		
	if($kalender_kerja->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$kalender_kerja->setField("KALENDER_KERJA_ID", $reqId);
	$kalender_kerja->setField("DEPARTEMEN_ID", $reqDepartemen);
	$kalender_kerja->setField("NAMA", $reqNama);
	$kalender_kerja->setField("KETERANGAN", $reqKeterangan);
	$kalender_kerja->setField("TANGGAL_AWAL", dateToDBCheck($reqTanggalAwal));
	$kalender_kerja->setField("TANGGAL_AKHIR", dateToDBCheck($reqTanggalAkhir));
	$kalender_kerja->setField("WARNA", $reqWarna);
	$kalender_kerja->setField("USER_LOGIN_ID", $userLogin->UID);
	$kalender_kerja->setField("STATUS", 1);
	$kalender_kerja->setField("LAST_UPDATE_USER", $userLogin->nama);
	$kalender_kerja->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	
	if($kalender_kerja->update())
		echo "Data berhasil disimpan.";
	
}
?>