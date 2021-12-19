<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/RubahPosting.php");

$rubah_posting = new RubahPosting();
    
$reqNota = httpFilterPost("reqNota");
$reqTanggalNota = httpFilterPost("reqTanggalNota");
$reqStatusClosing= httpFilterPost("reqStatusClosing");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqTanggal= httpFilterPost("reqTanggal");

$reqTahun =  $rubah_posting->getPostingTahun(dateToDbCheck($reqTanggal));
$reqBulan =  $rubah_posting->getPostingBulan(dateToDbCheck($reqTanggal));

$statusPosting = $rubah_posting->getStatusPosting(array("BLN_BUKU" => $reqBulan, "THN_BUKU" => $reqTahun));

if($statusPosting == "C")
{
	echo "Periode telah di closing.";	
	exit;
}

if($statusPosting == "")
{
	echo "Periode belum dibuat.";	
	exit;
}

$rubah_posting->setField("NO_NOTA", $reqNota);
$rubah_posting->setField("TANGGAL_SEBELUM", dateToDbCheck($reqTanggalNota));
$rubah_posting->setField("TANGGAL_POSTING", dateToDbCheck($reqTanggal));
$rubah_posting->setField("CREATED_BY", $userLogin->idUser);
if($rubah_posting->insert())
{
	echo "Data berhasil diproses.";
}
?>