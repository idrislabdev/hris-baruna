<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/AksesAdmIntranet.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$akses_adm_intranet = new AksesAdmIntranet();

//$reqId = httpFilterGet("reqId");
$reqAksesIntranet = httpFilterRequest("reqAksesIntranet");

$tempDepartemen = $userLogin->idDepartemen;

if($reqAksesIntranet == "")
{
	$reqMode = "insert";	
}
else 
{
	$reqMode = "update";	
	$akses_adm_intranet->selectByParams(array("AKSES_ADM_INTRANET_ID" => $reqAksesIntranet));
	$akses_adm_intranet->firstRow();
	$tempNama = $akses_adm_intranet->getField("NAMA");
	$tempInformasi = $akses_adm_intranet->getField("INFORMASI");
	$tempHasilRapat = $akses_adm_intranet->getField("HASIL_RAPAT");
	$tempAgenda = $akses_adm_intranet->getField("AGENDA");
	$tempForum = $akses_adm_intranet->getField("FORUM");
	$tempKataMutiara = $akses_adm_intranet->getField("KATA_MUTIARA");
	$tempKalenderKerja = $akses_adm_intranet->getField("KALENDER_KERJA");
	$tempUserGroup = $akses_adm_intranet->getField("USER_GROUP");
	$tempUserApp = $akses_adm_intranet->getField("USER_APP");
	$tempDepartemen = $akses_adm_intranet->getField("DEPARTEMEN");
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
				url:'../json-intranet/akses_adm_intranet_add.php',
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
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Akses Intranet</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Nama</td>
            <td>
                <input name="reqNama" class="easyui-validatebox" required="true" size="40" type="text" value="<?=$tempNama?>" />
            </td>
        </tr>
        <tr>
            <td>Informasi</td>
            <td>
                <input type="radio" <? if($tempInformasi == 'A') echo 'checked';?> name="reqInformasi" value="A" /> All &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempInformasi == 'R') echo 'checked';?> name="reqInformasi" value="R" /> Readonly &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempInformasi == 'D') echo 'checked';?> name="reqInformasi" value="D" /> Disabled
            </td>        
        </tr>
        <tr>
            <td>Hasil Rapat</td>
            <td>
                <input type="radio" <? if($tempHasilRapat == 'A') echo 'checked';?> name="reqHasilRapat" value="A" /> All &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempHasilRapat == 'R') echo 'checked';?> name="reqHasilRapat" value="R" /> Readonly &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempHasilRapat == 'D') echo 'checked';?> name="reqHasilRapat" value="D" /> Disabled
            </td>        
        </tr>
        <tr>
            <td>Agenda</td>
            <td>
                <input type="radio" <? if($tempAgenda == 'A') echo 'checked';?> name="reqAgenda" value="A" /> All &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempAgenda == 'R') echo 'checked';?> name="reqAgenda" value="R" /> Readonly &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempAgenda == 'D') echo 'checked';?> name="reqAgenda" value="D" /> Disabled
            </td>        
        </tr> 
        <tr>
            <td>Unit Kerja</td>
            <td>
                <input type="radio" <? if($tempDepartemen == 'A') echo 'checked';?> name="reqDepartemen" value="A" /> All &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempDepartemen == 'D') echo 'checked';?> name="reqDepartemen" value="D" /> Disabled
            </td>        
        </tr> 
        <tr>
            <td>Forum</td>
            <td>
                <input type="radio" <? if($tempForum == 'A') echo 'checked';?> name="reqForum" value="A" /> All &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempForum == 'D') echo 'checked';?> name="reqForum" value="D" /> Disabled
            </td>        
        </tr> 
        <tr>
            <td>Kata Mutiara</td>
            <td>
                <input type="radio" <? if($tempKataMutiara == 'A') echo 'checked';?> name="reqKataMutiara" value="A" /> All &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempKataMutiara == 'R') echo 'checked';?> name="reqKataMutiara" value="R" /> Readonly &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempKataMutiara == 'D') echo 'checked';?> name="reqKataMutiara" value="D" /> Disabled
            </td>        
        </tr>
        <tr>
            <td>Kalender Kerja</td>
            <td>
                <input type="radio" <? if($tempKalenderKerja == 'A') echo 'checked';?> name="reqKalenderKerja" value="A" /> All &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempKalenderKerja == 'R') echo 'checked';?> name="reqKalenderKerja" value="R" /> Readonly &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempKalenderKerja == 'D') echo 'checked';?> name="reqKalenderKerja" value="D" /> Disabled
            </td>        
        </tr>
        <tr>
            <td>User Group</td>
            <td>
                <input type="radio" <? if($tempUserGroup == 'A') echo 'checked';?> name="reqUserGroup" value="A" /> All &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempUserGroup == 'R') echo 'checked';?> name="reqUserGroup" value="R" /> Readonly &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempUserGroup == 'D') echo 'checked';?> name="reqUserGroup" value="D" /> Disabled
                
            </td>        
        </tr> 
        <tr>
            <td>User App</td>
            <td>
                <input type="radio" <? if($tempUserApp == 'A') echo 'checked';?> name="reqUserApp" value="A" /> All &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempUserApp == 'R') echo 'checked';?> name="reqUserApp" value="R" /> Readonly &nbsp;&nbsp;&nbsp;
                <input type="radio" <? if($tempUserApp == 'D') echo 'checked';?> name="reqUserApp" value="D" /> Disabled
            </td>        
        </tr>                                                                    
    </table>
        <div>
            <input type="hidden" name="reqAksesIntranet" value="<?=$reqAksesIntranet?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>