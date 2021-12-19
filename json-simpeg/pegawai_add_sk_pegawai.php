<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiSKPegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_sk_pegawai = new PegawaiSKPegawai();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqPegawaiSkPegawaiId= httpFilterPost("reqPegawaiSkPegawaiId");
$reqNoSK= httpFilterPost("reqNoSK");
$reqTanggalSK= httpFilterPost("reqTanggalSK");
$reqTanggalMulai= httpFilterPost("reqTanggalMulai");
$reqPejabat= httpFilterPost("reqPejabat");

$pegawai_sk_pegawai->setField('PEGAWAI_SK_PEGAWAI_ID', $reqPegawaiSkPegawaiId);
$pegawai_sk_pegawai->setField('NO_SK', $reqNoSK);
$pegawai_sk_pegawai->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSK));
$pegawai_sk_pegawai->setField('TMT_SK', dateToDBCheck($reqTanggalMulai));
$pegawai_sk_pegawai->setField('PEJABAT_PENETAP_ID', $reqPejabat);
$pegawai_sk_pegawai->setField('PEGAWAI_ID', $reqId);
	
//echo $reqPegawaiSkPegawaiId.'---'.$reqMode;

if($reqMode == "insert")
{
	$pegawai_sk_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_sk_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	if($pegawai_sk_pegawai->insert()){
		echo $reqId."-Data berhasil disimpan.";
	}
	//echo $pegawai_sk_pegawai->query;
}
else
{
	$pegawai_sk_pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai_sk_pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	if($pegawai_sk_pegawai->update()){
		echo $reqId."-Data berhasil disimpan.";
	}
	//echo $pegawai_sk_pegawai->query;
}
?>