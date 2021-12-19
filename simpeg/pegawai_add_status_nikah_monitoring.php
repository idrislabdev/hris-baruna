<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiStatusNikah.php");

$pegawai_status_nikah = new PegawaiStatusNikah();

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
	$pegawai_status_nikah->setField("PEGAWAI_STATUS_NIKAH_ID", $reqDeleteId);
	$pegawai_status_nikah->delete();	
}

$pegawai_status_nikah->selectByParams(array("PEGAWAI_ID" => $reqId));
//echo $pegawai_status_nikah->query;
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
                <span><img src="../WEB-INF/images/panah-judul.png">Status Nikah</span>
    </div>
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">Tanggal Nikah</th>
    <th scope="col">Status</th>
    <th scope="col">Tempat</th>
    <th scope="col">No Sk</th>
    <th scope="col">Hubungan</th>
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>
    
    <?
    while($pegawai_status_nikah->nextRow())
	{
	?>
        <tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_status_nikah.php?reqId=<?=$reqId?>&reqRowId=<?=$pegawai_status_nikah->getField("PEGAWAI_STATUS_NIKAH_ID")?>'">
            <td><?=dateToPageCheck($pegawai_status_nikah->getField("TANGGAL_NIKAH"))?></td>
            <td><?=$pegawai_status_nikah->getField("STATUS_NIKAH_NAMA")?></td>
            <td><?=$pegawai_status_nikah->getField("TEMPAT")?></td>
            <td><?=$pegawai_status_nikah->getField("NO_SK")?></td>
            <td><?=$pegawai_status_nikah->getField("HUBUNGAN_NAMA")?></td>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pegawai_add_status_nikah_monitoring.php?reqMode=delete&reqId=<?=$pegawai_status_nikah->getField("PEGAWAI_ID")?>&reqDeleteId=<?=$pegawai_status_nikah->getField("PEGAWAI_STATUS_NIKAH_ID")?>' }"><img src="../WEB-INF/images/delete-icon.png"></a></td>
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>