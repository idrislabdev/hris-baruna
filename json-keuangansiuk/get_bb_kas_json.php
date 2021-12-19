<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrBukuBesar.php");

/* create objects */

/* LOGIN CHECK */

$reqKdBukuBesarId = httpFilterGet("reqKdBukuBesarId");

//$reqNoBukuBesarKasId = 'A.11';
//$reqTahun = 3;

$kbbr_buku_besar = new KbbrBukuBesar();
$kbbr_buku_besar->selectByParams(array('KD_BUKU_BESAR'=>$reqKdBukuBesarId));
$kbbr_buku_besar->firstRow();

$tempNmBukuBesar = $kbbr_buku_besar->getField('NM_BUKU_BESAR');
 
$arrFinal = array("NM_BUKU_BESAR" => $tempNmBukuBesar);
echo json_encode($arrFinal);
?>