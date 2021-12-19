<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");

/* create objects */

/* LOGIN CHECK */

$reqId = httpFilterGet("reqId");
$reqKdValuta = httpFilterGet("reqKdValuta");
$reqNota = httpFilterGet("reqNota");
$kptt_nota_d = new KpttNotaD();

$kptt_nota_d->selectByParamsKompensasiSisaUperPencarian(array("NO_NOTA" => $reqNota), -1,-1,$reqId,$reqKdValuta);
$kptt_nota_d->firstRow();

$arrFinal = array("NO_PPKB" => $kptt_nota_d->getField("NO_PPKB"), 
				  "KARTU" => $kptt_nota_d->getField("KARTU"),
				  "NO_REF1" => $kptt_nota_d->getField("NO_REF1"),
				  "TGL_TRANS" => dateToPage($kptt_nota_d->getField("TGL_TRANS")),
				  "TGL_JT_TEMPO" => dateToPage($kptt_nota_d->getField("TGL_JT_TEMPO")),
				  "JML_WD_UPPER" => numberToIna($kptt_nota_d->getField("JML_WD_UPPER")),
				  "SISA_TAGIHAN" => numberToIna($kptt_nota_d->getField("SISA_TAGIHAN")),
				  "JUMLAH_DIBAYAR" => numberToIna($kptt_nota_d->getField("JUMLAH_DIBAYAR")),
				  "JNS_JUAL" => $kptt_nota_d->getField("JNS_JUAL"),
				  "NO_NOTA" => $kptt_nota_d->getField("NO_NOTA")
				  );
				  
echo json_encode($arrFinal);

				  
?>