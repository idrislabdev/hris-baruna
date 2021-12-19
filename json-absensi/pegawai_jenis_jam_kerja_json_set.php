<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/base-absensi/PegawaiJamKerjaJenis.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$pegawai_jam_kerja_jenis = new PegawaiJamKerjaJenis();

$reqId = httpFilterGet("reqId");
$reqJamKerjaJenisId = httpFilterGet("reqJamKerjaJenisId");

$pegawai_jam_kerja_jenis->setField("PEGAWAI_ID", $reqId);
$pegawai_jam_kerja_jenis->setField("JAM_KERJA_JENIS_ID", $reqJamKerjaJenisId);
$pegawai_jam_kerja_jenis->delete();

if($reqJamKerjaJenisId == 1)
{}
else
	$pegawai_jam_kerja_jenis->insert();

$met = array();
$i=0;

$met[0]['STATUS'] = 1;
echo json_encode($met);
?>
