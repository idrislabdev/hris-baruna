<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/Lokasi.php");

$lokasi = new Lokasi();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

$lokasi->selectByParams(array("LOKASI_ID" => $reqId));
$lokasi->firstRow();

$tempGM = $lokasi->getField("GM");
$tempManager = $lokasi->getField("MANAGER");
$tempAsman = $lokasi->getField("ASMAN");
$tempJabatanManager = $lokasi->getField("JABATAN_MANAGER");
$tempJabatanAsman = $lokasi->getField("JABATAN_ASMAN");
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
<script type="text/javascript" src="../WEB-INF/lib/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/globalfunction.js"></script>

<script language="Javascript">
<? include_once "../jslib/formHandler.php"; ?>
</script>

<script type="text/javascript">
$(function(){
	$('#ff').form({
		url:'../json-operasional/pendataan_cetak_add.php',
		onSubmit:function(){
			return $(this).form('validate');
		},
		success:function(data){
			document.location.href = 'cetak_inventaris.php?reqLokasi=<?=$reqId?>';	
		}
	});
});
</script>
</head>

<body class="bg-kanan-full">
	<div id="judul-popup">Tambah Data Inventaris</div>
	<div id="konten">
    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
    	<div id="popup-tabel2">
    	<table>
        	<tr>
                <td style="text-align:center">JABATAN</td>   
                <td style="text-align:center">NAMA</td>        
            </tr>
            <tr>
                <td>GENERAL MANAGER</td>
                <td>
                    <input id="reqGM" name="reqGM" class="easyui-combobox"  
                    data-options="
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url:'../json-inventaris/penanda_tangan_combo_json.php'
                    " style="width:350px;"  value="<?=$tempGM?>"/>
                </td>
            </tr>
            <tr>
                <td><input type="text" name="reqJabatanManager" value="<?=$tempJabatanManager?>" placeholder="Manager"></td>
                <td>
                    <input id="reqManager" name="reqManager" class="easyui-combobox"  
                    data-options="
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url:'../json-inventaris/penanda_tangan_combo_json.php'
                    " style="width:350px;" value="<?=$tempManager?>" />
                </td>
            </tr>
            <tr>
                <td><input type="text" name="reqJabatanAsman" value="<?=$tempJabatanAsman?>" placeholder="Asisten Manager"></td>
                <td>
                     <input id="reqAsman" name="reqAsman" class="easyui-combobox"  
                    data-options="
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url:'../json-inventaris/penanda_tangan_combo_json.php'
                    " style="width:350px;" value="<?=$tempAsman?>" />
                </td>
            </tr>              
        	<tr>
            	<td>
                    <input type="hidden" name="reqId" value="<?=$reqId?>">
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                	<input type="submit" value="Simpan" /> 
                </td>
            </tr>
        </table>
        </div>
        </form>
        </div>
    </div>
</body>
</html>