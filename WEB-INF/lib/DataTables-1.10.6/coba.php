<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/StatusPegawai.php");

$jenis_pegawai = new JenisPegawai();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
$tinggi = 170;

$reqDepartemen = httpFilterGet("reqDepartemen");

$reqJenisPegawai= httpFilterGet("reqJenisPegawai");
$reqPeriodeAwal= httpFilterGet("reqPeriodeAwal");
$reqPeriodeAkhir= httpFilterGet("reqPeriodeAkhir");

if($reqDepartemen == "")
	$reqDepartemen = "CAB1";

$jenis_pegawai->selectByParams();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>Diklat</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">

<style type="text/css" media="screen">
    @import "../WEB-INF/lib/media/css/site_jui.css";
    @import "../WEB-INF/lib/media/css/demo_table_jui.css";
    @import "../WEB-INF/lib/media/css/themes/base/jquery-ui.css";
    /*
     * Override styles needed due to the mix of three different CSS sources! For proper examples
     * please see the themes example in the 'Examples' section of this site
     */
    .dataTables_info { padding-top: 0; margin-top:-5px }
    .dataTables_paginate { padding-top: 0; margin-top:-5px; }
    .css_right { float: right; }
    #example_wrapper .fg-toolbar { font-size: 0.7em }
    #theme_links span { float: left; padding: 2px 10px; }
</style>
	<link rel="stylesheet" type="text/css" href="media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="examples/resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="examples/resources/demo.css">
	<style type="text/css" class="init">

	</style>
	<script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="examples/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="examples/resources/demo.js"></script>	
	<script type="text/javascript" language="javascript" src="extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>	
	<script type="text/javascript" language="javascript" class="init">
	    $(document).ready( function () {
										
        var id = -1;//simulation of id
		$(window).resize(function() {
		  $('.dataTables_scrollBody').css('height', ($(window).height() - <?=$tinggi?>));
		});
		var oldStart = 0;
		
        var oTable = $('#example').dataTable({ bJQueryUI: true,"iDisplayLength": 50,
			  /* UNTUK MENGHIDE KOLOM ID */
			  "aoColumns": [ 
							 { bVisible:false },
							 null,
							 null,
							 null,
							 null,
							 null,
							 null,
							 null,
							 null,
							 null												 								 
						],
			  "bSort":true,
			  "processing": true,
			  "serverSide": true,		
			  "sAjaxSource": "../json-simpeg/siswa_magang_json.php?reqDepartemen=<?=$reqDepartemen?>&reqPeriodeAwal=<?=$reqPeriodeAwal?>&reqPeriodeAkhir=<?=$reqPeriodeAkhir?>",
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "130%"
			  });
			  new $.fn.dataTable.FixedColumns( oTable, {
				leftColumns: 3
			} );
			
			$('#example tbody').on( 'click', 'tr', function () {
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
					}
					else {
						oTable.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
					}
			});				
		});
</script>

<!--RIGHT CLICK EVENT-->		
<style>

	.vmenu{
	border:1px solid #aaa;
	position:absolute;
	background:#fff;
	display:none;font-size:0.75em;}
	.first_li{}
	.first_li span{width:100px;display:block;padding:5px 10px;cursor:pointer}
	.inner_li{display:none;margin-left:120px;position:absolute;border:1px solid #aaa;border-left:1px solid #ccc;margin-top:-28px;background:#fff;}
	.sep_li{border-top: 1px ridge #aaa;margin:5px 0}
	.fill_title{font-size:11px;font-weight:bold;/height:15px;/overflow:hidden;word-wrap:break-word;}
	
	label {
	font-size: 12px;
  }
	  
</style>
<!--RIGHT CLICK EVENT-->		

<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 

<!-- CSS for Drop Down Tabs Menu #2 -->
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  
<link rel="stylesheet" type="text/css" href="../WEB-INF/css/bluetabs.css" />
<script type="text/javascript" src="../WEB-INF/css/dropdowntabs.js"></script>
<script language="JavaScript" src="../jslib/displayElement.js"></script>  

<!-- Flex Menu -->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/flexdropdown.css" />
<script type="text/javascript" src="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/jquery.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/flexdropdown.js"></script> 

</head>
<body style="overflow:hidden" >
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Data Siswa Magang</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" id="btnAdd" onClick="window.parent.OpenDHTML('pegawai_kadet_add.php', 'Office Management - Aplikasi Kepegawaian', '880', '495');" title="Tambah">Tambah</a>
            <a href="#" id="btnEdit" title="Edit">Ubah</a> 
            <a href="#" id="btnEkspor" title="Edit">Export Excel</a> 
            </li>
          <?php /*?>  <li>
            <a href="#" title="Proses" id="btnProses" data-flexmenu="flexmenu1">&nbsp;Proses</a>
            </li>
            <li>
            <a href="#" title="Ekspor" id="btnEkspor">&nbsp;Export Excel</a>
			<a href="#" title="Ekspor" id="btnCV">&nbsp;Curriculum Vitae</a>
            </li><?php */?>
        </ul>
        <ul id="flexmenu1" class="flexdropdownmenu">
          <li><a href="#" id="btnPerubahanJenisPegawai">Perubahan Jenis Pegawai</a></li>
          <li><a href="#" id="btnMutasiKeluar">Mutasi Keluar</a></li>
          <li><a href="#" id="btnMutasiMasuk">Mutasi Masuk</a></li>
          <li><a href="#" id="btnMutasi">Mutasi Internal</a></li>
          <li><a href="#" id="btnKenaikanJabatan">Promosi (Usulan)</a></li>
          <li><a href="#" id="btnMpp">MPP</a></li>
          <li><a href="#" id="btnPensiun">Pensiun</a></li>
          <li><a href="#" id="btnPerpanjanganKontrak">Perpanjangan Kontrak PKWT</a></li>          
        </ul> 
        
        <ul id="flexmenu2" class="flexdropdownmenu">
          <li><a href="#" onClick="window.parent.OpenDHTML('pegawai_add.php', 'Office Management - Aplikasi Kepegawaian', '880', '495');" id="btnPegawai">Pegawai</a></li>
          <li><a href="#" onClick="window.parent.OpenDHTML('pegawai_kadet_add.php', 'Office Management - Aplikasi Kepegawaian', '880', '495');" id="btnPegawaiKadet">Siswa Magang</a></li>
        </ul>
      
    </div>
    <?
	//}
	?>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:6px; margin-left:178px; z-index:9999; font-size:12px;">
        Departemen : <input id="cc" class="easyui-combotree" name="reqDepartemen" data-options="url:'../json-simpeg/departemen_combo_json.php'" style="width:200px;">&nbsp;&nbsp;
        Periode : <input id="reqTanggalAwal" type="text" name="reqTanggalAwal" value="<?php echo date('m/01/Y'); ?>"  /> - <input id="reqTanggalAkhir" name="reqTanggalAkhir" value="<?php echo date('m/t/Y'); ?>"  />
    </div>
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Id</th>
            <th width="85px">NIS</th>
            <th width="200px">Nama</th>       
            <th width="90px">Agama</th>
            <th width="100px">Jenis Kelamin</th>
            <th width="100px">Tempat Lahir</th> 
            <th width="100px">Tanggal Lahir</th> 
            <th width="250px">Alamat</th>
            <th width="100px">Jenis Magang</th>            
            <th width="200px">Unit Kerja</th>
            
        </tr>
    </thead>
    </table>
    </div>    
        <!--RIGHT CLICK EVENT -->
        <div class="vmenu">
            <div class="first_li"><span>Ubah</span></div>
            <div class="first_li"><span>Mutasi</span></div>
            <div class="first_li"><span>MPP</span></div>
            <div class="first_li"><span>Hapus</span></div>
            <!--<div class="first_li"><span>Status</span>
                <div class="inner_li">
                    <span>Aktif</span> 
                    <span>Non-Aktif</span>
                </div>
            </div>-->
        </div>
        <!--RIGHT CLICK EVENT -->
    
</div>
</body>
</html>