<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrNoNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/DynamicQuery.php");

$kbbr_no_nota = new KbbrNoNota();

$reqTahunAwal = httpFilterGet("reqTahunAwal");
$reqTahunAkhir = httpFilterGet("reqTahunAkhir");


$dynamic_query = new DynamicQuery();
$query = " SELECT COUNT(1) NILAI FROM KBBR_NO_NOTA WHERE KD_PERIODE = '".$reqTahunAkhir."' ";
$ada = $dynamic_query->getQueryScalar($query, "NILAI");

if($ada > 0)
	$status = "Sudah terdapat dapat pada periode ".$reqTahunAkhir.", copy data gagal.";
else
{
	$kbbr_no_nota->setField("KD_PERIODE_AWAL", $reqTahunAwal);
	$kbbr_no_nota->setField("KD_PERIODE_AKHIR", $reqTahunAkhir);
	$kbbr_no_nota->insertCopy();
	$status = "1";
}

$arrFinal = array("STATUS" => $status);

echo json_encode($arrFinal);
?>