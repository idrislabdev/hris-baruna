<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/DynamicQuery.php");

$kptt_nota = new KpttNota();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoNotaDinas= httpFilterPost("reqNoNotaDinas");
$reqKetNotaDinas= httpFilterPost("reqKetNotaDinas"); 

$dynamic_query = new DynamicQuery();
$query = " SELECT CASE WHEN SUM(SALDO_VAL_DEBET) = SUM(SALDO_VAL_KREDIT) THEN 1 ELSE 0 END NILAI FROM KBBT_JUR_BB_D WHERE NO_NOTA = '".$reqId."' ";
$balance = $dynamic_query->getQueryScalar($query, "NILAI");

if($balance == 1)
{	
	$kptt_nota_posting = new KpttNota();
	$kptt_nota_posting->setField("NO_NOTA", $reqId);
	$kptt_nota_posting->callProsesCetakNotaPenjualan();	
}


$kptt_nota->setField('NO_NOTA', $reqId); 
$kptt_nota->setField("NO_NOTA_DINAS", $reqNoNotaDinas);
$kptt_nota->setField("KET_NOTA_DINAS", $reqKetNotaDinas); 
	
if($kptt_nota->updateNotaDinas())
	echo "Data berhasil disimpan.";	
		

?>