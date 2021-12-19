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
$reqTglPosting = httpFilterGet("reqTglPosting");
$arrTglPosting = explode("-", $reqTglPosting);

$reqBulan = $arrTglPosting[1];
$reqTahun = $arrTglPosting[2];

$arrId = explode(",", $reqId);

$error = 0;
for($i=0;$i<count($arrId);$i++)
{
	if($error == 0)
	{
		$kbbt_jur_bb = new KbbtJurBb();
		
		$kbbt_jur_bb->selectByParamsSimple(array("NO_NOTA" => $arrId[$i]));
		$kbbt_jur_bb->firstRow();
		
		
		$reqBulan = getMonth($reqTglPosting);
		if($reqBulan == 12)
		{
			$reqBulan = $kbbt_jur_bb->getField("BLN_BUKU");
		}
	
		$status_closing = $kbbr_thn_buku_d->getStatusClosing(array("THN_BUKU" => $reqTahun, "BLN_BUKU" => $reqBulan));
		if($status_closing == 'C') 
		{
			$pesan = "Posting ditolak, bulan/tahun buku akuntansi ".$reqBulan."/".$reqTahun." sudah di-Close atau tidak tercatat pada SIUK.";
			$error = 1;
		}
		else
		{
			
			if($kbbt_jur_bb->getField("BLN_BUKU") == 15 && $reqBulan != $kbbt_jur_bb->getField("BLN_BUKU"))
			{
				$pesan = "Posting Ditolak, No.Bukti ".$arrId[$i]." bukan Transaksi Bulan Periode ".$reqBulan." (AJP)";	
				$error = 1;
			}
			elseif($kbbt_jur_bb->getField("BLN_BUKU") != 15 && $reqBulan == 15)
			{		          
				$pesan = "Posting Ditolak, No.Bukti ".$arrId[$i]." bukan Transaksi Bulan Periode ".$reqBulan." (AJT)".$kbbt_jur_bb->getField("BLN_BUKU");
				$error = 1;
			}			
		    else
			{
				$kbbt_jur_bb->setField("NO_NOTA", $arrId[$i]);
				$kbbt_jur_bb->setField("TGL_POSTING", dateToDBCheck($reqTglPosting));
				$kbbt_jur_bb->updatePostingKoreksiAudit();

				$kbbt_jur_bb->setField("NO_NOTA", $arrId[$i]);
				$kbbt_jur_bb->setField("KD_SUBSIS", $kbbt_jur_bb->getField("KD_SUBSIS"));
				$no_posting = $kbbt_jur_bb->callPosting();
				
				if($no_posting == "")
				{}
				else
				{
					if($kbbt_jur_bb->getField("JEN_JURNAL") == "JRR")
					{
						$no_dokumen = $kbbt_jur_bb->getField("NO_REG_KASIR");
						
						if($no_dokumen == "")
							$no_dokumen = $kbbt_jur_bb->getNoDokumen($kbbt_jur_bb->getField("JEN_JURNAL"));
					}					

					if($kbbt_jur_bb->getField("PROGRAM_NAME") == 'KBB_GENERATE_JRR_KURS')
						$program_name = 'KBB_GENERATE_JRR_KURS';
					else
						$program_name = 'KBB_INQ_POST_AUDIT_IMAIS';	
						
					$kbbt_jur_bb->setField("NO_NOTA", $arrId[$i]);
					$kbbt_jur_bb->setField("NO_REG_KASIR", $no_dokumen);
					$kbbt_jur_bb->setField("TGL_POSTING", dateToDBCheck($reqTglPosting));
					$kbbt_jur_bb->setField("NO_POSTING", $no_posting);
					$kbbt_jur_bb->setField("PROGRAM_NAME", $program_name);
					$kbbt_jur_bb->updateAfterPostingKoreksiAudit();		        	
	
					$pesan = "Posting data berhasil.";
				}
			}
		}
	}
	
	unset($kbbt_jur_bb);	
}


//if($error == 1)
//	$pesan = "Proses gagal.";

$arrFinal = array("PESAN" => $pesan);

echo json_encode($arrFinal);
?>