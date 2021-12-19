<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Inventaris.php");

$inventaris = new Inventaris();

$reqId = httpFilterGet("reqId");

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$inventaris->selectByParams(array("A.INVENTARIS_ID" => $reqId));
	$inventaris->firstRow();
	
	$tempNama = $inventaris->getField("NAMA");
	$tempJenisInventaris= $inventaris->getField("JENIS_INVENTARIS_ID");
	$tempSpesifikasi= $inventaris->getField("SPESIFIKASI");
	$tempKode= $inventaris->getField("KODE");
	$tempUkuran= $inventaris->getField("UKURAN");
	$tempTipe = $inventaris->getField("TIPE");
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> -->
<title>Untitled Document</title>

<link rel="stylesheet" type="text/css" href="../WEB-INF/css/gaya.css">

<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
<script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/globalfunction.js"></script>

<script language="Javascript">
<? include_once "../jslib/formHandler.php"; ?>
</script>

<script type="text/javascript">
function setValue(){
	$('#reqJenisInventaris').combotree('setValue', '<?=$tempJenisInventaris?>');
}

$.fn.datebox.defaults.formatter = function(date){
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	var d = date.getDate();
	return d+'-'+m+'-'+y;
}		
$(function(){
	$('#ff').form({
		url:'../json-inventaris/inventaris_add.php',
		onSubmit:function(){
			return $(this).form('validate');
		},
		success:function(data){
			$.messager.alert('Info', data, 'info');
			$('#rst_form').click();
			top.frames['mainFrame'].location.reload();				
		}
	});
	
});
</script>
</head>

<body onLoad="setValue();" class="bg-kanan-full">
	<div id="judul-popup">Tambah Data Asset</div>
	<div id="konten">
    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
    	<div id="popup-tabel2">
    	<table>
        	<tr>
                <td>Kode</td>
                <td>:</td>
                <td>
                    <input name="reqKode" class="easyui-validatebox" required title="Kode harus diisi" style="width:300px;" type="text" value="<?=$tempKode?>" />
                </td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>
                    <input name="reqNama" class="easyui-validatebox" required title="Nama harus diisi" style="width:300px;" type="text" value="<?=$tempNama?>" />
                </td>
            </tr>
            <tr>
                <td>Jenis Asset</td>
                <td>:</td>
                <td>
                	<input id="reqJenisInventaris" name="reqJenisInventaris" style="width:200px" required class="easyui-combotree" data-options="url:'../json-inventaris/jenis_inventaris_combo_json.php'" style="width:300px;" value="<?=$tempJenisInventaris?>" />
                </td>
            </tr> 
            <tr>
                <td>Spesifikasi</td>
                <td>:</td>
                <td>
                    <input name="reqSpesifikasi" class="easyui-validatebox" style="width:300px;" type="text" value="<?=$tempSpesifikasi?>" />
                </td>
            </tr>
            <tr>
              <td>File Upload</td>
               <td>:</td>
              <td><input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
                <input type="file" name="reqLinkFile" id="reqLinkFile" /></td>
            </tr>
        	<tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <input type="hidden" name="reqId" value="<?=$reqId?>">
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                	<input type="submit" name="" value="Simpan" /> 
                    <input type="reset" id="rst_form" value="Reset" />
                </td>
            </tr>   
        </table>
        </div>     
        </form>
    </div>
</body>
</html>