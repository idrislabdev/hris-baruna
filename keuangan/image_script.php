<?
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajak.php");
ini_set("memory_limit","100M");

$reqId = httpFilterRequest("reqId");  
$reqMode = httpFilterRequest("reqMode");  

$no_faktur_pajak = new NoFakturPajak();
$no_faktur_pajak->selectByParams(array("NO_FAKTUR_PAJAK_ID" => $reqId));
$no_faktur_pajak->firstRow();
$data= $no_faktur_pajak->getField("FILE_UPLOAD"); 
$tipe= $no_faktur_pajak->getField("FILE_FORMAT"); 
$nama= "file";
header("Content-type: $tipe");
header("Content-Disposition: inline; filename=$nama");
echo $data;
?>