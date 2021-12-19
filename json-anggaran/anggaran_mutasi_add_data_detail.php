<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbDTmp.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoBukti= httpFilterPost("reqNoBukti");
$reqValuta= httpFilterPost("reqValuta");
$reqValutaNama= httpFilterPost("reqValutaNama");
$reqBuktiPendukung= httpFilterPost("reqBuktiPendukung");
$reqKursValuta= httpFilterPost("reqKursValuta");
$reqTanggalTransaksi= httpFilterPost("reqTanggalTransaksi");
$reqNoFakturPajak= httpFilterPost("reqNoFakturPajak");
$reqPerusahaan= httpFilterPost("reqPerusahaan");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqAlamat= httpFilterPost("reqAlamat");
$reqNoPosting= httpFilterPost("reqNoPosting");
$reqTanggalPosting= httpFilterPost("reqTanggalPosting");


if($reqMode == "insert")
{		
	$kbbt_jur_bb_d_tmp->setField("KD_CABANG", "");
	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", "");
	$kbbt_jur_bb_d_tmp->setField("NO_SEQ", "");
	$kbbt_jur_bb_d_tmp->setField("KD_SUBSIS", "");
	$kbbt_jur_bb_d_tmp->setField("KD_JURNAL", "");
	$kbbt_jur_bb_d_tmp->setField("TIPE_TRANS", "");
	$kbbt_jur_bb_d_tmp->setField("KLAS_TRANS", "");
	$kbbt_jur_bb_d_tmp->setField("KD_BUKU_BESAR", "");
	$kbbt_jur_bb_d_tmp->setField("KD_SUB_BANTU", "");
	$kbbt_jur_bb_d_tmp->setField("KD_BUKU_PUSAT", "");
	$kbbt_jur_bb_d_tmp->setField("KD_VALUTA", "");
	$kbbt_jur_bb_d_tmp->setField("TGL_VALUTA", dateToDBCheck(""));
	$kbbt_jur_bb_d_tmp->setField("KURS_VALUTA", "");
	$kbbt_jur_bb_d_tmp->setField("SALDO_VAL_DEBET", "");
	$kbbt_jur_bb_d_tmp->setField("SALDO_VAL_KREDIT", "");
	$kbbt_jur_bb_d_tmp->setField("SALDO_RP_DEBET", "");
	$kbbt_jur_bb_d_tmp->setField("SALDO_RP_KREDIT", "");
	$kbbt_jur_bb_d_tmp->setField("TANDA_TRANS", "");
	$kbbt_jur_bb_d_tmp->setField("KD_AKTIF", "");
	$kbbt_jur_bb_d_tmp->setField("LAST_UPDATE_DATE", dateToDBCheck(""));
	$kbbt_jur_bb_d_tmp->setField("LAST_UPDATED_BY", "");
	$kbbt_jur_bb_d_tmp->setField("PROGRAM_NAME", "");
	$kbbt_jur_bb_d_tmp->setField("PREV_NO_NOTA", "");
	$kbbt_jur_bb_d_tmp->setField("REF_NOTA_JUAL_BELI", "");
	$kbbt_jur_bb_d_tmp->setField("BAYAR_VIA", "");
	//$kbbt_jur_bb_d_tmp->setField("STATUS_KENA_PAJAK", "");
	

	if($kbbt_jur_bb_d_tmp->insert())
		echo "Data berhasil disimpan.";
}
else
{		
	if($kbbt_jur_bb_d_tmp->update())
		echo "Data berhasil disimpan.";
			
}
?>