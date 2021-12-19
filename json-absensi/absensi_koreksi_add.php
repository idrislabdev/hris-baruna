<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiKoreksi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$absensi_koreksi = new AbsensiKoreksi();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqPeriode = httpFilterPost("reqPeriode");
$reqIjinId = $_POST["reqIjinId"];
$reqKoreksiHari = httpFilterPost("reqKoreksiHari");

$reqKategori = httpFilterPost("reqKategori");


$absensi_koreksi_delete = new AbsensiKoreksi();
$absensi_koreksi_delete->setField('PEGAWAI_ID', $reqId);
$absensi_koreksi_delete->setField('PERIODE', $reqPeriode);
$absensi_koreksi_delete->delete();


$absensi_koreksi->setField('PEGAWAI_ID', $reqId);
$absensi_koreksi->setField('PERIODE', $reqPeriode);
$absensi_koreksi->setField('HARI_1', $reqIjinId[0]);
$absensi_koreksi->setField('HARI_2', $reqIjinId[1]);
$absensi_koreksi->setField('HARI_3', $reqIjinId[2]);
$absensi_koreksi->setField('HARI_4', $reqIjinId[3]);
$absensi_koreksi->setField('HARI_5', $reqIjinId[4]);
$absensi_koreksi->setField('HARI_6', $reqIjinId[5]);
$absensi_koreksi->setField('HARI_7', $reqIjinId[6]);
$absensi_koreksi->setField('HARI_8', $reqIjinId[7]);
$absensi_koreksi->setField('HARI_9', $reqIjinId[8]);
$absensi_koreksi->setField('HARI_10', $reqIjinId[9]);
$absensi_koreksi->setField('HARI_11', $reqIjinId[10]);
$absensi_koreksi->setField('HARI_12', $reqIjinId[11]);
$absensi_koreksi->setField('HARI_13', $reqIjinId[12]);
$absensi_koreksi->setField('HARI_14', $reqIjinId[13]);
$absensi_koreksi->setField('HARI_15', $reqIjinId[14]);
$absensi_koreksi->setField('HARI_16', $reqIjinId[15]);
$absensi_koreksi->setField('HARI_17', $reqIjinId[16]);
$absensi_koreksi->setField('HARI_18', $reqIjinId[17]);
$absensi_koreksi->setField('HARI_19', $reqIjinId[18]);
$absensi_koreksi->setField('HARI_20', $reqIjinId[19]);
$absensi_koreksi->setField('HARI_21', $reqIjinId[20]);
$absensi_koreksi->setField('HARI_22', $reqIjinId[21]);
$absensi_koreksi->setField('HARI_23', $reqIjinId[22]);
$absensi_koreksi->setField('HARI_24', $reqIjinId[23]);
$absensi_koreksi->setField('HARI_25', $reqIjinId[24]);
$absensi_koreksi->setField('HARI_26', $reqIjinId[25]);
$absensi_koreksi->setField('HARI_27', $reqIjinId[26]);
$absensi_koreksi->setField('HARI_28', $reqIjinId[27]);
$absensi_koreksi->setField('HARI_29', $reqIjinId[28]);
$absensi_koreksi->setField('HARI_30', $reqIjinId[29]);
$absensi_koreksi->setField('HARI_31', $reqIjinId[30]);
$absensi_koreksi->setField('KOREKSI_MANUAL_HARI', $reqKoreksiHari);
$absensi_koreksi->setField('KATEGORI', $reqKategori);

if($absensi_koreksi->insert())
{
	echo "Data berhasil disimpan.";	
}

?>