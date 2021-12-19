<?
include_once("../WEB-INF/setup/defines.php");
include_once("../WEB-INF/page_config.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/Pesan.php");
include_once("../WEB-INF/classes/base/Menu.php");
include_once("../main/init.php");
$pesan = new Pesan();
$menu = new Menu();
/* PARAMETERS */
$pg = httpFilterGet("pg");
$reqMode = httpFilterRequest("reqMode");
$reqUser = httpFilterPost("reqUser");
$reqPasswd = httpFilterPost("reqPasswd");
$mainFrame = httpFilterRequest("mainFrame");
$cek_surat_masuk = 0;

$_THUMB_PREFIX = "z__thumb_";

/* ACTIONS BY reqMode */
if ($reqMode == "submitLogin" && $reqUser != "" && $reqPasswd != "") 
{
	$userLogin->resetLogin();
	if ($userLogin->verifyUserLogin($reqUser, $reqPasswd)) 
	{		
		$cek_surat_masuk = 1;			
	}
	else
	{
		echo '<script language="javascript">';
		echo 'alert("Username atau password anda masih salah.");';
		echo 'top.location.href = "index.php";';
		echo '</script>';		
		exit;		
	}
}
else if ($reqMode == "submitLogout")
{
	$userLogin->resetLogin();
	$userLogin->emptyUsrSessions();
}

function getMenuByParent($id_induk, $akses_id)
{
	$child = new Menu();
	
	$child->selectByParamsMenu(9, $akses_id, "AKSES_APP_SURVEY", " AND A.MENU_PARENT_ID = '".$id_induk."'");
		
	while($child->nextRow())
	{
		if($child->getField("AKSES") == "D")
		{}
		else
			echo "<a href=\"".$child->getField("LINK_FILE")."\" target=\"mainFrame\">".$child->getField("NAMA")."</a>";
	}
	unset($child);
}


$menu->selectByParamsMenu(9, $userLogin->userAksesSurvey, "AKSES_APP_SURVEY", " AND A.MENU_PARENT_ID = 0 ");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Administration Panel</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style>
@font-face {
    font-family: 'CalibriRegular';
    src: url('../main/fonts/calibri-webfont.eot');
    src: url('../main/fonts/calibri-webfont.eot?#iefix') format('embedded-opentype'),
         url('../main/fonts/calibri-webfont.woff') format('woff'),
         url('../main/fonts/calibri-webfont.ttf') format('truetype'),
         url('../main/fonts/calibri-webfont.svg#CalibriRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

*{ font-family:'CalibriRegular'; font-size:12px;}
</style>

<script type="text/javascript" src="../main/js/jquery.js"></script>
<link href="../main/css/gaya.css" rel="stylesheet" type="text/css">
<!-- slide -->
    <link rel="stylesheet" type="text/css" href="../main/css/demo.css" />
    <link rel="stylesheet" type="text/css" href="../main/css/style.css" />
    
    <noscript>
        <link rel="stylesheet" type="text/css" href="../main/css/noscript.css" />
    </noscript>

<!-- LIVE DATE -->
	<script type="text/javascript" src="../WEB-INF/lib/time/time.js"></script>
    
    <script type="text/javascript">
    // <![CDATA[
    var myMenu;
    window.onload = function() {
        goforit();
    };
    // ]]>
    </script>

<!-- POPUP WINDOW -->
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
    <script type="text/javascript">
    function iecompattest(){
    return (!window.opera && document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
    }
    
    function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
    {
    
        var left = iecompattest().scrollLeft; //(screen.width/2)-(opWidth/2);
        var top = iecompattest().scrollTop; //(screen.width/2)-(opWidth/2);
        
        opWidth = iecompattest().clientWidth;
        opHeight = iecompattest().clientHeight - 40;
        divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
    }
    
    function OpenDHTMLPopup(opAddress, opCaption, opWidth, opHeight)
    {
        var left = (screen.width/2)-(opWidth/2);
        var top = (screen.height/2)-(opHeight/2) - 100;
        
        //opWidth = iecompattest().clientWidth - 200;
        //opHeight = iecompattest().clientHeight - 40;
        divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
    }
    </script>
    
<!-- DISPLAY ELEMENT -->
    <script language="JavaScript" src="../jslib/displayElement.js"></script>
    <script language="JavaScript">
    function openPopup(opUrl,opWidth,opHeight)
    {
        newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top = 100, left = 150");
        newWindow.focus();
    }
    </script>

<!---------------------------------------------------- MENU KIRI ------------------------------------------------------------------------------>
<?php /*?>
<!-- DD LEVELS MENU -->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ddlevelsmenu/ddlevelsfiles/ddlevelsmenu-base.css" />
<!--<link rel="stylesheet" type="text/css" href="plugin/ddlevelsmenu/ddlevelsfiles/ddlevelsmenu-topbar.css" />-->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ddlevelsmenu/ddlevelsfiles/ddlevelsmenu-sidebar.css" />
<script type="text/javascript" src="../WEB-INF/lib/ddlevelsmenu/ddlevelsfiles/ddlevelsmenu.js">
/***********************************************
* All Levels Navigational Menu- (c) Dynamic Drive DHTML code library (http://www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************
</script>
<?php */?>
<!--<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ddlevelsmenu/ddlevelsfiles/ddlevelsmenu-base.css" />-->
<!--<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ddlevelsmenu/ddlevelsfiles/ddlevelsmenu-sidebar.css" />-->

<?php /*?><!-- FLEX DROP DOWN MENU -->    
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/flexdropdown.css" />

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>-->

<script type="text/javascript" src="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/flexdropdown.js">

/***********************************************
* Flex Level Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************

</script><?php */?>

<!-- JSDOMENU -->
<!--<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/jsdomenu1.3/demo/demo.css" />-->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/jsdomenu1.3/themes/classic/classic.css" title="Classic" />
<!--<link rel="alternate stylesheet" type="text/css" href="../WEB-INF/lib/jsdomenu1.3/themes/office_xp/office_xp.css" title="Office XP" />-->
<script type="text/javascript" src="../WEB-INF/lib/jsdomenu1.3/jsdomenu.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/jsdomenu1.3/demo/demo2.inc.js"></script>

</head>

<body onload="initjsDOMenu()" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0" style="overflow:hidden;">
<!--<p>

</p>-->


<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" height="100%">
  <tr>
    <td width="1" rowspan="3">
    
      <table width="230" border="0" cellpadding="0" cellspacing="0" height="100%" id="menuFrame">
        <tr> 
          <!--<td height="100%">&nbsp;</td>-->
          <td valign="top">
          	
          	<section style="padding:0px 5px 0 5px"><a href="index.php"><img src="../WEB-INF/lib/sdmenu/bg-header-menu-kiri.png"></a></section>
            
            <?php /*?><div id="ddsidemenubar" class="markermenu" style="height:1px; margin-top:96px;">
            	<ul>
                <li><a href="#" data-flexmenu="administrasi_aplikasi" data-dir="h" data-offsets="8,0">Administrasi Aplikasi</a></li>
                <li><a href="#" data-flexmenu="penjualan_piutang" data-dir="h" data-offsets="8,0">Penjualan/Piutang (A/R)</a></li>
                <li><a href="#" data-flexmenu="kasir" data-dir="h" data-offsets="8,0">Kasir</a></li>
                <li><a href="#" data-flexmenu="buku_besar" data-dir="h" data-offsets="8,0">Buku&nbsp;Besar (G-L)</a></li>
                <li><a href="#" data-flexmenu="anggaran" data-dir="h" data-offsets="8,0">Anggaran</a></li>
                <li><a href="#" data-flexmenu="pajak" data-dir="h" data-offsets="8,0" style="border-bottom-width: 0">Pajak</a></li>		
                </ul>
            </div><?php */?>
            <?php /*?><script type="text/javascript">
            	ddlevelsmenu.setup("ddsidemenubar", "sidebar") //ddlevelsmenu.setup("mainmenuid", "topbar|sidebar")
            </script><?php */?>
            
            <?php /*?><!-- SUB MENU -->
            <ul id="administrasi_aplikasi" class="flexdropdownmenu">
            <li><a href="#">Admin 1</a>
                <ul>
                <li><a href="parameter_aplikasi.php" target="mainFrame">Parameter Aplikasi</a></li>
                <li><a href="#">Struktur Organisasi</a>
                    <ul>
                    <li><a href="pegawai.php" target="mainFrame" >Master Pegawai</a></li>
                    <li><a href="pegawai_pejabat_otoritas.php" target="mainFrame" >Pejabat Otorisasi</a></li>
                    </ul>
                </li>
                <li><a href="#">Chart of Account</a>
                    <ul>
                    <li><a href="rekening_group.php" target="mainFrame" >Group Rekening (COA)</a></li>
                    <li><a href="rekening_buku_besar.php" target="mainFrame" >Rekening Buku&nbsp;Besar</a></li>
                    <li><a href="rekening_pusat_biaya.php" target="mainFrame" >Rekening Pusat Biaya</a></li>
                    </ul>
                </li>
                <li><a href="#">Referensi Jurnal Transaksi</a>
                    <ul>
                    <li><a href="jurnal.php" target="mainFrame" >Jenis Jurnal Transaksi</a></li>
                    <li><a href="setting_auto_jurnal.php" target="mainFrame" >Setting Auto Jurnal</a></li>
                    </ul>
                </li>
                <li><a href="nota_penomoran.php" target="mainFrame" >Referensi Penomoran</a></li>
                <li><a href="referensi.php" target="mainFrame" >Referensi Lainnya</a></li>
                <li><a href="tahun_pembukuan.php" target="mainFrame" >Tahun Pembukuan</a></li>
                </ul>
            </li>
            <li><a href="#">Admin 2</a>
                <ul>
                <li><a href="pelanggan.php" target="mainFrame" >Master Pelanggan</a></li>
                <li><a href="badan_usaha_coa.php" target="mainFrame" >Rekening Piutang Pelanggan</a></li>
                <li><a href="bank.php" target="mainFrame" >Master Bank Pelabuhan III</a></li>
                <li><a href="kurs.php" target="mainFrame" >Tabel Kurs Valas</a></li>
                <li><a href="kurs_pajak.php" target="mainFrame" >Tabel Pajak</a></li>
                </ul>
            </li>
            <li><a href="kapal.php" target="mainFrame" >Master Kapal</a></li>
            </ul>
            
            <ul id="penjualan_piutang" class="flexdropdownmenu">
            <li> <a href="#" >Penjualan/Piutang (A/R)</a>
              <ul>
                <li> <a href="#" >Transaksi A/R</a>
                  <ul>
                    <li> <a href="#">Penjualan/Penerimaan</a>
                        <ul>
                        <li> <a href="penjualan_tunai.php" target="mainFrame" >Penjualan Tunai (JKM)</a></li>
                        <li> <a href="penjualan_non_tunai.php" target="mainFrame">Penjualan Non Tunai (JPJ)</a></li>
                        </ul>
                    </li>
                    <li> <a href="proses_cetak_nota_penjualan.php" target="mainFrame" >Cetak Nota</a></li>
                    <li> <a href="proses_cetak_ulang_nota_penjualan.php" target="mainFrame" >Proses Cetak Ulang Nota</a></li>
                    <li> <a href="#" >Proses Pelunasan Nota</a>
                        <ul>
                        <li> <a href="proses_pelunasan_kas_bank.php" target="mainFrame" >Pelunasan Kas-Bank (JKM)</a></li>
                        <li> <a href="proses_kompensasi_sisa_uper.php" target="mainFrame" >Kompensasi Sisa Uper (JRR)</a></li>
                        </ul>
                    </li>
                    <li> <a href="cetak_bukti_jurnal_ar.php" target="mainFrame" >Cetak Bukti Jurnal A/R</a></li>
                    <li> <a href="#" >Proses Pembatalan</a>
                        <ul>
                        <li> <a href="pembatalan_sudah_cetak.php" target="mainFrame" >Pembatalan Sdh Cetak Nota</a></li>
                        <li> <a href="pembatalan_pelunasan.php" target="mainFrame" >Pembatalan Pelunasan (JKK)</a></li>
                        <li> <a href="pembatalan_kompensasi.php" target="mainFrame" >Pembatalan Kompensasi (JRR)</a></li>
                        </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            </ul>
            
            
            
            
            
            <ul id="kasir" class="flexdropdownmenu">
            <li> <a href="#">Kasir</a>
              <ul>
                <li> <a href="#">Monitoring Kasir</a>
                    <ul>
                        <li> <a href="inquiry_jurnal_kas_masuk_belum_posting.php" target="mainFrame">JKM Belum Posting</a></li>
                        <li> <a href="inquiry_jurnal_kas_masuk_sudah_posting.php" target="mainFrame">JKM Sudah Posting</a></li>
                        <li> <a href="inquiry_jurnal_kas_keluar_belum_posting.php" target="mainFrame">JKK Belum Posting</a></li>
                        <li> <a href="inquiry_jurnal_kas_keluar_sudah_posting.php" target="mainFrame">JKK Sudah Posting</a></li>
                        <li> <a href="#" target="mainFrame">Jurnal Register Nota</a></li>
                        <li> <a href="monitoring_kas_bank_kasir_dengan_neraca.php" target="mainFrame">Kas-Bank Kasir vs Neraca</a></li>
                    </ul>
                </li>
                <li> <a href="#">Pelaporan Kasir</a>
                    <ul>
                        <li> <a href="monitoring_jurnal_transaksi.php" target="mainFrame">Monitoring Jurnal</a></li>
                        <li> <a href="mutasi_penerimaan_jkm.php" target="mainFrame">Mutasi Penerimaan (JKM)</a></li>
                        <li> <a href="mutasi_pengeluaran_jkk.php" target="mainFrame">Mutasi Pengeluaran (JKK)</a></li>
                        <li> <a href="#">Laporan Harian Kasir</a>
                            <ul>
                                <li> <a href="laporan_harian_mutasi_kas_bank.php" target="mainFrame">Laporan Mutasi Kas Bank</a></li>
                                <li> <a href="laporan_harian_posisi_kas_bank.php" target="mainFrame">Laporan Posisi Kas Bank</a></li>
                                <li> <a href="laporan_harian_kartu_rekening.php" target="mainFrame">Laporan Kartu Rekening</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </li>
                <li> <a href="#">Transaksi Kasir</a>
                    <ul>
                        <li> <a href="#" target="mainFrame">Pelunasan Nota Tagih</a></li>
                        <li> <a href="proses_kompensasi_sisa_uper.php" target="mainFrame">Pelunasan Via Uang Titipan</a></li>
                        <li> <a href="transaksi_kasir_register_bukti_jurnal.php" target="mainFrame">Register Bukti JKM/JKK</a></li>
                        <li> <a href="kurs.php" target="mainFrame">Entry Kurs Baru</a></li>
                        <li> <a href="kurs_pajak.php" target="mainFrame">Entry Kurs Pajak</a></li>
                    </ul>
                </li>
                <li> <a href="#">Laporan Harian Kas Bank</a>
                    <ul>
                        <li> <a href="laporan_harian_mutasi_kas_bank.php" target="mainFrame">Laporan Mutasi Kas Bank</a></li>
                        <li> <a href="laporan_harian_posisi_kas_bank.php" target="mainFrame">Laporan Posisi Kas Bank</a></li>
                        <li> <a href="laporan_harian_kartu_rekening.php" target="mainFrame">Laporan Kartu Rekening</a></li>
                    </ul>
                </li>
              </ul>
            </li>
            </ul>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            <ul id="buku_besar" class="flexdropdownmenu">
            <li> <a href="#">Buku&nbsp;Besar (G-L)</a>
              <ul>
                <li> <a href="#">Transaksi</a>
                    <ul>
                        <li> <a href="jurnal_penerimaan_kas_bank.php" target="mainFrame">Jurnal Penerimaan Kas-Bank</a></li>
                        <li> <a href="jurnal_pengeluaran_kas_bank.php" target="mainFrame">Jurnal Pengeluaran Kas-Bank</a></li>
                        <li> <a href="jurnal_rupa_rupa.php" target="mainFrame">Jurnal Rupa-rupa</a></li>
                        <li> <a href="cetak_bukti_jurnal_gl.php" target="mainFrame">Cetak Bukti Jurnal</a></li>
                        <li> <a href="posting_jurnal.php" target="mainFrame">Posting Jurnal</a></li>
                        <li> <a href="cetak_jurnal_payroll.php" target="mainFrame">Cetak Jurnal Payroll</a></li>
                        <li> <a href="jurnal_pemindahbukuan.php" target="mainFrame">JKM - Pemindahbukuan</a></li>
                    </ul>
                </li>
                <li> <a href="#">Monitoring Saldo</a>
                    <ul>
                        <li> <a href="monitoring_jurnal_transaksi.php" target="mainFrame">Jurnal Transaksi</a></li>
                        <li> <a href="monitoring_neraca_saldo.php" target="mainFrame">Neraca Saldo</a></li>
                        <li> <a href="#">Buku&nbsp;Besar</a></li>
                        <li> <a href="#">Pusat Biaya</a></li>
                        <li> <a href="monitoring_jurnal_transaksi_akuntansi.php" target="mainFrame">Jurnal Transaksi Akuntansi</a></li>
                        <li> <a href="monitoring_saldo_piutang_neraca.php" target="mainFrame">Saldo Piutang &amp; Neraca</a></li>
                    </ul>
                </li>
                <li> <a href="#">Pelaporan Bulanan &amp; Harian</a>
                  <ul>
                    <li> <a href="#">Lap. Bulanan (LB-Rupiah)</a>
                      <ul>
                        <li> <a href="daftar_isi.php" target="mainFrame">Daftar Isi</a></li>
                        <li> <a href="neraca_komparatif.php" target="mainFrame">Neraca Komparatif (LB1)</a></li>
                        <li> <a href="jenis_biaya_kompar.php" target="mainFrame">L/R Jns Biaya Kompar (LB2)</a></li>
                        <li> <a href="jenis_biaya.php" target="mainFrame">L/R Jns Biaya (LB2.1)</a></li>
                        <li> <a href="pusat_biaya_kompar.php" target="mainFrame">L/R Pst Biaya Kompar (LB3)</a></li>
                        <li> <a href="pusat_biaya.php" target="mainFrame">L/R Pst Biaya (LB3.1)</a></li>
                        <li> <a href="rasio_keuangan.php" target="mainFrame">Rasio Keuangan (LB5)</a></li>
                        <li> <a href="arus_kas.php" target="mainFrame">Arus Kas (LB4)</a></li>
                        <li> <a href="#">Ikhtisar Jurnal</a>
                            <ul>
                                <li> <a href="ikhtisar_jkm.php" target="mainFrame">Ikhtisar J.K.M</a></li>
                                <li> <a href="ikhtisar_jkk.php" target="mainFrame">Ikhtisar J.K.K</a></li>
                                <li> <a href="ikhtisar_jpj.php" target="mainFrame">Ikhtisar J.P.J</a></li>
                                <li> <a href="ikhtisar_jpb.php" target="mainFrame">Ikhtisar J.P.B</a></li>
                                <li> <a href="ikhtisar_jpp.php" target="mainFrame">Ikhtisar J.P.P</a></li>
                                <li> <a href="ikhtisar_jrr.php" target="mainFrame">Ikhtisar J.R.R</a></li>
                                <li> <a href="mutasi_rk_pusat.php" target="mainFrame">Mutasi R/K K.Pusat</a></li>
                            </ul>
                        </li>
                        <li> <a href="neraca_saldo.php" target="mainFrame">Neraca Saldo (LB6)</a></li>
                        <li> <a href="buku_besar_per_rekening.php" target="mainFrame">BK. Besar Per Rek.(LB7)</a></li>
                        <li> <a href="ikhtisar_buku_besar.php" target="mainFrame">Ikht. Buku&nbsp;Besar (LB8)</a></li>
                        <li> <a href="ikhtisar_buku_bantu.php" target="mainFrame">Ikht. Buku Bantu (LB9)</a></li>
                        <li> <a href="#">Ikhtisar Pendapatan &amp; Biaya</a>
                            <ul>
                                <li><a href="realisasi_anggaran_pendapatan.php" target="mainFrame">Real. Angg.Pendapatan(LB10)</a></li>
                                <li><a href="realisasi_anggaran_biaya_jenis.php" target="mainFrame">Real. Angg.Biaya/Jenis(LB11)</a></li>
                                <li><a href="realisasi_anggaran_biaya_pusat.php" target="mainFrame">Real. Angg.Biaya/Pusat(LB13)</a></li>
                            </ul>
                        </li>
                        <li> <a href="realisasi_biaya_jenis_pusat.php" target="mainFrame">Real. Biaya Jns / Pst (LB13)</a></li>
                        <li> <a href="realisasi_biaya_pusat_jenis.php" target="mainFrame">Real. Biaya Pst / Jns (LB14)</a></li>
                      </ul>
                    </li>
                    <li> <a href="#">Lap. Bulanan (LB-Valas)</a>
                        <ul>
                            <li> <a href="neraca_saldo_valas.php" target="mainFrame">Neraca Saldo Valas(LB6)</a></li>
                            <li> <a href="ikhtisar_buku_besar_valas.php" target="mainFrame">Ikht. Buku&nbsp;Besar Valas(LB8)</a></li>
                            <li> <a href="ikhtisar_buku_bantu_valas.php" target="mainFrame">Ikht. Buku Bantu Valas(LB9)</a></li>
                        </ul>
                    </li>
                    <li> <a href="#">Lap. Harian (LH1-LH4)</a>
                        <ul>
                            <li> <a href="buku_bantu_per_rekening.php" target="mainFrame">Bk. Bantu Per Rekening(LH1)</a></li>
                            <li> <a href="buku_sub_bantu_neraca.php" target="mainFrame">Buku Sub Bantu Neraca(LH2)</a></li>
                            <li> <a href="buku_sub_bantu_pusat_biaya.php" target="mainFrame">Buku Sub Bantu Pst/Biy(LH3)</a></li>
                            <li> <a href="buku_sub_bantu_jenis_biaya.php" target="mainFrame">Buku Sub Bantu Jns/Biy(LH4)</a></li>
                        </ul>
                    </li>
                    <li> <a href="#">Lap. Mutasi Jurnal</a>
                        <ul>
                            <li> <a href="rincian_mutasi_jurnal.php" target="mainFrame">Rincian Mutasi Jurnal</a></li>
                        </ul>
                    </li>
                    <li> <a href="#">Lap. Standar IFRS</a>
                        <ul>
                            <li> <a href="neraca_komparatif_ifrs.php" target="mainFrame">Neraca Komparatir(LB1)</a></li>
                            <li> <a href="laba_rugi_sifat.php" target="mainFrame">Laba Rugi Sifat(LB2)</a></li>
                            <li> <a href="laba_rugi_fungsi.php" target="mainFrame">Laba Rugi Fungsi(LB3)</a></li>
                        </ul>
                    </li>
                  </ul>
                </li>
                <li> <a href="#">Proses Akhir Tahun</a>
                  <ul>
                    <li><a href="proses_ajp.php" target="mainFrame">Proses AJP (Login User AJP)</a></li>
                    <li><a href="proses_ajt.php" target="mainFrame">Proses AJT (Login User AJT)</a></li>
                    <li><a href="#">Proses Tutup Tahun Buku</a></li>
                    <li> <a href="#">Proses Koreksi Audit</a>
                        <ul>
                            <li> <a href="entry_jurnal_koreksi_audit.php" target="mainFrame">Entry Jurnal Koreksi Audit</a></li>
                            <li> <a href="posting_koreksi_audit.php" target="mainFrame">Posting Koreksi Audit</a></li>
                            <li> <a href="#">Pindah Saldo Audit</a></li>
                        </ul>
                    </li>
                    <li><a href="proses_posting_ajp_ajt.php" target="mainFrame">Proses Posting AJP AJT</a></li>
                    <li><a href="jurnal_tutup_tahun.php" target="mainFrame">Jurnal Tutup Tahun</a></li>
                  </ul>
                </li>
                <li> <a href="maintenance_anggaran.php" target="mainFrame">Maintenance Anggaran</a></li>                            
              </ul>
            </li>
            </ul>
            
            
            
            
            
            
            
            <ul id="anggaran" class="flexdropdownmenu">
            <li> <a href="#">Anggaran</a>
             <ul>
                 <li> <a href="anggaran.php" target="mainFrame">Set Anggaran</a></li>
                 <li> <a href="anggaran_mutasi.php" target="mainFrame">Penggunaan Anggaran</a></li>
                 <li> <a href="anggaran_mutasi_validasi.php" target="mainFrame">Validasi PPA</a></li>
                 <li> <a href="sisa_anggaran.php" target="mainFrame">Sisa Anggaran</a></li>
                 <li> <a href="anggaran_overbudget.php" target="mainFrame">Over Budget</a></li>
             </ul>                        
            </li>
            </ul>
            
            <ul id="pajak" class="flexdropdownmenu">
            <li> <a href="data_diri.php" target="mainFrame">Pajak</a>
             <ul>
                 <li> <a href="pajak_pph_21.php" target="mainFrame">PPH 21</a></li>
                 <li> <a href="pajak_pph_23.php" target="mainFrame">PPH 23</a></li>
                 <li> <a href="pajak_pph_15.php" target="mainFrame">PPH 15</a></li>
                 <li> <a href="pajak_pph_4_ayat_2.php" target="mainFrame">PPH 4 Ayat 2</a></li>
                 <li> <a href="pajak_ppn.php" target="mainFrame">PPN</a></li>
             </ul>
            </li>
            </ul><?php */?>
            
          </td>
        </tr>
      </table>
    
    </td>
    
    <td width="6" rowspan="3" class="show-hide-menu">
    <a href="javascript:displayElement('menuFrame')"><img src="../WEB-INF/images/btn_display_element.gif" border="0" id="showhide-button" name="showhide-button" title="Tutup Menu"></a>
    </td>
    <td>
      <div id="header" style="background:#8df0ef;">
        <div class="navigasi-atas">
			<?
               include_once("../global_page/main_menu.php");
            ?>
        </div>
      </div>
      
    </td>
  </tr>
  <tr> 
    <!--<td valign="top" height="100%" width="100%">
			<iframe src="home.php" class="mainframe" id="idMainFrame" name="mainFrame" width="100%" height="100%" scrolling="auto" frameborder="0"></iframe>
		</td>-->
    <td height="100%" style="background-image:url(../main/images/bkg.jpg)"><?
        if($mainFrame == ""){
        ?>
      <iframe name="mainFrame" src="home.php" scrolling="no" width="100%" height="100%" frameborder="0"></iframe>
      <?
        }else{
        ?>
      <iframe name="mainFrame" src="<? echo $mainFrame.".php";?>" scrolling="yes" width="100%" height="100%" frameborder="0"></iframe>
      <? }?></td>
  </tr>
  <tr>
    <td><div id="footer"> COPYRIGHT &copy; 2012 PT PELINDO MARINE SERVICE. ALL RIGHTS RESERVED. </div></td>
  </tr>
</table>
</body>
</html>
