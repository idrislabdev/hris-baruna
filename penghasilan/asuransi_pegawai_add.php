<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/AsuransiPegawai.php");
include_once("../WEB-INF/classes/base-gaji/Asuransi.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

$asuransi_pegawai = new AsuransiPegawai();
$pegawai= new Pegawai();
$asuransi = new Asuransi();

$pegawai->selectByParams(array("A.PEGAWAI_ID" => $reqId));
$pegawai->firstRow();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");


$asuransi_pegawai->selectByParams(array("PEGAWAI_ID" => $reqId));
$asuransi_pegawai->firstRow();
$tempAsuransiId = $asuransi_pegawai->getField('ASURANSI_ID');
$tempJumlah = $asuransi_pegawai->getField("JUMLAH");

if($tempAsuransiId=="")
	$reqMode = "insert";
else
	$reqMode = "update";
	
$asuransi->selectByParams();
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
		function setValue(){
			$('#ccJabatan').combotree('setValue', '<?=$tempAsuransiId?>');
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-gaji/asuransi_pegawai_add.php',
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
		<span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Asuransi Pegawai</span>
    </div>
    
    <div class="data-foto-table">
        <div class="data-foto">
            <div class="data-foto-img">
                <img src="../simpeg/image_script.php?reqPegawaiId=<?=$reqId?>&reqMode=pegawai" width="60" height="77">
            </div>
            
            <div class="data-foto-ket">
            	<div style="font-size:18px;"><?=$pegawai->getField("NAMA")?> <br>(<?=$pegawai->getField("NRP")?>)</div>
            	<div style="font-size:15px; line-height:20px;"><?=$pegawai->getField("JABATAN_NAMA")?></div>
                <div style="font-size:14px; line-height:20px;">Kelas : <?=$pegawai->getField("KELAS")?></div>
                <div style="font-size:14px; line-height:20px;">NPWP : <?=$pegawai->getField("NPWP")?></div>
            </div>
    
        </div>
        
        <div class="data-table">
    
            <form id="ff" method="post" novalidate>
            <table>
                <tr>
                    <td>Asuransi</td>
                    <td>
                        <select id="reqAsuransiId" name="reqAsuransiId">
                        <? while($asuransi->nextRow()){?>
                            <option value="<?=$asuransi->getField('ASURANSI_ID')?>" <? if($tempAsuransiId == $asuransi->getField('ASURANSI_ID')) echo 'selected';?>><?=$asuransi->getField('NAMA')?></option>
                        <? }?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>
                        <input name="reqJumlah" class="easyui-validatebox" required title="Jumlah harus diisi" style="width:150px;" type="text" value="<?=numberToIna($tempJumlah)?>" id="reqJumlah"  OnFocus="FormatAngka('reqJumlah')" OnKeyUp="FormatUang('reqJumlah')" OnBlur="FormatUang('reqJumlah')"  />
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
    </div><!-- END DATA FOTO TABLE -->
</div>
<script>

$("#reqNama").keypress(function(e) {
	//alert(e.which);
	if( e.which!=46 && e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>