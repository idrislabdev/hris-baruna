<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/ReportPenandaTangan.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$report_penanda_tangan = new ReportPenandaTangan();

$reqJenisReport = httpFilterGet("reqJenisReport");
$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
$reqPeriode = httpFilterGet("reqPeriode");

	$report_penanda_tangan->selectByParams(array("JENIS_REPORT" => $reqJenisReport));
	$report_penanda_tangan->firstRow();

	$tempNama1= $report_penanda_tangan->getField("NAMA_1");
	$tempJabatan1= $report_penanda_tangan->getField("JABATAN_1");
	$tempNama2= $report_penanda_tangan->getField("NAMA_2");
	$tempJabatan2= $report_penanda_tangan->getField("JABATAN_2");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
			  $('#btnJamsostekPerbantuan').on('click', function () {
			  	newWindow = window.open('daftar_jamsostek_rpt.php?reqJenisPegawaiId=<?=$reqJenisPegawaiId?>&reqPeriode=<?=$reqPeriode?>&reqNama1='+ $("#reqNama1").val()+'&reqJabatan1='+ $("#reqJabatan1").val()+'&reqNama2='+ $("#reqNama2").val()+'&reqJabatan2='+ $("#reqJabatan2").val(), 'Cetak');
				newWindow.focus();
				window.parent.divwin.close();
			  });
			  $('#btnJamsostekOrganik').on('click', function () {
			  	newWindow = window.open('daftar_jamsostek_rpt.php?reqJenisPegawaiId=<?=$reqJenisPegawaiId?>&reqPeriode=<?=$reqPeriode?>&reqNama1='+ $("#reqNama1").val()+'&reqJabatan1='+ $("#reqJabatan1").val()+'&reqNama2='+ $("#reqNama2").val()+'&reqJabatan2='+ $("#reqJabatan2").val(), 'Cetak');
				newWindow.focus();
				window.parent.divwin.close();
			  });			  
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
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
		    
    </script>
</head>
<body onload="setValue()">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Report Penanda Tangan</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Nama (Kiri)</td>
            <td>
                <input id="reqNama1" name="reqNama1" class="easyui-validatebox" size="50" type="text" value="<?=$tempNama1?>" />
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
                <input id="reqNama2" name="reqNama2" class="easyui-validatebox" size="50" type="text" value="<?=$tempNama2?>" />
            </td>
        </tr>
        <tr>
            <td>Jabatan (Tengah)</td>
            <td>
                <input id="reqJabatan2" name="reqJabatan2" class="easyui-validatebox" size="80" type="text" value="<?=$tempJabatan2?>" />
            </td>
        </tr>
    </table>
        <div>
            <?
            	if ($reqJenisPegawaiId == 1)
				{
			?>
            <input type="submit" value="Cetak" id="btnJamsostekPerbantuan">
            <?
				}
				else
				{
			?>
            <input type="submit" value="Cetak" id="btnJamsostekOrganik">
        	<?
				}
			?>
        </div>
    </form>
</div>
</body>
</html>