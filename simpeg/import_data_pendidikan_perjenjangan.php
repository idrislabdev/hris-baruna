<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikanPerjenjangan.php");


//$reqLokasi = httpFilterGet("reqLokasi");
//$reqPeriode = httpFilterGet("reqPeriode");
$reqId = httpFilterGet("reqId");

$pegawai_pendidikan_perjenjangan = new PegawaiPendidikanPerjenjangan();
$pegawai_pendidikan_perjenjangan->selectByParams(array("PEGAWAI_ID" => $reqId));
$pegawai_pendidikan_perjenjangan->firstRow();

//$tempLokasi= $pegawai_pendidikan_perjenjangan->getField("LOKASI_TERAKHIR");
//$tempNama= $pegawai_pendidikan_perjenjangan->getField("KAPAL");
//unset($pegawai_pendidikan_perjenjangan);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
     <script type="text/javascript" src="../WEB-INF/js/globalfunction.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-simpeg/import_data_pendidikan_perjenjangan.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					<?php /*?><? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?><?php */?>
				}
			});
		});
		/*
		function callExcel()
		{
			newWindow = window.open('realisasi_produksi_add_data_import_cns_contoh_excel.php?reqId=<?=$reqId?>&reqPeriode=<?=$reqPeriode?>&reqLokasi=<?=$reqLokasi?>', 'Cetak');
			newWindow.focus();
		}
		*/
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Import Data Pendidikan Perjenjangan</span>
    </div>
    <form id="ff" method="post" enctype="multipart/form-data" novalidate>
    <table>
        <tr>
            <td>Silakan Pilih File Excel</td>
            <td>
            	<input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
        		<input type="file" name="reqLinkFile" id="reqLinkFile" />
            </td>
        </tr>
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>