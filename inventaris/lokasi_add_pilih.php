<?
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-inventaris/Lokasi.php");

$lokasi = new Lokasi();

$reqId = httpFilterGet("reqId");


$reqInduk = substr($reqId, 0, 3);

$lokasi->selectByParams(array("LOKASI_ID" => $reqInduk));
$lokasi->firstRow();
$tempGambar = $lokasi->getField("FILE_GAMBAR");

list($width, $height, $type, $attr) = getimagesize("uploads/lokasi/".$tempGambar."");

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Layout Perusahaan</title>
	<style type="text/css">@import "../WEB-INF/lib/zoommap/zoommap.css";</style>
	<script type="text/javascript" src="../WEB-INF/lib/zoommap/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="../WEB-INF/lib/zoommap/zoommap.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
		
		/* Show jQuery is running */
		$('h1').css({textDecoration: 'underline'});
		
		$('#map').zoommap({
				// Width and Height of the Map
				width: '<?=$width?>px',
				height: '<?=$height?>px',
					
				//Misc Settings
				blankImage: 'images/blank.gif',
				zoomDuration: 1000,
				bulletWidthOffset: '10px',
				bulletHeightOffset: '10px',
				
				//ids and classes
				zoomClass: 'zoomable',
				popupSelector: 'div.popup',
				popupCloseSelector: 'a.close',
				
				//Return to Parent Map Link
				showReturnLink: true,
				returnId: 'returnlink',
				returnText: 'Return to Full Map',
				
				//Initial Region to be shown
				map: {
					id: 'campus',
					image: 'uploads/lokasi/<?=$tempGambar?>',
					data: 'lokasi_add_pilih_data.php?reqId=<?=$reqId?>',
				}
			});
		
			$("#map").click(function (e) {
				window.parent.document.getElementById("reqX").value = e.pageX;	
				window.parent.document.getElementById("reqY").value = e.pageY;
				window.parent.divwin.close();			
			});

		
		});
    </script>
</head>
<body style="margin:0 0; padding:0 0">
<div id="map" style="margin:0 0"></div>
</body>
</html>