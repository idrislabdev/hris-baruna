<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiHukuman.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_hukuman = new PegawaiHukuman();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId = httpFilterPost("reqRowId");

$reqKategoriHukumanId = httpFilterPost("reqKategoriHukumanId");
$reqJenisHukumanId = httpFilterPost("reqJenisHukumanId");
$reqPejabatPenetapId = httpFilterPost("reqPejabatPenetapId");
$reqTanggalSK = httpFilterPost("reqTanggalSK");
$reqTMTSK = httpFilterPost("reqTMTSK");
$reqNoSK = httpFilterPost("reqNoSK");
$reqKasus = httpFilterPost("reqKasus");

$reqAkhirTMT = httpFilterPost("reqAkhirTMT");

$pegawai_hukuman->setField('KATEGORI_HUKUMAN_ID', $reqKategoriHukumanId);
$pegawai_hukuman->setField('JENIS_HUKUMAN_ID', $reqJenisHukumanId);
$pegawai_hukuman->setField('PEJABAT_PENETAP_ID', $reqPejabatPenetapId);
$pegawai_hukuman->setField('NO_SK', $reqNoSK);
$pegawai_hukuman->setField('TMT_SK', dateToDBCheck($reqTMTSK));
$pegawai_hukuman->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSK));
$pegawai_hukuman->setField('KASUS', $reqKasus);
$pegawai_hukuman->setField('PEGAWAI_HUKUMAN_ID', $reqRowId);
$pegawai_hukuman->setField('PEGAWAI_ID', $reqId);
$pegawai_hukuman->setField('AKHIR_TMT', dateToDBCheck($reqAkhirTMT));

if($reqMode == "insert")
{
	$pegawai_hukuman->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_hukuman->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	if($pegawai_hukuman->insert()){
		$reqRowId= $pegawai_hukuman->id;
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_hukuman->query;
}
else
{
	$pegawai_hukuman->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai_hukuman->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	if($pegawai_hukuman->update()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_hukuman->query;
}
?>