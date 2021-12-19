<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");

/* create objects */

/* LOGIN CHECK */

$reqId = httpFilterGet("reqId");

$kptt_nota_d = new KpttNotaD();
$kptt_nota_d->selectByParams(array("A.NO_NOTA"=>$reqId));
$kptt_nota_d->firstRow();

$arrFinal = array("KLAS_TRANS" => $kptt_nota_d->getField("KLAS_TRANS"), 
				  "JML_VAL_TRANS" => numberToIna($kptt_nota_d->getField("JML_VAL_TRANS")),
				  "JML_VAL_PAJAK" => numberToIna($kptt_nota_d->getField("JML_VAL_PAJAK"))
				  );
echo json_encode($arrFinal);
?>