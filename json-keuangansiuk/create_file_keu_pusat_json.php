<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KeuanganPusat.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");

$reqTahunBuku = httpFilterGet("reqTahunBuku");
$reqTahun 	 = substr($reqTahunBuku, 2, 4);
$reqBulan	 = substr($reqTahunBuku, 0, 2);

$reqTahunBukuAkhir = httpFilterGet("reqTahunBukuAkhir");
$reqTahunAkhir 	 = substr($reqTahunBukuAkhir, 2, 4);
$reqBulanAkhir	 = substr($reqTahunBukuAkhir, 0, 2);


ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);


$kbbr_thn_buku_d = new KbbrThnBukuD();
$kbbr_thn_buku_d->selectByParams(array(), -1, -1, " ", " ORDER BY THN_BUKU ASC, BLN_BUKU ASC ");
$exec = 0;
$reqDelete = 1;
while($kbbr_thn_buku_d->nextRow())
{
	if($kbbr_thn_buku_d->getField("BLN_BUKU") == $reqBulan && $kbbr_thn_buku_d->getField("THN_BUKU") == $reqTahun)
		$exec = 1;
	
	if($exec == 1)
	{
		$keuangan_pusat = new KeuanganPusat();
		$keuangan_pusat->setField("BULAN", $kbbr_thn_buku_d->getField("BLN_BUKU"));
		$keuangan_pusat->setField("TAHUN", $kbbr_thn_buku_d->getField("THN_BUKU"));
		$keuangan_pusat->setField("DELETE", $reqDelete);
		$keuangan_pusat->callCreateMaster();
		$keuangan_pusat->callCreateTranb();
		$keuangan_pusat->callPiutangMaster();
		$keuangan_pusat->callMasters();
		$keuangan_pusat->callControlData();	
		unset($keuangan_pusat);	
		$reqDelete = 0;
	}
	
	if($kbbr_thn_buku_d->getField("BLN_BUKU") == $reqBulanAkhir && $kbbr_thn_buku_d->getField("THN_BUKU") == $reqTahunAkhir)
	{
		break;
	}
	
}


$pesan = "Proses selesai.";
	
$arrFinal = array("PESAN" => $pesan);

echo json_encode($arrFinal);
?>