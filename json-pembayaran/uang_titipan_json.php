<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmBank.php");


/* create objects */

$safm_bank = new SafmBank();

$reqKdValuta = httpFilterGet("reqKdValuta");

$j=0;

	$arr_parent[$j]['id'] = "207.04.00.00";
	$arr_parent[$j]['text'] = "Titipan Penerimaan Siswa Baru";
	$j++;
	$arr_parent[$j]['id'] = "207.01.00.00";
	$arr_parent[$j]['text'] = "Titipan Uang Pangkal";
	$j++;
	$arr_parent[$j]['id'] = "207.02.00.00";
	$arr_parent[$j]['text'] = "Titipan Uang  SPP";
	$j++;
	$arr_parent[$j]['id'] = "207.03.00.00";
	$arr_parent[$j]['text'] = "Titipan Uang DPPS";
	$j++;
	

echo json_encode($arr_parent);
?>