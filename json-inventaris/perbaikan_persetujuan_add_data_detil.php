<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisPerbaikanDetil.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$inventaris_perbaikan_persetujuan_detil = new InventarisPerbaikanDetil();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId= httpFilterPost("reqRowId");

$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqLinkFile = $_FILES["reqLinkFile"];

$inventaris_perbaikan_persetujuan_detil->setField("NAMA", $reqNama);
$inventaris_perbaikan_persetujuan_detil->setField("KETERANGAN", $reqKeterangan);
$inventaris_perbaikan_persetujuan_detil->setField("INVENTARIS_PERBAIKAN_ID", $reqId);
$inventaris_perbaikan_persetujuan_detil->setField("UKURAN", ValToNullDB($req));
$inventaris_perbaikan_persetujuan_detil->setField("TIPE", ValToNullDB($req));

if($reqLinkFile['type']=="image/jpeg")
{			
	if($reqMode == "insert")
	{
		if($inventaris_perbaikan_persetujuan_detil->insert())
		{
			$reqRowId= $inventaris_perbaikan_persetujuan_detil->id;
			
			if($reqLinkFile['tmp_name'])
			{
					$inventaris_perbaikan_persetujuan_detil->upload("INVENTARIS_PERBAIKAN_DETIL", "FILE_GAMBAR", $reqLinkFile['tmp_name'], "INVENTARIS_PERBAIKAN_DETIL_ID = ".$reqRowId);
					
					$child=new InventarisPerbaikanDetil();
					$child->setField("UKURAN", ValToNullDB($reqLinkFile['size']));
					$child->setField("TIPE", ValToNullDB($reqLinkFile['type']));
					$child->setField("INVENTARIS_PERBAIKAN_DETIL_ID", $reqRowId);
					$child->updateFormat();
					
					unset($child);
			}		
			echo $reqId."-Data berhasil disimpan.";
		}
	}
	else
	{
		$inventaris_perbaikan_persetujuan_detil->setField("INVENTARIS_PERBAIKAN_DETIL_ID", $reqRowId);
		
		if($inventaris_perbaikan_persetujuan_detil->update())
		{
			if($reqLinkFile['tmp_name'])
			{
					$inventaris_perbaikan_persetujuan_detil->upload("INVENTARIS_PERBAIKAN_DETIL", "FILE_GAMBAR", $reqLinkFile['tmp_name'], "INVENTARIS_PERBAIKAN_DETIL_ID = ".$reqRowId);
					
					$child=new InventarisPerbaikanDetil();
					$child->setField("UKURAN", ValToNullDB($reqLinkFile['size']));
					$child->setField("TIPE", ValToNullDB($reqLinkFile['type']));
					$child->setField("INVENTARIS_PERBAIKAN_DETIL_ID", $reqRowId);
					
					$child->updateFormat();
					unset($child);
			}
			echo $reqId."-Data berhasil disimpan.-".$reqRowId;
		}
	}
}
else
{
	echo $reqId."-Data yang diupload harus JPG";
}
?>