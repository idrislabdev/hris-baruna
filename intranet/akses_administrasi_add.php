<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/Menu.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$menu = new Menu();

$reqMenuGroupId = httpFilterGet("reqMenuGroupId");
$reqAksesIntranet = httpFilterGet("reqAksesIntranet");
$reqTable = httpFilterGet("reqTable");

if($reqAksesIntranet == "")
	$reqMode = "insert";
else
	$reqMode = "update";


$tempDepartemen = $userLogin->idDepartemen;

$menu->selectByParams(array("MENU_GROUP_ID" => $reqMenuGroupId), -1, -1, "", $reqAksesIntranet, $reqTable);
//echo $menu->query;
$i=0;
while($menu->nextRow())
{
	$arrMenu[$i]["MENU_PARENT_ID"] = $menu->getField("MENU_PARENT_ID");
	$arrMenu[$i]["MENU_ID"] = $menu->getField("MENU_ID");
	$arrMenu[$i]["NAMA"] = $menu->getField("NAMA");
	$arrMenu[$i]["AKSES"] = $menu->getField("AKSES");
	if($reqTable == "AKSES_APP_KEUANGAN")
		$arrMenu[$i]["MENU"] = $menu->getField("MENU_LENGKAP");
	else
		$arrMenu[$i]["MENU"] = $menu->getField("MENU");
		
	$i++;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		
		$(function(){
			$('#ff').form({
				url:'../json-intranet/akses_administrasi_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					parent.location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
				}
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script>    
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Administrasi Akses</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Nama</td>
            <td>
                <input name="reqNama" class="easyui-validatebox" required="true" size="40" type="text" value="<?=$arrMenu[0]["NAMA"]?>" />
            </td>
        </tr>
		<?
	        for($i=0;$i<count($arrMenu);$i++)
            {
				if($arrMenu[$i]["MENU_PARENT_ID"] == 0)
				{
        ?>       
        		<tr>
                	<td colspan="2" style="background-color:#CCC"><?=$arrMenu[$i]["MENU"]?></td>
                </tr>
        <?
				}
				else
				{
		?> 
                <tr>
                    <td><?=$arrMenu[$i]["MENU"]?></td>
                    <td>
                        <input type="radio" <? if($arrMenu[$i]["AKSES"] == 'A') echo 'checked'; else echo 'checked'; ?> name="reqCheck<?=$i?>" value="A" onClick="document.getElementById('reqCheck<?=$i?>').value = 'A'" /> All &nbsp;&nbsp;&nbsp;
                        <input type="radio" <? if($arrMenu[$i]["AKSES"] == 'R') echo 'checked';?> name="reqCheck<?=$i?>" value="R" onClick="document.getElementById('reqCheck<?=$i?>').value = 'R'" /> Readonly &nbsp;&nbsp;&nbsp;
                        <input type="radio" <? if($arrMenu[$i]["AKSES"] == 'D') echo 'checked';?> name="reqCheck<?=$i?>" value="D" onClick="document.getElementById('reqCheck<?=$i?>').value = 'D'" /> Disabled
                        <input type="hidden" name="reqMenuId[]" value="<?=$arrMenu[$i]["MENU_ID"]?>">
                        <input type="hidden" name="reqCheck[]" id="reqCheck<?=$i?>" value="<?=$arrMenu[$i]["AKSES"]?>">
                    </td>        
                </tr>
		<?
				}
	        }
        ?>    
    </table>
        <div>
            <input type="hidden" name="reqAksesIntranet" value="<?=$reqAksesIntranet?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="hidden" name="reqTable" value="<?=$reqTable?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>