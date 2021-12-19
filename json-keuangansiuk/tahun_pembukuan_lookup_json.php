<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBuku.php");

$tahun_pembukuan = new KbbrThnBuku();

$reqTahun= httpFilterGet("reqTahun");
$reqTahunTemp= httpFilterGet("reqTahunTemp");

if($reqTahunTemp == "")
{
	$tahun_pembukuan->selectByParams(array('THN_BUKU'=>$reqTahun));
}
else
{
	$tahun_pembukuan->selectByParams(array('THN_BUKU'=>$reqTahun, "NOT THN_BUKU" => $reqTahunTemp));
}

$tahun_pembukuan->firstRow();

$arrFinal = array("TAHUN" => $tahun_pembukuan->getField("THN_BUKU"));

echo json_encode($arrFinal);
?>