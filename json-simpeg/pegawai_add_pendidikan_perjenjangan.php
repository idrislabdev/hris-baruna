<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikanPerjenjangan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_pendidikan = new PegawaiPendidikanPerjenjangan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId = httpFilterPost("reqRowId");

$reqNama= httpFilterPost("reqNama");
$reqTanggalAwal= httpFilterPost("reqTanggalAwal");
$reqTanggalAkhir= httpFilterPost("reqTanggalAkhir");

$pegawai_pendidikan->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
$pegawai_pendidikan->setField('NAMA', $reqNama);
$pegawai_pendidikan->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
$pegawai_pendidikan->setField('PEGAWAI_PEND_PERJENJANGAN_ID', $reqRowId);
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