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
<script type="text/javascript" src="../main/js/jquery.js"></script>
<link href="../main/css/gaya.css" rel="stylesheet" type="text/css">
<!-- slide -->
<link rel="stylesheet" type="text/css" href="../main/css/demo.css" />
<link rel="stylesheet" type="text/css" href="../main/css/style.css" />
<noscript>
<link rel="stylesheet" type="text/css" href="../main/css/noscript.css" />
</noscript>
<script type="text/javascript" src="../WEB-INF/lib/time/time.js"></script>

<!-- menu kiri -->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/sdmenu/sdmenu.css" />
<script type="text/javascript" src="../WEB-INF/lib/sdmenu/sdmenu.js"></script>
<script type="text/javascript">
// <![CDATA[
var myMenu;
window.onload = function() {
	goforit();
	myMenu = new SDMenu("my_menu");
	myMenu.init();
};
// ]]>
</script>

<!-- POPUP WINDOW -->
<link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
<script type="text/javascript">
function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
{
	var left = (screen.width/2)-(opWidth/2);
	
	divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=20,resize=1,scrolling=1,midle=1'); return false;
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

<!-- TILE STYLES -->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/tileJs/css/tile.css">

<!-- DRILL DOWN MENU -->
<!--Make sure your page contains a valid doctype at the very top-->

<script type="text/javascript" src="../WEB-INF/lib/DrillDownMenu/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DrillDownMenu/drilldownmenu.css" />
<script type="text/javascript" src="../WEB-INF/lib/DrillDownMenu/drilldownmenu.js">

/***********************************************
* Drill Down Menu script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script>
<script type="text/javascript">

var mymenu=new drilldownmenu({
	menuid: 'drillmenu1',
	menuheight: 'auto',
	breadcrumbid: 'drillcrumb',
	persist: {enable: true, overrideselectedul: true}
})

</script>
</head><body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0" style="overflow:hidden;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" height="100%">
  <tr>
    <td width="1" rowspan="3">
    
      <table width="230" border="0" cellpadding="0" cellspacing="0" height="100%" id="menuFrame">
        <tr> 
          <!--<td height="100%">&nbsp;</td>-->
          <td valign="top">
          
          	<section style="padding:0px 5px 0 5px"><a href="index.php"><img src="../WEB-INF/lib/sdmenu/bg-header-menu-kiri.png"></a></section>
            
            <div id="" class="side" style="height:0px; margin-top:24px;">
              <!--<a style="opacity: 1;" class="trigger" href="#">Hide</a>-->
              <div style="opacity: 1; left: 0px;" class="slide">
                <div style="padding:0px 0px 0px 10px;">
                  <div id="metro-array" style="display: inline-block;">
                    
                    <!--<div id="drillcrumb"></div>-->
                    <div id="drillmenu1" class="drillmenu">
                      <ul>
                        
                        <!-- ADMINISTRASI APLIKASI -->
                        <li> <a href="#" class="metro-tile bg-mn-induk-ADM"><img src="images/tileMenu/menu-aplikasi.png" class="menu-tile"/>Administrasi Aplikasi</a>
                          <ul>
                            <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-admin1.png" class="menu-tile"/>Admin 1</a>
                              <ul>
                                <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-struktur-organisasi.png" class="menu-tile"/>Parameter Aplikasi</a> </li>
                                <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-struktur-organisasi.png" class="menu-tile"/>Struktur Organisasi</a>
                                	<ul>
                                    	<li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-struktur-organisasi.png" class="menu-tile"/>Master Pegawai</a> </li>
                                        <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-struktur-organisasi.png" class="menu-tile"/>Pejabat Otorisasi</a> </li>
                                    </ul>
                                </li>
                                <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-coa.png" class="menu-tile"/>Chart of Account</a>
                                	<ul>
                                    	<li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-coa.png" class="menu-tile"/>Group Rekening (COA)</a> </li>
                                        <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-coa.png" class="menu-tile"/>Rekening Buku&nbsp;Besar</a> </li>
                                        <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-coa.png" class="menu-tile"/>Rekening Pusat Biaya</a> </li>
                                    </ul>
                                </li>
                                <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-jurnal-transaksi.png" class="menu-tile"/>Ref. Jurnal Transaksi</a>
                                	<ul>
                                    	<li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-jurnal-transaksi.png" class="menu-tile"/>Jenis Jurnal Transaksi</a></li>
                                        <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-jurnal-transaksi.png" class="menu-tile"/>Setting Auto Jurnal</a></li>
                                    </ul>
                                </li>
                                <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-jurnal-transaksi.png" class="menu-tile"/>Ref. Penomoran</a> </li>
                                <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-jurnal-transaksi.png" class="menu-tile"/>Ref. Lainnya</a> </li>
                                <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-jurnal-transaksi.png" class="menu-tile"/>Tahun Pembukuan</a> </li>
                              </ul>
                            </li>
                            <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-admin2.png" class="menu-tile"/>Admin 2</a>
                            	<ul>
                                	<li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-admin2.png" class="menu-tile"/>Master Pelanggan</a></li>
                                    <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-admin2.png" class="menu-tile"/>Rek. Piutang Pelanggan</a></li>
                                    <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-admin2.png" class="menu-tile"/>Master Bank Pelabuhan III</a></li>
                                    <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-admin2.png" class="menu-tile"/>Tabel Kurs (Valas)</a></li>
                                    <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-admin2.png" class="menu-tile"/>Tabel Pajak</a></li>
                                </ul>
                            </li>
                            <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-admin3.png" class="menu-tile"/>Admin 3</a>
                            	<ul>
                                	<li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-admin3.png" class="menu-tile"/>Entry Hari Libur</a></li>
                                </ul>
                            </li>
                            <li> <a href="#" class="metro-tile warna-menu"><img src="images/tileMenu/menu-admin3.png" class="menu-tile"/>Entry Master Kapal</a> </li>
                          </ul>
                        </li>
                        
                        <!-- Penjualan-Piutang (A-R) -->
                        <li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-penjualan-piutang.png" class="menu-tile"/>Penjualan/Piutang (A/R)</a>
                          <ul>
                            <li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-transaksi-ar.png" class="menu-tile"/>Transaksi A/R</a>
                              <ul>
                                <li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-penjualan-penerimaan.png" class="menu-tile"/>Penjualan/Penerimaan</a>
                                	<ul>
                                    	<li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-penjualan-penerimaan.png" class="menu-tile"/>Penjualan Tunai (JKM)</a></li>
                                        <li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-penjualan-penerimaan.png" class="menu-tile"/>Penjualan Non Tunai (JPJ)</a></li>
                                    </ul>
                                </li>
                                <li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-transaksi-ar.png" class="menu-tile"/>Cek Nota</a></li>
                                <li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-transaksi-ar.png" class="menu-tile"/>Proses Cetak Ulang Nota</a></li>
                                <li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-pelunasan-nota.png" class="menu-tile"/>Proses Pelunasan Nota</a>
                                	<ul>
                                    	<li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-pelunasan-nota.png" class="menu-tile"/>Pelunasan Kas-Bank (JKM)</a></li>
                                        <li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-pelunasan-nota.png" class="menu-tile"/>Kompensasi Sisa Uper (JRR)</a></li>
                                    </ul>
                                </li>
                                <li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-transaksi-ar.png" class="menu-tile"/>Cetak Bukti Jurnal A/R</a></li>
                                <li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-pembatalan.png" class="menu-tile"/>Proses Pembatalan</a>
                                	<ul>
                                    	<li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-pembatalan.png" class="menu-tile"/>Pembatalan Sdh Cetak Nota</a></li>
                                        <li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-pembatalan.png" class="menu-tile"/>Pembatalan Pelunasan (JKK)</a></li>
                                        <li> <a href="#" class="metro-tile warna-ijo-2"><img src="images/tileMenu/menu-pembatalan.png" class="menu-tile"/>Pembatalan Kompensasi (JRR)</a></li>
                                    </ul>
                                </li>
                              </ul>
                            </li>
                          </ul>
                        </li>
                        
                        <!-- Kasir -->
                        <li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-kasir.png" class="menu-tile"/>Kasir</a>
                          <ul>
                            <li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-transaksi-kasir.png" class="menu-tile"/>Transaksi Kasir</a>
                            	<ul>
                                    <li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-transaksi-kasir.png" class="menu-tile"/>Register Bukti JKM/JKK</a></li>
                                    <li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-transaksi-kasir.png" class="menu-tile"/>Entry Kurs Baru</a></li>
                                    <li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-transaksi-kasir.png" class="menu-tile"/>Entry Kurs Pajak</a></li>
                                </ul>
                            </li>
                            <li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-monitoring-kasir.png" class="menu-tile"/>Monitoring Kasir</a>
                            	<ul>
                                	<li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-monitoring-kasir.png" class="menu-tile"/>JKM Belum Posting</a></li>
                                    <li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-monitoring-kasir.png" class="menu-tile"/>JKM Sudah Posting</a></li>
                                    <li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-monitoring-kasir.png" class="menu-tile"/>JKK Belum Posting</a></li>
                                    <li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-monitoring-kasir.png" class="menu-tile"/>JKK Sudah Posting</a></li>
                                    <li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-monitoring-kasir.png" class="menu-tile"/>Kas-Bank Kasir vs Neraca</a></li>
                                </ul>
                            </li>
                            <li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-pelaporan-kasir.png" class="menu-tile"/>Pelaporan Kasir</a>
                            	<ul>
                                	<li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-pelaporan-kasir.png" class="menu-tile"/>Mutasi Penerimaan (JKM)</a></li>
                                    <li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-pelaporan-kasir.png" class="menu-tile"/>Mutasi Pengeluaran (JKK)</a></li>
                                    <li> <a href="#" class="metro-tile warna-ungu"><img src="images/tileMenu/menu-pelaporan-kasir.png" class="menu-tile"/>Laporan Harian Kasir</a></li>
                                </ul>
                            </li>
                          </ul>
                        </li>
                        
                        <!-- Buku&nbsp;Besar (G-L) -->
                        <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-buku-besar.png" class="menu-tile"/>Buku&nbsp;Besar (G-L)</a>
                          <ul>
                            <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-transaksi-buku-besar.png" class="menu-tile"/>Transaksi</a>
                            	<ul>
                                	<li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-transaksi-buku-besar.png" class="menu-tile"/>Jurnal Penerimaan Kas-Bank</a></li>
                                    <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-transaksi-buku-besar.png" class="menu-tile"/>Jurnal Pengeluaran Kas-Bank</a></li>
                                    <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-transaksi-buku-besar.png" class="menu-tile"/>Jurnal Rupa-rupa</a></li>
                                    <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-transaksi-buku-besar.png" class="menu-tile"/>Cetak Bukti Jurnal</a></li>
                                    <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-transaksi-buku-besar.png" class="menu-tile"/>Posting Jurnal</a></li>
                                    <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-transaksi-buku-besar.png" class="menu-tile"/>Cetak Jurnal Payroll</a></li>
                                    <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-transaksi-buku-besar.png" class="menu-tile"/>JKM - Pemindahbukuan</a></li>
                                </ul>
                            </li>
                            <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-monitoring-saldo.png"/>Monitoring Saldo</a>
                            	<ul>
                                	<li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-monitoring-saldo.png" class="menu-tile"/>Jurnal Transaksi</a></li>
                                    <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-monitoring-saldo.png" class="menu-tile"/>Neraca Saldo</a></li>
                                    <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-monitoring-saldo.png" class="menu-tile"/>Buku&nbsp;Besar</a></li>
                                    <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-monitoring-saldo.png" class="menu-tile"/>Pusat Biaya</a></li>
                                    <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-monitoring-saldo.png" class="menu-tile"/>Jurnal Transaksi</a></li>
                                    <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-monitoring-saldo.png" class="menu-tile"/>Saldo Piutang &amp; Neraca</a></li>
                                </ul>
                            </li>
                            <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-pelaporan-bulanan-harian.png" class="menu-tile"/>Pelaporan Bulanan &amp; Harian</a>
                              <ul>
                                <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-rupiah.png" class="menu-tile"/>Lap. Bulanan (LB-Rupiah)</a>
                                  <ul>
                                  	<li> <a href="#" class="metro-tile bg-mn-report-GL laporan">Daftar Isi</a></li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">Neraca Komparatif (LB1)</a></li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">L/R Jns Biaya Kompar (LB2)</a></li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">L/R Jns Biaya (LB2.1)</a></li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">L/R Pst Biaya Kompar (LB3)</a></li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">L/R Pst Biaya (LB3.1)</a></li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">Rasio Keuangan (LB5)</a></li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">Arus Kas (LB4)</a></li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">Ikhtisar Jurnal</a>
                                    	<ul>
                                        	<li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-rupiah.png" class="menu-tile"/>Ikhtisar J.K.M</a></li>
                                            <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-rupiah.png" class="menu-tile"/>Ikhtisar J.K.K</a></li>
                                            <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-rupiah.png" class="menu-tile"/>Ikhtisar J.P.J</a></li>
                                            <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-rupiah.png" class="menu-tile"/>Ikhtisar J.P.B</a></li>
                                            <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-rupiah.png" class="menu-tile"/>Ikhtisar J.P.P</a></li>
                                            <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-rupiah.png" class="menu-tile"/>Ikhtisar J.R.R</a></li>
                                            <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-rupiah.png" class="menu-tile"/>Mutasi R/K K.Pusat</a></li>
                                        </ul>
                                    </li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">Neraca Saldo (LB6)</a></li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">BK. Besar Per Rek.(LB7)</a></li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">Ikht. Buku&nbsp;Besar (LB8)</a></li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">Ikht. Buku Bantu (LB9)</a></li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">Ikhtisar Pendapatan &amp; Biaya</a>
                                    	<ul>
                                        	<li><a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-rupiah.png" class="menu-tile"/>Real. Angg.Pendapatan(LB10)</a></li>
                                            <li><a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-rupiah.png" class="menu-tile"/>Real. Angg.Biaya/Jenis(LB11)</a></li>
                                            <li><a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-rupiah.png" class="menu-tile"/>Real. Angg.Biaya/Pusat(LB13)</a></li>
                                        </ul>
                                    </li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">Real. Biaya Jns / Pst (LB13)</a></li>
                                    <li> <a href="#" class="metro-tile bg-mn-report-GL laporan">Real. Biaya Pst / Jns (LB14)</a></li>
                                  </ul>
                                </li>
                                <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-valas.png" class="menu-tile"/>Lap. Bulanan (LB-Valas)</a>
                                	<ul>
                                    	<li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-valas.png" class="menu-tile"/>Neraca Saldo Valas(LB6)</a></li>
                                        <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-valas.png" class="menu-tile"/>Ikht. Buku&nbsp;Besar Valas(LB8)</a></li>
                                        <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-valas.png" class="menu-tile"/>Ikht. Buku Bantu Valas(LB9)</a></li>
                                    </ul>
                                </li>
                                <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LH1-LH4.png" class="menu-tile"/>Lap. Harian (LH1-LH4)</a>
                                	<ul>
                                    	<li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-valas.png" class="menu-tile"/>Bk. Bantu Per Rekening(LH1)</a></li>
                                        <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-valas.png" class="menu-tile"/>Buku Sub Bantu Neraca(LH2)</a></li>
                                        <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-valas.png" class="menu-tile"/>Buku Sub Bantu Pst/Biy(LH4)</a></li>
                                        <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-valas.png" class="menu-tile"/>Buku Sub Bantu Jns/Biy(LH4)</a></li>
                                    </ul>
                                </li>
                                <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-laporan-mutasi-jurnal.png" class="menu-tile"/>Lap. Mutasi Jurnal</a>
                                	<ul>
                                    	<li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-valas.png" class="menu-tile"/>Rincian Mutasi Jurnal</a></li>
                                    </ul>
                                </li>
                                <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-laporan-standar-ifrs.png" class="menu-tile"/>Lap. Standar IFRS</a>
                                	<ul>
                                    	<li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-valas.png" class="menu-tile"/>Neraca Komparatir(LB1)</a></li>
                                        <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-valas.png" class="menu-tile"/>Laba Rugi Sifat(LB2)</a></li>
                                        <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-LB-valas.png" class="menu-tile"/>Laba Rugi Fungsi(LB3)</a></li>
                                    </ul>
                                </li>
                              </ul>
                            </li>
                            <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-proses-akhir-tahun.png" class="menu-tile"/>Proses Akhir Tahun</a>
                              <ul>
                              	<li><a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-proses-akhir-tahun.png" class="menu-tile"/>Proses AJP (Login User AJP)</a></li>
                                <li><a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-proses-akhir-tahun.png" class="menu-tile"/>Proses AJT (Login User AJT)</a></li>
                                <li><a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-proses-akhir-tahun.png" class="menu-tile"/>Proses Tutup Tahun Buku</a></li>
                                <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-proses-koreksi-audit.png" class="menu-tile"/>Proses Koreksi Audit</a>
                                	<ul>
                                    	<li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-proses-koreksi-audit.png" class="menu-tile"/>Entry Jurnal Koreksi Audit</a></li>
                                        <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-proses-koreksi-audit.png" class="menu-tile"/>Posting Koreksi Audit</a></li>
                                        <li> <a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-proses-koreksi-audit.png" class="menu-tile"/>Pindah Saldo Audit</a></li>
                                    </ul>
                                </li>
                                <li><a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-proses-akhir-tahun.png" class="menu-tile"/>Proses Posting AJP AJT</a></li>
                                <li><a href="#" class="metro-tile warna-biru-toska"><img src="images/tileMenu/menu-proses-akhir-tahun.png" class="menu-tile"/>Jurnal Tutup Tahun</a></li>
                              </ul>
                            </li>
                          </ul>
                        </li>
                        
                        <!-- ANGGARAN -->
                        <li> <a href="#" class="metro-tile warna-kunir-2"><img src="images/tileMenu/menu-anggaran.png" class="menu-tile"/>Anggaran</a></li>
                        
                        <!-- PAJAK -->
                        <li> <a href="pajak.php" target="mainFrame" class="metro-tile warna-ijo-3"><img src="images/tileMenu/menu-pajak.png" class="menu-tile"/>Pajak</a></li>
                        
                      </ul>
                      <!--<br style="clear: left" />-->

                    </div>
                    
                    <!--<a href="#" rel="drillback-drillmenu1"><img src="../WEB-INF/lib/DrillDownMenu/backbutton.jpg" style="border-width:0; margin:10px 0 10px 17px" /></a>--> 
                    
                    <!-- Simple grid for the demo! None of these styles are required, thats just how I've styled my tiles --> 
                    <!-- The only important thing is class="metro-tile" --> 
                    
                  </div>
                </div>
                
                <!-- Including TileJs... YAY! --> 
                <script src="../WEB-INF/lib/tileJs/js/tileJs.js" type="text/javascript"></script> 
                <div class="bg-footer2">
                <span>Copyright &copy; Pemerintah Kabupaten Probolinggo.</span>
                </div> 
                
              </div>
            </div>
            
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
        <div style="clear:both;"></div>
        <div style="font-size:12px; padding-left:39px; margin-top:24px; text-align:right; margin-right:20px;">
          <div><span style="position:relative; background:#58d0cf; margin-right:5px; padding-top:5px; padding-bottom:1px;">&nbsp; </span> <span id="drillcrumb" style="background:#FFF; padding:0 10px 0 0;"></span></div>
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
    <td height="43"><div id="footer"> COPYRIGHT &copy; 2012 PT PELINDO MARINE SERVICE. ALL RIGHTS RESERVED. </div></td>
  </tr>
</table>
</body>
</html>
