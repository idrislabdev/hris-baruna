<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiKeluarga.php");
include_once("../WEB-INF/classes/base-simpeg/HubunganKeluarga.php");
include_once("../WEB-INF/classes/base-simpeg/Pendidikan.php");

$pegawai_keluarga = new PegawaiKeluarga();
$hubungan_keluarga = new HubunganKeluarga();
$pendidikan = new Pendidikan();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");

$pegawai_keluarga->selectByParams(array('PEGAWAI_KELUARGA_ID'=>$reqRowId));
$pegawai_keluarga->firstRow();
//echo $pegawai_keluarga->query;

$tempHubunganKeluargaId = $pegawai_keluarga->getField('HUBUNGAN_KELUARGA_ID');
$tempStatusKawin = $pegawai_keluarga->getField('STATUS_KAWIN');
$tempJenisKelamin = $pegawai_keluarga->getField('JENIS_KELAMIN');
$tempStatusTunjangan = $pegawai_keluarga->getField('STATUS_TUNJANGAN');
$tempNama = $pegawai_keluarga->getField('NAMA');
$tempTanggalWafat = dateToPageCheck($pegawai_keluarga->getField('TANGGAL_WAFAT'));
$tempTanggalLahir = dateToPageCheck($pegawai_keluarga->getField('TANGGAL_LAHIR'));
$tempStatusTanggung = $pegawai_keluarga->getField('STATUS_TANGGUNG');
$tempTempatLahir = $pegawai_keluarga->getField('TEMPAT_LAHIR');
$tempPendidikanId = $pegawai_keluarga->getField('PENDIDIKAN_ID');
$tempPekerjaan = $pegawai_keluarga->getField('PEKERJAAN');
$tempNik = $pegawai_keluarga->getField('NIK');
$tempRowId = $pegawai_keluarga->getField('PEGAWAI_KELUARGA_ID');

$pendidikan->selectByParams();
$hubungan_keluarga->selectByParams();
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
    <script type="text/javascript" src="../WEB-INF/js/globalfunction.js"></script>
   
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
					//alert(value.length);
					if(value.length == '10')
					{
						var reg = /^(\d{1,2})(-|\/)(\d{1,2})\2(\d{1,4})$/;
						//var reg = "(?:(0[1-9]|[12][0-9]|3[01])[\-.](0[1-9]|1[012])[\-.](18|19|20|21)[0-9]{2})+";
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
				url:'../json-simpeg/pegawai_add_keluarga.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					
					parent.frames['mainFramePop'].location.href = 'pegawai_add_keluarga_monitoring.php?reqId=' + data[0];
					<? if($tempRowId) { ?>
						document.location.href = 'pegawai_add_keluarga.php?reqId=' + data[0] + '&reqRowId=' + data[2];
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
            <a href="pegawai_add_keluarga.php?reqId=<?=$reqId?>">Batal</a>
            </li>        
        <?
		}
		?>
        </ul>
    </div>
    <form id="ff" method="post" novalidate style="margin-top:20px;">
    <table>
        <tr>
        	<td>Hubungan Keluarga</td>
            <td>
            	<select id="reqHubunganKeluargaId" name="reqHubunganKeluargaId" required="true">
                <? while($hubungan_keluarga->nextRow()){?>
                	<option value="<?=$hubungan_keluarga->getField('HUBUNGAN_KELUARGA_ID')?>" <? if($tempHubunganKeluargaId == $hubungan_keluarga->getField('HUBUNGAN_KELUARGA_ID')) echo 'selected';?>><?=$hubungan_keluarga->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
            <td>Status Kawin</td>
            <td>
            	<input type="checkbox" id="reqStatusKawin" name="reqStatusKawin" value="1" <? if($tempStatusKawin == 1) echo "checked"; ?>>
            </td>
        </tr>
        <tr>
        	<td>Jenis Kelamin</td>
            <td>
            	<select id="reqJenisKelamin" name="reqJenisKelamin">
                    <option value="L" <? if($tempJenisKelamin == 'L') echo 'selected';?>>L</option>
                    <option value="P" <? if($tempJenisKelamin == 'P') echo 'selected';?>>P</option>
                </select>
            </td>
            <td>Tunjangan</td>
            <td>
            	<input type="checkbox" id="reqStatusTunjangan" name="reqStatusTunjangan" value="1" <? if($tempStatusTunjangan == 1) echo "checked"; ?>>
            </td>
        </tr>
        <tr>
        	<td>Nama</td>
            <td>
                <input name="reqNama" id="reqNama" class="easyui-validatebox" required="required" size="35" type="text" value="<?=$tempNama?>" />
            </td>
            <td>Tanggal Wafat</td>
            <td>
                <input id="dd" name="reqTanggalWafat" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalWafat?>"></input>
            </td>
        </tr>
        <tr>
        	<td>Tanggal Lahir</td>
            <td>
                <input id="reqTanggalLahir" name="reqTanggalLahir" data-options="validType:'date'" class="easyui-datebox" value="<?=$tempTanggalLahir?>"></input>
            </td>
            <td>Status Tanggung</td>
            <td>
            	<input type="checkbox" id="reqStatusTanggung" name="reqStatusTanggung" value="1" <? if($tempStatusTanggung == 1) echo "checked"; ?>>
            </td>
        </tr>
        <tr>
        	<td>Tempat Lahir</td>
            <td colspan="3">
                <input name="reqTempatLahir" id="reqTempatLahir" class="easyui-validatebox" size="20" type="text" value="<?=$tempTempatLahir?>" />
            </td>
        </tr>
        <tr>
        	<td>Pendidikan</td>
            <td colspan="3">
                <select id="reqPendidikanId" name="reqPendidikanId" required="true">
                <? while($pendidikan->nextRow()){?>
                	<option value="<?=$pendidikan->getField('PENDIDIKAN_ID')?>" <? if($tempPendidikanId == $pendidikan->getField('PENDIDIKAN_ID')) echo 'selected';?>><?=$pendidikan->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td colspan="3">
                <input name="reqPekerjaan" id="reqPekerjaan" class="easyui-validatebox" size="85" type="text" value="<?=$tempPekerjaan?>" />
            </td>
        </tr>
        <tr>
            <td>NIK</td>
            <td colspan="3">
                <input name="reqNik" id="reqNik" class="easyui-validatebox" size="15" type="text" value="<?=$tempNik?>" />
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