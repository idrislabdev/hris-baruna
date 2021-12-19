<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Inventaris.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$inventaris = new Inventaris();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKode = httpFilterPost("reqKode");
$reqNama= httpFilterPost("reqNama");
$reqJenisInventaris=httpFilterPost("reqJenisInventaris");
$reqSpesifikasi=httpFilterPost("reqSpesifikasi");
$reqUmurEkonomis=httpFilterPost("reqUmurEkonomis");

$reqLinkFile = $_FILES["reqLinkFile"];

// echo $reqJenisInventaris;exit();

$inventaris->setField("NAMA", $reqNama);
$inventaris->setField("KODE", $reqKode);
$inventaris->setField("UMUR_EKONOMIS_INVENTARIS", $reqUmurEkonomis);
$inventaris->setField("JENIS_INVENTARIS_ID", ValToNullDB($reqJenisInventaris));
$inventaris->setField("SPESIFIKASI", $reqSpesifikasi);

// echo $reqJenisInventaris;exit();
	
if($reqMode == "insert")
{
	$inventaris->setField("LAST_CREATE_USER", $userLogin->nama);
	$inventaris->setField("LAST_CREATE_DATE", "CURRENT_DATE");	
	
	if($inventaris->insert())
	{
		$reqId= $inventaris->id;
		
		if($reqLinkFile['tmp_name'])
		{
			$inventaris->upload("INVENTARIS", "FILE_GAMBAR", $reqLinkFile['tmp_name'], "INVENTARIS_ID = ".$reqId);
			
			$child=new Inventaris();
			$child->setField("UKURAN", ValToNullDB($reqLinkFile['size']));
			$child->setField("TIPE", ValToNullDB($reqLinkFile['type']));
			$child->setField("INVENTARIS_ID", $reqId);
			$child->updateFormat();
			
			unset($child);
		}
		echo "Data berhasil disimpan.";
	}
}
else
{
	$inventaris->setField("INVENTARIS_ID", $reqId);
	$inventaris->setField("LAST_UPDATE_USER", $userLogin->nama);
	$inventaris->setField("LAST_UPDATE_DATE", "CURRENT_DATE");
	
	if($inventaris->update())
	{
		if($reqLinkFile['tmp_name'])
		{
			$inventaris->upload("INVENTARIS", "FILE_GAMBAR", $reqLinkFile['tmp_name'], "INVENTARIS_ID = ".$reqId);
			
			$child=new Inventaris();
			$child->setField("UKURAN", ValToNullDB($reqLinkFile['size']));
			$child->setField("TIPE", ValToNullDB($reqLinkFile['type']));
			$child->setField("INVENTARIS_ID", $reqId);
			$child->updateFormat();
			//echo $child->query;
			unset($child);
		}
		echo "Data berhasil disimpan.";
	}
	//echo $inventaris->query;
}
?>