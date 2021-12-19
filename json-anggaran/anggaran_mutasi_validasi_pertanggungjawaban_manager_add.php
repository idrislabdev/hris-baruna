<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasiD.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranOverbudget.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$anggaran_mutasi = new AnggaranMutasi();
$anggaran_mutasi_d = new AnggaranMutasiD();
$anggaran_overbudget = new AnggaranOverBudget();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoBukti = httpFilterPost("reqNoBukti");
$reqJumlahDiBayar = httpFilterPost("reqJumlahDiBayar");
$reqJumlahLebihKurang = httpFilterPost("reqJumlahLebihKurang");
$reqJumlahUangMuka = httpFilterPost("reqJumlahUangMuka");
$reqNoNotaUM = httpFilterPost("reqNoNotaUM");
$reqNoNotaJRR = httpFilterPost("reqNoNotaJRR");
$reqNoNotaJKKJKM = httpFilterPost("reqNoNotaJKKJKM");
$reqStatusPengembalian = httpFilterPost("reqStatusPengembalian");
$reqNoRef2 = httpFilterPost("reqNoRef2");
$reqPuspelSubBantu = httpFilterPost("reqPuspelSubBantu");
$reqJenisAnggaranId = httpFilterPost("reqJenisAnggaranId");

$reqBukuBesar = $_POST["reqBukuBesar"];
$reqKartu = $_POST["reqKartu"];
$reqBukuPusat = $_POST["reqBukuPusat"];
$reqNama = $_POST["reqNama"];
$reqKeterangan = $_POST["reqKeterangan"];
$reqUnit = $_POST["reqUnit"];
$reqHarga = $_POST["reqHarga"];
$reqJumlah = $_POST["reqJumlah"];
$reqRealisasi = $_POST["reqRealisasi"];
$reqLebihKurang = $_POST["reqLebihKurang"];
$reqNoUrut = $_POST["reqNoUrut"];
$reqOverbudget = $_POST["reqOverbudget"];

$anggaran_mutasi_d->setField("ANGGARAN_MUTASI_ID", $reqId);
$anggaran_mutasi_d->deleteRealisasi();
unset($anggaran_mutasi_d);

$anggaran_overbudget->setField("ANGGARAN_MUTASI_ID", $reqId);
$anggaran_overbudget->delete();
unset($anggaran_overbudget);

for($i=0;$i<count($reqBukuBesar);$i++){
	$anggaran_mutasi_d = new AnggaranMutasiD();
	$anggaran_mutasi_d->setField("ANGGARAN_MUTASI_ID", $reqId);
	$anggaran_mutasi_d->setField("NO_SEQ", $i+1);
	$anggaran_mutasi_d->setField("NO_NOTA", $reqNoBukti);
	$anggaran_mutasi_d->setField("KD_BUKU_BESAR", $reqBukuBesar[$i]);
	$anggaran_mutasi_d->setField("KD_SUB_BANTU", $reqKartu[$i]);
	$anggaran_mutasi_d->setField("KD_BUKU_PUSAT", $reqBukuPusat[$i]);
	$anggaran_mutasi_d->setField("NAMA", $reqNama[$i]);
	$anggaran_mutasi_d->setField("UNIT", $reqUnit[$i]);
	$anggaran_mutasi_d->setField("HARGA_SATUAN", dotToNo($reqHarga[$i]));
	$anggaran_mutasi_d->setField("JUMLAH", dotToNo($reqJumlah[$i]));
	$anggaran_mutasi_d->setField("KET_TAMBAH", $reqKeterangan[$i]);
	$anggaran_mutasi_d->setField("STATUS_JURNAL", "REALISASI");
	$anggaran_mutasi_d->insert();
	unset($anggaran_mutasi_d);	
	
	if(dotToNo($reqOverbudget[$i]) > 0)
	{			
		$anggaran_overbudget = new AnggaranOverBudget();
		$anggaran_overbudget->setField("ANGGARAN_MUTASI_ID", $reqId);
		$anggaran_overbudget->setField("NO_NOTA", $reqNoBukti);
		$anggaran_overbudget->setField("KD_BUKU_BESAR", $reqBukuBesar[$i]);
		$anggaran_overbudget->setField("KD_SUB_BANTU", $reqKartu[$i]);
		$anggaran_overbudget->setField("KD_BUKU_PUSAT", $reqBukuPusat[$i]);
		$anggaran_overbudget->setField("JUMLAH", dotToNo($reqOverbudget[$i]));
		$anggaran_overbudget->insert();
		unset($anggaran_overbudget);
	}
}	



if($reqJenisAnggaranId == 3 || $reqJenisAnggaranId == 6){ 
	$anggaran_mutasi_d = new AnggaranMutasiD();
	$anggaran_mutasi_d_pengembalian = new AnggaranMutasiD();
	
	
	if($reqStatusPengembalian == "JKM")
	{
		$anggaran_mutasi_d->selectByParamsJurnalPertanggungjawabanUangMuka(array("A.ANGGARAN_MUTASI_ID" => $reqId));
		$anggaran_mutasi_d_pengembalian->selectByParamsJurnalPertanggungjawabanPengembalianJKM(array("A.ANGGARAN_MUTASI_ID" => $reqId));
		$jumlah_total_jrr = dotToNo($reqJumlahDiBayar);
	}
	elseif($reqStatusPengembalian == "JKK")
	{
		$anggaran_mutasi_d->selectByParamsJurnalPertanggungjawabanUangMukaKurang(array("A.ANGGARAN_MUTASI_ID" => $reqId));
		$anggaran_mutasi_d_pengembalian->selectByParamsJurnalPertanggungjawabanKurangJKK(array("A.ANGGARAN_MUTASI_ID" => $reqId));
		$jumlah_total_jrr = dotToNo($reqJumlahUangMuka);
	}
	else {		
		$anggaran_mutasi_d->selectByParamsJurnalPermintaanAnggaran(array("A.ANGGARAN_MUTASI_ID" => $reqId));
		$jumlah_total_jrr = dotToNo($reqJumlahUangMuka);
	}
	//KIRIM JURNAL JKK	
	include_once("../WEB-INF-SIUK/classes/base/KbbtJurBb.php");
	include_once("../WEB-INF-SIUK/classes/base/KbbtJurBbD.php");
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmPelanggan.php");
		
	$kbbt_jur_bb_cek_posting = new KbbtJurBb();
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb_d = new KbbtJurBbD();
	$safm_pelanggan = new SafmPelanggan();
	
	if($reqNoNotaJRR == "")
	{	
		$reqNoNotaJRR = $kbbt_jur_bb->getKodeNotaJRR();
	}
	else
	{
		if($kbbt_jur_bb_cek_posting->cekSudahPosting($reqNoNotaJRR) == 1){
			echo $reqId."-Jurnal sudah diposting.";	
			exit;
		}

		$kbbt_jur_bb->setField("NO_NOTA", $reqNoNotaJRR);
		$kbbt_jur_bb->delete();
		unset($kbbt_jur_bb);
		$kbbt_jur_bb_d->setField("NO_NOTA", $reqNoNotaJRR);
		$kbbt_jur_bb_d->delete();		
		unset($kbbt_jur_bb_d);
		
		$kbbt_jur_bb = new KbbtJurBb();
		$kbbt_jur_bb_d = new KbbtJurBbD();	
	}
	$safm_pelanggan->selectByParams(array("MPLG_KODE" => $reqPuspelSubBantu));
	$safm_pelanggan->firstRow();
	
	$kbbt_jur_bb->setField("KD_CABANG", "96");
	$kbbt_jur_bb->setField("KD_SUBSIS", "KBB");
	$kbbt_jur_bb->setField("TIPE_TRANS", "JRR-KBB-01");
	$kbbt_jur_bb->setField("NO_NOTA", $reqNoNotaJRR);
	$kbbt_jur_bb->setField("JEN_JURNAL", "JRR");
	$kbbt_jur_bb->setField("NO_REF1", $reqNoNotaJRR);
	$kbbt_jur_bb->setField("NO_REF2", $reqNoBukti);
	$kbbt_jur_bb->setField("NO_REF3", $reqNoRef2);
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
	$kbbt_jur_bb->setField("JML_VAL_TRANS", $jumlah_total_jrr);
	$kbbt_jur_bb->setField("JML_RP_TRANS", $jumlah_total_jrr);
	$kbbt_jur_bb->setField("KD_BAYAR", "");
	$kbbt_jur_bb->setField("KD_BANK", "");
	$kbbt_jur_bb->setField("NOREK_BANK", "");
	$kbbt_jur_bb->setField("NO_CEK_NOTA", "");
	$kbbt_jur_bb->setField("NO_POSTING", "");
	$kbbt_jur_bb->setField("KET_TAMBAH", "PERTGJWBN ". substr($reqKetTambah,0,155)." (".$reqNoNotaUM.")");
	$kbbt_jur_bb->setField("USER_DATA", "GL :");
	$kbbt_jur_bb->setField("ID_KASIR", "");
	$kbbt_jur_bb->setField("APPROVER", "");
	$kbbt_jur_bb->setField("TANDA_TRANS", "");
	$kbbt_jur_bb->setField("LAST_UPDATE_DATE", "TRUNC(SYSDATE)");
	$kbbt_jur_bb->setField("LAST_UPDATED_BY", "AKUNTANSI_PMS");
	$kbbt_jur_bb->setField("PROGRAM_NAME", "VALIDATE_ANGGARAN_IMAIS");
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
		$kbbt_jur_bb->insertJurnalTemp($reqNoNotaJRR);
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
				$kbbt_jur_bb_d->setField('NO_NOTA', $reqNoNotaJRR);
				$kbbt_jur_bb_d->setField('NO_SEQ', $seq);
				$kbbt_jur_bb_d->setField('KD_SUBSIS', "KBB");
				$kbbt_jur_bb_d->setField('KD_JURNAL', "JRR");
				$kbbt_jur_bb_d->setField('TIPE_TRANS', "JRR-KBB-01");
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
				$kbbt_jur_bb_d->setField('PROGRAM_NAME', "VALIDATE_ANGGARAN_IMAIS");
				/*
				$kbbt_jur_bb_d->insert(); 
				echo $kbbt_jur_bb_d->query; 
				*/
				
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
	$kbbt_jur_bb_d->insertTemporary($reqNoNotaJRR);

	if($reqStatusPengembalian == "JKM")
	{
		
		$kbbt_jur_bb = new KbbtJurBb();
		$kbbt_jur_bb_d = new KbbtJurBbD();
				
		if($reqNoNotaJKKJKM == "")
		{	
			$reqNoNotaJKKJKM = $kbbt_jur_bb->getKodeNotaJKM();
		}
		else
		{
			$kbbt_jur_bb->setField("NO_NOTA", $reqNoNotaJKKJKM);
			$kbbt_jur_bb->delete();
			unset($kbbt_jur_bb);
			$kbbt_jur_bb_d->setField("NO_NOTA", $reqNoNotaJKKJKM);
			$kbbt_jur_bb_d->delete();		
			unset($kbbt_jur_bb_d);
			
			$kbbt_jur_bb = new KbbtJurBb();
			$kbbt_jur_bb_d = new KbbtJurBbD();	
		}
			
		$kbbt_jur_bb->setField("KD_CABANG", "96");
		$kbbt_jur_bb->setField("KD_SUBSIS", "KBB");
		$kbbt_jur_bb->setField("TIPE_TRANS", "JKM-KBB-01");
		$kbbt_jur_bb->setField("NO_NOTA", $reqNoNotaJKKJKM);
		$kbbt_jur_bb->setField("JEN_JURNAL", "JKM");
		$kbbt_jur_bb->setField("NO_REF1", $reqNoNotaJKKJKM);
		$kbbt_jur_bb->setField("NO_REF2", $reqNoBukti);
		$kbbt_jur_bb->setField("NO_REF3", $reqNoRef2);
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
		$kbbt_jur_bb->setField("JML_VAL_TRANS", dotToNo($reqJumlahLebihKurang));
		$kbbt_jur_bb->setField("JML_RP_TRANS", dotToNo($reqJumlahLebihKurang));
		$kbbt_jur_bb->setField("KD_BAYAR", "");
		$kbbt_jur_bb->setField("KD_BANK", "");
		$kbbt_jur_bb->setField("NOREK_BANK", "");
		$kbbt_jur_bb->setField("NO_CEK_NOTA", "");
		$kbbt_jur_bb->setField("NO_POSTING", "");
		$kbbt_jur_bb->setField("KET_TAMBAH", "TERIMA KEL. ". substr($reqKetTambah,0,155) ." (".$reqNoNotaJRR.")");
		$kbbt_jur_bb->setField("USER_DATA", "GL :");
		$kbbt_jur_bb->setField("ID_KASIR", "");
		$kbbt_jur_bb->setField("APPROVER", "");
		$kbbt_jur_bb->setField("TANDA_TRANS", "");
		$kbbt_jur_bb->setField("LAST_UPDATE_DATE", "TRUNC(SYSDATE)");
		$kbbt_jur_bb->setField("LAST_UPDATED_BY", "AKUNTANSI_PMS");
		$kbbt_jur_bb->setField("PROGRAM_NAME", "VALIDATE_ANGGARAN_IMAIS");
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
			$kbbt_jur_bb->insertJurnalTemp($reqNoNotaJKKJKM);
			$seq = 1;
			while($anggaran_mutasi_d_pengembalian->nextRow())
			{
				$kbbt_jur_bb_d = new KbbtJurBbD();
				if($anggaran_mutasi_d_pengembalian->getField("SALDO_VAL_DEBET") == 0 && 
				   $anggaran_mutasi_d_pengembalian->getField("SALDO_VAL_KREDIT") == 0 && 
				   $anggaran_mutasi_d_pengembalian->getField("SALDO_RP_DEBET") == 0 && 
				   $anggaran_mutasi_d_pengembalian->getField("SALDO_RP_KREDIT") == 0)
				{}
				else
				{
					$kbbt_jur_bb_d->setField('KD_CABANG', "96");
					$kbbt_jur_bb_d->setField('NO_NOTA', $reqNoNotaJKKJKM);
					$kbbt_jur_bb_d->setField('NO_SEQ', $seq);
					$kbbt_jur_bb_d->setField('KD_SUBSIS', "KBB");
					$kbbt_jur_bb_d->setField('KD_JURNAL', "JKM");
					$kbbt_jur_bb_d->setField('TIPE_TRANS', "JKM-KBB-01");
					$kbbt_jur_bb_d->setField('KLAS_TRANS', "");
					$kbbt_jur_bb_d->setField('KD_BUKU_BESAR', $anggaran_mutasi_d_pengembalian->getField("KD_BUKU_BESAR"));
					$kbbt_jur_bb_d->setField('KD_SUB_BANTU', $anggaran_mutasi_d_pengembalian->getField("KD_SUB_BANTU"));
					$kbbt_jur_bb_d->setField('KD_BUKU_PUSAT', $anggaran_mutasi_d_pengembalian->getField("KD_BUKU_PUSAT"));
					$kbbt_jur_bb_d->setField('KD_VALUTA', "IDR");
					$kbbt_jur_bb_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");
					$kbbt_jur_bb_d->setField('KURS_VALUTA', "1");
					$kbbt_jur_bb_d->setField('SALDO_VAL_DEBET', $anggaran_mutasi_d_pengembalian->getField("SALDO_VAL_DEBET"));
					$kbbt_jur_bb_d->setField('SALDO_VAL_KREDIT', $anggaran_mutasi_d_pengembalian->getField("SALDO_VAL_KREDIT"));
					$kbbt_jur_bb_d->setField('SALDO_RP_DEBET', $anggaran_mutasi_d_pengembalian->getField("SALDO_RP_DEBET"));
					$kbbt_jur_bb_d->setField('SALDO_RP_KREDIT', $anggaran_mutasi_d_pengembalian->getField("SALDO_RP_KREDIT"));
					$kbbt_jur_bb_d->setField('KET_TAMBAH', "");
					$kbbt_jur_bb_d->setField('TANDA_TRANS', "");
					$kbbt_jur_bb_d->setField('KD_AKTIF', "");
					$kbbt_jur_bb_d->setField('PREV_NO_NOTA', "");
					$kbbt_jur_bb_d->setField('REF_NOTA_JUAL_BELI', "");
					$kbbt_jur_bb_d->setField('BAYAR_VIA', "");
					$kbbt_jur_bb_d->setField('STATUS_KENA_PAJAK', "");
					$kbbt_jur_bb_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
					$kbbt_jur_bb_d->setField('LAST_UPDATED_BY', $userLogin->nama);
					$kbbt_jur_bb_d->setField('PROGRAM_NAME', "VALIDATE_ANGGARAN_IMAIS");
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
		$kbbt_jur_bb_d->insertTemporary($reqNoNotaJKKJKM);	
	
	}
	elseif($reqStatusPengembalian == "JKK")
	{
		
		$kbbt_jur_bb = new KbbtJurBb();
		$kbbt_jur_bb_d = new KbbtJurBbD();
				
		if($reqNoNotaJKKJKM == "")
		{	
			$reqNoNotaJKKJKM = $kbbt_jur_bb->getKodeNota();
		}
		else
		{
			$kbbt_jur_bb->setField("NO_NOTA", $reqNoNotaJKKJKM);
			$kbbt_jur_bb->delete();
			unset($kbbt_jur_bb);
			$kbbt_jur_bb_d->setField("NO_NOTA", $reqNoNotaJKKJKM);
			$kbbt_jur_bb_d->delete();		
			unset($kbbt_jur_bb_d);
			
			$kbbt_jur_bb = new KbbtJurBb();
			$kbbt_jur_bb_d = new KbbtJurBbD();	
		}
			
		$kbbt_jur_bb->setField("KD_CABANG", "96");
		$kbbt_jur_bb->setField("KD_SUBSIS", "KBB");
		$kbbt_jur_bb->setField("TIPE_TRANS", "JKK-KBB-01");
		$kbbt_jur_bb->setField("NO_NOTA", $reqNoNotaJKKJKM);
		$kbbt_jur_bb->setField("JEN_JURNAL", "JKK");
		$kbbt_jur_bb->setField("NO_REF1", $reqNoNotaJKKJKM);
		$kbbt_jur_bb->setField("NO_REF2", $reqNoBukti);
		$kbbt_jur_bb->setField("NO_REF3", $reqNoRef2);
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
		$kbbt_jur_bb->setField("JML_VAL_TRANS", dotToNo($reqJumlahLebihKurang));
		$kbbt_jur_bb->setField("JML_RP_TRANS", dotToNo($reqJumlahLebihKurang));
		$kbbt_jur_bb->setField("KD_BAYAR", "");
		$kbbt_jur_bb->setField("KD_BANK", "");
		$kbbt_jur_bb->setField("NOREK_BANK", "");
		$kbbt_jur_bb->setField("NO_CEK_NOTA", "");
		$kbbt_jur_bb->setField("NO_POSTING", "");
		$kbbt_jur_bb->setField("KET_TAMBAH", "PEMBYR KEK. ". substr($reqKetTambah,0,155) ." (".$reqNoNotaJRR.")");
		$kbbt_jur_bb->setField("USER_DATA", "GL :");
		$kbbt_jur_bb->setField("ID_KASIR", "");
		$kbbt_jur_bb->setField("APPROVER", "");
		$kbbt_jur_bb->setField("TANDA_TRANS", "");
		$kbbt_jur_bb->setField("LAST_UPDATE_DATE", "TRUNC(SYSDATE)");
		$kbbt_jur_bb->setField("LAST_UPDATED_BY", "AKUNTANSI_PMS");
		$kbbt_jur_bb->setField("PROGRAM_NAME", "VALIDATE_ANGGARAN_IMAIS");
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
			$kbbt_jur_bb->insertJurnalTemp($reqNoNotaJKKJKM);
			$seq = 1;
			while($anggaran_mutasi_d_pengembalian->nextRow())
			{
				$kbbt_jur_bb_d = new KbbtJurBbD();
				if($anggaran_mutasi_d_pengembalian->getField("SALDO_VAL_DEBET") == 0 && 
				   $anggaran_mutasi_d_pengembalian->getField("SALDO_VAL_KREDIT") == 0 && 
				   $anggaran_mutasi_d_pengembalian->getField("SALDO_RP_DEBET") == 0 && 
				   $anggaran_mutasi_d_pengembalian->getField("SALDO_RP_KREDIT") == 0)
				{					
				}
				else
				{
					
					$kbbt_jur_bb_d->setField('KD_CABANG', "96");
					$kbbt_jur_bb_d->setField('NO_NOTA', $reqNoNotaJKKJKM);
					$kbbt_jur_bb_d->setField('NO_SEQ', $seq);
					$kbbt_jur_bb_d->setField('KD_SUBSIS', "KBB");
					$kbbt_jur_bb_d->setField('KD_JURNAL', "JKK");
					$kbbt_jur_bb_d->setField('TIPE_TRANS', "JKK-KBB-01");
					$kbbt_jur_bb_d->setField('KLAS_TRANS', "");
					$kbbt_jur_bb_d->setField('KD_BUKU_BESAR', $anggaran_mutasi_d_pengembalian->getField("KD_BUKU_BESAR"));
					$kbbt_jur_bb_d->setField('KD_SUB_BANTU', $anggaran_mutasi_d_pengembalian->getField("KD_SUB_BANTU"));
					$kbbt_jur_bb_d->setField('KD_BUKU_PUSAT', $anggaran_mutasi_d_pengembalian->getField("KD_BUKU_PUSAT"));
					$kbbt_jur_bb_d->setField('KD_VALUTA', "IDR");
					$kbbt_jur_bb_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");
					$kbbt_jur_bb_d->setField('KURS_VALUTA', "1");
					$kbbt_jur_bb_d->setField('SALDO_VAL_DEBET', $anggaran_mutasi_d_pengembalian->getField("SALDO_VAL_DEBET"));
					$kbbt_jur_bb_d->setField('SALDO_VAL_KREDIT', $anggaran_mutasi_d_pengembalian->getField("SALDO_VAL_KREDIT"));
					$kbbt_jur_bb_d->setField('SALDO_RP_DEBET', $anggaran_mutasi_d_pengembalian->getField("SALDO_RP_DEBET"));
					$kbbt_jur_bb_d->setField('SALDO_RP_KREDIT', $anggaran_mutasi_d_pengembalian->getField("SALDO_RP_KREDIT"));
					$kbbt_jur_bb_d->setField('KET_TAMBAH', "");
					$kbbt_jur_bb_d->setField('TANDA_TRANS', "");
					$kbbt_jur_bb_d->setField('KD_AKTIF', "");
					$kbbt_jur_bb_d->setField('PREV_NO_NOTA', "");
					$kbbt_jur_bb_d->setField('REF_NOTA_JUAL_BELI', "");
					$kbbt_jur_bb_d->setField('BAYAR_VIA', "");
					$kbbt_jur_bb_d->setField('STATUS_KENA_PAJAK', "");
					$kbbt_jur_bb_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
					$kbbt_jur_bb_d->setField('LAST_UPDATED_BY', $userLogin->nama);
					$kbbt_jur_bb_d->setField('PROGRAM_NAME', "VALIDATE_ANGGARAN_IMAIS");
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
		$kbbt_jur_bb_d->insertTemporary($reqNoNotaJKKJKM);	
	
	}	
	/* UPDATE NO_REF_NOTA */
	$anggaran_mutasi->setField("NO_NOTA_TANGGUNGJAWAB", $reqNoNotaJRR);
	$anggaran_mutasi->setField("NO_NOTA_TANGGUNGJAWAB_SISA", $reqNoNotaJKKJKM);
	$anggaran_mutasi->setField("TG_JAWAB_MANKEU_BY", $userLogin->nama);
	$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $reqId);
	$anggaran_mutasi->updateStatusKirimLebihKurang();
}
else
{
	$anggaran_mutasi_d = new AnggaranMutasiD();
	$anggaran_mutasi_d->selectByParamsJurnalPermintaanAnggaran(array("A.ANGGARAN_MUTASI_ID" => $reqId));
	
	if($reqJenisAnggaranId == 1 || $reqJenisAnggaranId == 5)
		$ket = "PEMBYR ";
	else
		$ket = "PENGISIAN KEMBALI ";
		
	//KIRIM JURNAL JKK	
	include_once("../WEB-INF-SIUK/classes/base/KbbtJurBb.php");
	include_once("../WEB-INF-SIUK/classes/base/KbbtJurBbD.php");
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmPelanggan.php");
		
	$kbbt_jur_bb_cek_posting = new KbbtJurBb();
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb_d = new KbbtJurBbD();
	$safm_pelanggan = new SafmPelanggan();
	
	if($reqNoNotaJKKJKM == "")
	{	
		$reqNoNotaJKKJKM = $kbbt_jur_bb->getKodeNota();
	}
	// cek apakah sudah posting	
	else
	{
		if($kbbt_jur_bb_cek_posting->cekSudahPosting($reqNoNotaJKKJKM) == 1){
			echo $reqId."-Jurnal sudah diposting.";	
			exit;
		}

		$kbbt_jur_bb->setField("NO_NOTA", $reqNoNotaJKKJKM);
		$kbbt_jur_bb->delete();
		unset($kbbt_jur_bb);
		$kbbt_jur_bb_d->setField("NO_NOTA", $reqNoNotaJKKJKM);
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
	$kbbt_jur_bb->setField("NO_NOTA", $reqNoNotaJKKJKM);
	$kbbt_jur_bb->setField("JEN_JURNAL", "JKK");
	$kbbt_jur_bb->setField("NO_REF1", $reqNoNotaJKKJKM);
	$kbbt_jur_bb->setField("NO_REF2", $reqNoBukti);
	$kbbt_jur_bb->setField("NO_REF3", substr($reqNoRef2,0,25));
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
	$kbbt_jur_bb->setField("KET_TAMBAH", $ket. substr($reqKetTambah,0,155));
	$kbbt_jur_bb->setField("USER_DATA", "GL :");
	$kbbt_jur_bb->setField("ID_KASIR", "");
	$kbbt_jur_bb->setField("APPROVER", "");
	$kbbt_jur_bb->setField("TANDA_TRANS", "");
	$kbbt_jur_bb->setField("LAST_UPDATE_DATE", "TRUNC(SYSDATE)");
	$kbbt_jur_bb->setField("LAST_UPDATED_BY", "AKUNTANSI_PMS");
	$kbbt_jur_bb->setField("PROGRAM_NAME", "TGJAWAB_ANGGARAN_IMAIS");
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
		
		$kbbt_jur_bb->insertJurnalTemp($reqNoNotaJKKJKM);
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
				$kbbt_jur_bb_d->setField('NO_NOTA', $reqNoNotaJKKJKM);
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
				$kbbt_jur_bb_d->setField('KET_TAMBAH', $anggaran_mutasi_d->getField("KET_TAMBAH"));
				$kbbt_jur_bb_d->setField('TANDA_TRANS', "");
				$kbbt_jur_bb_d->setField('KD_AKTIF', "");
				$kbbt_jur_bb_d->setField('PREV_NO_NOTA', "");
				$kbbt_jur_bb_d->setField('REF_NOTA_JUAL_BELI', "");
				$kbbt_jur_bb_d->setField('BAYAR_VIA', "");
				$kbbt_jur_bb_d->setField('STATUS_KENA_PAJAK', "");
				$kbbt_jur_bb_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
				$kbbt_jur_bb_d->setField('LAST_UPDATED_BY', $userLogin->nama);
				$kbbt_jur_bb_d->setField('PROGRAM_NAME', "TGJAWAB_ANGGARAN_IMAIS");
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
	$kbbt_jur_bb_d->insertTemporary($reqNoNotaJKKJKM);
	
	/* UPDATE NO_REF_NOTA */
	$anggaran_mutasi->setField("NO_NOTA_TANGGUNGJAWAB", "");
	$anggaran_mutasi->setField("NO_NOTA_TANGGUNGJAWAB_SISA", $reqNoNotaJKKJKM);
	$anggaran_mutasi->setField("TG_JAWAB_MANKEU_BY", $userLogin->nama);
	$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $reqId);
	$anggaran_mutasi->updateStatusKirimLebihKurang();
}



echo $reqId."-Kirim jurnal berhasil.";	
	
?>