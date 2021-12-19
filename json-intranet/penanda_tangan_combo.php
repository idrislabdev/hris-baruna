<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/PenandaTangan.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$penanda_tangan = new PenandaTangan();

$reqNama = httpFilterGet("reqNama");

$penanda_tangan->selectByParams(array("NAMA" => $reqNama));
$penanda_tangan->firstRow();

$jabatan = $penanda_tangan->getField("JABATAN");

$met = array();
$i=0;

$met[0]['JABATAN'] = $jabatan;
echo json_encode($met);
?>