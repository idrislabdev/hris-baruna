<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base/PenandaTangan.php");

$penanda_tangan = new PenandaTangan();
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
	$penanda_tangan->selectByParams(array("PENANDA_TANGAN_ID" => $reqId));
	$penanda_tangan->firstRow();
	$tempNama 	= $penanda_tangan->getField("NAMA");
	$tempJabatan = $penanda_tangan->getField("JABATAN");
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
				url:'../json-intranet/penanda_tangan_add.php',
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
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <!-- POPUP WINDOW -->
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
	<script>
		function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
		{
			//var left = (screen.width/2)-(opWidth/2);
			var left=50;
			
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=20,resize=1,scrolling=1,midle=1'); return false;
		}
		    
		function openPencarianUser()
		{
			OpenDHTML('pegawai_penanda_tangan_pencarian.php', 'Pencarian User', 680, 500);	
		}
		
		function OptionSet(id, nrp,nama, jabatan){
			document.getElementById('reqNama').value = nama;
			document.getElementById('reqJabatan').value = jabatan;
		}			

    </script>		    
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Penanda Tangan</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Nama</td>
            <td>
                <input name="reqNama" id="reqNama" class="easyui-validatebox" required title="Nama harus diisi" size="40" type="text" value="<?=$tempNama?>" />&nbsp;&nbsp;
                <img src="../WEB-INF/images/group.png" onClick="openPencarianUser()">
            </td>
        </tr>
        <tr>
            <td>Jabatan</td>

            <td>
                <input name="reqJabatan" id="reqJabatan" class="easyui-validatebox" required title="Jabatan harus diisi" size="40" type="text" value="<?=$tempJabatan?>" />
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