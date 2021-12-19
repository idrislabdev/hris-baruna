<?
//include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");

$reqId = $_GET['reqId'];
$reqMode = $_GET['reqMode'];


include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasiD.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranOverBudget.php");

$overbudget	= new AnggaranOverBudget();
$anggaran = new AnggaranMutasi();
$anggaran_cek = new AnggaranMutasi();
$anggaran_detail = new AnggaranMutasiD();
$anggaran->setField('ANGGARAN_MUTASI_ID', $reqId);
$anggaran_cek->setField('ANGGARAN_MUTASI_ID', $reqId);
$overbudget->setField('ANGGARAN_MUTASI_ID', $reqId);
$anggaran_detail->setField('ANGGARAN_MUTASI_ID', $reqId);

$anggaran_cek->getStatusBolehDelete();
$anggaran_cek->firstRow();
$status_boleh_delete = $anggaran_cek->getField('STATUS_DELETE');

if($status_boleh_delete == 'BOLEH'){
	$anggaran->delete();
	$anggaran_detail->delete();
	$overbudget->delete();
	$alertMsg .= "Data berhasil dihapus";
}
else{
	$alertMsg .= "Data telah diaaprove jadi tidak bisa dihapus";
}
echo $alertMsg
?>
