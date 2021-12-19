<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPuspel.php");

$pegawai_puspel = new PegawaiPuspel();

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
	$pegawai_puspel->setField("PEGAWAI_PUSPEL_ID", $reqDeleteId);
	$pegawai_puspel->delete();	
}

$pegawai_puspel->selectByParams(array("PEGAWAI_ID" => $reqId));
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
                <span><img src="../WEB-INF/images/panah-judul.png">Puspel</span>
    </div>
    <!--<table id="gradient-style" style="width:730px">
    <thead>
    <tr>
    <th scope="col" style="width:50px">TMT Puspel</th>
    <th scope="col" style="width:150px">Cabang</th>
    <th scope="col" style="width:150px">Unit Kerja</th>
    <th scope="col" style="width:100px">Kode Pusple 1</th>
    <th scope="col" style="width:100px">Kode Pusple 2</th>
    <th scope="col" style="width:100px">Kode Pusple 3</th>
    <th scope="col" style="width:70px">Tanggal Puspel</th>
    <th scope="col" style="width:10px">Aksi</th>
    </tr>-->
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">TMT Puspel</th>
    <!--<th scope="col">Cabang</th>
    <th scope="col">Unit Kerja</th>-->
    <th scope="col">Kode Pusple 1</th>
    <th scope="col">Kode Pusple 2</th>
    <th scope="col">Kode Pusple 3</th>
    <th scope="col">Tanggal Puspel</th>
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>

    <?
    while($pegawai_puspel->nextRow())
	{
	?>
    	<tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_puspel.php?reqId=<?=$reqId?>&reqRowId=<?=$pegawai_puspel->getField("PEGAWAI_PUSPEL_ID")?>'">
            <td><?=dateToPageCheck($pegawai_puspel->getField("TMT_PUSPEL"))?></td>
            <?php /*?><td><?=$pegawai_puspel->getField("CABANG_NAMA")?></td>
            <td><?=$pegawai_puspel->getField("DEPARTEMEN_NAMA")?></td><?php */?>
            <td><?=$pegawai_puspel->getField("KODE_PUSPEL1")?></td>
            <td><?=$pegawai_puspel->getField("KODE_PUSPEL2")?></td>
            <td><?=$pegawai_puspel->getField("KODE_PUSPEL3")?></td>
            <td><?=dateToPageCheck($pegawai_puspel->getField("TANGGAL_PUSPEL"))?></td>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pegawai_add_puspel_monitoring.php?reqMode=delete&reqId=<?=$pegawai_puspel->getField("PEGAWAI_ID")?>&reqDeleteId=<?=$pegawai_puspel->getField("PEGAWAI_PUSPEL_ID")?>' }"><img src="../WEB-INF/images/delete-icon.png"></a></td>
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>