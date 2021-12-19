<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBuku.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");

$kbbr_thn_buku_d = new KbbrThnBukuD();
$kbbr_thn_buku = new KbbrThnBuku();
$kbbt_jur_bb = new KbbtJurBb();

$reqTahunBuku = httpFilterGet("reqTahunBuku");
$reqProses1   = httpFilterGet("reqProses1");
$reqProses2   = httpFilterGet("reqProses2");
$reqProses3   = httpFilterGet("reqProses3");   
$reqTahun 	 = substr($reqTahunBuku, 2, 4);
$reqBulan	 = substr($reqTahunBuku, 0, 2);

$kbbr_thn_buku->selectByParams(array("THN_BUKU" => $reqTahun));
$kbbr_thn_buku->firstRow();
$reqKdCabang = $kbbr_thn_buku->getField("KD_CABANG");

$status_open = $kbbr_thn_buku_d->getCountByParams(array("THN_BUKU" => $reqTahun), " AND BLN_BUKU BETWEEN '01' AND '12' AND STATUS_CLOSING = 'O' ");

if($status_open > 0)
{
	$pesan = "Ada bulan buku yang masih OPEN. CLOSE terlebih dahulu untuk melanjutkan proses.";	
}
else
{
	$status_close = $kbbr_thn_buku_d->getCountByParams(array("THN_BUKU" => $reqTahun + 1), " AND BLN_BUKU = '01' AND STATUS_CLOSING = 'C' ");
	
	if($status_close == 1 && $reqProses1 == 1)
	{
		$pesan = "Periode buku januari sudah di CLOSE. Proses pindah saldo awal tidak dapat dilakukan.";	
	}
	else
	{
		if($reqProses1 == 1 && $reqProses2 == 0 && $reqProses3 == 0)
		{
			$kbbt_jur_bb_pindah_saldo = new KbbtJurBb();
			$kbbt_jur_bb_pindah_saldo->setField("TAHUN", $reqTahun);
			$kbbt_jur_bb_pindah_saldo->setField("BULAN", $reqBulan);
			$kbbt_jur_bb_pindah_saldo->setField("KD_CABANG", $reqKdCabang);
			$kbbt_jur_bb_pindah_saldo->callInsertHistory();	
			
			$kbbt_jur_bb->setField("TAHUN", $reqTahun);
			$kbbt_jur_bb->setField("BULAN", $reqBulan);
			$kbbt_jur_bb->setField("KD_CABANG", $reqKdCabang);
			$kbbt_jur_bb->callKbbPindahSaldoTahun();
		}
		elseif($reqProses2 == 1 && $reqProses1 == 0 && $reqProses3 == 0)
		{
			//PROSES_AJT_TAHUNAN
			$kbbt_jur_bb->setField("TAHUN", $reqTahun);
			$kbbt_jur_bb->callProsesAjtTahunan();
		}
		elseif($reqProses3 == 1 && $reqProses1 == 0 && $reqProses2 == 0)
		{
			//KBB_PINDAH_ANGGARAN_AWLTHN -- COBA DIPASTIKAN LAGI APAKAH PARSING TAHUN + 1 !!!!!!!!!!!!!!!
			$kbbt_jur_bb->setField("TAHUN", $reqTahun + 1);
			$kbbt_jur_bb->setField("KD_CABANG", $reqKdCabang);
			$kbbt_jur_bb->callKbbPindahAnggaranAwlThn();
		}
		elseif($reqProses1 == 1 && $reqProses2 == 1 && $reqProses3 == 1)
		{
			$kbbt_jur_bb_pindah_saldo = new KbbtJurBb();
			$kbbt_jur_bb_pindah_saldo->setField("TAHUN", $reqTahun);
			$kbbt_jur_bb_pindah_saldo->setField("BULAN", $reqBulan);
			$kbbt_jur_bb_pindah_saldo->setField("KD_CABANG", $reqKdCabang);
			$kbbt_jur_bb_pindah_saldo->callInsertHistory();	
			
			$kbbt_jur_bb_ajt_tahunan = new KbbtJurBb();
			$kbbt_jur_bb_ajt_tahunan->setField("TAHUN", $reqTahun);
			$kbbt_jur_bb_ajt_tahunan->callProsesAjtTahunan();
						
			$kbbt_jur_bb_pindah_saldo = new KbbtJurBb();
			$kbbt_jur_bb_pindah_saldo->setField("TAHUN", $reqTahun);
			$kbbt_jur_bb_pindah_saldo->setField("BULAN", $reqBulan);
			$kbbt_jur_bb_pindah_saldo->setField("KD_CABANG", $reqKdCabang);
			$kbbt_jur_bb_pindah_saldo->callKbbPindahSaldoTahun();	

			
			/*
			$kbbt_jur_bb_pindah_anggaran = new KbbtJurBb();
			$kbbt_jur_bb_pindah_anggaran->setField("TAHUN", $reqTahun + 1);
			$kbbt_jur_bb_pindah_anggaran->setField("KD_CABANG", $reqKdCabang);
			$kbbt_jur_bb_pindah_anggaran->callKbbPindahAnggaranAwlThn();
			*/
							
		}
		elseif($reqProses1 == 1 && $reqProses2 == 1 && $reqProses3 == 0)
		{
			$kbbt_jur_bb_pindah_saldo = new KbbtJurBb();
			$kbbt_jur_bb_pindah_saldo->setField("TAHUN", $reqTahun);
			$kbbt_jur_bb_pindah_saldo->setField("BULAN", $reqBulan);
			$kbbt_jur_bb_pindah_saldo->setField("KD_CABANG", $reqKdCabang);
			$kbbt_jur_bb_pindah_saldo->callInsertHistory();	
			
			$kbbt_jur_bb_ajt_tahunan = new KbbtJurBb();
			$kbbt_jur_bb_ajt_tahunan->setField("TAHUN", $reqTahun);
			$kbbt_jur_bb_ajt_tahunan->callProsesAjtTahunan();
						
			$kbbt_jur_bb_pindah_saldo = new KbbtJurBb();
			$kbbt_jur_bb_pindah_saldo->setField("TAHUN", $reqTahun);
			$kbbt_jur_bb_pindah_saldo->setField("BULAN", $reqBulan);
			$kbbt_jur_bb_pindah_saldo->setField("KD_CABANG", $reqKdCabang);
			$kbbt_jur_bb_pindah_saldo->callKbbPindahSaldoTahun();	

								
		}
		elseif($reqProses1 == 1 && $reqProses3 == 1 && $reqProses2 == 0)
		{
			$kbbt_jur_bb_pindah_saldo = new KbbtJurBb();
			$kbbt_jur_bb_pindah_saldo->setField("TAHUN", $reqTahun);
			$kbbt_jur_bb_pindah_saldo->setField("BULAN", $reqBulan);
			$kbbt_jur_bb_pindah_saldo->setField("KD_CABANG", $reqKdCabang);
			$kbbt_jur_bb_pindah_saldo->callKbbPindahSaldoTahun();	
			/*
			$kbbt_jur_bb_pindah_anggaran = new KbbtJurBb();
			$kbbt_jur_bb_pindah_anggaran->setField("TAHUN", $reqTahun + 1);
			$kbbt_jur_bb_pindah_anggaran->setField("KD_CABANG", $reqKdCabang);
			$kbbt_jur_bb_pindah_anggaran->callKbbPindahAnggaranAwlThn();
			*/
			$kbbt_jur_bb_pindah_saldo = new KbbtJurBb();
			$kbbt_jur_bb_pindah_saldo->setField("TAHUN", $reqTahun);
			$kbbt_jur_bb_pindah_saldo->setField("BULAN", $reqBulan);
			$kbbt_jur_bb_pindah_saldo->setField("KD_CABANG", $reqKdCabang);
			$kbbt_jur_bb_pindah_saldo->callInsertHistory();	
							
		}
		elseif($reqProses2 == 1 & $reqProses3 == 1 && $reqProses1 == 0)
		{

			$kbbt_jur_bb_ajt_tahunan = new KbbtJurBb();
			$kbbt_jur_bb_ajt_tahunan->setField("TAHUN", $reqTahun);
			$kbbt_jur_bb_ajt_tahunan->callProsesAjtTahunan();
			/*
			$kbbt_jur_bb_pindah_anggaran = new KbbtJurBb();
			$kbbt_jur_bb_pindah_anggaran->setField("TAHUN", $reqTahun + 1);
			$kbbt_jur_bb_pindah_anggaran->setField("KD_CABANG", $reqKdCabang);
			$kbbt_jur_bb_pindah_anggaran->callKbbPindahAnggaranAwlThn();
			*/				
		}
		
		$pesan = "Proses sudah selesai dilakukan.";
		
	}	
}

$arrFinal = array("PESAN" => $pesan);

echo json_encode($arrFinal);
?>