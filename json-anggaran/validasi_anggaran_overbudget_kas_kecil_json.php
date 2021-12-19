<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranKasKecil.php");

$anggaran_kas_kecil = new AnggaranKasKecil();

$reqPuspel = httpFilterGet("reqPuspel");
$reqPuspelNama = httpFilterGet("reqPuspelNama");
$reqJumlah = httpFilterGet("reqJumlah");

$anggaran_kas_kecil->selectByParams(array("PUSPEL" => $reqPuspel, "TAHUN" => date("Y")));
$anggaran_kas_kecil->firstRow();

$sisa = $anggaran_kas_kecil->getField("JUMLAH");
$posisi_sekarang = $sisa - $reqJumlah;
$overbudget = 0;
if($posisi_sekarang >= 0) 
	$nilai = "0";
else
{
	$nilai = "1";
	$overbudget = 0 - $posisi_sekarang;
}
$arrFinal = array("NILAI" => $nilai, "OVERBUDGET" => $overbudget);
echo json_encode($arrFinal);
?>