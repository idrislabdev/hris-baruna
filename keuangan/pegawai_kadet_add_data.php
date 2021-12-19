<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/Agama.php");
include_once("../WEB-INF/classes/base-simpeg/Bank.php");
include_once("../WEB-INF/classes/base-simpeg/StatusPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/StatusKeluarga.php");

$pegawai = new Pegawai();
$pegawai_jenis_pegawai = new PegawaiJenisPegawai();
$agama = new Agama();
$bank = new Bank();
$status_pegawai = new StatusPegawai();
$status_keluarga = new StatusKeluarga();

$reqId = httpFilterGet("reqId");

if($reqId == "")
{
	$reqMode = "insert";
	$tempNIS = date("Y").generateZero($pegawai->getUrut() + 1, 3);	
}
else
{
	$reqMode = "update";
	$pegawai->selectByParams(array("A.PEGAWAI_ID" => $reqId));
	$pegawai->firstRow();
	/*PEGAWAI_ID*/
	$tempNIS= $pegawai->getField("NIS");
	$tempNama = $pegawai->getField("NAMA");
	$tempJenisKelamin = $pegawai->getField("JENIS_KELAMIN");
	$tempAgamaId= $pegawai->getField("AGAMA_ID");
	$tempDepartemen = $pegawai->getField("DEPARTEMEN_ID");
	$tempNRP = $pegawai->getField("NRP");
	$tempTempat = $pegawai->getField("TEMPAT_LAHIR");
	$tempTanggal = dateToPageCheck($pegawai->getField("TANGGAL_LAHIR"));
	$tempAlamat = $pegawai->getField("ALAMAT");
	$tempEmail = $pegawai->getField("EMAIL");
	$tempTelepon = $pegawai->getField("TELEPON");
	$tempBankId = $pegawai->getField("BANK_ID");
	$tempMagangTipe = $pegawai->getField("MAGANG_TIPE");
	
	if($tempDepartemen == "")
		$tempDepartemen = "NULL";
	
		
	$pegawai_jenis_pegawai->selectByParamsKadet(array("PEGAWAI_ID"=>$reqId),-1,-1);
	$pegawai_jenis_pegawai->firstRow();
	$tempTanggalAwal= dateToPageCheck($pegawai_jenis_pegawai->getField("TANGGAL_KONTRAK_AWAL"));
	$tempTanggalAkhir= dateToPageCheck($pegawai_jenis_pegawai->getField("TANGGAL_KONTRAK_AKHIR"));
	$tempAsalSekolah= $pegawai_jenis_pegawai->getField("ASAL_SEKOLAH");
	$tempKelasSekolah= $pegawai_jenis_pegawai->getField("KELAS_SEKOLAH");
	$tempJurusanSekolah= $pegawai_jenis_pegawai->getField("JURUSAN");
	$reqRowId= $pegawai_jenis_pegawai->getField("PEGAWAI_JENIS_PEGAWAI_ID");
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
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
    
    <script language="Javascript">
	<? include_once "../jslib/formHandler.php"; ?>
	</script>
    
	<script type="text/javascript">
		var tempNRP='';
		
		function setValue(sts_pegawai){
			$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
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
				url:'../json-simpeg/pegawai_kadet_add_data.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
					top.frames['mainFrame'].location.reload();
					parent.frames['menuFramePop'].location.href = 'pegawai_kadet_add_menu.php?reqId=' + data[0];
					document.location.href = 'pegawai_kadet_add_data.php?reqId=' + data[0];
				}
			});
			
			$.extend($.fn.validatebox.defaults.rules, {  
				BandingTanggalAwal: {
					validator: function(value, param){
						var start = value;
						var end = $(param[0]).datebox('getValue');//$(param[0]).val();
						 
						var awal = start;	
						var selesai = end;
						
						awal=String(awal);			selesai=String(selesai);
						arrawal=awal.split('-');	arrselesai=selesai.split('-');
						var dt1   = arrawal[0]; 	var mon1  = arrawal[1];			var yr1   = arrawal[2]; 
						
						var dt2   = arrselesai[0]; 	var mon2  = arrselesai[1]; 		var yr2   = arrselesai[2];
						
						var dtStart = new Date(yr1, mon1, dt1); var dtEnd = new Date(yr2, mon2, dt2);
						//alert('----'+dtStart+'--'+dtEnd);
						if(dtEnd > dtStart) 	return true;
						else 					return false;
						
					},
					message: 'Tanggal Akhir lebih besar / sama dengan tanggal awal '
				},
				
				BandingTanggalAkhir: {
					validator: function(value, param){
						var start = value;
						var end = $(param[0]).datebox('getValue');//$(param[0]).val();
						 
						var awal = start;	
						var selesai = end;
						
						awal=String(awal);			selesai=String(selesai);
						arrawal=awal.split('-');	arrselesai=selesai.split('-');
						var dt1   = arrawal[0]; 	var mon1  = arrawal[1];			var yr1   = arrawal[2]; 
						
						var dt2   = arrselesai[0]; 	var mon2  = arrselesai[1]; 		var yr2   = arrselesai[2];
						
						var dtStart = new Date(yr1, mon1, dt1); var dtEnd = new Date(yr2, mon2, dt2);
						//alert('----'+dtStart+'--'+dtEnd);
						if(dtEnd < dtStart) 	return true;
						else 					return false;
						
					},
					message: 'Tanggal Akhir lebih besar / sama dengan tanggal awal '
				}  
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
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script>    
</head>

<body onLoad="setValue(<?=$tempStatusPegawai?>);">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Siswa Magang</span>
    </div>
    <form id="ff" method="post" novalidate enctype="multipart/form-data">
    <table>
        <tr>
            <td>NIS</td>
            <td colspan="3">
                <input name="reqNIS" id="reqNIS" class="easyui-validatebox" <?php /*?>data-options="validType:'minLength[9]'" validType="existNRP['#reqNRPTemp']" maxlength="9"<?php */?> required size="20" type="text" value="<?=$tempNIS?>" />
            </td>
        </tr>
        <tr>
            <td>Nama</td>
            <td colspan="3">
            	<input name="reqNama" class="easyui-validatebox" required size="90" type="text" value="<?=$tempNama?>" />
            </td>
        </tr>
        <tr>
            <td>Asal Sekolah</td>
            <td colspan="3">
            	<input name="reqAsalSekolah" class="easyui-validatebox" required size="90" type="text" value="<?=$tempAsalSekolah?>" />
            </td>
        </tr>
        <tr>
            <td>Kelas Sekolah</td>
            <td colspan="3">
            	<input name="reqKelasSekolah" class="easyui-validatebox" size="5" type="text" value="<?=$tempKelasSekolah?>" />
                &nbsp;&nbsp;&nbsp;Jurusan
                <input name="reqJurusanSekolah" class="easyui-validatebox" size="25" type="text" value="<?=$tempJurusanSekolah?>" />
            </td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td colspan="3"><input id="cc" class="easyui-combotree"  required="true" name="reqDepartemen" data-options="url:'../json-intranet/departemen_combo_json.php'" style="width:300px;"></td>
        </tr>
        <tr>
            <td>Jenis Magang</td>
            <td colspan="3">
            	<select name="reqJenisMagang">
                	<option value="PRAKERIN" <? if($tempMagangTipe == "PRAKERIN") { ?> selected <? } ?>>Prakerin</option>
                	<option value="KADET" <? if($tempMagangTipe == "KADET") { ?> selected <? } ?>>Kadet</option>
                </select>
            </td>
        </tr>        
        <tr>
            <td>Tanggal Kontrak Awal</td>
            <td colspan="3">
                <input id="reqTanggalAwal" name="reqTanggalAwal" class="easyui-datebox" validType="BandingTanggalAwal['#reqTanggalAkhir']" required value="<?=$tempTanggalAwal?>" />
                &nbsp;&nbsp;&nbsp;Tanggal Kontrak Akhir
                <input id="reqTanggalAkhir" name="reqTanggalAkhir" class="easyui-datebox" validType="BandingTanggalAkhir['#reqTanggalAwal']" required value="<?=$tempTanggalAkhir?>" />
            </td>
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
        <?php /*?><tr>    
            <td>Status Pegawai</td>
            <td colspan="3">
            	<select id="reqStatusPegawai" name="reqStatusPegawai">
                <? while($status_pegawai->nextRow()){?>
                    <option value="<?=$status_pegawai->getField('STATUS_PEGAWAI_ID')?>" <? if($tempStatusPegawai == $status_pegawai->getField('STATUS_PEGAWAI_ID')) echo 'selected';?>><?=$status_pegawai->getField('NAMA')?></option>
                <? }?>
                </select>
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
        <tr>
            <td>Foto</td>
            <td>
                 <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
        		 <input type="file" name="reqLinkFile" id="reqLinkFile" />  
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