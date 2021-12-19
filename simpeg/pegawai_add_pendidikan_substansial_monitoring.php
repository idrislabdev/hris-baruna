<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikanSubstansial.php");

$pegawai_pendidikan_substansial = new PegawaiPendidikanSubstansial();

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
	$pegawai_pendidikan_substansial->setField("PEGAWAI_PEND_SUBSTANSIAL_ID", $reqDeleteId);
	$pegawai_pendidikan_substansial->delete();	
}

$pegawai_pendidikan_substansial->selectByParams(array("PEGAWAI_ID" => $reqId));
//echo $pegawai_pendidikan_substansial->query;
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
                <span><img src="../WEB-INF/images/panah-judul.png">Data Pendidikan Substansial</span>
    </div>
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">Nama</th>
    <th scope="col">Tanggal Awal</th>
    <th scope="col">Tanggal Akhir</th>
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>
    
    <?
    while($pegawai_pendidikan_substansial->nextRow())
	{
	?>
        <tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_pendidikan_substansial.php?reqId=<?=$reqId?>&reqRowId=<?=$pegawai_pendidikan_substansial->getField("PEGAWAI_PEND_SUBSTANSIAL_ID")?>'">
            <td><?=$pegawai_pendidikan_substansial->getField("NAMA")?></td>
            <td><?=dateToPageCheck($pegawai_pendidikan_substansial->getField("TANGGAL_AWAL"))?></td>
            <td><?=dateToPageCheck($pegawai_pendidikan_substansial->getField("TANGGAL_AKHIR"))?></td>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pegawai_add_pendidikan_substansial_monitoring.php?reqMode=delete&reqId=<?=$pegawai_pendidikan_substansial->getField("PEGAWAI_ID")?>&reqDeleteId=<?=$pegawai_pendidikan_substansial->getField("PEGAWAI_PEND_SUBSTANSIAL_ID")?>' }"><img src="../WEB-INF/images/delete-icon.png"></a></td>
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>