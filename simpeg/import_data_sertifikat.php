<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiSertifikat.php");


//$reqLokasi = httpFilterGet("reqLokasi");
//$reqPeriode = httpFilterGet("reqPeriode");
$reqId = httpFilterGet("reqId");

$pegawai_sertifikat = new PegawaiSertifikat();
$pegawai_sertifikat->selectByParams(array("PEGAWAI_ID" => $reqId));
$pegawai_sertifikat->firstRow();

//$tempLokasi= $pegawai_sertifikat->getField("LOKASI_TERAKHIR");
//$tempNama= $pegawai_sertifikat->getField("KAPAL");
//unset($pegawai_sertifikat);

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
				url:'../json-simpeg/import_data_sertifikat.php',
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
                <span><img src="../WEB-INF/images/panah-judul.png">Import Data Keluarga</span>
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