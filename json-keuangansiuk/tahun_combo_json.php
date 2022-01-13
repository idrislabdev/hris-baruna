<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/KbbrThnBuku.php");


/* create objects */
$reqMode = httpFilterGet("reqMode");

$kbbr_tahun_buku = new KbbrThnBuku();

if($reqMode == "")
{
	$arr_parent[0]['id'] = '';
	$arr_parent[0]['text'] = 'Semua';
	$j=1;
}
else
{
	$j=0;	
}

$kbbr_tahun_buku->selectByParamsCombo();
while($kbbr_tahun_buku->nextRow())
{
	$tahun_depan = $kbbr_tahun_buku->getField("THN_BUKU")+1;
	$arr_parent[$j]['id'] = $kbbr_tahun_buku->getField("THN_BUKU");
	$arr_parent[$j]['text'] = $kbbr_tahun_buku->getField("THN_BUKU")."-".$tahun_depan;
	$j++;
}

echo json_encode($arr_parent);
?>