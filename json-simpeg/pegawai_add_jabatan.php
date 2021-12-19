<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_jabatan = new PegawaiJabatan();
$departemen_cabang = new Departemen();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId= httpFilterPost("reqRowId");
$reqKondisiJabatan = httpFilterPost("reqKondisiJabatan");

$reqTanggal= httpFilterPost("reqTanggal");
$reqTMT= httpFilterPost("reqTMT");
$reqNoSK= httpFilterPost("reqNoSK");
$reqCabang= httpFilterPost("reqCabang");
$reqDepartemen= httpFilterPost("reqDepartemen");
//$reqSubDepartemen= httpFilterPost("reqSubDepartemen");
//$reqSubDepartemen= httpFilterPost("reqSubDepartemen");
$reqJabatan= httpFilterPost("reqJabatan");
$reqNoUrut= httpFilterPost("reqNoUrut");
$reqKelas= httpFilterPost("reqKelas");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqPejabat= httpFilterPost("reqPejabat");

$departemen_cabang->selectByParams(array('DEPARTEMEN_ID'=>$reqDepartemen));
$departemen_cabang->firstRow();
$reqCabang= $departemen_cabang->getField('CABANG_ID');

$pegawai_jabatan->setField('PEGAWAI_ID', $reqId);
$pegawai_jabatan->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
$pegawai_jabatan->setField('TMT_JABATAN', dateToDBCheck($reqTMT));
$pegawai_jabatan->setField('NO_SK', $reqNoSK);
$pegawai_jabatan->setField('CABANG_ID', $reqCabang);
$pegawai_jabatan->setField('DEPARTEMEN_ID', $reqDepartemen);
//$pegawai_jabatan->setField('', $reqSubDepartemen);
$pegawai_jabatan->setField('JABATAN_ID', $reqJabatan);
//$pegawai_jabatan->setField('', $reqNoUrut);
//$pegawai_jabatan->setField('', $reqKelas);
$pegawai_jabatan->setField('NAMA', $reqNama);
$pegawai_jabatan->setField('KETERANGAN', $reqKeterangan);
$pegawai_jabatan->setField('PEJABAT_PENETAP_ID', $reqPejabat);
$pegawai_jabatan->setField('PEGAWAI_JABATAN_ID', $reqRowId);
$pegawai_jabatan->setField('KONDISI_JABATAN', $reqKondisiJabatan);

if($reqMode == "insert")
{
	$pegawai_jabatan->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_jabatan->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	if($pegawai_jabatan->insert()){
		$reqRowId= $pegawai_jabatan->id;
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_jabatan->query;
}
else
{
	$pegawai_jabatan->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai_jabatan->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	if($pegawai_jabatan->update()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_jabatan->query;
}
?>