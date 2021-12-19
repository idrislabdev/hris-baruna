<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

/* LOGIN CHECK */

$reqPeriode = httpFilterGet("reqPeriode");
$reqMode = httpFilterGet("reqMode");

if($reqPeriode == "")
{
	include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/KbbrThnBukuD.php");
	$periode_buku = new KbbrThnBukuD();
	$reqPeriode = $periode_buku->getPeriodeAkhir();
}
	
if($reqMode == "all")
	$reqPeriode = "";

$tinggi = 155;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>jurnal pengeluaran kas bank</title>
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

	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/examples/resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/examples/resources/demo.css">
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.js"></script>
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/demo.js"></script>	
	<script type="text/javascript" language="javascript" class="init">
var oTable;
var selected =  new Array();
 
 
$(document).ready(function() {
	/* Init the table */
	oTable = $("#example").dataTable({ bJQueryUI: true,"iDisplayLength": 50,
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
			  "sAjaxSource": "../json-keuangansiuk/jurnal_pengeluaran_kas_bank_json.php?reqPeriode=<?=$reqPeriode?>",
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "150%",
			  "sPaginationType": "full_numbers",	
			  "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
					$('#example tbody tr').each( function () {
						if (jQuery.inArray(aData[0], selected)!=-1) {
							$(this).addClass('row_selected');
						}
					});
					return nRow;
				},
				"fnDrawCallback": function ( oSettings ) {
					$('#example tbody tr').each( function () {
						var iPos = oTable.fnGetPosition( this );
						if (iPos!=null) {
							var aData = oTable.fnGetData( iPos );
							if (jQuery.inArray(aData[0], selected)!=-1)
								$(this).addClass('row_selected');
						}
						$(this).click( function (event) {
							var iPos = oTable.fnGetPosition( this );
							var aData = oTable.fnGetData( iPos );
							var iId = aData[0];
							is_in_array = jQuery.inArray(iId, selected);
							if (is_in_array==-1) {
								selected[selected.length]=iId;
							}
							else {
								selected = jQuery.grep(selected, function(value) {
									return value != iId;
								});
							}
							if(event.ctrlKey == true)
							{
								if ( $(this).hasClass('row_selected') ) {
									$(this).removeClass('row_selected');
								}
								else {
									$(this).addClass('row_selected');
								}
							}
							else
							{
								var aTrs = oTable.fnGetNodes();	
								for ( var i=0 ; i<aTrs.length ; i++ )
								{
									if ( $(aTrs[i]).hasClass('selected') )
									{
										$(aTrs[i]).removeClass('row_selected');
									}
								}			
								$(this).addClass('row_selected');
							}
						});
					});
				}
	});

	/* Click event handler */
	$('#example tbody tr').on('dblclick', function () {
		$("#btnRincianJurnal").click();	
	});

	/* RIGHT CLICK EVENT */
	var anSelectedData = '';
	var anSelectedId = '';
	var anSelectedNoPosting = '';
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
		  anSelectedNoPosting = element[1];	
	});
	
	
	$('#btnEdit').on('click', function () {
		if(anSelectedData == "")
			return false;
		if(anSelectedNoPosting == '' || anSelectedNoPosting.length != 6)
		  window.parent.OpenDHTML('jurnal_pengeluaran_kas_bank_add.php?reqMode=update&reqId='+anSelectedId, 'Office Management - Aplikasi Keuangan', '600', '300');
		else
			//alert(anSelectedNoPosting);
		  	alert('Data yang telah diposting tidak dapat diubah.');
	});

	$('#btnRincianJurnal').on('click', function () {
		if(anSelectedData == "")
			return false;				
		window.parent.OpenDHTML('monitoring_jurnal_transaksi_lihat.php?&reqId='+anSelectedId, 'Office Management - Aplikasi Keuangan', '800', '500');		
	});

	$('#btnCopy').on('click', function () {
		if(anSelectedData == "")
			return false;				
		window.parent.OpenDHTML('monitoring_jurnal_transaksi_copy.php?&reqId='+anSelectedId, 'Office Management - Aplikasi Keuangan', '800', '500');		
	});

	
	$('#btnHapus').on('click', function () {
		if(anSelectedData == "")
			return false;				

		$.getJSON('../json-keuangansiuk/get_posting_json.php?reqTabel=KBBT_JUR_BB&reqId='+anSelectedId,
		  function(data){
			  if(data.NO_POSTING == "")
			  {
				  if(confirm('Apakah anda yakin ingin menghapus nota : '+anSelectedId+'?'))
				  {
					  $.getJSON('../json-keuangansiuk/hapus_data_json.php?reqSource=JURNAL_PENGELUARAN_KAS_BANK&reqId='+anSelectedId,
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
	
	$('#btnCetak').on('click', function () {
	   if(anSelectedData == "")
			return false;	
			  window.parent.OpenDHTML('jurnal_pengeluaran_kas_bank_penanda_tangan.php?reqNoBukti='+ anSelectedId, 'Office Management - Aplikasi Keuangan', '600', '300');						
	});
	
	$('#reqPeriode').combobox({
	  onSelect: function(param){
		  if(param.text == 'Semua')
			  document.location.href = 'jurnal_pengeluaran_kas_bank.php?reqMode=all';
		  else		  
		  	  document.location.href = 'jurnal_pengeluaran_kas_bank.php?reqPeriode='+ param.id;
	  }
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
			if($(this).children().text() == 'Ubah')
			{
				$("#btnEdit").click();
			}
			else if($(this).children().text() == 'Copy Jurnal')
			{
				$("#btnCopy").click();
			}
			else if($(this).children().text() == 'Hapus')
			{
				$("#btnHapus").click();
			}
			else if($(this).children().text() == 'Cetak')
			{
				$("#btnCetak").click();
			}
			else if($(this).children().text() == 'Rincian Jurnal')
			{
				$("#btnRincianJurnal").click();
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Jurnal Pengeluaran Kas Bank (JKK)</span>
            </div>            
            </td>
        </tr>
    </table>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:30px; margin-left:176px; z-index:9999; font-size:12px;">
        Periode : <input id="reqPeriode" class="easyui-combotree" name="reqPeriode" data-options="valueField:'id',textField:'text',url:'../json-keuangansiuk/bulan_tahun_combo_json.php'" style="width:200px;" value="<?=$reqPeriode?>" />
    </div>
    </div>       
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
        	<li>
            <a href="#" id="btnRincianJurnal" title="Rincian Jurnal">Rincian Jurnal</a>            
            </li>
            <li>
            <a href="#" id="btnAdd" onClick="window.parent.OpenDHTML('jurnal_pengeluaran_kas_bank_add.php?reqMode=insert', 'Office Management - Aplikasi Keuangan', '600', '300');" title="Tambah">Tambah</a>
            <a href="#" id="btnEdit" title="Edit">Ubah</a>
            <a href="#" id="btnCopy" title="Copy">Copy Jurnal</a>
            <a href="#" id="btnCetak" title="Cetak">Cetak</a>
            <a href="#" id="btnHapus" title="Hapus">Hapus</a>
            </li>        
			<li>
            <a href="#" id="btnAdd" onClick="window.parent.OpenDHTML('jurnal_pengeluaran_kas_bank_import.php', 'Office Management - Aplikasi Keuangan', '600', '300');" title="Tambah">Import</a>            
            </li>
        </ul>
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Id</th>
            <th>Id</th>
            <th width="120px">No&nbsp;Bukti&nbsp;(SIUK)</th>
            <th width="120px">Bukti&nbsp;Pendukung</th>
            <th width="100px">Tgl&nbsp;Trans</th>
            <th width="250px">Agen/Perusahaan</th>
            <th width="50px">Valuta</th>
            <th width="50px">Kurs</th>   
            <th width="100px">Jumlah</th>
            <th width="100px">No&nbsp;Posting</th>  
            <th width="100px">Tgl&nbsp;Posting</th>  
            <th width="250px">Keterangan</th>                                                  
        </tr>
    </thead>
    </table> 
    </div> 
    <!--RIGHT CLICK EVENT -->
    <div class="vmenu">
        <div class="first_li"><span>Rincian Jurnal</span></div>
        <div class="first_li"><span>Ubah</span></div>
        <div class="first_li"><span>Copy Jurnal</span></div>
        <div class="first_li"><span>Cetak</span></div> 
        <div class="first_li"><span>Hapus</span></div>
    </div>
    <!--RIGHT CLICK EVENT -->     
</div>
</body>
</html>