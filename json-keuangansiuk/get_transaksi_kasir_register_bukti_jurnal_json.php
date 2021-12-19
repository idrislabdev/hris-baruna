<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");

/* create objects */

/* LOGIN CHECK */

$reqId = httpFilterGet("reqId");
$reqKodeJurnal = httpFilterGet("reqKodeJurnal");


$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb->selectByParams(array("NO_REF1" => $reqId, "JEN_JURNAL" => $reqKodeJurnal));
$kbbt_jur_bb->firstRow();

$arrFinal = array("NO_NOTA" => $kbbt_jur_bb->getField("NO_NOTA"), 
				  "TGL_TRANS" => dateToPageCheck($kbbt_jur_bb->getField("TGL_TRANS")),
				  "NM_AGEN_PERUSH" => $kbbt_jur_bb->getField("NM_AGEN_PERUSH"),
				  "ALMT_AGEN_PERUSH" => $kbbt_jur_bb->getField("ALMT_AGEN_PERUSH"),
				  "KD_VALUTA" => $kbbt_jur_bb->getField("KD_VALUTA"),
				  "KURS_VALUTA" => numberToIna($kbbt_jur_bb->getField("KURS_VALUTA")),
				  "NO_POSTING" => $kbbt_jur_bb->getField("NO_POSTING"),
				  "KD_SUBSIS" => $kbbt_jur_bb->getField("KD_SUBSIS"),
				  "KET_TAMBAH" => $kbbt_jur_bb->getField("KET_TAMBAH")
				  );
echo json_encode($arrFinal);
?>