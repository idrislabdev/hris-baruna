<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/LaporanKeuangan.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");

$laporan_keuangan = new LaporanKeuangan();
$kbbr_thn_buku_d = new KbbrThnBukuD();

$reqPeriode = httpFilterGet("reqPeriode");

$reqBulan = substr($reqPeriode,0, 2);
$reqTahun = substr($reqPeriode,2, 4);

$status_closing = $kbbr_thn_buku_d->getStatusClosing(array("THN_BUKU" => $reqTahun, "BLN_BUKU" => $reqBulan));

if($status_closing == "O")
{
	$laporan_keuangan->setField("BULAN", $reqBulan);
	$laporan_keuangan->setField("TAHUN", $reqTahun);	
	$laporan_keuangan->callArusKas();
	
	$laporan_keuangan->setField("BULAN", $reqBulan);
	$laporan_keuangan->setField("TAHUN", $reqTahun);	
	$laporan_keuangan->callLb4New();	
}

$arrFinal = array("STATUS" => 1);

echo json_encode($arrFinal);
?>