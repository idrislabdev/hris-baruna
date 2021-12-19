<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaSpp.php");

$kptt_nota_spp = new KpttNotaSpp();

/* LOGIN CHECK */

$reqId = httpFilterGet("reqId");
$reqSource = httpFilterGet("reqSource");


if($reqSource == "KOREKSI")
{

	$kptt_nota_spp->setField("NO_NOTA", $reqId);
	$kptt_nota_spp->koreksi();

	$output = array("HASIL" => "1");

	echo json_encode( $output );
	exit;
}

$kptt_nota_spp->setField("NO_NOTA", $reqId);
$kptt_nota_spp->delete();

$output = array("HASIL" => "1");

echo json_encode( $output );
?>
