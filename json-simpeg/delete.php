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
if($reqMode == "hubungan_keluarga")
{
	include_once("../WEB-INF/classes/base-simpeg/HubunganKeluarga.php");
	$hubungan_keluarga	= new HubunganKeluarga();
	$hubungan_keluarga->setField('HUBUNGAN_KELUARGA_ID', $reqId);
	if($hubungan_keluarga->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$hubungan_keluarga->getErrorMsg();
}elseif($reqMode == "universitas")
{
	include_once("../WEB-INF/classes/base-simpeg/Universitas.php");
	$universitas	= new Universitas();
	$universitas->setField('UNIVERSITAS_ID', $reqId);
	if($universitas->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$universitas->getErrorMsg();
}
elseif($reqMode == "pendidikan_biaya")
{
	include_once("../WEB-INF/classes/base-simpeg/PendidikanBiaya.php");
	$pendidikan_biaya= new PendidikanBiaya();
	$pendidikan_biaya->setField('PENDIDIKAN_BIAYA_ID', $reqId);
	if($pendidikan_biaya->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$pendidikan_biaya->getErrorMsg();
}
elseif($reqMode == "pendidikan")
{
	include_once("../WEB-INF/classes/base-simpeg/Pendidikan.php");
	$pendidikan= new Pendidikan();
	$pendidikan->setField('PENDIDIKAN_ID', $reqId);
	if($pendidikan->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$pendidikan->getErrorMsg();
}
elseif($reqMode == "pejabat_penetap")
{
	include_once("../WEB-INF/classes/base-simpeg/PejabatPenetap.php");
	$pejabat_penetap= new PejabatPenetap();
	$pejabat_penetap->setField('PEJABAT_PENETAP_ID', $reqId);
	if($pejabat_penetap->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$pejabat_penetap->getErrorMsg();
}
elseif($reqMode == "pangkat_perubahan_kode")
{
	include_once("../WEB-INF/classes/base-simpeg/PangkatPerubahanKode.php");
	$pangkat_perubahan_kode= new PangkatPerubahanKode();
	$pangkat_perubahan_kode->setField('PANGKAT_PERUBAHAN_KODE_ID', $reqId);
	if($pangkat_perubahan_kode->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$pangkat_perubahan_kode->getErrorMsg();
}
elseif($reqMode == "pangkat_kode")
{
	include_once("../WEB-INF/classes/base-simpeg/PangkatKode.php");
	$pangkat_kode= new PangkatKode();
	$pangkat_kode->setField('PANGKAT_KODE_ID', $reqId);
	if($pangkat_kode->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$pangkat_kode->getErrorMsg();
}elseif($reqMode == "pangkat")
{
	include_once("../WEB-INF/classes/base-simpeg/Pangkat.php");
	$pangkat= new Pangkat();
	$pangkat->setField('PANGKAT_ID', $reqId);
	if($pangkat->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$pangkat->getErrorMsg();
}
elseif($reqMode == "jabatan")
{
	include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");
	$jabatan= new Jabatan();
	$jabatan->setField('JABATAN_ID', $reqId);
	if($jabatan->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$jabatan->getErrorMsg();
}
elseif($reqMode == "agama")
{
	include_once("../WEB-INF/classes/base-simpeg/Agama.php");
	$agama= new Agama();
	$agama->setField('AGAMA_ID', $reqId);
	if($agama->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$agama->getErrorMsg();
}
elseif($reqMode == "bank")
{
	include_once("../WEB-INF/classes/base-simpeg/Bank.php");
	$bank	= new Bank();
	$bank->setField('BANK_ID', $reqId);
	if($bank->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$bank->getErrorMsg();
}
elseif($reqMode == "status_pegawai")
{
	include_once("../WEB-INF/classes/base-simpeg/StatusPegawai.php");
	$status_pegawai	= new StatusPegawai();
	$status_pegawai->setField('STATUS_PEGAWAI_ID', $reqId);
	if($status_pegawai->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$status_pegawai->getErrorMsg();
}
elseif($reqMode == "pegawai")
{
	include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
	$pegawai	= new Pegawai();
	$pegawai->setField('PEGAWAI_ID', $reqId);
	if($pegawai->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$pegawai->getErrorMsg();
}
elseif($reqMode == "cuti_tahunan")
{
	include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");
	$cuti_tahunan	= new CutiTahunan();
	$cuti_tahunan->setField('CUTI_TAHUNAN_ID', $reqId);
	if($cuti_tahunan->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$cuti_tahunan->getErrorMsg();
}
?>
