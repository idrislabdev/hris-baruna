<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriodeTahun.php");

$gaji_periode_tahun = new GajiPeriodeTahun();
$cuti_tahunan = new CutiTahunan();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");

$cuti_tahunan->selectByParamsPegawai(array('PEGAWAI_ID'=>$reqId));
$cuti_tahunan->firstRow();

$tempPeriode = $cuti_tahunan->getField("PERIODE");
$tempStatus = $cuti_tahunan->getField("STATUS_BAYAR_MUTASI");
$tempLamaCuti = $cuti_tahunan->getField("LAMA_CUTI");
$tempLamaCutiTerbayar = $cuti_tahunan->getField("LAMA_CUTI_TERBAYAR");


$gaji_periode_tahun->selectByParams(array(),-1,-1,"","ORDER BY GAJI_PERIODE_TAHUN_ID DESC");
while($gaji_periode_tahun->nextRow())
{
	$arrPeriode[] = $gaji_periode_tahun->getField("PERIODE");	
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
				url:'../json-simpeg/pegawai_add_status_cuti_tahunan.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					parent.frames['mainFramePop'].location.href = 'pegawai_add_status_cuti_tahunan_monitoring.php?reqId=' + data[0];
					document.location.href = 'pegawai_add_status_cuti_tahunan.php?reqId='+data[0];
				}				
			});
			
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
            <a href="pegawai_add_status_cuti_tahunan.php?reqId=<?=$reqId?>">Batal</a>
            </li>        
        <?
		}
		?>
        </ul>
    </div>
    <form id="ff" method="post" novalidate style="margin-top:20px;">
    <table>
    	<tr>
        	<td>Periode</td>
            <td><select name="reqPeriode" id="reqPeriode">
        		  <?
                  for($i=0;$i<count($arrPeriode);$i++)
				  {
				  ?>
                  	<option value="<?=$arrPeriode[$i]?>" <? if($tempPeriode == $arrPeriode[$i]) { ?> selected <? } ?>><?=$arrPeriode[$i]?></option>
                  <?	  
				  }
				  ?>
        		  </select></td>
        </tr>
        <tr>
            <td>Lama Cuti</td>
            <td>
                <input id="reqLamaCuti" name="reqLamaCuti" size="8" type="text" maxlength="2" value="<?=$tempLamaCuti?>" class="easyui-validatebox" validType="existNRP" /> hari
                <input id="reqCutiDiambil" name="reqCutiDiambil" size="2" type="hidden" value="0" />                
            </td>
        </tr> 
        <tr>
            <td>Lama Cuti Terbayar</td>
            <td>
                <input id="reqLamaCutiTerbayar" name="reqLamaCutiTerbayar" size="8" type="text" maxlength="2" value="<?=$tempLamaCutiTerbayar?>" class="easyui-validatebox" validType="existNRP" /> hari
            </td>
        </tr>                
<?php /*?>        <tr>
        	<td>Status Bantuan</td>
            <td><select name="reqStatus"><option value="D" <? if($tempStatus == "D") { ?> selected <? } ?>>Sesuai Hari</option><option value="F" <? if($tempStatus == "F") { ?> selected <? } ?>>Full</option></select></td>
        </tr><?php */?>
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