<?
//include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");

$reqId = $_GET['id'];
$reqRowId = $_GET['reqRowId'];
$reqMode = $_GET['reqMode'];

$reqBesar = $_GET['reqBesar'];
$reqTahun = $_GET['reqTahun'];
$reqPusat = $_GET['reqPusat'];

/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/
if($reqMode == "badan_usaha")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/BadanUsaha.php");
	$badan_usaha	= new BadanUsaha();
	$badan_usaha->setField('BADAN_USAHA_ID', $reqId);
	if($badan_usaha->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$badan_usaha->getErrorMsg();
}
elseif($reqMode == "nota_penomoran")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrNoNota.php");
	$nota_penomoran	= new KbbrNoNota();
	$nota_penomoran->setField('KD_BUKTI', $reqId);
	$nota_penomoran->setField('KD_PERIODE', $reqRowId);
	if($nota_penomoran->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$nota_penomoran->getErrorMsg();
}
elseif($reqMode == "tahun_pembukuan")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBuku.php");
	$tahun_pembukuan	= new KbbrThnBuku();
	$tahun_pembukuan->setField('THN_BUKU', $reqId);
	if($tahun_pembukuan->deleteAll())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$tahun_pembukuan->getErrorMsg();
}
elseif($reqMode == "jurnal")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRefD.php");
	$jurnal	= new KbbrGeneralRefD();
	$jurnal->setField('ID_REF_DATA', $reqId);
	$jurnal->setField('ID_REF_FILE', "JENISJURNAL");
	
	if($jurnal->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$jurnal->getErrorMsg();
}
elseif($reqMode == "rekening_buku_besar")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrBukuBesar.php");
	$rekening_buku_besar= new KbbrBukuBesar();
	$rekening_buku_besar->setField('KD_BUKU_BESAR', $reqId);
	
	if($rekening_buku_besar->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$rekening_buku_besar->getErrorMsg();
	echo $rekening_buku_besar->query;	
}
elseif($reqMode == "rekening_pusat_biaya")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrBukuPusat.php");
	$rekening_pusat_biaya= new KbbrBukuPusat();
	$rekening_pusat_biaya->setField('KD_BUKU_BESAR_ID', $reqId);
	
	if($rekening_pusat_biaya->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$rekening_pusat_biaya->getErrorMsg();
}
elseif($reqMode == "badan_usaha_coa")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/BadanUsaha.php");
	$badan_usaha_coa	= new BadanUsaha();
	$badan_usaha_coa->setField('BADAN_USAHA_ID', $reqId);
	if($badan_usaha_coa->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$badan_usaha_coa->getErrorMsg();
}
elseif($reqMode == "kurs")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValutaKurs.php");
	$safr_valuta_kurs	= new SafrValutaKurs();
	$safr_valuta_kurs->setField('TGL_MULAI_RATE', dateToDBCheck(dateToPageCheck($reqId)));
	if($safr_valuta_kurs->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$safr_valuta_kurs->getErrorMsg();
	//echo $safr_valuta_kurs->query;
}
elseif($reqMode == "kurs_pajak")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValutaKursPajak.php");
	$safr_valuta_kurs_pajak	= new SafrValutaKursPajak();
	$safr_valuta_kurs_pajak->setField('TGL_MULAI_RATE', dateToDBCheck(dateToPageCheck($reqId)));
	if($safr_valuta_kurs_pajak->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$safr_valuta_kurs_pajak->getErrorMsg();
}
elseif($reqMode == "pelanggan")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmPelanggan.php");
	$safm_pelanggan	= new SafmPelanggan();
	$safm_pelanggan->setField('MPLG_KODE', $reqId);
	if($safm_pelanggan->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$safm_pelanggan->getErrorMsg();
}
elseif($reqMode == "referensi")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRef.php");
	$referensi	= new KbbrGeneralRef();
	$referensi->setField('REFERENSI_ID', $reqId);
	if($referensi->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$referensi->getErrorMsg();
}
elseif($reqMode == "rekening_group")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGroupRek.php");
	$rekening_group	= new KbbrGroupRek();
	$rekening_group->setField('ID_GROUP', $reqId);
	if($rekening_group->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$rekening_group->getErrorMsg();
}
elseif($reqMode == "valuta")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");
	$valuta	= new Valuta();
	$valuta->setField('VALUTA_ID', $reqId);
	if($valuta->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$valuta->getErrorMsg();
}
elseif($reqMode == "bank")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmBank.php");
	$safm_bank	= new SafmBank();
	$safm_bank->setField('MBANK_KODE', $reqId);
	if($safm_bank->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$safm_bank->getErrorMsg();
}
elseif($reqMode == "jurnal_rupa_rupa")
{
	
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
	$jurnal_rupa_rupa	= new KbbtJurBbTmp();
	$jurnal_rupa_rupa->setField('TIPE_TRANS', $reqId);
	$jurnal_rupa_rupa->setField('TIPE_TRANS', "JRR-KBB-01");
	$jurnal_rupa_rupa->setField('NO_NOTA', $reqRowId);	
	
	//echo $jurnal_rupa_rupa->query;
	
	if($jurnal_rupa_rupa->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$jurnal_rupa_rupa->getErrorMsg();
}
elseif($reqMode == "jurnal_penerimaan_kas_bank")
{
	
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
	$jurnal_penerimaan_kas_bank	= new KbbtJurBbTmp();
	$jurnal_penerimaan_kas_bank->setField('TIPE_TRANS', $reqId);
	$jurnal_penerimaan_kas_bank->setField('TIPE_TRANS', "JKM-KBB-01");
	$jurnal_penerimaan_kas_bank->setField('NO_NOTA', $reqRowId);	
	
	echo $jurnal_penerimaan_kas_bank->query;
	
	if($jurnal_penerimaan_kas_bank->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$jurnal_penerimaan_kas_bank->getErrorMsg();
}
elseif($reqMode == "jurnal_pengeluaran_kas_bank")
{
	
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
	$jurnal_pengeluaran_kas_bank	= new KbbtJurBbTmp();
	$jurnal_pengeluaran_kas_bank->setField('TIPE_TRANS', $reqId);
	$jurnal_pengeluaran_kas_bank->setField('TIPE_TRANS', "JKK-KBB-01");
	$jurnal_pengeluaran_kas_bank->setField('NO_NOTA', $reqRowId);	
	
	echo $jurnal_pengeluaran_kas_bank->query;
	
	if($jurnal_pengeluaran_kas_bank->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$jurnal_pengeluaran_kas_bank->getErrorMsg();
}
elseif($reqMode == "jurnal_pemindahbukuan")
{
	
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
	$jurnal_pemindahbukuan	= new KbbtJurBbTmp();
	$jurnal_pemindahbukuan->setField('TIPE_TRANS', $reqId);
	$jurnal_pemindahbukuan->setField('TIPE_TRANS', "JKM-KBB-03");
	$jurnal_pemindahbukuan->setField('NO_NOTA', $reqRowId);	
	
	echo $jurnal_pemindahbukuan->query;
	
	if($jurnal_pemindahbukuan->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$jurnal_pemindahbukuan->getErrorMsg();
}
elseif($reqMode == "proses_ajp")
{
	
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
	$proses_ajp	= new KbbtJurBbTmp();
	$proses_ajp->setField('TIPE_TRANS', $reqId);
	$proses_ajp->setField('TIPE_TRANS', "JRR-KBB-06");
	$proses_ajp->setField('NO_NOTA', $reqRowId);	
	
	if($proses_ajp->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$proses_ajp->getErrorMsg();
}
elseif($reqMode == "proses_ajt")
{
	
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
	$proses_ajt	= new KbbtJurBbTmp();
	$proses_ajt->setField('TIPE_TRANS', $reqId);
	$proses_ajt->setField('TIPE_TRANS', "JRR-KBB-07");
	$proses_ajt->setField('NO_NOTA', $reqRowId);	
	
	if($proses_ajt->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$proses_ajt->getErrorMsg();
}
elseif($reqMode == "jurnal_tutup_tahun")
{
	
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
	$jurnal_tutup_tahun	= new KbbtJurBbTmp();
	$jurnal_tutup_tahun->setField('TIPE_TRANS', $reqId);
	$jurnal_tutup_tahun->setField('TIPE_TRANS', "JRR-KBB-01");
	$jurnal_tutup_tahun->setField('NO_NOTA', $reqRowId);	
	
	if($jurnal_tutup_tahun->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$jurnal_tutup_tahun->getErrorMsg();
}
elseif($reqMode == "transaksi_kasir_register_bukti_jurnal")
{
	
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
	$transaksi_kasir_register_bukti_jurnal	= new KbbtJurBb();
	$transaksi_kasir_register_bukti_jurnal->setField('TIPE_TRANS', $reqId);
	$transaksi_kasir_register_bukti_jurnal->setField('NO_NOTA', $reqRowId);	
	
	if($transaksi_kasir_register_bukti_jurnal->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$transaksi_kasir_register_bukti_jurnal->getErrorMsg();
}
elseif($reqMode == "faktur_pajak")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajak.php");
	$no_faktur_pajak	= new NoFakturPajak();
	$no_faktur_pajak->setField('NO_FAKTUR_PAJAK_ID', $reqId);
	
	if($no_faktur_pajak->deleteAll())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$transaksi_kasir_register_bukti_jurnal->getErrorMsg();
}
elseif($reqMode == "pegawai_pejabat_otoritas")
{
	
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrKeyTabel.php");
	$pegawai_pejabat_otoritas	= new KbbrKeyTabel();
	$pegawai_pejabat_otoritas->setField('KD_TABEL', $reqId); 
	$pegawai_pejabat_otoritas->setField('ID_TABEL', "OFFICER"); 
	
	
	if($pegawai_pejabat_otoritas->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$pegawai_pejabat_otoritas->getErrorMsg();
} 
elseif($reqMode == "rekening_buku_besar")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrBukuBesar.php");
	$rekening_buku_besar	= new KbbrBukuBesar();
	$rekening_buku_besar->setField('KD_BUKU_BESAR', $reqId);
	
	if($rekening_buku_besar->deleteAll())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$rekening_buku_besar->getErrorMsg();
}

elseif($reqMode == "maintenance_anggaran")
{
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtNeracaAngg.php");
	$maintenance_anggaran	= new KbbtNeracaAngg();
	$maintenance_anggaran->setField('KD_BUKU_PUSAT', $reqPusat);
	$maintenance_anggaran->setField('KD_BUKU_BESAR', $reqBesar);
	$maintenance_anggaran->setField('THN_BUKU', $reqTahun);

	
	if($maintenance_anggaran->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$maintenance_anggaran->getErrorMsg();

	return $alertMsg;
}
?>