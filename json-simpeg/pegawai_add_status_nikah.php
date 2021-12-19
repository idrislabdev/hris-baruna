<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiStatusNikah.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_status_nikah = new PegawaiStatusNikah();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId = httpFilterPost("reqRowId");

$reqTanggalNikah= httpFilterPost("reqTanggalNikah");
$reqStatusNikah= httpFilterPost("reqStatusNikah");
$reqTempat= httpFilterPost("reqTempat");
$reqNoSK= httpFilterPost("reqNoSK");
$reqHubungan= httpFilterPost("reqHubungan");

$pegawai_status_nikah->setField('TANGGAL_NIKAH', dateToDBCheck($reqTanggalNikah));
$pegawai_status_nikah->setField('STATUS_NIKAH', $reqStatusNikah);
$pegawai_status_nikah->setField('TEMPAT', $reqTempat);
$pegawai_status_nikah->setField('NO_SK', $reqNoSK);
$pegawai_status_nikah->setField('HUBUNGAN', $reqHubungan);
$pegawai_status_nikah->setField('PEGAWAI_STATUS_NIKAH_ID', $reqRowId);
$pegawai_status_nikah->setField('PEGAWAI_ID', $reqId);

if($reqMode == "insert")
{
	$pegawai_status_nikah->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_status_nikah->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
	if($pegawai_status_nikah->insert()){
		$reqRowId= $pegawai_status_nikah->id;
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_status_nikah->query;
}
else
{
	$pegawai_status_nikah->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai_status_nikah->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
	if($pegawai_status_nikah->update()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_status_nikah->query;
}
?>