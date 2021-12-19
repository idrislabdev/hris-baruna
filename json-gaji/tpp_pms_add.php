<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/TppPMS.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$tpp_pms = new TppPMS();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKelas = httpFilterPost("reqKelas");
$reqTunjanganPrestasi = httpFilterPost("reqTunjanganPrestasi");
$reqMinJamMengajar = httpFilterPost("reqMinJamMengajar");
$reqTarifKelebihan = httpFilterPost("reqTarifKelebihan");
$reqMaxKelebihan = httpFilterPost("reqMaxKelebihan");
$reqMaxPotongan = httpFilterPost("reqMaxPotongan");
$reqKelompokPegawai = httpFilterPost("reqKelompokPegawai");
$reqKelompokPegawaiPendidik = httpFilterPost("reqKelompokPegawaiPendidik");

if($reqMode == "insert")
{
	$tpp_pms->setField("KELOMPOK_PEGAWAI", $reqKelompokPegawai);
	$tpp_pms->setField("KELAS", $reqKelas);
	$tpp_pms->setField("TUNJANGAN_PRESTASI", dotToNo($reqTunjanganPrestasi));
	$tpp_pms->setField("MIN_JAM_MENGAJAR", dotToNo($reqMinJamMengajar));
	$tpp_pms->setField("TARIF_KELEBIHAN", dotToNo($reqTarifKelebihan));
	$tpp_pms->setField("MAX_KELEBIHAN", dotToNo($reqMaxKelebihan));
	$tpp_pms->setField("MAX_POTONGAN", dotToNo($reqMaxPotongan));
	
	if($tpp_pms->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$tpp_pms->setField("TPP_PMS_ID", $reqId);
	$tpp_pms->setField("KELOMPOK_PEGAWAI", $reqKelompokPegawai);
	$tpp_pms->setField("KELOMPOK_PENDIDIK", $reqKelompokPegawaiPendidik);
	$tpp_pms->setField("KELAS", $reqKelas);
	$tpp_pms->setField("TUNJANGAN_PRESTASI", dotToNo($reqTunjanganPrestasi));
	$tpp_pms->setField("MIN_JAM_MENGAJAR", dotToNo($reqMinJamMengajar));
	$tpp_pms->setField("TARIF_KELEBIHAN", dotToNo($reqTarifKelebihan));
	$tpp_pms->setField("MAX_KELEBIHAN", dotToNo($reqMaxKelebihan));
	$tpp_pms->setField("MAX_POTONGAN", dotToNo($reqMaxPotongan));
	$tpp_pms->setField("LAST_UPDATE_USER", "");
	$tpp_pms->setField("LAST_UPDATE_DATE", "SYSDATE");
	
	if($tpp_pms->update())
		echo "Data berhasil disimpan.";
	
}
?>