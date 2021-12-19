<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$departemen = new Departemen();

$reqJumlah = $_POST["reqJumlah"];
$reqDepartemenId = $_POST["reqDepartemenId"];

for($i=0;$i<count($reqDepartemenId);$i++)
{
	$departemen = new Departemen();
	$departemen->setField("JUMLAH_STAFF", $reqJumlah[$i]);
	$departemen->setField("DEPARTEMEN_ID", $reqDepartemenId[$i]);
	$departemen->updateJumlahStaff();
	unset($departemen);	
}
echo "Data berhasil disimpan.";

?>