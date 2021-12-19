<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasiDetil.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama= $_POST["reqNama"];
$reqUnit= $_POST["reqUnit"];
$reqHargaSatuan= $_POST["reqHargaSatuan"];
$reqStatusVerifikasi= $_POST["reqStatusVerifikasi"];
$reqJumlah= $_POST["reqJumlah"];
$reqArrayIndex= $_POST["reqArrayIndex"];

$set_loop= $reqArrayIndex;
if($reqMode == "insert")
{
	for($i=0;$i<=$set_loop;$i++)
	{
		if($reqNama[$i] == "")
		{}
		else
		{
			$anggaran_mutasi_detil = new AnggaranMutasiDetil();
			$anggaran_mutasi_detil->setField('ANGGARAN_MUTASI_ID', $reqId);
			$anggaran_mutasi_detil->setField('NAMA', $reqNama[$i]);
			$anggaran_mutasi_detil->setField('UNIT', $reqUnit[$i]);
			$anggaran_mutasi_detil->setField('HARGA_SATUAN', dotToNo($reqHargaSatuan[$i]));
			$anggaran_mutasi_detil->setField('JUMLAH', dotToNo($reqJumlah[$i]));
			$anggaran_mutasi_detil->setField('STATUS_VERIFIKASI', $reqStatusVerifikasi[$i]);
			
			$anggaran_mutasi_detil->insert();
			unset($anggaran_mutasi_detil);
		}
	}
	
	echo "-Data berhasil disimpan.";
}
else
{	
	
	$set= new AnggaranMutasiDetil();
	$set->setField("ANGGARAN_MUTASI_ID", $reqId);
	$set->delete();
	unset($set);
	
	for($i=0;$i<=$set_loop;$i++)
	{
		if($reqNama[$i] == "")
		{}
		else
		{		   
			$anggaran_mutasi_detil = new AnggaranMutasiDetil();
			$anggaran_mutasi_detil->setField('ANGGARAN_MUTASI_ID', $reqId);
			$anggaran_mutasi_detil->setField('NAMA', $reqNama[$i]);
			$anggaran_mutasi_detil->setField('UNIT', $reqUnit[$i]);
			$anggaran_mutasi_detil->setField('HARGA_SATUAN', dotToNo($reqHargaSatuan[$i]));
			$anggaran_mutasi_detil->setField('JUMLAH', dotToNo($reqJumlah[$i]));
			$anggaran_mutasi_detil->setField('STATUS_VERIFIKASI', $reqStatusVerifikasi[$i]);
		
			$anggaran_mutasi_detil->insert();
			if($i == 5)
			$temp = $anggaran_mutasi_detil->query;
			
			unset($anggaran_mutasi_detil);
		}
	}
	
	echo $reqId."-Data berhasil disimpan.";	
	//echo $reqId."-".$set_loop;
}
?>