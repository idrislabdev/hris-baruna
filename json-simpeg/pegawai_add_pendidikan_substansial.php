<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikanSubstansial.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_pendidikan_substansial = new PegawaiPendidikanSubstansial();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId = httpFilterPost("reqRowId");

$reqNama= httpFilterPost("reqNama");
$reqTanggalAwal= httpFilterPost("reqTanggalAwal");
$reqTanggalAkhir= httpFilterPost("reqTanggalAkhir");

$pegawai_pendidikan_substansial->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
$pegawai_pendidikan_substansial->setField('NAMA', $reqNama);
$pegawai_pendidikan_substansial->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
$pegawai_pendidikan_substansial->setField('PEGAWAI_PEND_SUBSTANSIAL_ID', $reqRowId);
$pegawai_pendidikan_substansial->setField('PEGAWAI_ID', $reqId);

if($reqMode == "insert")
{
	$pegawai_pendidikan_substansial->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_pendidikan_substansial->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	if($pegawai_pendidikan_substansial->insert()){
		$reqRowId= $pegawai_pendidikan_substansial->id;
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_pendidikan_substansial->query;
}
else
{
	$pegawai_pendidikan_substansial->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai_pendidikan_substansial->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	if($pegawai_pendidikan_substansial->update()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_pendidikan_substansial->query;
}
?>