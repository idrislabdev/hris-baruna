<?
include_once("../WEB-INF/setup/defines.php");
include_once("../WEB-INF/page_config.php");

include_once("../WEB-INF/classes/utils/UserLogin.php");

if ($userLogin->checkUserLogin()) { 
	$userLogin->retrieveUserInfo();
	if ($userLogin->aksesKeuangan == 'NO') { 
		showMessageDlg("Anda tidak memiliki hak untuk mengakses halaman ini.",false,"../main/index.php");
	}
}
else {
	showMessageDlg("Anda tidak memiliki hak untuk mengakses halaman ini.",false,"../main/login.php");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Office Management</title>

<link rel="stylesheet" type="text/css" href="../WEB-INF/css/gaya.css">

<!-- MENU DOWN RIGHT ACCORDION -->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/jQueryDownRightAccordion/SmoothNavigationalMenu/ddsmoothmenu.css" />
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/jQueryDownRightAccordion/SmoothNavigationalMenu/ddsmoothmenu-v.css" />

<script type="text/javascript" src="../WEB-INF/lib/jQueryDownRightAccordion/SmoothNavigationalMenu/jquery.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/jQueryDownRightAccordion/SmoothNavigationalMenu/ddsmoothmenu.js">

/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>

<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "smoothmenu-1", //menu DIV id
	orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
	method: 'hover', // set to 'hover' (default) or 'toggle'
	arrowswap: true, // enable rollover effect on menu arrow images?
	//customtheme: ["#804000", "#482400"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

ddsmoothmenu.init({
	mainmenuid: "smoothmenu-2", //Menu DIV id
	orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
	method: 'hover', // set to 'hover' (default) or 'toggle'
	arrowswap: true, // enable rollover effect on menu arrow images?
	//customtheme: ["#804000", "#482400"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})


ddsmoothmenu.init({
	mainmenuid: "smoothmenu-3", //Menu DIV id
	orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
	method: 'hover', // set to 'hover' (default) or 'toggle'
	arrowswap: true, // enable rollover effect on menu arrow images?
	//customtheme: ["#804000", "#482400"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})


ddsmoothmenu.init({
	mainmenuid: "smoothmenu-4", //Menu DIV id
	orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
	method: 'hover', // set to 'hover' (default) or 'toggle'
	arrowswap: true, // enable rollover effect on menu arrow images?
	//customtheme: ["#804000", "#482400"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})


ddsmoothmenu.init({
	mainmenuid: "smoothmenu-5", //Menu DIV id
	orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
	method: 'hover', // set to 'hover' (default) or 'toggle'
	arrowswap: true, // enable rollover effect on menu arrow images?
	//customtheme: ["#804000", "#482400"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>


<!-- jQUERY ACCORDION CONTENT -->
<link href="../WEB-INF/lib/jQueryDownRightAccordion/jqueryAccordionMenu/style/format.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../WEB-INF/lib/jQueryDownRightAccordion/jquery.min.js"> </script>
<script type="text/javascript" src="../WEB-INF/lib/jQueryDownRightAccordion/jqueryAccordionMenu/includes/javascript.js"> </script>


<!-- HIDDEN SIDEBAR -->
<script type='text/javascript'>
	//<![CDATA[ 
	$(window).load(function(){
		$("#setHideMenu").val("");
		$('button').click(function () {
			$('#sisi-kiri').toggleClass('hidden');
			//$('.ddsmoothmenu-v').toggleClass('hidden');
			
			
			$('#sisi-kanan').toggleClass('hidden');
			
			var setHideMenu="";
			setHideMenu= $("#setHideMenu").val();
			
			if(setHideMenu == "")
			{
				//$('.ddsmoothmenu-v').hide();
				//$(".ddsmoothmenu-v").fadeOut();
				//$(".ddsmoothmenu-v").fadeOut("slow");
				$(".sidebar-area").fadeOut(500);

				$("#setHideMenu").val("1");	
			} else {
				//$('.ddsmoothmenu-v').show();
				//$(".ddsmoothmenu-v").fadeIn();
				//$(".ddsmoothmenu-v").fadeIn("slow");
				$(".sidebar-area").fadeIn(3000);

				$("#setHideMenu").val("");
			}
		});
	});//]]>  

</script>


<!-- HOVER NOTIFIKASI / TOOLTIP -->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/TooltipMenu/css/default.css" />
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/TooltipMenu/css/component.css" />
<script src="../WEB-INF/lib/TooltipMenu/js/modernizr.custom.js"></script>

<!-- PROGRESS BAR -->
<script type="text/javascript" src="../WEB-INF/lib/progressbar/progressbar.js"></script>

<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/progressbar/progressbar.css">
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/progressbar/skins/tiny-green/progressbar.css">

<!-- JQUERY WINDOW -->
<link id="jquery_ui_theme_loader" type="text/css" href="../WEB-INF/lib/window/js/jquery/themes/black-tie/jquery-ui.css" rel="stylesheet" />
<link type="text/css" href="../WEB-INF/lib/window/js/jquery/window/css/jquery.window.css" rel="stylesheet" />
<!-- jQuery Library -->
<script type="text/javascript" src="../WEB-INF/lib/window/js/jquery/jquery.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/window/js/jquery/jquery-ui.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/window/js/jquery/window/jquery.window.js"></script>
<script type="text/javascript">
    function OpenDHTML(opAddress, opCaption, opWidth, opHeight) {
        $.window({
            showModal: true,
            modalOpacity: 0.6,
            title: opCaption,
            url: opAddress,
            bookmarkable: false,
			showFooter: false,
			//onShow: function(wnd) {  // a callback function while container is added into body
			//  $(".maximizeImg").click();
			//}
        });
    }

	function OpenDHTMLPopUp(opAddress, opCaption, opWidth, opHeight) {
        $.window({
            showModal: true,
            modalOpacity: 0.6,
            title: opCaption,
            url: opAddress,
            bookmarkable: false,
			showFooter: false,
            width: opWidth,
            height: opHeight
			
        });
		maximized = true;
    }
		
	function createWindow2() {
        $.window({
            showModal: true,
            modalOpacity: 0.6,
            title: "Judul Popup Window",
            url: "popup.php",
            bookmarkable: false,
			showFooter: false
        });
    }
	
	function closeWindow()
	{
		$(".closeImg").click();	
	}
	
	
</script>


</head>

<body style="height:100%; min-height:100%;">

<div id="kontainer" style="height:100%; min-height:100%;">
	<div id="header">
    	<?
		$_GET["reqModul"] = "Aplikasi Keuangan";
        include_once "../global_page/header.php";
		?>
	</div>
    <div id="sisi-kiri">
		<?
		$menu_array = array(
			array(
			  "accordion_button" => "Administrasi Aplikasi",
			  "accordion_content" => 
				array(
					array(
						"nama" => "Admin 1",
						"link" => "#",
						"sub" => array(
							array(
								"nama" => "Parameter Aplikasi",
								"link" => "parameter_aplikasi.php"
							),
							array(
								"nama" => "Struktur Organisasi",
								"link" => "#",
								"sub" => array(
									array(
										"nama" => "Master Pegawai",
										"link" => "pegawai.php"
									),
									array(
										"nama" => "Pejabat Otoritas",
										"link" => "pegawai_pejabat_otoritas.php"
									)
								)
							),
							array(
								"nama" => "Chart Of Account",
								"link" => "#",
								"sub" => array(
									array(
										"nama" => "Group Rekening COA",
										"link" => "rekening_group.php"
									),
									array(
										"nama" => "Rekening Buku Besar",
										"link" => "rekening_buku_besar.php"
									),
									array(
										"nama" => "Rekening Pusat Biaya",
										"link" => "rekening_pusat_biaya.php"
									)
								)
							),
							array(
								"nama" => "Referensi Jurnal Transaksi",
								"link" => "#",
								"sub" => array(
									array(
										"nama" => "Jenis Jurnal Transaksi",
										"link" => "jurnal.php"
									),
									array(
										"nama" => "Setting Auto Jurnal",
										"link" => "setting_auto_jurnal.php"
									)
								)
							),
							array(
								"nama" => "Referensi Penomoran",
								"link" => "parameter_aplikasi.php"
							),
							array(
								"nama" => "Referensi Lainnya",
								"link" => "parameter_aplikasi.php"
							),
							array(
								"nama" => "Tahun Pembukuan",
								"link" => "tahun_pembukuan.php"
							)
						)
					),
					array(
						"nama" => "Admin 2",
						"link" => "#",
						"sub" => array(
							array(
								"nama" => "Master Pelanggan",
								"link" => "pelanggan.php"
							),
							array(
								"nama" => "Rekening Piutang Pelanggan",
								"link" => "badan_usaha_coa.php"
							),
							array(
								"nama" => "Master Bank",
								"link" => "bank.php"
							),
							array(
								"nama" => "Tabel Kurs Valas",
								"link" => "kurs.php"
							),
							array(
								"nama" => "Tabel Pajak",
								"link" => "kurs_pajak.php"
							),
							array(
								"nama" => "Tabel Faktur Pajak",
								"link" => "faktur_pajak.php"
							)
					  )
					)
				)
			),
			array(
				"accordion_button" => "Penjualan  / Piutang A/R",
				"accordion_content" => 
				  array(
					  array(
						  "nama" => "Transaksi AR",
						  "link" => "#",
						  "sub" => array(
								array(
									"nama" => "Penjualan Penerimaan",
									"link" => "#",
									"sub" => array(
										array(
											"nama" => "Penjualan Tunai (JKM)",
											"link" => "penjualan_tunai.php"
										),
										array(
											"nama" => "Penjualan Non Tunai (JPJ)",
											"link" => "penjualan_non_tunai.php"
										),
										array(
											"nama" => "Penjualan Non SPP (JPJ)",
											"link" => "penjualan_non_spp.php"
										),array(
											"nama" => "Transaksi SPP Siswa (JPJ)",
											"link" => "penjualan_pembayaran.php"
										),
										array(
											"nama" => "Transaksi SPP STIAMAK JPJ)",
											"link" => "penjualan_pembayaran_stiamak.php"
										)
									)
								),
								array(
									"nama" => "Cetak Nota",
									"link" => "proses_cetak_nota_penjualan.php",
								),
								array(
									"nama" => "Proses Cetak Ulang Nota",
									"link" => "proses_cetak_ulang_nota_penjualan.php",
								),
								array(
									"nama" => "Proses Pelunasan Nota",
									"link" => "#",
									"sub" => array(
										array(
											"nama" => "Pelunasan Kas - Bank Per Pelanggan (JKM)", 
											"link" => "proses_pelunasan_kas_bank.php"
										),
										array(
											"nama" => "Pelunasan Kas - Bank Per Transaksi (JKM)", 
											"link" => "proses_pelunasan_transaksi_kas_bank.php"
										),
										array(
											"nama" => "Pelunasan Non SPP (JKM)", 
											"link" => "proses_pelunasan_nonspp.php"
										),
										array(
											"nama" => "Pelunasan SPP Siswa (JKM)", 
											"link" => "proses_pelunasan_pembayaran.php"
										),
										array(
											"nama" => "Pelunasan SPP STIAMAK (JKM)", 
											"link" => "proses_pelunasan_pembayaran_stiamak.php"
										),
										array(
											"nama" => "Pelunasan Uang Titipan ", 
											"link" => "proses_kompensasi_sisa_uper.php"
										),
										array(
											"nama" => "Pelunasan Tunai", 
											"link" => "proses_pelunasan_kas_tunai.php"
										)
									)
								),
								array(
									"nama" => "Cetak Bukti Jurnal A/r",
									"link" => "cetak_bukti_jurnal_ar.php",
								),
								array(
									"nama" => "Proses Pembatalan",
									"link" => "#",
									"sub" => array(
										array(
											"nama" => "Pembatalan Sudah Cetak Nota",
											"link" => "pembatalan_sudah_cetak.php"
										),
										array(
											"nama" => "Pembatalan Pelunasan (JKK)",
											"link" => "pembatalan_pelunasan.php"
										)
									)
								),
								array(
									"nama" => "Koreksi Pelunasan (JPJ - JRR)",
									"link" => "koreksi_pelunasan.php",
								),
								array(
									"nama" => "Maintenance SPP",
									"link" => "maintenance_spp.php",
								),
								array(
									"nama" => "Maintenance Non SPP",
									"link" => "maintenance_nonspp.php",
								),
								array(
									"nama" => "Koreksi Tagihan (JPJ - JRR)",
									"link" => "koreksi_tagihan.php",
								),
								array(
									"nama" => "Pembatalan Sudah Cetak (JPJ)",
									"link" => "koreksi_tagihan_sudah.php",
								),
						  )
					  )
				  )
			  ),
			array(
			"accordion_button" => "Kasir",
			"accordion_content" => 
				array(
					array(
						"nama" => "Monitoring Kasir",
						"link" => "#",
						"sub" => array(
							array(
								"nama" => "JKM Belum Posting",
								"link" => "inquiry_jurnal_kas_masuk_belum_posting.php"
							),
							array(
								"nama" => "JKM Sudah Posting",
								"link" => "inquiry_jurnal_kas_masuk_sudah_posting.php"
							),
							array(
								"nama" => "JKK Belum Posting",
								"link" => "inquiry_jurnal_kas_keluar_belum_posting.php"
							),
							array(
								"nama" => "JKM Sudah Posting",
								"link" => "inquiry_jurnal_kas_keluar_sudah_posting.php"
							),
							array(
								"nama" => "Jurnal Register Nota",
								"link" => "transaksi_kasir_register_bukti_jurnal.php"
							),
							array(
								"nama" => "Kas Bank Kasir Vs Neraca",
								"link" => "monitoring_kas_bank_kasir_dengan_neraca.php"
							),
						)
					),
					array(
						"nama" => "Pelaporan Kasir",
						"link" => "#",
						"sub" => array(
							array(
								"nama" => "Monitoring Jurnal",
								"link" => "monitoring_jurnal_transaksi.php",
							),
							array(
								"nama" => "Mutasi Penerimaan (JKM)",
								"link" => "mutasi_penerimaan_jkm.php",
							),
							array(
								"nama" => "Mutasi Pengeluaran (JKK)",
								"link" => "mutasi_pengeluaran_jkk.php",
							),
							array(
								"nama" => "Laporan Harian Kasir",
								"link" => "#",
								"sub" => array(
									array(
										"nama" => "Laporan Mutasi Kas Bank",
										"link" => "laporan_harian_mutasi_kas_bank.php"
									),
									array(
										"nama" => "Laporan Posisi Kas Bank",
										"link" => "laporan_harian_posisi_kas_bank.php"
									),
									array(
										"nama" => "Laporan Kartu Rekening",
										"link" => "laporan_harian_kartu_rekening.php"
									)
								)
							)
						)
					),
					array(
						"nama" => "Transaksi Kasir",
						"link" => "#",
						"sub" => array(
							array(
								"nama" => "Peluansan Via Uang Titipan",
								"link" => "proses_kompensasi_sisa_uper.php"
							),
							array(
								"nama" => "Register Bukti JKM/JKK",
								"link" => "transaksi_kasir_register_bukti_jurnal.php"
							),
							array(
								"nama" => "Entry Kurs Baru",
								"link" => "kurs.php"
							),
							array(
								"nama" => "Entry Kurs Pajak",
								"link" => "kurs_pajak.php"
							)
						)
					)
				)
			),
			array(
				"accordion_button" => "Buku Besar G/L",
				"accordion_content" => 
					array(
						array(
							"nama" => "Transaksi",
							"link" => "#",
							"sub" => array(
								array(
									"nama" => "Jurnal Penerimaan Kas Bank",
									"link" => "jurnal_penerimaan_kas_bank.php"
								),
								array(
									"nama" => "Jurnal Pengeluaran Kas Bank",
									"link" => "jurnal_pengeluaran_kas_bank.php"
								),
								array(
									"nama" => "Jurnal Rupa Rupa",
									"link" => "jurnal_rupa_rupa.php"
								),
								array(
									"nama" => "Cetak Bukti Jurnal",
									"link" => "cetak_bukti_jurnal_gl.php"
								),
								array(
									"nama" => "Posting Jurnal",
									"link" => "posting_jurnal.php"
								), 
								array(
									"nama" => "Rubah Posting",
									"link" => "rubah_posting.php"
								),
								array(
									"nama" => "JKM-Pemindahbukuan",
									"link" => "jurnal_pemindahbukuan.php"
								)
							)
						),
						array(
							"nama" => "Monitoring Saldo",
							"link" => "#",
							"sub" => array(
								array(
									"nama" => "Jurnal Transaksi",
									"link" => "monitoring_jurnal_transaksi.php"
								),
								array(
									"nama" => "Neraca Saldo",
									"link" => "monitoring_neraca_saldo.php"
								),
								array(
									"nama" => "Buku Besar",
									"link" => "buku_besar_monitoring.php"
								),
								array(
									"nama" => "Buku Bantu",
									"link" => "buku_bantu_monitoring.php"
								),
								array(
									"nama" => "Jurnal Tranasksi Akuntansi",
									"link" => "monitoring_jurnal_transaksi_akuntansi.php"
								),
								array(
									"nama" => "Saldo Piutang dan Nerca",
									"link" => "monitoring_saldo_piutang_neraca.php"
								),
							)
						),
						array(
							"nama" => "Pelaporan Bulanan dan Harian",
							"link" => "#",
							"sub" => array(
								array(
									"nama" => "Lap Bulanan (LB Rupiah)",
									"link" => "neraca_komparatif.php",
									"sub" => array(
										array(
											"nama" => "Daftar Isi",
											"link" => "daftar_isi.php"
										),
										array(
											"nama" => "Neraca Komparatif (LB1)",
											"link" => "neraca_komparatif.php"
										),
										array(
											"nama" => "L/R Jenis Biaya Kompar (LB2)",
											"link" => "jenis_biaya_kompar.php"
										),
										array(
											"nama" => "L/R Jenis Biaya (LB2.1)",
											"link" => "jenis_biaya.php"
										),
										array(
											"nama" => "L/R Pusat Biaya Kompar (LB3)",
											"link" => "pusat_biaya_kompar.php"
										),
										array(
											"nama" => "L/R Pusat Biaya (LB3.1)",
											"link" => "pusat_biaya.php"
										),
										array(
											"nama" => "Rasio Keuangan (LBS)",
											"link" => "rasio_keuangan.php"
										),
										array(
											"nama" => "Arus Kas (LB4)",
											"link" => "arus_kas.php"
										),
										array(
											"nama" => "Ikhtisar Jurnal",
											"link" => "#",
											"sub" => array(
												array(
													"nama" => "Ikhtisar JKM",
													"link" => "ikhtisar_jkm.php"
												),
												array(
													"nama" => "Ikhtisar JKK",
													"link" => "ikhtisar_jkk.php"
												),
												array(
													"nama" => "Ikhtisar JPJ	",
													"link" => "ikhtisar_jpj.php"
												),
												array(
													"nama" => "Ikhtisar JRR",
													"link" => "ikhtisar_jrr.php"
												),
												array(
													"nama" => "Mutasi R/K K.Pusat",
													"link" => "mutasi_rk_pusat.php"
												),
											)
										),
										array(
											"nama" => "Neraca Saldo (LB6)",
											"link" => "neraca_saldo.php"
										),
										array(
											"nama" => "BK. Besar Per Rek (LB7)",
											"link" => "buku_besar_per_rekening.php"
										),
										array(
											"nama" => "Ikt. Buku Besar (LB8)",
											"link" => "ikhtisar_buku_besar.php"
										),
										array(
											"nama" => "Ikht. Buku Bantu (LB8.1)",
											"link" => "ikhtisar_buku_besar_bantu.php"
										),
										array(
											"nama" => "Ikht. Buku Sub Bantu (LB9)",
											"link" => "ikhtisar_buku_bantu.php"
										),
										array(
											"nama" => "Ikht. Pendapatan Dan Biaya",
											"link" => "#",
											"sub" => array(
												array(
													"nama" => "Real Angg Pendapatan (LB10)",
													"link" => "realisasi_anggaran_pendapatan.php"
												),
												array(
													"nama" => "Real Angg Biaya/Jenis (LB11)",
													"link" => "realisasi_anggaran_biaya_jenis.php"
												),
												array(
													"nama" => "Real Angg Biaya/Pusat (LB12)",
													"link" => "realisasi_anggaran_biaya_pusat.php"
												)
											)
										),
										array(
											"nama" => "Real Biaya Jns / PST (LB13)",
											"link" => "realisasi_biaya_jenis_pusat.php"
										),
										array(
											"nama" => "Laporan Bulanan Semua",
											"link" => "realisasi_biaya_pusat_jenis.php"
										),
										array(
											"nama" => "Laporan Bulanan Semua",
											"link" => "laporan_bulanan_semua.php"
										),
										array(
											"nama" => "Laporan Aktivitas Kompilasi",
											"link" => "laporan_aktivitas_kompilasi.php"
										),
										array(
											"nama" => "Laporan Aktivitas Sumberdana",
											"link" => "laporan_aktivitas_sumberdana"
										),
										array(
											"nama" => "L/R Per Sekolah (LB11.3)",
											"link" => "jenis_biaya_persekolah.php"
										),
									)
								),
								array(
									"nama" => "Laporan Per Sekolah",
									"link" => "#",
									"sub" => array(
										array(
											"nama" => "Laporan Posisi Keuangan",
											"link" => "neraca_komparatif.php"
										),
										array(
											"nama" => "Laporan Aktivitas Kenaikan / Penurunan Komperatif",
											"link" => "#",
											"sub" => array(
												array(
													"nama" => "Pusat",
													"link" => "jenis_biaya_kompar.php"
												),
												array(
													"nama" => "Cabang",
													"link" => "jenis_biaya_kompar.php?reqMode=cabang"
												)
											)
										),
										array(
											"nama" => "Laporan Aktivitas Kenaikan / Penurunan",
											"link" => "#",
											"sub" => array(
												array(
													"nama" => "Pusat",
													"link" => "jenis_biaya.php"
												),
												array(
													"nama" => "Cabang",
													"link" => "jenis_biaya.php?reqMode=cabang"
												)
											)
										),
										array(
											"nama" => "Arus Kas",
											"link" => "arus_kas.php"
										),
										array(
											"nama" => "Neraca Saldo",
											"link" => "neraca_saldo.php"
										),
										array(
											"nama" => "Rincian Neraca",
											"link" => "ikhtisar_buku_besar.php"
										),
										array(
											"nama" => "Rincian Pendapatan",
											"link" => "#", 
											"sub" => array(
												array(
													"nama" => "Pusat",
													"link" => "realisasi_anggaran_pendapatan.php"
												),
												array(
													"nama" => "Cabang",
													"link" => "realisasi_anggaran_pendapatan.php?reqMode=cabang"
												)
											)
										),
										array(
											"nama" => "Rincian Biaya",
											"link" => "#",
											"sub" => array(
												array(
													"nama" => "Pusat",
													"link" => "realisasi_anggaran_biaya_jenis.php"
												),
												array(
													"nama" => "Cabang",
													"link" => "realisasi_anggaran_biaya_jenis.php?reqMode=cabang"
												)
											)
										),
										array(
											"nama" => "Sub Buku Bantu",
											"link" => "#",
											"sub" => array(
												array(
													"nama" => "Pusat",
													"link" => "ikhtisar_buku_bantu.php"
												),
												array(
													"nama" => "Cabang",
													"link" => "ikhtisar_buku_bantu.php?reqMode=cabang"
												)
											)
										),
										array(
											"nama" => "Sumber Dana",
											"link" => "laporan_aktivitas_sumberdana.php"
										),
									)
								),
								array(
									"nama" => "Laporan Harian (LH1-LH4)",
									"link" => "#",
									"sub" => array(
										array(
											"nama" => "Bk Bantu Per Rekening (LH1)",
											"link" => "buku_bantu_per_rekening.php"
										),
										array(
											"nama" => "Buku Sub Bantu Neraca (LH2)",
											"link" => "buku_sub_bantu_neraca.php"
										),
										array(
											"nama" => "Buku Sub Bantu  PST / BIY (LH3)",
											"link" => "buku_sub_bantu_pusat_biaya.php"
										),
										array(
											"nama" => "Buku Sub Bantu JNS / BIY (LH4)",
											"link" => "buku_sub_bantu_jenis_biaya.php"
										)
									)
								),
								array(
									"nama" => "Laporan Mutasi Jurnal",
									"link" => "#",
									"sub" => array(
										array(
											"nama" => "Rincian Mutasi Jurnal",
											"link" => "rincian_mutasi_jurnal.php"
										)
									)
								),
								array(
									"nama" => "Laporan Standar IFRS",
									"link" => "#",
									"sub" => array(
										array(
											"nama" => "Neraca Komparatif",
											"link" => "neraca_komparatif_ifrs.php"
										),
										array(
											"nama" => "Laba Rugi Sifat (LB2)",
											"link" => "laba_rugi_sifat.php"
										),
										array(
											"nama" => "Laba Rugi Fungsi (LB3)",
											"link" => "laba_rugi_fungsi.php"
										)
									)
								)
							)
						),
						array(
							"nama" => "Proses Akhir Tahun",
							"link" => "#",
							"sub" => array(
								array(
									"nama" => "Proses AJP (Login User AJP)",
									"link" => "proses_ajp.php"
								),
								array(
									"nama" => "Proses AJT (Login User AJT)",
									"link" => "proses_ajt.php"
								),
								array(
									"nama" => "Proses Tutup Tahun Buku",
									"link" => "proses_tutup_tahun_buku.php"
								),
								array(
									"nama" => "Proses Koreksi Audit",
									"link" => "#",
									"sub" => array(
										array(
											"nama" => "Entri Jurnal Koreksi Audit",
											"link" => "entry_jurnal_koreksi_audit.php"
										),
										array(
											"nama" => "Posting Koreksi Audit",
											"link" => "posting_koreksi_audit.php"
										),
										array(
											"nama" => "Pindah Saldo Audit",
											"link" => "#"
										)
									)
								)
							)
						),
						array(
							"nama" => "Maintenance Anggaran",
							"link" => "maintenance_anggaran.php"
						),
						array(
							"nama" => "Create File Keu. Pusat",
							"link" => "create_file_keu_pusat.php"
						),
						array(
							"nama" => "LH To Excel",
							"link" => "lh_to_excel.php"
						),
						array(
							"nama" => "Inquiry",
							"link" => "#",
							"sub" => array(
								array(
									"nama" => "Monitoring Jurnal",
									"link" => "monitoring_jurnal.php"
								)
							)
						)
					)
			),
			array(
				"accordion_button" => "Perbendaharaan",
				"accordion_content" => 
					array(
						array(
							"nama" => "Info Piutang Per Debitur",
							"link" => "#",
							"sub" => array(
								array(
									"nama" => "Info Transaksi Online",
									"link" => "info_tranasksi_online.php"
								)
							)
						),
						array(
							"nama" => "Neraca Saldo Vs Bantu",
							"link" => "saldo_neraca_vs_bantu.php"
						),
						array(
							"nama" => "Monitoringi Neraca Saldo",
							"link" => "monitoring_neraca_saldo.php"
						)
					)
			),
			array(
				"accordion_button" => "Pajak",
				"accordion_content" => 
					array(
						array(
							"nama" => "PPH 4 Ayat 2",
							"link" => "pph_4_ayat_2.php"
						),
						array(
							"nama" => "PPH 15",
							"link" => "pph_15.php"
						),
						array(
							"nama" => "PPH 21",
							"link" => "pph_21.php"
						),
						array(
							"nama" => "PPH 23",
							"link" => "pph_23.php"
						),
						array(
							"nama" => "PPH Penjualan",
							"link" => "ppn.php	"
						)
			),
			array(
				"accordion_button" => "Hapus Jurnal",
				"accordion_content" => 
					array(
						array(
							"nama" => "Maintenance Jurnal",
							"link" => "hapus_jurnal.php"
						)
					)
				)
			)
		);

        include_once "../global_page/sidebar.php";
		?>
	</div>
    <div id="sisi-kanan">
    	
		<div id="frame-area">
        	<iframe name="mainFrame" src="home.php"></iframe>
        </div>
        
    </div>
</div>

<script src="../WEB-INF/lib/TooltipMenu/js/cbpTooltipMenu.min.js"></script>
<script>
	var menu = new cbpTooltipMenu( document.getElementById( 'cbp-tm-menu' ) );
</script>

</body>
</html>
