<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasiD.php");

$reqKdBukuBesar = httpFilterGet("reqKdBukuBesar");
$reqKdBukuPusat = httpFilterGet("reqKdBukuPusat");
$reqJumlah = httpFilterGet("reqJumlah");
$reqId = httpFilterGet("reqId");

$anggaran_mutasi_d = new AnggaranMutasiD();
$anggaran_belum_posting = $anggaran_mutasi_d->getSumByParams(array("KD_BUKU_BESAR" => $reqKdBukuBesar, "KD_BUKU_PUSAT" => $reqKdBukuPusat), " AND NVL(VERIFIKASI, 'S') = 'S' AND NOT A.ANGGARAN_MUTASI_ID = NVL('".$reqId."', 0) ");

include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtNeracaAngg.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrBukuBesar.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrBukuPusat.php");


/* create objects */
$kbbt_neraca_angg = new KbbtNeracaAngg();
$kbbr_buku_besar = new KbbrBukuBesar();
$kbbr_buku_pusat = new KbbrBukuPusat();

$kbbr_buku_besar->selectByParams(array("KD_BUKU_BESAR" => $reqKdBukuBesar));
$kbbr_buku_besar->firstRow();
$kbbr_buku_pusat->selectByParams(array("KD_BUKU_BESAR" => $reqKdBukuPusat));
$kbbr_buku_pusat->firstRow();

$kbbt_neraca_angg->selectByParamsMaintenanceAnggaran(array("KD_BUKU_BESAR" => $reqKdBukuBesar, "KD_BUKU_PUSAT" => $reqKdBukuPusat, "THN_BUKU" => date("Y")));
$kbbt_neraca_angg->firstRow();

$sisa = $kbbt_neraca_angg->getField("SISA");
$posisi_sekarang = $sisa - $reqJumlah - $anggaran_belum_posting; 


if($reqKdBukuBesar == "" || $reqKdBukuPusat == "") 
	$nilai = "2";
else
{   
	if($posisi_sekarang < 0) 
		$nilai = "0";
	else
		$nilai = "1";
}
$arrFinal = array("NILAI" => $nilai);
echo json_encode($arrFinal);
?>