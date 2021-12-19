<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPangkat.php");
include_once("../WEB-INF/classes/base-simpeg/PangkatPerubahanKode.php");
include_once("../WEB-INF/classes/base-simpeg/Pangkat.php");
include_once("../WEB-INF/classes/base-simpeg/PangkatKode.php");
include_once("../WEB-INF/classes/base-simpeg/PejabatPenetap.php");
include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");

$pegawai_pangkat = new PegawaiPangkat();
$pegawai_jabatan = new PegawaiJabatan();
$pangkat_perubahan_kode = new PangkatPerubahanKode();
$pangkat = new Pangkat();
$pangkat_kode = new PangkatKode();
$pejabat_penetap = new PejabatPenetap();
$jabatan = new Jabatan();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");

$pegawai_jabatan->selectByParamsJabatanTerakhir(array('PEGAWAI_ID'=>$reqId));
$pegawai_jabatan->firstRow();
$tempJabatanView= $pegawai_jabatan->getField('JABATAN_ID');
//echo $tempJabatanView.'---';

$pegawai_pangkat->selectByParams(array('PEGAWAI_PANGKAT_ID'=>$reqRowId));
$pegawai_pangkat->firstRow();
//echo $pegawai_pangkat->query;

$tempTMT = dateToPageCheck($pegawai_pangkat->getField('TMT_PANGKAT'));
$tempPangkat = $pegawai_pangkat->getField('PANGKAT_ID');
$tempPangkatKode = $pegawai_pangkat->getField('PANGKAT_KODE_ID');
$tempPangkatPerubahanKode = $pegawai_pangkat->getField('PANGKAT_PERUBAHAN_KODE_ID');
$tempNoSK = $pegawai_pangkat->getField('NO_SK');
$tempTanggal = dateToPageCheck($pegawai_pangkat->getField('TANGGAL_SK'));
$tempGaji = $pegawai_pangkat->getField('GAJI_POKOK');
$tempTahun = $pegawai_pangkat->getField('MASA_KERJA_TAHUN');
$tempBulan = $pegawai_pangkat->getField('MASA_KERJA_BULAN');
$tempPejabat = $pegawai_pangkat->getField('PEJABAT_PENETAP_ID');
$tempUraian = $pegawai_pangkat->getField('KETERANGAN');
$tempRowId = $pegawai_pangkat->getField('PEGAWAI_PANGKAT_ID');
$tempKelas= $pegawai_pangkat->getField('KELAS');

$tempJabatan = $pegawai_pangkat->getField('JABATAN_ID');
if($tempJabatan == '')$tempJabatan= $tempJabatanView;

$jabatan->selectByParams();
$pangkat_perubahan_kode->selectByParams();
$pangkat->selectByParams();
$pangkat_kode->selectByParams();
$pejabat_penetap->selectByParams();

$jumlah_entri = 0;//$pegawai_pangkat->getCountByParams(array("PEGAWAI_ID" => $reqId));
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
		var tempTMT='';
		
		function setValue(){
			$('#ccJabatan').combobox('setValue', '<?=$tempJabatan?>');

			<?
			if($jumlah_entri > 0)
			{
			?>
			$("#ff :input").attr("disabled", true);
			$('#bluemenu').hide();
			<?
			}
			?>			
			
		}
		
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
		
		$.extend($.fn.validatebox.defaults.rules, {
			existTMT:{
				validator: function(value, param){
					if(value.length == '10')
					{
						var reg = /^(\d{1,2})(-|\/)(\d{1,2})\2(\d{1,4})$/;
						if(reg.test(value) == true)
						{
							if($(param[0]).val() == "")
							{
								$.getJSON("../json-simpeg/pegawai_add_pangkat_tmt_json.php?reqId=<?=$reqId?>&reqTMT="+value,
								function(data){
									tempTMT= data.PEGAWAI_PANGKAT_ID;
								});
							}
							else
							{
								$.getJSON("../json-simpeg/pegawai_add_pangkat_tmt_json.php?reqId=<?=$reqId?>&reqTMTTemp="+$(param[0]).val()+"&reqTMT="+value,
								function(data){
									tempTMT= data.PEGAWAI_PANGKAT_ID;
								});
							}
							 
							 if(tempTMT == '')
								return true;
							 else
								return false;
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}
				},
				message: 'TMT Tanggal, sudah ada atau Format Tanggal belum sesuai: {dd-mm-yyyy}'
			}
		});
		
		$(function(){
			$('#ff').form({
				url:'../json-simpeg/pegawai_add_pangkat.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					
					parent.frames['mainFramePop'].location.href = 'pegawai_add_pangkat_monitoring.php?reqId=' + data[0];
					document.location.href = 'pegawai_add_pangkat.php?reqId=' + data[0] + '&reqRowId=' + data[2];
				}				
			});
			
			$("#reqKelas").keypress(function(e) {
				if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
				{
				return false;
				}
			});
			
			$("#reqKelas").keypress(function(e) {
				if( $("#reqKelas").val() != '' ){
					var code = e.which;
					if(code==13){
						$('#ccJabatan').combobox({
							url:'../json-simpeg/jabatan_p3_combo_json.php?reqKelas='+$("#reqKelas").val(),
							valueField:'id',
							textField:'text',
							panelHeight:'88'
						});
					}
				}
			});
			$('#reqTahun').change(function() {
				$(function(){
					$.getJSON('../json-gaji/get_gaji_pokok.php?reqPangkat=' + $("#reqPangkat").val() + '&reqMasaKerja='+$("#reqTahun").val(),
					function(data){
							$("#reqGaji").val(FormatCurrency(data.JUMLAH));
					});
				});			  
			});
		});
		
	</script>
    <style>
	    .CodeMirror-scroll {
		height: 100%;
        /*width: 100%;
        overflow-y: auto;
		overflow-y: hidden;*/
        overflow-x: auto;
		}
	</style>
</head>
<body onLoad="setValue();">
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
            <a href="pegawai_add_pangkat.php?reqId=<?=$reqId?>">Batal</a>
            </li>        
        <?
		}
		?>
        </ul>
    </div>
    <form id="ff" method="post" novalidate style="margin-top:20px;">
    <table>
        <tr>
            <td>Terhitung Mulai Tanggal (TMT)</td>
            <td>
            	<input type="hidden" name="reqTMTTemp" id="reqTMTTemp" value="<?=$tempTMT?>">
                <input id="dd" name="reqTMT" class="easyui-datebox" validType="existTMT['#reqTMTTemp']" required value="<?=$tempTMT?>"></input>
            </td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>
                <input id="reqKelas" size="5" class="easyui-validatebox" required value="<?=$tempKelas?>"></input>
                <span style="font-size:12px;"><strong><em>&nbsp;*Isi Kelas, tekan enter untuk pengisian Jabatan.</em></strong></span>
            </td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>
            	<input id="ccJabatan" class="easyui-combobox"  required="true" name="reqJabatan" 
                data-options="
                    url:'../json-simpeg/jabatan_p3_combo_json.php',
                    valueField:'id',
                    textField:'text',
                    panelHeight:'120'
                	" 
                style="width:300px;">
            	<?php /*?><select id="reqJabatan" name="reqJabatan">
                <? while($jabatan->nextRow()){?>
                	<option value="<?=$jabatan->getField('JABATAN_ID')?>" <? if($tempJabatan == $jabatan->getField('JABATAN_ID')) echo 'selected';?>><?=$jabatan->getField('NAMA')?></option>
                <? }?>
                </select><?php */?>
            </td>
        </tr>
        <tr>
            <td>Jenis Pangkat</td>
            <td>
            	<select id="reqPangkat" name="reqPangkat">
                	<? while($pangkat->nextRow()){?>
                	<option value="<?=$pangkat->getField('PANGKAT_ID')?>" <? if($pangkat->getField('PANGKAT_ID') == $tempPangkat) echo 'selected';?>><?=$pangkat->getField('NAMA')?></option>
                    <? }?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Kode Pangkat</td>
            <td>
            	<select id="reqPangkatKode" name="reqPangkatKode">
                	<? while($pangkat_kode->nextRow()){?>
                	<option value="<?=$pangkat_kode->getField('PANGKAT_KODE_ID')?>" <? if($pangkat_kode->getField('PANGKAT_KODE_ID') == $tempPangkatKode) echo 'selected';?>><?=$pangkat_kode->getField('NAMA')?></option>
                    <? }?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Kode Perubahan Pangkat</td>
            <td>
            	<select id="reqPangkatPerubahanKode" name="reqPangkatPerubahanKode">
                	<? while($pangkat_perubahan_kode->nextRow()){?>
                	<option value="<?=$pangkat_perubahan_kode->getField('PANGKAT_PERUBAHAN_KODE_ID')?>" <? if($pangkat_perubahan_kode->getField('PANGKAT_PERUBAHAN_KODE_ID') == $tempPangkatPerubahanKode) echo 'selected';?>><?=$pangkat_perubahan_kode->getField('NAMA')?></option>
                    <? }?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Nomor SK</td>
            <td>
                <input name="reqNoSK" id="reqNoSK" class="easyui-validatebox" size="25" type="text" value="<?=$tempNoSK?>" />
                &nbsp;&nbsp;&nbsp;Tanggal SK
                <input id="dd" name="reqTanggal" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggal?>"></input>
            </td>
        </tr>
        <tr>
            <td>Tahun Masa Kerja</td>
            <td>
                <input name="reqTahun" id="reqTahun" class="easyui-validatebox" size="4" maxlength="4" type="text" value="<?=$tempTahun?>" />
                &nbsp;&nbsp;&nbsp;Bulan Masa Kerja
                <input name="reqBulan" id="reqBulan" class="easyui-validatebox" size="4" maxlength="2" type="text" value="<?=$tempBulan?>" />
            </td>
        </tr>
        <tr>
            <td>Gaji Pokok</td>
            <td>
            	<input name="reqGaji" type="text" id="reqGaji" class="easyui-validatebox" size="20" value="<?=numberToIna($tempGaji)?>"  OnFocus="FormatAngka('reqGaji')" OnKeyUp="FormatUang('reqGaji')" OnBlur="FormatUang('reqGaji')"/>
            </td>
        </tr>
        <tr>
            <td>Pejabat Penetap</td>
            <td>
            	<select id="reqPejabat" name="reqPejabat">
                <? while($pejabat_penetap->nextRow()){?>
                	<option value="<?=$pejabat_penetap->getField('PEJABAT_PENETAP_ID')?>" <? if($tempPejabat == $pejabat_penetap->getField('PEJABAT_PENETAP_ID')) echo 'selected';?>><?=$pejabat_penetap->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Uraian</td>
            <td>
            	<textarea id="reqUraian" name="reqUraian" cols="60" class="easyui-validatebox" ><?=$tempUraian?></textarea>
                <?php /*?><input name="reqUraian" id="reqUraian" class="easyui-validatebox" required size="60" type="text" value="<?=$tempUraian?>" /><?php */?>
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