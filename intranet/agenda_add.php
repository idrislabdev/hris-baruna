<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/Agenda.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$agenda = new Agenda();

$reqId = httpFilterGet("reqId");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$agenda->selectByParams(array("AGENDA_ID" => $reqId));
	$agenda->firstRow();
	$tempDepartemen = $agenda->getField("DEPARTEMEN_ID");
	$tempNama = $agenda->getField("NAMA");
	$tempTanggal = dateTimeToPageCheck($agenda->getField("TANGGAL"));
	$tempKeterangan = $agenda->getField("KETERANGAN");	
	if($tempDepartemen == "")
		$tempDepartemen = "NULL";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender-easyui.js"></script>
	<script type="text/javascript">
		function setValue(){
			$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-intranet/agenda_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
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
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Agenda</span>
    </div>
    <form id="ff" method="post" novalidate>
	<?
	if($userLogin->userPublish == 1)
		$link = "../json-intranet/departemen_pusat_combo_json.php?reqDepartemen=".$userLogin->idDepartemen;	
	else
		$link = "../json-intranet/departemen_detil_combo_json.php?reqDepartemen=".$userLogin->idDepartemen;
	?>
    <table>
        <tr>
            <td>Unit Kerja</td>
            <td><input id="cc" class="easyui-combotree"  required="true" name="reqDepartemen" data-options="url:'<?=$link?>'" style="width:300px;"></td>
        </tr>
        <tr>
            <td>Nama</td>

            <td>
                <input name="reqNama" class="easyui-validatebox" required size="60" type="text" value="<?=$tempNama?>" />
            </td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>
				<input id="dd" name="reqTanggal" class="easyui-datetimebox" data-options="validType:'datetimebox'" required value="<?=$tempTanggal?>"></input>                
            </td>
        </tr>          
        <tr>
            <td>Keterangan</td>

            <td>
                <textarea name="reqKeterangan"><?=$tempKeterangan?></textarea>
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
</body>
</html>