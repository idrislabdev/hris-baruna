<?
include_once("../WEB-INF/setup/defines.php");
include_once("../WEB-INF/page_config.php");

include_once("../WEB-INF/classes/utils/UserLogin.php");


if ($userLogin->checkUserLogin()) { 
	$userLogin->retrieveUserInfo();
	if ($userLogin->aksesPengaturan == 'NO') { 
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
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

ddsmoothmenu.init({
	mainmenuid: "smoothmenu2", //Menu DIV id
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
	
</script>


</head>

<body style="height:100%; min-height:100%;">

<div id="kontainer" style="height:100%; min-height:100%;">
	<div id="header">
    	<?
		$_GET["reqModul"] = "Administrasi Aplikasi";
        include_once "../global_page/header.php";
		?>
	</div>
    <div id="sisi-kiri" style="overflow-y:auto;">
		<?
		$menu_array = array(
			array(
			  "accordion_button" => "Main Menu",
			  "accordion_content" => 
				array(
					array(
						"nama" => "Agenda",
						"link" => "agenda.php"
					),
					array(
						"nama" => "Forum Kategori",
						"link" => "forum_kategori.php"
					),
					array(
						"nama" => "Hasil Rapat",
						"link" => "hasil_rapat.php"
                    ),
                    array(
						"nama" => "Informasi",
						"link" => "informasi.php"
					),
                    array(
						"nama" => "Kalender Kerja",
						"link" => "kalender_kerja.php"
					),
					array(
						"nama" => "Kata Mutiara",
						"link" => "kata_mutiara.php"
					),
					array(
						"nama" => "FaQ",
						"link" => "faq.php"
					)
				)
			),
			array(
				"accordion_button" => "Setting",
				"accordion_content" => 
				  	array(
						array(
							"nama" => "Cabang",
							"link" => "cabang.php"
						),
						array(
							"nama" => "Departemen",
							"link" => "departemen.php"
						),
						array(
							"nama" => "User Group",
							"link" => "user_group.php"
						),
						array(
							"nama" => "User Login",
							"link" => "user_login.php"
						),
						array(
							"nama" => "Notifikasi",
							"link" => "notifikasi.php"
						),
						array(
							"nama" => "Penanda Tangan",
							"link" => "penanda_tangan.php"
						),
						array(
							"nama" => "Report Penanda Tangan",
							"link" => "report_penanda_tangan.php"
						),
						array(
							"nama" => "Aplikasi",
							"link" => "setting_aplikasi.php"
						)
					),
			  	),
				array(
					"accordion_button" => "Petunjuk Penggunaan",
					"accordion_content" => 
						  array(
							array(
								"nama" => "Hasil Rapat",
								"link" => "petunjuk_penggunaan?reqMode=hasil_rapat.php"
							)
						),
						
				),
				array(
					"accordion_button" => "Panduan",
					"accordion_content" => 
						  array(
							array(
								"nama" => "Panduan Penggunaan",
								"link" => "panduan_penggunaan?file=INTRANET.pdf"
							)
						),
						
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
