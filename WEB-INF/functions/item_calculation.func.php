<?php
include_once("../WEB-INF/classes/base/Item.php");
include_once("../WEB-INF/classes/base/Peminjaman.php");


function calcStok($IID)
{
	$item = new Item();
	$peminjaman = new Peminjaman();
	
	$jmlDipinjam = $peminjaman->getCountExactByParams(array("IID" => $IID, "status_pinjam" => "0"));
	
	// get real stok
	$item->selectExactByParams(array("i.IID" => $IID));
	$item->firstRow();
	$jmlStok = $item->getField("i_stok");
	
	$sisa = $jmlStok - $jmlDipinjam;

	return $sisa;
}

function getFuckinDay($_date) {
	$arrDate = explode("-", $_date);
	return $arrDate[2];
}

function getFuckinMonth($_date) {
	$arrDate = explode("-", $_date);
	return $arrDate[1];
}

function getFuckinYear($_date) {
	$arrDate = explode("-", $_date);
	return $arrDate[0];
}

// $date = YYYY-MM-DD
function calcTanggalKembali($tglPinjam, $day)
{
	$srcDay = getFuckinDay($tglPinjam);
	$srcMonth = getFuckinMonth($tglPinjam);
	$srcYear = getFuckinYear($tglPinjam);
	
	$srcDay += $day;
	
	//barat
	//return date("m-d-Y", mktime (0,0,0,$srcMonth,$srcDay,$srcYear));
	
	//indo
	return date("d-m-Y", mktime (0,0,0,$srcMonth,$srcDay,$srcYear));
}
?>