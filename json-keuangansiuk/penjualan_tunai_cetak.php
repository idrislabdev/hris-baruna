<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");

$kptt_nota = new KpttNota();

$reqId = httpFilterGet("reqId");

$kptt_nota->selectByParamsSimple(array("NO_NOTA" => $reqId));
$kptt_nota->firstRow();

if($kptt_nota->getField("NO_FAKT_PAJAK") == "")
{
	$faktur_pajak = $kptt_nota->getKode("NJUAL", dateToDBCheck(dateToPageCheck($kptt_nota->getField("TGL_TRANS"))));
	if($faktur_pajak == "")
	{}
	else
	{
		$kptt_nota_suspend = new KpttNota();
		$kptt_nota_suspend->setField("KD_BUKTI", "NFAKT");
		$kptt_nota_suspend->setField("TANGGAL_TRANS", dateToDBCheck(dateToPageCheck($kptt_nota->getField("TGL_TRANS"))));
		$kptt_nota_suspend->setField("NO_NOTA", $reqId);
		$kptt_nota_suspend->callDeleteNotaSuspend();
	}


	$kptt_nota_faktur = new KpttNota();
	$kptt_nota_faktur->setField("NO_NOTA", $reqId);
	$kptt_nota_faktur->callGenerateFakturPajak();
	
	
	$kptt_nota_setor = new KpttNota();
	$kptt_nota_setor->setField("NO_NOTA", $reqId);
	$kptt_nota_setor->callFlagSetorPajak();

}

$arrFinal = array("STATUS" => 1);

echo json_encode($arrFinal);
?>