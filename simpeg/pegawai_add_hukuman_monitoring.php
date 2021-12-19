<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiHukuman.php");
include_once("../WEB-INF/classes/base/DeleteRowUser.php");


$pegawai_hukuman = new PegawaiHukuman();

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
	$pegawai_hukuman->setField("PEGAWAI_HUKUMAN_ID", $reqDeleteId);
	$pegawai_hukuman->delete();	

	$delete_row_user = new DeleteRowUser();
	$delete_row_user->setField("TABEL_NAMA", "PEGAWAI_HUKUMAN");
	$delete_row_user->setField("TABEL_ROW_ID", $reqDeleteId);
	$delete_row_user->setField("USER_NAMA", $userLogin->nama);
	$delete_row_user->setField("TABEL_ROW_ID_INDUK", $reqId);
	$delete_row_user->insert();	
	
}

$pegawai_hukuman->selectByParams(array("PEGAWAI_ID" => $reqId));
//echo $pegawai_hukuman->query;
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
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">Kategori Hukuman</th>
    <th scope="col">Jenis Hukuman</th>
    <th scope="col">Tanggal SK</th>
    <th scope="col">Kasus</th>
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>
    
    <?
    while($pegawai_hukuman->nextRow())
	{
	?>
        <tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_hukuman.php?reqId=<?=$reqId?>&reqRowId=<?=$pegawai_hukuman->getField("PEGAWAI_HUKUMAN_ID")?>'">
            <td><?=$pegawai_hukuman->getField("KATEGORI_HUKUMAN")?></td>
            <td><?=$pegawai_hukuman->getField("JENIS_HUKUMAN")?></td>
            <td><?=dateToPageCheck($pegawai_hukuman->getField("TANGGAL_SK"))?></td>
            <td><?=$pegawai_hukuman->getField("KASUS")?></td>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pegawai_add_hukuman_monitoring.php?reqMode=delete&reqId=<?=$pegawai_hukuman->getField("PEGAWAI_ID")?>&reqDeleteId=<?=$pegawai_hukuman->getField("PEGAWAI_HUKUMAN_ID")?>' }"><img src="../WEB-INF/images/delete-icon.png"></a></td>
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>