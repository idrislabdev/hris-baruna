<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/KbbrThnBukuD.php");


/* create objects */

$kbbr_tahun_buku_d = new KbbrThnBukuD();

$j=0;
$kbbr_tahun_buku_d->selectByParamsCombo();
while($kbbr_tahun_buku_d->nextRow())
{
	$arr_parent[$j]['id'] = $kbbr_tahun_buku_d->getField("TAHUN_BULAN");
	$arr_parent[$j]['text'] = $kbbr_tahun_buku_d->getField("NAMA");
	$j++;
}

echo json_encode($arr_parent);
?>