<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/ParameterPotonganWajib.php");

$parameter_potongan_wajib = new ParameterPotonganWajib();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");

if($reqMode == "update")
{
	$parameter_potongan_wajib->selectByParams(array("JENIS_POTONGAN" => $reqId, "KELAS" => $reqRowId), -1, -1);
	$parameter_potongan_wajib->firstRow();
	
	$tempJenisPotongan = $parameter_potongan_wajib->getField("JENIS_POTONGAN");
	$tempKelas = $parameter_potongan_wajib->getField("KELAS");
	$tempJumlah = $parameter_potongan_wajib->getField("JUMLAH");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../simpeg/js/globalfunction.js"></script>
	<script type="text/javascript">
		function setValue(){
			$('#ccJabatan').combotree('setValue', '<?=$tempJabatan?>');
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-gaji/parameter_potongan_wajib_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					<?php /*?>$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>	<?php */?>	
					//alert(data);
					data = data.split("-");
					document.location.href = 'parameter_potongan_wajib_add.php?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>';
					//parent.frames["mainFrameDetilPop"].document.getElementById("btnSubmit").click();
					//parent.frames["mainFrame"].document.getElementById("btnSubmit").click();
					top.frames['mainFrame'].location.reload();		
					window.parent.divwin.close(); 	
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data ParameterPotonganWajib</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
    	<tr>
            <td>Jenis Potongan</td>
            <td>
            	<input name="reqJenisPotongan" id="reqJenisPotongan" class="easyui-validatebox" required="true" style="width:100px;"  type="text" value="<?=$tempJenisPotongan?>" />
            </td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>
            	<input name="reqKelas" id="reqKelas" class="easyui-validatebox" required="true" style="width:40px;"  type="text" value="<?=$tempKelas?>" />
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
            <input type="hidden" name="reqRowId" value="<?=$reqRowId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
<script>

$("#reqKelas").keypress(function(e) {
	//alert(e.which);
	if( e.which!=46 && e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>