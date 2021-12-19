<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPuspel.php");
include_once("../WEB-INF/classes/base-simpeg/Cabang.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");

$pegawai = new Pegawai();
$pegawai_puspel = new PegawaiPuspel();
$cabang = new Cabang();
$departemen_cabang = new Departemen();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");

$pegawai_puspel->selectByParams(array('PEGAWAI_PUSPEL_ID'=>$reqRowId));
$pegawai_puspel->firstRow();

$tempTMTPuspel = dateToPageCheck($pegawai_puspel->getField('TMT_PUSPEL'));
$tempKodePuspel1 = $pegawai_puspel->getField('KODE_PUSPEL1');
$tempKodePuspel2 = $pegawai_puspel->getField('KODE_PUSPEL2');
$tempKodePuspel3 = $pegawai_puspel->getField('KODE_PUSPEL3');
$tempTanggalPuspel = dateToPageCheck($pegawai_puspel->getField('TANGGAL_PUSPEL'));
$tempCabang = $pegawai_puspel->getField('CABANG_ID');

$pegawai->selectByParams(array("PEGAWAI_ID" => $reqId));
$pegawai->firstRow();	$tempDepartemenPegawai = $pegawai->getField('DEPARTEMEN_ID');

$tempDepartemen = $pegawai_puspel->getField('DEPARTEMEN_ID');
if($tempDepartemen == '') $tempDepartemen= $tempDepartemenPegawai;

$tempRowId = $pegawai_puspel->getField('PEGAWAI_PUSPEL_ID');

$cabang->selectByParams();
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
		function setValue(){
			$('#ccDepartemen').combotree('setValue', '<?=$tempDepartemen?>');
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
		
		$(function(){
			$('#ff').form({
				url:'../json-simpeg/pegawai_add_puspel.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					
					parent.frames['mainFramePop'].location.href = 'pegawai_add_puspel_monitoring.php?reqId=' + data[0];
					<? if($tempRowId) { ?>
						document.location.href = 'pegawai_add_puspel.php?reqId=' + data[0] + '&reqRowId=' + data[2];
					<? } ?>
				}				
			});
		});
		
	</script>
    <style>
	    .CodeMirror-scroll { height: 100%; overflow-x: auto;}
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
            <a href="pegawai_add_puspel.php?reqId=<?=$reqId?>">Batal</a>
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
                <input id="dd" name="reqTMTPuspel" class="easyui-datebox" data-options="validType:'date'"  required="required" value="<?=$tempTMTPuspel?>"></input>
            </td>
        </tr>
        <tr>
            <td>Kode Puspel1</td>
            <td>
                <input name="reqKodePuspel1" id="reqKodePuspel1" class="easyui-validatebox" size="10" type="text" value="<?=$tempKodePuspel1?>" />
                &nbsp;&nbsp;&nbsp;
                Kode Puspel2
                <input name="reqKodePuspel2" id="reqKodePuspel2" class="easyui-validatebox" size="10" type="text" value="<?=$tempKodePuspel2?>" />
                &nbsp;&nbsp;&nbsp;
                Kode Puspel3
                <input name="reqKodePuspel3" id="reqKodePuspel3" class="easyui-validatebox" size="10" type="text" value="<?=$tempKodePuspel3?>" />
            </td>
        </tr>
        <?php /*?><tr>
            <td>Cabang/Unit/Pelb.</td>
            <td>
            	<select id="reqCabang" name="reqCabang">
            	<? while($cabang->nextRow()){?>
                	<option value="<?=$cabang->getField('CABANG_ID')?>" <? if($tempJabatan == $cabang->getField('CABANG_ID')) echo 'selected';?>><?=$cabang->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
        </tr><?php */?>
        <tr>
            <td>Unit Kerja</td>
            <td><input id="ccDepartemen" class="easyui-combotree"  required="true" name="reqDepartemen" data-options="panelHeight:'88',url:'../json-simpeg/departemen_combo_json.php'" style="width:300px;"></td>
        </tr>
        <tr>
            <td>Tanggal Puspel</td>
            <td>
                <input id="dd" name="reqTanggalPuspel" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalPuspel?>"></input>
            </td>
        </tr>
    </table>
        <div style="display:none">
        	<? if($tempRowId == ''){ $reqMode='insert'; }else{ $reqMode='update'; }?>
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqRowId" value="<?=$reqRowId?>">
            <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
<script>
$("#reqKodePuspel1,#reqKodePuspel2,#reqKodePuspel3").keypress(function(e) {
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