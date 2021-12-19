<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisPenyusutanDetil.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqInventarisRuanganId= $_POST["reqInventarisRuanganId"];

if($reqMode == "insert")
{
	$id=$reqId;
	
	$set= new InventarisPenyusutanDetil();
	$set->setField("INVENTARIS_PENYUSUTAN_ID", $id);
	$set->delete();
	unset($set);
	
	for($i=0; $i < count($reqInventarisRuanganId); $i++)
	{
		if($reqInventarisRuanganId[$i] == ""){}
		else
		{
			$inventaris_penyusutan_detil = new InventarisPenyusutanDetil();
			$inventaris_ruangan = new InventarisRuangan();
			
			$inventaris_penyusutan_detil->setField("INVENTARIS_PENYUSUTAN_ID", $id);
			$inventaris_penyusutan_detil->setField("INVENTARIS_RUANGAN_ID", $reqInventarisRuanganId[$i]);
			if($inventaris_penyusutan_detil->insert())
			{
				/* HILANGKAN INVENTARIS DARI RUANGANNYA */
				$inventaris_ruangan->setField("ALASAN_HAPUS", "DIMUSNAHKAN");
				$inventaris_ruangan->setField("INVENTARIS_RUANGAN_ID", $reqInventarisRuanganId[$i]);
				$inventaris_ruangan->delete();
			}
			
			unset($inventaris_penyusutan_detil);
			unset($inventaris_ruangan);
		}
	}
	
	echo $id."-Data berhasil disimpan.";
	//echo $arsip->query;
}
?>