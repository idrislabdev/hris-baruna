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
$reqKodeKusto = httpFilterGet("reqKodeKusto");
$reqKdValuta = httpFilterGet("reqKdValuta");
$reqTglTrans = httpFilterGet("reqTglTrans");


$kptt_nota = new KpttNota();
$kptt_nota->selectByParamsPembatalanNotaPencarian($reqId, $reqKodeKusto, $reqKdValuta, $reqTglTrans);
$kptt_nota->firstRow();

$arrFinal = array("TGL_POSTING" => $kptt_nota->getField("TGL_POSTING"), 
				  "JML_VAL_BAYAR" => $kptt_nota->getField("JML_VAL_BAYAR"),
				  "STATUS_PROSES" => $kptt_nota->getField("STATUS_PROSES"),
				  "PREV_NOTA_UPDATE" => $kptt_nota->getField("PREV_NOTA_UPDATE"),
				  "NO_NOTA" => $kptt_nota->getField("NO_NOTA"),
				  "METERAI" => $kptt_nota->getField("METERAI"),
				  "JML_TAGIHAN" => numberToIna($kptt_nota->getField("JML_TAGIHAN")),
				  "KURS" => numberToIna($kptt_nota->getField("KURS"))
				  );
echo json_encode($arrFinal);
?>