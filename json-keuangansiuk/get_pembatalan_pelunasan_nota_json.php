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
$kptt_nota->selectByParamsPembatalanPelunasan(array("A.NO_NOTA"=>$reqId));
$kptt_nota->firstRow();
												

$arrFinal = array("KD_BAYAR" => $kptt_nota->getField("KD_BAYAR"), 
				  "KD_BANK" => $kptt_nota->getField("KD_BANK"), 
				  "REK_BANK" => $kptt_nota->getField("REK_BANK"), 
				  "KD_BB_BANK" => $kptt_nota->getField("KD_BB_BANK"), 
				  "KD_KUSTO" => $kptt_nota->getField("KD_KUSTO"), 
				  "MBANK_NAMA" => $kptt_nota->getField("MBANK_NAMA"), 
				  "NO_CHEQUE" => $kptt_nota->getField("NO_CHEQUE"), 
				  "KD_VALUTA" => $kptt_nota->getField("KD_VALUTA"),
				  "JML_VAL_TRANS" => numberToIna($kptt_nota->getField("JML_VAL_TRANS")),
				  "BADAN_USAHA" => $kptt_nota->getField("BADAN_USAHA"),
				  "KD_BB_KUSTO" => $kptt_nota->getField("KD_BB_KUSTO"),
				  "NO_POSTING" => $kptt_nota->getField("NO_POSTING"),
				  "MPLG_NAMA" => $kptt_nota->getField("MPLG_NAMA")
				  );

echo json_encode($arrFinal);
?>