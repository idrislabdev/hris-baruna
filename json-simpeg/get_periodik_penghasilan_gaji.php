<?
/* INCLUDE FILE */
//include_once("../WEB-INF/classes/utils/UserLogin.php");
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
$reqPegawaiId= httpFilterGet("reqPegawaiId");
$reqKelas= httpFilterGet("reqKelas");
$reqJumlahPenghasilan = httpFilterGet("reqJumlahPenghasilan");

$reqJumlahPenghasilan = str_replace(".", "", $reqJumlahPenghasilan);

if($reqPeriode == "")
	$reqPeriode=0;

if($reqJumlahPenghasilan == "")
	$reqJumlahPenghasilan=0;
	
$pegawai_jabatan = new PegawaiJabatan();
$pegawai_jabatan->selectByParamsJsonGaji(array('A.PEGAWAI_ID'=>$reqPegawaiId),-1,-1,$reqPeriode, $reqJumlahPenghasilan, $reqKelas);
$pegawai_jabatan->firstRow();

$json_gaji = $pegawai_jabatan->getField('JSON_GAJI');
$pegawai_jabatan_json_gaji= $pegawai_jabatan->getField('JSON_GAJI');

echo $json_gaji;
?>