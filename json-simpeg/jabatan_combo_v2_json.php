<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");


/* create objects */

$jabatan = new Jabatan();
$pegawai = new Pegawai();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$reqStatus= httpFilterGet("reqStatus");
$reqPegawaiId= httpFilterGet("reqPegawaiId");

$pegawai->selectByParamsDepartemen(array("PEGAWAI_ID" => $reqPegawaiId));
$pegawai->firstRow();
$reqDepartemenId = $pegawai->getField("DEPARTEMEN_ID");
$reqDepartemen = $pegawai->getField("DEPARTEMEN");

$arr_json = array();
$i = 0;
$arr_json[$i]['id'] = "JAB".$reqDepartemenId;
$arr_json[$i]['text'] = $reqDepartemen;

$j=0;
$jabatan->selectByParams(array("DEPARTEMEN_ID" => $reqDepartemenId));
while($jabatan->nextRow())
{
	$arr_parent[$j]['id'] = $jabatan->getField("JABATAN_ID");
	$arr_parent[$j]['text'] = $jabatan->getField("NAMA").' ('.$jabatan->getField("KELAS").')';
	$j++;
}

$arr_json[$i]['children'] = $arr_parent;
unset($departemen);	
unset($arr_parent);
$i++;

echo json_encode($arr_json);
?>