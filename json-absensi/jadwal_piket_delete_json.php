<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-absensi/DaftarJagaPiket.php");

$reqDepartemenId= $_GET["reqDepartemenId"];
$reqPeriode= $_GET["reqPeriode"];
$reqPeriode = substr($reqPeriode, 0, 2) . '-' . substr($reqPeriode, 2, 4);
$set = new DaftarJagaPiket();
$set->setField("DEPARTEMEN_ID", $reqDepartemenId);
$set->setField("PERIODE", $reqPeriode);
$set->delete(); 
unset($set);
$output = array('sukses'=>true);
echo json_encode($output);	
?>