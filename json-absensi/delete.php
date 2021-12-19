<?
//include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");

$reqId = $_GET['id'];
$reqMode = $_GET['reqMode'];

/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/
if($reqMode == "master_jam_kerja")
{
	include_once("../WEB-INF/classes/base-absensi/JamKerja.php");
	$jam_kerja	= new JamKerja();
	$jam_kerja->setField('JAM_KERJA_ID', $reqId);
	if($jam_kerja->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$jam_kerja->getErrorMsg();
}
elseif($reqMode == "master_hari_libur")
{
	include_once("../WEB-INF/classes/base-absensi/HariLibur.php");
	$hari_libur	= new HariLibur();
	$hari_libur->setField('HARI_LIBUR_ID', $reqId);
	if($hari_libur->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$hari_libur->getErrorMsg();
}
elseif($reqMode == "absensi")
{
	include_once("../WEB-INF/classes/base-absensi/Absensi.php");
	$absensi = new Absensi();
	$absensi->setField('ABSENSI_ID', $reqId);
	if($absensi->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$absensi->getErrorMsg();
}
elseif($reqMode == "absensi_ijin_cuti")
{
	include_once("../WEB-INF/classes/base-absensi/AbsensiIjin.php");
	$absensi_ijin = new AbsensiIjin();
	$absensi_ijin->setField('ABSENSI_IJIN_ID', $reqId);
	if($absensi_ijin->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$absensi_ijin->getErrorMsg();
}
elseif($reqMode == "absensi_lembur")
{
	include_once("../WEB-INF/classes/base-absensi/Lembur.php");
	$lembur = new Lembur();
	$lembur->setField('LEMBUR_ID', $reqId);
	if($lembur->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$lembur->getErrorMsg();
}
elseif($reqMode == "master_jam_kerja_jenis")
{
	include_once("../WEB-INF/classes/base-absensi/JamKerjaJenis.php");
	$jam_kerja_jenis = new JamKerjaJenis();
	$jam_kerja_jenis->setField('JAM_KERJA_JENIS_ID', $reqId);
	if($jam_kerja_jenis->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$jam_kerja_jenis->getErrorMsg();
}
?>
