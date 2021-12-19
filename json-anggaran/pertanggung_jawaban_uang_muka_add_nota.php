<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranTgjawab.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$anggaran_tgjawab = new AnggaranTgjawab();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId = httpFilterPost("reqRowId");

$reqNomor= httpFilterPost("reqNomor");
$reqNama= httpFilterPost("reqNama");
$reqJumlah= httpFilterPost("reqJumlah");
$reqTanggal= httpFilterPost("reqTanggal");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqLinkFile = $_FILES["reqLinkFile"];
$reqNota = httpFilterPost("reqNota");

$anggaran_tgjawab->setField("NOMOR", $reqNomor);
$anggaran_tgjawab->setField("TANGGAL", dateToDBCheck($reqTanggal));
$anggaran_tgjawab->setField("NAMA", $reqNama);
$anggaran_tgjawab->setField("JUMLAH", dotToNo($reqJumlah));
$anggaran_tgjawab->setField("ANGGARAN_MUTASI_ID", $reqId);

if($reqMode == "insert")
{
	
	if($anggaran_tgjawab->insert()){
		$reqRowId= $anggaran_tgjawab->id;
		
		if($reqLinkFile['tmp_name'])
		{
			$anggaran_tgjawab->upload("PEL_ANGGARAN.ANGGARAN_TGJAWAB", "FILE_GAMBAR", $reqLinkFile['tmp_name'], "ANGGARAN_TGJAWAB_ID = ".$reqRowId);
			
			$child=new AnggaranTgjawab();
			$child->setField("FILE_UKURAN", ValToNullDB($reqLinkFile['size']));
			$child->setField("FILE_TIPE", ValToNullDB($reqLinkFile['type']));
			$child->setField("ANGGARAN_TGJAWAB_ID", $reqRowId);
			$child->updateFormat();
			unset($child);
		}
			
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $anggaran_tgjawab->query;
}
else
{
	$anggaran_tgjawab->setField("ANGGARAN_TGJAWAB_ID", $reqRowId);
	if($anggaran_tgjawab->update()){
		
		if($reqLinkFile['tmp_name'])
		{
			$anggaran_tgjawab->upload("PEL_ANGGARAN.ANGGARAN_TGJAWAB", "FILE_GAMBAR", $reqLinkFile['tmp_name'], "ANGGARAN_TGJAWAB_ID = ".$reqRowId);
			
			$child=new AnggaranTgjawab();
			$child->setField("FILE_UKURAN", ValToNullDB($reqLinkFile['size']));
			$child->setField("FILE_TIPE", ValToNullDB($reqLinkFile['type']));
			$child->setField("ANGGARAN_TGJAWAB_ID", $reqRowId);
			$child->updateFormat();
			unset($child);
		}
		
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $anggaran_tgjawab->query;
}
?>