<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/Absensi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$absensi = new Absensi();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqPegawaiId= httpFilterPost("reqPegawaiId");
$reqNRP= httpFilterPost("reqNRP");
$reqNama= httpFilterPost("reqNama");
$reqDepartemenId= httpFilterPost("reqDepartemenId");
$reqDepartemen= httpFilterPost("reqDepartemen");
$reqStatus= httpFilterPost("reqStatus");
$reqTanggal= httpFilterPost("reqTanggal");
$reqJam= httpFilterPost("reqJam");

if($reqMode == "insert")
{
	$reqJamTanggal = $reqTanggal.":".$reqJam;
	
	$absensi->setField('PEGAWAI_ID', $reqPegawaiId);
	$absensi->setField('DEPARTEMEN_ID', $reqDepartemenId);
	$absensi->setField('JAM', datetimeToDB($reqJamTanggal));
	$absensi->setField('STATUS', $reqStatus);
	$absensi->setField('VALIDASI', 0);
	$absensi->setField("LAST_CREATE_USER", $userLogin->nama);
	$absensi->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
	if($absensi->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$reqJamTanggal = $reqTanggal.":".$reqJam;
	
	$absensi->setField('ABSENSI_ID', $reqId); 
	$absensi->setField('PEGAWAI_ID', $reqPegawaiId);
	$absensi->setField('DEPARTEMEN_ID', $reqDepartemenId);
	$absensi->setField('JAM', datetimeToDB($reqJamTanggal));
	$absensi->setField('STATUS', $reqStatus);
	$absensi->setField('VALIDASI', 0);
	$absensi->setField("LAST_UPDATE_USER", $userLogin->nama);
	$absensi->setField("LAST_UPDATE_DATE", OCI_SYSDATE);			
	if($absensi->update())
		echo "Data berhasil disimpan.";
	
}
?>