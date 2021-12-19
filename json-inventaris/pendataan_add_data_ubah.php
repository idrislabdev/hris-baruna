<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/utils/FileHandler.php");
include_once("../WEB-INF/functions/image.func.php");

$inventaris_ruangan = new InventarisRuangan();
$file   = new FileHandler();

$reqId = httpFilterPost("reqId");
$reqRowId = httpFilterPost("reqRowId");
$reqMode = httpFilterPost("reqMode");
$reqNomor = httpFilterPost("reqNomor");
$reqPerolehanHarga= httpFilterPost("reqPerolehanHarga");
$reqKondisiFisikProsentase= httpFilterPost("reqKondisiFisikProsentase");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqPerolehan= httpFilterPost("reqPerolehan");
$reqNoInvoice= httpFilterPost("reqNoInvoice");
	
$reqLinkFile   = $_FILES['reqLinkFile'];
$reqLinkFileTemp = httpFilterPost("reqLinkFileTemp");

$FILE_DIR = "../operasional/uploads/inventaris_ruangan/";
$_THUMB_PREFIX = "z__thumb_";

if($reqMode == "insert")
{
	/*$inventaris_ruangan->setField("PEROLEHAN_HARGA", $reqPerolehanHarga);
	$inventaris_ruangan->setField("KETERANGAN", $reqKeterangan);
	$inventaris_ruangan->setField("NOMOR", $reqNomor);
	$inventaris_ruangan->setField("KONDISI_FISIK_PROSENTASE", $reqKondisiFisikProsentase);
	
	if($inventaris_ruangan->insert())
		echo "Data berhasil disimpan.";*/
}
else
{
	$reqTahun= substr($reqPerolehan,2,4);
	$inventaris_ruangan->setField("NO_INVOICE", $reqNoInvoice);
	$inventaris_ruangan->setField("PEROLEHAN_TANGGAL", dateToDBCheck($reqPerolehan));
	$inventaris_ruangan->setField("INVENTARIS_RUANGAN_ID", $reqRowId);
	$inventaris_ruangan->setField('PEROLEHAN_HARGA', ValToNullDB(dotToNo($reqPerolehanHarga)));
	$inventaris_ruangan->setField("KETERANGAN", $reqKeterangan);
	$inventaris_ruangan->setField("NOMOR", $reqNomor);
	$inventaris_ruangan->setField("LAST_UPDATE_USER", $userLogin->nama);
	$inventaris_ruangan->setField("KONDISI_FISIK_PROSENTASE", ValToNullDB($reqKondisiFisikProsentase));
	$inventaris_ruangan->updatePendataanDetil();
	
	if($inventaris_ruangan->updatePendataanDetil())
		echo $reqRowId."-Data berhasil disimpan.";
	
	
}

if($reqLinkFile['type']=="image/jpeg")
{
	$cek = formatTextToDb($file->getFileName('reqLinkFile'));
	if($cek == "")
	{
	}
	else
	{
		$allowed = array(".exe");	$status_allowed='';
		foreach ($allowed as $file_cek) 
		{
			if(preg_match("/$file_cek\$/i", $_FILES['reqLinkFile']['name'])) 
			{
				$status_allowed = 'tidak_boleh';
			}
		}
		
		$renameFile = $reqRowId.'~'.formatTextToDb($file->getFileName('reqLinkFile'));
		$renameFile = str_replace(" ", "", $renameFile);
		
		$varSource=$FILE_DIR.$reqLinkFileTemp;
		$varThumbnail = $FILE_DIR.$_THUMB_PREFIX.$reqLinkFileTemp;
		
		if($file->uploadToDir('reqLinkFile', $FILE_DIR, $renameFile))
		{
			
			$thumbDestination = $file->dirLocation.$_THUMB_PREFIX.$file->uploadedFileName;
			if(!createThumbnail($file->uploadedFile, $thumbDestination))
				$alertMsg .= "Error creating thumbnail";
				
			if($reqLinkFileTemp != ''){
				if($file->delete($varSource)){
						$file->delete($varThumbnail);
				}
			}
			
			$insertLinkFile = $file->uploadedFileName;
			$set_file = new InventarisRuangan();
			$set_file->setField("INVENTARIS_RUANGAN_ID", $reqRowId);	
			$set_file->setField("FILE_GAMBAR", $insertLinkFile);
			$set_file->uploadFile();
		}
	}
}
?>