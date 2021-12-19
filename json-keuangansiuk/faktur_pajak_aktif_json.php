<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/NoFakturPajak.php");

$reqTanggal = httpFilterGet("reqTanggal");

/* create objects */

$no_faktur_pajak_d = new NoFakturPajak();

$j=0;
$nomor = $no_faktur_pajak_d->getLastFakturPajak($reqTanggal);


$arrFinal = array("NOMOR" => $nomor);

echo json_encode($arrFinal);
?>