<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-absensi/ProsesPresensiLock.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$proses_presensi_lock = new ProsesPresensiLock();

$reqPeriode = httpFilterGet("reqPeriode");
$reqJenisProses = httpFilterGet("reqJenisProses");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$proses_presensi_lock->setField("PERIODE", $reqPeriode);
$proses_presensi_lock->setField("JENIS_PROSES", $reqJenisProses);
$proses_presensi_lock->insert();
	
$met = array();
$i=0;

$met[0]['STATUS'] = 1;
echo json_encode($met);
?>