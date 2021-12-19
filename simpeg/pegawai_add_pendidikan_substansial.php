<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikanSubstansial.php");

$pegawai_pendidikan_substansial = new PegawaiPendidikanSubstansial();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");

$pegawai_pendidikan_substansial->selectByParams(array('PEGAWAI_PEND_SUBSTANSIAL_ID'=>$reqRowId));
$pegawai_pendidikan_substansial->firstRow();
//echo $pegawai_pendidikan_substansial->query;

$tempTanggalAwal = dateToPageCheck($pegawai_pendidikan_substansial->getField('TANGGAL_AWAL'));
$tempTanggalAkhir = dateToPageCheck($pegawai_pendidikan_substansial->getField('TANGGAL_AKHIR'));
$tempNama = $pegawai_pendidikan_substansial->getField('NAMA');
$tempRowId = $reqRowId;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/bluetabs.css" />
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    
    <script type="text/javascript">
		$.fn.datebox.defaults.formatter = function(date) {
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			return (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
		};
		$.extend($.fn.validatebox.defaults.rules, {
			date:{
				validator:function(value, param) {
					if(value.length == '10')
					{
						var reg = /^(\d{1,2})(-|\/)(\d{1,2})\2(\d{1,4})$/;
						return reg.test(value);
					}
					else
					{
						return false;
					}
				},
				message:"Format Tanggal: dd-mm-yyyy"
			}  
		});
	
		$.fn.datebox.defaults.parser = function(s) {
			if (s) {
				var a = s.split('-');
				var d = new Number(a[0]);
				var m = new Number(a[1]);
				var y = new Number(a[2]);
				var dd = new Date(y, m-1, d);
				return dd;
			} 
			else 
			{
				return new Date();
			}
		};
		
		$(function(){
			$('#ff').form({
				url:'../json-simpeg/pegawai_add_pendidikan_substansial.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					
					parent.frames['mainFramePop'].location.href = 'pegawai_add_pendidikan_substansial_monitoring.php?reqId=' + data[0];
					<? if($tempRowId) { ?>
						document.location.href = 'pegawai_add_pendidikan_substansial.php?reqId=' + data[0] + '&reqRowId=' + data[2];
					<? } ?>
				}				
			});
		});
		
	</script>
    <style>
	    .CodeMirror-scroll { height: 100%; overflow-x: auto;}
	</style>
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah" class="CodeMirror-scroll">
	<div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif); position:fixed; width:100%; margin-top:0px; zIndex: -1'">    
        <ul>
            <li>
            <a href="#" onClick="$('#btnSubmit').click();">Simpan</a>
            </li>        
        <?
        if($reqRowId == "") {}
		else
		{
		?>
            <li>
            <a href="pegawai_add_pendidikan_substansial.php?reqId=<?=$reqId?>">Batal</a>
            </li>        
        <?
		}
		?>
        </ul>
    </div>
    <form id="ff" method="post" novalidate style="margin-top:20px;">
    <table>
    	<tr>
        	<td>Nama</td>
            <td>
            	<input type="text" name="reqNama" class="easyui-validatebox" required style="width:250px" value="<?=$tempNama?>" />
            </td>
        </tr>
        <tr>
            <td>Tanggal Awal</td>
            <td>
                <input id="reqTanggalAwal" name="reqTanggalAwal" class="easyui-datebox" data-options="validType:'date'"  value="<?=$tempTanggalAwal?>"></input>
            </td>
        </tr>
        <tr>
            <td>Tanggal Akhir</td>
            <td>
                <input id="reqTanggalAkhir" name="reqTanggalAkhir" class="easyui-datebox" data-options="validType:'date'"  value="<?=$tempTanggalAkhir?>"></input>
            </td>
        </tr>
    </table>
        <div style="display:none">
        	<? if($tempRowId == ''){ $reqMode='insert'; }else{ $reqMode='update'; }?>
        	<input type="hidden" name="reqRowId" value="<?=$tempRowId?>">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>