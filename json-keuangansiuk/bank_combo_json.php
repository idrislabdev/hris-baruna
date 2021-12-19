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
if($reqKdValuta == "")
{}
else
	$statement = " AND KODE_VALUTA = '".$reqKdValuta."' ";
	
$safm_bank->selectByParamsPencarian(array(),-1,-1,$statement);
while($safm_bank->nextRow())
{
	$arr_parent[$j]['id'] = $safm_bank->getField("MBANK_NAMA");
	$arr_parent[$j]['text'] = $safm_bank->getField("MBANK_NAMA");
	$arr_parent[$j]['MBANK_KODE_BB'] = $safm_bank->getField("MBANK_KODE_BB");	
	$arr_parent[$j]['MBANK_KODE'] = $safm_bank->getField("MBANK_KODE");	
	$j++;
}

echo json_encode($arr_parent);
?>