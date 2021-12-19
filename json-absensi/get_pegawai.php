<?
/* INCLUDE FILE */
//include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/

$reqKode = httpFilterGet("reqKode");
//$reqKode = '987654321';
//$reqKode = 12345;

$pegawai = new Pegawai();
$pegawai->selectByParams(array(), - 1, -1, " AND NRP =" .$reqKode. " OR NIPP =" .$reqKode );
$pegawai->firstRow();
//echo $pegawai->query;
$nama = $pegawai->getField('NAMA');
$pegawai_id = $pegawai->getField('PEGAWAI_ID');
$departemen = $pegawai->getField('DEPARTEMEN');
$departemen_id = $pegawai->getField('DEPARTEMEN_ID');

$arrFinal = array("nama" => $nama, "pegawai_id" => $pegawai_id, "departemen" => $departemen, "departemen_id" => $departemen_id);
echo json_encode($arrFinal);
?>