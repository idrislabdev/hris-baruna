<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");


$reqId = httpFilterGet("reqId");
$arrId = explode(",", $reqId);
/*
$arrFinal = array("PESAN" => 'ada ' . $reqId);
echo json_encode($arrFinal); exit;
*/
$error = 0;
for($i=0;$i<count($arrId);$i++)
{
	if($error == 0)
	{
		
			include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
			include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasiD.php");			
			$anggaran_mutasi = new AnggaranMutasi();
			$anggaran_mutasi->selectByParamsPertanggungjawaban(array("A.ANGGARAN_MUTASI_ID" => $arrId[$i]));
			$anggaran_mutasi->firstRow();
			
			$reqJenisAnggaranId = $anggaran_mutasi->getField("JENIS_ANGGARAN_ID");
			$reqPuspelSubBantu = $anggaran_mutasi->getField("PUSPEL_SUB_BANTU");		
			$reqJumlahDiBayar = $anggaran_mutasi->getField("JML_VAL_REALISASI");
			$reqJumlahUangMuka = $anggaran_mutasi->getField("JML_VAL_TRANS");
			$reqNoRef2 = $anggaran_mutasi->getField("NO_REF2");
			$reqKetTambah = $anggaran_mutasi->getField("KET_TAMBAH");
			$reqNoNotaUM = $anggaran_mutasi->getField("NO_NOTA_UM");
			$reqNoNotaJRR = $anggaran_mutasi->getField("NO_NOTA_TANGGUNGJAWAB");
			$reqNoNotaJKKJKM = $anggaran_mutasi->getField("NO_NOTA_TANGGUNGJAWAB_SISA");
			$reqJumlahLebihKurang = $anggaran_mutasi->getField("JML_VAL_LEBIH_KURANG");
			$reqNoNotaUntukAuto = $anggaran_mutasi->getField("NO_NOTA");
			$reqStatusPengembalian = $anggaran_mutasi->getField("STATUS_PENGEMBALIAN");

			if($reqJenisAnggaranId == 3 || $reqJenisAnggaranId == 6)
			{
				$anggaran_mutasi_d = new AnggaranMutasiD();
				$anggaran_mutasi_d_pengembalian = new AnggaranMutasiD();
				
				
				if($reqStatusPengembalian == "JKM")
				{
					$anggaran_mutasi_d->selectByParamsJurnalPertanggungjawabanUangMuka(array("A.ANGGARAN_MUTASI_ID" => $arrId[$i]));
					$anggaran_mutasi_d_pengembalian->selectByParamsJurnalPertanggungjawabanPengembalianJKM(array("A.ANGGARAN_MUTASI_ID" => $arrId[$i]));
					$jumlah_total_jrr = dotToNo($reqJumlahDiBayar);
				}
				elseif($reqStatusPengembalian == "JKK")
				{
					$anggaran_mutasi_d->selectByParamsJurnalPertanggungjawabanUangMukaKurang(array("A.ANGGARAN_MUTASI_ID" => $arrId[$i]));
					$anggaran_mutasi_d_pengembalian->selectByParamsJurnalPertanggungjawabanKurangJKK(array("A.ANGGARAN_MUTASI_ID" => $arrId[$i]));
					$jumlah_total_jrr = dotToNo($reqJumlahUangMuka);
				}
				
				//KIRIM JURNAL JKK	
				include_once("../WEB-INF-SIUK/classes/base/KbbtJurBb.php");
				include_once("../WEB-INF-SIUK/classes/base/KbbtJurBbD.php");
				include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmPelanggan.php");
					
				$kbbt_jur_bb = new KbbtJurBb();
				$kbbt_jur_bb_d = new KbbtJurBbD();
				$safm_pelanggan = new SafmPelanggan();
				
				if($reqNoNotaJRR == "")
				{	
					$reqNoNotaJRR = $kbbt_jur_bb->getKodeNotaJRR();
				}
				else
				{
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
				$kbbt_jur_bb->setField("NO_REF2", $reqNoNotaUntukAuto);
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
				$kbbt_jur_bb->setField("KET_TAMBAH", "PERTGJWBN ".$reqKetTambah." (".$reqNoNotaUM.")");
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
					$kbbt_jur_bb->setField("NO_REF2", $reqNoNotaUntukAuto);
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
					$kbbt_jur_bb->setField("KET_TAMBAH", "TERIMA KEL. ".$reqKetTambah." (".$reqNoNotaJRR.")");
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
					$kbbt_jur_bb->setField("NO_REF2", $reqNoNotaUntukAuto);
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
					$kbbt_jur_bb->setField("KET_TAMBAH", "PEMBYR KEK. ".$reqKetTambah." (".$reqNoNotaJRR.")");
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
				
				unset($kbbt_jur_bb);
				unset($kbbt_jur_bb_d);
				
				
				/* UPDATE NO_REF_NOTA */
				$anggaran_mutasi->setField("NO_NOTA_TANGGUNGJAWAB", $reqNoNotaJRR);
				$anggaran_mutasi->setField("NO_NOTA_TANGGUNGJAWAB_SISA", $reqNoNotaJKKJKM);
				$anggaran_mutasi->setField("TG_JAWAB_MANKEU_BY", $userLogin->nama);
				$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $arrId[$i]);
				$anggaran_mutasi->updateStatusKirimLebihKurang();
				unset($anggaran_mutasi);
				unset($anggaran_mutasi_d);
				unset($anggaran_mutasi_d_pengembalian);
			}
			else
			{
				$anggaran_mutasi_d = new AnggaranMutasiD();
				$anggaran_mutasi_d->selectByParamsJurnalPermintaanAnggaran(array("A.ANGGARAN_MUTASI_ID" => $arrId[$i]));
				
				if($reqJenisAnggaranId == 1 || $reqJenisAnggaranId == 5)
					$ket = "PEMBYR ";
				else
					$ket = "PENGISIAN KEMBALI ";
					
				//KIRIM JURNAL JKK	
				include_once("../WEB-INF-SIUK/classes/base/KbbtJurBb.php");
				include_once("../WEB-INF-SIUK/classes/base/KbbtJurBbD.php");
				include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmPelanggan.php");
					
				$kbbt_jur_bb = new KbbtJurBb();
				$kbbt_jur_bb_d = new KbbtJurBbD();
				$safm_pelanggan = new SafmPelanggan();
				
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
				
				$safm_pelanggan->selectByParams(array("MPLG_KODE" => $reqPuspelSubBantu));
				$safm_pelanggan->firstRow();
				
				$kbbt_jur_bb->setField("KD_CABANG", "96");
				$kbbt_jur_bb->setField("KD_SUBSIS", "KBB");
				$kbbt_jur_bb->setField("TIPE_TRANS", "JKK-KBB-01");
				$kbbt_jur_bb->setField("NO_NOTA", $reqNoNotaJKKJKM);
				$kbbt_jur_bb->setField("JEN_JURNAL", "JKK");
				$kbbt_jur_bb->setField("NO_REF1", $reqNoNotaJKKJKM);
				$kbbt_jur_bb->setField("NO_REF2", $reqNoNotaUntukAuto);
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
				$kbbt_jur_bb->setField("JML_VAL_TRANS", dotToNo($reqJumlahDiBayar));
				$kbbt_jur_bb->setField("JML_RP_TRANS", dotToNo($reqJumlahDiBayar));
				$kbbt_jur_bb->setField("KD_BAYAR", "");
				$kbbt_jur_bb->setField("KD_BANK", "");
				$kbbt_jur_bb->setField("NOREK_BANK", "");
				$kbbt_jur_bb->setField("NO_CEK_NOTA", "");
				$kbbt_jur_bb->setField("NO_POSTING", "");
				$kbbt_jur_bb->setField("KET_TAMBAH", $ket.$reqKetTambah);
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
				
				unset($kbbt_jur_bb);
				unset($kbbt_jur_bb_d);				
				
				
				/* UPDATE NO_REF_NOTA */
				$anggaran_mutasi->setField("NO_NOTA_TANGGUNGJAWAB", "");
				$anggaran_mutasi->setField("NO_NOTA_TANGGUNGJAWAB_SISA", $reqNoNotaJKKJKM);
				$anggaran_mutasi->setField("TG_JAWAB_MANKEU_BY", $userLogin->nama);
				$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $arrId[$i]);
				$anggaran_mutasi->updateStatusKirimLebihKurang();
				unset($anggaran_mutasi);
				unset($anggaran_mutasi_d);
				unset($anggaran_mutasi_d_pengembalian);			
			}
			
			$pesan = "Proses data berhasil.";
	}
}

if($error == 1)
	$pesan = "Proses gagal.";

$arrFinal = array("PESAN" => $pesan);

echo json_encode($arrFinal);
?>