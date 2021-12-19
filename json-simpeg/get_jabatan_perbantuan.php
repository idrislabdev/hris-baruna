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
$reqNomorUrut= httpFilterGet("reqNomorUrut");
$reqKelas= httpFilterGet("reqKelas");

$jabatan = new Jabatan();
$jabatan->selectByParams(array(), - 1, -1, " AND KELOMPOK = 'P' AND NO_URUT =" .$reqNomorUrut. " AND KELAS =" .$reqKelas );
$jabatan->firstRow();
//echo $jabatan->query;
$jabatan_id = $jabatan->getField('JABATAN_ID');
$jabatan = $jabatan->getField('NAMA');

$arrFinal = array("jabatan" => $jabatan, "jabatan_id" => $jabatan_id);
echo json_encode($arrFinal);
?>