<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikan.php");
include_once("../WEB-INF/classes/base-simpeg/Universitas.php");
include_once("../WEB-INF/classes/base-simpeg/Pendidikan.php");
include_once("../WEB-INF/classes/base-simpeg/PendidikanBiaya.php");

$pegawai_pendidikan = new PegawaiPendidikan();
$universitas = new Universitas();
$pendidikan = new Pendidikan();
$pendidikan_biaya = new PendidikanBiaya();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");

$pegawai_pendidikan->selectByParams(array('PEGAWAI_PENDIDIKAN_ID'=>$reqRowId));
$pegawai_pendidikan->firstRow();
//echo $pegawai_pendidikan->query;

$tempPendidikanId = $pegawai_pendidikan->getField('PENDIDIKAN_ID');
$tempPendidikanBiayaId = $pegawai_pendidikan->getField('PENDIDIKAN_BIAYA_ID');
$tempNama = $pegawai_pendidikan->getField('NAMA');
$tempKota = $pegawai_pendidikan->getField('KOTA');
$tempUniversitasId = $pegawai_pendidikan->getField('UNIVERSITAS_ID');
$tempTanggalIjasah = dateToPageCheck($pegawai_pendidikan->getField('TANGGAL_IJASAH'));
$tempLulus = $pegawai_pendidikan->getField('LULUS');
$tempNo = $pegawai_pendidikan->getField('NO_IJASAH');
$tempTtdIjazah = $pegawai_pendidikan->getField('TTD_IJASAH');
$tempNoAcc = $pegawai_pendidikan->getField('NO_ACC');
$tempTanggalAcc = dateToPageCheck($pegawai_pendidikan->getField('TANGGAL_ACC'));
$tempRowId = $pegawai_pendidikan->getField('PEGAWAI_PENDIDIKAN_ID');

$pendidikan_biaya->selectByParams();
$universitas->selectByParams();
$pendidikan->selectByParams(array(),-1,-1,"", "ORDER BY NAMA");
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
				url:'../json-simpeg/pegawai_add_pendidikan.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					
					parent.frames['mainFramePop'].location.href = 'pegawai_add_pendidikan_monitoring.php?reqId=' + data[0];
					<? if($tempRowId) { ?>
						document.location.href = 'pegawai_add_pendidikan.php?reqId=' + data[0] + '&reqRowId=' + data[2];
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
            <a href="pegawai_add_pendidikan.php?reqId=<?=$reqId?>">Batal</a>
            </li>        
        <?
		}
		?>
        </ul>
    </div>
    <form id="ff" method="post" novalidate style="margin-top:20px;">
    <table>
        <tr>
            <td>Pendidikan</td>
            <td>
            	<select id="reqPendidikanId" name="reqPendidikanId" required="true">
                <? while($pendidikan->nextRow()){?>
                	<option value="<?=$pendidikan->getField('PENDIDIKAN_ID')?>" <? if($tempPendidikanId == $pendidikan->getField('PENDIDIKAN_ID')) echo 'selected';?>><?=$pendidikan->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
            <td>Tgacckop</td>
            <td>
                <input id="dd" name="reqTanggalAcc" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalAcc?>"></input>
            </td>
            <?php /*?><td>Kode Biaya</td>
            <td>
            	<select id="reqPendidikanBiayaId" name="reqPendidikanBiayaId" required="true">
                <? while($pendidikan_biaya->nextRow()){?>
                	<option value="<?=$pendidikan_biaya->getField('PENDIDIKAN_BIAYA_ID')?>" <? if($tempPendidikanBiayaId == $pendidikan_biaya->getField('PENDIDIKAN_BIAYA_ID')) echo 'selected';?>><?=$pendidikan_biaya->getField('NAMA')?></option>
                <? }?>
                </select>
            </td><?php */?>
        </tr>
        <tr>
        	<td colspan="2"></td>
            <td>No Acckop</td>
            <td>
                <input name="reqNoAcc" id="reqNoAcc" class="easyui-validatebox" size="25" type="text" value="<?=$tempNoAcc?>" />
            </td>
        </tr>
        <tr>
        	<td>Nama Sekolah</td>
            <td colspan="3">
                <input name="reqNama" id="reqNama" class="easyui-validatebox" required size="40" type="text" value="<?=$tempNama?>" />
            </td>
        </tr>
        <tr>
        	<td>Jurusan Pendidikan</td>
            <td>
                <input name="reqKota" id="reqKota" class="easyui-validatebox" size="30" type="text" value="<?=$tempKota?>" />
            </td>
            <td>Lembaga Pendidikan</td>
            <td>
            	<select id="reqUniversitasId" name="reqUniversitasId" required="true">
                <? while($universitas->nextRow()){?>
                	<option value="<?=$universitas->getField('UNIVERSITAS_ID')?>" <? if($tempUniversitasId == $universitas->getField('UNIVERSITAS_ID')) echo 'selected';?>><?=$universitas->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
        </tr>
        <tr>
        	<?php /*?><td>No Ijazah</td>
            <td>
                <input name="reqNoIjasah" id="reqNoIjasah" class="easyui-validatebox" required="required" size="25" type="text" value="<?=$tempNo?>" />
            </td><?php */?>
            <td>Lulus</td>
            <td colspan="3">
                <input name="reqLulus" id="reqLulus" class="easyui-validatebox" size="4" maxlength="4" type="text" value="<?=$tempLulus?>" />
            </td>
        </tr>
        <tr>
        	<td>Tanggal Ijazah</td>
            <td>
                <input id="dd" name="reqTanggalIjasah" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalIjasah?>"></input>
            </td>
            <td>Kode Biaya</td>
            <td>
            	<select id="reqPendidikanBiayaId" name="reqPendidikanBiayaId" required="true">
                <? while($pendidikan_biaya->nextRow()){?>
                	<option value="<?=$pendidikan_biaya->getField('PENDIDIKAN_BIAYA_ID')?>" <? if($tempPendidikanBiayaId == $pendidikan_biaya->getField('PENDIDIKAN_BIAYA_ID')) echo 'selected';?>><?=$pendidikan_biaya->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
            <?php /*?><td>Tgacckop</td>
            <td>
                <input id="dd" name="reqTanggalAcc" class="easyui-datebox" data-options="validType:'date'"  required="required" value="<?=$tempTanggalAcc?>"></input>
            </td><?php */?>
        </tr>
        <tr>
        	<td>No Ijazah</td>
            <td colspan="3">
                <input name="reqNoIjasah" id="reqNoIjasah" class="easyui-validatebox" size="65" type="text" value="<?=$tempNo?>" />
            </td>
        </tr>
        <tr>
        	<td>Ttd Ijazah</td>
            <td colspan="3">
                <input name="reqTtdIjazah" id="reqTtdIjazah" class="easyui-validatebox" size="65" type="text" value="<?=$tempTtdIjazah?>" />
            </td>
            <?php /*?><td>No Acc</td>
            <td>
                <input name="reqNoAcc" id="reqNoAcc" class="easyui-validatebox" required="required" size="25" type="text" value="<?=$tempNoAcc?>" />
            </td><?php */?>
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
<script>
$("#reqLulus").keypress(function(e) {
	if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});

$("#reqKredit").keypress(function(e) {
	//alert(e.which);
	if( e.which!=46 && e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>