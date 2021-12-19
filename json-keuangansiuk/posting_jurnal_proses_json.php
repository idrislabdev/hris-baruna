<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");

$kbbt_jur_bb = new KbbtJurBb();
$kbbr_thn_buku_d = new KbbrThnBukuD();

$reqId = httpFilterGet("reqId");
$reqTanggal = httpFilterGet("reqTanggal");
$arrId = explode(",", $reqId);

$reqTanggalPosting = $reqTanggal;
$reqTanggal = dateToDB($reqTanggal);

$reqBulan = getMonth($reqTanggal);
$reqTahun = getYear($reqTanggal);

$kbbr_thn_buku_d->selectByParams(array("TAHUN" => $reqTahun, "BULAN" => $reqBulan));
$kbbr_thn_buku_d->firstRow();

$status_closing = $kbbr_thn_buku_d->getField("STATUS_CLOSING");
$reqBulan = $kbbr_thn_buku_d->getField("BLN_BUKU");
$reqTahun = $kbbr_thn_buku_d->getField("THN_BUKU");

//$status_closing = $kbbr_thn_buku_d->getStatusClosing(array("THN_BUKU" => $reqTahun, "BLN_BUKU" => $reqBulan));

if($status_closing == "")
	$pesan = "[]Posting ditolak,Bulan buku belum dibuat.";
else
{
	if($status_closing == "C" && $reqBulan < 12)
	{
		$pesan = "[]Posting ditolak, bulan/tahun buku akuntansi ".$reqBulan."/".$reqTahun." sudah di-close atau tidak tercatat di SIUK.";	
	}
	else
	{
		$error = 0;
		$daftar_posting = "";
		for($i=0;$i<count($arrId);$i++)
		{
			if($error == 0)
			{
				$no_posting = "";

				$kbbt_jur_bb = new KbbtJurBb();
				$kbbt_jur_bb->selectByParamsSimple(array("NO_NOTA" => $arrId[$i]));
				$kbbt_jur_bb->firstRow();
				
				if($kbbt_jur_bb->getField("BLN_BUKU") == 14 && $reqBulan !== $kbbt_jur_bb->getField("BLN_BUKU"))
				{
					$pesan = "[]Posting Ditolak, No.Bukti ".$arrId[$i]." bukan Transaksi Bulan Periode AJP";	
					$error = 1;
				}
				elseif($kbbt_jur_bb->getField("BLN_BUKU") !== 14 && $reqBulan == 14)
				{		          
					$pesan = "[]Posting Ditolak, No.Bukti ".$arrId[$i]." bukan Transaksi Bulan Periode AJT";
					$error = 1;
				}
				else
				{
					
					
					/* CEK APAKAH ADA REKENING 5 YANG BELUM DIENTRI BUKU PUSAT */
					$kbbt_jur_bb_d = new KbbtJurBbD();
					$adaRekening5tanpaPusat = $kbbt_jur_bb_d->getValidasiPosting($arrId[$i]);
					
					if($adaRekening5tanpaPusat == 0)
					{
						
						$kbbt_jur_bb->setField("NO_NOTA", $arrId[$i]);
						$kbbt_jur_bb->setField("BLN_BUKU", $reqBulan);
						$kbbt_jur_bb->setField("THN_BUKU", $reqTahun);
						$kbbt_jur_bb->setField("TGL_POSTING", dateToDBCheck($reqTanggalPosting));
						$kbbt_jur_bb->updatePosting();
						
						$kbbt_jur_bb->setField("NO_NOTA", $arrId[$i]);
						$kbbt_jur_bb->setField("KD_SUBSIS", $kbbt_jur_bb->getField("KD_SUBSIS"));
						$no_posting = $kbbt_jur_bb->callPosting();
						$kbbt_jur_bb->setField("NO_NOTA", $arrId[$i]);
						$kbbt_jur_bb->setField("NO_POSTING", $no_posting);
						$kbbt_jur_bb->setField("TGL_POSTING", dateToDBCheck($reqTanggalPosting));
						$kbbt_jur_bb->updateAfterPosting();
											
						if($daftar_posting == "")
							$daftar_posting = $arrId[$i];
						else
							$daftar_posting .= ",".$arrId[$i];
						
						$pesan = $daftar_posting."[]Posting data berhasil.";	
					}
					else
					{
						if($notaSalahEntri == "")
							$notaSalahEntri = $arrId[$i];	
						else							
							$notaSalahEntri .= ",".$arrId[$i];	
					}
					
			
				}
			}
			
			unset($kbbt_jur_bb);	
		}
	
	}
}

if($notaSalahEntri == "")
{}
else
{
	if(trim($pesan) == "")
		$pesan = "[]Terdapat Posting Gagal karena rekening 5 (lima) belum dientri buku pusat pada NOTA : ".$notaSalahEntri; 
	else
		$pesan .= " Terdapat Posting Gagal karena rekening 5 (lima) belum dientri buku pusat pada NOTA : ".$notaSalahEntri; 
}


if($error == 1)
	$pesan = "[]Proses gagal.";

$arrFinal = array("PESAN" => $pesan);

echo json_encode($arrFinal);
?>