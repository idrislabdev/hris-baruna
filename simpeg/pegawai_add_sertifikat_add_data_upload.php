<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiSertifikatFile.php");

$pegawai_sertifikat_file = new PegawaiSertifikatFile();

$reqId = httpFilterRequest("reqId");
$reqRowId = httpFilterRequest("reqRowId");
$reqSubmit= httpFilterPost("reqSubmit");
$reqLinkFile = $_FILES["reqLinkFile"];

if($reqSubmit == "Submit")
{
	$pegawai_sertifikat_file->setField("PEGAWAI_SERTIFIKAT_ID", $reqId);
	
	$pegawai_sertifikat_file->setField("NAMA", $_FILES['reqLinkFile']['name']);
	$pegawai_sertifikat_file->setField("FILE_NAMA", $_FILES['reqLinkFile']['name']);
	$pegawai_sertifikat_file->setField("FILE_UKURAN", $_FILES['reqLinkFile']['size']);
	$pegawai_sertifikat_file->setField("FILE_FORMAT", $_FILES['reqLinkFile']['type']);
	$pegawai_sertifikat_file->insert();
	
	$id = $pegawai_sertifikat_file->id;
	$pegawai_sertifikat_file->upload("IMASYS_SIMPEG.PEGAWAI_SERTIFIKAT_FILE", "FILE_UPLOAD", $reqLinkFile['tmp_name'], "PEGAWAI_SERTIFIKAT_FILE_ID = ".$id);
	
	echo '<script language="javascript">';
	echo "parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_sertifikat_add_data_upload_monitoring.php?reqRowId=".$reqRowId."&reqId=".$reqId."';";
	echo '</script>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">    
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
            <a href="pegawai_add_sertifikat_add_data_upload.php?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>">Batal</a>
            </li>        
        <?
		}
		?>
        </ul>
    </div>
    <form id="ff" method="post" enctype="multipart/form-data">
    	<div style="margin-top:25px; margin-left:0px;">
        <label>File Upload</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
        <input type="file" name="reqLinkFile" id="reqLinkFile" />
        </div>
    
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