<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/TunjanganMasaKerja.php");

$tunjangan_masa_kerja = new TunjanganMasaKerja();
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
	$tunjangan_masa_kerja->selectByParams(array("TUNJANGAN_MASA_KERJA_ID" => $reqId));
	$tunjangan_masa_kerja->firstRow();
	$tempAwal = $tunjangan_masa_kerja->getField("AWAL");
	$tempAkhir = $tunjangan_masa_kerja->getField("AKHIR");	
	$tempNilai = $tunjangan_masa_kerja->getField("NILAI");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-gaji/tunjangan_masa_kerja_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
				}
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Tunjangan Masa Kerja</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Awal</td>
            <td>
                <input name="reqAwal" class="easyui-validatebox" required="true" title="Kelas harus diisi" style="width:20px;" type="text" value="<?=$tempAwal?>" />
            </td>
        </tr>
        <tr>
            <td>Akhir</td>
            <td>
                <input name="reqAkhir" class="easyui-validatebox" required="true" title="Periode harus diisi" style="width:20px;" type="text" value="<?=$tempAkhir?>" />
            </td>
        </tr>
        <tr>
            <td>Nilai</td>
            <td>
                <input name="reqNilai" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempNilai)?>" id="reqNilai"  OnFocus="FormatAngka('reqNilai')" OnKeyUp="FormatUang('reqNilai')" OnBlur="FormatUang('reqNilai')"  />
            </td>
        </tr>                
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>