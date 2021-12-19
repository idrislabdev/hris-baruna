<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/Premi.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");
include_once("../WEB-INF/classes/base-operasional/KapalJenis.php");
include_once("../WEB-INF/classes/base-operasional/KruJabatan.php");
include_once("../WEB-INF/classes/base-operasional/Lokasi.php");

$premi = new Premi();
$departemen = new Departemen();
$jabatan = new Jabatan();
$kapal_jenis = new KapalJenis();
$kru_jabatan = new KruJabatan();
$lokasi = new Lokasi();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
	$premi->selectByParams(array("PREMI_ID" => $reqId));
	$premi->firstRow();
	
	$tempLokasi = $premi->getField('LOKASI_ID');
	$tempKapalJenis = $premi->getField("KAPAL_JENIS_ID");
	//$tempJabatan = $premi->getField("JABATAN_ID");
	$tempJabatan = $premi->getField("KRU_JABATAN_ID");
	$tempProduksiNormal = $premi->getField("PRODUKSI_NORMAL");
	$tempProduksiMaksimal = $premi->getField("PRODUKSI_MAKSIMAL");
	$tempIntervalProduksi = $premi->getField("INTERVAL_PRODUKSI");
	$tempTarifNormal = $premi->getField("TARIF_NORMAL");
	$tempTarifMaksimal = $premi->getField("TARIF_MAKSIMAL");
}
$departemen->selectByParams();
$jabatan->selectByParams();
$kapal_jenis->selectByParams();
$kru_jabatan->selectByParams();
$lokasi->selectByParams();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../simpeg/js/globalfunction.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-gaji/premi_add.php',
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Premi</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Lokasi</td>
            <td>
            	<select id="reqLokasi" name="reqLokasi">
                	<? while($lokasi->nextRow()){?>
                	<option value="<?=$lokasi->getField('LOKASI_ID')?>" <? if($lokasi->getField('LOKASI_ID') == $tempLokasi) echo 'selected';?>><?=$lokasi->getField('NAMA')?></option>
                    <? }?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Jenis Kapal</td>
            <td>
            	<select id="reqKapalJenis" name="reqKapalJenis">
                	<? while($kapal_jenis->nextRow()){?>
                	<option value="<?=$kapal_jenis->getField('KAPAL_JENIS_ID')?>" <? if($kapal_jenis->getField('KAPAL_JENIS_ID') == $tempKapalJenis) echo 'selected';?>><?=$kapal_jenis->getField('NAMA')?></option>
                    <? }?>
                </select>
            </td>
        </tr> 
        <tr>
            <td>Jabatan</td>
            <td>
            	<select id="reqJabatan" name="reqJabatan">
                	<? while($kru_jabatan->nextRow()){?>
                	<option value="<?=$kru_jabatan->getField('KRU_JABATAN_ID')?>" <? if($kru_jabatan->getField('KRU_JABATAN_ID') == $tempJabatan) echo 'selected';?>><?=$kru_jabatan->getField('NAMA')?></option>
                    <? }?>
                </select>
            </td>
        </tr>                
        <tr>
            <td>Produksi Normal</td>
            <td>
                <input name="reqProduksiNormal" id="reqProduksiNormal" class="easyui-validatebox" required="true" style="width:40px;"  type="text" value="<?=$tempProduksiNormal?>" />
            </td>
        </tr>
        <tr>
            <td>Produksi Maksimal</td>
            <td>
                <input name="reqProduksiMaksimal" id="reqProduksiMaksimal" class="easyui-validatebox" required="true" style="width:40px;" type="text" value="<?=$tempProduksiMaksimal?>" />
            </td>
        </tr>  
        <tr>
            <td>Interval Produksi</td>
            <td>
                <input name="reqIntervalProduksi" id="reqIntervalProduksi" class="easyui-validatebox" required="true" style="width:40px;" type="text" value="<?=$tempIntervalProduksi?>" />
            </td>
        </tr>                
        <tr>
            <td>Tarif Normal</td>
            <td>
				<input name="reqTarifNormal" type="text" id="reqTarifNormal" class="easyui-validatebox"  required="required" style="width:80px;" value="<?=numberToIna($tempTarifNormal)?>"  OnFocus="FormatAngka('reqTarifNormal')" OnKeyUp="FormatUang('reqTarifNormal')" OnBlur="FormatUang('reqTarifNormal')"/>                    
            </td>
        </tr>
        <tr>
            <td>Tarif Maksimal</td>
            <td>
				<input name="reqTarifMaksimal" type="text" id="reqTarifMaksimal" class="easyui-validatebox"  required="required" style="width:80px;" value="<?=numberToIna($tempTarifMaksimal)?>"  OnFocus="FormatAngka('reqTarifMaksimal')" OnKeyUp="FormatUang('reqTarifMaksimal')" OnBlur="FormatUang('reqTarifMaksimal')"/>                    
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

$("#reqProduksiNormal,#reqProduksiMaksimal,#reqIntervalProduksi").keypress(function(e) {
	//alert(e.which);
	if( e.which!=46 && e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>