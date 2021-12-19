<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunanDetil.php");

$cuti_tahunan_detil = new CutiTahunanDetil();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");
$tt_cuti_bersama = $cuti_tahunan_detil->sumCutiBersama();
$cuti_tahunan_detil->selectByParams(array('CUTI_TAHUNAN_DETIL_ID'=>$reqRowId));
$cuti_tahunan_detil->firstRow();

$tempTanggal=dateToPageCheck($cuti_tahunan_detil->getField('TANGGAL')); 
$tempLamaCuti= $cuti_tahunan_detil->getField('LAMA_CUTI') - $tt_cuti_bersama;
$tempTanggalAwal=dateToPageCheck($cuti_tahunan_detil->getField('TANGGAL_AWAL')); 
$tempTanggalAkhir=dateToPageCheck($cuti_tahunan_detil->getField('TANGGAL_AKHIR'));
$tempLokasiCuti = $cuti_tahunan_detil->getField("LOKASI_CUTI");
$reqTunda = $cuti_tahunan_detil->getField("STATUS_TUNDA_ID");
$reqNDTunda = $cuti_tahunan_detil->getField("NOTA_DINAS_TUNDA");
$reqTanggalNDTunda = dateToPageCheck($cuti_tahunan_detil->getField("TANGGAL_NOTA_DINAS_TUNDA"));
$reqKeteranganTunda = $cuti_tahunan_detil->getField("KETERANGAN_TUNDA");
$tempRowId = $reqRowId;

$tempCutiDiambil = $cuti_tahunan_detil->sumByParams(array("CUTI_TAHUNAN_ID" => $reqId));

if($tempLamaCuti < 0) {$tempLamaCuti = 0;}
if($tempCutiDiambil == 0){
	$tempCutiDiambil = $tt_cuti_bersama;
}
else {
	$tempCutiDiambil = $tempCutiDiambil - $tempLamaCuti;
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
				url:'../json-simpeg/cuti_tahunan_add_detil.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					//$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					parent.frames['mainFramePop'].location.href = 'cuti_tahunan_add_monitoring.php?reqId=' + data[0];
					document.location.href = 'cuti_tahunan_add_detil.php?reqId=' + data[0];
				}				
			});
			$('#reqTunda').change(function() {
				if($('#reqTunda').prop('checked')){
					$('#reqTunda').val('1');
					$('.hiddenkan').show();
				}
				else {
					$('#reqTunda').val('0');
					$('.hiddenkan').hide();
				}
			});
			if($('#reqTunda').prop('checked')){
				$('.hiddenkan').show();
			}
			else {
				$('.hiddenkan').hide();
			}
		});

		$.extend($.fn.validatebox.defaults.rules, {
			existNRP:{
				validator: function(value, param){
					if(parseInt(document.getElementById('reqLamaCuti').value) + parseInt(document.getElementById('reqCutiDiambil').value) > 12)
					{
						return false;
					}
					
					return true;
				},
				message: 'Lama cuti melebihi batas yang telah ditentukan.'
			}  
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
            <a href="cuti_tahunan_add_detil.php?reqId=<?=$reqId?>">Batal</a>
            </li>        
        <?
		}
		?>
        </ul>
    </div>
    <form id="ff" method="post" novalidate style="margin-top:20px;">
    <table>
        <tr>
            <td>Tanggal Permohonan</td>
            <td>
                <input id="dd" name="reqTanggal" class="easyui-datebox" data-options="validType:'date'" required value="<?=$tempTanggal?>"></input>
            </td>
        </tr>
        <tr>
            <td>Lama Cuti</td>
            <td>
                <input id="reqLamaCuti" name="reqLamaCuti" size="8" type="text" maxlength="2" value="<?=$tempLamaCuti?>" class="easyui-validatebox"  <? if($reqMode == "realisasi") { ?> readonly <? } else { ?> validType="existNRP" <? } ?> /> hari
                <?
                if($reqMode == "realisasi")
				{}
				else
				{
				?>
                &nbsp;&nbsp;&nbsp;<strong>(Cuti yang telah di ambil</strong> <input id="reqCutiDiambil" name="reqCutiDiambil" size="2" type="text" value="<?=(int)$tempCutiDiambil?>" readonly /> <strong>hari)</strong>
                &nbsp;&nbsp;&nbsp;
                <?
				}
				?>
            </td>
        </tr>
        <tr>
            <td>Tanggal Cuti</td>
            <td>
                <input id="dd" name="reqTanggalAwal" class="easyui-datebox" data-options="validType:'date'" required value="<?=$tempTanggalAwal?>"></input> s/d
                <input id="dd" name="reqTanggalAkhir" class="easyui-datebox" data-options="validType:'date'" required value="<?=$tempTanggalAkhir?>"></input>
            </td>
        </tr>
        <tr>
        	<td>Lokasi Cuti</td>
            <td><input type="text" name="reqLokasiCuti" value="<?=$tempLokasiCuti?>"></td>
        </tr>
        <tr >
        	<td>Tunda Cuti</td>
            <td><input type="checkbox" id="reqTunda" name="reqTunda" <?php if($reqTunda == 1) echo 'checked'; ?> value="<?=$reqTunda;?>" ></td>
        </tr>
        <tr class="hiddenkan" >
        	<td>Nota Dinas Tunda</td>
            <td><input type="text" name="reqNDTunda" value="<?=$reqNDTunda?>"></td>
        </tr>
        <tr class="hiddenkan" >
        	<td>Tanggal Nota Dinas Tunda</td>
            <td><input class="easyui-datebox" data-options="validType:'date'"  type="text" name="reqTanggalNDTunda" value="<?=$reqTanggalNDTunda?>"></td>
        </tr>
        <tr class="hiddenkan" >
        	<td>Keterangan Cuti Tunda</td>
            <td><textarea name="reqKeteranganTunda" id="reqKeteranganTunda" ><?=$reqKeteranganTunda?></textarea></td>
        </tr>
		<?
        if($reqMode == "realisasi")
        {}
        else
        {
        ?>        
        <tr><td colspan="2"><a style="text-decoration:blink"><strong>"Pada saat entri awal akan diakumulasikan dengan jumlah cuti bersama"</strong></a></td></tr>
		<?
		}
		?>
    </table>
        <div style="display:none">
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