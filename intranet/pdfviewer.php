<?
include_once("../WEB-INF/functions/default.func.php");

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        
<html xmlns="http://www.w3.org/1999/xhtml" lang="em_AU">

<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title>Office Management - PDF Viewer</title>
<link href="../WEB-INF/lib/jquery-pdfdoc/main.css" rel="stylesheet" type="text/css" />
<script src="../WEB-INF/lib/jquery-pdfdoc/jquery.min.js"></script>
<link rel="stylesheet" href="../WEB-INF/lib/jquery-pdfdoc/jquery-pdfdoc.css" />
<script src="../WEB-INF/lib/jquery-pdfdoc/pdf.min.js"></script>
<script src="../WEB-INF/lib/jquery-pdfdoc/jquery-pdfdoc.js"></script>
</head>
<body>
<div class="preview">
	<div id="pdfdoc_5090946300b30"></div>
<script>$('#pdfdoc_5090946300b30').PDFDoc( { source : 'open.php?reqMode=<?=$reqMode?>&reqId=<?=$reqId?>' } );</script></div>

</ul>

</div>
    
	</body>
</html>
    
