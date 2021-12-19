<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");

$kbbr_tipe_trans_d = new KbbrTipeTransD();

$reqTipeTrans = httpFilterGet("reqTipeTrans");
$reqRow = httpFilterGet("reqRow");
$reqKey = httpFilterGet("reqKey");

$kbbr_tipe_trans_d->selectByParams(array("TIPE_TRANS" => $reqTipeTrans), -1, -1, " AND (KD_AKTIF = 'A' OR KD_AKTIF IS NULL) ");

$arrId[0] =  "";
$arrNama[0] = "";
$arrKenaPajak[0] = "";
$i = 1;
while($kbbr_tipe_trans_d->nextRow())
{
	$arrId[$i] =  $kbbr_tipe_trans_d->getField("KLAS_TRANS");
	$arrNama[$i] =  $kbbr_tipe_trans_d->getField("KETK_TRANS");
	$arrKenaPajak[$i] = $kbbr_tipe_trans_d->getField("STATUS_KENA_PAJAK");
	$i += 1;
}
	$arrFinal = array("KLAS_TRANS" => $arrId, 
					  "KETK_TRANS" => $arrNama,
					  "STATUS_KENA_PAJAK" => $arrKenaPajak);
	echo json_encode($arrFinal);
?>