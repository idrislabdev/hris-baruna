<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/NoFakturPajakD.php");

$reqTanggal = httpFilterGet("reqTanggal");
$reqFakturPajak = httpFilterGet("reqFakturPajak");
/* create objects */

$no_faktur_pajak_d = new NoFakturPajakD();

	
$j=0;
$no_faktur_pajak_d->selectByParamsAktif(array("STATUS"=>0),-1,-1);

while($no_faktur_pajak_d->nextRow())
{
	$arr_parent[$j]['id'] = $no_faktur_pajak_d->getField("NOMOR");
	$arr_parent[$j]['text'] = $no_faktur_pajak_d->getField("NOMOR");
	$j++;
}

if($reqFakturPajak == "")
{}
else
{
	$arr_parent[$j]['id'] = $reqFakturPajak;
	$arr_parent[$j]['text'] = $reqFakturPajak;
}


echo json_encode($arr_parent);
?>