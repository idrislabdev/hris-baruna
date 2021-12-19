<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_pendidikan = new PegawaiPendidikan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId = httpFilterPost("reqRowId");

$reqPendidikanId= httpFilterPost("reqPendidikanId");
$reqPendidikanBiayaId= httpFilterPost("reqPendidikanBiayaId");
$reqNama= httpFilterPost("reqNama");
$reqKota= httpFilterPost("reqKota");
$reqUniversitasId= httpFilterPost("reqUniversitasId");
$reqTanggalIjasah= httpFilterPost("reqTanggalIjasah");
$reqLulus= httpFilterPost("reqLulus");
$reqNoIjasah= httpFilterPost("reqNoIjasah");
$reqTtdIjazah= httpFilterPost("reqTtdIjazah");
$reqNoAcc= httpFilterPost("reqNoAcc");
$reqTanggalAcc= httpFilterPost("reqTanggalAcc");

$pegawai_pendidikan->setField('PENDIDIKAN_ID', $reqPendidikanId);
$pegawai_pendidikan->setField('PENDIDIKAN_BIAYA_ID', $reqPendidikanBiayaId);
$pegawai_pendidikan->setField('NAMA', $reqNama);
$pegawai_pendidikan->setField('KOTA', $reqKota);
$pegawai_pendidikan->setField('UNIVERSITAS_ID', $reqUniversitasId);
$pegawai_pendidikan->setField('TANGGAL_IJASAH', dateToDBCheck($reqTanggalIjasah));
$pegawai_pendidikan->setField('LULUS', $reqLulus);
$pegawai_pendidikan->setField('NO_IJASAH', $reqNoIjasah);
$pegawai_pendidikan->setField('TTD_IJASAH', $reqTtdIjazah);
$pegawai_pendidikan->setField('NO_ACC', $reqNoAcc);
$pegawai_pendidikan->setField('TANGGAL_ACC', dateToDBCheck($reqTanggalAcc));
$pegawai_pendidikan->setField('PEGAWAI_PENDIDIKAN_ID', $reqRowId);
$pegawai_pendidikan->setField('PEGAWAI_ID', $reqId);

if($reqMode == "insert")
{
	$pegawai_pendidikan->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_pendidikan->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	if($pegawai_pendidikan->insert()){
		$reqRowId= $pegawai_pendidikan->id;
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_pendidikan->query;
}
else
{
	$pegawai_pendidikan->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai_pendidikan->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	if($pegawai_pendidikan->update()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_pendidikan->query;
}
?>