<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");

$kptt_nota = new KpttNota();

/* LOGIN CHECK */

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);


$reqId = httpFilterGet("reqId");
$reqKartu = httpFilterGet("reqKartu");

$kptt_nota->setField("NO_NOTA", $reqId);
$kptt_nota->setField("KD_SUB_BANTU", $reqKartu);
$kptt_nota->setField("LAST_CREATE_USER", $userLogin->nama);

$kptt_nota->insertPelunasanGL();
echo "Data telah dilunasi melalui GL";
?>
