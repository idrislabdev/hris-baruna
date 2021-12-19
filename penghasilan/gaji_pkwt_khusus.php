<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/Gaji.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriodeCapegPKWT.php");
include_once("../WEB-INF/classes/base-gaji/ProsesGajiLock.php");
include_once("../WEB-INF/classes/base/AksesAppPenghasilan.php");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
$gaji = new Gaji();
$gaji_periode = new GajiPeriodeCapegPKWT();
$proses_gaji_lock = new ProsesGajiLock();
$akses_app_penghasilan = new AksesAppPenghasilan();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqDepartemen = httpFilterGet("reqDepartemen");

$gaji_periode->selectByParams(array(),-1,-1,"","ORDER BY GAJI_PERIODE_CAPEG_PKWT_ID DESC");
while($gaji_periode->nextRow())
{
	$arrPeriode[] = $gaji_periode->getField("PERIODE");	
}

if($reqDepartemen == "")
	$reqDepartemen = "CAB1";

if($reqPeriode == "")
	$reqPeriode = $arrPeriode[0];

$lock_proses = $proses_gaji_lock->getProsesGajiLock(array("PERIODE" => $reqPeriode, "JENIS_PROSES" => "GAJI_PERBANTUAN_ORGANIK"));
$lock_cetak  = $proses_gaji_lock->getProsesGajiLock(array("PERIODE" => $reqPeriode, "JENIS_PROSES" => "DAFTAR_POTONGAN"));

$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(12, "SEMUA"));
$json_item_sumbangan = json_decode($gaji->getItemSumbanganDiberikan(12));
$json_item_potongan = json_decode($gaji->getItemPotonganDiberikan(12));
$json_item_tanggungan = json_decode($gaji->getItemTanggunganDiberikan(12));

$akses_app_penghasilan->selectByParamsAksesMenu(array("LINK_FILE" => "gaji_pkwt_khusus.php", "AKSES_APP_PENGHASILAN_ID" => $userLogin->userAksesPenghasilan));
$akses_app_penghasilan->firstRow();
$akses = $akses_app_penghasilan->getField("AKSES");

$tinggi = 179;
$Jenis_pegawai_id = 12;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>Diklat</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<?php /*?><link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml"><?php */?>
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
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/media/css/dataTables.fixedColumns.css">
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
							 { bVisible:false },
							 null,
							 null,
							 null,
							 null,
							 null,
							 <?
							 for($i=0;$i<count($json_item_gaji->{'NAMA'});$i++)
						     {	
							 ?>							 								 
							 null,
							 <?
							 }
							 ?>		
							 <?
							 for($i=0;$i<count($json_item_sumbangan->{'NAMA'});$i++)
						     {	
							 ?>							 								 
							 null,
							 <?
							 }
							 ?>
							 <?
							 for($i=0;$i<count($json_item_potongan->{'NAMA'});$i++)
						     {	
							 ?>							 								 
							 null,
							 <?
							 }
							 ?>							 							 
							 <?
							 for($i=0;$i<count($json_item_tanggungan->{'NAMA'});$i++)
						     {	
							 ?>							 								 
							 null,
							 <?
							 }
							 ?>		
							 null,
							 null												 								 
						],
			  "bSort":false,
			  "bProcessing": true,
			  "bServerSide": true,		
			  "sAjaxSource": "../json-gaji/gaji_pkwt_khusus_json.php?reqPeriode=<?=$reqPeriode?>&reqDepartemen=<?=$reqDepartemen?>",						  
			  "scrollY": ($(window).height() - <?=$tinggi?>),
			  "scrollX": "100%",		
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
			  
			  var fc = new $.fn.dataTable.FixedColumns( oTable, {
				leftColumns: 5
			  });
			  
			  $('#example tbody tr').on('dblclick', function () {
				  $("#btnEdit").click();	
			  });														
		  
			  /* RIGHT CLICK EVENT */
			  var anSelectedData = '';
			  var anSelectedId = '';
			  var anSelectedPosition = '';	
			  			  
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
					$("#example tr").removeClass('selected');
					$(".DTFC_Cloned tr").removeClass("selected");
					var row = $(this);
				    var rowIndex = row.index() + 1;
					
					if (row.parent().parent().hasClass("DTFC_Cloned")) {
						$("#example tr:nth-child(" + rowIndex + ")").addClass("selected");;
					} else {
						$(".DTFC_Cloned tr:nth-child(" + rowIndex + ")").addClass("selected");
					}
					
					row.addClass("selected");
					  //
					  var anSelected = fnGetSelected(oTable);													
					  anSelectedData = String(oTable.fnGetData(anSelected[0]));
					  var element = anSelectedData.split(','); 
					  anSelectedId = element[0];
			  });
			  
			  $("#reqPeriode").change(function() { 
				 if($("#reqPeriode").val() == '<?=$arrPeriode[0]?>' && '<?=$lock_proses?>' == '0')
				 	 $('.toggle').css({"display":"inline"});
				 else
				 	 $('.toggle').css({"display":"none"}); 
			  		oTable.fnReloadAjax("../json-gaji/gaji_pkwt_khusus_json.php?reqDepartemen="+$('#cc').combotree('getValue')+"&reqPeriode="+ $("#reqPeriode").val());
				 	 
			  });
			  			  
			  $('#cc').combotree({
					onSelect: function(param){
			  		oTable.fnReloadAjax("../json-gaji/gaji_pkwt_khusus_json.php?reqDepartemen="+param.id+"&reqPeriode="+ $("#reqPeriode").val());
					}
			  });

			  $('#btnLihat').on('click', function () {
				  if(anSelectedData == "")
					  return false;				
				  window.parent.OpenDHTML('gaji_perbantuan_lihat.php?reqId='+anSelectedId+'&reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Penghasilan', '900', '600');	
			  });

			  $('#btnCetakBukuBesar').on('click', function () {
				if(<?=$lock_cetak?> == 1)
				{
					window.parent.OpenDHTML('report_penanda_tangan.php?reqJenisReport=BESAR&reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Penghasilan', '600', '300');					
				}
				else
				{
					if(confirm('Daftar potongan belum di approve, data penghasilan mungkin tidak valid. Lanjutkan Cetak?'))
					{  
						window.parent.OpenDHTML('report_penanda_tangan.php?reqJenisReport=BESAR&reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Penghasilan', '600', '300');					
					}
				}				  
			  	//newWindow = window.open('gaji_perbantuan_buku_besar.php?reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				//newWindow.focus();
			  });

			  $('#btnEkspor').on('click', function () {
			  	newWindow = window.open('gaji_perbantuan_cetak.php?reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			  });
			  
			  $('#btnJamsostekExcel').on('click', function () {
			  	newWindow = window.open('jamsostek_excel.php?reqPeriode='+ $("#reqPeriode").val() + '&reqDepartemen=<?=$reqDepartemen?>', 'Cetak');
				newWindow.focus();
			  });
			  
			  $('#btnBPJSExcel').on('click', function () {
			  	newWindow = window.open('bpjs_excel.php?reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode='+ $("#reqPeriode").val() + '&reqDepartemen=<?=$reqDepartemen?>', 'Cetak');
				newWindow.focus();
			  });
			  
			  $('#btnPotonganExcel').on('click', function () {
			  	newWindow = window.open('potongan_excel.php?reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			  });	
			  
			  $('#btnPotonganLainExcel').on('click', function () {
			  	newWindow = window.open('potongan_lain_excel.php?reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			  });
			  
			  $('#btnTaspenExcel').on('click', function () {
			  	newWindow = window.open('taspen_excel.php?reqPeriode=<?=$reqPeriode?>&reqDepartemen=<?=$reqDepartemen?>', 'Cetak');
				newWindow.focus();
			  });		

			  $('#btnCetakPotonganLain').on('click', function () {
			  	newWindow = window.open('potongan_lain_cetak_rpt.php?reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			  });

			  $('#btnDaftarPengantar').on('click', function () {
			  	newWindow = window.open('daftar_pengantar_cetak_rpt.php?reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			  });

			  $('#btnCetakSemua').on('click', function () {
				if(<?=$lock_cetak?> == 1)
				{
					newWindow = window.open('gaji_perbantuan_slip.php?reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					newWindow.focus();
				}
				else
				{
					if(confirm('Daftar potongan belum di approve, data penghasilan mungkin tidak valid. Lanjutkan Cetak?'))
					{  
					newWindow = window.open('gaji_perbantuan_slip.php?reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					newWindow.focus();
					}
				}				  
			  });
			  
			  $('#btnCetakPerOrang').on('click', function () {
				if(<?=$lock_cetak?> == 1)
				{
					newWindow = window.open('gaji_perbantuan_slip.php?reqId='+anSelectedId+'&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					newWindow.focus();
				}
				else
				{
					if(confirm('Daftar potongan belum di approve, data penghasilan mungkin tidak valid. Lanjutkan Cetak?'))
					{  
						newWindow = window.open('gaji_perbantuan_slip.php?reqId='+anSelectedId+'&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
						newWindow.focus();
					}
				}	
			  });

			  $('#btnDaftarPengantarBankExcel').on('click', function () {
			  	newWindow = window.open('daftar_pengantar_bank_excel.php?reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode=<?=$reqPeriode?>', 'Cetak');
				newWindow.focus();
			  });		
			  			  			  
			  $('#btnCetak').on('click', function () {
				  if(anSelectedData == "")
					{  
					  newWindow = window.open('gaji_pkwt_cetak.php?reqPeriode=<?=$reqPeriode?>&reqDepartemen=<?=$reqDepartemen?>&reqJenisPegawaiId=<?=$Jenis_pegawai_id?>', 'Cetak');
					  newWindow.focus();
					}
			  });			  

			  $('#btnJamsostekExcel').on('click', function () {
			  	newWindow = window.open('jamsostek_excel.php?reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			  });

			  $('#btnJamsostek').on('click', function () {
			  	//newWindow = window.open('daftar_jamsostek_rpt.php?reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				//newWindow.focus();
				window.parent.OpenDHTML('report_penanda_tangan.php?reqJenisReport=DAFTAR_IURAN_JAMSOSTEK&reqJenisPegawaiId=<?=$Jenis_pegawai_id?>&reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Penghasilan', '600', '300');				
			  });			

			  $('#btnKirimJurnal').on('click', function () {
			  	  //window.parent.OpenDHTML('proses_gaji_set_lock.php?reqJenisProses=GAJI_PKWT&reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Penghasilan', '600', '300');							    
				 		
				  if(confirm('Kunci proses bulan terpilih?'))
				  {
					$.getJSON("../json-gaji/proses_gaji_set_lock.php?reqJenisProses=GAJI_PKWT&reqPeriode="+ $("#reqPeriode").val(),
					function(data){
					});	
				  }
				  alert('Proses di bulan terpilih telah di kunci.');
				  $('.toggle').css({"display":"none"}); 
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
					  if($(this).text() == 'Dibayar')
					  {
						  /*alert(anSelectedId+'---'+$("#reqPeriode").val());*/
						  $.getJSON('../json-gaji/gaji_pkwt_set_status.php?reqId='+anSelectedId+'&reqNilai=1&reqPeriode='+ $("#reqPeriode").val(), function (data) 
						  {
							  $.each(data, function (i, SingleElement) {
							  });
						  });									
						  oTable.fnUpdate('Dibayar', anSelectedPosition, 1, false);
					  }
					  /*else if($(this).text() == 'Ditolak')
					  {
						  $.getJSON('../json-website/bursa_kapal_set_status.php?reqId='+anSelectedId+'&reqNilai=2', function (data) 
						  {
							  $.each(data, function (i, SingleElement) {
								  
							  });
						  });									
						  oTable.fnUpdate('Ditolak', anSelectedPosition, 7, false);
					  }*/				  
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Data PKWT Khusus</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
        	<?
            if($akses == "A")
			{
			?>        	
            <?php /*?><li><a href="#" title="Baca" id="btnBacaRow"  class="toggle">&nbsp;Kalkulasi</a></li>      <?php */?>
            <?
			}
			?>   
            <li><a href="#" title="Lihat" id="btnLihat">&nbsp;Lihat</a></li>                    
            <li>
            <a href="#" data-flexmenu="flexmenu1">Cetak</a>
            </li>
            <li>
            <a href="#" data-flexmenu="flexmenu2">Export Excel</a>
            </li>                         
        	<?
            if($akses == "A")
			{
			?>        	
            <?php /*?><li><a href="#" title="Baca" id="btnKirimJurnal"  class="toggle">&nbsp;Kunci Proses</a></li>   <?php */?>     
            <?
			}
			?>   
        </ul>
        <!--HTML for Flex Drop Down Menu 1-->
        <ul id="flexmenu1" class="flexdropdownmenu">
            <li><a href="#">Slip Gaji</a>
                <ul>
                <li><a href="#" id="btnCetakSemua">Semua</a></li>
                <li><a href="#" id="btnCetakPerOrang">Per Orang</a></li>
                </ul>
            </li>
			<li><a href="#" id="btnCetakBukuBesar">Buku Besar</a></li>
            <li><a href="#" id="btnCetakPotonganLain">Potongan Lain</a></li>
            <li><a href="#" id="btnDaftarPengantar">Daftar Pengantar</a></li>
            <li><a href="#" id="btnJamsostek">BPJS Ketenagakerjaan</a>
        </ul>   
        <ul id="flexmenu2" class="flexdropdownmenu">
            <li><a href="#" id="btnEkspor">Monitoring Gaji</a></li>
            <li><a href="#" id="btnDaftarPengantarBankExcel">Daftar Pengantar</a></li>
            <li><a href="#" id="btnPotonganExcel">Potongan</a></li>
			<li><a href="#" id="btnPotonganLainExcel">Potongan Lain</a></li>
            <li><a href="#" id="btnJamsostekExcel">BPJS Ketenagakerjaan</a></li>
            <li><a href="#" id="btnBPJSExcel">BPJS Kesehatan</a></li>
            <li><a href="#" id="btnTaspenExcel">Taspen</a></li>            
        </ul> 
    </div>
    <?
	//}
	?>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:6px; margin-left:180px; z-index:9999; font-size:12px;">
        Departemen : <input id="cc" class="easyui-combotree" name="reqDepartemen" data-options="url:'../json-simpeg/departemen_combo_json.php'" style="width:300px;">&nbsp;&nbsp;&nbsp;&nbsp;
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
            <th rowspan="2" class="th_like" width="250px">ID</th>
            <th rowspan="2" class="th_like" width="250px">Status</th>
            <th rowspan="2" class="th_like" width="10px">No.</th>
            <th rowspan="2" class="th_like" width="80px">NRP</th>
            <th rowspan="2" class="th_like" width="100px">Nama</th>
            <th rowspan="2" class="th_like" width="100px">Jabatan</th>       
            <th rowspan="2" class="th_like" width="10px">Bayar</th>  
            <th colspan="<?=count($json_item_gaji->{'NAMA'})?>" style="text-align:center">Gaji</th>
            <th colspan="<?=count($json_item_sumbangan->{'NAMA'})?>" style="text-align:center">Sumbangan</th>
            <th colspan="<?=count($json_item_potongan->{'NAMA'})?>" style="text-align:center">Potongan</th>
            <th colspan="<?=count($json_item_tanggungan->{'NAMA'})?>" style="text-align:center">Tanggungan</th>
            <th rowspan="2" class="th_like" width="20px">Potongan Lain</th>
            <th rowspan="2" class="th_like" width="20px">Gaji - Potongan</th>
        </tr>
        <tr>
        <?
        for($i=0;$i<count($json_item_gaji->{'NAMA'});$i++)
		{
		?>
             <th class="th_like" width="50px"><?=$json_item_gaji->{'NAMA'}{$i}?></th>
        <?
		}
		?>
        <?
        for($i=0;$i<count($json_item_sumbangan->{'NAMA'});$i++)
		{
		?>
             <th class="th_like" width="50px"><?=$json_item_sumbangan->{'NAMA'}{$i}?></th>
        <?
		}
		?>     
        <?
        for($i=0;$i<count($json_item_potongan->{'NAMA'});$i++)
		{
		?>
             <th class="th_like" width="50px"><?=$json_item_potongan->{'NAMA'}{$i}?></th>
        <?
		}
		?>     
        <?
        for($i=0;$i<count($json_item_tanggungan->{'NAMA'});$i++)
		{
		?>
             <th class="th_like" width="50px"><?=$json_item_tanggungan->{'NAMA'}{$i}?></th>
        <?
		}
		?>
        </tr>
        </thead>
        </table> 
    </div> 
    <!--RIGHT CLICK EVENT -->
    <div class="vmenu">
        <!--<div class="first_li"><span>Ubah</span></div>
        <div class="first_li"><span>Hapus</span></div>-->
        <div class="first_li"><span>Status</span>
            <div class="inner_li">
                <span>Dibayar</span>
			</div>
        </div>
    </div>
    <!--RIGHT CLICK EVENT -->     
</div>
</body>
</html>