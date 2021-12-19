<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-gaji/ProsesGajiLock.php");
include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");



$reqPeriode = httpFilterGet("reqPeriode");
$reqJenisProses = httpFilterGet("reqJenisProses");
$reqNotaDinas1 = httpFilterGet("reqNotaDinas1");
$reqNotaDinas2 = httpFilterGet("reqNotaDinas2");


$proses_gaji_lock = new ProsesGajiLock();
$gaji_awal_bulan = new GajiAwalBulan();
$gaji_awal_bulan_detil = new GajiAwalBulan();
$gaji_awal_bulan_jkm = new GajiAwalBulan();
$gaji_awal_bulan_jkm_detil = new GajiAwalBulan();

if($reqJenisProses == "GAJI_PKWT")
{
	$reqJenisPegawaiId = 3;
	$reqKeterangan = "PEMBY PENGHASILAN PEGAWAI PKWT PT. PELINDO MARINE SERVICE BULAN";
	$reqKeteranganPotongan = "POTONGAN A/ PEMBY PENGHASILAN PEGAWAI PKWT PT. PELINDO MARINE SERVICE BULAN";
	$reqJenisPegawai = "PEGAWAI PKWT";
}
elseif($reqJenisProses == "GAJI_CAPEG")
{
	$reqJenisPegawaiId = 5;
	$reqKeterangan = "PEMBY PENGHASILAN PEGAWAI PTTPK PT. PELINDO MARINE SERVICE BULAN";
	$reqKeteranganPotongan = "POTONGAN A/ PEMBY PENGHASILAN PEGAWAI PTTPK PT. PELINDO MARINE SERVICE BULAN";
	$reqJenisPegawai = "PEGAWAI PTTPK";
}
elseif($reqJenisProses == "GAJI_DIREKSI")
{
	$reqJenisPegawaiId = 6;
	$reqKeterangan = "PEMBY PENGHASILAN & TUNJANGAN DIREKSI BULAN";
	$reqKeteranganPotongan = "POTONGAN A/ PEMBY PENGHASILAN & TUNJANGAN DIREKSI BULAN";
	$reqJenisPegawai = "DIREKSI";
}
elseif($reqJenisProses == "GAJI_KOMISARIS")
{
	$reqJenisPegawaiId = 7;
	$reqKeterangan = "PEMBY HONOR DEWAN KOMISARIS & STAF BULAN";
	$reqKeteranganPotongan = "POT PPH 21 A/ PEMBY HONOR DEWAN KOMISARIS & STAF BULAN";
	$reqJenisPegawai = "DEWAN KOMISARIS & STAF";
}

$gaji_awal_bulan->selectByParamsJurnal(array(), -1, -1, " AND PERIODE = '".$reqPeriode."' AND JENIS_PEGAWAI_ID = ".$reqJenisPegawaiId);
$gaji_awal_bulan->firstRow();
	
// JKM
$gaji_awal_bulan_jkm->selectByParamsJurnalJKM(array(), -1, -1, " AND PERIODE = '".$reqPeriode."' AND JENIS_PEGAWAI_ID = ".$reqJenisPegawaiId);
$gaji_awal_bulan_jkm->firstRow();
	

if($reqJenisProses == "GAJI_PKWT")
	$gaji_awal_bulan_detil->selectByParamsJurnalDetilPKWT(array(), -1, -1, "", $reqPeriode, $reqJenisPegawaiId);
elseif($reqJenisProses == "GAJI_DIREKSI")
	$gaji_awal_bulan_detil->selectByParamsJurnalDetilDireksi(array(), -1, -1, "", $reqPeriode, $reqJenisPegawaiId);
elseif($reqJenisProses == "GAJI_KOMISARIS")
	$gaji_awal_bulan_detil->selectByParamsJurnalDetilKomisaris(array(), -1, -1, "", $reqPeriode, $reqJenisPegawaiId);
else
	$gaji_awal_bulan_detil->selectByParamsJurnalDetil(array(), -1, -1, "", $reqPeriode, $reqJenisPegawaiId);

$gaji_awal_bulan_jkm_detil->selectByParamsJurnalJKMDetil(array(), -1, -1, "", $reqPeriode, $reqJenisPegawaiId);


include_once("../WEB-INF-SIUK/classes/base/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base/KbbtJurBbD.php");
/* create objects */

$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_d = new KbbtJurBbD();
$kbbt_jur_bb_jkm = new KbbtJurBb();
$kbbt_jur_bb_d_jkm = new KbbtJurBbD();




//$reqNoNota = '001479/JKK/2013';
//$reqNoNotaJKM = '000933/JKM/2013';

$reqNoNota = $kbbt_jur_bb->getKodeNota();
$reqNoNotaJKM = $kbbt_jur_bb_jkm->getKodeNotaJKM();





	
	$kbbt_jur_bb->setField("KD_CABANG", "96");
	$kbbt_jur_bb->setField("KD_SUBSIS", "KBB");
	$kbbt_jur_bb->setField("TIPE_TRANS", "JKK-KBB-01");
	$kbbt_jur_bb->setField("NO_NOTA", $reqNoNota);
	$kbbt_jur_bb->setField("JEN_JURNAL", "JKK");
	$kbbt_jur_bb->setField("NO_REF1", $reqNoNota);
	$kbbt_jur_bb->setField("NO_REF2", "1");
	$kbbt_jur_bb->setField("NO_REF3", $reqNotaDinas1);
	$kbbt_jur_bb->setField("JEN_TRANS", "");
	$kbbt_jur_bb->setField("KD_SUB_BANTU", "");
	$kbbt_jur_bb->setField("KD_UNITK", "");
	$kbbt_jur_bb->setField("KD_KUSTO", "");
	$kbbt_jur_bb->setField("KD_KLIENT", "");
	$kbbt_jur_bb->setField("KD_ASSET", "");
	$kbbt_jur_bb->setField("KD_STOCK", "");
	$kbbt_jur_bb->setField("THN_BUKU", date("Y"));
	$kbbt_jur_bb->setField("BLN_BUKU", date("m"));
	$kbbt_jur_bb->setField("TGL_ENTRY", "TRUNC(SYSDATE)");
	$kbbt_jur_bb->setField("TGL_TRANS", "TRUNC(SYSDATE)");
	$kbbt_jur_bb->setField("KD_VALUTA", "IDR");
	$kbbt_jur_bb->setField("TGL_VALUTA", "TRUNC(SYSDATE)");
	$kbbt_jur_bb->setField("KURS_VALUTA", 1);
	$kbbt_jur_bb->setField("JML_VAL_TRANS", $gaji_awal_bulan->getField("JUMLAH"));
	$kbbt_jur_bb->setField("JML_RP_TRANS", $gaji_awal_bulan->getField("JUMLAH"));
	$kbbt_jur_bb->setField("KD_BAYAR", "");
	$kbbt_jur_bb->setField("KD_BANK", "");
	$kbbt_jur_bb->setField("NOREK_BANK", "");
	$kbbt_jur_bb->setField("NO_CEK_NOTA", "");
	$kbbt_jur_bb->setField("NO_POSTING", "");
	$kbbt_jur_bb->setField("KET_TAMBAH", $reqKeterangan." ".strtoupper(getNamePeriode($reqPeriode))."");
	$kbbt_jur_bb->setField("USER_DATA", "GL :");
	$kbbt_jur_bb->setField("ID_KASIR", "");
	$kbbt_jur_bb->setField("APPROVER", "KASIR");
	$kbbt_jur_bb->setField("TANDA_TRANS", "");
	$kbbt_jur_bb->setField("LAST_UPDATE_DATE", "TRUNC(SYSDATE)");
	$kbbt_jur_bb->setField("LAST_UPDATED_BY", "AKUNTANSI_PMS");
	$kbbt_jur_bb->setField("PROGRAM_NAME", "KBB_ENTRY_JUR_JKK");
	$kbbt_jur_bb->setField("KD_BUKU_PUSAT", "");
	$kbbt_jur_bb->setField("NM_AGEN_PERUSH", $reqJenisPegawai);
	$kbbt_jur_bb->setField("ALMT_AGEN_PERUSH", "PT. PELINDO MARINE SERVICE");
	$kbbt_jur_bb->setField("URAIAN", "");
	$kbbt_jur_bb->setField("TGL_POSTING", dateToDBCheck(""));
	$kbbt_jur_bb->setField("JML_CETAK", "");
	$kbbt_jur_bb->setField("KD_KAS", "");
	$kbbt_jur_bb->setField("KD_TERMINAL", "");
	$kbbt_jur_bb->setField("NO_SP", "");
	$kbbt_jur_bb->setField("TGL_SP", dateToDBCheck(""));
	$kbbt_jur_bb->setField("NO_KN_BANK", "");
	$kbbt_jur_bb->setField("TGL_KN_BANK", dateToDBCheck(""));
	$kbbt_jur_bb->setField("NO_DN", "");
	$kbbt_jur_bb->setField("TGL_DN", dateToDBCheck(""));
	$kbbt_jur_bb->setField("NO_REG_KASIR", "");
	$kbbt_jur_bb->setField("FLAG_SETOR_PAJAK", "1");
	$kbbt_jur_bb->setField("STATUS_PROSES", "");
	$kbbt_jur_bb->setField("VERIFIED", "");
	$kbbt_jur_bb->setField("NO_URUT_UPER", "");
	$kbbt_jur_bb->setField("NO_FAKT_PAJAK", "");
	if($kbbt_jur_bb->insertJurnal())
	{
		$kbbt_jur_bb->insertJurnalTemp($reqNoNota);
		
		
					
		while($gaji_awal_bulan_detil->nextRow())
		{
			$kbbt_jur_bb_d = new KbbtJurBbD();
			if($gaji_awal_bulan_detil->getField("SALDO_VAL_DEBET") == 0 && 
			   $gaji_awal_bulan_detil->getField("SALDO_VAL_KREDIT") == 0 && 
			   $gaji_awal_bulan_detil->getField("SALDO_RP_DEBET") == 0 && 
			   $gaji_awal_bulan_detil->getField("SALDO_RP_KREDIT") == 0)
			{}
			else
			{
				$kbbt_jur_bb_d->setField('KD_CABANG', $gaji_awal_bulan_detil->getField("KD_CABANG"));
				$kbbt_jur_bb_d->setField('NO_NOTA', $reqNoNota);
				$kbbt_jur_bb_d->setField('NO_SEQ', $gaji_awal_bulan_detil->getField("NO_SEQ"));
				$kbbt_jur_bb_d->setField('KD_SUBSIS', "KBB");
				$kbbt_jur_bb_d->setField('KD_JURNAL', "JKK");
				$kbbt_jur_bb_d->setField('TIPE_TRANS', "JKK-KBB-01");
				$kbbt_jur_bb_d->setField('KLAS_TRANS', "");
				$kbbt_jur_bb_d->setField('KD_BUKU_BESAR', $gaji_awal_bulan_detil->getField("KD_BUKU_BESAR"));
				$kbbt_jur_bb_d->setField('KD_SUB_BANTU', $gaji_awal_bulan_detil->getField("KD_SUB_BANTU"));
				$kbbt_jur_bb_d->setField('KD_BUKU_PUSAT', $gaji_awal_bulan_detil->getField("KD_BUKU_PUSAT"));
				$kbbt_jur_bb_d->setField('KD_VALUTA', $gaji_awal_bulan_detil->getField("KD_VALUTA"));
				$kbbt_jur_bb_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");
				$kbbt_jur_bb_d->setField('KURS_VALUTA', $gaji_awal_bulan_detil->getField("KURS_VALUTA"));
				$kbbt_jur_bb_d->setField('SALDO_VAL_DEBET', $gaji_awal_bulan_detil->getField("SALDO_VAL_DEBET"));
				$kbbt_jur_bb_d->setField('SALDO_VAL_KREDIT', $gaji_awal_bulan_detil->getField("SALDO_VAL_KREDIT"));
				$kbbt_jur_bb_d->setField('SALDO_RP_DEBET', $gaji_awal_bulan_detil->getField("SALDO_RP_DEBET"));
				$kbbt_jur_bb_d->setField('SALDO_RP_KREDIT', $gaji_awal_bulan_detil->getField("SALDO_RP_KREDIT"));
				$kbbt_jur_bb_d->setField('KET_TAMBAH', $gaji_awal_bulan_detil->getField("KET_TAMBAH"));
				$kbbt_jur_bb_d->setField('TANDA_TRANS', $gaji_awal_bulan_detil->getField("TANDA_TRANS"));
				$kbbt_jur_bb_d->setField('KD_AKTIF', $gaji_awal_bulan_detil->getField("KD_AKTIF"));
				$kbbt_jur_bb_d->setField('PREV_NO_NOTA', $gaji_awal_bulan_detil->getField("PREV_NO_NOTA"));
				$kbbt_jur_bb_d->setField('REF_NOTA_JUAL_BELI', $gaji_awal_bulan_detil->getField("REF_NOTA_JUAL_BELI"));
				$kbbt_jur_bb_d->setField('BAYAR_VIA', $gaji_awal_bulan_detil->getField("BAYAR_VIA"));
				$kbbt_jur_bb_d->setField('STATUS_KENA_PAJAK', $gaji_awal_bulan_detil->getField("STATUS_KENA_PAJAK"));
				$kbbt_jur_bb_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
				$kbbt_jur_bb_d->setField('LAST_UPDATED_BY', $gaji_awal_bulan_detil->getField("LAST_UPDATED_BY"));
				$kbbt_jur_bb_d->setField('PROGRAM_NAME', $gaji_awal_bulan_detil->getField("PROGRAM_NAME"));
				$kbbt_jur_bb_d->insert();
			}
			unset($kbbt_jur_bb_d);
		}
	}			

	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->insertTemporary($reqNoNota);

	$kbbt_jur_bb_jkm->setField("KD_CABANG", "96");
	$kbbt_jur_bb_jkm->setField("KD_SUBSIS", "KBB");
	$kbbt_jur_bb_jkm->setField("TIPE_TRANS", "JKM-KBB-01");
	$kbbt_jur_bb_jkm->setField("NO_NOTA", $reqNoNotaJKM);
	$kbbt_jur_bb_jkm->setField("JEN_JURNAL", "JKM");
	$kbbt_jur_bb_jkm->setField("NO_REF1", $reqNoNotaJKM);
	$kbbt_jur_bb_jkm->setField("NO_REF2", "1");
	$kbbt_jur_bb_jkm->setField("NO_REF3", $reqNotaDinas1);
	$kbbt_jur_bb_jkm->setField("JEN_TRANS", "");
	$kbbt_jur_bb_jkm->setField("KD_SUB_BANTU", "");
	$kbbt_jur_bb_jkm->setField("KD_UNITK", "");
	$kbbt_jur_bb_jkm->setField("KD_KUSTO", "");
	$kbbt_jur_bb_jkm->setField("KD_KLIENT", "");
	$kbbt_jur_bb_jkm->setField("KD_ASSET", "");
	$kbbt_jur_bb_jkm->setField("KD_STOCK", "");
	$kbbt_jur_bb_jkm->setField("THN_BUKU", date("Y"));
	$kbbt_jur_bb_jkm->setField("BLN_BUKU", date("m"));
	$kbbt_jur_bb_jkm->setField("TGL_ENTRY", "TRUNC(SYSDATE)");
	$kbbt_jur_bb_jkm->setField("TGL_TRANS", "TRUNC(SYSDATE)");
	$kbbt_jur_bb_jkm->setField("KD_VALUTA", "IDR");
	$kbbt_jur_bb_jkm->setField("TGL_VALUTA", "TRUNC(SYSDATE)");
	$kbbt_jur_bb_jkm->setField("KURS_VALUTA", 1);
	$kbbt_jur_bb_jkm->setField("JML_VAL_TRANS", $gaji_awal_bulan_jkm->getField("JUMLAH"));
	$kbbt_jur_bb_jkm->setField("JML_RP_TRANS", $gaji_awal_bulan_jkm->getField("JUMLAH"));
	$kbbt_jur_bb_jkm->setField("KD_BAYAR", "");
	$kbbt_jur_bb_jkm->setField("KD_BANK", "");
	$kbbt_jur_bb_jkm->setField("NOREK_BANK", "");
	$kbbt_jur_bb_jkm->setField("NO_CEK_NOTA", "");
	$kbbt_jur_bb_jkm->setField("NO_POSTING", "");
	$kbbt_jur_bb_jkm->setField("KET_TAMBAH", $reqKeteranganPotongan." ".strtoupper(getNamePeriode($reqPeriode))."");
	$kbbt_jur_bb_jkm->setField("USER_DATA", "GL :");
	$kbbt_jur_bb_jkm->setField("ID_KASIR", "");
	$kbbt_jur_bb_jkm->setField("APPROVER", "KASIR");
	$kbbt_jur_bb_jkm->setField("TANDA_TRANS", "");
	$kbbt_jur_bb_jkm->setField("LAST_UPDATE_DATE", "TRUNC(SYSDATE)");
	$kbbt_jur_bb_jkm->setField("LAST_UPDATED_BY", "AKUNTANSI_PMS");
	$kbbt_jur_bb_jkm->setField("PROGRAM_NAME", "KBB_ENTRY_JUR_JKM");
	$kbbt_jur_bb_jkm->setField("KD_BUKU_PUSAT", "");
	$kbbt_jur_bb_jkm->setField("NM_AGEN_PERUSH", $reqJenisPegawai);
	$kbbt_jur_bb_jkm->setField("ALMT_AGEN_PERUSH", "PT. PELINDO MARINE SERVICE");
	$kbbt_jur_bb_jkm->setField("URAIAN", "");
	$kbbt_jur_bb_jkm->setField("TGL_POSTING", dateToDBCheck(""));
	$kbbt_jur_bb_jkm->setField("JML_CETAK", "");
	$kbbt_jur_bb_jkm->setField("KD_KAS", "");
	$kbbt_jur_bb_jkm->setField("KD_TERMINAL", "");
	$kbbt_jur_bb_jkm->setField("NO_SP", "");
	$kbbt_jur_bb_jkm->setField("TGL_SP", dateToDBCheck(""));
	$kbbt_jur_bb_jkm->setField("NO_KN_BANK", "");
	$kbbt_jur_bb_jkm->setField("TGL_KN_BANK", dateToDBCheck(""));
	$kbbt_jur_bb_jkm->setField("NO_DN", "");
	$kbbt_jur_bb_jkm->setField("TGL_DN", dateToDBCheck(""));
	$kbbt_jur_bb_jkm->setField("NO_REG_KASIR", "");
	$kbbt_jur_bb_jkm->setField("FLAG_SETOR_PAJAK", "");
	$kbbt_jur_bb_jkm->setField("STATUS_PROSES", "");
	$kbbt_jur_bb_jkm->setField("VERIFIED", "");
	$kbbt_jur_bb_jkm->setField("NO_URUT_UPER", "");
	$kbbt_jur_bb_jkm->setField("NO_FAKT_PAJAK", "");
	if($kbbt_jur_bb_jkm->insertJurnal())
	{
		$kbbt_jur_bb_jkm->insertJurnalTemp($reqNoNotaJKM);

		while($gaji_awal_bulan_jkm_detil->nextRow())
		{
			  $kbbt_jur_bb_d_jkm = new KbbtJurBbD();

			  $kbbt_jur_bb_d_jkm->setField('KD_CABANG', $gaji_awal_bulan_jkm_detil->getField("KD_CABANG"));
			  $kbbt_jur_bb_d_jkm->setField('NO_NOTA', $reqNoNotaJKM);
			  $kbbt_jur_bb_d_jkm->setField('NO_SEQ', $gaji_awal_bulan_jkm_detil->getField("NO_SEQ"));
			  $kbbt_jur_bb_d_jkm->setField('KD_SUBSIS', $gaji_awal_bulan_jkm_detil->getField("KD_SUBSIS"));
			  $kbbt_jur_bb_d_jkm->setField('KD_JURNAL', $gaji_awal_bulan_jkm_detil->getField("KD_JURNAL"));
			  $kbbt_jur_bb_d_jkm->setField('TIPE_TRANS', $gaji_awal_bulan_jkm_detil->getField("TIPE_TRANS"));
			  $kbbt_jur_bb_d_jkm->setField('KLAS_TRANS', "");
			  $kbbt_jur_bb_d_jkm->setField('KD_BUKU_BESAR', $gaji_awal_bulan_jkm_detil->getField("KD_BUKU_BESAR"));
			  $kbbt_jur_bb_d_jkm->setField('KD_SUB_BANTU', $gaji_awal_bulan_jkm_detil->getField("KD_SUB_BANTU"));
			  $kbbt_jur_bb_d_jkm->setField('KD_BUKU_PUSAT', $gaji_awal_bulan_jkm_detil->getField("KD_BUKU_PUSAT"));
			  $kbbt_jur_bb_d_jkm->setField('KD_VALUTA', $gaji_awal_bulan_jkm_detil->getField("KD_VALUTA"));
			  $kbbt_jur_bb_d_jkm->setField('TGL_VALUTA', "TRUNC(SYSDATE)");
			  $kbbt_jur_bb_d_jkm->setField('KURS_VALUTA', $gaji_awal_bulan_jkm_detil->getField("KURS_VALUTA"));
			  $kbbt_jur_bb_d_jkm->setField('SALDO_VAL_DEBET', $gaji_awal_bulan_jkm_detil->getField("SALDO_VAL_DEBET"));
			  $kbbt_jur_bb_d_jkm->setField('SALDO_VAL_KREDIT', $gaji_awal_bulan_jkm_detil->getField("SALDO_VAL_KREDIT"));
			  $kbbt_jur_bb_d_jkm->setField('SALDO_RP_DEBET', $gaji_awal_bulan_jkm_detil->getField("SALDO_RP_DEBET"));
			  $kbbt_jur_bb_d_jkm->setField('SALDO_RP_KREDIT', $gaji_awal_bulan_jkm_detil->getField("SALDO_RP_KREDIT"));
			  $kbbt_jur_bb_d_jkm->setField('KET_TAMBAH', $gaji_awal_bulan_jkm_detil->getField("KET_TAMBAH"));
			  $kbbt_jur_bb_d_jkm->setField('TANDA_TRANS', $gaji_awal_bulan_jkm_detil->getField("TANDA_TRANS"));
			  $kbbt_jur_bb_d_jkm->setField('KD_AKTIF', $gaji_awal_bulan_jkm_detil->getField("KD_AKTIF"));
			  $kbbt_jur_bb_d_jkm->setField('PREV_NO_NOTA', $gaji_awal_bulan_jkm_detil->getField("PREV_NO_NOTA"));
			  $kbbt_jur_bb_d_jkm->setField('REF_NOTA_JUAL_BELI', $gaji_awal_bulan_jkm_detil->getField("REF_NOTA_JUAL_BELI"));
			  $kbbt_jur_bb_d_jkm->setField('BAYAR_VIA', $gaji_awal_bulan_jkm_detil->getField("BAYAR_VIA"));
			  $kbbt_jur_bb_d_jkm->setField('STATUS_KENA_PAJAK', $gaji_awal_bulan_jkm_detil->getField("STATUS_KENA_PAJAK"));
			  $kbbt_jur_bb_d_jkm->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
			  $kbbt_jur_bb_d_jkm->setField('LAST_UPDATED_BY', $gaji_awal_bulan_jkm_detil->getField("LAST_UPDATED_BY"));
			  $kbbt_jur_bb_d_jkm->setField('PROGRAM_NAME', $gaji_awal_bulan_jkm_detil->getField("PROGRAM_NAME"));
			  $kbbt_jur_bb_d_jkm->insert();

			unset($kbbt_jur_bb_d_jkm);
		}
	}	
	
	$kbbt_jur_bb_d_jkm = new KbbtJurBbD();
	$kbbt_jur_bb_d_jkm->insertTemporary($reqNoNotaJKM);

?>