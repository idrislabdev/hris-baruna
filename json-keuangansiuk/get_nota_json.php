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

//$reqNoBukuBesarKasId = 'A.11';
//$reqTahun = 3;

$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb->selectByParamsGetNota(array('NO_NOTA'=>$reqId), -1, -1, " AND NO_POSTING IS NOT NULL ");
$kbbt_jur_bb->firstRow();

$NO_NOTA 		= $kbbt_jur_bb->getField('NO_NOTA');
$TGL_POSTING 	= dateToPage($kbbt_jur_bb->getField('TGL_POSTING')); 
$KET_TAMBAH 	= $kbbt_jur_bb->getField('KET_TAMBAH'); 
$STATUS_CLOSING = $kbbt_jur_bb->getField('STATUS_CLOSING'); 
 
$arrFinal = array("NO_NOTA" => $NO_NOTA, "TGL_POSTING" => $TGL_POSTING, "KET_TAMBAH" => $KET_TAMBAH, "STATUS_CLOSING" => $STATUS_CLOSING);
echo json_encode($arrFinal);
?>