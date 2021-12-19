<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasiD.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$anggaran_mutasi = new AnggaranMutasi();
$reqNoBukti = httpFilterPost("reqNoBukti");
$reqId = httpFilterPost("reqId");
$reqValidasi = httpFilterPost("reqValidasi");
$reqValidasiAlasan = httpFilterPost("reqValidasiAlasan");
$reqJumlahUangMuka = httpFilterPost("reqJumlahUangMuka");
$reqJenisAnggaranId = httpFilterPost("reqJenisAnggaranId");
$reqNoNota = httpFilterPost("reqNoNota");
$reqNoRef3 = httpFilterPost("reqNoRef3");
$reqJumlahDiBayar = httpFilterPost("reqJumlahDiBayar");
$reqJumlahPPN = httpFilterPost("reqJumlahPPN");
$reqKetTambah = httpFilterPost("reqKetTambah");
$reqBukuBesarUm = httpFilterPost("reqBukuBesarUm");
$reqPuspelSubBantu = httpFilterPost("reqPuspelSubBantu");

$reqBukuBesar = $_POST["reqBukuBesar"];
$reqKartu = $_POST["reqKartu"];
$reqBukuPusat = $_POST["reqBukuPusat"];
$reqNama = $_POST["reqNama"];
$reqKeterangan = $_POST["reqKeterangan"];
$reqUnit = $_POST["reqUnit"];
$reqHarga = $_POST["reqHarga"];
$reqJumlah = $_POST["reqJumlah"];
$reqPajak = $_POST["reqPajak"];
$reqRealisasi = $_POST["reqRealisasi"];
$reqLebihKurang = $_POST["reqLebihKurang"];
$reqNoUrut = $_POST["reqNoUrut"];

for($i=0;$i<count($reqBukuBesar);$i++)
{
	$anggaran_mutasi_d = new AnggaranMutasiD();
	$anggaran_mutasi_d->setField("ANGGARAN_MUTASI_ID", $reqId);
	$anggaran_mutasi_d->setField("NO_SEQ", $reqNoUrut[$i]);
	$anggaran_mutasi_d->setField("KD_BUKU_BESAR", $reqBukuBesar[$i]);
	$anggaran_mutasi_d->setField("KD_BUKU_PUSAT", $reqBukuPusat[$i]);
	$anggaran_mutasi_d->setField("KD_SUB_BANTU", $reqKartu[$i]);
	$anggaran_mutasi_d->setField("NAMA", $reqNama[$i]);
	$anggaran_mutasi_d->setField("PAJAK", $reqPajak[$i]);
	$anggaran_mutasi_d->updateVerifikasiRencana();
	unset($anggaran_mutasi_d);	
}

$anggaran_mutasi->setField("KD_BUKU_BESAR_UM", $reqBukuBesarUm);
$anggaran_mutasi->setField("VERIFIKASI", $reqValidasi);
$anggaran_mutasi->setField("VERIFIKASI_ALASAN", $reqValidasiAlasan);
$anggaran_mutasi->setField("VERIFIKASI_MANKEU_BY", $userLogin->nama);
$anggaran_mutasi->setField("UANG_MUKA", dotToNo($reqJumlahUangMuka));
$anggaran_mutasi->setField("JML_VAL_PAJAK", dotToNo($reqJumlahPPN));
$anggaran_mutasi->setField("JML_VAL_TRANS", dotToNo($reqJumlahDiBayar));
$anggaran_mutasi->setField("JML_RP_TRANS", dotToNo($reqJumlahDiBayar));
$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $reqId);
$anggaran_mutasi->updateStatus();


if($reqValidasi == "S")
{
	/*
	$reqJenisAnggaranId = $anggaran_mutasi->getField("JENIS_ANGGARAN_ID");
	$reqNoRef3 = $anggaran_mutasi->getField("NO_REF3");
	$reqPuspelSubBantu = PUSPEL
	$reqJumlahDiBayar = JML_RP_TRANS
	$reqKetTambah = KET_TAMBAH
	*/
	if($reqJenisAnggaranId == 3 || $reqJenisAnggaranId == 6)
	{
		$anggaran_mutasi_d = new AnggaranMutasiD();
		$anggaran_mutasi_d->selectByParamsJurnalUangMuka(array("A.ANGGARAN_MUTASI_ID" => $reqId));
		
		//KIRIM JURNAL JKK	
		include_once("../WEB-INF-SIUK/classes/base/KbbtJurBb.php");
		include_once("../WEB-INF-SIUK/classes/base/KbbtJurBbD.php");
		include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmPelanggan.php");
			
		$kbbt_jur_bb_cek_posting = new KbbtJurBb();

		$kbbt_jur_bb = new KbbtJurBb();
		$kbbt_jur_bb_d = new KbbtJurBbD();
		$safm_pelanggan = new SafmPelanggan();
		
		if($reqNoNota == "")
		{	
			$reqNoNota = $kbbt_jur_bb->getKodeNota();
		}
		else
		{
			if($kbbt_jur_bb_cek_posting->cekSudahPosting($reqNoNota) == 1){
				echo $reqId."-Jurnal sudah diposting.";	
				exit;
			}
			
			$kbbt_jur_bb->setField("NO_NOTA", $reqNoNota);
			$kbbt_jur_bb->delete();
			unset($kbbt_jur_bb);
			$kbbt_jur_bb_d->setField("NO_NOTA", $reqNoNota);
			$kbbt_jur_bb_d->delete();		
			unset($kbbt_jur_bb_d);
			
			$kbbt_jur_bb = new KbbtJurBb();
			$kbbt_jur_bb_d = new KbbtJurBbD();	
		}
		
		$safm_pelanggan->selectByParams(array("MPLG_KODE" => $reqPuspelSubBantu));
		$safm_pelanggan->firstRow();
		
		$kbbt_jur_bb->setField("KD_CABANG", "96");
		$kbbt_jur_bb->setField("KD_SUBSIS", "KBB");
		$kbbt_jur_bb->setField("TIPE_TRANS", "JKK-KBB-01");
		$kbbt_jur_bb->setField("NO_NOTA", $reqNoNota);
		$kbbt_jur_bb->setField("JEN_JURNAL", "JKK");
		$kbbt_jur_bb->setField("NO_REF1", $reqNoNota);
		$kbbt_jur_bb->setField("NO_REF2", $reqNoBukti);
		$kbbt_jur_bb->setField("NO_REF3", $reqNoRef3);
		$kbbt_jur_bb->setField("JEN_TRANS", "");
		$kbbt_jur_bb->setField("KD_SUB_BANTU", $reqPuspelSubBantu);
		$kbbt_jur_bb->setField("KD_UNITK", "");
		$kbbt_jur_bb->setField("KD_KUSTO", $reqPuspelSubBantu);
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
		$kbbt_jur_bb->setField("JML_VAL_TRANS", dotToNo($reqJumlahDiBayar));
		$kbbt_jur_bb->setField("JML_RP_TRANS", dotToNo($reqJumlahDiBayar));
		$kbbt_jur_bb->setField("KD_BAYAR", "");
		$kbbt_jur_bb->setField("KD_BANK", "");
		$kbbt_jur_bb->setField("NOREK_BANK", "");
		$kbbt_jur_bb->setField("NO_CEK_NOTA", "");
		$kbbt_jur_bb->setField("NO_POSTING", "");
		$kbbt_jur_bb->setField("KET_TAMBAH", "PEMBYR ".$reqKetTambah);
		$kbbt_jur_bb->setField("USER_DATA", "GL :");
		$kbbt_jur_bb->setField("ID_KASIR", "");
		$kbbt_jur_bb->setField("APPROVER", "");
		$kbbt_jur_bb->setField("TANDA_TRANS", "");
		$kbbt_jur_bb->setField("LAST_UPDATE_DATE", "TRUNC(SYSDATE)");
		$kbbt_jur_bb->setField("LAST_UPDATED_BY", "AKUNTANSI_PMS");
		$kbbt_jur_bb->setField("PROGRAM_NAME", "ENTRY_UM_ANGGARAN_IMAIS");
		$kbbt_jur_bb->setField("KD_BUKU_PUSAT", "");
		$kbbt_jur_bb->setField("NM_AGEN_PERUSH", $safm_pelanggan->getField("MPLG_NAMA"));
		$kbbt_jur_bb->setField("ALMT_AGEN_PERUSH", $safm_pelanggan->getField("MPLG_ALAMAT"));
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
		$kbbt_jur_bb->setField("FLAG_SETOR_PAJAK", "");
		$kbbt_jur_bb->setField("STATUS_PROSES", "");
		$kbbt_jur_bb->setField("VERIFIED", "");
		$kbbt_jur_bb->setField("NO_URUT_UPER", "");
		$kbbt_jur_bb->setField("NO_FAKT_PAJAK", "");
		if($kbbt_jur_bb->insertJurnal())
		{
			$kbbt_jur_bb->insertJurnalTemp($reqNoNota);
			$seq = 1;
			while($anggaran_mutasi_d->nextRow())
			{
				$kbbt_jur_bb_d = new KbbtJurBbD();
				if($anggaran_mutasi_d->getField("SALDO_VAL_DEBET") == 0 && 
				   $anggaran_mutasi_d->getField("SALDO_VAL_KREDIT") == 0 && 
				   $anggaran_mutasi_d->getField("SALDO_RP_DEBET") == 0 && 
				   $anggaran_mutasi_d->getField("SALDO_RP_KREDIT") == 0)
				{}
				else
				{
					$kbbt_jur_bb_d->setField('KD_CABANG', "96");
					$kbbt_jur_bb_d->setField('NO_NOTA', $reqNoNota);
					$kbbt_jur_bb_d->setField('NO_SEQ', $seq);
					$kbbt_jur_bb_d->setField('KD_SUBSIS', "KBB");
					$kbbt_jur_bb_d->setField('KD_JURNAL', "JKK");
					$kbbt_jur_bb_d->setField('TIPE_TRANS', "JKK-KBB-01");
					$kbbt_jur_bb_d->setField('KLAS_TRANS', "");
					$kbbt_jur_bb_d->setField('KD_BUKU_BESAR', $anggaran_mutasi_d->getField("KD_BUKU_BESAR"));
					$kbbt_jur_bb_d->setField('KD_SUB_BANTU', $anggaran_mutasi_d->getField("KD_SUB_BANTU"));
					$kbbt_jur_bb_d->setField('KD_BUKU_PUSAT', $anggaran_mutasi_d->getField("KD_BUKU_PUSAT"));
					$kbbt_jur_bb_d->setField('KD_VALUTA', "IDR");
					$kbbt_jur_bb_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");
					$kbbt_jur_bb_d->setField('KURS_VALUTA', "1");
					$kbbt_jur_bb_d->setField('SALDO_VAL_DEBET', $anggaran_mutasi_d->getField("SALDO_VAL_DEBET"));
					$kbbt_jur_bb_d->setField('SALDO_VAL_KREDIT', $anggaran_mutasi_d->getField("SALDO_VAL_KREDIT"));
					$kbbt_jur_bb_d->setField('SALDO_RP_DEBET', $anggaran_mutasi_d->getField("SALDO_RP_DEBET"));
					$kbbt_jur_bb_d->setField('SALDO_RP_KREDIT', $anggaran_mutasi_d->getField("SALDO_RP_KREDIT"));
					$kbbt_jur_bb_d->setField('KET_TAMBAH', "");
					$kbbt_jur_bb_d->setField('TANDA_TRANS', "");
					$kbbt_jur_bb_d->setField('KD_AKTIF', "");
					$kbbt_jur_bb_d->setField('PREV_NO_NOTA', "");
					$kbbt_jur_bb_d->setField('REF_NOTA_JUAL_BELI', "");
					$kbbt_jur_bb_d->setField('BAYAR_VIA', "");
					$kbbt_jur_bb_d->setField('STATUS_KENA_PAJAK', "");
					$kbbt_jur_bb_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
					$kbbt_jur_bb_d->setField('LAST_UPDATED_BY', $userLogin->nama);
					$kbbt_jur_bb_d->setField('PROGRAM_NAME', "ENTRY_UM_ANGGARAN_IMAIS");
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
		}	
		$kbbt_jur_bb_d = new KbbtJurBbD();
		$kbbt_jur_bb_d->insertTemporary($reqNoNota);
		
		unset($kbbt_jur_bb);
		unset($kbbt_jur_bb_d);
		/* UPDATE NO_REF_NOTA */
		
		$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $reqId);
		$anggaran_mutasi->setField("NO_NOTA_UM", $reqNoNota);
		$anggaran_mutasi->updateNoNotaUM();
		//echo $anggaran_mutasi->query;
	}
	echo $reqId."-Anggaran telah disetujui.";
	
	
}
else
	echo $reqId."-Anggaran telah ditolak.";

?>