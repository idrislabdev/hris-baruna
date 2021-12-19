<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Lokasi.php");

$lokasi = new Lokasi();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");

if($reqMode == "update")
{
	$lokasi->selectByParams(array("LOKASI_ID" => $reqId));
	$lokasi->firstRow();
	
	$tempLokasiParent 	= $lokasi->getField("LOKASI_PARENT_ID");
	$tempNama 			= $lokasi->getField("NAMA");
	$tempKeterangan 	= $lokasi->getField("KETERANGAN");
	$tempKode		 	= $lokasi->getField("KODE");
	$tempAlamat		 	= $lokasi->getField("ALAMAT");
	$tempLinkFileTemp 	= $lokasi->getField('FILE_GAMBAR');
	$tempX= $lokasi->getField('X');
	$tempY= $lokasi->getField('Y');
}
else
	$tempLokasiParent = $reqId;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>

<link rel="stylesheet" type="text/css" href="../WEB-INF/css/gaya.css">

<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
<script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript">
$.fn.datebox.defaults.formatter = function(date){
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	var d = date.getDate();
	return d+'-'+m+'-'+y;
}		
$(function(){
	$('#ff').form({
		url:'../json-inventaris/lokasi_add.php',
		onSubmit:function(){
			return $(this).form('validate');
		},
		success:function(data){
			//alert(data);
			$.messager.alert('Info', data, 'info');
			$('#rst_form').click();
			top.frames['mainFrame'].location.reload();
		}
	});
	
});

function iecompattest(){
	return (!window.opera && document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function OpenDHTMLPopup(opAddress, opCaption, opWidth, opHeight)
{
	var left = iecompattest().scrollLeft; //(screen.width/2)-(opWidth/2);
	var top = (screen.height/2)-(opHeight/2) - 150;
	
	opWidth = iecompattest().clientWidth;      
	divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
}			
function openMap()
{
	OpenDHTMLPopup('lokasi_add_pilih.php?reqId='+$("#reqId").val()+'&reqMap='+$("#reqFileGambarTemp").val(), 'Administrasi Website', 500, 500)	
}
</script>
<link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>  
</head>

<body class="bg-kanan-full">
	<div id="judul-popup">Tambah Lokasi</div>
	<div id="konten">
    	<form id="ff" method="post" enctype="multipart/form-data">
    	<div id="popup-tabel2">  	
        <table>        	
            <tr>
                <td>Kode</td>
                <td>:</td>
                <td>
                    <input name="reqKode" class="easyui-validatebox" size="40" type="text" value="<?=$tempKode?>" />
                </td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>
                    <input name="reqNama" class="easyui-validatebox" required title="Nama harus diisi" size="40" type="text" value="<?=$tempNama?>" />
                </td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>
                    <textarea name="reqAlamat" title="Alamat harus diisi" style="width:300px; height:60px;"><?=$tempAlamat?></textarea>
                </td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td>
                    <textarea name="reqKeterangan" title="Keterangan harus diisi" style="width:300px; height:60px;"><?=$tempKeterangan?></textarea>
                </td>
            </tr>
            <?
            if($tempLokasiParent == 0)
			{
			?>
        	<tr>
            	<td>Gambar</td>
                <td>:</td>
                <td>
                   	<input type="file" style="width:150px" name="reqLinkFile" id="reqLinkFile" value="<?=$tempLinkFile?>" />
                   	<input type="hidden" name="reqLinkFileTemp" value="<?=$tempLinkFileTemp?>" /> 
                    <br />temp : <label id="idImageNama"><?=$tempLinkFileTemp?></label>
                 </td>
            </tr>  
            <?
			} 
			else
			{
			?>
            <tr>
            	<td valign="top">Titik Lokasi</td>
                <td valign="top">:</td>
                <td valign="top">
					X = <input type="text" name="reqX" id="reqX" class="easyui-validatebox" style="width:30px;" readonly value="<?=$tempX?>" />
                    <a style="cursor:pointer;" onclick="openMap()"><img src="../WEB-INF/images/app-map-icon.png" title="Tentukan Lokasi" /></a>
                    <br />
                    Y = <input type="text" name="reqY" id="reqY" class="easyui-validatebox" style="width:30px;" readonly value="<?=$tempY?>" />                    
                </td>
            </tr>
            <?
			}
            ?>
        	<tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <input type="hidden" id="reqId" name="reqId" value="<?=$reqId?>">
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