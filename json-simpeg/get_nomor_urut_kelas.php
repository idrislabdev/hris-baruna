<?
/* INCLUDE FILE */
//include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/
$reqId= httpFilterGet("reqId");

$jabatan = new Jabatan();
$jabatan->selectByParams(array(), - 1, -1, " AND JABATAN_ID =" .$reqId );
$jabatan->firstRow();
//echo $jabatan->query;
$nomor_urut = $jabatan->getField('NO_URUT');
$kelas = $jabatan->getField('KELAS');

$arrFinal = array("nomor_urut" => $nomor_urut, "kelas" => $kelas);
echo json_encode($arrFinal);
?>