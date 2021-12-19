<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiSKPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/PejabatPenetap.php");

$pegawai_sk_pegawai = new PegawaiSKPegawai();
$pejabat_penetap = new PejabatPenetap();

$reqId = httpFilterGet("reqId");
$reqPegawaiSkPegawaiId = httpFilterGet("reqPegawaiSkPegawaiId");

if($reqId == "")
{
	echo '<script language="javascript">';
	echo 'alert("Isi data pegawai terlebih dahulu.");';	
	echo 'window.parent.location.href = "pegawai_add.php";';
	echo '</script>';
	exit();
}

$pegawai_sk_pegawai->selectByParams(array("PEGAWAI_ID" => $reqId));
$pegawai_sk_pegawai->firstRow();

$tempPegawaiSkPegawaiId = $pegawai_sk_pegawai->getField('PEGAWAI_SK_PEGAWAI_ID');
$tempNoSK = $pegawai_sk_pegawai->getField('NO_SK');
$tempTanggalSK = dateToPageCheck($pegawai_sk_pegawai->getField('TANGGAL_SK'));
$tempTanggalMulai = dateToPageCheck($pegawai_sk_pegawai->getField('TMT_SK'));
$tempPejabat = $pegawai_sk_pegawai->getField('PEJABAT_PENETAP_ID');
	
if($tempPegawaiSkPegawaiId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";
}

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
				url:'../json-simpeg/pegawai_add_sk_pegawai.php',
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
					document.location.href = 'pegawai_add_sk_pegawai.php?reqId=' + data[0];
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
                <span><img src="../WEB-INF/images/panah-judul.png">SK Pegawai</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
        	<td>Tanggal SK</td>
            <td>
                <input id="dd" name="reqTanggalSK" class="easyui-datebox" data-options="validType:'date'"  required="required" value="<?=$tempTanggalSK?>"></input>
                &nbsp;&nbsp;&nbsp;
                No SK&nbsp;
                <input name="reqNoSK" id="reqNoSK" class="easyui-validatebox" required="required" size="45" type="text" value="<?=$tempNoSK?>" />
            </td>
            <?php /*?><td>No SK</td>
            <td>
                <input name="reqNoSK" id="reqNoSK" class="easyui-validatebox" required="required" size="45" type="text" value="<?=$tempNoSK?>" />
            </td><?php */?>
        </tr>
        <?php /*?><tr>
            <td>Tanggal SK</td>
            <td>
                <input id="dd" name="reqTanggalSK" class="easyui-datebox" data-options="validType:'date'"  required="required" value="<?=$tempTanggalSK?>"></input>
            </td>
        </tr><?php */?>
        <tr>
            <td>Mulai Diangkat</td>
            <td>
                <input id="dd" name="reqTanggalMulai" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalMulai?>"></input>
            </td>
        </tr>
        <tr>
            <td><!--Pejabat Tanda Tangan-->Pejabat Penetap</td>
            <td>
            	<select id="reqPejabat" name="reqPejabat">
                <? while($pejabat_penetap->nextRow()){?>
                	<option value="<?=$pejabat_penetap->getField('PEJABAT_PENETAP_ID')?>" <? if($tempPejabat == $pejabat_penetap->getField('PEJABAT_PENETAP_ID')) echo 'selected';?>><?=$pejabat_penetap->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
        </tr>
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqPegawaiSkPegawaiId" value="<?=$tempPegawaiSkPegawaiId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>