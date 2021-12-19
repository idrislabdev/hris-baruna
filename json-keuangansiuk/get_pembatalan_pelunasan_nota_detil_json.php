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

$kptt_nota = new KpttNota();
$kptt_nota->selectByParamsPembatalanPelunasanDetil(array("A.NO_NOTA"=>$reqId));
while($kptt_nota->nextRow())
{

$arrFinal[] = array("NO_REF3" => $kptt_nota->getField("NO_REF3"), 
				  "PREV_NO_NOTA" => $kptt_nota->getField("NO_NOTA"),
				  "TGL_TRANS" => dateToPage($kptt_nota->getField("TGL_TRANS")), 
				  "KD_BUKU_BESAR" => $kptt_nota->getField("KD_BUKU_BESAR"), 
				  "KD_SUB_BANTU" => $kptt_nota->getField("KD_SUB_BANTU"), 
				  "TGL_JT_TEMPO" => dateToPage($kptt_nota->getField("TGL_JT_TEMPO")), 
				  "JML_TAGIHAN" => numberToIna($kptt_nota->getField("JML_TAGIHAN")), 
				  "JML_VAL_TRANS" => numberToIna($kptt_nota->getField("JML_VAL_TRANS"))
				  );
}

echo json_encode($arrFinal);
?>