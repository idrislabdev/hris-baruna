<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatanP3.php");
include_once("../WEB-INF/classes/base/DeleteRowUser.php");

$pegawai_jabatan_p3 = new PegawaiJabatanP3();

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
	$pegawai_jabatan_p3->setField("PEGAWAI_JABATAN_P3_ID", $reqDeleteId);
	$pegawai_jabatan_p3->delete();	

	$delete_row_user = new DeleteRowUser();
	$delete_row_user->setField("TABEL_NAMA", "PEGAWAI_JABATAN_P3");
	$delete_row_user->setField("TABEL_ROW_ID", $reqDeleteId);
	$delete_row_user->setField("USER_NAMA", $userLogin->nama);
	$delete_row_user->setField("TABEL_ROW_ID_INDUK", $reqId);
	$delete_row_user->insert();	

	echo '<script language="javascript">';
	echo 'window.parent.frames["mainFrameDetilPop"].location.reload();';
	echo '</script>';
			
}

$pegawai_jabatan_p3->selectByParams(array("PEGAWAI_ID" => $reqId));
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
                <span><img src="../WEB-INF/images/panah-judul.png">Data Jabatan Perbantuan</span>
    </div>
    <!--<table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">Jabatan</th>
    <th scope="col">Cabang</th>
    <th scope="col">Departemen</th>
    <th scope="col">No SK</th>
    <th scope="col">Tanggal SK</th>
    <th scope="col">TMT Jabatan</th>
    <th scope="col">Nama</th>
    <th scope="col">Keterangan</th>
    <th scope="col">Pejabat Penetap</th>
    <th scope="col">Aksi</th>
    </tr>
    <table id="gradient-style" style="width:1510px">
    <thead>
    <tr>
    <th scope="col" style="width:200px">Jabatan</th>
    <th scope="col" style="width:150px">Cabang</th>
    <th scope="col" style="width:150px">Unit Kerja</th>
    <th scope="col" style="width:100px">No SK</th>
    <th scope="col" style="width:50px">Tanggal SK</th>
    <th scope="col" style="width:50px">TMT Jabatan</th>
    <th scope="col" style="width:100px">Nama</th>
    <th scope="col" style="width:300px">Keterangan</th>
    <th scope="col" style="width:200px">Pejabat Penetap</th>
    <th scope="col" style="width:10px">Aksi</th>
    </tr>-->
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">Jabatan</th>
    <!--<th scope="col">Cabang</th>
    <th scope="col">Unit Kerja</th>-->
    <th scope="col">No SK</th>
    <th scope="col">Tanggal SK</th>
    <th scope="col">TMT Jabatan</th>
    <!--<th scope="col">Nama</th>-->
    <th scope="col">Uraian Tugas</th>
    <th scope="col">Pejabat Penetap</th>
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>

    <?
    while($pegawai_jabatan_p3->nextRow())
	{
	?>
    	<tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_jabatan_perbantuan.php?reqId=<?=$reqId?>&reqRowId=<?=$pegawai_jabatan_p3->getField("PEGAWAI_JABATAN_P3_ID")?>'">
            <td><?=$pegawai_jabatan_p3->getField("JABATAN_NAMA")?></td>
            <?php /*?><td><?=$pegawai_jabatan_p3->getField("CABANG_NAMA")?></td>
            <td><?=$pegawai_jabatan_p3->getField("DEPARTEMEN_NAMA")?></td><?php */?>
            <td><?=$pegawai_jabatan_p3->getField("NO_SK")?></td>
            <td><?=dateToPageCheck($pegawai_jabatan_p3->getField("TANGGAL_SK"))?></td>
            <td><?=dateToPageCheck($pegawai_jabatan_p3->getField("TMT_JABATAN"))?></td>
            <?php /*?><td><?=$pegawai_jabatan_p3->getField("NAMA")?></td><?php */?>
            <td><?=$pegawai_jabatan_p3->getField("KETERANGAN")?></td>
            <td><?=$pegawai_jabatan_p3->getField("PEJABAT_PENETAP_NAMA")?></td>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pegawai_add_jabatan_perbantuan_monitoring.php?reqMode=delete&reqId=<?=$pegawai_jabatan_p3->getField("PEGAWAI_ID")?>&reqDeleteId=<?=$pegawai_jabatan_p3->getField("PEGAWAI_JABATAN_P3_ID")?>' }"><img src="../WEB-INF/images/delete-icon.png"></a></td>
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>