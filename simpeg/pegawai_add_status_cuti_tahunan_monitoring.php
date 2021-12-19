<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunanDetil.php");
include_once("../WEB-INF/classes/base/DeleteRowUser.php");


$cuti_tahunan = new CutiTahunan();
$cuti_tahunan_detil = new CutiTahunanDetil();

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
$cuti_tahunan->setField('PEGAWAI_ID', $reqId);
$cuti_tahunan->deletePegawai();
$cuti_tahunan_detil->deletePegawai($reqId);
		
}

if($reqMode == "tunda")
{
	$cuti_tahunan->setField("CUTI_TAHUNAN_DETIL_ID", $reqDeleteId);
	$cuti_tahunan->updateStatusTunda();	

	
}

$cuti_tahunan->selectByParamsPegawai(array("PEGAWAI_ID" => $reqId), -1, -1, " AND STATUS_BAYAR_MUTASI IS NOT NULL ");
//echo $cuti_tahunan->query;
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
                <span><img src="../WEB-INF/images/panah-judul.png">Pelaksanaan Cuti</span>
    </div>
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">Periode</th>
    <th scope="col">Jumlah Pelaksanaan Cuti (hari)</th>
    <th scope="col">Jumlah Terbayar (hari)</th>
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>
    
    <?
    while($cuti_tahunan->nextRow())
	{
	?>
        <tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_status_cuti_tahunan.php?reqId=<?=$reqId?>'">
            <td><?=$cuti_tahunan->getField("PERIODE")?></td>
            <td><?=$cuti_tahunan->getField("LAMA_CUTI")?></td>
            <td><?=$cuti_tahunan->getField("LAMA_CUTI_TERBAYAR")?></td>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pegawai_add_status_cuti_tahunan_monitoring.php?reqMode=delete&reqId=<?=$reqId?>' }">Hapus</a></td>
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>