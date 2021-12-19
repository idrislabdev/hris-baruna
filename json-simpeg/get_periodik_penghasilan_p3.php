<?
/* INCLUDE FILE */

include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/
$reqPeriode= httpFilterGet("reqPeriode");
$reqKelas= httpFilterGet("reqKelas");
$reqKelasPms= httpFilterGet("reqKelasPms");

if($reqPeriode == "")
	$reqPeriode=0;

if($reqKelas == "")
	$reqKelas=0;
	
$pegawai_jabatan = new PegawaiJabatan();
$pegawai_jabatan->selectByParamsJsonGajiP3($reqPeriode, $reqKelas);
$pegawai_jabatan->firstRow();
$jumlah = $pegawai_jabatan->getField("JUMLAH");

$pegawai_jabatan->selectByParamsJsonGajiTPPP3($reqKelas);
$pegawai_jabatan->firstRow();
$tpp = $pegawai_jabatan->getField("JUMLAH");

$pegawai_jabatan->selectByParamsGajiPMS($reqPeriode, $reqKelasPms);
$pegawai_jabatan->firstRow();
$tpppms = $pegawai_jabatan->getField("TPP_PMS");
$meritpms = $pegawai_jabatan->getField("MERIT_PMS");

$arrFinal = array("JUMLAH" => $jumlah, "TPP" => $tpp, "JUMLAH_PMS" => $meritpms, "TPP_PMS" => $tpppms);

echo json_encode($arrFinal);
?>