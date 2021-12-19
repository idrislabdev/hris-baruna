<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/AksesAdmIntranet.php");
include_once("../WEB-INF/classes/base/AksesAdmWebsite.php");
include_once("../WEB-INF/classes/base/AksesAppBackup.php");
include_once("../WEB-INF/classes/base/AksesAppDatabase.php");
include_once("../WEB-INF/classes/base/AksesAppKepegawaian.php");
include_once("../WEB-INF/classes/base/AksesAppOperasional.php");
include_once("../WEB-INF/classes/base/AksesAppPenghasilan.php");
include_once("../WEB-INF/classes/base/AksesAppPenilaian.php");
include_once("../WEB-INF/classes/base/AksesAppPresensi.php");
include_once("../WEB-INF/classes/base/UserGroup.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$user_group = new UserGroup();
$akses_adm_intranet = new AksesAdmIntranet();
$akses_adm_website = new AksesAdmWebsite();
$akses_app_backup = new AksesAppBackup();
$akses_app_database = new AksesAppDatabase();
$akses_app_kepegawaian = new AksesAppKepegawaian();
$akses_app_operasional = new AksesAppOperasional();
$akses_app_penghasilan = new AksesAppPenghasilan();
$akses_app_penilaian = new AksesAppPenilaian();
$akses_app_presensi = new AksesAppPresensi();
$reqId = httpFilterGet("reqId");

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$user_group->selectByParams(array("USER_GROUP_ID" => $reqId));
	$user_group->firstRow();
	$tempNama = $user_group->getField("NAMA");
	$tempAksesIntranet = $user_group->getField("AKSES_ADM_INTRANET_ID");
	$tempAksesDatabase = $user_group->getField("AKSES_APP_DATABASE_ID");
	$tempAksesWebsite = $user_group->getField("AKSES_ADM_WEBSITE_ID");
	$tempAksesBackup = $user_group->getField("AKSES_APP_BACKUP_ID");
	$tempAksesKepegawaian = $user_group->getField("AKSES_APP_KEPEGAWAIAN_ID");
	$tempAksesOperasional = $user_group->getField("AKSES_APP_OPERASIONAL_ID");
	$tempAksesPenghasilan = $user_group->getField("AKSES_APP_PENGHASILAN_ID");
	$tempAksesPenilaian = $user_group->getField("AKSES_APP_PENILAIAN_ID");
	$tempAksesPresensi = $user_group->getField("AKSES_APP_PRESENSI_ID");
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
				url:'../json-intranet/user_group_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					//parent.location.reload();
					<?php /*?><? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?><?php */?>					
				}
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script> 
    
    <!-- POPUP WINDOW -->
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
    <script language="javascript">
    function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
    {
        var left = 50;
        
        divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=20,resize=1,scrolling=1,midle=1'); return false;
    }
    </script>       
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

<div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data User Group</span>
</div>

<div style="padding:5px 5px 5px 15px">
    <form id="ff" method="post" novalidate>
        <table>
        <tr>
            <td>Nama</td>
            <td>
                <input name="reqNama" class="easyui-validatebox" required size="40" type="text" value="<?=$tempNama?>" />
            </td>
        </tr>        
            <tr>
                <td>Akses Intranet</td>
                <td>
                  <select name="reqAksesIntranet" id="reqAksesIntranet" class="required" title="Akses Intranet harus dipilih" />
                  			<option value="NULL">-- Pilih Nama Group Akses --</option>
						<? 
	                        $akses_adm_intranet->selectByParams(array());
    		                while($akses_adm_intranet->nextRow()){
                        ?>
                          	<option value="<?=$akses_adm_intranet->getField("AKSES_ADM_INTRANET_ID")?>" <? if($akses_adm_intranet->getField("AKSES_ADM_INTRANET_ID") == $tempAksesIntranet) echo "selected"; ?>><?=$akses_adm_intranet->getField("NAMA")?></option>
                        <?
                          	}
                        ?>
				  </select> 
                  <a href="#" onClick="OpenDHTML('akses_adm_intranet_add.php', 'Office Management - Administrasi Intranet', 450,500);" ><img src="images/tree-add.png" width="15" height="15"/></a>		                
                  <a href="#" onClick="OpenDHTML('akses_adm_intranet_add.php?reqAksesIntranet='+$('#reqAksesIntranet').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="images/tree-edit.png" width="15" height="15"/></a>		                
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Database</td>
                <td>
                    <select name="reqAplikasiDatabase" class="required" title="Akses Aplikasi Database harus dipilih" />
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_database->selectByParams();
							while($akses_app_database->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_database->getField("AKSES_APP_DATABASE_ID")?>" <? if($akses_app_database->getField("AKSES_APP_DATABASE_ID") == $tempAksesDatabase) echo "selected"; ?>><?=$akses_app_database->getField("NAMA")?></option>                        
                        <?
							}
						?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Operasional</td>
                <td>
                    <select name="reqAplikasiOperasional" class="required" title="Akses Aplikasi Operasional harus dipilih" />
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_operasional->selectByParams();
							while($akses_app_operasional->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_operasional->getField("AKSES_APP_OPERASIONAL_ID")?>" <? if($akses_app_operasional->getField("AKSES_APP_OPERASIONAL_ID") == $tempAksesOperasional) echo "selected"; ?>><?=$akses_app_operasional->getField("NAMA")?></option>                        
                        <?
							}
						?>                        
                    </select>
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Kepegawaian</td>
                <td>
                    <select name="reqAplikasiKepegawaian" class="required" title="Akses Aplikasi Kepegawaian harus dipilih" />
                       <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_kepegawaian->selectByParams();
							while($akses_app_kepegawaian->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_kepegawaian->getField("AKSES_APP_KEPEGAWAIAN_ID")?>" <? if($akses_app_kepegawaian->getField("AKSES_APP_KEPEGAWAIAN_ID") == $tempAksesKepegawaian) echo "selected"; ?>><?=$akses_app_kepegawaian->getField("NAMA")?></option>                        
                        <?
							}
						?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Penghasilan</td>
                <td>
                    <select name="reqAplikasiPenghasilan" class="required" title="Akses Aplikasi Penghasilan  harus dipilih" />
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_penghasilan->selectByParams();
							while($akses_app_penghasilan->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_penghasilan->getField("AKSES_APP_PENGHASILAN_ID")?>" <? if($akses_app_penghasilan->getField("AKSES_APP_PENGHASILAN_ID") == $tempAksesPenghasilan) echo "selected"; ?>><?=$akses_app_penghasilan->getField("NAMA")?></option>                        
                        <?
							}
						?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Presensi</td>
                <td>
                    <select name="reqAplikasiPresensi" class="required" title="Akses Aplikasi Presensi harus dipilih" />
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_presensi->selectByParams();
							while($akses_app_presensi->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_presensi->getField("AKSES_APP_PRESENSI_ID")?>" <? if($akses_app_presensi->getField("AKSES_APP_PRESENSI_ID") == $tempAksesPresensi) echo "selected"; ?>><?=$akses_app_presensi->getField("NAMA")?></option>                        
                        <?
							}
						?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Penilaian</td>
                <td>
                    <select name="reqAplikasiPenilaian" class="required" title="Akses Aplikasi Penilaian harus dipilih" />
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_penilaian->selectByParams();
							while($akses_app_penilaian->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_penilaian->getField("AKSES_APP_PENILAIAN_ID")?>" <? if($akses_app_penilaian->getField("AKSES_APP_PENILAIAN_ID") == $tempAksesPenilaian) echo "selected"; ?>><?=$akses_app_penilaian->getField("NAMA")?></option>                        
                        <?
							}
						?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Backup</td>
                <td>
                    <select name="reqAplikasiBackup" class="required" title="Akses Aplikasi Backup harus dipilih" />
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_backup->selectByParams();
							while($akses_app_backup->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_backup->getField("AKSES_APP_BACKUP_ID")?>" <? if($akses_app_backup->getField("AKSES_APP_BACKUP_ID") == $tempAksesBackup) echo "selected"; ?>><?=$akses_app_backup->getField("NAMA")?></option>                        
                        <?
							}
						?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Akses Administrasi Website</td>
                <td>
                    <select name="reqAdministrasiWebsite" class="required" title="Akses Administrasi Website harus dipilih" />
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_adm_website->selectByParams();
							while($akses_adm_website->nextRow())
							{	
						?>
                          	<option value="<?=$akses_adm_website->getField("AKSES_ADM_WEBSITE_ID")?>" <? if($akses_adm_website->getField("AKSES_ADM_WEBSITE_ID") == $tempAksesWebsite) echo "selected"; ?>><?=$akses_adm_website->getField("NAMA")?></option>                        
                        <?
							}
						?>
                    </select>
                </td>
            </tr>
            
            
            <tr>
                <td></td>
                <td>
                    <input type="hidden" name="reqId" value="<?=$reqId?>">
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                    <input type="submit" value="Submit">
                    <input type="reset" id="rst_form">                    
                </td>
            </tr>
        </table>
    </form>
</div>

</div>
</body>
</html>