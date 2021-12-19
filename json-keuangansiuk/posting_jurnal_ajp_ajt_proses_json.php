<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");

$kbbt_jur_bb = new KbbtJurBb();
$kbbr_thn_buku_d = new KbbrThnBukuD();

$reqId = httpFilterGet("reqId");
$reqTglPosting = httpFilterGet("reqTanggalPosting");

$arrId = explode(",", $reqId);

$error = 0;
for($i=0;$i<count($arrId);$i++)
{
	if($error == 0)
	{
		$kbbt_jur_bb = new KbbtJurBb();
		$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
		
		$kbbt_jur_bb->selectByParamsSimple(array("NO_NOTA" => $arrId[$i]));
		$kbbt_jur_bb->firstRow();		
		
		$kbbt_jur_bb->setField("NO_NOTA", $arrId[$i]);
		$kbbt_jur_bb->setField("TGL_POSTING", "TO_DATE('".$reqTglPosting."', 'DD-MM-YYYY')");
		$kbbt_jur_bb->updatePostingAjpAjt();
		
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
			
			$kbbt_jur_bb->setField("NO_NOTA", $arrId[$i]);
			$kbbt_jur_bb->setField("NO_POSTING", $no_posting);
			$kbbt_jur_bb->setField("TGL_POSTING", "TO_DATE('".$reqTglPosting."', 'DD-MM-YYYY')" );
			$kbbt_jur_bb->updateAfterPosting();
			
			
			if($kbbt_jur_bb->getField("PROGRAM_NAME") == 'KBB_GENERATE_JRR_KURS')
				$program_name = 'KBB_GENERATE_JRR_KURS';
			else
				$program_name = 'KBB_INQ_POST_AKHIR_IMAIS';					
			
			$kbbt_jur_bb->setField("NO_NOTA", $arrId[$i]);
			$kbbt_jur_bb->setField("NO_REG_KASIR", $no_dokumen);			
			$kbbt_jur_bb->setField("PROGRAM_NAME", $program_name);			
			$kbbt_jur_bb->updateAfterPostingAjpAjt();					
			
			/*
			$kbbt_jur_bb_tmp->setField("NO_NOTA", $arrId[$i]);
			$kbbt_jur_bb_tmp->setField("NO_POSTING", $no_posting);			
			$kbbt_jur_bb_tmp->setField("PROGRAM_NAME", $program_name);			
			$kbbt_jur_bb_tmp->updateAfterPostingAjpAjt();		
			*/			
			
		}
		
		$pesan = "Posting data berhasil.";
	}
	
	unset($kbbt_jur_bb);
	unset($kbbt_jur_bb_tmp);	
}

if($error == 1)
	$pesan = "Proses gagal.";


$arrFinal = array("PESAN" => $pesan);

echo json_encode($arrFinal);
?>