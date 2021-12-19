<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-inventaris/Pegawai.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$pegawai = new Pegawai();

$reqNama = httpFilterGet("reqNama");

$pegawai->selectByParamsPegawaiJabatan(array("A.NAMA" => $reqNama));
$pegawai->firstRow();

$jabatan = $pegawai->getField("JABATAN");

$met = array();
$i=0;

$met[0]['JABATAN'] = $jabatan;
echo json_encode($met);
?>