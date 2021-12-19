<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/PenagihanPiutang.php");


/* create objects */

$penagihan_piutang = new PenagihanPiutang();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");

if(strtoupper($reqMode) == "CABANG")
	$statement = " AND MPLG_NAMA LIKE '%CABANG%' ";

$j=0;

$penagihan_piutang->selectByPelangganPiutang(array(), -1, -1, $statement, " ORDER BY MPLG_NAMA, MPLG_KODE ASC ");
while($penagihan_piutang->nextRow())
{
	$arr_parent[$j]['id'] = $penagihan_piutang->getField("MPLG_KODE");
	$arr_parent[$j]['text'] = $penagihan_piutang->getField("MPLG_KODE")." - ".$penagihan_piutang->getField("MPLG_NAMA");
	$arr_parent[$j]['MPLG_KODE'] = $penagihan_piutang->getField("MPLG_KODE");	
	$arr_parent[$j]['MPLG_ALAMAT'] = $penagihan_piutang->getField("MPLG_ALAMAT");	
	$arr_parent[$j]['MPLG_BADAN_USAHA'] = $penagihan_piutang->getField("MPLG_BADAN_USAHA");	
	$arr_parent[$j]['TOTAL_PIUTANG'] = $penagihan_piutang->getField("TOTAL_PIUTANG");
	$j++;
}

echo json_encode($arr_parent);
?>