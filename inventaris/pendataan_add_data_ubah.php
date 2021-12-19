<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");

$inventaris_ruangan = new InventarisRuangan();

$reqMode = httpFilterGet("reqMode");
$reqRowId = httpFilterGet("reqRowId");
$reqId = httpFilterGet("reqId");
$reqInventarisId = httpFilterGet("reqInventarisId");
$reqInventarisNama = httpFilterGet("reqInventarisNama");

if($reqMode == "update")
{
	$inventaris_ruangan->selectByParams(array("A.INVENTARIS_RUANGAN_ID" => $reqRowId));
	$inventaris_ruangan->firstRow();
	
	$tempPerolehanHarga= $inventaris_ruangan->getField("PEROLEHAN_HARGA"); 
	$tempNoInvoice= $inventaris_ruangan->getField("NO_INVOICE"); 
	$tempNomor= $inventaris_ruangan->getField("NOMOR"); 
	$tempKondisiFisikProsentase= $inventaris_ruangan->getField("KONDISI_FISIK_PROSENTASE"); 
	$tempKeterangan= $inventaris_ruangan->getField("KETERANGAN");
	$tempLokasiId= $inventaris_ruangan->getField("LOKASI_ID");
	$tempInventarisId= $inventaris_ruangan->getField("INVENTARIS_ID");
	$tempPerolehan= dateToPageCheck($inventaris_ruangan->getField("PEROLEHAN_TANGGAL"));
	$tempLinkFileTemp 	= $inventaris_ruangan->getField('FILE_GAMBAR');
}
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
		url:'../json-inventaris/pendataan_add_data_ubah.php',
		onSubmit:function(){
			return $(this).form('validate');
		},
		success:function(data){
			//alert(data);
			data = data.split("-");
			$.messager.alert('Info', data[1], 'info');
			$('#rst_form').click();
			window.parent.frames['mainFrameDetilPop'].location.href = 'pendataan_add_data.php?reqId=<?=$reqId?>&reqInventarisId=<?=$reqInventarisId?>&reqInventarisNama=<?=$reqInventarisNama?>';
			window.parent.divwin.close();
		}
	});
});
</script>
</head>

<body class="bg-kanan-full">
	<div id="judul-popup">Ubah Data Pendataan Detil</div>
	<div id="konten">
    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
    	<div id="popup-tabel2">
    	<table>
        	<tr>
                <td>Kode</td>
                <td>:</td>
                <td>
                    <input name="reqNomor" class="easyui-validatebox" required title="Nomor harus diisi" readonly  style="width:300px;" type="text" value="<?=$tempNomor?>" />
                </td>
            </tr>
            <tr>
                <td>No Invoice</td>
                <td>:</td>
                <td>
                    <input name="reqNoInvoice" class="easyui-validatebox" required title="Invoice harus diisi"  style="width:300px;" type="text" value="<?=$tempNoInvoice?>" />
                </td>
            </tr>
            <tr>
                <td>Perolehan Harga</td>
                <td>:</td>
                <td>
                    <input name="reqPerolehanHarga" type="text" id="reqPerolehanHarga" class="easyui-validatebox" size="10" value="<?=numberToIna($tempPerolehanHarga)?>"  OnFocus="FormatAngka('reqPerolehanHarga')" OnKeyUp="FormatUang('reqPerolehanHarga')" OnBlur="FormatUang('reqPerolehanHarga')"/>
                </td>
            </tr>
            <tr>
                <td>Tanggal Perolehan</td>
                <td>:</td>
                <td>
                    <input id="reqPerolehan" name="reqPerolehan" class="easyui-datebox" required data-options="validType:'date'" value="<?=$tempPerolehan?>"/>
                </td>
            </tr>
            <tr>
                <td>Kondisi Fisik Prosentase</td>
                <td>:</td>
                <td>
                    <input name="reqKondisiFisikProsentase" id="reqKondisiFisikProsentase" class="easyui-validatebox" style="width:100px;" type="text" value="<?=$tempKondisiFisikProsentase?>" />
                </td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td>
                     <textarea name="reqKeterangan" style="width:250px; height:10 0px;"><?=$tempKeterangan?></textarea>
                </td>
            </tr> 
            <tr>
            	<td>Gambar</td>
                <td>:</td>
                <td>
                   	<input type="file" style="width:150px" name="reqLinkFile" id="reqLinkFile" value="<?=$tempLinkFile?>" />
                   	<input type="hidden" name="reqLinkFileTemp" value="<?=$tempLinkFileTemp?>" /> 
                    <br />temp : <label id="idImageNama"><?=$tempLinkFileTemp?></label>
                 </td>
            </tr>                  
        	<tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <input type="hidden" name="reqRowId" value="<?=$reqRowId?>">
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