<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/default.func.php");


$reqId = httpFilterGet("reqId");
$reqTipe = httpFilterGet("reqTipe");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml"><head>
<title>Detail Arsip</title>
<script src="../WEB-INF/js/jquery-1.6.1.min.js" type="text/javascript"></script>
<link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css" /> 

<script type="text/javascript" charset="utf-8">
    $(document).ready( function () {
        var id = -1;//simulation of id
		$(window).resize(function() {
		  console.log($(window).height());
		  $('.display').css('height', ($(window).height() - 130));
		});
        
	} );
</script>

<script src="../WEB-INF/js/popup.js" type="text/javascript"></script> 
<link href="../WEB-INF/lib/tabs/tabs.css" rel="stylesheet" type="text/css" />
 <style type="text/css" media="screen">
      label {
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 3px;
        clear: both;
      }
    </style>
<!-- BEGIN Plugin Code -->
  <!-- END Plugin Code -->
  
  <!-- Popup -->  
<style type="text/css">
/* Remove margins from the 'html' and 'body' tags, and ensure the page takes up full screen height */
html, body {height:100%; margin:0; padding:0;}
/* Set the position and dimensions of the background image. */
#page-background {position:fixed; top:0; left:0; width:100%; height:100%;}
/* Specify the position and layering for the content that needs to appear in front of the background image. Must have a higher z-index value than the background image. Also add some padding to compensate for removing the margin from the 'html' and 'body' tags. */
#content {position:relative; z-index:1;}
/* prepares the background image to full capacity of the viewing area */
#bg {position:fixed; top:0; left:0; width:100%; height:100%;}
/* places the content ontop of the background image */
</style>
<script language="Javascript">

function openPopup(opUrl,opWidth,opHeight)
{
	newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars");
	newWindow.focus();
}
</script>

<link rel="stylesheet" href="../WEB-INF/css/admin.css" type="text/css" />
  
</head>

<body>

<?
	$link = 'statistik.php';
	switch($reqTipe){
		case 3:
			$link_frame_statistik = 'pendidikan_statistik';
			$link_frame_grafik_statistik = 'pendidikan_grafik_statistik';
			$tmp_css3 = 'current';
			$link2 = $link.'?reqTipe=2'; $link1 = $link.'?reqTipe=1'; $link4 = $link.'?reqTipe=4'; $link5 = $link.'?reqTipe=5';
			$link6 = $link.'?reqTipe=6'; $link7 = $link.'?reqTipe=7'; $link8 = $link.'?reqTipe=8';
			$link9 = $link.'?reqTipe=9'; $link10 = $link.'?reqTipe=10'; $link11 = $link.'?reqTipe=11';
		break;
		case 4:
			$link_frame_statistik = 'jenis_kelamin_statistik';
			$link_frame_grafik_statistik = 'jenis_kelamin_grafik_statistik';
			$tmp_css4 = 'current';
			$link2 = $link.'?reqTipe=2'; $link3 = $link.'?reqTipe=3'; $link1 = $link.'?reqTipe=1'; $link5 = $link.'?reqTipe=5';
			$link6 = $link.'?reqTipe=6'; $link7 = $link.'?reqTipe=7'; $link8 = $link.'?reqTipe=8';
			$link9 = $link.'?reqTipe=9'; $link10 = $link.'?reqTipe=10'; $link11 = $link.'?reqTipe=11';
		break;
		case 5:
			$link_frame_statistik = 'agama_statistik';
			$link_frame_grafik_statistik = 'agama_grafik_statistik';
			$tmp_css5 = 'current';
			$link2 = $link.'?reqTipe=2'; $link3 = $link.'?reqTipe=3'; $link4 = $link.'?reqTipe=4'; $link1 = $link.'?reqTipe=1';
			$link6 = $link.'?reqTipe=6'; $link7 = $link.'?reqTipe=7'; $link8 = $link.'?reqTipe=8';
			$link9 = $link.'?reqTipe=9'; $link10 = $link.'?reqTipe=10'; $link11 = $link.'?reqTipe=11';
		break;
		case 7:
			$link_frame_statistik = 'gol_umur_statistik';
			$link_frame_grafik_statistik = 'gol_umur_grafik_statistik';
			$tmp_css7 = 'current';
			$link2 = $link.'?reqTipe=2'; $link3 = $link.'?reqTipe=3'; $link4 = $link.'?reqTipe=4'; $link5 = $link.'?reqTipe=5';
			$link6 = $link.'?reqTipe=6'; $link1 = $link.'?reqTipe=1'; $link8 = $link.'?reqTipe=8';
			$link9 = $link.'?reqTipe=9'; $link10 = $link.'?reqTipe=10'; $link11 = $link.'?reqTipe=11';
		break;
		case 8:
			$link_frame_statistik = 'jenis_pegawai_statistik';
			$link_frame_grafik_statistik = 'jenis_pegawai_grafik_statistik';
			$tmp_css8 = 'current';
			$link2 = $link.'?reqTipe=2'; $link3 = $link.'?reqTipe=3'; $link4 = $link.'?reqTipe=4'; $link5 = $link.'?reqTipe=5';
			$link6 = $link.'?reqTipe=6'; $link7 = $link.'?reqTipe=7'; $link1 = $link.'?reqTipe=1';
			$link9 = $link.'?reqTipe=9'; $link10 = $link.'?reqTipe=10'; $link11 = $link.'?reqTipe=11';
		break;
		case 9:
			$link_frame_statistik = 'unit_kerja_statistik';
			$link_frame_grafik_statistik = 'unit_kerja_grafik_statistik';
			$tmp_css9 = 'current';
			$link2 = $link.'?reqTipe=2'; $link3 = $link.'?reqTipe=3'; $link4 = $link.'?reqTipe=4'; $link5 = $link.'?reqTipe=5';
			$link6 = $link.'?reqTipe=6'; $link7 = $link.'?reqTipe=7'; $link1 = $link.'?reqTipe=1';
			$link8 = $link.'?reqTipe=8'; $link10 = $link.'?reqTipe=10'; $link11 = $link.'?reqTipe=11';
		break;
		case 10:
			$link_frame_statistik = 'jenis_pekerjaan_statistik';
			$link_frame_grafik_statistik = 'jenis_pekerjaan_grafik_statistik';
			$tmp_css10 = 'current';
			$link2 = $link.'?reqTipe=2'; $link3 = $link.'?reqTipe=3'; $link4 = $link.'?reqTipe=4'; $link5 = $link.'?reqTipe=5';
			$link6 = $link.'?reqTipe=6'; $link7 = $link.'?reqTipe=7'; $link1 = $link.'?reqTipe=1';
			$link9 = $link.'?reqTipe=9'; $link8 = $link.'?reqTipe=8'; $link11 = $link.'?reqTipe=11';
		break;
		case 11:
			$link_frame_statistik = 'unit_kerja_jenis_pekerjaan_statistik';
			$link_frame_grafik_statistik = 'unit_kerja_jenis_pekerjaan_grafik_statistik';
			$tmp_css11 = 'current';
			$link2 = $link.'?reqTipe=2'; $link3 = $link.'?reqTipe=3'; $link4 = $link.'?reqTipe=4'; $link5 = $link.'?reqTipe=5';
			$link6 = $link.'?reqTipe=6'; $link7 = $link.'?reqTipe=7'; $link1 = $link.'?reqTipe=1';
			$link9 = $link.'?reqTipe=9'; $link10 = $link.'?reqTipe=10'; $link8 = $link.'?reqTipe=8';
		break;
		default:
			$link_frame_statistik = 'pendidikan_statistik';
			$link_frame_grafik_statistik = 'pendidikan_grafik_statistik';
			$tmp_css3 = 'current';
			$link2 = $link.'?reqTipe=2'; $link1 = $link.'?reqTipe=1'; $link4 = $link.'?reqTipe=4'; $link5 = $link.'?reqTipe=5';
			$link6 = $link.'?reqTipe=6'; $link7 = $link.'?reqTipe=7'; $link8 = $link.'?reqTipe=8';
			$link9 = $link.'?reqTipe=9'; $link10 = $link.'?reqTipe=10'; $link11 = $link.'?reqTipe=11';
	}
?>

    <div id="bg">
        <img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile">
    </div>
    <div id="content">
        <div style="margin-left:20px; padding-top:18px;">
            <ol id="toc"> 
                <li class="<?=$tmp_css3?>"><a href="<?=$link3?>"><span>Pendidikan</span></a></li>
                <li class="<?=$tmp_css4?>"><a href="<?=$link4?>"><span>Jenis Kelamin</span></a></li>
                <li class="<?=$tmp_css5?>"><a href="<?=$link5?>"><span>Agama</span></a></li>
                <li class="<?=$tmp_css7?>"><a href="<?=$link7?>"><span>Golongan Umur</span></a></li>
                <li class="<?=$tmp_css8?>"><a href="<?=$link8?>"><span>Jenis Pegawai</span></a></li>
                <li class="<?=$tmp_css9?>"><a href="<?=$link9?>"><span>Unit Kerja</span></a></li>
            </ol>
        </div>
        <div class="content">    
        <table cellpadding="0" cellspacing="1" border="0" class="display" width="100%">
        <tr>
            <td width="100%">
                <iframe src="<?=$link_frame_grafik_statistik?>.php" name="menuFrameGrafikStatistik" width="100%" height="550px;" frameborder="0" scrolling="no"></iframe>
            </td>
        </tr>
        </table>
        </div>
    </div>

</body>
</html>