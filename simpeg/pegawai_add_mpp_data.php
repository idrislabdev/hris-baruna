<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

$pegawai = new Pegawai();

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
	$tempAgamaId= $pegawai->getField('AGAMA_NAMA');
	$tempDepartemen = $pegawai->getField('DEPARTEMEN_ID');
	$tempNRP = $pegawai->getField('NRP');
	$tempTempat = $pegawai->getField('TEMPAT_LAHIR');
	$tempTanggal = dateToPageCheck($pegawai->getField('TANGGAL_LAHIR'));
	$tempUnitKerja= $pegawai->getField('DEPARTEMEN');
	$tempStatusPegawai= $pegawai->getField('STATUS_PEGAWAI_NAMA');
	$tempStatusPegawaiId = 5;
	$tempTMTMPP= dateToPageCheck($pegawai->getField('TANGGAL_MPP'));
	$tempNoSKMPP= $pegawai->getField('NO_MPP');
}

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
				url:'../json-simpeg/pegawai_add_mpp_data.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					parent.frames['menuFramePop'].location.href = 'pegawai_add_mpp_menu.php?reqId=' + data[0];
					document.location.href = 'pegawai_add_mpp_data.php?reqId=' + data[0];				
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
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script>    
</head>

<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Data MPP</span>
    </div>
    <form id="ff" method="post" novalidate enctype="multipart/form-data">
    <table>
        <tr>
            <td>NRP / NIPP</td>
            <td colspan="3">
            	<label><?=$tempNRP?></label>&nbsp;/&nbsp;<label><?=$tempNPP?></label>
            </td>
        </tr>
        <tr>
            <td>Nama</td>
            <td colspan="3">
            	<label><?=$tempNama?></label>
            </td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td colspan="3"><label><?=$tempUnitKerja?></label></td>
        </tr>
        <tr>
        	<td>Agama</td>
            <td colspan="3">
            	<label><?=$tempAgamaId?></label>
                &nbsp;&nbsp;&nbsp;&nbsp;
            	Jenis Kelamin : <label><?=$tempJenisKelamin?></label>
            </td>
        </tr>
        <tr>
            <td>Tgl MPP</td>
            <td colspan="3">
                <input id="reqTMTMPP" name="reqTMTMPP" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTMTMPP?>" />
            </td>
        </tr>
        <tr>
            <td>No SK MPP</td>
            <td colspan="3">
                <input name="reqNoSKMPP" id="reqNoSKMPP" class="easyui-validatebox" size="40" type="text" value="<?=$tempNoSKMPP?>" />
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