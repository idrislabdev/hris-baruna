<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiStatusNikah.php");

$pegawai_status_nikah = new PegawaiStatusNikah();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");

$pegawai_status_nikah->selectByParams(array('PEGAWAI_STATUS_NIKAH_ID'=>$reqRowId));
$pegawai_status_nikah->firstRow();
//echo $pegawai_status_nikah->query;

$tempTanggalNikah = dateToPageCheck($pegawai_status_nikah->getField('TANGGAL_NIKAH'));
$tempStatusNikah = $pegawai_status_nikah->getField('STATUS_NIKAH');
$tempTempat = $pegawai_status_nikah->getField('TEMPAT');
$tempNoSK = $pegawai_status_nikah->getField('NO_SK');
$tempHubungan = $pegawai_status_nikah->getField('HUBUNGAN');
$tempRowId = $pegawai_status_nikah->getField('PEGAWAI_STATUS_NIKAH_ID');
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
				url:'../json-simpeg/pegawai_add_status_nikah.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					
					parent.frames['mainFramePop'].location.href = 'pegawai_add_status_nikah_monitoring.php?reqId=' + data[0];
					<? if($tempRowId) { ?>
						document.location.href = 'pegawai_add_status_nikah.php?reqId=' + data[0] + '&reqRowId=' + data[2];
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
            <a href="pegawai_add_status_nikah.php?reqId=<?=$reqId?>">Batal</a>
            </li>        
        <?
		}
		?>
        </ul>
    </div>
    <form id="ff" method="post" novalidate style="margin-top:20px;">
    <table>
        <tr>
            <td>Tgl Nikah/Cerai</td>
            <td>
                <input id="dd" name="reqTanggalNikah" class="easyui-datebox" data-options="validType:'date'"  required="required" value="<?=$tempTanggalNikah?>"></input>
            </td>
        </tr>
        <tr>
            <td>Status Kawin</td>
            <td>
            	<select id="reqStatusNikah" name="reqStatusNikah" required="true">
                	<option value="1" <? if($tempStatusNikah == "1") echo 'selected'?>>Belum Kawin</option>
					<option value="2" <? if($tempStatusNikah == "2") echo 'selected'?>>Kawin</option>
					<option value="3" <? if($tempStatusNikah == "3") echo 'selected'?>>Janda</option>
					<option value="4" <? if($tempStatusNikah == "4") echo 'selected'?>>Duda</option>
                </select>
            </td>
        </tr>
        <tr>
        	<td>Tempat</td>
            <td>
                <input name="reqTempat" id="reqTempat" class="easyui-validatebox" size="40" type="text" value="<?=$tempTempat?>" />
            </td>
        </tr>
        <tr>
            <td>No SK</td>
            <td>
                <input name="reqNoSK" id="reqNoSK" class="easyui-validatebox" size="60" type="text" value="<?=$tempNoSK?>" />
            </td>
        </tr>
        <tr>
            <td>Hubungan Keluarga</td>
            <td>
                <select id="reqHubungan" name="reqHubungan" required="true">
                <option value="I" <? if($tempHubungan == 'I') echo 'selected';?>>Istri</option>
                <option value="S" <? if($tempHubungan == 'S') echo 'selected';?>>Suami</option>
                </select>
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