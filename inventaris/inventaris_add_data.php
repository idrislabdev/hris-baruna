<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Inventaris.php");

$inventaris = new Inventaris();

$reqId = httpFilterGet("reqId");
$reqLokasiId = httpFilterGet("reqLokasiId");

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$inventaris->selectByParams(array("A.INVENTARIS_ID" => $reqId));
	$inventaris->firstRow();
	
	$tempNama = $inventaris->getField("NAMA");
	$tempJenisInventaris= $inventaris->getField("JENIS_INVENTARIS_ID");
	$tempSpesifikasi= $inventaris->getField("SPESIFIKASI");
	$tempKode= $inventaris->getField("KODE");
	$tempUkuran= $inventaris->getField("UKURAN");
	$tempTipe = $inventaris->getField("TIPE");
	$reqUmurEkonomis = $inventaris->getField("UMUR_EKONOMIS_INVENTARIS");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/globalfunction.js"></script>
	<script type="text/javascript">
	function setValue(){
		$('#reqJenisInventaris').combotree('setValue', '<?=$tempJenisInventaris?>');
	}

	$.fn.datebox.defaults.formatter = function(date){
		var y = date.getFullYear();
		var m = date.getMonth()+1;
		var d = date.getDate();
		return d+'-'+m+'-'+y;
	}		
	$(function(){
		$('#ff').form({
			url:'../json-inventaris/inventaris_add.php',
			onSubmit:function(){
				return $(this).form('validate');
			},
			success:function(data){
				$.messager.alert('Info', data, 'info');
				top.frames['mainFrame'].location.reload();		
				<?
				if(!empty($reqLokasiId))
				{
				?>
				window.parent.frames['mainFramePop'].location.href = 'pendataan_add_monitoring.php?reqId=<?=$reqLokasiId?>';								
				<?
				}
				?>
			}
		});
		
	});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <!--<script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script> -->

<style type="text/css">
div.message{
background: transparent url(msg_arrow.gif) no-repeat scroll bottom left;
padding-bottom: 5px;
}

div.error{
background-color:#F3E6E6;
border-color: #924949;
/*border-style: solid solid solid none;*/
border-style: solid solid solid solid;
border-width: 1px;
padding: 5px;
}
.combo span{
	width:300px !important;	
}
</style>
</head>
     
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Asset</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        	<tr style="display:none">
                <td>Kode</td>
                <td>:</td>
                <td>
                    <input name="reqKode" class="easyui-validatebox"  title="Kode harus diisi" style="width:300px;" type="text" value="<?=$tempKode?>" />
                </td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>
                    <input name="reqNama" class="easyui-validatebox" required title="Nama harus diisi" style="width:300px;" type="text" value="<?=$tempNama?>" />
                </td>
            </tr>
            <tr>
                <td>Jenis Asset</td>
                <td>:</td>
                <td>
                	<input id="reqJenisInventaris" name="reqJenisInventaris" required class="easyui-combotree" data-options="url:'../json-inventaris/jenis_inventaris_combo_json.php'" style="width:500px;" value="<?=$tempJenisInventaris?>" />
                </td>
            </tr> 
            <tr>
                <td>Spesifikasi</td>
                <td>:</td>
                <td>
                    <input name="reqSpesifikasi" class="easyui-validatebox" style="width:300px;" type="text" value="<?=$tempSpesifikasi?>" />
                </td>
            </tr>
            <tr>
                <td>Umur Ekonomis / Sisa Umur</td>
                <td>:</td>
                <td>
                    <input name="reqUmurEkonomis" type="text" id="reqUmurEkonomis" class="easyui-validatebox" size="10" value="<?=numberToIna($reqUmurEkonomis)?>"  OnFocus="FormatAngka('reqUmurEkonomis')" OnKeyUp="FormatUang('reqUmurEkonomis')" OnBlur="FormatUang('reqUmurEkonomis')"/>
                </td>
            </tr>
        	<tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <input type="hidden" name="reqId" value="<?=$reqId?>">
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                	<input type="submit" name="" value="Simpan" /> 
                    <input type="reset" id="rst_form" value="Reset" />
                </td>
            </tr>   
        </table>
    </form>
</div>
</body>
</html>