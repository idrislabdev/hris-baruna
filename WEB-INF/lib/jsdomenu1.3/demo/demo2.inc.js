function createjsDOMenu() {
  absoluteMenu1 = new jsDOMenu(250, "absolute", "", true);
  with (absoluteMenu1) {
    addMenuItem(new menuItem("Administrasi Aplikasi", "administrasi_aplikasi", ""));
    addMenuItem(new menuItem("Penjualan/Piutang (A/R)", "penjualan_piutang", ""));
    addMenuItem(new menuItem("Kasir", "kasir", ""));
    addMenuItem(new menuItem("Buku Besar", "buku_besar", ""));
/*    addMenuItem(new menuItem("Anggaran", "anggaran", ""));
	addMenuItem(new menuItem("Pajak", "pajak", ""));*/
    moveTo(0, 141);
    show();
  }
  
  AdministrasiAplikasi = new jsDOMenu(200, "absolute");
  with (AdministrasiAplikasi) {
    addMenuItem(new menuItem("Admin 1", "admin1", ""));
    addMenuItem(new menuItem("Admin 2", "admin2", ""));
    addMenuItem(new menuItem("Master Kapal", "", "code:mainFrame.location.href='kapal.php'"));
  }
  
  Admin1 = new jsDOMenu(200, "absolute");
  with (Admin1) {
    addMenuItem(new menuItem("Parameter Aplikasi", "", "code:mainFrame.location.href='parameter_aplikasi.php'"));
    addMenuItem(new menuItem("Struktur Organisasi", "struktur_organisasi", ""));
    addMenuItem(new menuItem("Chart of Account", "chart_of_account", ""));
	addMenuItem(new menuItem("Referensi Jurnal Transaksi", "referensi_jurnal_transaksi", ""));
	addMenuItem(new menuItem("Referensi Penomoran", "", "code:mainFrame.location.href='nota_penomoran.php'"));
	addMenuItem(new menuItem("Referensi Lainnya", "", "code:mainFrame.location.href='referensi.php'"));
	addMenuItem(new menuItem("Tahun Pembukuan", "", "code:mainFrame.location.href='tahun_pembukuan.php'"));
  }
  
	  StrukturOrganisasi = new jsDOMenu(200, "absolute");
	  with (StrukturOrganisasi) {
		addMenuItem(new menuItem("Master Pegawai", "", "code:mainFrame.location.href='pegawai.php'"));
		addMenuItem(new menuItem("Pejabat Otorisasi", "", "code:mainFrame.location.href='pegawai_pejabat_otoritas.php'"));
	  }
	  
	  ChartofAccount = new jsDOMenu(200, "absolute");
	  with (ChartofAccount) {
		addMenuItem(new menuItem("Group Rekening (COA)", "", "code:mainFrame.location.href='rekening_group.php'"));
		addMenuItem(new menuItem("Rekening Buku Besar", "", "code:mainFrame.location.href='rekening_buku_besar.php'"));
		addMenuItem(new menuItem("Rekening Pusat Biaya", "", "code:mainFrame.location.href='rekening_pusat_biaya.php'"));
	  }
	  
	  ReferensiJurnalTransaksi = new jsDOMenu(200, "absolute");
	  with (ReferensiJurnalTransaksi) {
		addMenuItem(new menuItem("Jenis Jurnal Transaksi", "", "code:mainFrame.location.href='jurnal.php'"));
		addMenuItem(new menuItem("Setting Auto Jurnal", "", "code:mainFrame.location.href='setting_auto_jurnal.php'"));
	  }
  
  Admin2 = new jsDOMenu(200, "absolute");
  with (Admin2) {			
    addMenuItem(new menuItem("Master Pelanggan", "", "code:mainFrame.location.href='pelanggan.php'"));
    addMenuItem(new menuItem("Rekening Piutang Pelanggan", "", "code:mainFrame.location.href='badan_usaha_coa.php'"));
    addMenuItem(new menuItem("Master Bank Pelabuhan III", "", "code:mainFrame.location.href='bank.php'"));
	addMenuItem(new menuItem("Tabel Kurs Valas", "", "code:mainFrame.location.href='kurs.php'"));
	addMenuItem(new menuItem("Tabel Pajak", "", "code:mainFrame.location.href='kurs_pajak.php'"));
  }
  
  absoluteMenu1.items.administrasi_aplikasi.setSubMenu(AdministrasiAplikasi);
	  AdministrasiAplikasi.items.admin1.setSubMenu(Admin1);
	  AdministrasiAplikasi.items.admin2.setSubMenu(Admin2);
		  Admin1.items.struktur_organisasi.setSubMenu(StrukturOrganisasi);
		  Admin1.items.chart_of_account.setSubMenu(ChartofAccount);
		  Admin1.items.referensi_jurnal_transaksi.setSubMenu(ReferensiJurnalTransaksi);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  PenjualanPiutang = new jsDOMenu(200, "absolute");
  with (PenjualanPiutang) {
    addMenuItem(new menuItem("Transaksi A/R", "transaksi_ar", ""));
  }
  
  TransaksiAR = new jsDOMenu(200, "absolute");
  with (TransaksiAR) {
    addMenuItem(new menuItem("Penjualan/Penerimaan", "penjualan_penerimaan", ""));
    addMenuItem(new menuItem("Cetak Nota", "", "code:mainFrame.location.href='proses_cetak_nota_penjualan.php'"));
    addMenuItem(new menuItem("Proses Cetak Ulang Nota", "", "code:mainFrame.location.href='proses_cetak_ulang_nota_penjualan.php'"));
    addMenuItem(new menuItem("Proses Pelunasan Nota", "proses_pelunasan_nota", ""));
    addMenuItem(new menuItem("Cetak Bukti Jurnal A/R", "", "code:mainFrame.location.href='cetak_bukti_jurnal_ar.php'"));
    addMenuItem(new menuItem("Proses Pembatalan", "proses_pembatalan", ""));
  }
  
  PenjualanPenerimaan = new jsDOMenu(200, "absolute");
  with (PenjualanPenerimaan) {
    addMenuItem(new menuItem("Penjualan Tunai (JKM)", "", "code:mainFrame.location.href='penjualan_tunai.php'"));
    addMenuItem(new menuItem("Penjualan Non Tunai (JPJ)", "", "code:mainFrame.location.href='penjualan_non_tunai.php'"));
  }
  
  ProsesPelunasanNota = new jsDOMenu(200, "absolute");
  with (ProsesPelunasanNota) {
    addMenuItem(new menuItem("Pelunasan Kas-Bank (JKM)", "", "code:mainFrame.location.href='proses_pelunasan_kas_bank.php'"));
    addMenuItem(new menuItem("Kompensasi Sisa Uper (JRR)", "", "code:mainFrame.location.href='proses_kompensasi_sisa_uper.php'"));
  }
  
  ProsesPembatalan = new jsDOMenu(200, "absolute");
  with (ProsesPembatalan) {
    addMenuItem(new menuItem("Pembatalan Sdh Cetak Nota", "", "code:mainFrame.location.href='pembatalan_sudah_cetak.php'"));
    addMenuItem(new menuItem("Pembatalan Pelunasan (JKK)", "", "code:mainFrame.location.href='pembatalan_pelunasan.php'"));
	addMenuItem(new menuItem("Pembatalan Kompensasi (JRR)", "", "code:mainFrame.location.href='pembatalan_kompensasi.php'"));
  }	
  
  absoluteMenu1.items.penjualan_piutang.setSubMenu(PenjualanPiutang);
	  PenjualanPiutang.items.transaksi_ar.setSubMenu(TransaksiAR);
		  TransaksiAR.items.penjualan_penerimaan.setSubMenu(PenjualanPenerimaan);
		  TransaksiAR.items.proses_pelunasan_nota.setSubMenu(ProsesPelunasanNota);
		  TransaksiAR.items.proses_pembatalan.setSubMenu(ProsesPembatalan);
  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  Kasir = new jsDOMenu(200, "absolute");
  with (Kasir) {
    addMenuItem(new menuItem("Monitoring Kasir", "monitoring_kasir", ""));
    addMenuItem(new menuItem("Pelaporan Kasir", "pelaporan_kasir", ""));
    addMenuItem(new menuItem("Transaksi Kasir", "transaksi_kasir", ""));
    addMenuItem(new menuItem("Laporan Harian Kas Bank", "laporan_harian_kas_bank", ""));
  }

  MonitoringKasir = new jsDOMenu(200, "absolute");
  with (MonitoringKasir) {
    addMenuItem(new menuItem("JKM Belum Posting", "", "code:mainFrame.location.href='inquiry_jurnal_kas_masuk_belum_posting.php'"));
    addMenuItem(new menuItem("JKM Sudah Posting", "", "code:mainFrame.location.href='inquiry_jurnal_kas_masuk_sudah_posting.php'"));
    addMenuItem(new menuItem("JKK Belum Posting", "", "code:mainFrame.location.href='inquiry_jurnal_kas_keluar_belum_posting.php'"));
    addMenuItem(new menuItem("JKK Sudah Posting", "", "code:mainFrame.location.href='inquiry_jurnal_kas_keluar_sudah_posting.php'"));
    addMenuItem(new menuItem("Jurnal Register Nota", "", ""));
    addMenuItem(new menuItem("Kas-Bank Kasir vs Neraca", "", "code:mainFrame.location.href='monitoring_kas_bank_kasir_dengan_neraca.php'"));
  }
  
  PelaporanKasir = new jsDOMenu(200, "absolute");
  with (PelaporanKasir) {
    addMenuItem(new menuItem("Monitoring Jurnal", "", "code:mainFrame.location.href='monitoring_jurnal_transaksi.php'"));
    addMenuItem(new menuItem("Mutasi Penerimaan (JKM)", "", "code:mainFrame.location.href='mutasi_penerimaan_jkm.php'"));
    addMenuItem(new menuItem("Mutasi Pengeluaran (JKK)", "", "code:mainFrame.location.href='mutasi_pengeluaran_jkk.php'"));
    addMenuItem(new menuItem("Laporan Harian Kasir", "laporan_harian_kasir", ""));
  }

	  LaporanHarianKasir = new jsDOMenu(200, "absolute");
	  with (LaporanHarianKasir) {
		addMenuItem(new menuItem("Laporan Mutasi Kas Bank", "", "code:mainFrame.location.href='laporan_harian_mutasi_kas_bank.php'"));
		addMenuItem(new menuItem("Laporan Posisi Kas Bank", "", "code:mainFrame.location.href='laporan_harian_posisi_kas_bank.php'"));
		addMenuItem(new menuItem("Laporan Kartu Rekening", "", "code:mainFrame.location.href='laporan_harian_kartu_rekening.php'"));
	  }

  TransaksiKasir = new jsDOMenu(200, "absolute");
  with (TransaksiKasir) {
    addMenuItem(new menuItem("Pelunasan Nota Tagih", "", ""));
    addMenuItem(new menuItem("Pelunasan Via Uang Titipan", "", "code:mainFrame.location.href='proses_kompensasi_sisa_uper.php'"));
    addMenuItem(new menuItem("Register Bukti JKM/JKK", "", "code:mainFrame.location.href='transaksi_kasir_register_bukti_jurnal_add.php'"));
    addMenuItem(new menuItem("Entry Kurs Baru", "", "code:mainFrame.location.href='kurs.php'"));
    addMenuItem(new menuItem("Entry Kurs Pajak", "", "code:mainFrame.location.href='kurs_pajak.php'"));
  }

  LaporanHarianKasBank = new jsDOMenu(200, "absolute");
  with (LaporanHarianKasBank) {
    addMenuItem(new menuItem("Laporan Mutasi Kas Bank", "", "code:mainFrame.location.href='laporan_harian_mutasi_kas_bank.php'"));
	addMenuItem(new menuItem("Laporan Posisi Kas Bank", "", "code:mainFrame.location.href='laporan_harian_posisi_kas_bank.php'"));
	addMenuItem(new menuItem("Laporan Kartu Rekening", "", "code:mainFrame.location.href='laporan_harian_kartu_rekening.php'"));
  }
  
  absoluteMenu1.items.kasir.setSubMenu(Kasir);
	  Kasir.items.monitoring_kasir.setSubMenu(MonitoringKasir);
	  Kasir.items.pelaporan_kasir.setSubMenu(PelaporanKasir);
	  Kasir.items.transaksi_kasir.setSubMenu(TransaksiKasir);
	  Kasir.items.laporan_harian_kas_bank.setSubMenu(LaporanHarianKasBank);
		  PelaporanKasir.items.laporan_harian_kasir.setSubMenu(LaporanHarianKasir);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  BukuBesar = new jsDOMenu(200, "absolute");
  with (BukuBesar) {
    addMenuItem(new menuItem("Transaksi", "transaksi", ""));
	addMenuItem(new menuItem("Monitoring Saldo", "monitoring_saldo", ""));
	addMenuItem(new menuItem("Pelaporan Bulanan dan Harian", "pelaporan_bulanan_dan_harian", ""));
	addMenuItem(new menuItem("Proses Akhir Tahun", "proses_akhir_tahun", ""));
	addMenuItem(new menuItem("Maintenance Anggaran", "", "code:mainFrame.location.href='maintenance_anggaran.php'"));
  }
  
  Transaksi = new jsDOMenu(200, "absolute");
  with (Transaksi) {
	addMenuItem(new menuItem("Jurnal Penerimaan Kas-Bank", "", "code:mainFrame.location.href='jurnal_penerimaan_kas_bank.php'"));
	addMenuItem(new menuItem("Jurnal Pengeluaran Kas-Bank", "", "code:mainFrame.location.href='jurnal_pengeluaran_kas_bank.php'"));
	addMenuItem(new menuItem("Jurnal Rupa-rupa", "", "code:mainFrame.location.href='jurnal_rupa_rupa.php'"));
	addMenuItem(new menuItem("Cetak Bukti Jurnal", "", "code:mainFrame.location.href='cetak_bukti_jurnal_gl.php'"));
	addMenuItem(new menuItem("Posting Jurnal", "", "code:mainFrame.location.href='posting_jurnal.php'"));
	addMenuItem(new menuItem("Cetak Jurnal Payroll", "", "code:mainFrame.location.href='cetak_jurnal_payroll.php'"));
	addMenuItem(new menuItem("JKM - Pemindahbukuan", "", "code:mainFrame.location.href='jurnal_pemindahbukuan.php'"));
  }

  MonitoringSaldo = new jsDOMenu(200, "absolute");
  with (MonitoringSaldo) {
	addMenuItem(new menuItem("Jurnal Transaksi", "", "code:mainFrame.location.href='monitoring_jurnal_transaksi.php'"));
	addMenuItem(new menuItem("Neraca Saldo", "", "code:mainFrame.location.href='monitoring_neraca_saldo.php'"));
	addMenuItem(new menuItem("Buku Besar", "", ""));
	addMenuItem(new menuItem("Pusat Biaya", "", ""));
	addMenuItem(new menuItem("Jurnal Transaksi Akuntansi", "", "code:mainFrame.location.href='monitoring_jurnal_transaksi_akuntansi.php'"));
	addMenuItem(new menuItem("Saldo Piutang dan Neraca", "", "code:mainFrame.location.href='monitoring_saldo_piutang_neraca.php'"));
  }
  
  PelaporanBulananDanHarian = new jsDOMenu(200, "absolute");
  with (PelaporanBulananDanHarian) {
	addMenuItem(new menuItem("Lap. Bulanan (LB-Rupiah)", "lap_bulanan_lb_rupiah", ""));
	addMenuItem(new menuItem("Lap. Bulanan (LB-Valas)", "lap_bulanan_lb_valas", ""));
	addMenuItem(new menuItem("Lap. Harian (LH1-LH4)", "lap_harian_lh1_lh4", ""));
	addMenuItem(new menuItem("Lap. Mutasi Jurnal", "lap_mutasi_jurnal", ""));
	addMenuItem(new menuItem("Lap. Standar IFRS", "lap_standar_ifrs", ""));
  }
  
	  LapBulananLBRupiah = new jsDOMenu(200, "absolute");
	  with (LapBulananLBRupiah) {
		addMenuItem(new menuItem("Daftar Isi", "", "code:mainFrame.location.href='daftar_isi.php'"));
		addMenuItem(new menuItem("Neraca Komparatif (LB1)", "", "code:mainFrame.location.href='neraca_komparatif.php'"));
		addMenuItem(new menuItem("L/R Jns Biaya Kompar (LB2)", "", "code:mainFrame.location.href='jenis_biaya_kompar.php'"));
		addMenuItem(new menuItem("L/R Jns Biaya (LB2.1)", "", "code:mainFrame.location.href='jenis_biaya.php'"));
		addMenuItem(new menuItem("L/R Pst Biaya Kompar (LB3)", "", "code:mainFrame.location.href='pusat_biaya_kompar.php'"));
		addMenuItem(new menuItem("L/R Pst Biaya (LB3.1)", "", "code:mainFrame.location.href='pusat_biaya.php'"));
		addMenuItem(new menuItem("Rasio Keuangan (LB5)", "", "code:mainFrame.location.href='rasio_keuangan.php'"));
		addMenuItem(new menuItem("Arus Kas (LB4)", "", "code:mainFrame.location.href='arus_kas.php'"));
		
		addMenuItem(new menuItem("Ikhtisar Jurnal", "ikhtisar_jurnal", ""));
		addMenuItem(new menuItem("Neraca Saldo (LB6)", "", "code:mainFrame.location.href='neraca_saldo.php'"));
		addMenuItem(new menuItem("BK. Besar Per Rek.(LB7)", "", "code:mainFrame.location.href='buku_besar_per_rekening.php'"));
		addMenuItem(new menuItem("Ikht. Buku Besar (LB8)", "", "code:mainFrame.location.href='ikhtisar_buku_besar.php'"));
		addMenuItem(new menuItem("Ikht. Buku Bantu (LB9)", "", "code:mainFrame.location.href='ikhtisar_buku_bantu.php'"));
		
		addMenuItem(new menuItem("Ikhtisar Pendapatan dan Biaya", "ikhtisar_pendapatan_dan_biaya", ""));
		addMenuItem(new menuItem("Real. Biaya Jns / Pst (LB13)", "", "code:mainFrame.location.href='realisasi_biaya_jenis_pusat.php'"));
		addMenuItem(new menuItem("Real. Biaya Pst / Jns (LB14)", "", "code:mainFrame.location.href='realisasi_biaya_pusat_jenis.php'"));
	  }
	    
		  IkhtisarJurnal = new jsDOMenu(200, "absolute");
		  with (IkhtisarJurnal) {
			addMenuItem(new menuItem("Ikhtisar J.K.M", "", "code:mainFrame.location.href='ikhtisar_jkm.php'"));
			addMenuItem(new menuItem("Ikhtisar J.K.K", "", "code:mainFrame.location.href='ikhtisar_jkk.php'"));
			addMenuItem(new menuItem("Ikhtisar J.P.J", "", "code:mainFrame.location.href='ikhtisar_jpj.php'"));
			addMenuItem(new menuItem("Ikhtisar J.P.B", "", "code:mainFrame.location.href='ikhtisar_jpb.php'"));
			addMenuItem(new menuItem("Ikhtisar J.P.P", "", "code:mainFrame.location.href='ikhtisar_jpp.php'"));
			addMenuItem(new menuItem("Ikhtisar J.R.R", "", "code:mainFrame.location.href='ikhtisar_jrr.php'"));
			addMenuItem(new menuItem("Mutasi R/K K.Pusat", "", "code:mainFrame.location.href='mutasi_rk_pusat.php'"));
		  }	  
		  
		  IkhtisarPendapatanDanBiaya = new jsDOMenu(200, "absolute");
		  with (IkhtisarPendapatanDanBiaya) {
			addMenuItem(new menuItem("Real. Angg.Pendapatan(LB10)", "", "code:mainFrame.location.href='realisasi_anggaran_pendapatan.php'"));
			addMenuItem(new menuItem("Real. Angg.Biaya/Jenis(LB11)", "", "code:mainFrame.location.href='realisasi_anggaran_biaya_jenis.php'"));
			addMenuItem(new menuItem("Real. Angg.Biaya/Pusat(LB13)", "", "code:mainFrame.location.href='realisasi_anggaran_biaya_pusat.php'"));
		  }	  		  
	  
	    
	  LapBulananLBValas = new jsDOMenu(200, "absolute");
	  with (LapBulananLBValas) {
		addMenuItem(new menuItem("Neraca Saldo Valas(LB6)", "", "code:mainFrame.location.href='neraca_saldo_valas.php'"));
		addMenuItem(new menuItem("Ikht. Buku Besar Valas(LB8)", "", "code:mainFrame.location.href='ikhtisar_buku_besar_valas.php'"));
		addMenuItem(new menuItem("Ikht. Buku Bantu Valas(LB9)", "", "code:mainFrame.location.href='ikhtisar_buku_bantu_valas.php'"));
	  }
  
	  LapHarianLH1LH4 = new jsDOMenu(200, "absolute");
	  with (LapHarianLH1LH4) {
		addMenuItem(new menuItem("Bk. Bantu Per Rekening(LH1)", "", "code:mainFrame.location.href='buku_bantu_per_rekening.php'"));
		addMenuItem(new menuItem("Buku Sub Bantu Neraca(LH2)", "", "code:mainFrame.location.href='buku_sub_bantu_neraca.php'"));
		addMenuItem(new menuItem("Buku Sub Bantu Pst/Biy(LH3)", "", "code:mainFrame.location.href='buku_sub_bantu_pusat_biaya.php'"));
		addMenuItem(new menuItem("Buku Sub Bantu Jns/Biy(LH4)", "", "code:mainFrame.location.href='buku_sub_bantu_jenis_biaya.php'"));
	  }
  
	  LapMutasiJurnal = new jsDOMenu(200, "absolute");
	  with (LapMutasiJurnal) {
		addMenuItem(new menuItem("Rincian Mutasi Jurnal", "", "code:mainFrame.location.href='rincian_mutasi_jurnal.php'"));
	  }
  
	  LapStandarIFRS = new jsDOMenu(200, "absolute");
	  with (LapStandarIFRS) {
		addMenuItem(new menuItem("Neraca Komparatir(LB1)", "", "code:mainFrame.location.href='neraca_komparatif_ifrs.php'"));
		addMenuItem(new menuItem("Laba Rugi Sifat(LB2)", "", "code:mainFrame.location.href='laba_rugi_sifat.php'"));
		addMenuItem(new menuItem("Laba Rugi Fungsi(LB3)", "", "code:mainFrame.location.href='laba_rugi_fungsi.php'"));
	  }

  ProsesAkhirTahun = new jsDOMenu(200, "absolute");
  with (ProsesAkhirTahun) {
	addMenuItem(new menuItem("Proses AJP (Login User AJP)", "", "code:mainFrame.location.href='proses_ajp.php'"));
	addMenuItem(new menuItem("Proses AJT (Login User AJT)", "", "code:mainFrame.location.href='proses_ajt.php'"));
	addMenuItem(new menuItem("Proses Tutup Tahun Buku", "", "code:mainFrame.location.href='proses_tutup_tahun_buku.php'"));
	addMenuItem(new menuItem("Proses Koreksi Audit", "proses_koreksi_audit", ""));
	addMenuItem(new menuItem("Proses Posting AJP AJT", "", "code:mainFrame.location.href='proses_posting_ajp_ajt.php'"));
	addMenuItem(new menuItem("Jurnal Tutup Tahun", "", "code:mainFrame.location.href='jurnal_tutup_tahun.php'"));
  }
  
	  ProsesKoreksiAudit = new jsDOMenu(200, "absolute");
	  with (ProsesKoreksiAudit) {
		addMenuItem(new menuItem("Entry Jurnal Koreksi Audit", "", "code:mainFrame.location.href='entry_jurnal_koreksi_audit.php'"));
		addMenuItem(new menuItem("Posting Koreksi Audit", "", "code:mainFrame.location.href='posting_koreksi_audit.php'"));
		addMenuItem(new menuItem("Pindah Saldo Audit", "", ""));
	  }

  absoluteMenu1.items.buku_besar.setSubMenu(BukuBesar);
	  BukuBesar.items.transaksi.setSubMenu(Transaksi);
	  BukuBesar.items.monitoring_saldo.setSubMenu(MonitoringSaldo);
	  BukuBesar.items.pelaporan_bulanan_dan_harian.setSubMenu(PelaporanBulananDanHarian);
	  BukuBesar.items.proses_akhir_tahun.setSubMenu(ProsesAkhirTahun);
	  //BukuBesar.items.maintenance_anggaran.setSubMenu(MaintenanceAnggaran);
	  
		  PelaporanBulananDanHarian.items.lap_bulanan_lb_rupiah.setSubMenu(LapBulananLBRupiah);
		  PelaporanBulananDanHarian.items.lap_bulanan_lb_valas.setSubMenu(LapBulananLBValas);
		  PelaporanBulananDanHarian.items.lap_harian_lh1_lh4.setSubMenu(LapHarianLH1LH4);
		  PelaporanBulananDanHarian.items.lap_mutasi_jurnal.setSubMenu(LapMutasiJurnal);
		  PelaporanBulananDanHarian.items.lap_standar_ifrs.setSubMenu(LapStandarIFRS);
	  
			  LapBulananLBRupiah.items.ikhtisar_jurnal.setSubMenu(IkhtisarJurnal);
			  LapBulananLBRupiah.items.ikhtisar_pendapatan_dan_biaya.setSubMenu(IkhtisarPendapatanDanBiaya);

		  ProsesAkhirTahun.items.proses_koreksi_audit.setSubMenu(ProsesKoreksiAudit);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  Anggaran = new jsDOMenu(200, "absolute");
  with (Anggaran) {
    addMenuItem(new menuItem("Set Anggaran", "", "code:mainFrame.location.href='anggaran.php'"));
    addMenuItem(new menuItem("Penggunaan Anggaran", "", "code:mainFrame.location.href='anggaran_mutasi.php'"));
    addMenuItem(new menuItem("Validasi PPA", "", "code:mainFrame.location.href='anggaran_mutasi_validasi.php'"));
    addMenuItem(new menuItem("Sisa Anggaran", "", "code:mainFrame.location.href='sisa_anggaran.php'"));
    addMenuItem(new menuItem("Over Budget", "", "code:mainFrame.location.href='anggaran_overbudget.php'"));
  }
  
  absoluteMenu1.items.anggaran.setSubMenu(Anggaran);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  Pajak = new jsDOMenu(200, "absolute");
  with (Pajak) {
    addMenuItem(new menuItem("PPH 21", "", "code:mainFrame.location.href='pajak_pph_21.php'"));
    addMenuItem(new menuItem("PPH 23", "", "code:mainFrame.location.href='pajak_pph_23.php'"));
    addMenuItem(new menuItem("PPH 15", "", "code:mainFrame.location.href='pajak_pph_15.php'"));
    addMenuItem(new menuItem("PPH 4 Ayat 2", "", "code:mainFrame.location.href='pajak_pph_4_ayat_2.php'"));
    addMenuItem(new menuItem("PPN", "", "code:mainFrame.location.href='pajak_ppn.php'"));
  }
  
  absoluteMenu1.items.pajak.setSubMenu(Pajak);
  
}