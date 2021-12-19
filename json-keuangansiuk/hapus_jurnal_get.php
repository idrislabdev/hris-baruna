<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF/classes/utils/FileHandler.php");

$reqId = httpFilterGet("reqId");

$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb->selectByParams(array(), -1, -1, " AND UPPER(NO_NOTA) LIKE '%".$reqId."%'  ");
$kbbt_jur_bb->firstRow();

$arrResult["NO_NOTA"] = $kbbt_jur_bb->getField("NO_NOTA");
$arrResult["JEN_JURNAL"] = $kbbt_jur_bb->getField("JEN_JURNAL");
$arrResult["KET_TAMBAH"] = $kbbt_jur_bb->getField("KET_TAMBAH");
$arrResult["JML_VAL_TRANS"] = numberToIna($kbbt_jur_bb->getField("JML_VAL_TRANS"));

echo json_encode($arrResult);

?>