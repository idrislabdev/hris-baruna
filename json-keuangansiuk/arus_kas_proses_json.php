<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/LaporanKeuangan.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");

$laporan_keuangan = new LaporanKeuangan();
$kbbr_thn_buku_d = new KbbrThnBukuD();

$reqPeriode = httpFilterGet("reqPeriode");

$reqBulan = substr($reqPeriode,0, 2);
$reqTahun = substr($reqPeriode,2, 4);

$status_closing = $kbbr_thn_buku_d->getStatusClosing(array("THN_BUKU" => $reqTahun, "BLN_BUKU" => $reqBulan));

if($status_closing == "C")
{
	$ada = $laporan_keuangan->getCountKbbrLaporanLb4(array("THN_BUKU" => $reqTahun, "BLN_BUKU" => $reqBulan));
	
	if($ada == 0)
	{
		$laporan_keuangan->setField("BULAN", $reqBulan);
		$laporan_keuangan->setField("TAHUN", $reqTahun);	
		$laporan_keuangan->callLb4();				
	}
}
else
{
	if((int)$reqBulan == 15 && $reqTahun == "2015")
	{
		$laporan_keuangan->setField("BULAN", $reqBulan);
		$laporan_keuangan->setField("TAHUN", $reqTahun);	
		$laporan_keuangan->callBulan15();
	}
	else
	{
		if((int)$reqBulan <= 10 && $reqTahun == "2015")
		{}  
		else
		{ 
		
			$laporan_keuangan->setField("BULAN", $reqBulan);
			$laporan_keuangan->setField("TAHUN", $reqTahun);	
			$laporan_keuangan->callArusKas();
		}
		
		if((int)$reqBulan <= 10 && $reqTahun == "2015")
		{}
		else
		{
			$laporan_keuangan->setField("BULAN", $reqBulan);
			$laporan_keuangan->setField("TAHUN", $reqTahun);	
			$laporan_keuangan->callLb4New();		
			$laporan_keuangan->callLb4New();		
		}
	}
}

$arrFinal = array("STATUS" => 1);

echo json_encode($arrFinal);
?>