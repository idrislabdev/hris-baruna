<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");


$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqKodeJurnal= httpFilterGet("reqKodeJurnal");
$reqKlasTransaksiId= httpFilterGet("reqKlasTransaksiId");

if($userLogin->nama == ""){}
else
{
	$transaksi_tipe_detil= new KbbrTipeTransD();
	$transaksi_tipe_detil->setField("KD_SUBSIS", $reqId);
	$transaksi_tipe_detil->setField("KD_JURNAL", $reqKodeJurnal);
	$transaksi_tipe_detil->setField("TIPE_TRANS", $reqRowId);
	$transaksi_tipe_detil->setField("KLAS_TRANS_ID", $reqKlasTransaksiId);
	$transaksi_tipe_detil->delete();
	//echo $transaksi_tipe_detil->query;
	unset($transaksi_tipe_detil);
	$arrFinal = array("Query" => "Data Berhasil Disimpan");
	echo json_encode($arrFinal);
	//echo "Data Berhasil Disimpan";
}

?>