<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/ReportPenandaTangan.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$report_penanda_tangan = new ReportPenandaTangan();

$reqId = httpFilterGet("reqId");

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$report_penanda_tangan->selectByParams(array("REPORT_PENANDA_TANGAN_ID" => $reqId));
	$report_penanda_tangan->firstRow();

	$tempJenisReport= $report_penanda_tangan->getField("JENIS_REPORT");
	$tempNama1= $report_penanda_tangan->getField("NAMA_1");
	$tempJabatan1= $report_penanda_tangan->getField("JABATAN_1");
	$tempNama2= $report_penanda_tangan->getField("NAMA_2");
	$tempJabatan2= $report_penanda_tangan->getField("JABATAN_2");
	$tempNama3= $report_penanda_tangan->getField("NAMA_3");
	$tempJabatan3= $report_penanda_tangan->getField("JABATAN_3");
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
			$('#reqUserLogin').combogrid('setValues', [<?=$tempUserLoginId?>]);
		}
		$(function(){
			$('#ff').form({
				url:'../json-intranet/report_penanda_tangan_add.php',
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
		function openPencarianUser(index)
		{
			OpenDHTML('pegawai_report_penanda_tangan_pencarian.php?reqIndex='+index, 'Pencarian User', 680, 500);	
		}
		
		function OptionSet(id,nama, jabatan, index){
			document.getElementById('reqNama'+index).value = nama;
			document.getElementById('reqJabatan'+index).value = jabatan;
		}			
		    
    </script>
</head>
<body onload="setValue()">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Report Penanda Tangan</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
    	<tr>
            <td>Jenis Report</td>
            <td>
                <input id="reqJenisReport" name="reqJenisReport" class="easyui-validatebox" size="50" type="text" value="<?=$tempJenisReport?>" readonly required />
            </td>
        </tr>
        <tr>
            <td>Nama (Kiri)</td>
            <td>
                <input id="reqNama1" name="reqNama1" class="easyui-validatebox" size="50" type="text" value="<?=$tempNama1?>" />&nbsp;&nbsp;
                <img src="../WEB-INF/images/group.png" onClick="openPencarianUser('1')">
            </td>
        </tr>
        <tr>
            <td>Jabatan (Kiri)</td>
            <td>
                <input id="reqJabatan1" name="reqJabatan1" class="easyui-validatebox" size="80" type="text" value="<?=$tempJabatan1?>" />
            </td>
        </tr>
        <tr>
            <td>Nama (Tengah)</td>
            <td>
                <input id="reqNama2" name="reqNama2" class="easyui-validatebox" size="50" type="text" value="<?=$tempNama2?>" />&nbsp;&nbsp;
                <img src="../WEB-INF/images/group.png" onClick="openPencarianUser('2')">
            </td>
        </tr>
        <tr>
            <td>Jabatan (Tengah)</td>
            <td>
                <input id="reqJabatan2" name="reqJabatan2" class="easyui-validatebox" size="80" type="text" value="<?=$tempJabatan2?>" />
            </td>
        </tr>
        <tr>
            <td>Nama (Kanan)</td>
            <td>
                <input id="reqNama3" name="reqNama3" class="easyui-validatebox" size="50" type="text" value="<?=$tempNama3?>" />&nbsp;&nbsp;
                <img src="../WEB-INF/images/group.png" onClick="openPencarianUser('3')">
            </td>
        </tr>
        <tr>
            <td>Jabatan (Kanan)</td>
            <td>
                <input id="reqJabatan3" name="reqJabatan3" class="easyui-validatebox" size="80" type="text" value="<?=$tempJabatan3?>" />
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
<script>
$("#reqKirim").keypress(function(e) {
	if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});

</script>

</body>
</html>