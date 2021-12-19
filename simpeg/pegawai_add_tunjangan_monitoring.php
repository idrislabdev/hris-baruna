<?
/*include_once("../WEB-INF/classes/utils/UserLogin.php");
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

$hasil_rapat_attachment->selectByParams(array("HASIL_RAPAT_ID" => $reqId));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Upload Data Hasil Rapat</span>
    </div>
    <table width="100%">
        <tr>
            <th>Nama</th>
            <th>Ukuran</th>
            <th>Tipe</th>
            <th>Aksi</th>
        </tr>
    <?php /*?><?
    while($hasil_rapat_attachment->nextRow())
	{
	?>
        <tr>
            <td><?=$hasil_rapat_attachment->getField("FILE_NAMA")?></td>
            <td><?=$hasil_rapat_attachment->getField("UKURAN")?></td>
            <td><?=$hasil_rapat_attachment->getField("FORMAT")?></td>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'hasil_rapat_add_upload_monitoring.php?reqMode=delete&reqId=<?=$hasil_rapat_attachment->getField("HASIL_RAPAT_ID")?>&reqDeleteId=<?=$hasil_rapat_attachment->getField("HASIL_RAPAT_ATTACHMENT_ID")?>' }">Hapus</a></td></td>
        </tr>    
    <?
	}
	?><?php */?>    
    </table>

</div>
</body>
</html>