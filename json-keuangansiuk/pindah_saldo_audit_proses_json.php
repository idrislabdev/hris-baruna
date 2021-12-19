<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");

$kbbt_jur_bb = new KbbtJurBb();
$kbbr_thn_buku_d = new KbbrThnBukuD();

$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqBukuTahun = httpFilterGet("reqBukuTahun");


$reqBulan = substr($reqPeriode,0, 2);
$reqTahun = substr($reqPeriode,2, 4);

$reqBulanBuku = substr($reqBukuTahun,0, 2);
$reqTahunBuku = substr($reqBukuTahun,2, 4);


$arrId = explode(",", $reqId);


$status_closing = $kbbr_thn_buku_d->getStatusClosing(array("THN_BUKU" => $reqTahun, "BLN_BUKU" => $reqBulan));

if($status_closing == "O")
{
	$pesan = "Periode buku belum di close.";	
}
else
{
	for($i=0;$i<count($arrId);$i++)
	{
		
		$kbbt_jur_bb = new KbbtJurBb();
		
		$kbbt_jur_bb->setField("THNBLN_BUKU", $reqTahunBuku."".$reqBulanBuku);
		$kbbt_jur_bb->setField("NO_NOTA", $arrId[$i]);
		$kbbt_jur_bb->callProsesMutTahun();
		unset($kbbt_jur_bb);	
	}
	
	$pesan = "Proses sudah selesai dilakukan.";
		
}


$arrFinal = array("PESAN" => $pesan);

echo json_encode($arrFinal);
?>