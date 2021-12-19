<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/PotonganKondisi.php");

$potongan_kondisi = new PotonganKondisi();
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
	$potongan_kondisi->selectByParams(array("POTONGAN_KONDISI_ID" => $reqId));
	$potongan_kondisi->firstRow();
    $tempNama       = $potongan_kondisi->getField("NAMA");
	$tempStatusImport 		= $potongan_kondisi->getField("STATUS_IMPORT");
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
		$(function(){
			$('#ff').form({
				url:'../json-gaji/potongan_kondisi_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
				}
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Potongan Kondisi</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Nama</td>
            <td>
                <input name="reqNama" class="easyui-validatebox" required="true" title="Nama harus diisi" size="40" type="text" value="<?=$tempNama?>" />
            </td>
        </tr>
        <tr>
            <td>Status Import</td>
            <td>
                <input type="checkbox" <? if($tempStatusImport == '1') echo 'checked'; ?> name="reqStatusImport" value="1" />
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
</body>
</html>