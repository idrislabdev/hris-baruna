<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/InventarisRuangan.php");

$inventaris_ruangan = new InventarisRuangan();

$reqMode = httpFilterGet("reqMode");
$reqRowId = httpFilterGet("reqRowId");
$reqId = httpFilterGet("reqId");
$reqInventarisId = httpFilterGet("reqInventarisId");
$reqInventarisNama = httpFilterGet("reqInventarisNama");

$inventaris_ruangan->selectByParams(array("A.INVENTARIS_RUANGAN_ID" => $reqRowId));
$inventaris_ruangan->firstRow();

$tempLinkFileTemp 	= $inventaris_ruangan->getField('FILE_GAMBAR');

if ($tempLinkFileTemp=="")
{
	$linkGambar = "../WEB-INF/images/no-img.jpg";
}
else
{
	$linkGambar = "../operasional/uploads/inventaris_ruangan/".$tempLinkFileTemp;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>

<link rel="stylesheet" type="text/css" href="../WEB-INF/css/gaya.css">

<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
<script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/globalfunction.js"></script>

<script language="Javascript">
<? include_once "../jslib/formHandler.php"; ?>
</script>

</head>

<body>
	<center>
		<img src="<?=$linkGambar?>" height="300" width="400" />
    </center>
</body>
</html>