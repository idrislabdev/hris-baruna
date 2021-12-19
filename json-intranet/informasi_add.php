<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/image.func.php");
include_once("../WEB-INF/classes/base/Informasi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/utils/FileHandler.php");

$webservice_url = 'http://10.34.7.161/pelindomarine/admin/ws_upload_berita.php';
/*ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);*/

$informasi = new Informasi();
$file = new FileHandler();

$reqId = httpFilterPost("reqId");
$reqIdWebsite = httpFilterPost("id_informasi");
$reqMode = httpFilterPost("reqMode");
$reqDepartemen = httpFilterPost("reqDepartemen");
$reqTanggal = httpFilterPost("reqTanggal");

$reqNama = httpFilterPost("reqNama");
$reqNamaEnglish = httpFilterPost("reqNamaEnglish");
$reqKeterangan = httpFilterPost("reqKeterangan");
$reqKeteranganEnglish = httpFilterPost("reqKeteranganEnglish");
$reqPublish = httpFilterPost("reqPublish");
if ( isset( $_POST['reqPublish']) && $_POST['reqPublish'] === '1' ) {
	$reqPublish = 1;
}

$reqLinkFile= $_FILES['reqLinkFile'];
$reqLinkFileTemp = httpFilterPost("reqLinkFileTemp");

$FILE_DIR = "../main/uploads/informasi/";
$_THUMB_PREFIX = "z__thumb_";

if($reqDepartemen == 0)
	$reqDepartemen = "CAB1";
else
	$reqDepartemen = $reqDepartemen;

if($reqMode == "insert"){	
	$informasi->setField("DEPARTEMEN_ID", $reqDepartemen);
	$informasi->setField("NAMA", $reqNama);
	$informasi->setField("NAMA_INGGRIS", $reqNamaEnglish);
	$informasi->setField("KETERANGAN", $reqKeterangan);
	$informasi->setField("KETERANGAN_INGGRIS", $reqKeteranganEnglish);
	$informasi->setField("TANGGAL", dateToDBCheck($reqTanggal));
	$informasi->setField("USER_LOGIN_ID", $userLogin->UID);
	$informasi->setField("STATUS", 1);
	$informasi->setField("STATUS_PUBLISH", $reqPublish);
	$informasi->setField("LAST_CREATE_USER", $userLogin->nama);
	$informasi->setField("LAST_CREATE_DATE", OCI_SYSDATE);
	$informasi->setField("INFORMASI_ID_WEBSITE", 0);

	// disini nanti untuk upload data
	/*
	if($reqPublish == 1){
		$data = '<DATA>';
			$data .= '<INFORMASI_ID>NULL</INFORMASI_ID>';
			$data .= '<NAMA>'. $reqNama .'</NAMA>';
			$data .= '<TITLE>'. $reqNamaEnglish .'</TITLE>';
			$data .= '<KETERANGAN>'. htmlentities($reqKeterangan) .'</KETERANGAN>';
			$data .= '<DESCRIPTION>'. htmlentities($reqKeteranganEnglish) .'</DESCRIPTION>';
			$data .= '<TANGGAL>CURRENT_TIME()</TANGGAL>';
			$data .= '<USER_LOGIN_ID>0</USER_LOGIN_ID>';
			$data .= '<LAST_CREATE_USER>'. $userLogin->nama .'</LAST_CREATE_USER>';
			$data .= '<LAST_CREATE_DATE>CURRENT_TIME()</LAST_CREATE_DATE>';
			$data .= '<STATUS_AKTIF>1</STATUS_AKTIF>';
			$data .= '<STATUS_INFORMASI>1</STATUS_INFORMASI>';
			$data .= '<STATUS_HALAMAN_DEPAN>1</STATUS_HALAMAN_DEPAN>';
		$data .= '</DATA>';
		$client = curl_init();
		curl_setopt($client, CURLOPT_URL, $webservice_url);
		curl_setopt($client, CURLOPT_CUSTOMREQUEST, "INSERT");
		curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($client, CURLOPT_POSTFIELDS, $data);
		$response = curl_exec($client);
		curl_close($client); 
		$xml = simplexml_load_string($response);
		
		$informasi->setField("INFORMASI_ID_WEBSITE", $xml->RESPONSE);
	} // end insert server website
	*/
	if($informasi->insert()){
		echo "Data berhasil disimpan|" . $informasi->id; $reqDetilId = $informasi->id;
	}
}
else if($reqMode == "updateIdWeb"){
	$informasi->setField("INFORMASI_ID", $reqId);
	$informasi->setField("INFORMASI_ID_WEBSITE", $reqIdWebsite);
	if($informasi->updateIdWeb()){
		echo "Data berhasil disimpan."; 
	}
}
else
{
	$informasi->setField("INFORMASI_ID", $reqId);
	$informasi->setField("DEPARTEMEN_ID", $reqDepartemen);
	$informasi->setField("NAMA", $reqNama);
	$informasi->setField("NAMA_INGGRIS", $reqNamaEnglish);
	$informasi->setField("KETERANGAN", $reqKeterangan);
	$informasi->setField("KETERANGAN_INGGRIS", $reqKeteranganEnglish);
	$informasi->setField("TANGGAL", dateToDBCheck($reqTanggal));
	$informasi->setField("USER_LOGIN_ID", $userLogin->UID);
	$informasi->setField("STATUS", 1);
	$informasi->setField("STATUS_PUBLISH", $reqPublish);
	$informasi->setField("LAST_UPDATE_USER", $userLogin->nama);
	$informasi->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	
	if($informasi->update()){
		//echo $reqNamaEnglish; $reqDetilId = $informasi->id;
		echo "Data berhasil disimpan."; $reqDetilId = $informasi->id;
	}
}

$cek = formatTextToDb($file->getFileName('reqLinkFile'));
if($cek != "")
{
	$allowed = array(".exe");	$status_allowed='';
	foreach ($allowed as $file_cek) 
	{
		if(preg_match("/$file_cek\$/i", $_FILES['reqLinkFile']['name'])) 
		{
			$status_allowed = 'tidak_boleh';
		}
	}
	
	$renameFile = $reqDetilId.'~'.formatTextToDb($file->getFileName('reqLinkFile'));
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
		$set_file = new Informasi();
		$set_file->setField('INFORMASI_ID', $reqDetilId);	
		$set_file->setField('LINK_FOTO', $insertLinkFile);
		$set_file->update_file();
	}
}

?>