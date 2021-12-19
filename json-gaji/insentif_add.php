<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/Insentif.php");
include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$insentif = new Insentif();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqJabatan = httpFilterPost("reqJabatan");
$reqJumlah = httpFilterPost("reqJumlah");

if($reqMode == "insert")
{
	$child=new Jabatan();
	$child->selectByParams(array("JABATAN_ID"=>$reqJabatan),-1,-1);
	$child->firstRow();
	$reqKelas= $child->getField("KELAS");
	unset($child);
	
	$insentif->setField("JABATAN_ID", $reqJabatan);
	$insentif->setField("KELAS", $reqKelas);
	$insentif->setField("JUMLAH", dotToNo($reqJumlah));
	
	if($insentif->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$child=new Jabatan();
	$child->selectByParams(array("JABATAN_ID"=>$reqJabatan),-1,-1);
	$child->firstRow();
	$reqKelas= $child->getField("KELAS");
	unset($child);
	
	$insentif->setField("INSENTIF_ID", $reqId);
	$insentif->setField("JABATAN_ID", $reqJabatan);
	$insentif->setField("KELAS", $reqKelas);
	$insentif->setField("JUMLAH", dotToNo($reqJumlah));
	
	if($insentif->update())
		echo "Data berhasil disimpan.";
	
}
?>