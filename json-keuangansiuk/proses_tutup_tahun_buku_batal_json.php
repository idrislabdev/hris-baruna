<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtNeracaSaldo.php");

$kbbr_thn_buku_d = new KbbrThnBukuD();
$kbbt_neraca_saldo = new KbbtNeracaSaldo();

$reqTahunBuku = httpFilterGet("reqTahunBuku");
$reqTahun 	 = substr($reqTahunBuku, 2, 4);
$reqBulan	 = substr($reqTahunBuku, 0, 2);

$status_open = $kbbr_thn_buku_d->getCountByParams(array("THN_BUKU" => $reqTahun), " AND BLN_BUKU = '13' AND STATUS_CLOSING = 'O' ");

if($status_open == 0)
{
	$pesan = "Tahun pembukuan telah diclose.";	
}
else
{
	$kbbt_neraca_saldo->setField("THN_BUKU", $reqTahun + 1);
	$kbbt_neraca_saldo->updateBatalProses();
	$pesan = "Batal Proses tutup tahun sudah selesai dilakukan.";	
}

$arrFinal = array("PESAN" => $pesan);

echo json_encode($arrFinal);
?>