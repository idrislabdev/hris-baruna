<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmBank.php");

/* create objects */

/* LOGIN CHECK */

$reqNoBukuBesarKasId = httpFilterGet("reqNoBukuBesarKasId");

//$reqNoBukuBesarKasId = 'A.11';
//$reqTahun = 3;

$safm_bank = new SafmBank();
$safm_bank->selectByParams(array('MBANK_KODE'=>$reqNoBukuBesarKasId));
$safm_bank->firstRow();

$tempBukuBesarKas = $safm_bank->getField('MBANK_NAMA');
$tempKdBbBank = $safm_bank->getField('MBANK_KODE_BB'); 
 
$arrFinal = array("MBANK_NAMA" => $tempBukuBesarKas, "MBANK_KODE_BB" => $tempKdBbBank);
echo json_encode($arrFinal);
?>