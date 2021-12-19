<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");

/* create objects */

/* LOGIN CHECK */

$reqId = httpFilterGet("reqId");
$reqKdKusto = httpFilterGet("reqKdKusto");
$reqKdValuta = httpFilterGet("reqKdValuta");

$kptt_nota = new KpttNota();
$kptt_nota->selectByParamsPembatalanKompensasiPencarian(array("A.NO_REF3"=>$reqId, "A.KD_KUSTO"=>$reqKdKusto, "A.KD_VALUTA" => $reqKdValuta));
$kptt_nota->firstRow();

$arrFinal = array("NO_PPKB" => $kptt_nota->getField("NO_PPKB"), 
				  "PELANGGAN" => $kptt_nota->getField("PELANGGAN"),
				  "TGL_NOTA" => dateToPage($kptt_nota->getField("TGL_NOTA")),
				  "TOT_TAGIHAN" => numberToIna($kptt_nota->getField("TOT_TAGIHAN")),
				  "BAYAR" => numberToIna($kptt_nota->getField("BAYAR")),
				  "NO_NOTA" => $kptt_nota->getField("NO_NOTA")
				  );
echo json_encode($arrFinal);
?>