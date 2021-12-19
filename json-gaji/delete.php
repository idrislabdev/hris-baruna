<?
//include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");

$reqId = $_GET['id'];
$reqRowId = $_GET['reqRowId'];
$reqMode = $_GET['reqMode'];

$reqPeriode = $_GET['reqPeriode'];
$reqKondisiId = $_GET['reqKondisiId'];


/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/
if($reqMode == "merit_p3")
{
	include_once("../WEB-INF/classes/base-gaji/MeritP3.php");
	$merit_p3	= new MeritP3();
	$merit_p3->setField('MERIT_P3_ID', $reqId);
	if($merit_p3->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$merit_p3->getErrorMsg();
}
else if($reqMode == "merit_pms")
{
	include_once("../WEB-INF/classes/base-gaji/MeritPMS.php");
	$merit_pms	= new MeritPMS();
	$merit_pms->setField('MERIT_PMS_ID', $reqId);
	if($merit_pms->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$merit_pms->getErrorMsg();
}
else if($reqMode == "merit_harian")
{
	include_once("../WEB-INF/classes/base-gaji/MeritHarian.php");
	$merit_harian	= new MeritHarian();
	$merit_harian->setField('MERIT_HARIAN_ID', $reqId);
	if($merit_harian->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$merit_harian->getErrorMsg();
}
else if($reqMode == "tpp_pegawai")
{
	include_once("../WEB-INF/classes/base-gaji/TppPegawai.php");
	$tpp_harian	= new TppPegawai();
	$tpp_harian->setField('TPP_PEGAWAI_ID', $reqId);
	if($tpp_harian->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$tpp_harian->getErrorMsg();
}
else if($reqMode == "tpp_p3")
{
	include_once("../WEB-INF/classes/base-gaji/TppP3.php");
	$tpp_p3	= new TppP3();
	$tpp_p3->setField('TPP_P3_ID', $reqId);
	if($tpp_p3->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$tpp_p3->getErrorMsg();
}
else if($reqMode == "tpp_pms")
{
	include_once("../WEB-INF/classes/base-gaji/TppPMS.php");
	$tpp_pms = new TppPMS();
	$tpp_pms->setField('TPP_PMS_ID', $reqId);
	if($tpp_pms->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$tpp_pms->getErrorMsg();
}
else if($reqMode == "tunjangan_jabatan")
{
	include_once("../WEB-INF/classes/base-gaji/TunjanganJabatan.php");
	$tunjangan_jabatan = new TunjanganJabatan();
	$tunjangan_jabatan->setField('TUNJANGAN_JABATAN_ID', $reqId);
	if($tunjangan_jabatan->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$tunjangan_jabatan->getErrorMsg();
}
else if($reqMode == "tunjangan_perbantuan_a")
{
	include_once("../WEB-INF/classes/base-gaji/TunjanganPerbantuanA.php");
	$tunjangan_perbantuan_a = new TunjanganPerbantuanA();
	$tunjangan_perbantuan_a->setField('TUNJANGAN_PERBANTUAN_A_ID', $reqId);
	if($tunjangan_perbantuan_a->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$tunjangan_perbantuan_a->getErrorMsg();
}
else if($reqMode == "tunjangan_perbantuan_b")
{
	include_once("../WEB-INF/classes/base-gaji/TunjanganPerbantuanB.php");
	$tunjangan_perbantuan_b = new TunjanganPerbantuanB();
	$tunjangan_perbantuan_b->setField('TUNJANGAN_PERBANTUAN_B_ID', $reqId);
	if($tunjangan_perbantuan_b->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$tunjangan_perbantuan_b->getErrorMsg();
}
elseif($reqMode == "insentif")
{
	include_once("../WEB-INF/classes/base-gaji/Insentif.php");
	$insentif	= new Insentif();
	$insentif->setField('INSENTIF_ID', $reqId);
	if($insentif->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$insentif->getErrorMsg();
}
elseif($reqMode == "premi")
{
	include_once("../WEB-INF/classes/base-gaji/Premi.php");
	$premi	= new Premi();
	$premi->setField('PREMI_ID', $reqId);
	if($premi->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$premi->getErrorMsg();
}
elseif($reqMode == "unit_link")
{
	include_once("../WEB-INF/classes/base-gaji/UnitLink.php");
	$unit_link	= new UnitLink();
	$unit_link->setField('UNIT_LINK_ID', $reqId);
	if($unit_link->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$unit_link->getErrorMsg();
}
elseif($reqMode == "parameter_potongan_wajib")
{
	include_once("../WEB-INF/classes/base-gaji/ParameterPotonganWajib.php");
	$parameter_potongan_wajib	= new ParameterPotonganWajib();
	$parameter_potongan_wajib->setField('JENIS_POTONGAN_ID', $reqId);
	$parameter_potongan_wajib->setField('KELAS_ID', $reqRowId);
	if($parameter_potongan_wajib->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$parameter_potongan_wajib->getErrorMsg();
}
elseif($reqMode == "asuransi")
{
	include_once("../WEB-INF/classes/base-gaji/Asuransi.php");
	$asuransi	= new Asuransi();
	$asuransi->setField('ASURANSI_ID', $reqId);
	if($asuransi->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$asuransi->getErrorMsg();
}
elseif($reqMode == "gaji_kondisi")
{
	include_once("../WEB-INF/classes/base-gaji/GajiKondisi.php");
	$gaji_kondisi	= new GajiKondisi();
	$gaji_kondisi->setField('GAJI_KONDISI_ID', $reqId);
	if($gaji_kondisi->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$gaji_kondisi->getErrorMsg();
}
elseif($reqMode == "integrasi_potongan")
{
	// echo $reqMode; exit();
	include_once("../WEB-INF/classes/base-gaji/IntegrasiPotongan.php");
	$integrasi_potongan	= new IntegrasiPotongan();
	$integrasi_potongan->setField('PEGAWAI_ID', $reqId);
	$integrasi_potongan->setField('PERIODE', coalesce($reqPeriode, '0'));
	$integrasi_potongan->setField('POTONGAN_KONDISI_ID', $reqKondisiId);
	if($integrasi_potongan->deleteParent())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$integrasi_potongan->getErrorMsg();
}
elseif($reqMode == "integrasi_tunjangan")
{
	// echo $reqMode; exit();
	include_once("../WEB-INF/classes/base-gaji/GajiKondisiPegawai.php");
	$gaji_kondisi_pegawai	= new GajiKondisiPegawai();
	$gaji_kondisi_pegawai->setField('GAJI_KONDISI_PEGAWAI_ID', $reqId);
	if($gaji_kondisi_pegawai->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$gaji_kondisi_pegawai->getErrorMsg();
}
elseif($reqMode == "pegawai_kecuali_jabatan")
{
	// echo $reqMode; exit();
	include_once("../WEB-INF/classes/base-gaji/PegawaiKecualiJabatan.php");
	$pegawai_kecuali_jabatan	= new PegawaiKecualiJabatan();
	$pegawai_kecuali_jabatan->setField('PEGAWAI_KECUALI_JABATAN_ID', $reqId);
	if($pegawai_kecuali_jabatan->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$pegawai_kecuali_jabatan->getErrorMsg();
}
elseif($reqMode == "tarif_transport")
{
	// echo $reqMode; exit();
	include_once("../WEB-INF/classes/base-gaji/TarifTransport.php");
	$tarif_transport	= new TarifTransport();
	$tarif_transport->setField('TARIF_TRANSPORT_ID', $reqId);
	if($tarif_transport->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$tarif_transport->getErrorMsg();
}
else if($reqMode == "tunjangan_masa_kerja")
{
	include_once("../WEB-INF/classes/base-gaji/TunjanganMasaKerja.php");
	$tunjangan_masa_kerja = new TunjanganMasaKerja();

	$tunjangan_masa_kerja->setField('TUNJANGAN_MASA_KERJA_ID', $reqId);
	if($tunjangan_masa_kerja->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$tunjangan_masa_kerja->getErrorMsg();
}
?>
