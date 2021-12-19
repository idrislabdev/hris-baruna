<?
/*include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/HasilRapatAttachment.php");

$hasil_rapat_attachment = new HasilRapatAttachment();

$reqLinkFile = $_FILES["reqLinkFile"];
$reqId = httpFilterRequest("reqId");
$reqSubmit = httpFilterPost("reqSubmit");

if($reqSubmit == "Submit")
{
	$hasil_rapat_attachment->setField("NAMA", $_FILES['reqLinkFile']['name']);
	$hasil_rapat_attachment->setField("HASIL_RAPAT_ID", $reqId);
	$hasil_rapat_attachment->setField("FILE_NAMA", $_FILES['reqLinkFile']['name']);
	$hasil_rapat_attachment->setField("UKURAN", $_FILES['reqLinkFile']['size']);
	$hasil_rapat_attachment->setField("FORMAT", $_FILES['reqLinkFile']['type']);
	$hasil_rapat_attachment->insert();
	$id = $hasil_rapat_attachment->id;
	$hasil_rapat_attachment->upload("HASIL_RAPAT_ATTACHMENT", "FILE_UPLOAD", $reqLinkFile['tmp_name'], "HASIL_RAPAT_ATTACHMENT_ID = ".$id);
	echo '<script language="javascript">';
	echo "parent.frames['mainFramePop'].location.href = 'hasil_rapat_add_upload_monitoring.php?reqId=".$reqId."';";
	echo "top.frames['mainFrame'].location.reload();";
	echo '</script>';
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <form id="ff" method="post" novalidate>
    <table>
        <!--<tr>
            <td>Departemen</td>
            <td><input id="cc" class="easyui-combotree"  required="true" name="reqDepartemen" data-options="url:'../json-intranet/departemen_combo_json.php'" style="width:300px;"></td>
        </tr>-->
        <tr>
        	<td>Terhitung Mulai Tanggal (TMT)</td>
            <td>
                <input id="dd" name="reqTMT" class="easyui-datebox" required="required" value="<?=$tempTMT?>"></input>
            </td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>
                <input name="reqKelas" id="reqKelas" class="easyui-validatebox" required="required" size="10" type="text" value="<?=$tempKelas?>" />
            </td>
        </tr>
        <tr>
            <td>Tunjangan</td>
            <td><label>Rp.</label>
                <input name="reqTunjangan" id="reqTunjangan" class="easyui-validatebox" required="required" size="60" type="text" value="<?=$tempTunjangan?>" />
            </td>
        </tr>
        <tr>
            <td>Nomor SK</td>
            <td>
                <input name="reqNoSK" id="reqNoSK" class="easyui-validatebox" required="required" size="60" type="text" value="<?=$tempNoSK?>" />
            </td>
        </tr>
        <tr>
        	<td>Tanggal SK</td>
            <td>
                <input id="dd" name="reqTanggal" class="easyui-datebox" required="required" value="<?=$tempTanggal?>"></input>
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