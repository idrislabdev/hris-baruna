<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikan.php");

$pegawai_pendidikan = new PegawaiPendidikan();

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
	$pegawai_pendidikan->setField("PEGAWAI_PENDIDIKAN_ID", $reqDeleteId);
	$pegawai_pendidikan->delete();	
}

$pegawai_pendidikan->selectByParams(array("PEGAWAI_ID" => $reqId));
//echo $pegawai_pendidikan->query;
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
                <span><img src="../WEB-INF/images/panah-judul.png">Data Pendidikan</span>
    </div>
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">Pendidikan</th>
    <th scope="col">Pendidikan Biaya</th>
    <th scope="col">Nama Sekolah</th>
    <th scope="col">Kota</th>
    <th scope="col">Lembaga Pendidikan</th>
    <!--<th scope="col">Tanggal Ijasah</th>-->
    <th scope="col">Lulus</th>
    <th scope="col">No Ijasah</th>
    <!--<th scope="col">TTD Ijasah</th>
    <th scope="col">No Acc</th>
    <th scope="col">Tanggal Acc</th>-->
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?
    while($pegawai_pendidikan->nextRow())
	{
	?>
        <tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_pendidikan.php?reqId=<?=$reqId?>&reqRowId=<?=$pegawai_pendidikan->getField("PEGAWAI_PENDIDIKAN_ID")?>'">
            <td><?=$pegawai_pendidikan->getField("PENDIDIKAN_NAMA")?></td>
            <td><?=$pegawai_pendidikan->getField("PENDIDIKAN_BIAYA_NAMA")?></td>
            <td><?=$pegawai_pendidikan->getField("NAMA")?></td>
            <td><?=$pegawai_pendidikan->getField("KOTA")?></td>
            <td><?=$pegawai_pendidikan->getField("UNIVERSITAS_NAMA")?></td>
            <?php /*?><td><?=dateToPageCheck($pegawai_pendidikan->getField("TANGGAL_IJASAH"))?></td><?php */?>
            <td><?=$pegawai_pendidikan->getField("LULUS")?></td>
            <td><?=$pegawai_pendidikan->getField("NO_IJASAH")?></td>
            <?php /*?><td><?=$pegawai_pendidikan->getField("TTD_IJASAH")?></td>
            <td><?=$pegawai_pendidikan->getField("NO_ACC")?></td>
            <td><?=dateToPageCheck($pegawai_pendidikan->getField("TANGGAL_ACC"))?></td><?php */?>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pegawai_add_pendidikan_monitoring.php?reqMode=delete&reqId=<?=$pegawai_pendidikan->getField("PEGAWAI_ID")?>&reqDeleteId=<?=$pegawai_pendidikan->getField("PEGAWAI_PENDIDIKAN_ID")?>' }"><img src="../WEB-INF/images/delete-icon.png"></a></td>
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>