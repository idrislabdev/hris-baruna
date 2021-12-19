<?
/* INCLUDE FILE */
//include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/CabangP3.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/
$reqCabang= httpFilterGet("reqCabang");

$cabang_p3 = new CabangP3();
$cabang_p3->selectByParams(array(), - 1, -1, " AND KODE =" .$reqCabang );
$cabang_p3->firstRow();
//echo $cabang_p3->query;
$cabang_p3_id = $cabang_p3->getField('CABANG_P3_ID');

$arrFinal = array("cabang_p3_id" => $cabang_p3_id);
echo json_encode($arrFinal);
?>