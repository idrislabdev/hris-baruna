<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");

/* create objects */

/* LOGIN CHECK */

$reqId = httpFilterGet("reqId");
$reqKdValuta = httpFilterGet("reqKdValuta");

$kptt_nota = new KpttNota();
$kptt_nota->selectByParamsPelunasanNotaPencarian(array("A.KD_KUSTO"=>$reqId, "A.KD_VALUTA" => $reqKdValuta));
//$kptt_nota->firstRow();

$j=0;
while($kptt_nota->nextRow())
{
	$arrFinal[$j]['PELANGGAN'] = $kptt_nota->getField("PELANGGAN");
	$arrFinal[$j]['TGL_NOTA'] = $kptt_nota->getField("NAMA");
	$arrFinal[$j]['TOT_TAGIHAN'] = numberToIna($kptt_nota->getField("TOT_TAGIHAN"));
	$arrFinal[$j]['BAYAR'] = numberToIna($kptt_nota->getField("BAYAR"));
	$arrFinal[$j]['SISA_TAGIHAN'] = numberToIna($kptt_nota->getField("SISA_TAGIHAN"));
	$arrFinal[$j]['NO_NOTA'] = $kptt_nota->getField("NO_NOTA");
	$arrFinal[$j]['KD_BB_KUSTO'] = $kptt_nota->getField("KD_BB_KUSTO");
	$arrFinal[$j]['NO_PPKB'] = $kptt_nota->getField("NO_PPKB");
	$j++;
}

echo json_encode($arrFinal);

/*
$arrFinal = array("PELANGGAN" => $kptt_nota->getField("PELANGGAN"), 
				  "TGL_NOTA" => dateToPage($kptt_nota->getField("TGL_NOTA")),
				  "TOT_TAGIHAN" => numberToIna($kptt_nota->getField("TOT_TAGIHAN")),
				  "BAYAR" => numberToIna($kptt_nota->getField("BAYAR")),
				  "SISA_TAGIHAN" => numberToIna($kptt_nota->getField("SISA_TAGIHAN")),
				  "NO_NOTA" => $kptt_nota->getField("NO_NOTA"),
				  "KD_BB_KUSTO" => $kptt_nota->getField("KD_BB_KUSTO"),
				  "NO_PPKB" => $kptt_nota->getField("NO_PPKB")
				  );

echo json_encode($arrFinal);
*/
?>