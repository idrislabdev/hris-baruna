<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");


/* create objects */
$jabatan = new Jabatan();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$reqNomorUrut= httpFilterGet("reqNomorUrut");
$reqKelas= httpFilterGet("reqKelas");
$reqJabatanId= httpFilterGet("reqJabatanId");

if($reqNomorUrut == ''){}
else{
	$statement=" AND NO_URUT =" .$reqNomorUrut;
}

if($reqKelas == ''){}
else{
	$statement.=" AND KELAS =" .$reqKelas;
}

if($reqJabatanId == ''){}
else{
	$statement.=" AND JABATAN_ID =" .$reqJabatanId;
}

$jabatan->selectByParams(array("STATUS" => 1), - 1, -1,  " AND KELOMPOK = 'P' ".$statement);
//$jabatan->selectByParams(array(), 5, 0,  " AND KELOMPOK = 'P' ".$statement);

//if($reqNomorUrut != '' || $reqKelas != '' || $reqJabatanId != ''){
	$arr_json = array();
	$i = 0;
	while($jabatan->nextRow())
	{
		$arr_json[$i]['id'] = $jabatan->getField("JABATAN_ID");
		$arr_json[$i]['text'] = $jabatan->getField("NAMA").' ('.$jabatan->getField("KELAS").')';
		
		if($reqNomorUrut != '' && $reqKelas != ''){
			$arr_json[$i]['selected'] = true;
		}
		if($reqJabatanId != ''){
			$arr_json[$i]['selected'] = true;
		}
		
		$i++;
	}
	echo json_encode($arr_json);
//}
?>