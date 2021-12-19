<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/InventarisRuangan.php");

$inventaris_ruangan = new InventarisRuangan();

$reqMode = httpFilterGet("reqMode");
$reqRowId = httpFilterGet("reqRowId");
$reqId = httpFilterGet("reqId");
$reqInventarisId = httpFilterGet("reqInventarisId");
$reqInventarisNama = httpFilterGet("reqInventarisNama");

$inventaris_ruangan->selectByParams(array("A.INVENTARIS_RUANGAN_ID" => $reqRowId));
$inventaris_ruangan->firstRow();

$tempPerolehanHarga= $inventaris_ruangan->getField("PEROLEHAN_HARGA"); 
$tempNomor= $inventaris_ruangan->getField("NOMOR"); 
$tempKondisiFisikProsentase= $inventaris_ruangan->getField("KONDISI_FISIK_PROSENTASE"); 
$tempKeterangan= $inventaris_ruangan->getField("KETERANGAN");
$tempLokasiId= $inventaris_ruangan->getField("LOKASI_ID");
$tempInventarisId= $inventaris_ruangan->getField("INVENTARIS_ID");
$tempPerolehan= $inventaris_ruangan->getField("PEROLEHAN_PERIODE");
$tempTahun= $inventaris_ruangan->getField("PEROLEHAN_TAHUN");
$tempLokasiKeterangan = $inventaris_ruangan->getField("LOKASI_KETERANGAN");
$tempPenanggungJawab = $inventaris_ruangan->getField("PEGAWAI");
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
		url:'../json-operasional/pendataan_add_data_pindah.php',
		onSubmit:function(){
			return $(this).form('validate');
		},
		success:function(data){
			window.parent.frames['mainFramePop'].location.href = 'pendataan_add_monitoring.php?reqId=<?=$reqId?>';	
			window.parent.frames['mainFrameDetilPop'].location.href = 'pendataan_add_data.php?reqId=<?=$reqId?>&reqInventarisId=<?=$reqInventarisId?>&reqInventarisNama=<?=$reqInventarisNama?>';
			window.parent.divwin.close();
		}
	});
});
</script>
</head>

<body class="bg-kanan-full">
	<div id="judul-popup">Pemindahan Inventaris</div>
	<div id="konten">
    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
    	<div id="popup-tabel2">
    	<table>
        	<tr>
                <td style="width:200px;">Nomor</td>
                <td>:</td>
                <td>
                    <?=$tempNomor?>
                </td>
            </tr>
            <tr>
                <td>Perolehan Harga</td>
                <td>:</td>
                <td>
                    <?=numberToIna($tempPerolehanHarga)?>
                </td>
            </tr>
            <tr>
                <td>Perolehan Periode</td>
                <td>:</td>
                <td>
                    <?=getNamePeriode($tempPerolehan)?>
                </td>
            </tr>
            <tr>
                <td>Kondisi Fisik</td>
                <td>:</td>
                <td>
                    <?=$tempKondisiFisikProsentase?> %
                </td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td>
                     <?=$tempKeterangan?>
                </td>
            </tr>  
            <tr>
                <td>Lokasi Sebelumnya</td>
                <td>:</td>
                <td>
                     <?=$tempLokasiKeterangan?>
                </td>
            </tr>  
            <tr>
                <td>Penanggungjawab Sebelumnya</td>
                <td>:</td>
                <td>
                     <?=$tempPenanggungJawab?>
                </td>
            </tr>  
            <tr>
                <td>Lokasi Baru</td>
                <td>:</td>
                <td>
                   <input id="cc" class="easyui-combotree" name="reqLokasiBaru" required data-options="url:'../json-inventaris/lokasi_combo_json.php'" style="width:350px;">	 
                </td>
            </tr>      
            <tr>
                <td>Penanggung Jawab</td>
                <td>:</td>
                <td>
                    <input id="reqPenanggungJawab" name="reqPenanggungJawab" class="easyui-combobox" required 
                    data-options="
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url:'../json-inventaris/pegawai_combo_json.php'
                    " style="width:350px;" />
                </td>
            </tr>      
            <tr>
                <td>TMT</td>
                <td>:</td>
                <td>
                    <input id="reqTMT" name="reqTMT" class="easyui-datebox" required data-options="validType:'date'"/>
                </td>           
            </tr>                   
        	<tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <input type="hidden" name="reqId" value="<?=$reqRowId?>">
                    <input type="hidden" name="reqInventaris" value="<?=$tempInventarisId?>">
                    <input type="hidden" name="reqTahun" value="<?=$tempTahun?>">
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                	<input type="submit" value="Simpan" /> 
                    <input type="reset" value="Reset" />
                </td>
            </tr>
        </table>
        </div>
        </form>
        </div>
		<script>
		$("#reqPerolehanHarga").keypress(function(e) {
			//alert(e.which);
			if( e.which!=46 && e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
			{
			return false;
			}
		});
		
		$("#reqKondisiFisikProsentase").keypress(function(e) {
			if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
			{
			return false;
			}
		});
        </script>
    </div>
</body>
</html>