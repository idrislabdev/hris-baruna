<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiKeluarga.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_keluarga = new PegawaiKeluarga();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId = httpFilterPost("reqRowId");

$reqHubunganKeluargaId= httpFilterPost("reqHubunganKeluargaId");
$reqStatusKawin= httpFilterPost("reqStatusKawin");
$reqJenisKelamin= httpFilterPost("reqJenisKelamin");
$reqStatusTunjangan= httpFilterPost("reqStatusTunjangan");
$reqNama= httpFilterPost("reqNama");
$reqNik= httpFilterPost("reqNik");
$reqTanggalWafat= httpFilterPost("reqTanggalWafat");
$reqTanggalLahir= httpFilterPost("reqTanggalLahir");
$reqStatusTanggung= httpFilterPost("reqStatusTanggung");
$reqTempatLahir= httpFilterPost("reqTempatLahir");
$reqPendidikanId= httpFilterPost("reqPendidikanId");
$reqPekerjaan= httpFilterPost("reqPekerjaan");

$pegawai_keluarga->setField('HUBUNGAN_KELUARGA_ID', $reqHubunganKeluargaId);
$pegawai_keluarga->setField('STATUS_KAWIN', setNULL($reqStatusKawin));
$pegawai_keluarga->setField('JENIS_KELAMIN', $reqJenisKelamin);
$pegawai_keluarga->setField('STATUS_TUNJANGAN', setNULL($reqStatusTunjangan));
$pegawai_keluarga->setField('NAMA', $reqNama);
$pegawai_keluarga->setField('NIK', $reqNik);
$pegawai_keluarga->setField('TANGGAL_WAFAT', dateToDBCheck($reqTanggalWafat));
$pegawai_keluarga->setField('TANGGAL_LAHIR', dateToDBCheck($reqTanggalLahir));
$pegawai_keluarga->setField('STATUS_TANGGUNG', setNULL($reqStatusTanggung));
$pegawai_keluarga->setField('TEMPAT_LAHIR', $reqTempatLahir);
$pegawai_keluarga->setField('PENDIDIKAN_ID', $reqPendidikanId);
$pegawai_keluarga->setField('PEKERJAAN', $reqPekerjaan);
$pegawai_keluarga->setField('PEGAWAI_KELUARGA_ID', $reqRowId);
$pegawai_keluarga->setField('PEGAWAI_ID', $reqId);

if($reqMode == "insert")
{
	$pegawai_keluarga->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_keluarga->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	if($pegawai_keluarga->insert()){
		$reqRowId= $pegawai_keluarga->id;
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_keluarga->query;
}
else
{
	$pegawai_keluarga->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai_keluarga->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	if($pegawai_keluarga->update()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_keluarga->query;
}
?>