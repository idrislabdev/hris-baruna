<?
/* INCLUDE FILE */
//include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-absensi/JamKerja.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$jam_kerja = new JamKerja();
$jam_kerja2 = new JamKerja();

$reqId = httpFilterGet("reqId");
$reqJenisId = httpFilterGet("reqJenisId");
$reqNilai = httpFilterGet("reqNilai");

/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/

	$jam_kerja->setField("FIELD", "STATUS");
	$jam_kerja->setField("FIELD_VALUE", 0);
	$jam_kerja->setField("CONDITION", "JAM_KERJA_JENIS_ID");
	$jam_kerja->setField("CONDITION_VALUE", $reqJenisId);
	$jam_kerja->updateByFieldWhereClause();

if ($reqNilai == 1){

	$jam_kerja->setField("FIELD", "STATUS");
	$jam_kerja->setField("FIELD_VALUE", $reqNilai);
	$jam_kerja->setField("JAM_KERJA_ID", $reqId);
	
	$jam_kerja->updateByFieldStatus();
	
	}
	
$met = array();
$i=0;

$met[0]['STATUS'] = 1;
echo json_encode($met);
?>