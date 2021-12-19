<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Lokasi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/utils/FileHandler.php");
include_once("../WEB-INF/functions/image.func.php");

$lokasi = new Lokasi();
$file   = new FileHandler();

$FILE_DIR = "../masterdata/uploads/lokasi/";
$_THUMB_PREFIX = "z__thumb_";

$reqId 				= httpFilterPost("reqId");
$reqMode 			= httpFilterPost("reqMode");
$reqNama 			= httpFilterPost("reqNama");
$reqKeterangan 		= httpFilterPost("reqKeterangan");
$reqKode	 		= httpFilterPost("reqKode");
$reqKodeGLPusat		= httpFilterPost("reqKodeGLPusat");
$reqSumberDana		= httpFilterPost("reqSumberDana");
$reqAlamat	 		= httpFilterPost("reqAlamat");
$reqX 				= httpFilterPost("reqX");
$reqY 				= httpFilterPost("reqY");
	
$reqLinkFile   = $_FILES['reqLinkFile'];
$reqLinkFileTemp = httpFilterPost("reqLinkFileTemp");

if($reqMode == "insert")
{	
	$lokasi->setField("LOKASI_ID", $reqId);
	$lokasi->setField("NAMA", $reqNama);
	$lokasi->setField("KODE", $reqKode);
	$lokasi->setField("KETERANGAN", $reqKeterangan);
	$lokasi->setField("ALAMAT", $reqAlamat);
	$lokasi->setField("X", $reqX);
	$lokasi->setField("Y", $reqY);
	$lokasi->setField("KODE_GL_PUSAT", $reqKodeGLPusat);
	$lokasi->setField("SUMBER_DANA", $reqSumberDana);
	$lokasi->setField("LAST_CREATE_USER", $userLogin->nama);
	$lokasi->setField("LAST_CREATE_DATE", "CURRENT_DATE");
	if($lokasi->insert())
	{	
		echo "Data berhasil disimpan.";
	}
}
else
{
	$lokasi->setField("LOKASI_ID", $reqId);
	$lokasi->setField("NAMA", $reqNama);
	$lokasi->setField("KODE", $reqKode);
	$lokasi->setField("KETERANGAN", $reqKeterangan);
	$lokasi->setField("ALAMAT", $reqAlamat);
	$lokasi->setField("X", $reqX);
	$lokasi->setField("Y", $reqY);
	$lokasi->setField("KODE_GL_PUSAT", $reqKodeGLPusat);
	$lokasi->setField("SUMBER_DANA", $reqSumberDana);
	
	$lokasi->setField("LAST_UPDATE_USER", $userLogin->nama);
	$lokasi->setField("LAST_UPDATE_DATE", "CURRENT_DATE");	
		
	if($lokasi->update())
		echo "Data berhasil disimpan.";
	
}
?>