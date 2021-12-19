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
$arrFinal = array("JUMLAH" => $jumlah, "TPP" => $tpp);


echo json_encode($arrFinal);
?>