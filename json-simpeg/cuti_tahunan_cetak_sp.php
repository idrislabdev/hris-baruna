<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunanDetil.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");


$reqCutiTahunanDetilId = $_POST["reqCutiTahunanDetilId"];
$reqNotaDinas =  $_POST["reqNotaDinas"];
$reqNama1 = httpFilterPost("reqNama1");
$reqJabatan1 = httpFilterPost("reqJabatan1");

for($i=0;$i<count($reqCutiTahunanDetilId);$i++)
{

	$cuti_tahunan_detil = new CutiTahunanDetil();
	
	$cuti_tahunan_detil->setField("CUTI_TAHUNAN_DETIL_ID", $reqCutiTahunanDetilId[$i]);
	$cuti_tahunan_detil->setField("NO_NOTA", $reqNotaDinas[$i]);
	$cuti_tahunan_detil->setField("TTD_NAMA", $reqNama1);
	$cuti_tahunan_detil->setField("TTD_JABATAN", $reqJabatan1);
	$cuti_tahunan_detil->updateNota();
	
	unset($cuti_tahunan_detil);
		
}

echo "Data berhasil diubah.";

?>