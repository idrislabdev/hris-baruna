<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/Informasi.php");

$informasi = new Informasi();

$reqId = httpFilterGet("reqId");
$tempDepartemen = $userLogin->idDepartemen;

$FILE_DIR = "../main/uploads/informasi/";
$_THUMB_PREFIX = "z__thumb_";

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$informasi->selectByParams(array("INFORMASI_ID" => $reqId));
	$informasi->firstRow();
	$tempDepartemen = $informasi->getField("DEPARTEMEN_ID");
	$tempNama = $informasi->getField("NAMA");
	$tempNamaEnglish = $informasi->getField("NAMA_INGGRIS");
	$tempKeterangan = $informasi->getField("KETERANGAN");
	$tempKeteranganEnglish = $informasi->getField("KETERANGAN_INGGRIS");
	$tempTanggal = ($informasi->getField("TANGGAL_INPUT"));
	$tempLinkFileTemp= $informasi->getField("LINK_FOTO");
	$tempPublish= $informasi->getField("STATUS_PUBLISH");
	$reqIdInformasi = $informasi->getField("INFORMASI_ID_WEBSITE");
	if($tempDepartemen == "")
		$tempDepartemen = "NULL";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Form Tambah Informasi</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		function setValue(){
			$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
		}
		function format_tgl_indonesia(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y;
        }
        function parser_tanggal(s){
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[2],10);
            var m = parseInt(ss[1],10);
            var d = parseInt(ss[0],10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                return new Date(y,m-1,d);
            } else {
                return new Date();
            }
        }	
		$(function(){
			
			$('#ff').form({
				url:'../json-intranet/informasi_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					var temp = data.split('|');
					
					jQuery.support.cors = true;
					var form = document.getElementById('ff');
					var formData = new FormData(form);
					$.ajax({
				     	//url:'http://10.34.7.154/pelindomarine/admin/ws_upload_berita.php',
				     	url:'http://pelindomarine.com/admin/ws_upload_berita.php',
						type:'POST',
						timeout: 30000,
						dataType : 'json',
				        data: formData,
						mimeType:"multipart/form-data",
						contentType: false,
				        cache: false,
				     	processData:false,
						success: function(dataku){
							$.post("../json-intranet/informasi_add.php",{id_informasi:dataku.id_informasi, reqId: temp[1], reqMode:'updateIdWeb'},function(result){
							    alert(result);
						  	});
						},
						error: function(jqXHR, textStatus, errorThrown){
							$.messager.alert('Info', textStatus + ', ' + errorThrown + ', ' + jqXHR.responseText, 'info');
						} 	        
					});
					
					$('#rst_form').click();
					$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>	
				}
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script>    
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Informasi</span>
    </div>
	<?
	if($userLogin->userPublish == 1)
		$link = "../json-intranet/departemen_pusat_combo_json.php?reqDepartemen=".$userLogin->idDepartemen;	
	else
		$link = "../json-intranet/departemen_detil_combo_json.php?reqDepartemen=".$userLogin->idDepartemen;
	?>      
    <form id="ff" method="post" novalidate enctype="multipart/form-data">
    <table>
        <tr>
            <td>Unit Kerja</td>
            <td colspan="2"><input id="cc" class="easyui-combotree"  required="true" name="reqDepartemen" data-options="url:'<?=$link?>'" style="width:300px;"></td>
        </tr>
        <tr>
            <td>Judul</td>
            <td colspan="2">
                <input name="reqNama" style="width:296px;" class="easyui-validatebox" required  type="text" value="<?=$tempNama?>" />
            </td>
        </tr>
        <tr>
            <td>Judul Bahasa Inggris</td>
            <td colspan="2">
                <input name="reqNamaEnglish" style="width:296px;" class="easyui-validatebox" required  type="text" value="<?=$tempNamaEnglish?>" />
            </td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td colspan="2">
				<input id="dd" name="reqTanggal" data-options="formatter:format_tgl_indonesia,parser:parser_tanggal" class="easyui-datebox" required value="<?=$tempTanggal?>">              
            </td>
        </tr>        
        <tr>
            <td>Keterangan</td>
            <td colspan="2">
                <textarea name="reqKeterangan"><?=$tempKeterangan?></textarea>
            </td>
        </tr>
        <tr>
            <td>Keterangan Inggris</td>
            <td colspan="2">
                <textarea name="reqKeteranganEnglish"><?=$tempKeteranganEnglish?></textarea>
            </td>
        </tr>
        <tr>
            <td>Link Foto</td>
            <td width="30%">
               <input type="file" style="width:100px" name="reqLinkFile" id="reqLinkFile" <?=$read?> value="<?=$tempLinkFile?>" />
               <input type="hidden" name="reqLinkFileTemp" value="<?=$tempLinkFileTemp?>" />
               <br />temp : <?=$tempLinkFileTemp?>
            </td>
            <td><img src="<?=$FILE_DIR.$_THUMB_PREFIX.$tempLinkFileTemp?>"></td>
        </tr>
        <tr>
            <td>Publikasikan ke website pelindomarine.com</td>
            <td colspan="2">
                <input id="reqPublish" type="checkbox"  <?php echo (isset($tempPublish) AND $tempPublish == 1) ? 'checked' : ''; ?> name="reqPublish" value="1" />
            </td>
        </tr>    
    </table>
        <div>
            <input type="hidden" name="reqId" id="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqIdInformasi" id="reqIdInformasi" value="<?=$reqIdInformasi?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="hidden" name="reqUser" value="<?=$userLogin->nama; ?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>