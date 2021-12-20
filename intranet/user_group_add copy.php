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
	$tempAksesIntranet = $user_group->getField("AKSES_ADM_INTRANET_ID");
	$tempAksesDatabase = $user_group->getField("AKSES_APP_DATABASE_ID");
	$tempAksesWebsite = $user_group->getField("AKSES_ADM_WEBSITE_ID");
	$tempAksesBackup = $user_group->getField("AKSES_APP_BACKUP_ID");
	$tempAksesHukum = $user_group->getField("AKSES_APP_HUKUM_ID");
	$tempAksesKeuangan = $user_group->getField("AKSES_APP_KEUANGAN_ID");
	$tempAksesKepegawaian = $user_group->getField("AKSES_APP_KEPEGAWAIAN_ID");
	$tempAksesOperasional = $user_group->getField("AKSES_APP_OPERASIONAL_ID");
	$tempAksesPenghasilan = $user_group->getField("AKSES_APP_PENGHASILAN_ID");
	$tempAksesPenilaian = $user_group->getField("AKSES_APP_PENILAIAN_ID");
	$tempAksesPresensi = $user_group->getField("AKSES_APP_PRESENSI_ID");
	$tempAksesSurvey = $user_group->getField("AKSES_APP_SURVEY_ID");
	$tempPublish = $user_group->getField("PUBLISH_KANTOR_PUSAT_ID");
	$tempFileManager = $user_group->getField("AKSES_APP_FILE_MANAGER_ID");
	$tempAksesKomersial = $user_group->getField("AKSES_APP_KOMERSIAL_ID");
	$tempAksesSMSGateway = $user_group->getField("AKSES_SMS_GATEWAY");
	$tempAksesArsip = $user_group->getField("AKSES_APP_ARSIP_ID");
	$tempAksesInventaris = $user_group->getField("AKSES_APP_INVENTARIS_ID");
	$tempAksesSPPD = $user_group->getField("AKSES_APP_SPPD_ID");
	$tempKeuangan = $user_group->getField("AKSES_KEUANGAN_ID");
	$tempAksesKontrakHukum = $user_group->getField("AKSES_KONTRAK_HUKUM_ID");
	$tempAksesNotifikasi = $user_group->getField("AKSES_APP_NOTIFIKASI_ID");
	$tempAksesGalangan = $user_group->getField("AKSES_APP_GALANGAN_ID");
	$tempAksesAnggaran = $user_group->getField("AKSES_APP_ANGGARAN_ID");
}

/*if($reqId == "")
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
	$tempAksesSurvey = $user_group->getField("AKSES_APP_SURVEY_ID");
	$tempPublish = $user_group->getField("PUBLISH_KANTOR_PUSAT_ID");
}*/

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
					  url: '../json-intranet/user_group_add.php',
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

		$("#reqAksesIntranet").change(function() { 
			 if($("#reqAksesIntranet").val() == '1' || $("#reqAksesIntranet").val() == '2' || $("#reqAksesIntranet").val() == '3' || $("#reqAksesIntranet").val() == 'NULL')
				 $('.toggleIntranet').css({"display":"none"});
			 else
				 $('.toggleIntranet').css({"display":"inline"});
			
		});

		$("#reqAplikasiOperasional").change(function() { 
			 if($("#reqAplikasiOperasional").val() == '1' || $("#reqAplikasiOperasional").val() == '2' || $("#reqAplikasiOperasional").val() == '3' || $("#reqAplikasiOperasional").val() == 'NULL')
				 $('.toggleOperasional').css({"display":"none"});
			 else
				 $('.toggleOperasional').css({"display":"inline"});
			
		});
		
		$("#reqAplikasiKepegawaian").change(function() { 
			 if($("#reqAplikasiKepegawaian").val() == '1' || $("#reqAplikasiKepegawaian").val() == '2' || $("#reqAplikasiKepegawaian").val() == '3' || $("#reqAplikasiKepegawaian").val() == 'NULL')
				 $('.toggleKepegawaian').css({"display":"none"});
			 else
				 $('.toggleKepegawaian').css({"display":"inline"});
			
		});
		
		$("#reqAplikasiPenghasilan").change(function() { 
			 if($("#reqAplikasiPenghasilan").val() == '1' || $("#reqAplikasiPenghasilan").val() == '2' || $("#reqAplikasiPenghasilan").val() == '3' || $("#reqAplikasiPenghasilan").val() == 'NULL')
				 $('.togglePenghasilan').css({"display":"none"});
			 else
				 $('.togglePenghasilan').css({"display":"inline"});
			
		});	
		
		$("#reqAplikasiPresensi").change(function() { 
			 if($("#reqAplikasiPresensi").val() == '1' || $("#reqAplikasiPresensi").val() == '2' || $("#reqAplikasiPresensi").val() == '3' || $("#reqAplikasiPresensi").val() == 'NULL')
				 $('.togglePresensi').css({"display":"none"});
			 else
				 $('.togglePresensi').css({"display":"inline"});
			
		});							

		$("#reqAplikasiPenilaian").change(function() { 
			 if($("#reqAplikasiPenilaian").val() == '1' || $("#reqAplikasiPenilaian").val() == '2' || $("#reqAplikasiPenilaian").val() == '3' || $("#reqAplikasiPenilaian").val() == 'NULL')
				 $('.togglePenilaian').css({"display":"none"});
			 else
				 $('.togglePenilaian').css({"display":"inline"});
			
		});	
		
		$("#reqAplikasiBackup").change(function() { 
			 if($("#reqAplikasiBackup").val() == '1' || $("#reqAplikasiBackup").val() == '2' || $("#reqAplikasiBackup").val() == '3' || $("#reqAplikasiBackup").val() == 'NULL')
				 $('.toggleBackup').css({"display":"none"});
			 else
				 $('.toggleBackup').css({"display":"inline"});
			
		});	

		$("#reqAplikasiKomersial").change(function() { 
			 if($("#reqAplikasiKomersial").val() == '1' || $("#reqAplikasiKomersial").val() == '2' || $("#reqAplikasiKomersial").val() == '3' || $("#reqAplikasiKomersial").val() == 'NULL')
				 $('.toggleKomersial').css({"display":"none"});
			 else
				 $('.toggleKomersial').css({"display":"inline"});
			
		});		
		
		$("#reqAdministrasiWebsite").change(function() { 
			 if($("#reqAdministrasiWebsite").val() == '1' || $("#reqAdministrasiWebsite").val() == '2' || $("#reqAdministrasiWebsite").val() == '3' || $("#reqAdministrasiWebsite").val() == 'NULL')
				 $('.toggleAdministrasiWebsite').css({"display":"none"});
			 else
				 $('.toggleAdministrasiWebsite').css({"display":"inline"});
			
		});				

		$("#reqAdministrasiWebsite").change(function() { 
			 if($("#reqAplikasiSurvey").val() == '1' || $("#reqAplikasiSurvey").val() == '2' || $("#reqAplikasiSurvey").val() == '3' || $("#reqAplikasiSurvey").val() == 'NULL')
				 $('.toggleAplikasiSurvey').css({"display":"none"});
			 else
				 $('.toggleAplikasiSurvey').css({"display":"inline"});
			
		});			

		$("#reqAplikasiArsip").change(function() { 
			 if($("#reqAplikasiArsip").val() == '1' || $("#reqAplikasiArsip").val() == '2' || $("#reqAplikasiArsip").val() == '3' || $("#reqAplikasiArsip").val() == 'NULL')
				 $('.toggleArsip').css({"display":"none"});
			 else
				 $('.toggleArsip').css({"display":"inline"});
			
		});

		$("#reqAplikasiInventaris").change(function() { 
			 if($("#reqAplikasiInventaris").val() == '1' || $("#reqAplikasiInventaris").val() == '2' || $("#reqAplikasiInventaris").val() == '3' || $("#reqAplikasiInventaris").val() == 'NULL')
				 $('.toggleInventaris').css({"display":"none"});
			 else
				 $('.toggleInventaris').css({"display":"inline"});
			
		});
				
		$("#reqAplikasiSPPD").change(function() { 
			 if($("#reqAplikasiSPPD").val() == '1' || $("#reqAplikasiSPPD").val() == '2' || $("#reqAplikasiSPPD").val() == '3' || $("#reqAplikasiSPPD").val() == 'NULL')
				 $('.toggleSPPD').css({"display":"none"});
			 else
				 $('.toggleSPPD').css({"display":"inline"});
			
		});

		$("#reqAplikasiHukum").change(function() { 
			 if($("#reqAplikasiHukum").val() == '1' || $("#reqAplikasiHukum").val() == '2' || $("#reqAplikasiHukum").val() == '3' || $("#reqAplikasiHukum").val() == 'NULL')
				 $('.toggleHukum').css({"display":"none"});
			 else
				 $('.toggleHukum').css({"display":"inline"});
			
		});		

		$("#reqAplikasiKeuangan").change(function() { 
			 if($("#reqAplikasiKeuangan").val() == '1' || $("#reqAplikasiKeuangan").val() == '2' || $("#reqAplikasiKeuangan").val() == '3' || $("#reqAplikasiKeuangan").val() == 'NULL')
				 $('.toggleKeuangan').css({"display":"none"});
			 else
				 $('.toggleKeuangan').css({"display":"inline"});
			
		});	
				
		$("#reqAplikasiNotifikasi").change(function() { 
			 if($("#reqAplikasiNotifikasi").val() == '1' || $("#reqAplikasiNotifikasi").val() == '2' || $("#reqAplikasiNotifikasi").val() == '3' || $("#reqAplikasiNotifikasi").val() == 'NULL')
				 $('.toggleNotifikasi').css({"display":"none"});
			 else
				 $('.toggleNotifikasi').css({"display":"inline"});
			
		});		
		
		$("#reqAplikasiGalangan").change(function() { 
			 if($("#reqAplikasiGalangan").val() == '1' || $("#reqAplikasiGalangan").val() == '2' || $("#reqAplikasiGalangan").val() == '3' || $("#reqAplikasiGalangan").val() == 'NULL')
				 $('.toggleGalangan').css({"display":"none"});
			 else
				 $('.toggleGalangan').css({"display":"inline"});
			
		});	
		$("#reqAplikasiAnggaran").change(function() { 
			 if($("#reqAplikasiAnggaran").val() == '1' || $("#reqAplikasiAnggaran").val() == '2' || $("#reqAplikasiAnggaran").val() == '3' || $("#reqAplikasiAnggaran").val() == 'NULL')
				 $('.toggleAnggaran').css({"display":"none"});
			 else
				 $('.toggleAnggaran').css({"display":"inline"});
			
		});	
		
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
                <td>Akses Intranet</td>
                <td>
                  <select name="reqAksesIntranet" id="reqAksesIntranet" class="required" title="Akses Intranet harus dipilih" >
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
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=8&reqTable=AKSES_ADM_INTRANET', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
 				  <?
				  $display = "";
                  if($tempAksesIntranet == 1 || $tempAksesIntranet == 2 || $tempAksesIntranet == 3)
				  	$display = "style='display:none'";
				  ?>
                  <a href="#" class="toggleIntranet" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=8&reqTable=AKSES_ADM_INTRANET&reqAksesIntranet='+$('#reqAksesIntranet').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>		                
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Operasional</td>
                <td>
                    <select name="reqAplikasiOperasional"  id="reqAplikasiOperasional" class="required" title="Akses Aplikasi Operasional harus dipilih" >
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
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=1&reqTable=AKSES_APP_OPERASIONAL', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
  				  <?
				  $display = "";
                  if($tempAksesOperasional == 1 || $tempAksesOperasional == 2 || $tempAksesOperasional == 3)
				  $display = "style='display:none'";
				  ?>	
                  <a href="#" class="toggleOperasional" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=1&reqTable=AKSES_APP_OPERASIONAL&reqAksesIntranet='+$('#reqAplikasiOperasional').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                    
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Kepegawaian</td>
                <td>
                    <select name="reqAplikasiKepegawaian" id="reqAplikasiKepegawaian" class="required" title="Akses Aplikasi Kepegawaian harus dipilih" >
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
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=2&reqTable=AKSES_APP_KEPEGAWAIAN', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
				  <?
				  $display = "";
                  if($tempAksesKepegawaian == 1 || $tempAksesKepegawaian == 2 || $tempAksesKepegawaian == 3)
                  $display = "style='display:none'";
                  ?>                   
                  <a href="#" class="toggleKepegawaian" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=2&reqTable=AKSES_APP_KEPEGAWAIAN&reqAksesIntranet='+$('#reqAplikasiKepegawaian').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                   
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Penghasilan</td>
                <td>
                    <select name="reqAplikasiPenghasilan" id="reqAplikasiPenghasilan" class="required" title="Akses Aplikasi Penghasilan  harus dipilih" >
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
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=3&reqTable=AKSES_APP_PENGHASILAN', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
				  <?
				  $display = "";
                  if($tempAksesPenghasilan == 1 || $tempAksesPenghasilan == 2 || $tempAksesPenghasilan == 3)
				  $display = "style='display:none'";
                  ?>                   
                  <a href="#" class="togglePenghasilan" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=3&reqTable=AKSES_APP_PENGHASILAN&reqAksesIntranet='+$('#reqAplikasiPenghasilan').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                                    
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Presensi</td>
                <td>
                    <select name="reqAplikasiPresensi" id="reqAplikasiPresensi" class="required" title="Akses Aplikasi Presensi harus dipilih" >
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
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=4&reqTable=AKSES_APP_PRESENSI', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
				  <?
				  $display = "";
                  if($tempAksesPresensi == 1 || $tempAksesPresensi == 2 || $tempAksesPresensi == 3)
                  $display = "style='display:none'";
                  ?>                   
                  <a href="#" class="togglePresensi" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=4&reqTable=AKSES_APP_PRESENSI&reqAksesIntranet='+$('#reqAplikasiPresensi').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                                   
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Penilaian</td>
                <td>
                    <select name="reqAplikasiPenilaian" id="reqAplikasiPenilaian" class="required" title="Akses Aplikasi Penilaian harus dipilih" >
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
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=5&reqTable=AKSES_APP_PENILAIAN', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
				  <?
				  $display = "";
                  if($tempAksesPenilaian == 1 || $tempAksesPenilaian == 2 || $tempAksesPenilaian == 3)
                  $display = "style='display:none'";
                  ?>                   
                  <a href="#" class="togglePenilaian" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=5&reqTable=AKSES_APP_PENILAIAN&reqAksesIntranet='+$('#reqAplikasiPenilaian').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                                  
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Backup</td>
                <td>
                    <select name="reqAplikasiBackup" id="reqAplikasiBackup" class="required" title="Akses Aplikasi Backup harus dipilih" >
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
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=6&reqTable=AKSES_APP_BACKUP', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
				  <?
				  $display = "";
                  if($tempAksesBackup == 1 || $tempAksesBackup == 2 || $tempAksesBackup == 3)
                  $display = "style='display:none'";
                  ?>                   
                  <a href="#" class="toggleBackup" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=6&reqTable=AKSES_APP_BACKUP&reqAksesIntranet='+$('#reqAplikasiBackup').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                    
                </td>
            </tr>
            <tr>
                <td>Akses Administrasi Website</td>
                <td>
                    <select name="reqAdministrasiWebsite" id="reqAdministrasiWebsite" class="required" title="Akses Administrasi Website harus dipilih" >
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
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=7&reqTable=AKSES_ADM_WEBSITE', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
				  <?
				  $display = "";
                  if($tempAksesWebsite == 1 || $tempAksesWebsite == 2 || $tempAksesWebsite == 3)
                  $display = "style='display:none'";
                  ?>                   
                  <a href="#" class="toggleAdministrasiWebsite" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=7&reqTable=AKSES_ADM_WEBSITE&reqAksesIntranet='+$('#reqAdministrasiWebsite').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                    
                </td>
            </tr>
           <tr>
                <td>Akses Aplikasi Survey</td>
                <td>
                    <select name="reqAplikasiSurvey" id="reqAplikasiSurvey" class="required" title="Akses Aplikasi Survey harus dipilih" >
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_survey->selectByParams();
							while($akses_app_survey->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_survey->getField("AKSES_APP_SURVEY_ID")?>" <? if($akses_app_survey->getField("AKSES_APP_SURVEY_ID") == $tempAksesSurvey) echo "selected"; ?>><?=$akses_app_survey->getField("NAMA")?></option>                        
                        <?
							}
						?>
                    </select>
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=9&reqTable=AKSES_APP_SURVEY', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
				  <?
                  $display = "";
				  if($tempAksesSurvey == 1 || $tempAksesSurvey == 2 || $tempAksesSurvey == 3)
                  $display = "style='display:none'";
                  ?>                   
                  <a href="#" class="toggleAplikasiSurvey" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=9&reqTable=AKSES_APP_SURVEY&reqAksesIntranet='+$('#reqAplikasiSurvey').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                    
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Komersial</td>
                <td>
                    <select name="reqAplikasiKomersial" id="reqAplikasiKomersial" class="required" title="Akses Aplikasi Komersial harus dipilih" >
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_komersial->selectByParams();
							while($akses_app_komersial->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_komersial->getField("AKSES_APP_KOMERSIAL_ID")?>" <? if($akses_app_komersial->getField("AKSES_APP_KOMERSIAL_ID") == $tempAksesKomersial) echo "selected"; ?>><?=$akses_app_komersial->getField("NAMA")?></option>                        
                        <?
							}
						?>
                    </select>
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=11&reqTable=AKSES_APP_KOMERSIAL', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
				  <?
				  $display = "";
                  if($tempAksesKomersial == 1 || $tempAksesKomersial == 2 || $tempAksesKomersial == 3)
                  $display = "style='display:none'";
                  ?>
                  <a href="#" class="toggleKomersial" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=11&reqTable=AKSES_APP_KOMERSIAL&reqAksesIntranet='+$('#reqAplikasiKomersial').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                    
                </td>
            </tr>        
<?php /*?>            <tr>
                <td>Akses Aplikasi Arsip</td>
                <td>
                    <select name="reqAplikasiArsip"  id="reqAplikasiArsip" class="required" title="Akses Aplikasi Arsip harus dipilih" />
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_arsip->selectByParams();
							while($akses_app_arsip->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_arsip->getField("AKSES_APP_ARSIP_ID")?>" <? if($akses_app_arsip->getField("AKSES_APP_ARSIP_ID") == $tempAksesArsip) echo "selected"; ?>><?=$akses_app_arsip->getField("NAMA")?></option>                        
                        <?
							}
						?>                        
                    </select>
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=1&reqTable=AKSES_APP_ARSIP', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
  				  <?
				  $display = "";
                  if($tempAksesArsip == 1 || $tempAksesArsip == 2 || $tempAksesArsip == 3)
				  $display = "style='display:none'";
				  ?>	
                  <a href="#" class="toggleArsip" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=13&reqTable=AKSES_APP_ARSIP&reqAksesIntranet='+$('#reqAplikasiArsip').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                    
                </td>
            </tr><?php */?>
            <tr>
                <td>Akses Aplikasi Inventaris</td>
                <td>
                    <select name="reqAplikasiInventaris"  id="reqAplikasiInventaris" class="required" title="Akses Aplikasi Inventaris harus dipilih" >
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_inventaris->selectByParams();
							while($akses_app_inventaris->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_inventaris->getField("AKSES_APP_INVENTARIS_ID")?>" <? if($akses_app_inventaris->getField("AKSES_APP_INVENTARIS_ID") == $tempAksesInventaris) echo "selected"; ?>><?=$akses_app_inventaris->getField("NAMA")?></option>                        
                        <?
							}
						?>                        
                    </select>
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=14&reqTable=AKSES_APP_INVENTARIS', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
  				  <?
				  $display = "";
                  if($tempAksesInventaris == 1 || $tempAksesInventaris == 2 || $tempAksesInventaris == 3)
				  $display = "style='display:none'";
				  ?>	
                  <a href="#" class="toggleInventaris" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=14&reqTable=AKSES_APP_INVENTARIS&reqAksesIntranet='+$('#reqAplikasiInventaris').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                    
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi SPPD</td>
                <td>
                    <select name="reqAplikasiSPPD"  id="reqAplikasiSPPD" class="required" title="Akses Aplikasi SPPD harus dipilih" >
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_sppd->selectByParams();
							while($akses_app_sppd->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_sppd->getField("AKSES_APP_SPPD_ID")?>" <? if($akses_app_sppd->getField("AKSES_APP_SPPD_ID") == $tempAksesSPPD) echo "selected"; ?>><?=$akses_app_sppd->getField("NAMA")?></option>                        
                        <?
							}
						?>                        
                    </select>
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=15&reqTable=AKSES_APP_SPPD', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
  				  <?
				  $display = "";
                  if($tempAksesSPPD == 1 || $tempAksesSPPD == 2 || $tempAksesSPPD == 3)
				  $display = "style='display:none'";
				  ?>	
                  <a href="#" class="toggleSPPD" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=15&reqTable=AKSES_APP_SPPD&reqAksesIntranet='+$('#reqAplikasiSPPD').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                    
                </td>
            </tr>
            <tr>
                <td>Akses Aplikasi Hukum</td>
                <td>
                    <select name="reqAplikasiHukum" id="reqAplikasiHukum" class="required" title="Akses Aplikasi Hukum harus dipilih" >
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_hukum->selectByParams();
							while($akses_app_hukum->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_hukum->getField("AKSES_APP_HUKUM_ID")?>" <? if($akses_app_hukum->getField("AKSES_APP_HUKUM_ID") == $tempAksesHukum) echo "selected"; ?>><?=$akses_app_hukum->getField("NAMA")?></option>                        
                        <?
							}
						?>
                    </select>
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=16&reqTable=AKSES_APP_HUKUM', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
				  <?
				  $display = "";
                  if($tempAksesHukum == 1 || $tempAksesHukum == 2 || $tempAksesHukum == 3)
                  $display = "style='display:none'";
                  ?>                   
                  <a href="#" class="toggleHukum" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=16&reqTable=AKSES_APP_HUKUM&reqAksesIntranet='+$('#reqAplikasiHukum').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                    
                </td>
            </tr> 
            <tr>
                <td>Akses Aplikasi Keuangan</td>
                <td>
                    <select name="reqAplikasiKeuangan" id="reqAplikasiKeuangan" class="required" title="Akses Aplikasi Keuangan harus dipilih" >
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_keuangan->selectByParams();
							while($akses_app_keuangan->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_keuangan->getField("AKSES_APP_KEUANGAN_ID")?>" <? if($akses_app_keuangan->getField("AKSES_APP_KEUANGAN_ID") == $tempAksesKeuangan) echo "selected"; ?>><?=$akses_app_keuangan->getField("NAMA")?></option>                        
                        <?
							}
						?>
                    </select>
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=17&reqTable=AKSES_APP_KEUANGAN', 'Office Management - Administrasi Intranet', 850,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
				  <?
				  $display = "";
                  if($tempAksesKeuangan == 1 || $tempAksesKeuangan == 2 || $tempAksesKeuangan == 3)
                  $display = "style='display:none'";
                  ?>                   
                  <a href="#" class="toggleKeuangan" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=17&reqTable=AKSES_APP_KEUANGAN&reqAksesIntranet='+$('#reqAplikasiKeuangan').val(), 'Office Management - Administrasi Intranet', 850,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                    
                </td>
            </tr>                      
            <tr>
                <td>Akses Aplikasi Notifikasi</td>
                <td>
                    <select name="reqAplikasiNotifikasi" id="reqAplikasiNotifikasi" class="required" title="Akses Aplikasi Notifikasi harus dipilih" >
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_notifikasi->selectByParams();
							while($akses_app_notifikasi->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_notifikasi->getField("AKSES_APP_NOTIFIKASI_ID")?>" <? if($akses_app_notifikasi->getField("AKSES_APP_NOTIFIKASI_ID") == $tempAksesNotifikasi) echo "selected"; ?>><?=$akses_app_notifikasi->getField("NAMA")?></option>                        
                        <?
							}
						?>
                    </select>
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=99&reqTable=AKSES_APP_NOTIFIKASI', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
				  <?
				  $display = "";
                  if($tempAksesNotifikasi == 1 || $tempAksesNotifikasi == 2 || $tempAksesNotifikasi == 3)
                  $display = "style='display:none'";
                  ?>                   
                  <a href="#" class="toggleNotifikasi" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=99&reqTable=AKSES_APP_NOTIFIKASI&reqAksesIntranet='+$('#reqAplikasiNotifikasi').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                    
                </td>
            </tr>   
            
            <tr>
                <td>Akses Aplikasi Galangan</td>
                <td>
                    <select name="reqAplikasiGalangan" id="reqAplikasiGalangan" class="required" title="Akses Aplikasi Galangan harus dipilih" >
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_galangan->selectByParams();
							while($akses_app_galangan->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_galangan->getField("AKSES_APP_GALANGAN_ID")?>" <? if($akses_app_galangan->getField("AKSES_APP_GALANGAN_ID") == $tempAksesGalangan) echo "selected"; ?>><?=$akses_app_galangan->getField("NAMA")?></option>                        
                        <?
							}
						?>
                    </select>
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=19&reqTable=akses_app_galangan', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
				  <?
				  $display = "";
                  if($tempAksesGalangan == 1 || $tempAksesGalangan == 2 || $tempAksesGalangan == 3)
                  $display = "style='display:none'";
                  ?>                   
                  <a href="#" class="toggleGalangan" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=19&reqTable=akses_app_galangan&reqAksesIntranet='+$('#reqAplikasiGalangan').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                    
                </td>
            </tr>   
            <tr>
                <td>Akses Aplikasi Anggaran</td>
                <td>
                    <select name="reqAplikasiAnggaran" id="reqAplikasiAnggaran" class="required" title="Akses Aplikasi Anggaran harus dipilih" >
                        <option value="NULL">-- Pilih Nama Group Akses --</option>
                        <?
                        	$akses_app_anggaran->selectByParams();
							while($akses_app_anggaran->nextRow())
							{	
						?>
                          	<option value="<?=$akses_app_anggaran->getField("AKSES_APP_ANGGARAN_ID")?>" <? if($akses_app_anggaran->getField("AKSES_APP_ANGGARAN_ID") == $tempAksesAnggaran) echo "selected"; ?>><?=$akses_app_anggaran->getField("NAMA")?></option>                        
                        <?
							}
						?>
                    </select>
                  <a href="#" onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=18&reqTable=akses_app_anggaran', 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-add.png" width="15" height="15"/></a>		                
				  <?
				  $display = "";
                  if($tempAksesAnggaran == 1 || $tempAksesAnggaran == 2 || $tempAksesAnggaran == 3)
                  $display = "style='display:none'";
                  ?>                   
                  <a href="#" class="toggleAnggaran" <?=$display?> onClick="OpenDHTML('akses_administrasi_add.php?reqMenuGroupId=18&reqTable=akses_app_anggaran&reqAksesIntranet='+$('#reqAplikasiAnggaran').val(), 'Office Management - Administrasi Intranet', 450,500);" ><img src="../WEB-INF/images/tree-edit.png" width="15" height="15"/></a>                    
                </td>
            </tr>                              
            <tr>
            	<td>Publish</td>
                <td>
                	<select name="reqPublish">
                    	<option value="0" <? if($tempPublish == 0) { ?> selected <? } ?>>Tidak</option>
                        <option value="1" <? if($tempPublish == 1) { ?> selected <? } ?>>Ya</option>
                    </select>
                </td>
            </tr>
            <tr>
            	<td>File Manager</td>
                <td>
                	<select name="reqAplikasiFileManager">
                    	<option value="0" <? if($tempFileManager == 0) { ?> selected <? } ?>>Tidak</option>
                        <option value="1" <? if($tempFileManager == 1) { ?> selected <? } ?>>Ya</option>
                    </select>
                </td>
            </tr>
            <tr>
            	<td>SMS Gateway</td>
                <td>
                	<select name="reqSMSGateway">
                    	<option value="0" <? if($tempAksesSMSGateway == 0) { ?> selected <? } ?>>Tidak</option>
                        <option value="1" <? if($tempAksesSMSGateway == 1) { ?> selected <? } ?>>Ya</option>
                    </select>
                </td>
            </tr>   
            <tr>
            	<td>Akses Kontrak Hukum</td>
                <td>
                	<select name="reqAksesKontrakHukum">
                    	<option value="0" <? if($tempAksesKontrakHukum == 0) { ?> selected <? } ?>>Tidak</option>
                        <option value="1" <? if($tempAksesKontrakHukum == 1) { ?> selected <? } ?>>Ya</option>
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