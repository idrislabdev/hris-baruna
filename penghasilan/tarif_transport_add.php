<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/TarifTransport.php");

$tarif_transport = new TarifTransport();
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
// echo $reqId;exit();

if($reqMode == "update")
{
	$tarif_transport->selectByParams(array("TARIF_TRANSPORT_ID" => $reqId));
	$tarif_transport->firstRow();
	$tempDepartemen = $tarif_transport->getField("DEPARTEMEN_ID");
	$tempJenisPegawai = $tarif_transport->getField("JENIS_PEGAWAI_ID");	
	$tempNilai = $tarif_transport->getField("NILAI");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-gaji/tarif_transport_add.php',
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Tarif Transport</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Departemen</td>
            <td>
            <input id="reqDepartemenId" class="easyui-combotree" name="reqDepartemenId" data-options="url:'../json-simpeg/departemen_combo_json.php'" style="width:300px;" value="<?=$tempDepartemen?>">
                <!-- <input name="reqKelas" class="easyui-validatebox" required="true" title="Kelas harus diisi" style="width:20px;" type="text" value="<?=$tempKelas?>" /> -->
            </td>
        </tr>
        <tr>
            <td>Jenis Pegawai</td>
            <td>
                <input id="reqJenisPegawai" class="easyui-combotree" name="reqJenisPegawai" data-options="url:'../json-gaji/jenis_pegawai_combo_json.php'" style="width:300px;" value="<?=$tempJenisPegawai?>">
            </td>
        </tr>
        <tr>
            <td>Nilai</td>
            <td>
                <input name="reqNilai" class="easyui-validatebox" required="true" title="Periode harus diisi" style="width:100px;" type="text" value="<?=$tempNilai?>" />
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