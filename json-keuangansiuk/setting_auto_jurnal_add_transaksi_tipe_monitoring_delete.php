<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTrans.php");


$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqKodeJurnal= httpFilterGet("reqKodeJurnal");
$reqTipeTrans= httpFilterGet("reqTipeTrans");

if($userLogin->nama == ""){}
else
{
	$transaksi_tipe= new KbbrTipeTrans();
	$transaksi_tipe->setField("KD_SUBSIS", $reqId);
	$transaksi_tipe->setField("KD_JURNAL", $reqRowId);
	$transaksi_tipe->setField("TIPE_TRANS", $reqTipeTrans);
	$transaksi_tipe->delete();
	//echo $transaksi_tipe->query;
	unset($transaksi_tipe);
	$arrFinal = array("Query" => "Data Berhasil Disimpan");
	echo json_encode($arrFinal);
	//echo "Data Berhasil Disimpan";
}

?>