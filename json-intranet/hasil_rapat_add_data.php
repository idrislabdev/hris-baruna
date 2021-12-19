<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/HasilRapat.php");
include_once("../WEB-INF/classes/base/HasilRapatDepartemen.php");
include_once("../WEB-INF/classes/base/HasilRapatJabatan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$hasil_rapat			= new HasilRapat();
$hasil_rapat_departemen = new HasilRapatDepartemen();
$hasil_rapat_jabatan	= new HasilRapatJabatan();

$reqId			= httpFilterPost("reqId");
$reqMode		= httpFilterPost("reqMode");
$reqDepartemen	= httpFilterPost("reqDepartemen");
$reqJabatan		= httpFilterPost("reqJabatan");
$reqTanggal		= httpFilterPost("reqTanggal");		
$reqNama		= httpFilterPost("reqNama");
	
$hasil_rapat_departemen->setField("HASIL_RAPAT_ID", $reqId);
$hasil_rapat_departemen->delete();	

$hasil_rapat_jabatan->setField("HASIL_RAPAT_ID", $reqId);
$hasil_rapat_jabatan->delete();	

if($reqMode == "insert") {
	if(preg_match('/Kantor/',$reqDepartemen)) $hasil_rapat->setField("DEPARTEMEN_ID", "CAB1");
	
	$hasil_rapat->setField("NAMA", $reqNama);
	$hasil_rapat->setField("TANGGAL", dateToDBCheck($reqTanggal));
	$hasil_rapat->setField("USER_LOGIN_ID", $userLogin->UID);
	$hasil_rapat->setField("LAST_CREATE_USER", $userLogin->nama);
	$hasil_rapat->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	
	if($hasil_rapat->insert()) {
		$hasil_rapat_departemen->setField("DEPARTEMEN", $reqDepartemen);
		$hasil_rapat_departemen->setField("HASIL_RAPAT_ID", $hasil_rapat->id);
		$hasil_rapat_departemen->insert();
		
		$hasil_rapat_jabatan->setField("JABATAN", $reqJabatan);
		$hasil_rapat_jabatan->setField("HASIL_RAPAT_ID", $hasil_rapat->id);
		$hasil_rapat_jabatan->insert();

		echo $hasil_rapat->id."-Data berhasil disimpan.";
	}
}
else {
	if(preg_match('/Kantor/',$reqDepartemen)) $hasil_rapat->setField("DEPARTEMEN_ID", "CAB1");
	
	$hasil_rapat->setField("HASIL_RAPAT_ID", $reqId);
	$hasil_rapat->setField("NAMA", $reqNama);
	$hasil_rapat->setField("TANGGAL", dateToDBCheck($reqTanggal));
	$hasil_rapat->setField("USER_LOGIN_ID", $userLogin->UID);
	
	$hasil_rapat->setField("LAST_UPDATE_USER", $userLogin->nama);
	$hasil_rapat->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	
	if($hasil_rapat->update()) {
		$hasil_rapat_departemen->setField("DEPARTEMEN", $reqDepartemen);
		$hasil_rapat_departemen->setField("HASIL_RAPAT_ID", $reqId);
		$hasil_rapat_departemen->insert();
		
		$hasil_rapat_jabatan->setField("JABATAN", $reqJabatan);
		$hasil_rapat_jabatan->setField("HASIL_RAPAT_ID", $reqId);
		$hasil_rapat_jabatan->insert();
				
		echo $reqId."-Data berhasil disimpan.";
	}
}
?>