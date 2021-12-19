<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/MeritHarian.php");

$merit_harian = new MeritHarian();
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
	$merit_harian->selectByParams(array("MERIT_HARIAN_ID" => $reqId));
	$merit_harian->firstRow();

	$tempJenisLokasi = $merit_harian->getField("JENIS_LOKASI");
	$tempMinggu = $merit_harian->getField("MINGGU");	
    $tempBulan = $merit_harian->getField("BULAN");
    $tempNilai = $merit_harian->getField("NILAI");
	$tempMax = $merit_harian->getField("MAX");
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
				url:'../json-gaji/merit_harian_add.php',
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Merit Harian</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Lokasi</td>
            <td>
                <input name="reqJenisLokasi" class="easyui-validatebox" required="true" title="Kelas harus diisi" style="width:250px;" type="text" value="<?=$tempJenisLokasi?>" />
            </td>
        </tr>
        <tr>
            <td>Per minggu</td>
            <td>
                <input name="reqMinggu" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempMinggu)?>" id="reqMinggu"  OnFocus="FormatAngka('reqMinggu')" OnKeyUp="FormatUang('reqMinggu')" OnBlur="FormatUang('reqMinggu')"  />
            </td>
        </tr> 
        <tr>
            <td>Per bulan</td>
            <td>
                <input name="reqBulan" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempBulan)?>" id="reqBulan"  OnFocus="FormatAngka('reqBulan')" OnKeyUp="FormatUang('reqBulan')" OnBlur="FormatUang('reqBulan')"  />
            </td>
        </tr> 
        <tr>
            <td>Tarif</td>
            <td>
                <input name="reqNilai" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempNilai)?>" id="reqNilai"  OnFocus="FormatAngka('reqNilai')" OnKeyUp="FormatUang('reqNilai')" OnBlur="FormatUang('reqNilai')"  />
            </td>
        </tr> 
        <tr>
            <td>Maksimal</td>
            <td>
                <input name="reqMax" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempMax)?>" id="reqMax"  OnFocus="FormatAngka('reqMax')" OnKeyUp="FormatUang('reqMax')" OnBlur="FormatUang('reqMax')"  />
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