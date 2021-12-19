<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiSertifikatFile.php");

$pegawai_sertifikat_file = new PegawaiSertifikatFile();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqDeleteId = httpFilterGet("reqDeleteId");
$reqMode = httpFilterGet("reqMode");

if($reqId == "")
{
	echo '<script language="javascript">';
	echo "window.parent.divwin.close();";
	echo '</script>';
	exit();
}
if($reqMode == "delete")
{
	$pegawai_sertifikat_file->setField("PEGAWAI_SERTIFIKAT_FILE_ID", $reqDeleteId);	
	$pegawai_sertifikat_file->delete();	
}

$pegawai_sertifikat_file->selectByParams(array("PEGAWAI_SERTIFIKAT_ID" => $reqId));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Upload Sertifikat Kapal</span>
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
    while($pegawai_sertifikat_file->nextRow())
	{
	?>
        <tr>
            <td><?=$pegawai_sertifikat_file->getField("FILE_NAMA")?></td>
            <td><?=round($pegawai_sertifikat_file->getField("FILE_UKURAN")/1024, 2)?> kb</td>
            <td><?=$pegawai_sertifikat_file->getField("FILE_FORMAT")?></td>
            <td>
            <a href="open.php?reqMode=pegawai_sertifikat&reqId=<?=$pegawai_sertifikat_file->getField("PEGAWAI_SERTIFIKAT_FILE_ID")?>" target="_blank"><img src="../WEB-INF/images/download.png" width="20" height="20"></a>
            <a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pegawai_add_sertifikat_add_data_upload_monitoring.php?reqMode=delete&reqId=<?=$pegawai_sertifikat_file->getField("PEGAWAI_SERTIFIKAT_ID")?>&reqDeleteId=<?=$pegawai_sertifikat_file->getField("PEGAWAI_SERTIFIKAT_FILE_ID")?>' }"><img src="../WEB-INF/images/delete-icon.png"></a>
            </td>
        </tr>    
    <?
	}
	?>    
</tbody>
</table>    
</div>
</body>
</html>