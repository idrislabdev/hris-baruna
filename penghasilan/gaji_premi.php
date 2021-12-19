<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriodeTengahBulan.php");
include_once("../WEB-INF/classes/base-gaji/ProsesGajiLock.php");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
$tinggi = 155;

$gaji_periode_tengah_bulan = new GajiPeriodeTengahBulan();
$proses_gaji_lock = new ProsesGajiLock();


$gaji_periode_tengah_bulan->selectByParams(array(),-1,-1,"","ORDER BY GAJI_PERIODE_TENGAH_BULAN_ID DESC");
while($gaji_periode_tengah_bulan->nextRow())
{
	$arrPeriode[] = $gaji_periode_tengah_bulan->getField("PERIODE");	
}


if($reqPeriode == "")
	$reqPeriode = $arrPeriode[0];
	
	
$lock_proses = $proses_gaji_lock->getProsesGajiLock(array("PERIODE" => $reqPeriode, "JENIS_PROSES" => "GAJI_PREMI"));
	
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
    @import "../WEB-INF/lib/media/css/dataTables.tableTools.css";
    /*
     * Override styles needed due to the mix of three different CSS sources! For proper examples
     * please see the themes example in the 'Examples' section of this site
     */
    .dataTables_info { padding-top: 0; }
    .dataTables_paginate { padding-top: 0; }
    .css_right { float: right; }
    #example_wrapper .fg-toolbar { font-size: 0.7em }
    #theme_links span { float: left; padding: 2px 10px; }
</style>

	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/examples/resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/examples/resources/demo.css">
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/demo.js"></script>	
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>	
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.min.js"></script>	
	<script type="text/javascript" language="javascript" class="init">
    $(document).ready( function () {

		<?
		if($lock_proses == 1)
		{
		?>
		$('.toggle').css({"display":"none"});
		<?
		}
		?>
												
        var id = -1;//simulation of id
		$(window).resize(function() {
		  console.log($(window).height());
		  $('.dataTables_scrollBody').css('height', ($(window).height() - <?=$tinggi?>));
		});
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
							 null
						],
			  "bSort":true,
			  "bProcessing": true,
			  "bServerSide": true,		
			  "sAjaxSource": "../json-gaji/gaji_premi_json.php?reqPeriode=<?=$reqPeriode?>",
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "100%",
			  "sPaginationType": "full_numbers",
			  "sDom": '<"H"lTfr>t<"F"ip>',
			  "oTableTools": {
					"sSwfPath": "../WEB-INF/lib/media/swf/copy_csv_xls_pdf.swf",
					"aButtons": [
						{
			                "sExtends": "copy"
			            },
			            {
			                "sExtends": "xls"
			            },
			            {
			                "sExtends": "pdf"
			            },
					]
				}
			  });
			/* Click event handler */
			  
			  $('#example tbody tr').on('dblclick', function () {
				  $("#btnEdit").click();	
			  });														
		  
			  /* RIGHT CLICK EVENT */
			  var anSelectedData = '';
			  var anSelectedId = '';
			  var anSelectedPosition = '';	
			  var anSelectedKapal = '';			  
			  
			  function fnGetSelected( oTableLocal )
			  {
				  var aReturn = new Array();
				  var aTrs = oTableLocal.fnGetNodes();
				  for ( var i=0 ; i<aTrs.length ; i++ )
				  {
					  if ( $(aTrs[i]).hasClass('selected') )
					  {
						  aReturn.push( aTrs[i] );
						  anSelectedPosition = i;
					  }
				  }
				  return aReturn;
			  }
		  
			  $('#example tbody').on( 'click', 'tr', function () {
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
					}
					else {
						oTable.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
					}
					  //
					  var anSelected = fnGetSelected(oTable);													
					  anSelectedData = String(oTable.fnGetData(anSelected[0]));
					  var element = anSelectedData.split(','); 
					  anSelectedId = element[0];
					  anSelectedKapal = element[0];
			  });
			  
			  $('#btnLihat').on('click', function () {
				  if(anSelectedData == "")
					  return false;				
				  window.parent.OpenDHTML('gaji_premi_lihat.php?reqId='+anSelectedId+'&reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Penghasilan', '980', '530');	
			  });
			  
			  $('#btnEkspor').on('click', function () {
				  //if(anSelectedData == "")
					  //return false;				
				  
				  newWindow = window.open('gaji_premi_cetak.php?reqPeriode='+ $("#reqPeriode").val()+'&reqId='+anSelectedId, 'Cetak');
				  newWindow.focus();
				  
			  });
			  
			  $('#btnEksporRekap').on('click', function () {
				  //if(anSelectedData == "")
					  //return false;				
				  
				  newWindow = window.open('gaji_premi_rekap_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				  newWindow.focus();
				  
			  });
			  
			  $('#btnEksporRekapTahun').on('click', function () {
				  //if(anSelectedData == "")
					  //return false;				
				  
				  newWindow = window.open('gaji_premi_rekap_excel.php?reqPeriode='+ $("#reqPeriode").val().substr(2,4), 'Cetak');
				  newWindow.focus();
				  
			  });
			  

			  $('#btnEksporRekapAwakKapal').on('click', function () {
				  //if(anSelectedData == "")
					  //return false;				
				  
				  newWindow = window.open('premi_awak_kapal_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				  newWindow.focus();
				  
			  });
			  
			  $('#btnEksporMandiriCSV').on('click', function () {
				  newWindow = window.open('gaji_premi_awak_kapal_mandiri_csv.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				  newWindow.focus();
				  
			  });
			  
			  $('#btnEksporBNICSV').on('click', function () {
				  newWindow = window.open('gaji_premi_awak_kapal_bni_csv.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				  newWindow.focus();
				  
			  });
			  
			  $('#btnEksporBRICSV').on('click', function () {
				  newWindow = window.open('gaji_premi_awak_kapal_bri_csv.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				  newWindow.focus();
				  
			  });
			    
			  $('#btnCetak').on('click', function () {
			  	//newWindow = window.open('gaji_premi_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				//newWindow.focus();
				window.parent.OpenDHTML('report_penanda_tangan.php?reqJenisReport=GAJI_PREMI&reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Penghasilan', '600', '300');
			  });

			  $('#btnRekap').on('click', function () {
			  	//newWindow = window.open('gaji_premi_rekap_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				//newWindow.focus();
				window.parent.OpenDHTML('report_penanda_tangan.php?reqJenisReport=REKAPITULASI_PREMI_KAPAL&reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Penghasilan', '600', '300');
			  });			  			  

			  $("#reqPeriode").change(function() { 
				 if($("#reqPeriode").val() == '<?=$arrPeriode[0]?>' && '<?=$lock_proses?>' == '0')
				 	 $('.toggle').css({"display":"inline"});
				 else
				 	 $('.toggle').css({"display":"none"}); 
			  		oTable.fnReloadAjax("../json-gaji/gaji_premi_json.php?reqPeriode="+ $("#reqPeriode").val());
				 	 
			  });

			  $('#btnKirimJurnal').on('click', function () {
				  /*
			  	  if(confirm('Kirim jurnal dan kunci proses bulan terpilih?'))
				  {
					$.getJSON("../json-gaji/proses_gaji_set_lock.php?reqJenisProses=GAJI_PREMI&reqPeriode="+ $("#reqPeriode").val(),
					function(data){
					});	

				    alert('Proses di bulan terpilih telah di kunci.');
				    $('.toggle').css({"display":"none"});

				  }
				  */
				window.parent.OpenDHTML('proses_gaji_set_lock.php?reqJenisProses=GAJI_PREMI&reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Penghasilan', '600', '300');
					  
			  });	
			  			  
			  $('#rightclickarea').bind('contextmenu',function(e){
				  if(anSelectedData == '')	
					  return false;							
			  var $cmenu = $(this).next();
			  $('<div class="overlay"></div>').css({left : '0px', top : '0px',position: 'absolute', width: '100%', height: '100%', zIndex: '0' }).click(function() {				
				  $(this).remove();
				  $cmenu.hide();
			  }).bind('contextmenu' , function(){return false;}).appendTo(document.body);
			  $(this).next().css({ left: e.pageX, top: e.pageY, zIndex: '1' }).show();
		  
			  return false;
			   });
		  
			   $('.vmenu .first_li').on('click',function() {
				  if( $(this).children().size() == 1 ) {
					  if($(this).children().text() == 'Ubah')
					  {
						  $("#btnEdit").click();
					  }
					  else if($(this).children().text() == 'Hapus')
					  {
						  $("#btnDeleteRow").click();
					  }
					  $('.vmenu').hide();
					  $('.overlay').hide();
				  }
			   });
			   
			   $('.vmenu .inner_li span').on('click',function() {												
					  if($(this).text() == 'Aktif')
					  {
						  $.getJSON('../json-intranet/kapal_set_status.php?reqId='+anSelectedId+'&reqNilai=1', function (data) 
						  {
							  $.each(data, function (i, SingleElement) {
							  });
						  });									
						  oTable.fnUpdate('Aktif', anSelectedPosition, 5, false);
					  }
					  $('.vmenu').hide();
					  $('.overlay').hide();
			  });			   
		  
			  $(".first_li , .sec_li, .inner_li span").hover(function () {
				  $(this).css({backgroundColor : '#E0EDFE' , cursor : 'pointer'});
			  if ( $(this).children().size() >0 )
					  $(this).find('.inner_li').show();	
					  $(this).css({cursor : 'default'});
			  }, 
			  function () {
				  $(this).css('background-color' , '#fff' );
				  $(this).find('.inner_li').hide();
			  });
			  /* RIGHT CLICK EVENT */
		} );
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
<body style="overflow:hidden" onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Premi</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li><a href="#" title="Baca" id="btnBacaRow"  class="toggle">&nbsp;Kalkulasi</a></li>        
            <li><a href="#" title="Lihat" id="btnLihat">&nbsp;Lihat</a></li>
            <li><a href="#" data-flexmenu="flexmenu1">Cetak</a></li>
            <li><a href="#" title="Ekspor" id="btnEkspor1" data-flexmenu="flexmenu2">&nbsp;Export Excel</a></li>
			<li><a href="#" title="Ekspor" id="btnEkspor1" data-flexmenu="flexmenu3">&nbsp;Export CSV</a></li>
            <li><a href="#" title="Baca" id="btnKirimJurnal"  class="toggle">&nbsp;Kirim Jurnal</a></li>   
        </ul>
        <ul id="flexmenu1" class="flexdropdownmenu">
			<li><a href="#" id="btnCetak">Daftar Premi</a></li>
            <li><a href="#" id="btnRekap">Rekapitulasi</a></li>
        </ul>           
        <ul id="flexmenu2" class="flexdropdownmenu">
			<li><a href="#" id="btnEkspor">Daftar Premi</a></li>
            <li><a href="#" id="btnEksporRekap">Rekapitulasi</a></li>
            <li><a href="#" id="btnEksporRekapTahun">Rekapitulasi Tahunan</a></li>
            <li><a href="#" id="btnEksporRekapAwakKapal">Rekap Awak Kapal</a></li>
        </ul>
		<ul id="flexmenu3" class="flexdropdownmenu">
			<li><a href="#" id="btnEksporMandiriCSV">Bank Mandiri</a></li>
            <li><a href="#" id="btnEksporBNICSV">Bank BNI</a></li>
            <li><a href="#" id="btnEksporBRICSV">Bank BRI</a></li>
        </ul>  		
    </div>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:6px; margin-left:180px; z-index:9999; font-size:12px;">
 		Periode : <select name="reqPeriode" id="reqPeriode">
        		  <?
                  for($i=0;$i<count($arrPeriode);$i++)
				  {
				  ?>
                  	<option value="<?=$arrPeriode[$i]?>" <? if($reqPeriode == $arrPeriode[$i]) { ?> selected <? } ?>><?=getNamePeriode($arrPeriode[$i])?></option>
                  <?	  
				  }
				  ?>
        		  </select>
    </div>
    </div>    
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th width="85px">KAPAL_ID</th>
            <th width="85px">Nama</th>
            <th width="85px">Jenis Kapal</th>
            <th width="85px">Kode</th>
            <th width="85px">Call Sign</th>
            <th width="85px">IMO Number</th>
            <th width="85px">Lokasi</th>
            <th width="85px">Jml. Kru</th>
        </tr>
    </thead>
    </table>
    </div>    
        <!--RIGHT CLICK EVENT -->
        <div class="vmenu">
            <div class="first_li"><span>Ubah</span></div>
            <div class="first_li"><span>Hapus</span></div>
        </div>
        <!--RIGHT CLICK EVENT -->
    
</div>
</body>
</html>