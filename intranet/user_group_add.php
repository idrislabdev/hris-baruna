<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/AksesAdmIntranet.php");
include_once("../WEB-INF/classes/base/AksesAdmWebsite.php");
include_once("../WEB-INF/classes/base/AksesAppBackup.php");
include_once("../WEB-INF/classes/base/AksesAppHukum.php");
include_once("../WEB-INF/classes/base/AksesAppKeuangan.php");
include_once("../WEB-INF/classes/base/AksesAppDatabase.php");
include_once("../WEB-INF/classes/base/AksesAppKepegawaian.php");
include_once("../WEB-INF/classes/base/AksesAppOperasional.php");
include_once("../WEB-INF/classes/base/AksesAppPenghasilan.php");
include_once("../WEB-INF/classes/base/AksesAppPenilaian.php");
include_once("../WEB-INF/classes/base/AksesAppPresensi.php");
include_once("../WEB-INF/classes/base/AksesAppSurvey.php");
include_once("../WEB-INF/classes/base/AksesAppKomersial.php");
include_once("../WEB-INF/classes/base/AksesAppArsip.php");
include_once("../WEB-INF/classes/base/AksesAppInventaris.php");
include_once("../WEB-INF/classes/base/AksesAppSPPD.php");
include_once("../WEB-INF/classes/base/AksesAppNotifikasi.php");
include_once("../WEB-INF/classes/base/AksesAppGalangan.php");
include_once("../WEB-INF/classes/base/AksesAppAnggaran.php");
include_once("../WEB-INF/classes/base/UserGroup.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$user_group = new UserGroup();
$akses_adm_intranet = new AksesAdmIntranet();
$akses_adm_website = new AksesAdmWebsite();
$akses_app_backup = new AksesAppBackup();
$akses_app_hukum = new AksesAppHukum();
$akses_app_keuangan = new AksesAppKeuangan();
$akses_app_database = new AksesAppDatabase();
$akses_app_kepegawaian = new AksesAppKepegawaian();
$akses_app_operasional = new AksesAppOperasional();
$akses_app_penghasilan = new AksesAppPenghasilan();
$akses_app_penilaian = new AksesAppPenilaian();
$akses_app_presensi = new AksesAppPresensi();
$akses_app_survey = new AksesAppSurvey();
$akses_app_komersial = new AksesAppKomersial();
$akses_app_arsip = new AksesAppArsip();
$akses_app_inventaris = new AksesAppInventaris();
$akses_app_sppd = new AksesAppSPPD();
$akses_app_notifikasi = new AksesAppNotifikasi();
$akses_app_galangan = new AksesAppGalangan();
$akses_app_anggaran = new AksesAppAnggaran();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");

if(($reqMode == "edit") || ($reqMode == "copy"))
{
	$user_group->selectByParams(array("USER_GROUP_ID" => $reqId));
	$user_group->firstRow();
	$tempNama = $user_group->getField("NAMA");
	$tempAksesLoginKepegawaian = $user_group->getField("AKSES_LOGIN_KEPEGAWAIAN");
	$tempAksesLoginPenghasilan = $user_group->getField("AKSES_LOGIN_PENGHASILAN");
	$tempAksesLoginPresens = $user_group->getField("AKSES_LOGIN_PRESENSI");
	$tempAksesLoginKeuangan = $user_group->getField("AKSES_LOGIN_KEUANGAN");
	$tempAksesLoginFixedAsset = $user_group->getField("AKSES_LOGIN_FIXED_ASSET");
	$tempAksesLoginPembayaran = $user_group->getField("AKSES_LOGIN_PEMBAYARAN");
	$tempAksesLoginPengaturan = $user_group->getField("AKSES_LOGIN_PENGATURAN");

}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form </title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	
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
	 $(document).ready( function () {
		 var formku = $("#ff");
		 $('#ff').form({
				url : '#',
				onSubmit:function(){
					//return $(this).form('validate');
					$.ajax({
					  type: "POST",
					  url: 'http://<?php echo $_SERVER['SERVER_NAME']; ?>/baruna/json-intranet/user_group_add.php',
					  data: formku.serialize(),
					  success: function(data){
					  	$.messager.alert('Info', data, 'info');
					  }
					});
				},
				success:function(data){
					//$.messager.alert('Info', data, 'info');
					//alert(data);
					/*$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					<? if(($reqMode == "edit")||($reqMode == "copy")) { ?> window.parent.divwin.close(); <? } ?>*/	
				}
			});

		// $("#reqAksesLoginKepegawaian").change(function() { 
		// 	 if($("#reqAksesLoginKepegawaian").val() == '1' || $("#reqAksesLoginKepegawaian").val() == '2' || $("#reqAksesLoginKepegawaian").val() == '3' || $("#reqAksesLoginKepegawaian").val() == 'NULL')
		// 		 $('.toggleIntranet').css({"display":"none"});
		// 	 else
		// 		 $('.toggleIntranet').css({"display":"inline"});
			
		// });

		
		
	 });	
    </script>       
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

<div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data User Group</span>
</div>

<div style="padding:5px 5px 5px 15px">
    <form id="ff" method="post" novalidate enctype="multipart/form-data" >
        <table>
        <tr>
            <td>Nama</td>
            <td>
                <input name="reqNama" class="easyui-validatebox" required size="40" type="text" value="<?=$tempNama?>" />
            </td>
        </tr>        
			<tr>
            	<td>Akses Kepegawaian</td>
                <td>
                	<select name="reqAksesLoginKepegawaian">
                    	<option value="YES" <? if($tempAksesLoginKepegawaian == 'YES') { ?> selected <? } ?>>YES</option>
                        <option value="NO" <? if($tempAksesLoginKepegawaian == 'NO') { ?> selected <? } ?>>NO</option>
                    </select>
                </td>
            </tr> 
			<tr>
            	<td>Akses Penghasilan</td>
                <td>
                	<select name="reqAksesLoginPenghasilan">
                    	<option value="YES" <? if($tempAksesLoginPenghasilan == 'YES') { ?> selected <? } ?>>YES</option>
                        <option value="NO" <? if($tempAksesLoginPenghasilan == 'NO') { ?> selected <? } ?>>NO</option>
                    </select>
                </td>
            </tr> 
			<tr>
            	<td>Akses Presensi</td>
                <td>
                	<select name="reqAksesLoginPresensi">
                    	<option value="YES" <? if($tempAksesLoginPresensi == 'YES') { ?> selected <? } ?>>YES</option>
                        <option value="NO" <? if($tempAksesLoginPresensi == 'NO') { ?> selected <? } ?>>NO</option>
                    </select>
                </td>
            </tr> 
			<tr>
            	<td>Akses Keuangan</td>
                <td>
                	<select name="reqAksesLoginKeuangan">
                    	<option value="YES" <? if($tempAksesLoginKeuangan == 'YES') { ?> selected <? } ?>>YES</option>
                        <option value="NO" <? if($tempAksesLoginKeuangan == 'NO') { ?> selected <? } ?>>NO</option>
                    </select>
                </td>
            </tr> 
			<tr>
            	<td>Akses Fixed Asset</td>
                <td>
                	<select name="reqAksesLoginFixedAsset">
                    	<option value="YES" <? if($tempAksesLoginFixedAsset == 'YES') { ?> selected <? } ?>>YES</option>
                        <option value="NO" <? if($tempAksesLoginFixedAsset == 'NO') { ?> selected <? } ?>>NO</option>
                    </select>
                </td>
            </tr> 
			<tr>
            	<td>Akses Pembayaran</td>
                <td>
                	<select name="reqAksesLoginPembayaran">
                    	<option value="YES" <? if($tempAksesLoginPembayaran == 'YES') { ?> selected <? } ?>>YES</option>
                        <option value="NO" <? if($tempAksesLoginPembayaran == 'NO') { ?> selected <? } ?>>NO</option>
                    </select>
                </td>
            </tr> 
			<tr>
            	<td>Akses Pengaturan</td>
                <td>
                	<select name="reqAksesLoginPengaturan">
                    	<option value="YES" <? if($tempAksesLoginPengaturan == 'YES') { ?> selected <? } ?>>YES</option>
                        <option value="NO" <? if($tempAksesLoginPengaturan == 'NO') { ?> selected <? } ?>>NO</option>
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