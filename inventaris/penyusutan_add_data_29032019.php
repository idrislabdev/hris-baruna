<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisPenyusutan.php");
include_once("../WEB-INF/classes/base-inventaris/JenisSusut.php");

$inventaris_penyusutan = new InventarisPenyusutan();
$jenis_susut = new JenisSusut();

$reqId = httpFilterGet("reqId");

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";
	$inventaris_penyusutan->selectByParams(array("INVENTARIS_PENYUSUTAN_ID" => $reqId));
	$inventaris_penyusutan->firstRow();
	
	$tempJenisSusut = $inventaris_penyusutan->getField("JENIS_SUSUT_ID");
	$tempTanggalSusut = dateToPageCheck($inventaris_penyusutan->getField("TANGGAL_SUSUT"));
	$tempKeterangan = $inventaris_penyusutan->getField("KETERANGAN");
	$tempNama = $inventaris_penyusutan->getField("NAMA");
}

$jenis_susut->selectByParams();

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

<script language="Javascript">
<? include_once "../jslib/formHandler.php"; ?>
</script>

<script type="text/javascript">	
$(function(){
	$('#ff').form({
		url:'../json-inventaris/penyusutan_add_data.php',
		onSubmit:function(){
			return $(this).form('validate');
		},
		success:function(data){
			//alert(data);
			data = data.split("-");
			$.messager.alert('Info', data[1], 'info');
			$('#rst_form').click();
			top.frames['mainFrame'].location.reload();
			parent.frames['menuFramePop'].location.href = 'penyusutan_add_menu.php?reqId=' + data[0];
			document.location.href = 'penyusutan_add_data.php?reqId=' + data[0];	
		}
	});
	
});
</script>
</head>

<body class="bg-kanan-full">
	<div id="judul-popup">Tambah Data Pemusnahan</div>
	<div id="konten">
    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
    	<div id="popup-tabel2">
    	<table>
        	<tr>
                <td>Jenis Pemusnahan</td>
                <td>:</td>
                <td>
                <select name="reqJenisSusut">
                <?
                while($jenis_susut->nextRow())
                {
                ?>
                <option value="<?=$jenis_susut->getField("JENIS_SUSUT_ID")?>" <? if($jenis_susut->getField("JENIS_SUSUT_ID") == $tempJenisSusut) echo "selected";?>><?=$jenis_susut->getField("NAMA")?></option>
                <?
                }
                ?>
                </select>
                </td>           
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>
                    <input id="reqNama" name="reqNama" class="easyui-validatebox" required size="50" type="text" value="<?=$tempNama?>" />
                </td>
            </tr>
            <tr>
                <td>Tanggal Susut</td>
                <td>:</td>
                <td>
                <input id="reqTanggalSusut" name="reqTanggalSusut" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalSusut?>" />
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
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <input type="hidden" name="reqId" value="<?=$reqId?>">
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                	<input type="submit" value="Simpan" /> 
                    <input type="reset" value="Reset" />
                </td>
            </tr>
        </table>
        </div>
        </form>
        </div>
    </div>
</body>
</html>