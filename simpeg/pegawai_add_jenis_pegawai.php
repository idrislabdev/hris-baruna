<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
include_once("../WEB-INF/classes/base/SettingAplikasi.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawaiPerubahanKode.php");
include_once("../WEB-INF/classes/base-simpeg/Pangkat.php");
include_once("../WEB-INF/classes/base-simpeg/PangkatKode.php");
include_once("../WEB-INF/classes/base-simpeg/PejabatPenetap.php");
include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");

$pegawai_jenis_pegawai = new PegawaiJenisPegawai();
$jenis_pegawai = new JenisPegawai();
$asal_perusahaan = new JenisPegawai();
$jenis_pegawai_perubahan_kode = new JenisPegawaiPerubahanKode();
$setting_aplikasi = new SettingAplikasi();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");

$pegawai_jenis_pegawai->selectByParams(array('PEGAWAI_JENIS_PEGAWAI_ID'=>$reqRowId));
$pegawai_jenis_pegawai->firstRow();
//echo $pegawai_jenis_pegawai->query;

$tempTMT = dateToPageCheck($pegawai_jenis_pegawai->getField('TMT_JENIS_PEGAWAI'));
$tempJenisPegawai = $pegawai_jenis_pegawai->getField('JENIS_PEGAWAI_ID');
$tempKeterangan = $pegawai_jenis_pegawai->getField('KETERANGAN');
$tempJenisPegawaiPerubahanKode = $pegawai_jenis_pegawai->getField('JENIS_PEGAWAI_PERUBAH_KODE_ID');
$tempMPP= $pegawai_jenis_pegawai->getField('MPP');
$tempAsalPerusahaan= $pegawai_jenis_pegawai->getField('ASAL_PERUSAHAAN');

$tempTMTMPP= dateToPageCheck($pegawai_jenis_pegawai->getField('TMT_MPP'));
$tempNoSKMPP= $pegawai_jenis_pegawai->getField('NO_SK_MPP');
$tempRowId = $pegawai_jenis_pegawai->getField('PEGAWAI_JENIS_PEGAWAI_ID');
$tempKontrakAwal = dateToPageCheck($pegawai_jenis_pegawai->getField("TANGGAL_KONTRAK_AWAL"));
$tempKontrakAkhir = dateToPageCheck($pegawai_jenis_pegawai->getField("TANGGAL_KONTRAK_AKHIR"));
$tempDokumenId = $pegawai_jenis_pegawai->getField("DOKUMEN_ID");
$tempStatusCalpeg = $pegawai_jenis_pegawai->getField("STATUS_CALPEG");

$jenis_pegawai->selectByParams();
$asal_perusahaan->selectAsalPerusahaan();
$jenis_pegawai_perubahan_kode->selectByParams();

if($tempJenisPegawai == 3)
	$kategori_id = $setting_aplikasi->getNilai("HUKUM_KONTRAK_PKWT");
elseif($tempJenisPegawai == 4)
	$kategori_id = $setting_aplikasi->getNilai("HUKUM_KONTRAK_KSO");



//check apakah sudah pernah entri, kalau sudah harus melalui proses apabila belum enable
// $jumlah_entri = $pegawai_jenis_pegawai->getCountByParams(array("PEGAWAI_ID" => $reqId));
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
	
		var tempTMT='';
		
		function setValue(jns_pegawai){

			// <?
			// if($reqRowId == "")
			// {
			// 	if($jumlah_entri > 0)
			// 	{
			// 	?>
			// 	$("#ff :input").attr("disabled", true);
			// 	$('#bluemenu').hide();
			// 	<?
			// 	}
			// 	?>
			// <?
			// }
			// ?>

			$('#labelAsalPerusahaan').hide();
			$('#kontrakPKWT').hide();
			$('#dokumenHukum').hide();
			
			if(jns_pegawai == 2){
				/*$('#labelMPP').show();
				$('#labelTMTMPP').show();
				$('#labelNoSKMPP').show();*/
			}
			else if(jns_pegawai == 4)	
			{
				$('#labelAsalPerusahaan').show(); 
				$('#dokumenHukum').show();
			}
			else if(jns_pegawai == 3)	
			{
				$('#kontrakPKWT').show();
				$('#dokumenHukum').show();
			}
		}
		
		$.fn.datebox.defaults.formatter = function(date) {
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			return (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
		};
		/*$.extend($.fn.validatebox.defaults.rules, {
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
		});*/
	
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
								$.getJSON("../json-simpeg/pegawai_add_jenis_pegawai_tmt_json.php?reqId=<?=$reqId?>&reqTMT="+value,
								function(data){
									tempTMT= data.PEGAWAI_JENIS_PEGAWAI_ID;
								});
							}
							else
							{
								$.getJSON("../json-simpeg/pegawai_add_jenis_pegawai_tmt_json.php?reqId=<?=$reqId?>&reqTMTTemp="+$(param[0]).val()+"&reqTMT="+value,
								function(data){
									tempTMT= data.PEGAWAI_JENIS_PEGAWAI_ID;
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
			},
			
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
		
		$(function(){
			$('#ff').form({
				url:'../json-simpeg/pegawai_add_jenis_pegawai.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					
					// reload menu apabila status perbantuan atau id 2
					window.parent.frames['menuFramePop'].hide_perubahan_pangkat('<?=$reqId?>');
					
					parent.frames['mainFramePop'].location.href = 'pegawai_add_jenis_pegawai_monitoring.php?reqId=' + data[0];
					document.location.href = 'pegawai_add_jenis_pegawai.php?reqId=' + data[0] + '&reqRowId=' + data[2];
				}				
			});
			
			$('#reqJenisPegawai').bind('change', function(ev) {		
				var jenis_pegawai = $('#reqJenisPegawai').val();
				
				/*$('#labelMPP').hide();
				$('#labelTMTMPP').hide();
				$('#labelNoSKMPP').hide();*/
				
				$('#labelAsalPerusahaan').hide();
				$('#kontrakPKWT').hide();
				
				if(jenis_pegawai == 2){
					/*$('#labelMPP').show();
					$('#labelTMTMPP').show();
					$('#labelNoSKMPP').show();*/
				}
				else if(jenis_pegawai == 4)	$('#labelAsalPerusahaan').show();
				else if(jenis_pegawai == 3)	$('#kontrakPKWT').show();
				//alert(jenis_pegawai);
				
			});	
			
	
		});
		
		function hide_perubahan_pangkat(){
			alert('pegawai jenis');
		}		

		function OptionSetDokumen(id)
		{
			$('#reqDokumenId').val(id);
			$('#lblDokumenId').text("Data terpilih.");
		}		
	</script>
    
    <style>
	    .CodeMirror-scroll { height: 100%; overflow-x: auto;}
	</style>
    
</head>
<body onLoad="setValue(<?=$tempJenisPegawai?>);">
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
            <a href="pegawai_add_jenis_pegawai.php?reqId=<?=$reqId?>">Batal</a>
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
                <input id="dd" name="reqTMT" class="easyui-datebox" required validType="existTMT['#reqTMTTemp']" value="<?=$tempTMT?>"></input>
                <?php /*?>data-options="validType:'date'"<?php */?>
            </td>
        </tr>
        <?php /*?><tr id="labelTMTMPP">
        	<td>TMT MPP</td>
            <td>
                <input id="dd" name="reqTMTMPP" class="easyui-datebox" value="<?=$tempTMTMPP?>"></input>
            </td>
        </tr>
        <tr id="labelNoSKMPP">
            <td>NO SK MPP</td>
            <td>
                <input name="reqNoSKMPP" id="reqNoSKMPP" class="easyui-validatebox" size="40" type="text" value="<?=$tempNoSKMPP?>" />
            </td>
        </tr><?php */?>
        <tr>
            <td>Kode Jenis Pegawai</td>
            <td>
            	<select id="reqJenisPegawai" name="reqJenisPegawai">
                	<? while($jenis_pegawai->nextRow()){?>
                	<option value="<?=$jenis_pegawai->getField('JENIS_PEGAWAI_ID')?>" <? if($jenis_pegawai->getField('JENIS_PEGAWAI_ID') == $tempJenisPegawai) echo 'selected';?>><?=$jenis_pegawai->getField('NAMA')?></option>
                    <? }?>
                </select>
                
                <?php /*?><label id="labelMPP">
                    &nbsp;&nbsp;&nbsp;<input type="checkbox" id="reqMPP" name="reqMPP" value="1" <? if($tempMPP == 1) echo "checked"; ?>>
                    MPP
                </label><?php */?>
                <label id="labelAsalPerusahaan">
                    &nbsp;&nbsp;Asal Perusahaan
                    &nbsp;
                    <!-- <input name="reqAsalPerusahaan1" id="reqAsalPerusahaan1" class="easyui-validatebox" size="40" type="text" value="<?=$tempAsalPerusahaan?>" /> -->
                    <select id="reqAsalPerusahaan" name="reqAsalPerusahaan">
                    	<?php  
                    	while($asal_perusahaan->nextRow()){ ?>
							<option value="<?php echo $asal_perusahaan->getField('NAMA')?>" <?php if($asal_perusahaan->getField('NAMA') == $tempAsalPerusahaan) echo 'selected'; ?> ><?php echo $asal_perusahaan->getField('NAMA')?></option>
                    	<?php } ?>
                    </select>
                </label>
            </td>
        </tr>
		<tr id="kontrakPKWT">
        	<td>Tanggal Kontrak</td>
            <td><input id="dd" name="reqKontrakAwal" class="easyui-datebox" value="<?=$tempKontrakAwal?>"></input> s/d <input id="dd" name="reqKontrakAkhir" class="easyui-datebox" value="<?=$tempKontrakAkhir?>"></input></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>
                <input name="reqKeterangan" id="reqKeterangan" class="easyui-validatebox" size="60" type="text" value="<?=$tempKeterangan?>" />
            </td>
        </tr>
        <tr>
            <td>Kode Perubahan</td>
            <td>
            	<select id="reqJenisPegawaiPerubahanKode" name="reqJenisPegawaiPerubahanKode">
                	<? while($jenis_pegawai_perubahan_kode->nextRow()){?>
                	<option value="<?=$jenis_pegawai_perubahan_kode->getField('JENIS_PEGAWAI_PERUBAH_KODE_ID')?>" <? if($jenis_pegawai_perubahan_kode->getField('JENIS_PEGAWAI_PERUBAH_KODE_ID') == $tempJenisPegawaiPerubahanKode) echo 'selected';?>><?=$jenis_pegawai_perubahan_kode->getField('NAMA')?></option>
                    <? }?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Status Calpeg</td>
            <td>
            	<input type="checkbox" id="reqStatusCalpeg" name="reqStatusCalpeg" value="Y" <? if($tempStatusCalpeg == 'Y') echo "checked"; ?>>
            </td>
        </tr>
		<tr id="dokumenHukum">
        	<td>Dokumen Hukum</td>
            <td>
            	<input type="hidden" name="reqDokumenId" id="reqDokumenId" value="<?=$tempDokumenId?>">
                <?
                if($tempDokumenId == "")
				{
				?>
                	<label id="lblDokumenId">Dokumen belum diupload.</label>
                <?
				}
                else
				{
				?>
                	<label id="lblDokumenId"><a href="../hukum/pdfviewer.php?reqMode=DOKUMEN&reqId=<?=$tempDokumenId?>" target="_blank">Lihat dokumen</a>&nbsp;</label>
                <?
				}
				?>
                <input type="button" name="reqBrowse" id="reqBrowse" value="browse" onClick="window.parent.OpenDHTML('../hukum/dokumen_pencarian.php?reqId=<?=$kategori_id?>', 'Office Management - Aplikasi Hukum', '900', '720')">
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