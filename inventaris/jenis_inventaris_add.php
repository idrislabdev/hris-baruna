<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/JenisInventaris.php");

$jenis_inventaris = new JenisInventaris();

$reqId = httpFilterGet("reqId");

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
	$jenis_inventaris->selectByParams(array("JENIS_INVENTARIS_ID" => $reqId));
	$jenis_inventaris->firstRow();
	$tempNama = $jenis_inventaris->getField("NAMA");
	$tempKeterangan = $jenis_inventaris->getField("KETERANGAN");
	$tempKode = $jenis_inventaris->getField("KODE");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> -->
<title>Untitled Document</title>

<link rel="stylesheet" type="text/css" href="../WEB-INF/css/gaya.css">

<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
<script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>

<script language="Javascript">
<? include_once "../jslib/formHandler.php"; ?>
</script>

<script type="text/javascript">
$.fn.datebox.defaults.formatter = function(date){
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	var d = date.getDate();
	return d+'-'+m+'-'+y;
}		
$(function(){
	$('#ff').form({
		url:'../json-inventaris/jenis_inventaris_add.php',
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

<body class="bg-kanan-full">
	<div id="judul-halaman"><span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Jenis Asset</span></div>
	<div id="konten">
    	<form id="ff" method="post" novalidate>
    	<div id="popup-tabel2">
    	<table>
        	<tr>
                <td>Kode</td>
                <td>:</td>
            	<td>
                    <input name="reqKode" class="easyui-validatebox" style="width:100px;" type="text" value="<?=$tempKode?>" />
                </td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>
                    <input name="reqNama" class="easyui-validatebox" required="true" title="Nama harus diisi" style="width:300px;" type="text" value="<?=$tempNama?>" />
                </td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td>
                     <textarea name="reqKeterangan" style="width:250px; height:10 0px;"><?=$tempKeterangan?></textarea>
                </td>
            </tr>
        	<tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <input type="hidden" name="reqId" value="<?=$reqId?>">
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                	<input type="submit" name="" value="Simpan" /> 
                    <input type="reset" name="" value="Reset" />
                </td>
            </tr>   
        </table>
        </div>     
        </form>
    </div>
</body>
</html>