<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base-simpeg/Agama.php");
include_once("../WEB-INF/classes/base-simpeg/Bank.php");
include_once("../WEB-INF/classes/base-simpeg/StatusPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/StatusKeluarga.php");

$pegawai = new Pegawai();
$agama = new Agama();
$bank = new Bank();
$status_pegawai = new StatusPegawai();
$status_keluarga = new StatusKeluarga();

$reqId = httpFilterGet("reqId");

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";
	$pegawai->selectByParams(array("A.PEGAWAI_ID" => $reqId));
	$pegawai->firstRow();
	/*PEGAWAI_ID*/
	$tempNPP = $pegawai->getField('NIPP');
	$tempNama = $pegawai->getField('NAMA');
	$tempJenisKelamin = $pegawai->getField('JENIS_KELAMIN');
	$tempAgamaId= $pegawai->getField('AGAMA_ID');
	//$tempAsalPelabuhanId = $pegawai->getField('PELABUHAN_ID');
	//$tempAsalPelabuhanKode = $pegawai->getField('KODE');
	//$tempAsalPelabuhan = $pegawai->getField('NAMA_PELABUHAN');
	$tempDepartemen = $pegawai->getField('DEPARTEMEN_ID');
	$tempNRP = $pegawai->getField('NRP');
	$tempTempat = $pegawai->getField('TEMPAT_LAHIR');
	$tempTanggal = dateToPageCheck($pegawai->getField('TANGGAL_LAHIR'));
	$tempAlamat = $pegawai->getField('ALAMAT');
	$tempGolDarah = $pegawai->getField('GOLONGAN_DARAH');
	$tempStatusPernikahan = $pegawai->getField('STATUS_KAWIN_ID');
	$tempEmail = $pegawai->getField('EMAIL');
	$tempTelepon = $pegawai->getField('TELEPON');
	$tempStatusPegawai = $pegawai->getField('STATUS_PEGAWAI_ID');
	$tempStatusKeluarga = $pegawai->getField('STATUS_KELUARGA_ID');
	$tempBankId = $pegawai->getField('BANK_ID');
	$tempRekeningNo = $pegawai->getField('REKENING_NO');
	$tempRekeningNama = $pegawai->getField('REKENING_NAMA');
	$tempNPWP = $pegawai->getField('NPWP');
	$tempTglPensiun= dateToPageCheck($pegawai->getField('TANGGAL_PENSIUN'));
	$tempTglMutasiKeluar= dateToPageCheck($pegawai->getField('TANGGAL_MUTASI_KELUAR'));
	$tempTglWafat= dateToPageCheck($pegawai->getField('TANGGAL_WAFAT'));
	$tempJamsostek = $pegawai->getField('JAMSOSTEK_NO');
	$tempJamsostekTanggal = dateToPageCheck($pegawai->getField('JAMSOSTEK_TANGGAL'));
	$tempHobby = $pegawai->getField("HOBBY");
	$tempFingerId = $pegawai->getField("FINGER_ID");
	$tempTanggalNpwp = dateToPageCheck($pegawai->getField('TANGGAL_NPWP'));

	$tempTMTMPP= dateToPageCheck($pegawai->getField('TANGGAL_MPP'));
	$tempNoSKMPP= $pegawai->getField('NO_MPP');
	
	if($tempDepartemen == "")
		$tempDepartemen = "NULL";
}

$agama->selectByParams();
$bank->selectByParams();
$status_pegawai->selectByParams();
$status_keluarga->selectByParams();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/js/globalfunction.js"></script>
    
    <script language="Javascript">
	<? include_once "../jslib/formHandler.php"; ?>
	</script>
    
	<script type="text/javascript">
		var tempNRP='';
		
		function setValue(sts_pegawai){
			//alert(sts_pegawai);
			$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
			
			$('#labelTglPensiun').hide();
			$('#labelTglMutasiKeluar').hide();
			$('#labelTglWafat').hide();
			
			$('#labelTMTMPP').hide();
			$('#labelNoSKMPP').hide();
			
			if(sts_pegawai == 2)
			{
				$('#labelTglPensiun').show();
			}
			else if(sts_pegawai == 3)
			{
				$('#labelTglMutasiKeluar').show();
			}
			else if(sts_pegawai == 4)
			{
				$('#labelTglWafat').show();
			}
			else if(sts_pegawai == 5)
			{
				$('#labelTMTMPP').show();
				$('#labelNoSKMPP').show();
			}
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
			existNRP:{
				validator: function(value, param){
					if($(param[0]).val() == "")
					{
						$.getJSON("../json-simpeg/pegawai_add_nrp_json.php?reqNRP="+value,
						function(data){
							tempNRP= data.NRP;
						});
					}
					else
					{
						$.getJSON("../json-simpeg/pegawai_add_nrp_json.php?reqNRPTemp="+$(param[0]).val()+"&reqNRP="+value,
						function(data){
							tempNRP= data.NRP;
						});
					}
					 
					 if(tempNRP == '')
					 	return true;
					 else
					 	return false;
				},
				message: 'NRP Pegawai, sudah ada.'
			}  
		});
		
		$(function(){
			$('#ff').form({
				url:'../json-simpeg/pegawai_add_data.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
					top.frames['mainFrame'].location.reload();
					parent.frames['menuFramePop'].location.href = 'pegawai_add_menu.php?reqId=' + data[0];
					document.location.href = 'pegawai_add_data.php?reqId=' + data[0];				
				}
			});
			
			$('#reqStatusPegawai').bind('change', function(ev) {		
				var status_pegawai = $('#reqStatusPegawai').val();
				
				$('#labelTglPensiun').hide();
				$('#labelTglMutasiKeluar').hide();
				$('#labelTglWafat').hide();
				
				$('#labelTMTMPP').hide();
				$('#labelNoSKMPP').hide();
				
				if(status_pegawai == 2)
				{
					$('#labelTglPensiun').show();
				}
				else if(status_pegawai == 3)
				{
					$('#labelTglMutasiKeluar').show();
				}
				else if(status_pegawai == 4)
				{
					$('#labelTglWafat').show();
				}
				else if(status_pegawai == 5)
				{
					$('#labelTMTMPP').show();
					$('#labelNoSKMPP').show();
				}
				//alert(status_pegawai);
				
			});				
			
			$.extend($.fn.validatebox.defaults.rules, {  
				minLength: {  
					//alert('asdsad');
					validator: function(value, param){  
						return value.length >= param[0];  
					},
					message: 'Total Kata Minimal {0} huruf.'
				}  
			});
			
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script>    
</head>

<body onLoad="setValue(<?=$tempStatusPegawai?>);">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Data Pegawai</span>
    </div>
    <form id="ff" method="post" novalidate enctype="multipart/form-data">
    <table>
        <tr>
            <td>NRP / NIPP</td>
            <td colspan="3">
            	<input type="hidden" name="reqNRPTemp" id="reqNRPTemp" value="<?=$tempNRP?>" >
                <input name="reqNRP" id="reqNRP" class="easyui-validatebox" data-options="validType:'minLength[9]'" validType="existNRP['#reqNRPTemp']" maxlength="9" required size="20" type="text" value="<?=$tempNRP?>" />
                <input name="reqNPP" id="reqNPP" class="easyui-validatebox" data-options="validType:'minLength[11]'" maxlength="11" onkeydown="return format_nipp(event,'reqNPP');" size="20" type="text" value="<?=$tempNPP?>" />
            </td>
        </tr>
        <tr>
            <td>Nama</td>
            <td colspan="3">
            	<input name="reqNama" class="easyui-validatebox" required size="90" type="text" value="<?=$tempNama?>" />
                <?php /*?>&nbsp;&nbsp;&nbsp;
                Jenis Kelamin
                <select id="reqJenisKelamin" name="reqJenisKelamin">
                    <option value="L" <? if($tempJenisKelamin == 'L') echo 'selected';?>>L</option>
                    <option value="P" <? if($tempJenisKelamin == 'P') echo 'selected';?>>P</option>
                </select><?php */?>
            </td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td colspan="3"><input id="cc" class="easyui-combotree"  required="true" name="reqDepartemen" data-options="url:'../json-intranet/departemen_combo_json.php'" style="width:300px;"></td>
        </tr>
        <tr>
        	<td>Agama</td>
            <td colspan="3">
            	<select id="reqAgamaId" name="reqAgamaId">
                <? while($agama->nextRow()){?>
                    <option value="<?=$agama->getField('AGAMA_ID')?>" <? if($tempAgamaId == $agama->getField('AGAMA_ID')) echo 'selected';?>><?=$agama->getField('NAMA')?></option>
                <? }?>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;
            	Jenis Kelamin
            	<select id="reqJenisKelamin" name="reqJenisKelamin">
                    <option value="L" <? if($tempJenisKelamin == 'L') echo 'selected';?>>L</option>
                    <option value="P" <? if($tempJenisKelamin == 'P') echo 'selected';?>>P</option>
                </select>
            </td>
        </tr>
        <tr>    
            <td>Status Pegawai</td>
            <td colspan="3">
            	<select id="reqStatusPegawai" name="reqStatusPegawai">
                <? while($status_pegawai->nextRow()){?>
                    <option value="<?=$status_pegawai->getField('STATUS_PEGAWAI_ID')?>" <? if($tempStatusPegawai == $status_pegawai->getField('STATUS_PEGAWAI_ID')) echo 'selected';?>><?=$status_pegawai->getField('NAMA')?></option>
                <? }?>
                </select>       
                
                <label id="labelTglPensiun">
                    &nbsp;&nbsp;&nbsp;Tgl Pensiun
                    &nbsp;&nbsp;&nbsp;
                    <input id="reqTglPensiun" name="reqTglPensiun" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTglPensiun?>"></input>
                </label>                
                <label id="labelTglMutasiKeluar">
                    &nbsp;&nbsp;&nbsp;Tgl Mutasi Keluar
                    &nbsp;&nbsp;&nbsp;
                    <input id="reqTglMutasiKeluar" name="reqTglMutasiKeluar" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTglMutasiKeluar?>"></input>
                </label>                
                <label id="labelTglWafat">
                    &nbsp;&nbsp;&nbsp;Tgl Wafat
                    &nbsp;&nbsp;&nbsp;
                    <input id="reqTglWafat" name="reqTglWafat" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTglWafat?>"></input>
                </label>
                <label id="labelTMTMPP">
                    &nbsp;&nbsp;&nbsp;Tgl MPP
                    &nbsp;&nbsp;&nbsp;
                    <input id="reqTMTMPP" name="reqTMTMPP" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTMTMPP?>"></input>
                </label>
            </td>
        </tr>        
        <tr id="labelNoSKMPP">
            <td>NO SK MPP</td>
            <td colspan="3">
                <input name="reqNoSKMPP" id="reqNoSKMPP" class="easyui-validatebox" size="40" type="text" value="<?=$tempNoSKMPP?>" />
            </td>
        </tr>
        <?php /*?><tr>
            <td>Asal Pelabuhan</td>
            <td>
                <input name="reqAsalPelabuhanKode" id="reqAsalPelabuhanKode" class="easyui-validatebox" required="required" size="20" type="text" value="<?=$tempAsalPelabuhanKode?>" />
                <input name="reqAsalPelabuhanId" id="reqAsalPelabuhanId" type="hidden" value="<?=$tempAsalPelabuhanId?>" />
                <input name="reqAsalPelabuhan" id="reqAsalPelabuhan" class="easyui-validatebox" required="required" size="60" type="text" value="<?=$tempAsalPelabuhan?>" />
                <a href="#" onClick="OpenDHTML('pelabuhan_lookup.php', 'Pilih Program', 450,350);" ><img src="images/icn_search.gif" width="15" height="15"/></a>
            </td>
        </tr><?php */?>
        <tr>
            <td>TTL</td>
            <td colspan="3">
                <input name="reqTempat" class="easyui-validatebox" required size="20" type="text" value="<?=$tempTempat?>" /> / 
                <input id="dd" name="reqTanggal" class="easyui-datebox" data-options="validType:'date'" required value="<?=$tempTanggal?>"></input>
            </td>
        </tr>
        <tr>
        	<td>Alamat</td>
			<td colspan="3">
            	<input name="reqAlamat" class="easyui-validatebox" size="100" type="text" value="<?=$tempAlamat?>" />
			</td>
        </tr>
        <tr>
			<td>Telepon</td>
			<td colspan="3"><input type="text" class="easyui-validatebox" size="20" name="reqTelepon" id="reqTelepon" value="<?=$tempTelepon?>" />
				&nbsp;&nbsp;&nbsp;Email
                <input type="text"  class="easyui-validatebox" data-options="validType:'email'" name="reqEmail" size="30" value="<?=$tempEmail?>" />
			</td>
        </tr>
        <tr style="height:20px">
            <td>Golongan Darah</td>
            <td style="width:125px">
            	<select name="reqGolDarah">
					<option value="A" <? if($tempGolDarah == "A") echo 'selected'?>>A</option>
					<option value="B" <? if($tempGolDarah == "B") echo 'selected'?>>B</option>
					<option value="AB" <? if($tempGolDarah == "AB") echo 'selected'?>>AB</option>
					<option value="O" <? if($tempGolDarah == "O") echo 'selected'?>>O</option>
				</select>
            </td>
            <td>
            <?php /*?><img src="image_script.php?reqPegawaiId=<?=$reqId?>&reqMode=pegawai" width="150" height="130"><?php */?>
            Bank
            </td>
            <td>
            	<select id="reqBankId" name="reqBankId">
                <? while($bank->nextRow()){?>
                    <option value="<?=$bank->getField('BANK_ID')?>" <? if($tempBankId == $bank->getField('BANK_ID')) echo 'selected';?>><?=$bank->getField('NAMA')?></option>
                <? }?>
                </select>            
            </td>
        </tr>
        <tr style="height:20px">
            <td>Status Nikah</td>
            <td width="220px">
            	<select name="reqStatusPernikahan">
					<option value="1" <? if($tempStatusPernikahan == "1") echo 'selected'?>>Belum Kawin</option>
					<option value="2" <? if($tempStatusPernikahan == "2") echo 'selected'?>>Kawin</option>
					<option value="3" <? if($tempStatusPernikahan == "3") echo 'selected'?>>Janda</option>
					<option value="4" <? if($tempStatusPernikahan == "4") echo 'selected'?>>Duda</option>
				</select>&nbsp;
            	<select id="reqStatusKeluarga" name="reqStatusKeluarga">
                <? while($status_keluarga->nextRow()){?>
                    <option value="<?=$status_keluarga->getField('STATUS_KELUARGA_ID')?>" <? if($tempStatusKeluarga == $status_keluarga->getField('STATUS_KELUARGA_ID')) echo 'selected';?>><?=$status_keluarga->getField('KODE')?></option>
                <? }?>
                </select>            
            </td>
            <td>No. Rekening</td>
            <td>
				<input name="reqRekeningNo" class="easyui-validatebox" size="40" type="text" value="<?=$tempRekeningNo?>" />            
            </td>
        </tr>
        <tr style="height:20px">
            <td>NPWP</td>
            <td>
                 <input name="reqNPWP" id="reqNPWP" class="easyui-validatebox" data-options="validType:'minLength[20]'" maxlength="20" size="20" type="text" value="<?=$tempNPWP?>" onkeydown="return format_npwp(event,'reqNPWP');"/>
            </td>
            <td>Nama Rekening</td>
            <td>
				<input name="reqRekeningNama" class="easyui-validatebox" size="40" type="text" value="<?=$tempRekeningNama?>" />            
            </td>            
        </tr>
        
        <tr>
            <td>Tgl Daftar NPWP</td>
            <td>
                 <input id="dd" name="reqTanggalNpwp" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalNpwp?>"></input>
            </td>
            <td>Jamsostek (No / Tgl)</td>
            <td>
				<input name="reqJamsostek" class="easyui-validatebox" size="17" type="text" value="<?=$tempJamsostek?>" /> /
                <input id="reqJamsostekTanggal" name="reqJamsostekTanggal" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempJamsostekTanggal?>"></input>  
            </td>              
        </tr>  
        <tr>
            <td>Foto</td>
            <td colspan="3">
                 <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
        		 <input type="file" name="reqLinkFile" id="reqLinkFile" />  
            </td>
        </tr>  
        <tr>
            <td>Hobby</td>
            <td colspan="3">
    			<input name="reqHobby" class="easyui-validatebox" size="100" type="text" value="<?=$tempHobby?>" />
            </td>              
        </tr>               
        <?php /*?><tr> 
        <td></td>
		<td style="border:none" rowspan="21" valign="top">
        <td><img src="image_script.php?reqPegawaiId=<?=$reqId?>&reqMode=pegawai" width="150" height="50"></td>
        </tr><?php */?>
        <tr>
            <td>Finger ID</td>
            <td colspan="3">
				<input name="reqFingerId" class="easyui-validatebox" size="5" type="text" value="<?=$tempFingerId?>" />  
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
<script>
$("#reqTelepon,#reqBulan,#reqNRP").keypress(function(e) {
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