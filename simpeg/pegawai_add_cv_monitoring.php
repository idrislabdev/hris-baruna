<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPengalamanKerja.php");

$pengalaman_kerja = new PegawaiPengalamanKerja();

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
	$pengalaman_kerja->setField("PEGAWAI_PENGALAMAN_KERJA_ID", $reqDeleteId);
	$pengalaman_kerja->delete();

	echo '<script language="javascript">';
	echo "window.parent.frames[\"mainFramePop\"].location.href='pegawai_add_cv_monitoring.php?reqId=<?=$reqId?>'";
	echo "window.parent.frames[\"mainFrameDetilPop\"].location.href='pegawai_add_cv.php?reqId=<?=$reqId?>'";
	echo '</script>';
	
}

$pengalaman_kerja->selectByParams(array("PEGAWAI_ID" => $reqId));
//echo $pengalaman_kerja->query;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Daftar Pengalaman Kerja</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
</head>

<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Pengalaman Kerja</span>
    </div>
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">Nama Perusahaan</th>
    <th scope="col">Jabatan</th>
    <th scope="col">Masuk Kerja</th>
    <th scope="col">Keluar Kerja</th>
    <th scope="col">Gaji</th>
    <th scope="col">Fasilitas</th>
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>
    
    <?
    while($pengalaman_kerja->nextRow())
	{
	?>
        <tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_cv.php?reqId=<?=$reqId?>&reqRowId=<?=$pengalaman_kerja->getField("PEGAWAI_PENGALAMAN_KERJA_ID");?>'">
            <td><?=$pengalaman_kerja->getField("NAMA_PERUSAHAAN");?></td>
            <td><?=$pengalaman_kerja->getField("JABATAN");?></td>
            <td><?=$pengalaman_kerja->getField("MASUK_KERJA_TEK");?></td>
            <td><?=$pengalaman_kerja->getField("KELUAR_KERJA_TEK");?></td>
            <td><?=$pengalaman_kerja->getField("GAJI");?></td>
            <td><?=$pengalaman_kerja->getField("FASILITAS");?></td>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pegawai_add_cv_monitoring.php?reqMode=delete&reqId=<?=$pengalaman_kerja->getField("PEGAWAI_ID")?>&reqDeleteId=<?=$pengalaman_kerja->getField("PEGAWAI_PENGALAMAN_KERJA_ID")?>' }"><img src="../WEB-INF/images/delete-icon.png"></a></td>
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>