<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/HasilRapatAttachment.php");

$hasil_rapat_attachment = new HasilRapatAttachment();

$reqId = httpFilterGet("reqId");
$reqDeleteId = httpFilterGet("reqDeleteId");
$reqMode = httpFilterGet("reqMode");

if($reqId == "")
{
	echo '<script language="javascript">';
	echo "alert('Isi data terlebih dahulu.');";	
	echo "window.parent.location.href = 'hasil_rapat_add.php';";
	echo '</script>';
	exit();
}
if($reqMode == "delete")
{
	$hasil_rapat_attachment->setField("HASIL_RAPAT_ATTACHMENT_ID", $reqDeleteId);	
	$hasil_rapat_attachment->delete();	
}

$hasil_rapat_attachment->selectByParams(array("HASIL_RAPAT_ID" => $reqId));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
</head>
<body>
<div id="begron"><img src="images/bg-kanan-polos.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Upload Data Hasil Rapat</span>
    </div>
<table id="gradient-style" style="width:96%">
<thead>

<tr>
<th scope="col">Nama</th>
<th scope="col">Ukuran</th>
<th scope="col">Tipe</th>
<th scope="col">Aksi</th>
</tr>
</thead>
<tbody>
    <?
    while($hasil_rapat_attachment->nextRow())
	{
	?>
        <tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'hasil_rapat_add_upload.php?reqId=<?=$reqId?>&reqRowId=<?=$hasil_rapat_attachment->getField("HASIL_RAPAT_ATTACHMENT_ID")?>'">
            <td><?=$hasil_rapat_attachment->getField("FILE_NAMA")?></td>
            <td><?=round($hasil_rapat_attachment->getField("UKURAN")/1024, 2)?> kb</td>
            <td><?=$hasil_rapat_attachment->getField("FORMAT")?></td>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'hasil_rapat_add_upload_monitoring.php?reqMode=delete&reqId=<?=$hasil_rapat_attachment->getField("HASIL_RAPAT_ID")?>&reqDeleteId=<?=$hasil_rapat_attachment->getField("HASIL_RAPAT_ATTACHMENT_ID")?>' }"><img src="../WEB-INF/images/delete-icon.png"></a></td></td>
        </tr>    
    <?
	}
	?>    
</tbody>
</table>    
</div>
</body>
</html>