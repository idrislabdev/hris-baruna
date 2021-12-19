<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_jenis_pegawai = new PegawaiJenisPegawai();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId = httpFilterPost("reqRowId");

$reqTMT= httpFilterPost("reqTMT");
$reqJenisPegawai= httpFilterPost("reqJenisPegawai");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqJenisPegawaiPerubahanKode= httpFilterPost("reqJenisPegawaiPerubahanKode");
$reqMPP= httpFilterPost("reqMPP");
$reqAsalPerusahaan= httpFilterPost("reqAsalPerusahaan");
$reqNoSKMPP= httpFilterPost("reqNoSKMPP");
$reqTMTMPP= httpFilterPost("reqTMTMPP");
$reqKontrakAwal= httpFilterPost("reqKontrakAwal");
$reqKontrakAkhir= httpFilterPost("reqKontrakAkhir");
$reqDokumenId = httpFilterPost("reqDokumenId");


$pegawai_jenis_pegawai->setField('NO_SK_MPP', setNULL($reqNoSKMPP));
$pegawai_jenis_pegawai->setField('TMT_MPP', dateToDBCheck($reqTMTMPP));
$pegawai_jenis_pegawai->setField('TANGGAL_KONTRAK_AWAL', dateToDBCheck($reqKontrakAwal));
$pegawai_jenis_pegawai->setField('TANGGAL_KONTRAK_AKHIR', dateToDBCheck($reqKontrakAkhir));
$pegawai_jenis_pegawai->setField('ASAL_PERUSAHAAN', $reqAsalPerusahaan);
$pegawai_jenis_pegawai->setField('MPP', setNULL($reqMPP));
$pegawai_jenis_pegawai->setField('TMT_JENIS_PEGAWAI', dateToDBCheck($reqTMT));
$pegawai_jenis_pegawai->setField('JENIS_PEGAWAI_ID', $reqJenisPegawai);
$pegawai_jenis_pegawai->setField('KETERANGAN', $reqKeterangan);
$pegawai_jenis_pegawai->setField('JENIS_PEGAWAI_PERUBAH_KODE_ID', $reqJenisPegawaiPerubahanKode);
$pegawai_jenis_pegawai->setField('PEGAWAI_JENIS_PEGAWAI_ID', $reqRowId);
$pegawai_jenis_pegawai->setField('PEGAWAI_ID', $reqId);
$pegawai_jenis_pegawai->setField('DOKUMEN_ID', $reqDokumenId);

if($reqMode == "insert")
{
	$pegawai_jenis_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_jenis_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	if($pegawai_jenis_pegawai->insert()){
		$reqRowId= $pegawai_jenis_pegawai->id;
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_jenis_pegawai->query;
}
else
{
	$pegawai_jenis_pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai_jenis_pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
	if($pegawai_jenis_pegawai->update()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_jenis_pegawai->query;
}
?>