<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
include_once("../WEB-INF/classes/base/DeleteRowUser.php");

$pegawai_jenis_pegawai = new PegawaiJenisPegawai();

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
	$pegawai_jenis_pegawai->setField("PEGAWAI_JENIS_PEGAWAI_ID", $reqDeleteId);
	$pegawai_jenis_pegawai->delete();

	$delete_row_user = new DeleteRowUser();
	$delete_row_user->setField("TABEL_NAMA", "PEGAWAI_JENIS_PEGAWAI");
	$delete_row_user->setField("TABEL_ROW_ID", $reqDeleteId);
	$delete_row_user->setField("USER_NAMA", $userLogin->nama);
	$delete_row_user->setField("TABEL_ROW_ID_INDUK", $reqId);
	$delete_row_user->insert();	
	
	echo '<script language="javascript">';
	echo 'window.parent.frames["menuFramePop"].hide_perubahan_pangkat("'.$reqId.'");';
	echo 'window.parent.frames["mainFrameDetilPop"].location.reload();';
	echo '</script>';
	
	
	// reload menu apabila status perbantuan atau id 2
	
}

$pegawai_jenis_pegawai->selectByParams(array("PEGAWAI_ID" => $reqId));
//echo $pegawai_jenis_pegawai->query;
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
                <span><img src="../WEB-INF/images/panah-judul.png">Jenis Pegawai</span>
    </div>
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">TMT</th>
    <th scope="col">Jenis Pegawai</th>
    <th scope="col">Keterangan</th>
    <th scope="col">Status Calpeg</th>
    <th scope="col">Perubahan Jenis Pegawai</th>
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>
    
    <?
    while($pegawai_jenis_pegawai->nextRow())
	{
	?>
        <tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_jenis_pegawai.php?reqId=<?=$reqId?>&reqRowId=<?=$pegawai_jenis_pegawai->getField("PEGAWAI_JENIS_PEGAWAI_ID")?>'">
            <td><?=dateToPageCheck($pegawai_jenis_pegawai->getField("TMT_JENIS_PEGAWAI"))?></td>
            <td><?=$pegawai_jenis_pegawai->getField("JENIS_PEGAWAI_NAMA")?></td>
            <td><?=$pegawai_jenis_pegawai->getField("KETERANGAN")?></td>
            <td><?=$pegawai_jenis_pegawai->getField("STATUS_CALPEG_DESC")?></td>
            <td><?=$pegawai_jenis_pegawai->getField("JENIS_PEGAWAI_PERUBAH_KODE_NM")?></td>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pegawai_add_jenis_pegawai_monitoring.php?reqMode=delete&reqId=<?=$pegawai_jenis_pegawai->getField("PEGAWAI_ID")?>&reqDeleteId=<?=$pegawai_jenis_pegawai->getField("PEGAWAI_JENIS_PEGAWAI_ID")?>' }"><img src="../WEB-INF/images/delete-icon.png"></a></td>
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>