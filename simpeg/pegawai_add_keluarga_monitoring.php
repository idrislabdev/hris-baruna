<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiKeluarga.php");
include_once("../WEB-INF/classes/base/DeleteRowUser.php");


$pegawai_keluarga = new PegawaiKeluarga();

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
	$pegawai_keluarga->setField("PEGAWAI_KELUARGA_ID", $reqDeleteId);
	$pegawai_keluarga->delete();	

	$delete_row_user = new DeleteRowUser();
	$delete_row_user->setField("TABEL_NAMA", "PEGAWAI_KELUARGA");
	$delete_row_user->setField("TABEL_ROW_ID", $reqDeleteId);
	$delete_row_user->setField("USER_NAMA", $userLogin->nama);
	$delete_row_user->setField("TABEL_ROW_ID_INDUK", $reqId);
	$delete_row_user->insert();	
		
}

$pegawai_keluarga->selectByParams(array("PEGAWAI_ID" => $reqId));
//echo $pegawai_keluarga->query;
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
                <span><img src="../WEB-INF/images/panah-judul.png">Data Keluarga</span>
    </div>
    <!--<table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">Hubungan Keluarga</th>
    <th scope="col">Status Tunjangan</th>
    <th scope="col">Status Kawin</th>
    <th scope="col">Status Tanggung</th>
    <th scope="col">Nama</th>
    <th scope="col">Jenis Kelamin</th>
    <th scope="col">Tanggal Wafat</th>
    <th scope="col">Tanggal Lahir</th>
    <th scope="col">Tempat Lahir</th>
    <th scope="col">Pendidikan</th>
    <th scope="col">Pekerjaan</th>
    <th scope="col">Aksi</th>
    </tr>
    <table id="gradient-style" style="width:1130px">
    <thead>
    <tr>
    <th scope="col" style="width:150px">Hubungan Keluarga</th>
    <th scope="col" style="width:100px">Status Tunjangan</th>
    <th scope="col" style="width:80px">Status Kawin</th>
    <th scope="col" style="width:100px">Status Tanggung</th>
    <th scope="col" style="width:150px">Nama</th>
    <th scope="col" style="width:80px">Jenis Kelamin</th>
    <th scope="col" style="width:80px">Tanggal Wafat</th>
    <th scope="col" style="width:80px">Tanggal Lahir</th>
    
    <th scope="col" style="width:100px">Tempat Lahir</th>
    <th scope="col" style="width:100px">Pendidikan</th>
    <th scope="col" style="width:100px">Pekerjaan</th>
    <th scope="col" style="width:10px">Aksi</th>
    </tr>-->
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">Hubungan Keluarga</th>
    <th scope="col">Status Tunjangan</th>
    <th scope="col">Status Kawin</th>
    <th scope="col">Status Tanggung</th>
    <th scope="col">Nama</th>
    <th scope="col">Jenis Kelamin</th>
    <!--<th scope="col">Tanggal Wafat</th>
    <th scope="col">Tanggal Lahir</th>-->
    <!--<th scope="col">Tempat Lahir</th>-->
    <!--<th scope="col">Pendidikan</th>
    <th scope="col">Pekerjaan</th>-->
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>
    
    <?
    while($pegawai_keluarga->nextRow())
	{
	?>
        <tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_keluarga.php?reqId=<?=$reqId?>&reqRowId=<?=$pegawai_keluarga->getField("PEGAWAI_KELUARGA_ID")?>'">
            <td><?=$pegawai_keluarga->getField("HUBUNGAN_KELUARGA_NAMA")?></td>
            <td><?=$pegawai_keluarga->getField("STATUS_TUNJANGAN_NAMA")?></td>
            <td><?=$pegawai_keluarga->getField("STATUS_KAWIN_NAMA")?></td>
            <td><?=$pegawai_keluarga->getField("STATUS_TANGGUNG_NAMA")?></td>
            <td><?=$pegawai_keluarga->getField("NAMA")?></td>
            <td><?=$pegawai_keluarga->getField("JENIS_KELAMIN")?></td>
            <?php /*?><td><?=dateToPageCheck($pegawai_keluarga->getField("TANGGAL_WAFAT"))?></td>
            <td><?=dateToPageCheck($pegawai_keluarga->getField("TANGGAL_LAHIR"))?></td><?php */?>
            <?php /*?><td><?=$pegawai_keluarga->getField("TEMPAT_LAHIR")?></td><?php */?>
            <?php /*?><td><?=$pegawai_keluarga->getField("PENDIDIKAN_NAMA")?></td>
            <td><?=$pegawai_keluarga->getField("PEKERJAAN")?></td><?php */?>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pegawai_add_keluarga_monitoring.php?reqMode=delete&reqId=<?=$pegawai_keluarga->getField("PEGAWAI_ID")?>&reqDeleteId=<?=$pegawai_keluarga->getField("PEGAWAI_KELUARGA_ID")?>' }"><img src="../WEB-INF/images/delete-icon.png"></a></td>
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>