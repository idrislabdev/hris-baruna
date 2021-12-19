<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPenghasilan.php");

$pegawai_penghasilan = new PegawaiPenghasilan();

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
	$pegawai_penghasilan->setField("PEGAWAI_PENGHASILAN_ID", $reqDeleteId);
	$pegawai_penghasilan->delete();	
}

$pegawai_penghasilan->selectByParams(array("PEGAWAI_ID" => $reqId));
//echo $pegawai_penghasilan->query;
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
                <span><img src="../WEB-INF/images/panah-judul.png">Data Penghasilan</span>
    </div>
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">Periodik</th>
    <th scope="col">Kelas</th>
    <th scope="col">TMT</th>
    <th scope="col">No SK</th>
    <th scope="col">Tanggal SK</th>
    <th scope="col">Pejabat Penetap</th>
    <th scope="col">Masa Kerja</th>
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>
    
    <?
    while($pegawai_penghasilan->nextRow())
	{
	?>
        <tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_penghasilan.php?reqId=<?=$reqId?>&reqRowId=<?=$pegawai_penghasilan->getField("PEGAWAI_PENGHASILAN_ID")?>'">
            <td><?=$pegawai_penghasilan->getField("PERIODE")?></td>
            <td><?=$pegawai_penghasilan->getField("KELAS")?></td>
            <td><?=dateToPageCheck($pegawai_penghasilan->getField("TMT_PENGHASILAN"))?></td>
            <td><?=$pegawai_penghasilan->getField("NO_SK")?></td>
            <td><?=dateToPageCheck($pegawai_penghasilan->getField("TANGGAL_SK"))?></td>
            <td><?=$pegawai_penghasilan->getField("PEJABAT_PENETAP_NAMA")?></td>
            <td><?=$pegawai_penghasilan->getField("MASA_KERJA_TAHUN").'-'.$pegawai_penghasilan->getField("MASA_KERJA_BULAN")?></td>
            <?php /*?><td><?=currencyToPage($pegawai_penghasilan->getField("JUMLAH_PENGHASILAN"))?></td>
            <td><?=currencyToPage($pegawai_penghasilan->getField("JUMLAH_TPP"))?></td>
            <td><?=currencyToPage($pegawai_penghasilan->getField("JUMLAH_TUNJANGAN_JABATAN"))?></td>
            <td><?=currencyToPage($pegawai_penghasilan->getField("JUMLAH_TUNJANGAN_SELISIH"))?></td>
            <td><?=currencyToPage($pegawai_penghasilan->getField("JUMLAH_TRANSPORTASI"))?></td>
            <td><?=currencyToPage($pegawai_penghasilan->getField("JUMLAH_UANG_MAKAN"))?></td>
            <td><?=currencyToPage($pegawai_penghasilan->getField("JUMLAH_INSENTIF"))?></td>
            <td><?=currencyToPage($pegawai_penghasilan->getField("JUMLAH_MOBILITAS"))?></td>
            <td><?=$pegawai_penghasilan->getField("PROSENTASE_PENGHASILAN")?></td>
            <td><?=$pegawai_penghasilan->getField("PROSENTASE_TUNJANGAN_JABATAN")?></td><?php */?>
            <td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pegawai_add_penghasilan_monitoring.php?reqMode=delete&reqId=<?=$pegawai_penghasilan->getField("PEGAWAI_ID")?>&reqDeleteId=<?=$pegawai_penghasilan->getField("PEGAWAI_PENGHASILAN_ID")?>' }"><img src="../WEB-INF/images/delete-icon.png"></a></td>
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>