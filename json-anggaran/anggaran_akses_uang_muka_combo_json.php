<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranAkses.php");

/* create objects */

$anggaran_akses = new AnggaranAkses();
$anggaran_akses_uang_muka = new AnggaranAkses();

$reqKdBukuPusat = httpFilterGet("reqKdBukuPusat");
$reqDepartemenId = httpFilterGet("reqDepartemenId");
$reqTahun = httpFilterGet("reqTahun");
$reqCheckAll = httpFilterGet("reqCheckAll");

if($reqTahun == "")
	$reqTahun = date("Y");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$j=0;
$arr_parent[$j]['id'] = $j;
$arr_parent[$j]['text'] = "109.00.00 - Uang Muka Beban";
$k=0;

$anggaran_akses_uang_muka->selectByParamsComboUangMuka(array(), -1, -1, "", $reqDepartemenId, $reqTahun);
while($anggaran_akses_uang_muka->nextRow())
{
	$arr_child[$k]['id'] = 1000+$k;
	$arr_child[$k]['text'] = $anggaran_akses_uang_muka->getField("KD_BUKU_BESAR")." - ".$anggaran_akses_uang_muka->getField("NM_BUKU_BESAR");
	if($anggaran_akses_uang_muka->getField("KD_BUKU_BESAR") == $anggaran_akses_uang_muka->getField("KD_BUKU_BESAR_AKSES"))
		$arr_child[$k]['checked'] = true;
	$k++;	
}
$arr_parent[$j]['children'] = $arr_child;


$j++;
$anggaran_akses->selectByParamsCombo(array("THN_BUKU" => $reqTahun, "A.KD_BUKU_PUSAT" => $reqKdBukuPusat), -1, -1, "", $reqDepartemenId, $reqTahun);
while($anggaran_akses->nextRow())
{
	$arr_parent[$j]['id'] = $j;
	$arr_parent[$j]['text'] = $anggaran_akses->getField("KD_BUKU_BESAR")." - ".$anggaran_akses->getField("NM_BUKU_BESAR");
	if($anggaran_akses->getField("KD_BUKU_BESAR") == $anggaran_akses->getField("KD_BUKU_BESAR_AKSES"))
		$arr_parent[$j]['checked'] = true;
	elseif($reqCheckAll == 1)
		$arr_parent[$j]['checked'] = true;
	elseif($reqCheckAll == 0)
		$arr_parent[$j]['checked'] = false;
			
	$j++;
}

echo json_encode($arr_parent);
?>