<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiIjin.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$absensi_ijin = new AbsensiIjin();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqPegawaiId= httpFilterPost("reqPegawaiId");
$reqNRP= httpFilterPost("reqNRP");
$reqNama= httpFilterPost("reqNama");
$reqDepartemenId= httpFilterPost("reqDepartemenId");
$reqDepartemen= httpFilterPost("reqDepartemen");
$reqIjinId= httpFilterPost("reqIjinId");
$reqTanggalAwal= httpFilterPost("reqTanggalAwal");
$reqTanggalAkhir= httpFilterPost("reqTanggalAkhir");

/*
$reqStatusKeteranganSakit= httpFilterPost("reqStatusKeteranganSakit");
$reqStatusKeteranganCuti= httpFilterPost("reqStatusKeteranganCuti");

$reqKeteranganSakit= httpFilterPost("reqKeteranganSakit");
$reqKeteranganCuti= httpFilterPost("reqKeteranganCuti");
*/
$tempKeterangan = httpFilterPost("reqKeterangan");

if($reqMode == "insert")
{
	/*
	if($reqStatusKeteranganSakit == '3' || $reqKeteranganSakit)
		$tempKeterangan= $reqKeteranganSakit;
	elseif($reqStatusKeteranganCuti == '1')
		$tempKeterangan= $reqKeteranganCuti;
	else
		$tempKeterangan= '';
	*/
	$absensi_ijin->setField('KETERANGAN', $tempKeterangan);
	
	$absensi_ijin->setField('IJIN_ID', $reqIjinId);
	$absensi_ijin->setField('PEGAWAI_ID', $reqPegawaiId);
	$absensi_ijin->setField('DEPARTEMEN_ID', $reqDepartemenId);
	$absensi_ijin->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
	$absensi_ijin->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
	//$absensi_ijin->setField('VALIDASI', 0);
	$absensi_ijin->setField("LAST_CREATE_USER", $userLogin->nama);
	$absensi_ijin->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	
	if($absensi_ijin->insert())
		echo "Data berhasil disimpan.";
}
else
{
	/*
	if($reqStatusKeteranganSakit == '3' || $reqKeteranganSakit)
		$tempKeterangan= $reqKeteranganSakit;
	elseif($reqStatusKeteranganCuti == '1')
		$tempKeterangan= $reqKeteranganCuti;
	else
		$tempKeterangan= '';
	*/	
	
	$absensi_ijin->setField('KETERANGAN', $tempKeterangan);
	
	$absensi_ijin->setField('ABSENSI_IJIN_ID', $reqId);
	$absensi_ijin->setField('IJIN_ID', $reqIjinId);
	$absensi_ijin->setField('PEGAWAI_ID', $reqPegawaiId);
	$absensi_ijin->setField('DEPARTEMEN_ID', $reqDepartemenId);
	$absensi_ijin->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
	$absensi_ijin->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
	//$absensi_ijin->setField('VALIDASI', 0);
	$absensi_ijin->setField("LAST_UPDATE_USER", $userLogin->nama);
	$absensi_ijin->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($absensi_ijin->update())
		echo "Data berhasil disimpan.";
	//echo $tempKeterangan.'---'.$reqStatusKeteranganSakit.'---'.$reqStatusKeteranganCuti;
}
?>