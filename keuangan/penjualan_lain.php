<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");

/* LOGIN CHECK */

$kptt_nota = new KpttNota();

$kptt_nota->selectByParamsPeriode(array("JEN_JURNAL" => "JPJ"), -1, -1, " AND BLN_BUKU IS NOT NULL ");

while($kptt_nota->nextRow())
{
	$arrPeriode[] = $kptt_nota->getField("PERIODE");	
}
	
$tinggi = 155;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>penjualan non tunai</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">

<style type="text/css" media="screen">
	@import "../WEB-INF/lib/media/css/site_jui.css";
    @import "../WEB-INF/lib/media/css/demo_table_jui.css";
    @import "../WEB-INF/lib/media/css/themes/base/jquery-ui.css";
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

	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/examples/resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/examples/resources/demo.css">
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/demo.js"></script>	
	<script type="text/javascript" language="javascript" class="init">
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
							 { bVisible:false },
							 null,
							 null,
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
			  "bServerSide": true,		
			  "sAjaxSource": "../json-keuangansiuk/penjualan_lain_json.php?reqPeriode=<?=$reqPeriode?>",			  
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "110%",
			  "sPaginationType": "full_numbers"
			  });
			/* Click event handler */
			  $('#example tbody tr').on('dblclick', function () {
				  $("#btnEdit").click();	
			  });

			  /* RIGHT CLICK EVENT */
			  var anSelectedData = '';
			  var anSelectedId = anSelectedNoPosting = '';
			  var anSelectedPosition = anSelectedRowId= '';	
			  			  
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
		  	  
			  $('#example tbody tr').on('dblclick', function () {
				$("#btnView").click();	
			  });
			  
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
					  anSelectedPajak = element[1];
					  anSelectedPPKB = element[3];
					  anSelectedValuta = element[10];
					  anSelectedNoPosting= element[element.length-2];
					  //anSelectedRowId= element[element.length-1];
			  });
			  
			  $('#btnView').on('click', function () {
				  if(anSelectedData == "")
					  return false;				
				  window.parent.OpenDHTML('penjualan_non_tunai_view.php?reqMode=update&reqId='+anSelectedId, 'Office Management - Aplikasi Keuangan', '600', '300');	
			  });
			  
			  $('#btnEdit').on('click', function () {
				  if(anSelectedData == "")
					  return false;				
				  if(anSelectedNoPosting == '')
				  	window.parent.OpenDHTML('penjualan_lain_add.php?reqMode=update&reqId='+anSelectedId, 'Office Management - Aplikasi Keuangan', '600', '300');	
			  	  else
				  	alert('Data yang telah diposting tidak dapat diubah.');
			  });
			  
			  $('#btnHapus').on('click', function () {
				  if(anSelectedData == "")
					  return false;				

				  $.getJSON('../json-keuangansiuk/get_posting_json.php?reqTabel=KPTT_NOTA&reqId='+anSelectedId,
					function(data){
						if(data.NO_POSTING == "")
						{
							if(confirm('Apakah anda yakin ingin menghapus nota : '+anSelectedId+'?'))
							{
								$.getJSON('../json-keuangansiuk/hapus_data_json.php?reqSource=penjualan_lain&reqId='+anSelectedId,
								function(data){
									if(data.HASIL == 1)
									{
										alert('Data berhasil dihapus.');
										document.location.reload();	
									}
								});			
							}
						}
						else
							alert('Data sudah diposting, tidak dapat dihapus.');
				  });	

			  });
			  
			  $('#btnCetakNotaInvoice').on('click', function () {
				  
				  if(anSelectedData == "")
					  return false;			
				  $.getJSON('../json-keuangansiuk/proses_cetak_nota_penjualan_cetak.php?reqId='+anSelectedId,
					function(data){

					  if(data.STATUS == "1")
					  {
						  window.parent.OpenDHTML('penjualan_lain_cetak_nota_rpt.php?reqId='+ anSelectedId, 'Cetak');
						  						  
						  oTable.fnReloadAjax("../json-keuangansiuk/penjualan_lain_json.php?reqPeriode="+ $("#reqPeriode").val());
					  }
					  else
					  	  alert(data.STATUS);
						  						
	
				  });	
				  
			  });
			  
			  $('#btnCetakNotaSbpp').on('click', function () {
				   window.parent.OpenDHTML('report_penanda_tangan_sbpp.php?reqId='+anSelectedId, 'Office Management - Aplikasi Keuangan', '600', '300');	
				 /* if(anSelectedData == "")
					  return false;			
				  $.getJSON('../json-keuangansiuk/proses_cetak_nota_penjualan_cetak.php?reqId='+anSelectedId,
					function(data){

					  if(data.STATUS == "1")
					  {
						  window.parent.OpenDHTML('penjualan_lain_cetak_sbpp_rpt.php?reqId='+ anSelectedId, 'Cetak');
						  						  
						  oTable.fnReloadAjax("../json-keuangansiuk/penjualan_lain_json.php?reqPeriode="+ $("#reqPeriode").val());
					  }
					  else
					  	  alert(data.STATUS);

						
	
				  });	*/
				  
			  });
			  
			  $('#btnScreenIND').on('click', function () {
				  if(anSelectedData == "")
					  return false;			
				  window.parent.OpenDHTML('penjualan_lain_cetak_nota_penanda_tangan.php?reqId='+ anSelectedId+'&reqKdValuta=IND', 'Cetak');
				  	
			  });
			  
			  $('#btnScreenENG').on('click', function () {
				  if(anSelectedData == "")
					  return false;			
				  window.parent.OpenDHTML('penjualan_lain_cetak_nota_penanda_tangan.php?reqId='+ anSelectedId+'&reqKdValuta=ENG', 'Cetak');
				  	
			  });
			  
			  $("#reqPeriode").change(function() { 
				 oTable.fnReloadAjax("../json-keuangansiuk/penjualan_lain_json.php?reqPeriode="+ $("#reqPeriode").val());
				 	 
			  });
			  
			  $('#btnCetakLaporan').on('click', function () {
				  if(anSelectedData == "")
					  return false;			
				  var centerWidth = (window.screen.width - 100) / 2;
				  var centerHeight = (window.screen.height - 100) / 2;
						  
					window.parent.OpenDHTML('cetak_permintaan_kategori.php?reqId='+anSelectedId, 'Cetak Laporan Permintaan Barang', 'resizable=1,scrollbars=yes,width=' + 350 + 
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
					  if($(this).children().text() == 'Ubah')
					  {
						  $("#btnEdit").click();
					  }
					  else if($(this).children().text() == 'Hapus')
					  {
						  $("#btnHapus").click();
					  }
					  else if($(this).children().text() == 'View')
					  {
						  $("#btnView").click();
					  }
					  $('.vmenu').hide();
					  $('.overlay').hide();
				  }
			   });

			   $('.first_li .inner_li span').on('click',function() {
				  	
					  if($(this).attr("id") == 'clickScreenInvoice')
					  {
						  $("#btnScreenIND").click();
					  }
					  else if($(this).attr("id") == 'clickScreenSBPP')
					  {
						  $("#btnScreenSbpp").click();
					  }
					  else if($(this).attr("id") == 'clickPrintInvoice')
					  {
						  $("#btnCetakNotaInvoice").click();
					  }
					  else if($(this).attr("id") == 'clickPrintSBPP')
					  {
						  $("#btnCetakNotaSbpp").click();
					  }
					  
					  $('.vmenu').hide();
					  $('.overlay').hide();
				 
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

<!-- Flex Menu -->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/flexdropdown.css" />
<script type="text/javascript" src="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/jquery.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/flexdropdown.js"></script> 

</head>
<body style="overflow:hidden">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Transaksi Lain-lain</span>
            </div>            
            </td>
        </tr>
    </table>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:30px; margin-left:176px; z-index:9999; font-size:12px;">
        Periode : <select name="reqPeriode" id="reqPeriode">
        		  <option value=""></option>
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
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" id="btnAdd" onClick="window.parent.OpenDHTML('penjualan_lain_add.php?reqMode=insert', 'Office Management - Aplikasi Keuangan', '600', '300');" title="Tambah">Tambah</a>
            <a href="#" id="btnEdit" title="Edit">Ubah</a>
            </li>
            <li>
            <a href="#" id="btnScreen" title="Screen" data-flexmenu="flexmenu1">Cetak Nota</a>
            </li>
            <li>
            <a href="#" id="btnHapus" title="Hapus">Hapus</a>
            </li>        
        </ul>
        <ul id="flexmenu1" class="flexdropdownmenu">
          <li><a href="#" id="btnScreenIND">Indonesian Version</a></li>
          <li><a href="#" id="btnScreenENG">English Version</a></li>
        </ul>  
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Id</th>  
            <th>Pajak</th>  
            <th width="100px">No.&nbsp;PPKB</th>
            <th width="250px">Pelanggan</th> 
            <th width="90px">Status Bayar</th>
            <th width="90px">No Faktur Pajak</th>
            <th width="90px">Tgl.&nbsp;Trans</th>
            <th width="50px">Kurs</th>  
            <th width="50px">Valuta</th>
            <th width="80px">Tahun</th>           
            <th width="90px">Tgl&nbsp;Valuta</th>     
            <th width="50px">Jml&nbsp;Tagihan</th>    
            <th width="200px">Ket&nbsp;Tambah</th>     
        </tr>
    </thead>
    </table> 
    </div> 
    <!--RIGHT CLICK EVENT -->
    <div class="vmenu">
        <div class="first_li"><span>Ubah</span></div>
        <div class="first_li"><span>Print</span>
            <div class="inner_li"> 
                <span id="clickScreenInvoice">Invoice</span> 
            </div>
        </div>
        <div class="first_li"><span>Hapus</span></div>
    </div>
    <!--RIGHT CLICK EVENT -->  
</div>
</body>
</html>