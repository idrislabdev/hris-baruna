<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPenghasilan.php");
include_once("../WEB-INF/classes/base-simpeg/PejabatPenetap.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");


$pegawai = new Pegawai();
$pegawai_jabatan = new PegawaiJabatan();
$pegawai_jenis = new PegawaiJenisPegawai();
$pegawai_penghasilan = new PegawaiPenghasilan();
$pejabat_penetap = new PejabatPenetap();
$jenis_pegawai = new JenisPegawai();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");
$reqJenisPegawaiId = 3;

$pegawai->selectByParams(array("A.PEGAWAI_ID" => $reqId));
$pegawai->firstRow();
/*PEGAWAI_ID*/
$tempNPP = $pegawai->getField('NIPP');
$tempNama = $pegawai->getField('NAMA');
$tempJenisKelamin = $pegawai->getField('JENIS_KELAMIN');
$tempAgamaId= $pegawai->getField('AGAMA_NAMA');
$tempDepartemen = $pegawai->getField('DEPARTEMEN_ID');
$tempNRP = $pegawai->getField('NRP');
$tempTempat = $pegawai->getField('TEMPAT_LAHIR');
$tempTanggal = dateToPageCheck($pegawai->getField('TANGGAL_LAHIR'));
$tempUnitKerja= $pegawai->getField('DEPARTEMEN');
$tempStatusPegawai= $pegawai->getField('STATUS_PEGAWAI_NAMA');
$tempTMTMPP= dateToPageCheck($pegawai->getField('TANGGAL_MPP'));
$tempNoSKMPP= $pegawai->getField('NO_MPP');
$tempJenisPegawaiNama = $pegawai->getField('JENIS_PEGAWAI_NAMA');
$tempJenisPegawaiId= $pegawai->getField('JENIS_PEGAWAI_ID');
$tempTanggalKontrakAwal = dateToPageCheck($pegawai->getField("TANGGAL_KONTRAK_AWAL"));
$tempTanggalKontrakAkhir = dateToPageCheck($pegawai->getField("TANGGAL_KONTRAK_AKHIR"));
$tempPegawaiJenisPegawaiId = $pegawai->getField("PEGAWAI_JENIS_PEGAWAI_ID");

if($reqJenisPegawaiId == "")
{}
else
	$tempJenisPegawaiId = $reqJenisPegawaiId;


$periode_disabel="";
if($tempJenisPegawaiId == "4")
	$periode_disabel="readonly";

$periode_disabel="";

$pegawai_jabatan->selectByParamsJabatanTerakhirJenisPegawai(array('A.PEGAWAI_ID'=>$reqId), $tempJenisPegawaiId);
$pegawai_jabatan->firstRow();
$json_item_gaji = json_decode($pegawai_jabatan->getField('JSON_GAJI_ITEM'));
if($reqRowId == "")
{
//echo $pegawai_jabatan->query;
$tempKelas= $pegawai_jabatan->getField('KELAS');
$tempTMTPenghasilan = dateToPageCheck($pegawai_jabatan->getField('TMT_JABATAN'));
$tempNoSK = $pegawai_jabatan->getField('NO_SK');
$tempTanggal = dateToPageCheck($pegawai_jabatan->getField('TANGGAL_SK'));
$tempPejabat = $pegawai_jabatan->getField('PEJABAT_PENETAP_ID');
$tempTahun = 0;
$tempBulan = 0;
$tempPeriode = 0;

$json_gaji = $pegawai_jabatan->getField('JSON_GAJI');
$gaji = json_decode($json_gaji);
$tempJumlahPenghasilan = $gaji->{'MERIT_PMS'}{2};
$tempProsentasePenghasilan = $gaji->{'MERIT_PMS'}{0};
$tempJumlahTunjanganJabatan = $gaji->{'TUNJANGAN_JABATAN'}{2};
$tempProsentaseTunjanganJabatan = $gaji->{'TUNJANGAN_JABATAN'}{0};
$tempJumlahUangMakan = $gaji->{'UANG_MAKAN'}{2}; 
$tempProsentaseUangMakan= $gaji->{'UANG_MAKAN'}{0}; 
$tempJumlahTransportasi =  $gaji->{'UANG_TRANSPORT'}{2}; 
$tempProsentaseTransportasi=  $gaji->{'UANG_TRANSPORT'}{0}; 
$tempJumlahUangKehadiran = $gaji->{'UANG_KEHADIRAN'}{2};
$tempProsentaseUangKehadiran = $gaji->{'UANG_KEHADIRAN'}{0};
$tempJumlahInsentif = $gaji->{'INSENTIF'}{2};
$tempProsentaseInsentif=  $gaji->{'INSENTIF'}{0};
$tempJumlahTPP = $gaji->{'TPP_PMS'}{2};
$tempProsentaseTPP = $gaji->{'TPP_PMS'}{0};
$tempJumlahTunjanganSelisih = $gaji->{'TUNJANGAN_PERBANTUAN'}{2};
$tempJumlahMobilitas = $gaji->{'MOBILITAS'}{2};
$tempProsentaseMobilitas = $gaji->{'MOBILITAS'}{0};
$tempJumlahPerumahan = $gaji->{'PERUMAHAN'}{2};
$tempProsentasePerumahan = $gaji->{'PERUMAHAN'}{0};
$tempJumlahBBM = $gaji->{'BBM'}{2};
$tempProsentaseBBM = $gaji->{'BBM'}{0};
$tempJumlahTelepon = $gaji->{'TELEPON'}{2};
$tempProsentaseTelepon = $gaji->{'TELEPON'}{0};
}
else
{
	$pegawai_penghasilan->selectByParams(array('PEGAWAI_PENGHASILAN_ID'=>$reqRowId));
	$pegawai_penghasilan->firstRow();
	//echo $pegawai_penghasilan->query;
	
	$tempTMTPenghasilan = dateToPageCheck($pegawai_penghasilan->getField('TMT_PENGHASILAN'));
	$tempPeriode = $pegawai_penghasilan->getField('PERIODE');
	$tempKelas = $pegawai_penghasilan->getField('KELAS');
	if($tempKelas=='')$tempKelas= $tempKelasView;
	
	$tempNoSK = $pegawai_penghasilan->getField('NO_SK');
	$tempTanggal = dateToPageCheck($pegawai_penghasilan->getField('TANGGAL_SK'));

	$tempPejabat = $pegawai_penghasilan->getField('PEJABAT_PENETAP_ID');
	$tempTahun = $pegawai_penghasilan->getField('MASA_KERJA_TAHUN');
	$tempBulan = $pegawai_penghasilan->getField('MASA_KERJA_BULAN');
	$tempJumlahPenghasilan = $pegawai_penghasilan->getField('JUMLAH_PENGHASILAN');
	$tempJumlahTPP = $pegawai_penghasilan->getField('JUMLAH_TPP');
	$tempJumlahTunjanganJabatan = $pegawai_penghasilan->getField('JUMLAH_TUNJANGAN_JABATAN');
	$tempJumlahTunjanganSelisih = $pegawai_penghasilan->getField('JUMLAH_TUNJANGAN_SELISIH');
	$tempJumlahTransportasi = $pegawai_penghasilan->getField('JUMLAH_TRANSPORTASI');
	$tempJumlahUangMakan = $pegawai_penghasilan->getField('JUMLAH_UANG_MAKAN');
	$tempJumlahInsentif = $pegawai_penghasilan->getField('JUMLAH_INSENTIF');
	$tempJumlahMobilitas = $pegawai_penghasilan->getField('JUMLAH_MOBILITAS');
	$tempProsentaseMobilitas = $pegawai_penghasilan->getField('PROSENTASE_MOBILITAS');
	$tempJumlahPerumahan = $pegawai_penghasilan->getField('JUMLAH_PERUMAHAN');
	$tempProsentasePerumahan = $pegawai_penghasilan->getField('PROSENTASE_PERUMAHAN');
	$tempJumlahBBM = $pegawai_penghasilan->getField('JUMLAH_BBM');
	$tempProsentaseBBM = $pegawai_penghasilan->getField('PROSENTASE_BBM');
	$tempJumlahTelepon = $pegawai_penghasilan->getField('JUMLAH_TELEPON');
	$tempProsentaseTelepon = $pegawai_penghasilan->getField('PROSENTASE_TELEPON');
	$tempProsentasePenghasilan = $pegawai_penghasilan->getField('PROSENTASE_PENGHASILAN');
	$tempProsentaseTunjanganJabatan = $pegawai_penghasilan->getField('PROSENTASE_TUNJANGAN_JABATAN');
	
	$tempProsentaseUangMakan= $pegawai_penghasilan->getField('PROSENTASE_UANG_MAKAN');
	$tempProsentaseTransportasi= $pegawai_penghasilan->getField('PROSENTASE_TRANSPORTASI');
	$tempProsentaseInsentif= $pegawai_penghasilan->getField('PROSENTASE_INSENTIF');
	
	$tempJumlahUangKehadiran = $pegawai_penghasilan->getField('JUMLAH_UANG_KEHADIRAN');
	$tempProsentaseUangKehadiran = $pegawai_penghasilan->getField('PROSENTASE_UANG_KEHADIRAN');
	
	$tempKelasP3= $pegawai_penghasilan->getField('KELAS_P3');
	$tempPeriodeP3= $pegawai_penghasilan->getField('PERIODE_P3');
	$tempJumlahP3= $pegawai_penghasilan->getField('JUMLAH_P3');
	
	$tempProsentaseTPP= $pegawai_penghasilan->getField('PROSENTASE_TPP');
	
	$tempRowId = $pegawai_penghasilan->getField('PEGAWAI_PENGHASILAN_ID');
	
}

if($tempProsentaseTunjanganJabatan == '')	$tempProsentaseTunjanganJabatan='100';
if($tempProsentasePenghasilan == '')		$tempProsentasePenghasilan='100';
if($tempProsentaseUangMakan == '')			$tempProsentaseUangMakan='100';
if($tempProsentaseTransportasi == '')		$tempProsentaseTransportasi='100';	
if($tempProsentaseInsentif == '')			$tempProsentaseInsentif='100';	
if($tempProsentaseTPP == '')				$tempProsentaseTPP='100';	

$pejabat_penetap->selectByParams();

function getEnableDisableInput($json_item_gaji, $variable)
{
	for($i=0;$i<count($json_item_gaji->{'ITEM_GAJI'});$i++)
	{
		if($json_item_gaji->{'VAR_JUMLAH'}{$i} == $variable)
			return "";
		if($json_item_gaji->{'VAR_PROSENTASE'}{$i} == $variable)
			return "";
	}
	
	return "disabled";
}
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
								$.getJSON("../json-simpeg/pegawai_add_penghasilan_tmt_json.php?reqId=<?=$reqId?>&reqTMT="+value,
								function(data){
									tempTMT= data.PEGAWAI_PENGHASILAN_ID;
								});
							}
							else
							{
								$.getJSON("../json-simpeg/pegawai_add_penghasilan_tmt_json.php?reqId=<?=$reqId?>&reqTMTTemp="+$(param[0]).val()+"&reqTMT="+value,
								function(data){
									tempTMT= data.PEGAWAI_PENGHASILAN_ID;
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
				url:'../json-simpeg/pegawai_add_perpanjangan_kontrak.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					
					top.frames['mainFrame'].location.reload();
					window.parent.divwin.close();
					<?php /*?>parent.frames['mainFramePop'].location.href = 'pegawai_add_penghasilan_monitoring.php?reqId=' + data[0];
					<? if($tempRowId) { ?>
						document.location.href = 'pegawai_add_penghasilan.php?reqId=' + data[0] + '&reqRowId=' + data[2];
					<? } ?><?php */?>
				}				
			});
			<?
			if($reqRowId == "")
			{
			?>
			$("#reqPeriode").keyup(function(e) {
				if( $("#reqPeriode").val() != ''){
					$.getJSON('../json-simpeg/get_periodik_penghasilan_gaji.php?reqPegawaiId=<?=$reqId?>&reqPeriode='+$("#reqPeriode").val(),
					function(data){
						/* JIKA DI JSON_GAJI ADA VARIABEL X MAKA TAMPILKAN */
						<?
						for($i=0;$i<count($json_item_gaji->{'ITEM_GAJI'});$i++)
						{
						?>
							$("#<?=$json_item_gaji->{'VAR_JUMLAH'}{$i}?>").val(FormatCurrency(data.<?=$json_item_gaji->{'ITEM_GAJI'}{$i}?>[2]));
							$("#<?=$json_item_gaji->{'VAR_PROSENTASE'}{$i}?>").val(FormatCurrency(data.<?=$json_item_gaji->{'ITEM_GAJI'}{$i}?>[0]));							
						<?
						}
						?>
						
					});
				}
			});
			<?
			}
			?>
			$("#reqPeriodeP3").keyup(function(e) {
					$.getJSON('../json-simpeg/get_periodik_penghasilan_p3.php?reqPeriode='+$("#reqPeriodeP3").val()+'&reqKelas='+$("#reqKelasP3").val(),
					function(data){
							$("#reqJumlahP3").val(FormatCurrency(data.JUMLAH));
						
					});
			});
			
			$("#reqKelasP3").keyup(function(e) {
					$.getJSON('../json-simpeg/get_periodik_penghasilan_p3.php?reqPeriode='+$("#reqPeriodeP3").val()+'&reqKelas='+$("#reqKelasP3").val(),
					function(data){
							$("#reqJumlahP3").val(FormatCurrency(data.JUMLAH));
					});
			});
			
            $("#reqJenisPegawaiId").change(function() { 
				 document.location.href = "pegawai_add_perubahan_jenis_pegawai.php?reqId=<?=$reqId?>&reqJenisPegawaiId="+ $("#reqJenisPegawaiId").val();				 	 
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

    <div id="judul-halaman">
		<span><img src="../WEB-INF/images/panah-judul.png">Informasi Perubahan Jenis Pegawai</span>
	</div>
    
    <div class="data-foto-table">
        <div class="data-foto">
            <div class="data-foto-img">
                <img src="../simpeg/image_script.php?reqPegawaiId=<?=$reqId?>&reqMode=pegawai" width="60" height="77">
            </div>
            
            <div class="data-foto-ket">
            	<div style="color:#000; font-size:18px; "><?=$pegawai->getField("NAMA")?> (<?=$pegawai->getField("NRP")?>)</div>     
                <div style="color:#000; font-size:15px;  line-height:20px;"><?=$pegawai->getField("JABATAN_NAMA")?></div>
                <div style="color:#000; font-size:12px;  line-height:20px;">Kelas : <?=$pegawai->getField("KELAS")?></div>
                <div style="color:#000; font-size:12px;  line-height:20px;">NPWP : <?=$pegawai->getField("NPWP")?></div>
            </div>
    
        </div>
        
        <div class="data-table">
    		<form id="ff" method="post" novalidate style="margin-top:20px;">
                <table border="0" width="100%">
                    <tr>
                        <td>
                            Masa Kontrak Sebelumnya.
                        </td>
                        <td colspan="3">
                            <?=$tempTanggalKontrakAwal?> s/d <?=$tempTanggalKontrakAkhir?>
                        </td>
                    </tr>    
                    <tr>
                        <td>
                            No Kontrak Baru
                        </td>
                        <td colspan="3">
                            <input name="reqNoKontrak" id="reqNoKontrak" class="easyui-validatebox" size="40" type="text" value="<?=$tempNoKontrak?>" />
                        </td>
                    </tr>    
                    <tr>
                        <td>
                            Masa Kontrak Baru
                        </td>
                        <td colspan="3">
                            <input id="dd" name="reqTanggalKontrakAwal" class="easyui-datebox" required data-options="validType:'date'" value="<?=$tempTanggal?>"></input> s/d 
                            <input id="dd" name="reqTanggalKontrakAkhir" class="easyui-datebox" required data-options="validType:'date'" value="<?=$tempTanggal?>"></input>
                        </td>
                    </tr>    
                    <tr>
                        <td>TMT</td>
                        <td colspan="3">
                            <?
                            $tempTMTtemp="";
                            if($reqRowId == ""){}
                            else
                            {
                                $tempTMTtemp= $tempTMTPenghasilan;
                            }
                            ?>
                            <input type="hidden" name="reqTMTTemp" id="reqTMTTemp" value="<?=$tempTMTtemp?>">
                            <input id="dd" name="reqTMTPenghasilan" class="easyui-datebox" validType="existTMT['#reqTMTTemp']" required value="<?=$tempTMTPenghasilan?>"></input>
                        </td>
                        <?php /*?><td>Periodik</td>
                        <td>
                            <input name="reqPeriode" id="reqPeriode" class="easyui-validatebox" required size="10" type="text" value="<?=$tempPeriode?>" />
                        </td><?php */?>
                    </tr>
                    <tr>
                        <td>Nomor SK</td>
                        <td>
                            <input name="reqNoSK" id="reqNoSK" class="easyui-validatebox" size="40" type="text" value="<?=$tempNoSK?>" />
                        </td>
                        <td>Tanggal SK</td>
                        <td>
                            <input id="dd" name="reqTanggal" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggal?>"></input>
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
                        <td>Kelas</td>
                        <td>
                            <input name="reqKelas" id="reqKelas" class="easyui-validatebox" required size="10" type="text" value="<?=$tempKelas?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>Periodik</td>
                        <td>
                            <input name="reqPeriode" <?=$periode_disabel?> id="reqPeriode" class="easyui-validatebox" 
                            <? if($periode_disabel == ''){}else{?>
                            style='font-size:12px; font-weight:bold; border:none; background:#CCC'
                            <? }?>
                            required size="10" type="text" value="<?=$tempPeriode?>" />
                        </td>
                        <td>Masa Kerja Periodik</td>
                        <td>
                            Tahun
                            <input name="reqTahun" id="reqTahun" class="easyui-validatebox" size="4" maxlength="4" type="text" value="<?=$tempTahun?>" />
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Bulan
                            <input name="reqBulan" id="reqBulan" class="easyui-validatebox" size="4" maxlength="2" type="text" value="<?=$tempBulan?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>Merit/Penghasilan</td>
                        <td>
                            (Rp.)
                            <input name="reqJumlahPenghasilan" type="text" id="reqJumlahPenghasilan" class="easyui-validatebox"  required="required" size="10" value="<?=numberToIna($tempJumlahPenghasilan)?>"  OnFocus="FormatAngka('reqJumlahPenghasilan')" OnKeyUp="FormatUang('reqJumlahPenghasilan')" OnBlur="FormatUang('reqJumlahPenghasilan')"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            (%)<input name="reqProsentasePenghasilan" id="reqProsentasePenghasilan" class="easyui-validatebox" required size="3" maxlength="5" type="text" value="<?=$tempProsentasePenghasilan?>" />
                        </td>
                        <td>Tunjangan Jabatan</td>
                        <td>
                            (Rp.)
                            <input name="reqJumlahTunjanganJabatan" <?=getEnableDisableInput($json_item_gaji, "reqJumlahTunjanganJabatan")?> type="text" id="reqJumlahTunjanganJabatan" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlahTunjanganJabatan)?>"  OnFocus="FormatAngka('reqJumlahTunjanganJabatan')" OnKeyUp="FormatUang('reqJumlahTunjanganJabatan')" OnBlur="FormatUang('reqJumlahTunjanganJabatan')"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            (%)<input name="reqProsentaseTunjanganJabatan" <?=getEnableDisableInput($json_item_gaji, "reqProsentaseTunjanganJabatan")?> id="reqProsentaseTunjanganJabatan" class="easyui-validatebox" size="3" maxlength="5" type="text" value="<?=$tempProsentaseTunjanganJabatan?>" />
                        </td>
                    </tr>
                    <?
                    if($tempJenisPegawaiId == 6)
                    {
                    ?>
                    <tr>
                        <td>Perumahan</td>
                        <td>
                            (Rp.)
                            <input name="reqJumlahPerumahan" <?=getEnableDisableInput($json_item_gaji, "reqJumlahPerumahan")?> type="text" id="reqJumlahPerumahan" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlahPerumahan)?>"  OnFocus="FormatAngka('reqJumlahPerumahan')" OnKeyUp="FormatUang('reqJumlahPerumahan')" OnBlur="FormatUang('reqJumlahPerumahan')"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            (%)<input name="reqProsentasePerumahan" <?=getEnableDisableInput($json_item_gaji, "reqProsentasePerumahan")?> id="reqProsentasePerumahan" class="easyui-validatebox" size="3" maxlength="3" type="text" value="<?=$tempProsentasePerumahan?>" />
                        </td>
                        <td>Mobilitas</td>
                        <td>
                            (Rp.)
                            <input name="reqJumlahMobilitas" <?=getEnableDisableInput($json_item_gaji, "reqJumlahMobilitas")?>  type="text" id="reqJumlahMobilitas" class="easyui-validatebox"  required="required" size="10" value="<?=numberToIna($tempJumlahMobilitas)?>"  OnFocus="FormatAngka('reqJumlahMobilitas')" OnKeyUp="FormatUang('reqJumlahMobilitas')" OnBlur="FormatUang('reqJumlahMobilitas')"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            (%)<input name="reqProsentaseMobilitas" <?=getEnableDisableInput($json_item_gaji, "reqProsentaseMobilitas")?>  id="reqProsentaseMobilitas" class="easyui-validatebox" required size="3" maxlength="3" type="text" value="<?=$tempProsentaseMobilitas?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>BBM</td>
                        <td>
                            (Rp.)
                            <input name="reqJumlahBBM" <?=getEnableDisableInput($json_item_gaji, "reqJumlahBBM")?> type="text" id="reqJumlahBBM" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlahBBM)?>"  OnFocus="FormatAngka('reqJumlahBBM')" OnKeyUp="FormatUang('reqJumlahBBM')" OnBlur="FormatUang('reqJumlahBBM')"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            (%)<input name="reqProsentaseBBM" <?=getEnableDisableInput($json_item_gaji, "reqProsentaseBBM")?> id="reqProsentaseBBM" class="easyui-validatebox" size="3" maxlength="3" type="text" value="<?=$tempProsentaseBBM?>" />
                        </td>
                        <td>Telepon</td>
                        <td>
                            (Rp.)
                            <input name="reqJumlahTelepon" <?=getEnableDisableInput($json_item_gaji, "reqJumlahTelepon")?>  type="text" id="reqJumlahTelepon" class="easyui-validatebox"  required="required" size="10" value="<?=numberToIna($tempJumlahTelepon)?>"  OnFocus="FormatAngka('reqJumlahTelepon')" OnKeyUp="FormatUang('reqJumlahTelepon')" OnBlur="FormatUang('reqJumlahTelepon')"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            (%)<input name="reqProsentaseTelepon" <?=getEnableDisableInput($json_item_gaji, "reqProsentaseTelepon")?>  id="reqProsentaseTelepon" class="easyui-validatebox" required size="3" maxlength="3" type="text" value="<?=$tempProsentaseTelepon?>" />
                        </td>
                    </tr>        
                    <?
                    }
                    else
                    {
                    ?>
                    <tr>
                        <td>Transportasi Harian</td>
                        <td>
                            (Rp.)
                            <input name="reqJumlahTransportasi" <?=getEnableDisableInput($json_item_gaji, "reqJumlahTransportasi")?> type="text" id="reqJumlahTransportasi" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlahTransportasi)?>"  OnFocus="FormatAngka('reqJumlahTransportasi')" OnKeyUp="FormatUang('reqJumlahTransportasi')" OnBlur="FormatUang('reqJumlahTransportasi')"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            (%)<input name="reqProsentaseTransportasi" <?=getEnableDisableInput($json_item_gaji, "reqProsentaseTransportasi")?> id="reqProsentaseTransportasi" class="easyui-validatebox" size="3" maxlength="3" type="text" value="<?=$tempProsentaseTransportasi?>" />
                        </td>
                        <td>Uang Makan Harian</td>
                        <td>
                            (Rp.)
                            <input name="reqJumlahUangMakan" <?=getEnableDisableInput($json_item_gaji, "reqJumlahUangMakan")?>  type="text" id="reqJumlahUangMakan" class="easyui-validatebox"  required="required" size="10" value="<?=numberToIna($tempJumlahUangMakan)?>"  OnFocus="FormatAngka('reqJumlahUangMakan')" OnKeyUp="FormatUang('reqJumlahUangMakan')" OnBlur="FormatUang('reqJumlahUangMakan')"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            (%)<input name="reqProsentaseUangMakan" <?=getEnableDisableInput($json_item_gaji, "reqProsentaseUangMakan")?>  id="reqProsentaseUangMakan" class="easyui-validatebox" required size="3" maxlength="3" type="text" value="<?=$tempProsentaseUangMakan?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>Insentif </td>
                        <td>
                            (Rp.)
                            <input name="reqJumlahInsentif" <?=getEnableDisableInput($json_item_gaji, "reqJumlahInsentif")?> type="text" id="reqJumlahInsentif" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlahInsentif)?>"  OnFocus="FormatAngka('reqJumlahInsentif')" OnKeyUp="FormatUang('reqJumlahInsentif')" OnBlur="FormatUang('reqJumlahInsentif')"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            (%)<input name="reqProsentaseInsentif" <?=getEnableDisableInput($json_item_gaji, "reqProsentaseInsentif")?> id="reqProsentaseInsentif" class="easyui-validatebox" size="3" maxlength="3" type="text" value="<?=$tempProsentaseInsentif?>" />
                        </td>
                        <td>Mobilitas</td>
                        <td>
                            (Rp.)
                            <input name="reqJumlahMobilitas" <?=getEnableDisableInput($json_item_gaji, "reqJumlahMobilitas")?>  type="text" id="reqJumlahMobilitas" class="easyui-validatebox"  required="required" size="10" value="<?=numberToIna($tempJumlahMobilitas)?>"  OnFocus="FormatAngka('reqJumlahMobilitas')" OnKeyUp="FormatUang('reqJumlahMobilitas')" OnBlur="FormatUang('reqJumlahMobilitas')"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            (%)<input name="reqProsentaseMobilitas" <?=getEnableDisableInput($json_item_gaji, "reqProsentaseMobilitas")?>  id="reqProsentaseMobilitas" class="easyui-validatebox" required size="3" maxlength="3" type="text" value="<?=$tempProsentaseMobilitas?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>TPP</td>
                        <td>
                            (Rp.)
                            <input name="reqJumlahTPP" <?=getEnableDisableInput($json_item_gaji, "reqJumlahTPP")?> type="text" id="reqJumlahTPP" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlahTPP)?>"  OnFocus="FormatAngka('reqJumlahTPP')" OnKeyUp="FormatUang('reqJumlahTPP')" OnBlur="FormatUang('reqJumlahTPP')"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            (%)<input name="reqProsentaseTPP" <?=getEnableDisableInput($json_item_gaji, "reqJumlahTPP")?> id="reqProsentaseTPP" class="easyui-validatebox" size="3" maxlength="3" type="text" value="<?=$tempProsentaseTPP?>" />
                        </td>
                        <td>Tunjangan Selisih</td>
                        <td>
                            (Rp.)
                            <input name="reqJumlahTunjanganSelisih" <?=getEnableDisableInput($json_item_gaji, "reqJumlahTunjanganSelisih")?> type="text" id="reqJumlahTunjanganSelisih" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlahTunjanganSelisih)?>"  OnFocus="FormatAngka('reqJumlahTunjanganSelisih')" OnKeyUp="FormatUang('reqJumlahTunjanganSelisih')" OnBlur="FormatUang('reqJumlahTunjanganSelisih')"/>
                        </td>
                    </tr>
                    <?
                    }
                    ?>
            <?php /*?>        <tr>
                        <td>Uang Kehadiran</td>
                        <td>
                            (Rp.)
                            <input name="reqJumlahUangKehadiran" <?=getEnableDisableInput($json_item_gaji, "reqJumlahUangKehadiran")?> type="text" id="reqJumlahUangKehadiran" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlahUangKehadiran)?>"  OnFocus="FormatAngka('reqJumlahUangKehadiran')" OnKeyUp="FormatUang('reqJumlahUangKehadiran')" OnBlur="FormatUang('reqJumlahUangKehadiran')"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            (%)<input name="reqProsentaseUangKehadiran" <?=getEnableDisableInput($json_item_gaji, "reqProsentaseUangKehadiran")?> id="reqProsentaseUangKehadiran" class="easyui-validatebox" size="3" maxlength="3" type="text" value="<?=$tempProsentaseUangKehadiran?>" />
                        </td>
                    </tr><?php */?>
                    <? if($tempJenisPegawaiId == 2 || $tempJenisPegawaiId == 6 || $tempJenisPegawaiId == 7){?>
                    <tr>
                        <td>Kelas P3</td>
                        <td>
                            <input name="reqKelasP3" type="text" id="reqKelasP3" class="easyui-validatebox" size="10" value="<?=$tempKelasP3?>" />
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Periode P3
                            <input name="reqPeriodeP3" type="text" id="reqPeriodeP3" class="easyui-validatebox" size="10" value="<?=$tempPeriodeP3?>" />
                        </td>
                        <td>Jumlah P3</td>
                        <td>
                            (Rp.)
                            <input name="reqJumlahP3" type="text" id="reqJumlahP3" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlahP3)?>"  OnFocus="FormatAngka('reqJumlahP3')" OnKeyUp="FormatUang('reqJumlahP3')" OnBlur="FormatUang('reqJumlahP3')"/>
                        </td>
                    </tr>
                    <? }?>
            
                </table>
                <div>
                    <? if($tempRowId == ''){ $reqMode='insert'; }else{ $reqMode='update'; }?>
                    <input type="hidden" name="reqRowId" value="<?=$tempRowId?>">
                    <input type="hidden" name="reqId" value="<?=$reqId?>">
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                    <input type="hidden" name="reqPegawaiJenisPegawaiId" value="<?=$tempPegawaiJenisPegawaiId?>">
                    <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
                    <input type="reset" id="rst_form">
                </div>
            </form>	
        </div>
    </div><!-- END DATA FOTO TABLE -->
    
</div>
<script>
$("#reqPeriode,#reqTahun,#reqBulan").keypress(function(e) {
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