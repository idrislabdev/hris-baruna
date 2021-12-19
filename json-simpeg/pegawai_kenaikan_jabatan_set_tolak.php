<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/KenaikanJabatan.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$kenaikan_jabatan = new KenaikanJabatan();

$reqId = httpFilterGet("reqId");

$kenaikan_jabatan->setField('KENAIKAN_JABATAN_ID', $reqId);
$kenaikan_jabatan->setField('STATUS', 2);
$kenaikan_jabatan->updateStatus();
$met[0]['STATUS'] = 1;
echo json_encode($met);

?>