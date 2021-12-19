<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/UserGroup.php");
include_once("../WEB-INF/classes/base/UserLoginBase.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$user_group = new UserGroup();
$user_login = new UserLoginBase();

$reqId = httpFilterGet("reqId");

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$user_login->selectByParams(array("USER_LOGIN_ID" => $reqId));
	$user_login->firstRow();
	$tempDepartemen = $user_login->getField("DEPARTEMEN_ID");
	$tempUserGroup = $user_login->getField("USER_GROUP_ID");
	$tempNama = $user_login->getField("NAMA");
	$tempJabatan = $user_login->getField("JABATAN");	
	$tempEmail = $user_login->getField("EMAIL");	
	$tempTelepon = $user_login->getField("TELEPON");	
	$tempPegawaiId =  $user_login->getField("PEGAWAI_ID");	
	if($tempDepartemen == "")
		$tempDepartemen = "NULL";
}

$user_group->selectByParams();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		function setValue(){
			$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
		}
		$.fn.datebox.defaults.formatter = function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return d+'-'+m+'-'+y;
		}			
		$(function(){
			$('#ff').form({
				url:'../json-intranet/user_login_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					<?php /*?>top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>				<?php */?>	
				}
			});
		});
		function OptionSet(id, nrp,nama, jabatan, email, telepon){
			document.getElementById('reqNama').value = nama;
			document.getElementById('reqJabatan').value = jabatan;
			document.getElementById('reqEmail').value = email;
			document.getElementById('reqTelepon').value = telepon;
			document.getElementById('reqUserLogin').value = nrp;
			document.getElementById('reqUserPassword').value = nrp;			
			document.getElementById('reqPegawaiId').value = id;			
		}		

	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <!-- POPUP WINDOW -->
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
	<script>
		function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
		{
			//var left = (screen.width/2)-(opWidth/2);
			var left=50;
			
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=20,resize=1,scrolling=1,midle=1'); return false;
		}
		    
		function openPencarianUser()
		{
			OpenDHTML('pegawai_pencarian.php', 'Pencarian User', 780, 500);	
		}
	

    </script>
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data User Login</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>User Group</td>
            <td>
            	<select name="reqUserGroup"  required="true">
                <?
                while($user_group->nextRow())
				{
				?>
                	<option value="<?=$user_group->getField("USER_GROUP_ID")?>" <? if($tempUserGroup == $user_group->getField("USER_GROUP_ID")) { ?> selected <? } ?>><?=$user_group->getField("NAMA")?></option>
                <?
				}
				?>	
                </select>
            </td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>
                <input id="reqNama" name="reqNama" class="easyui-validatebox" required size="50" type="text" value="<?=$tempNama?>" />&nbsp;&nbsp;
                <img src="../WEB-INF/images/group.png" onClick="openPencarianUser()">
            </td>
        </tr>
        <?php /*?><tr>
            <td>Departemen</td>
            <td><input id="cc" class="easyui-combotree" required name="reqDepartemen" data-options="url:'../json-intranet/departemen_combo_json.php'" style="width:300px;"></td>
        </tr><?php */?>
        <tr>
            <td>Jabatan</td>
            <td>
                <input id="reqJabatan" name="reqJabatan" size="50" type="text" value="<?=$tempJabatan?>" />
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td>
                <input id="reqEmail" name="reqEmail" data-options="validType:'email'" size="50" type="text" value="<?=$tempEmail?>" />
            </td>
        </tr>
        <tr>
            <td>Telepon</td>
            <td>
                <input id="reqTelepon" name="reqTelepon" size="50" type="text" value="<?=$tempTelepon?>" />
            </td>
        </tr>
        <?
        if($reqMode == "insert")
		{
		?>
        <tr>
            <td>User Login</td>
            <td>
                <input name="reqUserLogin" id="reqUserLogin" class="easyui-validatebox" required size="60" type="text"  />
            </td>
        </tr>
        <tr>
            <td>User Password</td>
            <td>
                <input name="reqUserPassword" id="reqUserPassword" class="easyui-validatebox" required size="60" type="password"  />
            </td>
        </tr>
    	<?
		}
		?>
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqPegawaiId" id="reqPegawaiId" value="<?=$tempPegawaiId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>