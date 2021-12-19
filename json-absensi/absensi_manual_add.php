<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiManual.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$absensi_manual = new AbsensiManual();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqPegawaiId= httpFilterPost("reqPegawaiId");
$reqStatus= httpFilterPost("reqStatus");
$reqBukti= httpFilterPost("reqBukti");
$reqJam= " TO_DATE('".httpFilterPost("reqJam")."', 'DD-MM-YYYY HH24:MI:SS') ";
$reqKeterangan= httpFilterPost("reqKeterangan");
if($reqMode == "insert")
{

	$absensi_manual->setField('ABSENSI_MANUAL_ID', 0);
	$absensi_manual->setField('PEGAWAI_ID', $reqPegawaiId);
	$absensi_manual->setField('STATUS', $reqStatus);
	$absensi_manual->setField('BUKTI', $reqBukti);
	$absensi_manual->setField('JAM', $reqJam);
	$absensi_manual->setField('KETERANGAN', $reqKeterangan);

	$absensi_manual->setField("LAST_CREATE_USER", $userLogin->nama);
	$absensi_manual->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	
	if($absensi_manual->insert())
		echo "Data berhasil disimpan.";
}
else
{	
	$absensi_manual->setField('ABSENSI_MANUAL_ID', $reqId);
	$absensi_manual->setField('PEGAWAI_ID', $reqPegawaiId);
	$absensi_manual->setField('STATUS', $reqStatus);
	$absensi_manual->setField('BUKTI', $reqBukti);
	$absensi_manual->setField('JAM',$reqJam);
	$absensi_manual->setField('KETERANGAN', $reqKeterangan);
	$absensi_manual->setField("LAST_UPDATE_USER", $userLogin->nama);
	$absensi_manual->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	
	if($absensi_manual->update()) {
		//echo $absensi_manual->query;
		echo "Data berhasil disimpan.";
	}
}
?>