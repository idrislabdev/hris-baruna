<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBuku.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrCoaKustKlien.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

/* LOGIN CHECK */

$kbbr_thn_buku = new KbbrThnBuku();
$kbbr_thn_buku_d = new KbbrThnBukuD();

$kbbr_thn_buku->selectByParams(array(),-1,-1, "", "ORDER BY THN_BUKU DESC");
$kbbr_thn_buku_d->selectByParams(array(), -1, -1, " AND THN_BUKU = TO_CHAR(SYSDATE, 'YYYY')-1 AND BLN_BUKU <=12 ", " ORDER BY BLN_BUKU ASC");

$kbbr_coa_kust_klien = new KbbrCoaKustKlien();

$kbbr_coa_kust_klien->selectByParams(array("KD_KUST_KLIEN"=>1));



$safr_valuta = new SafrValuta();

$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));

/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/

$tinggi = 155;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>roll rate model</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">

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
	.libur { background-color:#F33; }
	.cuti { background-color:#FF0; }
	.ijin { background-color:#0F0; }	
</style>

<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../WEB-INF/lib/media/js/complete.js"></script>
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>

<script src="../WEB-INF/lib/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../WEB-INF/lib/media/js/jquery.dataTables.editable.js"></script>
<script src="../WEB-INF/lib/media/js/jquery.jeditable.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/jquery-ui.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/jquery.validate.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/FixedColumns.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/dataTables.tableTools.js"></script>

<script type="text/javascript" charset="utf-8">
    $(document).ready( function () {
										
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
							 null,
							 null,
							 null												 								 
						],
			  "bSort":true,
			  "bProcessing": true,
			  "sDom": '<"H"lTfr>t<"F"ip>',
			  "oTableTools": {
					"sSwfPath": "../WEB-INF/lib/media/swf/copy_csv_xls_pdf.swf",
					"aButtons": [
						"copy",
						"xls",
						"pdf"
					]
				},
			  "bServerSide": true,		
			  "sAjaxSource": "../json-keuangansiuk/roll_rate_model_json.php",			  
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "180%",
			  "sPaginationType": "full_numbers"
			  });
			/* Click event handler */
				
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
			  });
			  
			  $('#btnHitungProsen').on('click', function () {
				  if($("#reqTahunBuku").val() == '')
				  {
				  		alert('Isi tahun buku.');
						return false;	  
				  }
				  if($("#reqBulanBuku").val() == '')
				  {
				  		alert('Isi Bulan Buku.');
						return false;	  
				  }
				  if($("#reqKodeValuta").val() == '')
				  {
				  		alert('Isi kode valuta.');
						return false;	  
				  }
				  if($("#reqBadanUsaha").val() == '')
				  {
				  		alert('Isi badan usaha.');
						return false;	  
				  }
				  var win = $.messager.progress({
						title:'Please waiting',
						msg:'Loading data...'
					});
				  $.getJSON('../json-keuangansiuk/hitung_prosen_roll_rate_json.php?reqBulan='+$("#reqBulanBuku").val()+'&reqTahun='+$("#reqTahunBuku").val()+'&reqKdValuta='+$("#reqKodeValuta").val()+'&reqBadanUsaha='+$("#reqBadanUsaha").val(),
					function(data){
					  $.messager.progress('close');
					  window.parent.OpenDHTML('roll_rate_model_detil.php?reqBulan='+$("#reqBulanBuku").val()+'&reqTahun='+$("#reqTahunBuku").val()+'&reqKdValuta='+$("#reqKodeValuta").val()+'&reqBadanUsaha='+$("#reqBadanUsaha").val()+'&reqSumCur='+data.SUM_CUR+'&reqSum130='+data.SUM_130+'&reqSum3190='+data.SUM_3190+'&reqSum181='+data.SUM_181+'&reqSum371='+data.SUM_371+'&reqSum365='+data.SUM_365+'&reqSumA365='+data.SUM_A365, 'Office Management - Aplikasi Keuangan', '600', '300');							  
				  });						  
			  });
			  
 	    	  $('#btnPrintAging').on('click', function () {
			   		/*if(anSelectedData == "")
						return false;*/	
					newWindow = window.open('roll_rate_model_aging_rpt.php?reqTahun='+ $("#reqTahunBuku").val()+'&reqBulan='+$("#reqBulanBuku").val()+'&reqKdValuta='+$("#reqKodeValuta").val()+'&reqBadanUsaha='+$("#reqBadanUsaha").val(), 'Cetak');
					newWindow.focus();					  
							
			  });
			  
			  $('#btnPrintProsen').on('click', function () {
			   		/*if(anSelectedData == "")
						return false;	*/
					newWindow = window.open('roll_rate_model_prosen_rpt.php?reqTahun='+ $("#reqTahunBuku").val()+'&reqBulan='+$("#reqBulanBuku").val()+'&reqKdValuta='+$("#reqKodeValuta").val()+'&reqBadanUsaha='+$("#reqBadanUsaha").val(), 'Cetak');
					newWindow.focus();					  
							
			  });
			  
			  
			  $('#btnPrintRekap').on('click', function () {
			   		/*if(anSelectedData == "")
						return false;*/	
					newWindow = window.open('roll_rate_model_rekap_rpt.php?reqTahun='+ $("#reqTahunBuku").val()+'&reqBulan='+$("#reqBulanBuku").val()+'&reqKdValuta='+$("#reqKodeValuta").val()+'&reqBadanUsaha='+$("#reqBadanUsaha").val(), 'Cetak');
					newWindow.focus();					  
							
			  });
			  
			  
			  $('#btnPrintHasil').on('click', function () {
			   		/*if(anSelectedData == "")
						return false;*/	
					newWindow = window.open('roll_rate_model_hasil_rpt.php?reqTahun='+ $("#reqTahunBuku").val()+'&reqBulan='+$("#reqBulanBuku").val()+'&reqKdValuta='+$("#reqKodeValuta").val()+'&reqBadanUsaha='+$("#reqBadanUsaha").val(), 'Cetak');
					newWindow.focus();					  
							
			  });
			  
			  $("#reqTahunBuku").change(function() { 
				   oTable.fnReloadAjax("../json-keuangansiuk/roll_rate_model_json.php?reqBulanBuku="+$("#reqBulanBuku").val()+"&reqTahunBuku="+$("#reqTahunBuku").val()+"&reqKodeValuta="+$("#reqKodeValuta").val()+"&reqBadanUsaha="+$("#reqBadanUsaha").val());				   
			  });

			  $("#reqBulanBuku").change(function() { 		
				   oTable.fnReloadAjax("../json-keuangansiuk/roll_rate_model_json.php?reqMode=proses&reqBulanBuku="+$("#reqBulanBuku").val()+"&reqTahunBuku="+$("#reqTahunBuku").val()+"&reqKodeValuta="+$("#reqKodeValuta").val()+"&reqBadanUsaha="+$("#reqBadanUsaha").val());				   
			  });

			  
			  $("#reqKodeValuta").change(function() { 
				   oTable.fnReloadAjax("../json-keuangansiuk/roll_rate_model_json.php?reqBulanBuku="+$("#reqBulanBuku").val()+"&reqTahunBuku="+$("#reqTahunBuku").val()+"&reqKodeValuta="+$("#reqKodeValuta").val()+"&reqBadanUsaha="+$("#reqBadanUsaha").val());				   
			  });
			  
			  $("#reqBadanUsaha").change(function() { 
				   oTable.fnReloadAjax("../json-keuangansiuk/roll_rate_model_json.php?reqBulanBuku="+$("#reqBulanBuku").val()+"&reqTahunBuku="+$("#reqTahunBuku").val()+"&reqKodeValuta="+$("#reqKodeValuta").val()+"&reqBadanUsaha="+$("#reqBadanUsaha").val());				   
			  });
			  
			  $('#btnCetakLaporan').on('click', function () {
				  if(anSelectedData == "")
					  return false;			
				  var centerWidth = (window.screen.width - 100) / 2;
				  var centerHeight = (window.screen.height - 100) / 2;
						  
					newWindow = window.open('cetak_permintaan_kategori.php?reqId='+anSelectedId, 'Cetak Laporan Permintaan Barang', 'resizable=1,scrollbars=yes,width=' + 350 + 
						',height=' + 250 + 
						',left=' + centerWidth + 
						',top=' + centerHeight);
				
					newWindow.focus();
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
					  if($(this).children().text() == 'Hitung Prosen')
					  {
						  $("#btnHitungProsen").click();
					  }
					  else if($(this).children().text() == 'Print Aging')
					  {
						  $("#btnPrintAging").click();
					  }
					  else if($(this).children().text() == 'Print Prosen')
					  {
						  $("#btnPrintProsen").click();
					  }
					  else if($(this).children().text() == 'Print Rekap')
					  {
						  $("#btnPrintRekap").click();
					  }
					  else if($(this).children().text() == 'Print Hasil')
					  {
						  $("#btnPrintHasil").click();
					  }
					  $('.vmenu').hide();
					  $('.overlay').hide();
				  }
			   });

			  $('body').click(function() {				   
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

</style>
<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  
<link href="../WEB-INF/css/bluetabs.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../WEB-INF/css/dropdowntabs.js"></script>
<script language="JavaScript" src="../jslib/displayElement.js"></script>  
</head>
<body style="overflow:hidden">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Monitoring Roll Rate</span>
            </div>            
            </td>
        </tr>
    </table>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:30px; margin-left:176px; z-index:9999; font-size:12px;">
        Tahun Buku :
        			<select id="reqTahunBuku" name="reqTahunBuku">
                    	<option value=""></option>
						<? while($kbbr_thn_buku->nextRow()){?>
                            <option value="<?=$kbbr_thn_buku->getField('THN_BUKU')?>"><?=$kbbr_thn_buku->getField('THN_BUKU')?></option>
                        <? }?>
                    </select> 
        Bulan&nbsp;Buku :
        			<select id="reqBulanBuku" name="reqBulanBuku">
                    	<option value=""></option>
						<? while($kbbr_thn_buku_d->nextRow()){?>
                            <option value="<?=$kbbr_thn_buku_d->getField('BLN_BUKU')?>"><?=$kbbr_thn_buku_d->getField('NM_BLN_BUKU')?></option>
                        <? }?>
                    </select>                     
         Kode Valuta : 
         			<select id="reqKodeValuta" name="reqKodeValuta">
                    	<option value=""></option>
						<? while($safr_valuta->nextRow()){?>
                            <option value="<?=$safr_valuta->getField('KODE_VALUTA')?>"><?=$safr_valuta->getField('KODE_VALUTA')?></option>
                        <? }?>
                    </select> 
          Badan Usaha : 
          			<select id="reqBadanUsaha" name="reqBadanUsaha">
                    	<option value=""></option>
						<? while($kbbr_coa_kust_klien->nextRow()){?>
                            <option value="<?=$kbbr_coa_kust_klien->getField('BADAN_USAHA')?>"><?=$kbbr_coa_kust_klien->getField('BADAN_USAHA')?></option>
                        <? }?>
                    </select> 
    </div>
    </div> 
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
        	<li>
            	<a href="#" id="btnHitungProsen" title="Cetak">Hitung Prosen</a>            	
            </li>
            <li>         
            	<a href="#" id="btnPrintAging" title="Cetak">Print Aging</a>
            	<a href="#" id="btnPrintProsen" title="Cetak">Print Prosen</a>
           	 	<a href="#" id="btnPrintRekap" title="Cetak">Print Rekap</a>
            	<a href="#" id="btnPrintHasil" title="Cetak">Print Hasil</a>
            </li>        
        </ul>
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Id</th>
            <th width="70px">Bulan</th>
            <th width="100px">Current</th>
            <th width="100px">1&nbsp;-&nbsp;30&nbsp;Hari</th>
            <th width="100px">31&nbsp;-&nbsp;90&nbsp;Hari</th>
            <th width="100px">91&nbsp;-&nbsp;180&nbsp;Hari</th>
            <th width="100px">181&nbsp;-&nbsp;270&nbsp;Hari</th>
            <th width="100px">271&nbsp;-&nbsp;365&nbsp;Hari</th>
            <th width="100px">>365&nbsp;Hari</th>
            <th width="100px">Jumlah</th>
        </tr>
    </thead>
    </table> 
    </div> 
    <!--RIGHT CLICK EVENT -->
    <div class="vmenu">
        <div class="first_li"><span>Hitung Prosen</span></div>
        <div class="first_li"><span>Print Aging</span></div>
        <div class="first_li"><span>Print Prosen</span></div> 
        <div class="first_li"><span>Print Rekap</span></div>
        <div class="first_li"><span>Print Hasil</span></div>
    </div>
    <!--RIGHT CLICK EVENT -->     
</div>
</body>
</html>