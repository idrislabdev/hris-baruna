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

$reqId = httpFilterGet("reqId");
$reqTahun = httpFilterGet("reqTahun");
$reqJenis = httpFilterGet("reqJenis");
$reqPPN = httpFilterGet("reqPPN");
$j=0;

if($reqJenis == 3 || $reqJenis == 6)
{
	$kbbt_neraca_angg->selectByParamsBukuBesarAll(array(),-1,-1, " AND A.KD_BUKU_BESAR LIKE '109%' AND NOT A.KD_BUKU_BESAR = '109.00.00' AND NOT A.NM_BUKU_BESAR LIKE '%TIDAK TERDEFINISI%' ");
	while($kbbt_neraca_angg->nextRow())
	{
		$arr_parent[$j]['id'] = $kbbt_neraca_angg->getField("KD_BUKU_BESAR");
		$arr_parent[$j]['text'] = $kbbt_neraca_angg->getField("KD_BUKU_BESAR")." - ".$kbbt_neraca_angg->getField("NM_BUKU_BESAR");
		$j++;
	}	
}
else
{
	if($reqPPN == 1)
	{
		$kbbt_neraca_angg_ppn = new KbbtNeracaAngg();
		$kbbt_neraca_angg_ppn->selectByParamsBukuBesarAll(array(),-1,-1, " AND A.KD_BUKU_BESAR = '112.01.00' AND NOT A.NM_BUKU_BESAR LIKE '%TIDAK TERDEFINISI%' ");
		while($kbbt_neraca_angg_ppn->nextRow())
		{
			$arr_parent[$j]['id'] = $kbbt_neraca_angg_ppn->getField("KD_BUKU_BESAR");
			$arr_parent[$j]['text'] = $kbbt_neraca_angg_ppn->getField("KD_BUKU_BESAR")." - ".$kbbt_neraca_angg_ppn->getField("NM_BUKU_BESAR");
			$j++;
		}			
	}	


	if($reqTahun == ""){}
	else
	$statement.= " AND THN_BUKU = '".$reqTahun."'";
	
	$kbbt_neraca_angg->selectByParamsBukuBesar(array(),-1,-1, $statement." AND A.KD_BUKU_BESAR LIKE '8%' ", "ORDER BY A.KD_BUKU_BESAR ASC");
	while($kbbt_neraca_angg->nextRow())
	{
		$arr_parent[$j]['id'] = $kbbt_neraca_angg->getField("KD_BUKU_BESAR");
		$arr_parent[$j]['text'] = $kbbt_neraca_angg->getField("KD_BUKU_BESAR")." - ".$kbbt_neraca_angg->getField("NM_BUKU_BESAR");
		$j++;
	}
}

echo json_encode($arr_parent);
?>