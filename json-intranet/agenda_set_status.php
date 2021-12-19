<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/Agenda.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$agenda = new Agenda();

$reqId = httpFilterGet("reqId");
$reqNilai = httpFilterGet("reqNilai");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

	$agenda->setField("FIELD", "STATUS");
	$agenda->setField("FIELD_VALUE", $reqNilai);
	$agenda->setField("AGENDA_ID", $reqId);
	$agenda->updateByField();
$met = array();
$i=0;

$met[0]['STATUS'] = 1;
echo json_encode($met);
?>