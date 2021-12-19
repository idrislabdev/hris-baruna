<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRefD.php");

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");

if($userLogin->nama == ""){}
else
{
	$transaksi_tipe= new KbbrGeneralRefD();
	$transaksi_tipe->setField("ID_REF_FILE", $reqId);
	$transaksi_tipe->setField("ID_REF_DATA", $reqRowId);
	$transaksi_tipe->delete();
	//echo $transaksi_tipe->query;
	unset($transaksi_tipe);
	$arrFinal = array("Query" => "Data Berhasil Disimpan");
	echo json_encode($arrFinal);
	//echo "Data Berhasil Disimpan";
}

?>