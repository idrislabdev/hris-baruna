<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/KelompokPegawai.php");


/* create objects */

$kelompok_pegawai = new KelompokPegawai();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

	$j=0;
	$kelompok_pegawai->selectByParams(array());
	while($kelompok_pegawai->nextRow())
	{
		$arr_json[$j]['id'] = $kelompok_pegawai->getField("KELOMPOK_PEGAWAI");
		$arr_json[$j]['text'] = $kelompok_pegawai->getField("NAMA");
		$j++;
	}
	
echo json_encode($arr_json);
?>