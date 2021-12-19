<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");

$reqId = httpFilterGet("reqId");
$kptt_nota_d = new KpttNotaD();

$kptt_nota_d->selectDaftarTagihanSPP(array("KD_SUB_BANTU" => $reqId));
$kptt_nota_d->firstRow();

$arrData["NO_NOTA"] = $kptt_nota_d->getField("NO_NOTA");
$arrData["TAGIHAN"] = $kptt_nota_d->getField("NO_NOTA");
$arrData["SISA"] = $kptt_nota_d->getField("NO_NOTA");
$arrData["PERIODE"] = getNamePeriodeKeu($kptt_nota_d->getField("NO_NOTA"));

echo json_encode($arrData);
?>
