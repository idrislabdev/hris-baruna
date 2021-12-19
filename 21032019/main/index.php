<?
include_once("../WEB-INF/setup/defines.php");
include_once("../WEB-INF/page_config.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/KataMutiara.php");
include_once("../WEB-INF/classes/base/Informasi.php");
include_once("../WEB-INF/classes/base/HasilRapat.php");
include_once("../WEB-INF/classes/base/HasilRapatAttachment.php");
include_once("../WEB-INF/classes/base/Agenda.php");
include_once("../WEB-INF/classes/base/Faq.php");

if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$kata_mutiara = new KataMutiara();
$informasi = new Informasi();
$hasil_rapat = new HasilRapat();
$hasil_rapat_attachment = new HasilRapatAttachment();
$agenda = new Agenda();
$faq = new Faq();

$kata_mutiara->selectByParams(array(), 7, 0, "", "ORDER BY dbms_random.value");
$informasi->selectByParams(array("A.STATUS" => 1), 2, 0, "AND SUBSTR(A.DEPARTEMEN_ID, 1, 3) = 'CAB'");
$statement_hasil_rapat = "
					AND (
                    EXISTS(SELECT 1 FROM HASIL_RAPAT_DEPARTEMEN X WHERE X.HASIL_RAPAT_ID = A.HASIL_RAPAT_ID AND DEPARTEMEN_ID LIKE '".substr($userLogin->idDepartemen, 0, 2)."%')
                    OR EXISTS(SELECT 1 FROM HASIL_RAPAT_JABATAN X INNER JOIN PEL_SIMPEG.PEGAWAI_JABATAN_TERAKHIR Y ON Y.JABATAN_ID = X.JABATAN_ID WHERE X.HASIL_RAPAT_ID = A.HASIL_RAPAT_ID AND Y.PEGAWAI_ID = '".$userLogin->pegawaiId."')
                    OR A.DEPARTEMEN_ID = 'CAB1'
                    )
			  ";
$hasil_rapat->selectByParams(array("STATUS" => 1), 3, 0, $statement_hasil_rapat);
$agenda->selectByParams(array("STATUS" => 1), 2, 0, "AND SUBSTR(A.DEPARTEMEN_ID, 1, 3) = 'CAB'");
$faq->selectByParams(array(), 2, 0);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Office Management System</title>
<link rel="stylesheet" href="../WEB-INF/css/gaya.css" type="text/css" />
<style>
</style>

<!-- DROPTILES -->
<script type="text/javascript" src="droptiles/js/Combined.js?v=14"></script>
<!--<link rel="stylesheet" type="text/css" href="droptiles/css/bootstrap.min.css">-->
<link rel="stylesheet" type="text/css" href="droptiles/css/droptiles.css?v=14">
<style>
.app-nama{ color:#77726f; font-size:16px; margin-bottom:10px;}
.app-last-login-icon{ float:left; margin-right:10px; padding-top:7px;}
.app-keterangan{ float:right; color:#aba7a5; }
</style>



<!-- HOVER NOTIFIKASI / TOOLTIP -->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/TooltipMenu/css/default.css" />
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/TooltipMenu/css/component.css" />
<script src="../WEB-INF/lib/TooltipMenu/js/modernizr.custom.js"></script>

<!-- PROGRESS BAR -->
<script type="text/javascript" src="../WEB-INF/lib/progressbar/progressbar.js"></script>

<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/progressbar/progressbar.css">
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/progressbar/skins/tiny-green/progressbar.css">


<!-- LIVE DATE -->
<script>

/*
Live Date Script- 
© Dynamic Drive (www.dynamicdrive.com)
For full source code, installation instructions, 100's more DHTML scripts, and Terms Of Use,
visit http://www.dynamicdrive.com
*/

var dayarray = new Array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu")
var montharray = new Array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember")

function getthedate() {
    var mydate = new Date()
    var year = mydate.getYear()
    if (year < 1000)
        year += 1900
    var day = mydate.getDay()
    var month = mydate.getMonth()
    var daym = mydate.getDate()
    if (daym < 10)
        daym = "0" + daym
    var hours = mydate.getHours()
    var minutes = mydate.getMinutes()
    var seconds = mydate.getSeconds()
    var dn = "AM"
    if (hours >= 12)
        dn = "PM"
    if (hours > 12) {
        hours = hours - 12
    }
    if (hours == 0)
        hours = 12
    if (minutes <= 9)
        minutes = "0" + minutes
    if (seconds <= 9)
        seconds = "0" + seconds
    
	    //change font size here
    var cdate = "<small><font color='000000' face='Arial'><b>" + dayarray[day] + ", " + montharray[month] + " " + daym + ", " + year + " " + hours + ":" + minutes + ":" + seconds + " " + dn + "</b></font></small>"
	var cjam = hours + ":" + minutes
	var chari = dayarray[day] + ", " + daym + " " + montharray[month] + " " + year
	
    if (document.all)
        //document.all.clock.innerHTML = cdate,
		document.all.jam.innerHTML = cjam,
		document.all.hari.innerHTML = chari
    else if (document.getElementById)
        //document.getElementById("clock").innerHTML = cdate,
		document.getElementById("jam").innerHTML = cjam,
		document.getElementById("hari").innerHTML = chari
    else
        //document.write(cdate),
		document.write(cjam),
		document.write(chari)
}
if (!document.all && !document.getElementById)
    getthedate()

function goforit() {
    if (document.all || document.getElementById)
        setInterval("getthedate()", 1000)
}

</script>

<!-- NEWS TICKER -->
<link href="../WEB-INF/lib/news-ticker-4-line/Workshop.rs_ News Ticker in 4 lines of jQuery_files/global.css" rel="stylesheet" type="text/css">
<script src="../WEB-INF/lib/news-ticker-4-line/Workshop.rs_ News Ticker in 4 lines of jQuery_files/jquery.js"></script>
<link href="../WEB-INF/lib/news-ticker-4-line/Workshop.rs_ News Ticker in 4 lines of jQuery_files/css.css" rel="stylesheet" type="text/css">


<!-- NIFTY MODAL WINDOW -->
<!--<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ModalWindowEffects/css/default.css" />
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ModalWindowEffects/css/component.css" />
<script src="../WEB-INF/lib/ModalWindowEffects/js/modernizr.custom.js"></script>-->

<!-- MODAL WINDOW EFFECT -->
<!--<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ModalWindowEffects/css/default.css" />-->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ModalWindowEffects/css/component.css" />
<!--<script src="../WEB-INF/lib/ModalWindowEffects/js/modernizr.custom.js"></script>-->

<!-- FONT AWESOME -->
<!--<link rel="stylesheet" href="../WEB-INF/lib/fontawesome-free-5.5.0/css/fontawesome.css" type="text/css" />-->
<link rel="stylesheet" href="../WEB-INF/lib/font-awesome-4.7.0/css/font-awesome.css" type="text/css" />

<style>
.metro-sections{
	*border: 2px solid yellow;
	margin-top: 0px !important;
}
</style>

</head>

<body onLoad="goforit()">
<div id="kontainer" style="background:#383838;">
	<div id="header">
    	<?
        include_once "../global_page/header.php";
		?>
    </div>
    <div id="side-kiri-main">
    	<div class="logo-pel-main"><a href="index.php"><img src="../WEB-INF/images/logo.png" /></a></div>
        <div class="kata-mutiara">
        	<div class="kata-mutiara-judul">Kata Mutiara</div>
            <div class="kata-mutiara-isi">
                <ul id="ticker_02" class="ticker">
                <?
                while($kata_mutiara->nextRow())
				{
				?>
                    <li style="display: list-item; text-align:justify"><?=$kata_mutiara->getField("KETERANGAN")?><br /><em><strong><?=$kata_mutiara->getField("NAMA")?></strong></em></li>
                <?
				}
				?>
                </ul>
            </div>
            <div class="kata-mutiara-mask">&nbsp;</div>
        </div>
        <div id="footer-waktu">
        	<div id="footer-waktu-jam"><span id="jam"></span></div>
        	<div id="footer-waktu-tgl"><span id="hari"></span></div>
        </div>
    </div>
    <div id="side-kanan-main">
    	<div id="main-informasi">
        	<div id="main-berita">
            	<div class="main-informasi-judul">Berita Terbaru <span><a class="md-trigger md-setperspective" data-modal="modal-berita" title="lihat semua berita"><i class="fa fa-arrow-circle-right"></i></a></span></div>
                <?
                while($informasi->nextRow())
				{
				?>
                <div class="berita-list">
                	<div class="berita-thumb"><img src="../WEB-INF/images/berita-thumb.jpg" /></div>
                    <div class="berita-ket">
                    	<div class="berita-tgl"><?=getFormattedDate($informasi->getField("TANGGAL"))?></div>
                        <div class="berita-isi"><a href="#" class="md-trigger md-setperspective" data-modal="modal-berita-detil" ><strong><?=truncate($informasi->getField("NAMA"), 6)?></strong>.</a> <br /><span style="font-size:14px;"><?=truncate(dropAllHtml($informasi->getField("KETERANGAN")), 9)?>...</span>
                        </div>
                    </div>
                </div>
                <?
				}
				?>
            </div>
            
            <div class="md-modal md-effect-19" id="modal-berita">
                <div class="md-content" style="width:100%; height:600px; background:#e85f32;">
                    <h3>Berita</h3>
                    <div>
                        <iframe src="berita.php"></iframe>
                        <div class="tombol-close"><img class="md-close" src="../WEB-INF/images/icon-close.png"></div>
                    </div>
                </div>
            </div>
            <div class="md-modal md-effect-19" id="modal-berita-detil">
                <div class="md-content" style="width:100%; height:600px; background:#e85f32;">
                    <h3>Berita</h3>
                    <div>
                        <iframe src="berita_detil.php"></iframe>
                        <div class="tombol-close"><img class="md-close" src="../WEB-INF/images/icon-close.png"></div>
                    </div>
                </div>
            </div>
			
            <!-- AGENDA -->
            <div id="main-agenda">
            	<div class="main-informasi-judul">Agenda Kegiatan <span><a href="#" class="md-trigger md-setperspective" data-modal="modal-agenda" title="lihat semua agenda"><i class="fa fa-arrow-circle-right"></i></a></span></div>
				<?
                while($agenda->nextRow())
				{
					
				?>
                <div class="agenda-list">
                	<div class="agenda-thumb">
                    	<div class="agenda-tgl"><?=$agenda->getField("TGL")?></div>
                        <div class="agenda-bulan"><?=getNameMonth((int)$agenda->getField("BLN"))?></div>
                    </div>
                    <div class="agenda-ket">
                    	<div class="agenda-isi"><a href="#"><?=truncate(dropAllHtml($agenda->getField("KETERANGAN")), 30)?></a></div>
                    </div>
                </div>
                <?
				}
				?>
            </div>
            <div class="md-modal md-effect-19" id="modal-agenda">
                <div class="md-content" style="width:100%; height:600px; background:#5e853a;">
                    <h3>Agenda Kegiatan</h3>
                    <div>
                        <iframe src="agenda.php"></iframe>
                        <div class="tombol-close"><img class="md-close" src="../WEB-INF/images/icon-close.png"></div>
                    </div>
                </div>
            </div>
            
            <!-- RAPAT -->
            <div id="main-rapat">
            	<div class="main-informasi-judul">Hasil Rapat <span><a href="#" class="md-trigger md-setperspective" data-modal="modal-rapat" title="lihat semua hasil rapat"><i class="fa fa-arrow-circle-right"></i></a></span></div>
                <div class="rapat-pdf"><img src="../WEB-INF/images/icon-pdf-besar.png" /></div>
                <div class="rapat-area">
                <?
                while($hasil_rapat->nextRow())
				{
					$hasil_rapat_attachment = new HasilRapatAttachment();
				?>
                	<div class="rapat-list">
                    	<div class="rapat-isi"><?=$hasil_rapat->getField("NAMA")?></div>
                        <?
                        $hasil_rapat_attachment->selectByParams(array("HASIL_RAPAT_ID" => $hasil_rapat->getField("HASIL_RAPAT_ID")));
						$hasil_rapat_attachment->firstRow();
						?>
                        <div class="rapat-download-icon"><a href="pdfviewer.php?reqMode=hasil_rapat&reqId=<?=$hasil_rapat_attachment->getField("HASIL_RAPAT_ATTACHMENT_ID")?>" title="download hasil rapat" target="_blank"><img src="../WEB-INF/images/ArrowDownRed.gif" /></a></div>
                    </div>
                <?
					unset($hasil_rapat_attachment);
				}
				?>    
                </div>                
            </div>
            <div class="md-modal md-effect-19" id="modal-rapat">
                <div class="md-content" style="width:100%; height:600px; background:#e6c222;">
                    <h3>Hasil Rapat</h3>
                    <div>
                        <iframe src="rapat.php"></iframe>
                        <div class="tombol-close"><img class="md-close" src="../WEB-INF/images/icon-close.png"></div>
                    </div>
                </div>
            </div>
            
            <!-- FAQ -->
            <div id="main-faq">
            	<div class="main-informasi-judul">FAQ <span><a href="#" class="md-trigger md-setperspective" data-modal="modal-faq" title="lihat semua faq"><i class="fa fa-arrow-circle-right"></i></a></span></div>
				<?
                while($faq->nextRow())
				{
				?>
                <div class="faq-list">
                	<div class="faq-tanya"><span>T :</span> <?=$faq->getField("PERTANYAAN")?></div>
                	<div class="faq-jawab"><span>J :</span> <?=$faq->getField("JAWABAN")?></div>
                </div>
                <?
				}
				?>
            </div>
            <div class="md-modal md-effect-19" id="modal-faq">
                <div class="md-content" style="width:100%; height:600px; background:#5e5e60;">
                    <h3>FAQ</h3>
                    <div>
                        <iframe src="faq.php"></iframe>
                        <div class="tombol-close"><img class="md-close" src="../WEB-INF/images/icon-close.png"></div>
                    </div>
                </div>
            </div>
            
            <div class="md-overlay"></div><!-- the overlay element -->
        </div>
        <div id="main-aplikasi">
        	<div id="judul-main-menu">
                <span><i class="fa fa-th-large"></i> Main Menu</span>
            </div> 

            <div id="content" style="visibility: hidden; clear: both ;">
                <div id="browser_incompatible" class="alert">
                    <button class="close" data-dismiss="alert">Ã—</button>
                    <strong>Warning!</strong>
                    Your browser is incompatible with Droptiles. Please use Internet Explorer 9+, Chrome, Firefox or Safari.
                </div>
                <div id="CombinedScriptAlert" class="alert">
                    <button class="close" data-dismiss="alert">Ã—</button>
                    <strong>Warning!</strong>
                    Combined javascript files are outdated. Please retun the js\Combine.bat file. Otherwise it won't work when you will deploy on a server.    
                </div>
                
                <div id="metro-sections-container" class="metro" style="height:calc(100% - 114px);">
                    <?php /*?><!--<div id="trash" class="trashcan" data-bind="sortable: { data: trash }"></div>--><?php */?>
                    <div class="metro-sections" data-bind="foreach: sections" style="height:calc(100% - 100px);" >
                
                        <div class="metro-section" data-bind="sortable: { data: tiles }">
                            <div data-bind="attr: { id: uniqueId, 'class': tileClasses }">
                                <!-- ko if: tileImage -->
                                <div class="tile-image">
                                    <img data-bind="attr: { src: tileImage }" src="droptiles/img/Internet Explorer.png" />
                                </div>
                                <!-- /ko -->
                
                                <!-- ko if: iconSrc -->
                                <!-- ko if: slides().length == 0 -->
                                <div data-bind="attr: { 'class': iconClasses }">
                                    <img data-bind="attr: { src: iconSrc }" src="droptiles/img/Internet Explorer.png" />
                                </div>
                                <!-- /ko -->
                                <!-- /ko -->
                
                                <div data-bind="foreach: slides">
                                    <div class="tile-content-main">
                                        <div data-bind="html: $data">
                                        </div>
                                    </div>
                                </div>
                
                                <!-- ko if: label -->
                                <span class="tile-label" data-bind="html: label">Label</span>
                                <!-- /ko -->
                
                                <!-- ko if: counter -->
                                <span class="tile-counter" data-bind="html: counter">10</span>
                                <!-- /ko -->
                
                                <!-- ko if: subContent -->
                                <div data-bind="attr: { 'class': subContentClasses }, html: subContent">
                                    subContent
                                </div>
                                <!-- /ko -->
                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END METRO CONTENT -->
            
        </div>
        
        
        
        
    <!--Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum-->
    </div>
    <div id="footer">Copyright &copy; 2018 Yayasan Barunawati Biru Surabaya. All Rights Reserved.</div>
</div>

<!-- MODAL WINDOW EFFECT -->
<!-- classie.js by @desandro: https://github.com/desandro/classie -->
<script src="../WEB-INF/lib/ModalWindowEffects/js/classie.js"></script>
<script src="../WEB-INF/lib/ModalWindowEffects/js/modalEffects.js"></script>
        


<script src="../WEB-INF/lib/TooltipMenu/js/cbpTooltipMenu.min.js"></script>
<script>
	var menu = new cbpTooltipMenu( document.getElementById( 'cbp-tm-menu' ) );
</script>

<!-- NEWS TICKER -->

<script>

	function tick2(){
		$('#ticker_02 li:first').slideUp( function () { $(this).appendTo($('#ticker_02')).slideDown(); });
	}
	setInterval(function(){ tick2 () }, 3000);


</script>

<!-- DROPTILES -->
<script type="text/javascript">
    window.currentUser = new User({
        firstName: "None",
        lastName: "Anonymous",
        photo: "img/User No-Frame.png",
        isAnonymous: true
    });
</script>

<script type="text/javascript" src="droptiles/js/CombinedDashboard.js?v=14"></script>

</body>
</html>