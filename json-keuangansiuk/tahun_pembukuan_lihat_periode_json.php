<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");

$tahun_buku_detil = new KbbrThnBukuD();

$reqPeriode= httpFilterGet("reqPeriode");
$reqId= httpFilterGet("reqId");

$tahun_buku_detil->selectByParams(array('THN_BUKU'=>getTahunPeriode($reqPeriode), "BLN_BUKU"=>getBulanPeriode($reqPeriode)));
$tahun_buku_detil->firstRow();

$arrFinal = array("PERIODE" => $tahun_buku_detil->getField("PERIODE"));

echo json_encode($arrFinal);
?>