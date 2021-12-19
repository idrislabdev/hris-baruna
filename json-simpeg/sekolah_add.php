<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/DataSekolah.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$sekolah = new DataSekolah();

$reqId = httpFilterPost("SEKOLAH_ID");

$reqNama	= httpFilterPost("NAMA");
$reqTelpon 	= httpFilterPost("TELPON");
$reqFax 	= httpFilterPost("FAX");
$reqKota 	= httpFilterPost("KOTA");
$reqWebsite = httpFilterPost("WEBSITE");
$reqEmail 	= httpFilterPost("EMAIL");
$reqAlamat 	= httpFilterPost("ALAMAT");
$reqRekomN 	= httpFilterPost("REKOMENDASI_N");
$reqRekomT 	= httpFilterPost("REKOMENDASI_T");
$reqSertifikat 	= httpFilterPost("SERTIFIKAT");
$reqTglSertifikat 	= httpFilterPost("TGL_SERTIFIKAT");
$reqApproval 	= httpFilterPost("APPROVAL_DESC");

if($reqId == ""){
	$sekolah->setField('NAMA', $reqNama);
	$sekolah->setField('TELPON', $reqTelpon);
	$sekolah->setField('FAX', $reqFax);
	$sekolah->setField('KOTA', $reqKota);
	$sekolah->setField('EMAIL', $reqEmail);
	$sekolah->setField('WEBSITE', $reqWebsite);
	$sekolah->setField('ALAMAT', $reqAlamat);
	$sekolah->setField('APPROVAL_DESC', $reqApproval);
	$sekolah->setField('REKOMENDASI_N', $reqRekomN);
	$sekolah->setField('REKOMENDASI_T', $reqRekomT);
	$sekolah->setField('SERTIFIKAT', $reqSertifikat);
	$sekolah->setField('TGL_SERTIFIKAT', dateToDBCheck($reqTglSertifikat));
	$sekolah->setField("LAST_CREATE_USER", $userLogin->nama);
	$sekolah->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
	if($sekolah->insert())
		echo '{success:true, error:null, "keterangan":"Data berhasil disimpan!"}';
}
else{
	$sekolah->setField('SEKOLAH_ID', $reqId);
	$sekolah->setField('NAMA', $reqNama);
	$sekolah->setField('TELPON', $reqTelpon);
	$sekolah->setField('FAX', $reqFax);
	$sekolah->setField('KOTA', $reqKota);
	$sekolah->setField('EMAIL', $reqEmail);
	$sekolah->setField('WEBSITE', $reqWebsite);
	$sekolah->setField('ALAMAT', $reqAlamat);
	$sekolah->setField('APPROVAL_DESC', $reqApproval);
	$sekolah->setField('REKOMENDASI_N', $reqRekomN);
	$sekolah->setField('REKOMENDASI_T', $reqRekomT);
	$sekolah->setField('SERTIFIKAT', $reqSertifikat);
	$sekolah->setField('TGL_SERTIFIKAT', dateToDBCheck($reqTglSertifikat));
	$sekolah->setField("LAST_UPDATE_USER", $userLogin->nama);
	$sekolah->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	if($sekolah->update())
		echo '{success:true, error:null, "keterangan":"Data berhasil disimpan!"}';
}
?>