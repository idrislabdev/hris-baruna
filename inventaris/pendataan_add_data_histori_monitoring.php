<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/InventarisPenanggungJawab.php");

$inventaris_penanggung_jawab = new InventarisPenanggungJawab();

$reqId = httpFilterGet("reqId");
$reqDeleteId = httpFilterGet("reqDeleteId");
$reqInventarisNama = httpFilterGet("reqInventarisNama");
$reqMode = httpFilterGet("reqMode");


if($reqMode == "delete")
{
	$inventaris_penanggung_jawab->setField("INVENTARIS_PENANGGUNG_JAWAB_ID", $reqDeleteId);
	$inventaris_penanggung_jawab->delete();	
?>
    <script language="javascript">
    parent.reloadParent();
    </script>
<?
}
$inventaris_penanggung_jawab->selectByParams(array("A.INVENTARIS_RUANGAN_ID" => $reqId), -1, -1, "", " ORDER BY TMT DESC");
//echo $inventaris_penanggung_jawab->query;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="../WEB-INF/css/gaya.css">
</head>

<body class="bg-kanan-atas">
	<div id="judul-popup">Histori Penanggung Jawab</div>
	<div id="konten">
    	<div id="popup-tabel">
            <table>
            <thead>
                <tr>
                    <th style="width:150px">NRP</th>
                    <th style="width:250px">Nama</th>
                    <th style="width:100px">TMT</th>
                    <th style="width:200px">Lokasi</th>
                    <th style="width:50px">Aksi</th>
                </tr>
            </thead>            
            <tbody>
                <?
				while($inventaris_penanggung_jawab->nextRow())
				{
				?>
					<tr>
						<td><?=$inventaris_penanggung_jawab->getField("NRP")?></td>
						<td><?=$inventaris_penanggung_jawab->getField("PEGAWAI")?></td>
						<td><?=dateToPageCheck($inventaris_penanggung_jawab->getField("TMT"))?></td>
						<td><?=$inventaris_penanggung_jawab->getField("LOKASI")?></td>
						<td><a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'pendataan_add_data_histori_monitoring.php?reqMode=delete&reqId=<?=$inventaris_penanggung_jawab->getField("INVENTARIS_RUANGAN_ID")?>&reqDeleteId=<?=$inventaris_penanggung_jawab->getField("INVENTARIS_PENANGGUNG_JAWAB_ID")?>' }">Hapus</a></td>                                            
					</tr>    
				<?
				}
				?>    
            </tbody>
            </table>
        </div>
    </div>
</body>
</html>