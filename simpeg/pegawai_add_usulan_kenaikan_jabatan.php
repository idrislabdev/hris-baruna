<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");

$pegawai = new Pegawai();
$pegawai_info = new Pegawai();
$departemen_cabang = new Departemen();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");

$pegawai->selectByParamsDepartemenJabatan(array("A.PEGAWAI_ID" => $reqId));
$pegawai->firstRow();	

$pegawai_info->selectByParams(array("A.PEGAWAI_ID" => $reqId));
$pegawai_info->firstRow();

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
		var tempTMT='';
		
		function setValue(){
			$('#ccDepartemen').combotree('setValue', '<?=$tempDepartemen?>');
			$('#ccJabatan').combotree('setValue', '<?=$tempJabatan?>');
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
				url:'../json-simpeg/pegawai_add_usulan_kenaikan_jabatan.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					/*data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					window.parent.divwin.close();*/
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

    <div id="judul-halaman">
		<span><img src="../WEB-INF/images/panah-judul.png">Usulan Kenaikan Jabatan</span>
	</div>
    
    <div class="data-foto-table">
        <div class="data-foto">
            <div class="data-foto-img">
                <img src="../simpeg/image_script.php?reqPegawaiId=<?=$reqId?>&reqMode=pegawai" width="60" height="77">
            </div>
            
            <div class="data-foto-ket">
            	<div style="color:#000; font-size:18px; "><?=$pegawai_info->getField("NAMA")?> (<?=$pegawai_info->getField("NRP")?>)</div>     
                <div style="color:#000; font-size:15px;  line-height:20px;"><?=$pegawai_info->getField("JABATAN_NAMA")?></div>
                <div style="color:#000; font-size:12px;  line-height:20px;">Kelas : <?=$pegawai_info->getField("KELAS")?></div>
                <div style="color:#000; font-size:12px;  line-height:20px;">NPWP : <?=$pegawai_info->getField("NPWP")?></div>
            </div>
    
        </div>
        
        <div class="data-table">
    		<form id="ff" method="post" novalidate style="margin-top:20px;">
                <table>
                    <tr>
                        <td>Unit Kerja Lama</td>
                        <td>
                            <label><?=$pegawai->getField("DEPARTEMEN")?></label>
                            <input type="hidden" name="reqDepartemenLama" value="<?=$pegawai->getField("DEPARTEMEN_ID")?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Jabatan Lama</td>
                        <td>
                            <label><?=$pegawai->getField("JABATAN")?></label>
                            <input type="hidden" name="reqJabatanLama" value="<?=$pegawai->getField("JABATAN_ID")?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Unit Kerja Baru</td>
                        <td>
                            <input id="ccDepartemen" class="easyui-combotree" required name="reqDepartemenBaru" data-options="panelHeight:'180',url:'../json-simpeg/departemen_combo_json.php'" style="width:300px;">
                        </td>
                    </tr>
                    <tr>
                        <td>Jabatan Baru</td>
                        <td>
                            <input id="ccJabatan" class="easyui-combotree"  required="true" name="reqJabatanBaru" data-options="panelHeight:'150',url:'../json-simpeg/jabatan_combo_json.php'" style="width:300px;">
                        </td>
                    </tr>
                </table>
                <div>
                    <? $reqMode='insert';?>
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                    <input type="hidden" name="reqId" value="<?=$reqId?>">
                    <input type="hidden" name="reqRowId" value="<?=$reqRowId?>">
                    <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
                    <input type="reset" id="rst_form">
                </div>
            </form>
        </div>
    </div><!-- END DATA FOTO TABLE -->
    
</div>
</body>
</html>