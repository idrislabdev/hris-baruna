<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/MeritPMS.php");

$merit_pms = new MeritPMS();
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
	$merit_pms->selectByParams(array("MERIT_PMS_ID" => $reqId));
	$merit_pms->firstRow();
	$tempPendidikanId = $merit_pms->getField("PENDIDIKAN_ID");
    $tempPeriode = $merit_pms->getField("PERIODE"); 
	$tempKelas = $merit_pms->getField("KELAS");	
	$tempJumlah = $merit_pms->getField("JUMLAH");
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
				url:'../json-gaji/merit_pms_add.php',
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Penghasilan Pokok</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Pendidikan</td>
            <td>
                <input id="reqPendidikanId" class="easyui-combotree" name="reqPendidikanId" data-options="url:'../json-simpeg/pendidikan_combo_json.php'" style="width:300px;" value="<?=$tempPendidikanId?>">
                <!-- <input name="reqKelas" class="easyui-validatebox" required="true" title="Kelas harus diisi" style="width:20px;" type="text" value="<?=$tempKelas?>" /> -->
            </td>
        </tr>
        <tr style="display: none;">
            <td>Periode</td>
            <td>
                <input name="reqPeriode" class="easyui-validatebox" required="true" title="Periode harus diisi" style="width:20px;" type="text" value="<?=$tempPeriode?>" />
            </td>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td>
                <input name="reqJumlah" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempJumlah)?>" id="reqJumlah"  OnFocus="FormatAngka('reqJumlah')" OnKeyUp="FormatUang('reqJumlah')" OnBlur="FormatUang('reqJumlah')"  />
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