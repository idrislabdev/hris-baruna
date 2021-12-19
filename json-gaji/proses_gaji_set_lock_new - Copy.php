<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-gaji/ProsesGajiLock.php");
include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$proses_gaji_lock = new ProsesGajiLock();
$gaji_awal_bulan = new GajiAwalBulan();
$gaji_awal_bulan_detil = new GajiAwalBulan();
$gaji_awal_bulan_jkm = new GajiAwalBulan();
$gaji_awal_bulan_jkm_detil = new GajiAwalBulan();

$reqPeriode = httpFilterRequest("reqPeriode");
$reqJenisProses = httpFilterRequest("reqJenisProses");
$reqNotaDinas1 = httpFilterPost("reqNotaDinas1");
$reqNotaDinas2 = httpFilterPost("reqNotaDinas2");

$bulan = substr($reqPeriode,0, 2);
$tahun = substr($reqPeriode,2, 4);

$bulan = (int)$bulan - 1;
if($bulan == 0)
	$reqPeriodeSebelum = "12".($tahun - 1);
else
	$reqPeriodeSebelum = generateZero($bulan, 2).$tahun;	
	
$proses_gaji_lock->setField("PERIODE", $reqPeriode);
$proses_gaji_lock->setField("JENIS_PROSES", $reqJenisProses);
$proses_gaji_lock->setField("STATUS", 1);

$proses_gaji_lock->delete();
$proses_gaji_lock->insert();

if($reqJenisProses == "GAJI_PERBANTUAN_ORGANIK")
{

	$gaji_awal_bulan->selectByParamsJurnalSemua(array(), -1, -1, $reqPeriode, $reqPeriodeSebelum);
	$gaji_awal_bulan->firstRow();

	$gaji_awal_bulan_detil->selectByParamsJurnalDetil(array(), -1, -1, "", $reqPeriode, $reqPeriodeSebelum);


	// JKM
	$gaji_awal_bulan_jkm->selectByParamsJurnalJKMSemua(array(), -1, -1, $reqPeriode, $reqPeriodeSebelum);
	$gaji_awal_bulan_jkm->firstRow();

	include_once("../WEB-INF-SIUK/classes/base/KbbtJurBb.php");
	include_once("../WEB-INF-SIUK/classes/base/KbbtJurBbD.php");

	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_jkm = new KbbtJurBb();
	$kbbt_jur_bb_d_jkm = new KbbtJurBbD();


		
	$reqNoNota = "001777/JKK/2013";//$kbbt_jur_bb->getKodeNota();
	$reqNoNotaJKM = "001120/JKM/2013";//$kbbt_jur_bb_jkm->getKodeNotaJKM();

	if($reqJenisProses == "GAJI_PERBANTUAN_ORGANIK")
	{
		
			$seq = 1;
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
					$kbbt_jur_bb_d->setField('NO_SEQ', $seq);
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
					if($kbbt_jur_bb_d->insert())
					{}
					else
					{
						echo "gagal".$kbbt_jur_bb_d->query."<br>";
					}
					$seq++;
				}
				unset($kbbt_jur_bb_d);
			}
		$kbbt_jur_bb_d = new KbbtJurBbD();
		$kbbt_jur_bb_d->insertTemporary($reqNoNota);

			$gaji_awal_bulan_jkm_detil->selectByParamsJurnalJKMDetil(array(), -1, -1, "", $reqPeriode, $reqPeriodeSebelum);
			$seq = 1;
			while($gaji_awal_bulan_jkm_detil->nextRow())
			{
				  $kbbt_jur_bb_d_jkm = new KbbtJurBbD();

				  $kbbt_jur_bb_d_jkm->setField('KD_CABANG', $gaji_awal_bulan_jkm_detil->getField("KD_CABANG"));
				  $kbbt_jur_bb_d_jkm->setField('NO_NOTA', $reqNoNotaJKM);
				  $kbbt_jur_bb_d_jkm->setField('NO_SEQ', $seq);
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
				  $seq++;
				unset($kbbt_jur_bb_d_jkm);
			}
		$kbbt_jur_bb_d_jkm = new KbbtJurBbD();
		$kbbt_jur_bb_d_jkm->insertTemporary($reqNoNotaJKM);
		
	}
}

$met = array();
$i=0;

$met[0]['STATUS'] = 1;
//echo json_encode($met);
echo "Kirim Jurnal Berhasil.";
?>