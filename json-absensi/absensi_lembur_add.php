<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/Lembur.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$lembur = new Lembur();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqPegawaiId= httpFilterPost("reqPegawaiId");
$reqNRP= httpFilterPost("reqNRP");
$reqNama= httpFilterPost("reqNama");
$reqDepartemenId= httpFilterPost("reqDepartemenId");
$reqDepartemen= httpFilterPost("reqDepartemen");
$reqLembur= httpFilterPost("reqLembur");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqTanggalAwal= httpFilterPost("reqTanggalAwal");
$reqJamAwal= httpFilterPost("reqJamAwal");
$reqTanggalAkhir= httpFilterPost("reqTanggalAkhir");
$reqJamAkhir= httpFilterPost("reqJamAkhir");

if($reqMode == "insert")
{
	$reqJamTanggalAwal 	= $reqTanggalAwal.":".$reqJamAwal;
	$reqJamTanggalAkhir = $reqTanggalAkhir.":".$reqJamAkhir;

	$lembur->setField('PEGAWAI_ID', $reqPegawaiId);
	$lembur->setField('NAMA', $reqLembur);
	$lembur->setField('KETERANGAN', $reqKeterangan);
	$lembur->setField('JAM_AWAL', datetimeToDB($reqJamTanggalAwal));
	$lembur->setField('JAM_AKHIR', datetimeToDB($reqJamTanggalAkhir));
	$lembur->setField('DEPARTEMEN_ID', $reqDepartemenId);
	$lembur->setField("LAST_CREATE_USER", $userLogin->nama);
	$lembur->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
	
	if($lembur->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$reqJamTanggalAwal 	= $reqTanggalAwal.":".$reqJamAwal;
	$reqJamTanggalAkhir = $reqTanggalAkhir.":".$reqJamAkhir;
	
	$lembur->setField('LEMBUR_ID', $reqId); 
	$lembur->setField('PEGAWAI_ID', $reqPegawaiId);
	$lembur->setField('NAMA', $reqLembur);
	$lembur->setField('KETERANGAN', $reqKeterangan);
	$lembur->setField('JAM_AWAL', datetimeToDB($reqJamTanggalAwal));
	$lembur->setField('JAM_AKHIR', datetimeToDB($reqJamTanggalAkhir));
	$lembur->setField('DEPARTEMEN_ID', $reqDepartemenId);
	$lembur->setField("LAST_UPDATE_USER", $userLogin->nama);
	$lembur->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	
	if($lembur->update())
		echo "Data berhasil disimpan.";
}
?>