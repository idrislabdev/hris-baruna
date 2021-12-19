<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiHukuman.php");
include_once("../WEB-INF/classes/base-simpeg/KategoriHukuman.php");
include_once("../WEB-INF/classes/base-simpeg/PejabatPenetap.php");
include_once("../WEB-INF/classes/base-simpeg/JenisHukuman.php");

$pegawai_hukuman = new PegawaiHukuman();
$kategori_hukuman = new KategoriHukuman();
$jenis_hukuman = new JenisHukuman();
$pejabat_penetap = new PejabatPenetap();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");

$pegawai_hukuman->selectByParams(array('PEGAWAI_HUKUMAN_ID'=>$reqRowId));
$pegawai_hukuman->firstRow();

$tempKategoriHukumanId = $pegawai_hukuman->getField('KATEGORI_HUKUMAN_ID');
$tempJenisHukumanId = $pegawai_hukuman->getField('JENIS_HUKUMAN_ID');
$tempPejabatPenetapId = $pegawai_hukuman->getField('PEJABAT_PENETAP_ID');
$tempTanggalSK = dateToPageCheck($pegawai_hukuman->getField('TANGGAL_SK'));
$tempTMTSK = dateToPageCheck($pegawai_hukuman->getField('TMT_SK'));
$tempNoSK = $pegawai_hukuman->getField('NO_SK');
$tempKasus = $pegawai_hukuman->getField('KASUS');
$tempRowId = $reqRowId;

$jenis_hukuman->selectByParams();
$kategori_hukuman->selectByParams();
$pejabat_penetap->selectByParams();

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
				url:'../json-simpeg/pegawai_add_hukuman.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					
					parent.frames['mainFramePop'].location.href = 'pegawai_add_hukuman_monitoring.php?reqId=' + data[0];
					<? if($tempRowId) { ?>
						document.location.href = 'pegawai_add_hukuman.php?reqId=' + data[0] + '&reqRowId=' + data[2];
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
        	<td>Kategori Hukuman</td>
            <td>
            	<select id="reqKategoriHukumanId" name="reqKategoriHukumanId" required="true">
                <? while($kategori_hukuman->nextRow()){?>
                	<option value="<?=$kategori_hukuman->getField('KATEGORI_HUKUMAN_ID')?>" <? if($tempKategoriHukumanId == $kategori_hukuman->getField('KATEGORI_HUKUMAN_ID')) echo 'selected';?>><?=$kategori_hukuman->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
            <td width="100px">Jenis Hukuman</td>
            <td>
            	<select id="reqJenisHukumanId" name="reqJenisHukumanId" required="true">
                <? while($jenis_hukuman->nextRow()){?>
                	<option value="<?=$jenis_hukuman->getField('JENIS_HUKUMAN_ID')?>" <? if($tempJenisHukumanId == $jenis_hukuman->getField('JENIS_HUKUMAN_ID')) echo 'selected';?>><?=$jenis_hukuman->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
        </tr>
        <tr>
        	<td>Tanggal SK</td>
            <td>
            	 <input id="reqTanggalSK" name="reqTanggalSK" data-options="validType:'date'" class="easyui-datebox" value="<?=$tempTanggalSK?>"></input>
            </td>
            <td>No. SK</td>
            <td>
            	<input name="reqNoSK" id="reqNoSK" class="easyui-validatebox" required size="40" type="text" value="<?=$tempNoSK?>" />
            </td>
        </tr>
        <tr>
        	<td>TMT SK</td>
            <td colspan="3">
                 <input id="reqTMTSK" name="reqTMTSK" data-options="validType:'date'" required class="easyui-datebox" value="<?=$tempTMTSK?>"></input>
            </td>
        </tr>
        <tr>
        	<td>Pejabat Penentap</td>
            <td colspan="3">
            	<select id="reqPejabatPenetapId" name="reqPejabatPenetapId" required="true">
                <? while($pejabat_penetap->nextRow()){?>
                	<option value="<?=$pejabat_penetap->getField('PEJABAT_PENETAP_ID')?>" <? if($tempPejabatPenetapId == $pejabat_penetap->getField('PEJABAT_PENETAP_ID')) echo 'selected';?>><?=$pejabat_penetap->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Kasus</td>
            <td colspan="3">
                <input name="reqKasus" id="reqKasus" class="easyui-validatebox" required size="85" type="text" value="<?=$tempKasus?>" />
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