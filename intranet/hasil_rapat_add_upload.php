<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/HasilRapatAttachment.php");

$hasil_rapat_attachment = new HasilRapatAttachment();

$reqLinkFile = $_FILES["reqLinkFile"];
$reqId = httpFilterRequest("reqId");
$reqRowId = httpFilterRequest("reqRowId");
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
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
<link rel="stylesheet" type="text/css" href="../WEB-INF/css/bluetabs.css" />

    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" onClick="$('#btnSubmit').click();">Simpan</a>
            </li>        
        <?
        if($reqRowId == "") {}
		else
		{
		?>
            <li>
            <a href="hasil_rapat_add_upload.php?reqId=<?=$reqId?>">Batal</a>
            </li>        
        <?
		}
		?>
        </ul>
    </div>
    <form id="ff" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>File Upload</td>
            <td>
                 <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
        		 <input type="file" name="reqLinkFile" id="reqLinkFile" />
            </td>
        </tr>
    </table>
        <div style="display:none">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqRowId" value="<?=$reqRowId?>">
            <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>