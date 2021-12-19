<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");

/* create objects */

/* LOGIN CHECK */

$reqTipeTrans = httpFilterGet("reqTipeTrans");
$reqKlasTrans = httpFilterGet("reqKlasTrans");

$kbbr_tipe_trans_d = new KbbrTipeTransD();
$kbbr_tipe_trans_d->selectByParams(array("TIPE_TRANS"=>$reqTipeTrans, "KLAS_TRANS" => $reqKlasTrans), -1, -1, " AND (KD_AKTIF = 'A' OR KD_AKTIF IS NULL)");
$kbbr_tipe_trans_d->firstRow();

$tempStatusKenaPajak = $kbbr_tipe_trans_d->getField("STATUS_KENA_PAJAK");
$tempKdBukuBesar = $kbbr_tipe_trans_d->getField("KD_BUKU_BESAR1");
$tempKdBukuPusat = $kbbr_tipe_trans_d->getField("KD_BUKU_BESAR2");
$tempKD = $kbbr_tipe_trans_d->getField("KD_DK");

$arrFinal = array("STATUS_KENA_PAJAK" => $tempStatusKenaPajak, "KD_BUKU_BESAR" => $tempKdBukuBesar, "KD_DK" => $tempKD, "KD_BUKU_PUSAT" => $tempKdBukuPusat);
echo json_encode($arrFinal);
?>