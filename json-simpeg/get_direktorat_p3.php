<?
/* INCLUDE FILE */
//include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/DirektoratP3.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/
$reqCabangId= httpFilterGet("reqCabangId");
$reqDirektorat= httpFilterGet("reqDirektorat");
$reqSubDirektorat= httpFilterGet("reqSubDirektorat");
$reqSeksi= httpFilterGet("reqSeksi");
$tempDirektoratId= $reqDirektorat.$reqSubDirektorat.$reqSeksi;

$direktorat_p3 = new DirektoratP3();
$direktorat_p3->selectByParams(array(), - 1, -1, " AND CABANG_P3_ID =" .$reqCabangId." AND DIREKTORAT_P3_ID =" .$tempDirektoratId );
$direktorat_p3->firstRow();
//echo $direktorat_p3->query;
$direktorat_p3_id = $direktorat_p3->getField('DIREKTORAT_P3_ID');
$direktorat_p3_nama = $direktorat_p3->getField('NAMA');

$arrFinal = array("direktorat_p3_id" => $direktorat_p3_id, "direktorat_p3_nama" => $direktorat_p3_nama);
echo json_encode($arrFinal);
?>