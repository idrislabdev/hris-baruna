<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-gaji/Gaji.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");

/* create objects */

$gaji = new Gaji();

$reqId = httpFilterGet("reqId");
$reqNilai = httpFilterGet("reqNilai");
$reqBulanTahun = httpFilterGet("reqBulanTahun");
/* LOGIN CHECK 
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
*/

	$gaji->setField("PEGAWAI_ID", $reqId);
	$gaji->setField("BULANTAHUN", $reqBulanTahun);
	$gaji->updateStatusGaji();
	
$met = array();
$i=0;

$met[0]['STATUS'] = $gaji->query;
echo json_encode($met);
?>