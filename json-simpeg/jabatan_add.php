<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$jabatan = new Jabatan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKode= httpFilterPost("reqKode");
$reqNoUrut= httpFilterPost("reqNoUrut");
$reqKelas= httpFilterPost("reqKelas");
$reqPPH= httpFilterPost("reqPPH");
$reqNama= httpFilterPost("reqNama");
$reqStatus= httpFilterPost("reqStatus");
$reqKelompok= httpFilterPost("reqKelompok");
$reqNamaSlip = httpFilterPost("reqNamaSlip");
$reqDepartemen = httpFilterPost("reqDepartemen");

$reqKandidatPengalaman= httpFilterPost("reqKandidatPengalaman");
$reqKandidatPendidikanKode= httpFilterPost("reqKandidatPendidikanKode");
$reqKandidatUsia= httpFilterPost("reqKandidatUsia");

if($reqMode == "insert")
{
	$jabatan->setField('KODE', $reqKode);
	$jabatan->setField('NO_URUT', $reqNoUrut);
	$jabatan->setField('KELAS', $reqKelas);
	$jabatan->setField('PPH', $reqPPH);
	$jabatan->setField('NAMA', $reqNama);
	$jabatan->setField('NAMA_SLIP', $reqNamaSlip);
	$jabatan->setField('KELOMPOK', $reqKelompok);
	$jabatan->setField("STATUS", setNULL($reqStatus));
	
	$jabatan->setField('KANDIDAT_PENDIDIKAN_KODE', $reqKandidatPendidikanKode);
	$jabatan->setField('KANDIDAT_PENGALAMAN', $reqKandidatPengalaman);
	$jabatan->setField('KANDIDAT_USIA', $reqKandidatUsia);
	$jabatan->setField('DEPARTEMEN_ID', $reqDepartemen);
	
	$jabatan->setField("LAST_CREATE_USER", $userLogin->nama);
	$jabatan->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
	if($jabatan->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$jabatan->setField('JABATAN_ID', $reqId); 
	$jabatan->setField('KODE', $reqKode);
	$jabatan->setField('NO_URUT', $reqNoUrut);
	$jabatan->setField('KELAS', $reqKelas);
	$jabatan->setField('PPH', $reqPPH);
	$jabatan->setField('NAMA', $reqNama);
	$jabatan->setField('NAMA_SLIP', $reqNamaSlip);
	$jabatan->setField('KELOMPOK', $reqKelompok);
	$jabatan->setField("STATUS", setNULL($reqStatus));
	
	$jabatan->setField('KANDIDAT_PENDIDIKAN_KODE', $reqKandidatPendidikanKode);
	$jabatan->setField('KANDIDAT_PENGALAMAN', $reqKandidatPengalaman);
	$jabatan->setField('KANDIDAT_USIA', $reqKandidatUsia);
	$jabatan->setField('DEPARTEMEN_ID', $reqDepartemen);
	
	$jabatan->setField("LAST_UPDATE_USER", $userLogin->nama);
	$jabatan->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	if($jabatan->update())
		echo "Data berhasil disimpan.";
	
}
?>