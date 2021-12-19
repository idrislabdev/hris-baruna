<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiSKCalonPegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_sk_calon_pegawai = new PegawaiSKCalonPegawai();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqNoSK= httpFilterPost("reqNoSK");
$reqTMT= httpFilterPost("reqTMT");
$reqTanggalSK= httpFilterPost("reqTanggalSK");
$reqPendidikan= httpFilterPost("reqPendidikan");
$reqTahun= httpFilterPost("reqTahun");
$reqBulan= httpFilterPost("reqBulan");
$reqPangkat= httpFilterPost("reqPangkat");
$reqPangkatKode= httpFilterPost("reqPangkatKode");
$reqPejabat= httpFilterPost("reqPejabat");
$reqTMTP3= httpFilterPost("reqTMTP3");
$reqPegawaiSKCalonPegawaiId= httpFilterPost("reqPegawaiSKCalonPegawaiId");

$pegawai_sk_calon_pegawai->setField('NO_SK', $reqNoSK);
$pegawai_sk_calon_pegawai->setField('TMT_SK', dateToDBCheck($reqTMT));
$pegawai_sk_calon_pegawai->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSK));
//$pegawai_sk_calon_pegawai->setField('', $reqPendidikanId);
$pegawai_sk_calon_pegawai->setField('PENDIDIKAN_ID', $reqPendidikan);
$pegawai_sk_calon_pegawai->setField('MASA_KERJA_TAHUN', $reqTahun);
$pegawai_sk_calon_pegawai->setField('MASA_KERJA_BULAN', $reqBulan);
$pegawai_sk_calon_pegawai->setField('PANGKAT_ID', $reqPangkat);
//$pegawai_sk_calon_pegawai->setField('', $reqPangkatKodeId);
$pegawai_sk_calon_pegawai->setField('PANGKAT_KODE_ID', $reqPangkatKode);
$pegawai_sk_calon_pegawai->setField('PEJABAT_PENETAP_ID', $reqPejabat);
$pegawai_sk_calon_pegawai->setField('TMT_P3', dateToDBCheck($reqTMTP3));
$pegawai_sk_calon_pegawai->setField('PEGAWAI_SK_CALON_PEGAWAI_ID', $reqPegawaiSKCalonPegawaiId);
$pegawai_sk_calon_pegawai->setField('PEGAWAI_ID', $reqId);
	
//echo $reqPegawaiSKCalonPegawaiId.'---'.$reqMode;

if($reqMode == "insert")
{
	$pegawai_sk_calon_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_sk_calon_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
	if($pegawai_sk_calon_pegawai->insert()){
		echo $reqId."-Data berhasil disimpan.";
	}
	//echo $pegawai_sk_calon_pegawai->query;
}
else
{
	$pegawai_sk_calon_pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai_sk_calon_pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
	if($pegawai_sk_calon_pegawai->update()){
		echo $reqId."-Data berhasil disimpan.";
	}
	//echo $pegawai_sk_calon_pegawai->query;
}
?>