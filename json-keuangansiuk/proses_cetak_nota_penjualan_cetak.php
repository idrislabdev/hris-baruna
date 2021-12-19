<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/DynamicQuery.php");

$kptt_nota = new KpttNota();

$reqId = httpFilterGet("reqId");

$arrId = explode(",", $reqId);

$unbalance = 0;
for($i=0;$i<count($arrId);$i++)
{
	
	$dynamic_query = new DynamicQuery();
	$query = " SELECT CASE WHEN SUM(SALDO_VAL_DEBET) = SUM(SALDO_VAL_KREDIT) THEN 1 ELSE 0 END NILAI FROM KBBT_JUR_BB_D WHERE NO_NOTA = '".$arrId[$i]."' ";
	$balance = $dynamic_query->getQueryScalar($query, "NILAI");
	
	if($balance == 1)
	{	
		$kptt_nota = new KpttNota();
		
		$kptt_nota->setField("NO_NOTA", $arrId[$i]);
		$kptt_nota->callProsesCetakNotaPenjualan();
		
		unset($kptt_nota);	
	}
	else
		$unbalance += 1;

	unset($dynamic_query);	
}

if($unbalance > 0)
	$status = "Terdapat jurnal tidak balance.";
else
	$status = "1";
$arrFinal = array("STATUS" => $status);

echo json_encode($arrFinal);
?>