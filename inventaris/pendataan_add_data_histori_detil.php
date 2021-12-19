<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqId = httpFilterGet("reqId");
$reqLokasiId = httpFilterGet("reqLokasiId");
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
<script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>

<script type="text/javascript">		
$(function(){
	$('#ff').form({
		url:'../json-operasional/pendataan_add_data_histori_detil.php',
		onSubmit:function(){
			return $(this).form('validate');
		},
		success:function(data){
			//alert(data);
			//$.messager.alert('Info', data, 'info');	
			data = data.split("-");
			$.messager.alert('Info', data[1], 'info');
			$('#rst_form').click();
			parent.frames['mainFramePop'].location.href = 'pendataan_add_data_histori_monitoring.php?reqId=' + data[0];
			parent.reloadParent();
			document.location.href = 'pendataan_add_data_histori_detil.php?reqLokasiId=<?=$reqLokasiId?>&reqId=' + data[0];	
		}
	});
	
});
</script>
</head>

<body class="bg-kanan-bawah">
    <form id="ff" method="post" enctype="multipart/form-data">
	<div id="bar-popup"><input type="submit" name="reqSubmit" id="btnSubmit" value="Simpan"></div>
	<div id="konten">
    	<div id="popup-tabel2">
    	<table>
        	<tr>
                <td>Penanggung Jawab</td>
                <td>
                    <input id="reqPenanggungJawab" name="reqPenanggungJawab" class="easyui-combobox"  
                    data-options="
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url:'../json-inventaris/pegawai_combo_json.php'
                    " style="width:350px;" />
                </td>
            </tr>      
            <tr>
                <td>TMT</td>
                <td>
                    <input id="dd" name="reqTanggal" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggal?>"></input>
                </td>
            </tr>
        </table>    
        <div style="display:none">
        	<input type="hidden" name="reqRowId" value="<?=$tempRowId?>">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqLokasiId" value="<?=$reqLokasiId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
            <input type="reset" id="rst_form">
        </div>  
        </div>
    </div>
    </form>
</body>
</html>