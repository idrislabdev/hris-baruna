<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-operasional/SuratPerintah.php");

$surat_perintah = new SuratPerintah();

$reqId = httpFilterGet("reqId");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == ""){}
else
{
	$reqMode="update";
	$surat_perintah->selectByParams(array('SURAT_PERINTAH_ID'=>$reqId), -1, -1);
	$surat_perintah->firstRow();
	
	$tempNomorPenugasan= $surat_perintah->getField("NOMOR_PENUGASAN");
	$tempNomor= $surat_perintah->getField("NOMOR");
	$tempPekerjaan= $surat_perintah->getField("PEKERJAAN");
	$tempTanggal= dateToPageCheck($surat_perintah->getField("TANGGAL"));
	$tempLokasi= $surat_perintah->getField("LOKASI");
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
				url:'../json-simpeg/surat_perintah_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					/*data = data.split("-");
					$.messager.alert('Info', data[1], 'info');*/
					
					window.parent.OptionSet('<?=$reqId?>');
					top.frames['mainFrame'].location.reload();
					window.parent.divwin.close();
					
					
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
	<div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Data Surat Perintah</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Nomor Penugasan</td>
			 <td>
                <input name="reqNomorPenugasan" class="easyui-validatebox" required="true" style="width:200px" type="text" value="<?=$tempNomorPenugasan?>" />
			</td>			
        </tr>
        <tr>
             <td>Nomor</td>
			 <td>
             	<input name="reqNomor" class="easyui-validatebox" required="true" style="width:200px" type="text" value="<?=$tempNomor?>" />
			</td>			
        </tr>
        <tr>           
             <td>Pekerjaan</td>
			 <td>
             	<input name="reqPekerjaan" class="easyui-validatebox" style="width:300px" type="text" value="<?=$tempPekerjaan?>" />
			</td>			
        </tr>
        <tr>           
             <td>Tanggal</td>
			 <td>
             	<input id="dd" name="reqTanggal" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggal?>" style="width:80px" />
			</td>			
        </tr>
        <tr>           
             <td>Lokasi</td>
			 <td>
                <input name="reqLokasi" class="easyui-validatebox" style="width:250px" type="text" value="<?=$tempLokasi?>" />
			</td>			
        </tr>
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
        </div>
    </form>
</div>
</body>
</html>