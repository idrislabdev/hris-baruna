<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
include_once("../WEB-INF/classes/base-gaji/Gaji.php");

$gaji_awal_bulan = new GajiAwalBulan();

$reqGajiPerbantuan = httpFilterPost("reqGajiPerbantuan");
$reqGajiDewanDireksi = httpFilterPost("reqGajiDewanDireksi");
$reqGajiPttpk = httpFilterPost("reqGajiPttpk");
$reqGajiPkwt = httpFilterPost("reqGajiPkwt");
$reqGajiPkwtKhusus= httpFilterPost("reqGajiPkwtKhusus");
$reqBayarAwal = httpFilterPost("reqBayarAwal");
$reqBayarAkhir = httpFilterPost("reqBayarAkhir");
$reqGajiOrganik =httpFilterPost("reqGajiOrganik");

if($reqGajiPerbantuan == 1)
{
	$gaji_awal_bulan_proses = new GajiAwalBulan();
	$gaji_awal_bulan_proses->setField("PERIODE", $reqBayarAwal);
	$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "2");		
	$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();
	//echo $gaji_awal_bulan_proses->query;exit;
	unset($gaji_awal_bulan_proses);
	//echo 'Gaji Berhasil Diproses ';
}

if($reqGajiDewanDireksi == 1)
{
	$gaji_awal_bulan_proses = new GajiAwalBulan();
	$gaji_awal_bulan_proses->setField("PERIODE", $reqBayarAwal);
	$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "6,7");		
	$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();		
	//echo $gaji_awal_bulan_proses->query;exit;
	unset($gaji_awal_bulan_proses);
	//echo 'Gaji Berhasil Diproses ';
}

if($reqGajiOrganik == 1)
{
	$gaji_awal_bulan_proses = new GajiAwalBulan();
	$gaji_awal_bulan_proses->setField("PERIODE", $reqBayarAkhir);
	$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "1");		
	$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();		
	//echo $gaji_awal_bulan_proses->query;exit;
	unset($gaji_awal_bulan_proses);
	//echo 'Gaji Berhasil Diproses ';
}

if($reqGajiPttpk == 1)
{
	$gaji_awal_bulan_proses = new GajiAwalBulan();
	$gaji_awal_bulan_proses->setField("PERIODE", $reqBayarAkhir);
	$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "5");		
	$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();
	//echo $gaji_awal_bulan_proses->query;exit;
	unset($gaji_awal_bulan_proses);
	//echo 'Gaji Berhasil Diproses ';
}

if($reqGajiPkwt == 1)
{
	$gaji_awal_bulan_proses = new GajiAwalBulan();
	$gaji_awal_bulan_proses->setField("PERIODE", $reqBayarAkhir);
	$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "3");		
	$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();
	//echo $gaji_awal_bulan_proses->query;exit;
	unset($gaji_awal_bulan_proses);
	
}

if($reqGajiPkwtKhusus == 1)
{
	$gaji_awal_bulan_proses = new GajiAwalBulan();
	$gaji_awal_bulan_proses->setField("PERIODE", $reqBayarAkhir);
	$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "12");		
	$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();
	//echo $gaji_awal_bulan_proses->query;exit;
	unset($gaji_awal_bulan_proses);
	
}

	echo 'Gaji Berhasil Diproses ';
?>