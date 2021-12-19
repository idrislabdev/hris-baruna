<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiSKCalonPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/Pendidikan.php");
include_once("../WEB-INF/classes/base-simpeg/Pangkat.php");
include_once("../WEB-INF/classes/base-simpeg/PangkatKode.php");
include_once("../WEB-INF/classes/base-simpeg/PejabatPenetap.php");

$pegawai_sk_calon_pegawai = new PegawaiSKCalonPegawai();
$pendidikan = new Pendidikan();
$pangkat = new Pangkat();
$pangkat_kode = new PangkatKode();
$pejabat_penetap = new PejabatPenetap();

$reqId = httpFilterGet("reqId");
$reqPegawaiSKCalonPegawaiId= httpFilterGet("reqPegawaiSKCalonPegawaiId");

if($reqId == "")
{
	echo '<script language="javascript">';
	echo 'alert("Isi data pegawai terlebih dahulu.");';	
	echo 'window.parent.location.href = "pegawai_add.php";';
	echo '</script>';
	exit();
}

$pegawai_sk_calon_pegawai->selectByParams(array("PEGAWAI_ID" => $reqId));
$pegawai_sk_calon_pegawai->firstRow();
	
$tempNoSK = $pegawai_sk_calon_pegawai->getField('NO_SK');
$tempTMT = dateToPageCheck($pegawai_sk_calon_pegawai->getField('TMT_SK'));
$tempTanggalSK = dateToPageCheck($pegawai_sk_calon_pegawai->getField('TANGGAL_SK'));
//$tempPendidikanId = $pegawai_sk_calon_pegawai->getField('');
$tempPendidikan = $pegawai_sk_calon_pegawai->getField('PENDIDIKAN_ID');
$tempTahun = $pegawai_sk_calon_pegawai->getField('MASA_KERJA_TAHUN');
$tempBulan = $pegawai_sk_calon_pegawai->getField('MASA_KERJA_BULAN');
$tempPangkat = $pegawai_sk_calon_pegawai->getField('PANGKAT_ID');
//$tempPangkatKodeId = $pegawai_sk_calon_pegawai->getField('');
$tempPangkatKode = $pegawai_sk_calon_pegawai->getField('PANGKAT_KODE_ID');
$tempPejabat = $pegawai_sk_calon_pegawai->getField('PEJABAT_PENETAP_ID');
$tempTMTP3 = dateToPageCheck($pegawai_sk_calon_pegawai->getField('TMT_P3'));
$tempPegawaiSKCalonPegawaiId = $pegawai_sk_calon_pegawai->getField('PEGAWAI_SK_CALON_PEGAWAI_ID');

if($tempPegawaiSKCalonPegawaiId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";
}

$pendidikan->selectByParams();
$pangkat->selectByParams();
$pangkat_kode->selectByParams();
$pejabat_penetap->selectByParams();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
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
				url:'../json-simpeg/pegawai_add_sk_calon_pegawai.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					//$.messager.alert('Info', data, 'info');
					
					$('#rst_form').click();
					//top.frames['mainFrame'].location.reload();
					//parent.frames['menuFramePop'].location.href = 'hasil_rapat_add_menu.php?reqId=' + data[0];
					document.location.href = 'pegawai_add_sk_calon_pegawai.php?reqId=' + data[0];
					<? if($reqMode == "update") {} else { ?> window.parent.divwin.close(); <? } ?>					
				}
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script>    
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">SK Calon Pegawai</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td style="width:120px">No SK</td>
            <td>
                <input name="reqNoSK" id="reqNoSK" class="easyui-validatebox" required="required" size="30" type="text" value="<?=$tempNoSK?>" />
            </td>
            <td>TMT</td>
            <td>
                <input id="dd" name="reqTMT" class="easyui-datebox" data-options="validType:'date'" required="required" value="<?=$tempTMT?>"></input>
            </td>
        </tr>
        <tr>
            <td>Kodik</td>
            <td>
            	<select id="reqPendidikan" name="reqPendidikan">
                	<? while($pendidikan->nextRow()){?>
                	<option value="<?=$pendidikan->getField('PENDIDIKAN_ID')?>" <? if($pendidikan->getField('PENDIDIKAN_ID') == $tempPendidikan) echo 'selected';?>><?=$pendidikan->getField('NAMA')?></option>
                    <? }?>
                </select>
                
                <?php /*?><input name="reqPendidikanId" id="reqPendidikanId" class="easyui-validatebox" required="required" size="5" type="text" value="<?=$tempPendidikanId?>" />
                <input name="reqPendidikan" class="easyui-validatebox" required="required" size="40" type="text" value="<?=$tempPendidikan?>" /><?php */?>
            </td>
            <td>Tanggal SK</td>
            <td>
                <input id="dd" name="reqTanggalSK" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalSK?>"></input>
            </td>
        </tr>
        <tr>
            <td>Tahun Masa Kerja</td>
            <td>
                <input name="reqTahun" id="reqTahun" class="easyui-validatebox" size="4" maxlength="4" type="text" value="<?=$tempTahun?>" /> TH
                &nbsp;&nbsp;&nbsp;
                Bulan Masa Kerja
                <input name="reqBulan" id="reqBulan" class="easyui-validatebox" size="4" maxlength="2" type="text" value="<?=$tempBulan?>" /> BL
            </td>
            <?php /*?><td>Bulan Masa Kerja</td>
            <td>
                <input name="reqBulan" id="reqBulan" class="easyui-validatebox" required="required" size="4" maxlength="2" type="text" value="<?=$tempBulan?>" /> BL
            </td><?php */?>
            <td>Jenis Pegawai</td>
            <td>
            	<select id="reqPangkat" name="reqPangkat">
                	<? while($pangkat->nextRow()){?>
                	<option value="<?=$pangkat->getField('PANGKAT_ID')?>" <? if($pangkat->getField('PANGKAT_ID') == $tempPangkat) echo 'selected';?>><?=$pangkat->getField('NAMA')?></option>
                    <? }?>
                </select>
            </td>
        </tr>
        <tr>
            <?php /*?><td>Jenis Pegawai</td>
            <td>
            	<select id="reqPangkat" name="reqPangkat">
                	<? while($pangkat->nextRow()){?>
                	<option value="<?=$pangkat->getField('PANGKAT_ID')?>" <? if($pangkat->getField('PANGKAT_ID') == $tempPangkat) echo 'selected';?>><?=$pangkat->getField('NAMA')?></option>
                    <? }?>
                </select>
            </td><?php */?>
            <td>Pejabat Penetap</td>
            <td>
            	<select id="reqPejabat" name="reqPejabat">
                <? while($pejabat_penetap->nextRow()){?>
                	<option value="<?=$pejabat_penetap->getField('PEJABAT_PENETAP_ID')?>" <? if($tempPejabat == $pejabat_penetap->getField('PEJABAT_PENETAP_ID')) echo 'selected';?>><?=$pejabat_penetap->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
            <td>Kode Pangkat</td>
            <td>
            	<select id="reqPangkatKode" name="reqPangkatKode">
                	<? while($pangkat_kode->nextRow()){?>
                	<option value="<?=$pangkat_kode->getField('PANGKAT_KODE_ID')?>" <? if($pangkat_kode->getField('PANGKAT_KODE_ID') == $tempPangkatKode) echo 'selected';?>><?=$pangkat_kode->getField('NAMA')?></option>
                    <? }?>
                </select>
                <?php /*?><input name="reqPangkatKodeId" id="reqPangkatKodeId" class="easyui-validatebox" required="required" size="10" type="text" value="<?=$tempPangkatKodeId?>" />
                <input name="reqPangkatKode" id="reqPangkatKode" class="easyui-validatebox" required="required" size="10" type="text" value="<?=$tempPangkatKode?>" /><?php */?>
            </td>
        </tr>
        <tr>
        	<?php /*?><td>Pejabat Penetap</td>
            <td>
            	<select id="reqPejabat" name="reqPejabat">
                <? while($pejabat_penetap->nextRow()){?>
                	<option value="<?=$pejabat_penetap->getField('PEJABAT_PENETAP_ID')?>" <? if($tempPejabat == $pejabat_penetap->getField('PEJABAT_PENETAP_ID')) echo 'selected';?>><?=$pejabat_penetap->getField('NAMA')?></option>
                <? }?>
                </select>
            </td><?php */?>
            <td>TMT P3</td>
            <td>
                <input id="dd" name="reqTMTP3" class="easyui-datebox" data-options="validType:'date'" required="required" value="<?=$tempTMTP3?>"></input>
            </td>
        </tr>
    </table>
        <div>
        	<input type="hidden" name="reqPegawaiSKCalonPegawaiId" value="<?=$tempPegawaiSKCalonPegawaiId?>">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
<script>
$("#reqTahun,#reqBulan").keypress(function(e) {
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