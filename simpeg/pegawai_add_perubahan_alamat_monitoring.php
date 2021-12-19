<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PerubahanAlamat.php");

$perubahan_alamat = new PerubahanAlamat();

$reqId = httpFilterGet("reqId");
$reqDeleteId = httpFilterGet("reqDeleteId");
$reqMode = httpFilterGet("reqMode");

if($reqId == "")
{
	echo '<script language="javascript">';
	echo 'alert("Isi data pegawai terlebih dahulu.");';	
	echo 'window.parent.location.href = "pegawai_add.php";';
	echo '</script>';
	exit();
}
if($reqMode == "delete")
{
	$perubahan_alamat->setField("PERUBAHAN_ALAMAT_ID", $reqDeleteId);
	$perubahan_alamat->delete();	
}

$perubahan_alamat->selectByParams(array("PEGAWAI_ID" => $reqId));
//echo $perubahan_alamat->query;
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
                <span><img src="../WEB-INF/images/panah-judul.png">Perubahan Alamat</span>
    </div>
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">TMT</th>
    <th scope="col">Alamat</th>
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>
    
    <?
    while($perubahan_alamat->nextRow())
	{
	?>
        <tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_perubahan_alamat.php?reqId=<?=$reqId?>&reqRowId=<?=$perubahan_alamat->getField("PERUBAHAN_ALAMAT_ID")?>'">
            <td><?=dateToPageCheck($perubahan_alamat->getField("TMT_PERUBAHAN_ALAMAT"))?></td>
            <td><?=$perubahan_alamat->getField("ALAMAT")?></td>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pegawai_add_perubahan_alamat_monitoring.php?reqMode=delete&reqId=<?=$perubahan_alamat->getField("PEGAWAI_ID")?>&reqDeleteId=<?=$perubahan_alamat->getField("PERUBAHAN_ALAMAT_ID")?>' }"><img src="../WEB-INF/images/delete-icon.png"></a></td>
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>