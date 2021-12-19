<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTrans.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");


$reqId = httpFilterPost("reqId");
$reqRowId = httpFilterPost("reqRowId");
$reqTipeTrans= $_POST["reqTipeTrans"];
$reqKode= $_POST["reqKode"];
$reqKeterangan= $_POST["reqKeterangan"];
$reqNama= $_POST["reqNama"];
$reqStatusPostingJurnal= $_POST["reqStatusPostingJurnal"];
$reqStatusPajak= $_POST["reqStatusPajak"];
$reqStatusMaterai= $_POST["reqStatusMaterai"];
$reqKodePajak1= $_POST["reqKodePajak1"];
$reqKodePajak2= $_POST["reqKodePajak2"];

$reqArrayIndex= $_POST["reqArrayIndex"];
$set_loop= $reqArrayIndex;

for($i=0;$i<=$set_loop;$i++)
{
	$index = $i;
	if($reqTipeTrans[$i] == "")
	{
		$transaksi_tipe= new KbbrTipeTrans();
		$transaksi_tipe->setField("KD_CABANG", '11');
		$transaksi_tipe->setField("KD_SUBSIS", $reqId);
		$transaksi_tipe->setField("KD_JURNAL", $reqRowId);
		
		$transaksi_tipe->setField("TIPE_TRANS", $reqKode[$index]);
		$transaksi_tipe->setField("TIPE_DESC", $reqKeterangan[$index]);
		$transaksi_tipe->setField("AKRONIM_DESC", $reqNama[$index]);
		$transaksi_tipe->setField("ID_REF_JURNAL", 'MODULSIUK');
		$transaksi_tipe->setField("AUTO_MANUAL", "");
		$transaksi_tipe->setField("CONTRA_JURNAL", "");
		$transaksi_tipe->setField("POST_JURNAL", $reqStatusPostingJurnal[$index]);
		$transaksi_tipe->setField("CLOSING_JURNAL", "");
		$transaksi_tipe->setField("ADA_PAJAK", $reqStatusPajak[$index]);
		$transaksi_tipe->setField("KD_PAJAK1", $reqKodePajak1[$index]);
		$transaksi_tipe->setField("KD_PAJAK2", $reqKodePajak2[$index]);
		$transaksi_tipe->setField("KD_PAJAK3", "");
		$transaksi_tipe->setField("BB_GAIN_VALAS", "");
		$transaksi_tipe->setField("BB_LOSS_VALAS", "");
		$transaksi_tipe->setField("BB_GAIN_LOSS", "");
		$transaksi_tipe->setField("KD_AKTIF", "");
		$transaksi_tipe->setField("LAST_UPDATED_BY", $userLogin->nama);
		$transaksi_tipe->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		$transaksi_tipe->setField("PROGRAM_NAME", "KBB_R_TEMPL_JURNAL_IMAIS");
		$transaksi_tipe->setField("TIPE_LR_VALAS", "");
		$transaksi_tipe->setField("FLAG_METERAI", $reqStatusMaterai[$index]);
		$transaksi_tipe->insert();
		unset($transaksi_tipe);
	}
	else
	{
		$transaksi_tipe= new KbbrTipeTrans();
		$transaksi_tipe->setField("TIPE_TRANS", $reqKode[$index]);
		$transaksi_tipe->setField("TIPE_DESC", $reqKeterangan[$index]);
		$transaksi_tipe->setField("AKRONIM_DESC", $reqNama[$index]);
		$transaksi_tipe->setField("POST_JURNAL", $reqStatusPostingJurnal[$index]);
		$transaksi_tipe->setField("FLAG_METERAI", $reqStatusMaterai[$index]);
		$transaksi_tipe->setField("ADA_PAJAK", $reqStatusPajak[$index]);
		$transaksi_tipe->setField("KD_PAJAK1", $reqKodePajak1[$index]);
		$transaksi_tipe->setField("KD_PAJAK2", $reqKodePajak2[$index]);
		$transaksi_tipe->setField("LAST_UPDATED_BY", $userLogin->nama);
		$transaksi_tipe->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		$transaksi_tipe->setField("TIPE_TRANS_ID", $reqTipeTrans[$index]);
		$transaksi_tipe->update();
		unset($transaksi_tipe);
		
		$transaksi_tipe_detil= new KbbrTipeTransD();
		$transaksi_tipe_detil->setField("TIPE_TRANS_ID", $reqTipeTrans[$index]);
		$transaksi_tipe_detil->setField("LAST_UPDATED_BY", $userLogin->nama);
		$transaksi_tipe_detil->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		$transaksi_tipe_detil->updateTipeTrans();
		unset($transaksi_tipe_detil);
	}
}
echo "Data Berhasil Disimpan";
?>