<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPangkat.php");
include_once("../WEB-INF/classes/base/DeleteRowUser.php");

$pegawai_pangkat = new PegawaiPangkat();

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
	$pegawai_pangkat->setField("PEGAWAI_PANGKAT_ID", $reqDeleteId);
	$pegawai_pangkat->delete();	

	$delete_row_user = new DeleteRowUser();
	$delete_row_user->setField("TABEL_NAMA", "PEGAWAI_PANGKAT");
	$delete_row_user->setField("TABEL_ROW_ID", $reqDeleteId);
	$delete_row_user->setField("USER_NAMA", $userLogin->nama);
	$delete_row_user->setField("TABEL_ROW_ID_INDUK", $reqId);
	$delete_row_user->insert();		

	echo '<script language="javascript">';
	echo 'window.parent.frames["mainFrameDetilPop"].location.reload();';
	echo '</script>';
		
}

$pegawai_pangkat->selectByParams(array("PEGAWAI_ID" => $reqId));
//echo $pegawai_pangkat->query;
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
                <span><img src="../WEB-INF/images/panah-judul.png">Data Pangkat</span>
    </div>
    <!--<table id="gradient-style" style="width:140%">
    <thead>
    <tr>
    <th scope="col">TMT</th>
    <th scope="col">Jabatan</th>
    <th scope="col">Jenis Pangkat</th>
    <th scope="col">Kode Pangkat</th>
    <th scope="col">Kode Perubahan Pangkat</th>
    <th scope="col">Nomor SK</th>
    <th scope="col">Tanggal SK</th>
    <th scope="col">Gaji Pokok</th>
    <th scope="col">Masa Kerja</th>
    <th scope="col">Pejabat Tanda Tangan</th>
    <th scope="col">Aksi</th>
    </tr>
    <table id="gradient-style" style="width:1100px">
    <thead>
    <tr>
    <th scope="col" style="width:50px">TMT</th>
    <th scope="col" style="width:100px">Jabatan</th>
    <th scope="col" style="width:100px">Jenis Pangkat</th>
    <th scope="col" style="width:100px">Kode Pangkat</th>
    <th scope="col" style="width:200px">Kode Perubahan Pangkat</th>
    <th scope="col" style="width:100px">Nomor SK</th>
    <th scope="col" style="width:50px">Tanggal SK</th>
    <th scope="col" style="width:100px">Gaji Pokok</th>
    <th scope="col" style="width:90px">Masa Kerja</th>
    <th scope="col" style="width:200px">Pejabat Tanda Tangan</th>
    <th scope="col" style="width:10px">Aksi</th>
    </tr>-->
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">TMT</th>
    <!--<th scope="col">Jabatan</th>-->
    <th scope="col">Jenis Pangkat</th>
    <th scope="col">Kode Pangkat</th>
    <th scope="col">Kode Perubahan Pangkat</th>
    <!--<th scope="col">Nomor SK</th>
    <th scope="col">Tanggal SK</th>-->
    <!--<th scope="col">Gaji Pokok</th>-->
    <th scope="col">Masa Kerja</th>
    <th scope="col">Pejabat Penetap</th>
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>
    
    <?
    while($pegawai_pangkat->nextRow())
	{
	?>
        <tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_pangkat.php?reqId=<?=$reqId?>&reqRowId=<?=$pegawai_pangkat->getField("PEGAWAI_PANGKAT_ID")?>'">
            <td><?=dateToPageCheck($pegawai_pangkat->getField("TMT_PANGKAT"))?></td>
            <?php /*?><td><?=$pegawai_pangkat->getField("JABATAN_NAMA")?></td><?php */?>
            <td><?=$pegawai_pangkat->getField("PANGKAT_NAMA")?></td>
            <td><?=$pegawai_pangkat->getField("PANGKAT_KODE_NAMA")?></td>
            <td><?=$pegawai_pangkat->getField("PANGKAT_PERUBAHAN_KODE_NAMA")?></td>
            <?php /*?><td><?=$pegawai_pangkat->getField("NO_SK")?></td>
            <td><?=dateToPageCheck($pegawai_pangkat->getField("TANGGAL_SK"))?></td><?php */?>
            <?php /*?><td><?=currencyToPage($pegawai_pangkat->getField("GAJI_POKOK"))?></td><?php */?>
            <td><?=$pegawai_pangkat->getField("MASA_KERJA_TAHUN").'-'.$pegawai_pangkat->getField("MASA_KERJA_BULAN")?></td>
            <td><?=$pegawai_pangkat->getField("PEJABAT_PENETAP_NAMA")?></td>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pegawai_add_pangkat_monitoring.php?reqMode=delete&reqId=<?=$pegawai_pangkat->getField("PEGAWAI_ID")?>&reqDeleteId=<?=$pegawai_pangkat->getField("PEGAWAI_PANGKAT_ID")?>' }"><img src="../WEB-INF/images/delete-icon.png"></a></td>
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>