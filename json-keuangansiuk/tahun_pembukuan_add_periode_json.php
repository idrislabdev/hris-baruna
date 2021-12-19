<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-keuangan/TahunBukuDetil.php");

$tahun_buku_detil = new TahunBukuDetil();

$reqPeriode= httpFilterGet("reqPeriode");
$reqId= httpFilterGet("reqId");

$tahun_buku_detil->selectByParams(array('A.PERIODE'=>$reqPeriode, "A.TAHUN_BUKU_ID"=>$reqId));

/*if($reqNRPTemp == "")
{
	$tahun_buku_detil->selectByParams(array('A.NRP'=>$reqNRP));
}
else
{
	$tahun_buku_detil->selectByParams(array('A.NRP'=>$reqNRP, "NOT A.NRP" => $reqNRPTemp));
}*/

$tahun_buku_detil->firstRow();

$arrFinal = array("PERIODE" => $tahun_buku_detil->getField("PERIODE"));

echo json_encode($arrFinal);
?>