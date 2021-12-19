<?
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-inventaris/Lokasi.php");

$lokasi = new Lokasi();

$reqId = httpFilterGet("reqId");

$lokasi->selectByParams(array("LOKASI_ID" => $reqId));
?>
<link href="../WEB-INF/lib/zoommap/popups/themes/main.css" rel="stylesheet" type="text/css">
<?
$i=1;
while($lokasi->nextRow())
{
?>
	<a href="javascript:void(0)" id="<?=$i?>" class="bullet" rel="<?=$lokasi->getField('X')."-".$lokasi->getField('Y')?>"><img src="../WEB-INF/lib/map/interactivemap/images/pin-green.png" border="0" /></a> 	
<?
	$i++;
}
?>