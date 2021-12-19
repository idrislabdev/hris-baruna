<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$pegawai = new Pegawai();
$pegawai_jabatan = new PegawaiJabatan();
$pegawai_jabatan_terakhir = new PegawaiJabatan();

$reqId = httpFilterGet("reqId");
$reqTanggal = httpFilterGet("reqTanggal");
$reqDepartemen = httpFilterGet("reqDepartemen");


$pegawai_jabatan->setField("DEPARTEMEN_ID", $reqDepartemen);
$pegawai_jabatan->setField("TMT_JABATAN", dateToDBCheck($reqTanggal));
$pegawai_jabatan->setField("PEGAWAI_JABATAN_ID", $reqId);
$pegawai_jabatan->updateTools();

$pegawai_jabatan_terakhir->selectByParamsToolsJabatanTerakhir(array("PEGAWAI_JABATAN_ID" => $reqId));
$pegawai_jabatan_terakhir->firstRow();

if($pegawai_jabatan_terakhir->getField("PEGAWAI_JABATAN_ID") == $reqId)
{

	$pegawai->setField("DEPARTEMEN_ID", $reqDepartemen);
	$pegawai->setField("LAST_UPDATE_USER", "PERBAIKAN DATA");
	$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$pegawai->setField("PEGAWAI_ID", $pegawai_jabatan_terakhir->getField("PEGAWAI_ID"));
	$pegawai->updateDepartemen();
}

$met = array();
$i=0;

$met[0]['STATUS'] = 1;
echo json_encode($met);
?>