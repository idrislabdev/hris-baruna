<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValutaKursPajak.php");

/* create objects */

/* LOGIN CHECK */

$reqValutaKursId = httpFilterGet("reqValutaKursId");
$reqTanggalTransaksi= httpFilterGet("reqTanggalTransaksi");

//$reqSafrValutaKursId = 'A.11';
//$reqTahun = 3;

$safr_valuta_kurs = new SafrValutaKursPajak();
$safr_valuta_kurs->selectByParams(array('KODE_VALUTA'=>$reqValutaKursId), -1, -1, $statement." AND TO_DATE('".$reqTanggalTransaksi."', 'DD-MM-YYYY') BETWEEN TGL_MULAI_RATE AND TGL_AKHIR_RATE");
$safr_valuta_kurs->firstRow();


$tempValutaKurs = $safr_valuta_kurs->getField('NILAI_RATE');
$tempTanggalKurs = dateToPage($safr_valuta_kurs->getField('TGL_MULAI_RATE'));
 
$arrFinal = array("NILAI_RATE" => numberToIna($tempValutaKurs), "TGL_MULAI_RATE" => $tempTanggalKurs);
echo json_encode($arrFinal);
?>