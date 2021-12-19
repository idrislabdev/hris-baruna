<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmPelanggan.php");


/* create objects */

$safm_pelanggan = new SafmPelanggan();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");

if(strtoupper($reqMode) == "CABANG")
	$statement = " AND MPLG_NAMA LIKE '%CABANG%' ";

//$statement .= " AND EXISTS(SELECT 1 FROM SISWA_SPP_TERAKHIR X WHERE A.MPLG_KODE = X.MPLG_KODE) ";	

$j=0;

$safm_pelanggan->selectByParams(array(), -1, -1, $statement, " ORDER BY MPLG_NAMA, MPLG_KODE ASC ");
while($safm_pelanggan->nextRow())
{
	$arr_parent[$j]['id'] = $safm_pelanggan->getField("MPLG_KODE");
	$arr_parent[$j]['text'] = $safm_pelanggan->getField("MPLG_KODE")." - ".$safm_pelanggan->getField("MPLG_NAMA");
	$arr_parent[$j]['MPLG_KODE'] = $safm_pelanggan->getField("MPLG_KODE");	
	$arr_parent[$j]['MPLG_ALAMAT'] = $safm_pelanggan->getField("MPLG_ALAMAT");	
	$arr_parent[$j]['MPLG_BADAN_USAHA'] = $safm_pelanggan->getField("MPLG_BADAN_USAHA");	
	$arr_parent[$j]['MPLG_NPWP'] = $safm_pelanggan->getField("MPLG_NPWP");	
	$j++;
}

echo json_encode($arr_parent);
?>