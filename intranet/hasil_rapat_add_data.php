<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/HasilRapat.php");

$hasil_rapat = new HasilRapat();

$reqId = httpFilterGet("reqId");
//$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "") $reqMode = "insert";
else {
	$reqMode = "update";	
	$hasil_rapat->selectByParams(array("HASIL_RAPAT_ID" => $reqId));
	$hasil_rapat->firstRow();

	$tempDepartemenId	= $hasil_rapat->getField("DEPARTEMEN_ID");
	$tempDepartemen		= $hasil_rapat->getField("DEPARTEMEN");
	$tempJabatan		= $hasil_rapat->getField("JABATAN");
	$tempNama			= $hasil_rapat->getField("NAMA");
	$tempTanggal		= dateToPage($hasil_rapat->getField("TANGGAL"));	
	if($tempDepartemen == "") $tempDepartemen = "NULL";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		function setValue(){
			$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
		}
		
		$.fn.datebox.defaults.formatter = function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
		}
		
		$(function(){
			$('#ff').form({
				url		: '../json-intranet/hasil_rapat_add_data.php',
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
					top.frames['mainFrame'].location.reload();
					parent.frames['menuFramePop'].location.href = 'hasil_rapat_add_menu.php?reqId=' + data[0];
					document.location.href = 'hasil_rapat_add_data.php?reqId=' + data[0];
					<? if($reqMode == "update") {} else { ?> window.parent.divwin.close(); <? } ?>					
				}
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script>    
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Hasil Rapat</span>
    </div>

	<form id="ff" method="post" novalidate>
    <table>
        <tr>
			<td>Departemen</td>
            <td>
            	<select id="tt" class="easyui-combotree" data-options="onCheck:onCheck1,url:'../json-intranet/departemen_combotree_json.php?reqId=<?=$reqId?>&reqDepartemen=<?=$tempDepartemen?>&reqDepartemenId=<?=$tempDepartemenId?>',checkbox:true,cascadeCheck:false" multiple style="width:300px;"></select>
				<script>
					function onCheck1(v){
						var s											= $('#tt').combotree('getText');
						document.getElementById('idDepartemen').value	= s;
					}
				</script>   
				<input type="hidden" id="idDepartemen" name="reqDepartemen" value="<?=$tempDepartemen?>">
            </td>
		</tr>
        <tr>
            <td>Jabatan</td>
            <td>
            	<select id="tt2" class="easyui-combotree" data-options="onCheck:onCheck2,url:'../json-intranet/jabatan_combotree_json.php?reqId=<?=$reqId?>',onlyLeafCheck:true,checkbox:true,cascadeCheck:true" multiple style="width:300px;"></select>
				<script>
					function onCheck2(v){
						var s										= $('#tt2').combotree('getText');
						document.getElementById('idJabatan').value	= s;
					}
				</script>   
                <input type="hidden" id="idJabatan" name="reqJabatan" value="<?=$tempJabatan?>">
            </td>
        </tr>
        <tr>
        	<td>Tanggal</td>
            <td>
            	<input name="reqTanggal" class="easyui-datebox" required="required" value="<?=$tempTanggal?>" data-options="formatter:myformatter,parser:myparser"></input>&nbsp;&nbsp;Format : Tahun-Bulan-Tanggal
				
				<script type="text/javascript">
					function myformatter(date){
						var y = date.getFullYear();
						var m = date.getMonth()+1;
						var d = date.getDate();
						return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y;
					}
					
					function myparser(s){
						if (!s) return new Date();
						var ss = (s.split('-'));
						var y = parseInt(ss[0],10);
						var m = parseInt(ss[1],10);
						var d = parseInt(ss[2],10);
						if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
							return new Date(d,m-1,y);
						}
						else {
							return new Date();
						}
					}
				</script>
            </td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><input name="reqNama" class="easyui-validatebox" required size="60" type="text" value="<?=$tempNama?>"/></td>
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
</body>
</html>