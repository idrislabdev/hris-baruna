<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajakD.php");

/* create objects */

/* LOGIN CHECK */

$reqNota = httpFilterGet("reqNota");
$reqFaktur= httpFilterGet("reqFaktur");

$kptt_nota = new KpttNota();
$kptt_nota->setField("NO_NOTA", $reqNota);
$kptt_nota->updatePembatalanFakturPajak();

$no_faktur_pajak_d = new NoFakturPajakD();
$no_faktur_pajak_d->setField("NO_NOTA", $reqNota);
$no_faktur_pajak_d->updateBatal();	

$arrFinal = array("HASIL" => 1);
echo json_encode($arrFinal);		




?>