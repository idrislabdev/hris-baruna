<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/KbbtNeracaAngg.php");

/* create objects */
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$kbbt_neraca_angg = new KbbtNeracaAngg();
$j=0;
$kbbt_neraca_angg->selectByParamsBukuBesarAll(array(),-1,-1, " AND A.KD_BUKU_BESAR LIKE '413%' AND NOT A.KD_BUKU_BESAR = '413.00.00' AND NOT A.NM_BUKU_BESAR LIKE '%TIDAK TERDEFINISI%' ");
while($kbbt_neraca_angg->nextRow())
{
	$arr_parent[$j]['id'] = $kbbt_neraca_angg->getField("KD_BUKU_BESAR");
	$arr_parent[$j]['text'] = $kbbt_neraca_angg->getField("KD_BUKU_BESAR")." - ".$kbbt_neraca_angg->getField("NM_BUKU_BESAR");
	$j++;
}	

echo json_encode($arr_parent);
?>