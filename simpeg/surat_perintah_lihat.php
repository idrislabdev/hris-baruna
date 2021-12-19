<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-operasional/SuratPerintahUsulan.php");
include_once("../WEB-INF/classes/base-operasional/SuratPerintah.php");

$surat_perintah_usulan = new SuratPerintahUsulan();

$reqId = httpFilterGet("reqId");
$reqDeleteId = httpFilterGet("reqDeleteId");
$reqMode = httpFilterGet("reqMode");
$reqStatus = httpFilterGet("reqStatus");

if($reqMode == "delete")
{
	$surat_perintah_usulan->setField("SURAT_PERINTAH_USULAN_ID", $reqDeleteId);
	$surat_perintah_usulan->delete();	
}

if($reqMode == "approve")
{
	$surat_perintah = new SuratPerintah();
	$surat_perintah->setField("SURAT_PERINTAH_ID", $reqId);
	$surat_perintah->setField("STATUS", "A");
	$surat_perintah->updateStatus();
	echo "
	<script type='text/javascript'>
	top.frames['mainFrame'].location.reload();
	</script>
	";
}


$surat_perintah_usulan->selectByParams(array("SURAT_PERINTAH_ID" => $reqId));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
	<script language="javascript">

		function windowOpener(windowHeight, windowWidth, windowName, windowUri)
		{
			var centerWidth = (window.screen.width - windowWidth) / 2;
			var centerHeight = (window.screen.height - windowHeight) / 2;
		
			newWindow = window.open(windowUri, windowName, 'resizable=0,width=' + windowWidth + 
				',height=' + windowHeight + 
				',left=' + centerWidth + 
				',top=' + centerHeight);
		
			newWindow.focus();
			return newWindow.name;
		}
	
	</script>
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Surat Perintah</span>
    </div>
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col" rowspan="2" style="text-align:center">NRP</th>
    <th scope="col" rowspan="2" style="text-align:center">Nama</th>
    <th scope="col" colspan="2" style="text-align:center">Sebelum</th>
    <th scope="col" colspan="2" style="text-align:center">Sesudah</th>
    </tr>
    <tr>
    <th scope="col" style="text-align:center">Jabatan</th>
    <th scope="col" style="text-align:center">Kapal</th>
    <th scope="col" style="text-align:center">Jabatan</th>
    <th scope="col" style="text-align:center">Kapal</th>
    </tr>
    </thead>
    <tbody>

    <?
    while($surat_perintah_usulan->nextRow())
	{
	?>
    	<tr>
            <td><?=$surat_perintah_usulan->getField("NRP")?></td>
            <td><?=$surat_perintah_usulan->getField("NAMA")?></td>
            <td><?=$surat_perintah_usulan->getField("JABATAN_AWAL")?></td>
            <td><?=$surat_perintah_usulan->getField("KAPAL_AWAL")?></td>
            <td><?=$surat_perintah_usulan->getField("JABATAN_AKHIR")?></td>
            <td><?=$surat_perintah_usulan->getField("KAPAL_AKHIR")?></td>
        </tr>    
    <?
	}
	?>    
    </table>
	<?
    if($reqStatus == "C")
	{
	?>
    	<br>
    	&nbsp;&nbsp;&nbsp;<input type="button" value="Setujui" onClick="if(confirm('Setujui usulan terpilih?')) { window.location.href = 'surat_perintah_setujui.php?reqId=<?=$reqId?>' }">
    	&nbsp;&nbsp;&nbsp;<input type="button" value="Tolak" onClick="if(confirm('Tolak usulan terpilih?')) { window.location.href = 'surat_perintah_keterangan_tolak.php?reqId=<?=$reqId?>' }">
    <?
	}
	?>
</div>
</body>
</html>