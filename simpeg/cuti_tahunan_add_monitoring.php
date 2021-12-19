<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunanDetil.php");
include_once("../WEB-INF/classes/base/DeleteRowUser.php");


$cuti_tahunan_detil = new CutiTahunanDetil();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqDeleteId = httpFilterGet("reqDeleteId");
$reqMode = httpFilterGet("reqMode");

if($reqId == "")
{
	echo '<script language="javascript">';
	echo 'alert("Isi data pegawai terlebih dahulu.");';	
	echo 'window.parent.location.href = "cuti_tahunan_add.php";';
	echo '</script>';
	exit();
}
if($reqMode == "delete")
{
	$cuti_tahunan_detil->setField("CUTI_TAHUNAN_DETIL_ID", $reqDeleteId);
	$cuti_tahunan_detil->delete();	

	$delete_row_user = new DeleteRowUser();
	$delete_row_user->setField("TABEL_NAMA", "CUTI_TAHUNAN");
	$delete_row_user->setField("TABEL_ROW_ID", $reqDeleteId);
	$delete_row_user->setField("USER_NAMA", $userLogin->nama);
	$delete_row_user->setField("TABEL_ROW_ID_INDUK", $reqId);
	$delete_row_user->insert();	

	echo "<script language='javascript'>";
	echo "parent.frames['mainFrameDetilPop'].location.href = 'cuti_tahunan_add_detil.php?reqId=".$reqId."'";
	echo "</script>";	
}

if($reqMode == "tunda")
{
	$cuti_tahunan_detil->setField("CUTI_TAHUNAN_DETIL_ID", $reqDeleteId);
	$cuti_tahunan_detil->updateStatusTunda();	
	echo "<script language='javascript'>";
	echo "parent.frames['mainFrameDetilPop'].location.href = 'cuti_tahunan_add_detil.php?reqId=".$reqId."'";
	echo "</script>";
}

$cuti_tahunan_detil->selectByParams(array("CUTI_TAHUNAN_ID" => $reqId), -1, -1, "", " ORDER BY CUTI_TAHUNAN_DETIL_ID DESC ");
//echo $cuti_tahunan_detil->query;
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
    <th scope="col">Tgl Permohonan</th>
    <th scope="col">Lokasi</th>
    <th scope="col">Tgl Awal</th>
    <th scope="col">Tgl Akhir</th>
    <th scope="col">Lama Cuti</th>
    <th scope="col">Status Tunda</th>
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>
    
    <?
    while($cuti_tahunan_detil->nextRow())
	{
		$show_hapus = true;
		if($cuti_tahunan_detil->getField("TANGGAL_APPROVE") == "")
		{
			if($cuti_tahunan_detil->getField("TANGGAL_CETAK") == "")
				$show_tunda = false;
			else
				$show_tunda = true;				
		}
		else
			$show_tunda = true;
			
		if($cuti_tahunan_detil->getField("STATUS_TUNDA_ID") == 2)
		{
			$show_tunda = false;
			$show_hapus = false;
		}
		if($cuti_tahunan_detil->getField("TANGGAL") == "")
		{		
			$show_hapus = false;
			$show_tunda = false;		
		}
	?>
        <tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'cuti_tahunan_add_detil.php?reqId=<?=$reqId?>&reqMode=update&reqRowId=<?=$cuti_tahunan_detil->getField("CUTI_TAHUNAN_DETIL_ID");?>'">
            <td><?=dateToPageCheck($cuti_tahunan_detil->getField("TANGGAL"))?></td>
      		<td><?=$cuti_tahunan_detil->getField("LOKASI_CUTI")?></td>
            <td><?=dateToPageCheck($cuti_tahunan_detil->getField("TANGGAL_AWAL"))?></td>
            <td><?=dateToPageCheck($cuti_tahunan_detil->getField("TANGGAL_AKHIR"))?></td>
            <td><?=$cuti_tahunan_detil->getField("LAMA_CUTI")?></td>
            <td><?=$cuti_tahunan_detil->getField("STATUS_TUNDA")?></td>
            <td><? if($cuti_tahunan_detil->getField("STATUS_TUNDA_ID") == 1) { 
             	/*?><a href="#" onClick="parent.frames['mainFrameDetilPop'].location.href ='cuti_tahunan_add_detil.php?reqMode=realisasi&reqId=<?=$reqId?>&reqRowId=<?=$cuti_tahunan_detil->getField("CUTI_TAHUNAN_DETIL_ID")?>'"> Realisasi </a>- <?php */ 
             } else { 
             	if($show_tunda == true) { ?>
             		<!-- <a href="#" onClick="if(confirm('Apakah anda yakin ingin melakukan penundaan pada data ini?')) { window.location.href = 'cuti_tahunan_add_monitoring.php?reqMode=tunda&reqId=<?=$cuti_tahunan_detil->getField("CUTI_TAHUNAN_ID")?>&reqDeleteId=<?=$cuti_tahunan_detil->getField("CUTI_TAHUNAN_DETIL_ID")?>' }">Tunda</a> -  -->
             		<a href="#" onClick="window.location.href = 'cuti_tahunan_add_detil.php?reqId=<?=$reqId?>&reqMode=update&reqRowId=<?=$cuti_tahunan_detil->getField("CUTI_TAHUNAN_DETIL_ID");?>">Tunda</a> - <? 
             	} 
             } 
             if($show_hapus == true) { ?>
             	<a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'cuti_tahunan_add_monitoring.php?reqMode=delete&reqId=<?=$cuti_tahunan_detil->getField("CUTI_TAHUNAN_ID")?>&reqDeleteId=<?=$cuti_tahunan_detil->getField("CUTI_TAHUNAN_DETIL_ID")?>' }">Hapus</a><? } ?>
             </td
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>