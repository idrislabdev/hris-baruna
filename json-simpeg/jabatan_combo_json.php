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

$jabatan->selectByParamsCombo(array("KATEGORI_SEKOLAH" => "STIAMAK"));
// echo $jabatan->query; exit();
$j=0;

	while($jabatan->nextRow())
	{
		// echo $jabatan->getField("JABATAN_ID"); 
		$arr_parent[$j]['id'] = $jabatan->getField("JABATAN_ID");
		$arr_parent[$j]['text'] = $jabatan->getField("NAMA");
		$j++;
	}
	// print_r($arr_parent); exit();


echo json_encode($arr_parent);


// $reqStatus= httpFilterGet("reqStatus");

// if($reqStatus == 'perbantuan'){
// 	$kelompok= array('P');
// 	$kelompok_nama= array('Perbantuan');
// 	$max_loop= 1;
// }
// else{
// 	$kelompok= array('D','K');
// 	$kelompok_nama= array('Darat','Kapal');
// 	$max_loop= 2;
// }

// $arr_json = array();
// $i = 0;
// while($i < $max_loop){
// 	$arr_json[$i]['id'] = "JAB".$kelompok[$i];
// 	$arr_json[$i]['text'] = $kelompok_nama[$i];

// 	$j=0;
// 	$jabatan->selectByParams(array("KELOMPOK" => $kelompok[$i], "STATUS" => 1));
// 	while($jabatan->nextRow())
// 	{
// 		$arr_parent[$j]['id'] = $jabatan->getField("JABATAN_ID");
// 		$arr_parent[$j]['text'] = $jabatan->getField("NAMA").' ('.$jabatan->getField("KELAS").')';
// 		$j++;
// 	}
	
// 	$arr_json[$i]['children'] = $arr_parent;
// 	unset($departemen);	
// 	unset($arr_parent);
// 	$i++;
// }

// echo json_encode($arr_json);
// ?>