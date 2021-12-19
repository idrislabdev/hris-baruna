<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPangkat.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_pangkat = new PegawaiPangkat();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId = httpFilterPost("reqRowId");

$reqTMT= httpFilterPost("reqTMT");
$reqPangkat= httpFilterPost("reqPangkat");
$reqPangkatKode= httpFilterPost("reqPangkatKode");
$reqPangkatPerubahanKode= httpFilterPost("reqPangkatPerubahanKode");
$reqNoSK= httpFilterPost("reqNoSK");
$reqTanggal= httpFilterPost("reqTanggal");
$reqGaji= httpFilterPost("reqGaji");
$reqTahun= httpFilterPost("reqTahun");
$reqBulan= httpFilterPost("reqBulan");
$reqPejabat= httpFilterPost("reqPejabat");
$reqUraian= httpFilterPost("reqUraian");
$reqJabatan= httpFilterPost("reqJabatan");

$pegawai_pangkat->setField('TMT_PANGKAT', dateToDBCheck($reqTMT));
$pegawai_pangkat->setField('PANGKAT_ID', $reqPangkat);
$pegawai_pangkat->setField('PANGKAT_KODE_ID', $reqPangkatKode);
$pegawai_pangkat->setField('PANGKAT_PERUBAHAN_KODE_ID', $reqPangkatPerubahanKode);
$pegawai_pangkat->setField('NO_SK', $reqNoSK);
$pegawai_pangkat->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
$pegawai_pangkat->setField('GAJI_POKOK', dotToNo($reqGaji));
$pegawai_pangkat->setField('MASA_KERJA_TAHUN', $reqTahun);
$pegawai_pangkat->setField('MASA_KERJA_BULAN', $reqBulan);
$pegawai_pangkat->setField('PEJABAT_PENETAP_ID', $reqPejabat);
$pegawai_pangkat->setField('KETERANGAN', $reqUraian);
$pegawai_pangkat->setField('JABATAN_ID', $reqJabatan);
$pegawai_pangkat->setField('PEGAWAI_PANGKAT_ID', $reqRowId);
$pegawai_pangkat->setField('PEGAWAI_ID', $reqId);

if($reqMode == "insert")
{
	$pegawai_pangkat->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_pangkat->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	if($pegawai_pangkat->insert()){
		$reqRowId= $pegawai_pangkat->id;
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_pangkat->query;
}
else
{
	$pegawai_pangkat->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai_pangkat->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
	if($pegawai_pangkat->update()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_pangkat->query;
}
?>