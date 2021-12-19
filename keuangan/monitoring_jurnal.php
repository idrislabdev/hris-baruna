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
<title>Monitoring Jurnal</title>
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
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>	
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.min.js"></script>	
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/media/js/jquery.dataTables.rowGrouping.js"></script>	
	<script type="text/javascript" language="javascript" class="init">
	var oTable;
	var selected =  new Array();
	 
	 
	$(document).ready(function() {
	/* Init the table */
	oTable = $("#example").dataTable({ bJQueryUI: true,"iDisplayLength": 50,
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
			  "sAjaxSource": "../json-keuangansiuk/monitoring_jurnal_json.php?reqTanggal=<?=date("d-m-Y")?>",
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "180%",
			  "sPaginationType": "full_numbers"
			  }).rowGrouping();
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
	
	$("#example tbody").click(function(event) {
			var anSelected = fnGetSelected(oTable);
			//alert(anSelected.length);
			var id = "";
			var no = "";
			for(var i=0 ; i<anSelected.length ; i++)
			{
				  anSelectedData = String(oTable.fnGetData(anSelected[i]));		
				  var element = anSelectedData.split(','); 
				  if(id == "")
				  {
					  id = element[1];
					  no_posting = element[8];	
				  }
				  else
				  {
					  id = id+","+element[1];
					  no_posting = no_posting+","+element[8];	
				  }							
			}	
			anSelectedId =id;
			anSelectedNoPosting = no_posting;
	});
	
	$('#btnEdit').on('click', function () {
		if(anSelectedData == "")
			return false;
		if(anSelectedNoPosting == '')
		  window.parent.OpenDHTML('jurnal_penerimaan_kas_bank_add.php?reqMode=update&reqId='+anSelectedId, 'Office Management - Aplikasi Keuangan', '600', '300');
		else
		  alert('Data yang telah diposting tidak dapat diubah.');
	});

	$('#btnRincianJurnal').on('click', function () {
		if(anSelectedData == "")
			return false;				
		window.parent.OpenDHTML('monitoring_jurnal_transaksi_lihat.php?&reqId='+anSelectedId, 'Office Management - Aplikasi Keuangan', '800', '500');		
	});

	$('#reqTanggal').datebox({
	  onChange:function(newValue,oldValue){
		  
		    oTable.fnReloadAjax("../json-keuangansiuk/monitoring_jurnal_json.php?reqTanggal="+ newValue);
		  
	  }
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
            <!--<div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Jurnal Penerimaan Kas - Bank (JKM)</span>
            </div>-->
            
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Monitoring Jurnal</span>
            </div>
            </td>
        </tr>
    </table>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:31px; margin-left:176px; z-index:9999; font-size:12px;">
        Tanggal Entri : <input id="reqTanggal" name="reqTanggal" class="easyui-datebox" style="width:100px" value="<?=date("d-m-Y")?>" />
    </div>
    </div>        
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
        	<li>
            <a href="#" id="btnRincianJurnal" title="Rincian Jurnal">Rincian Jurnal</a>            
            </li>
        </ul>
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Id</th>
            <th width="120px">No&nbsp;Bukti&nbsp;(SIUK)</th>
            <th width="130px">Bukti&nbsp;Pendukung</th>
            <th width="120px">Tgl&nbsp;Trans</th>
            <th width="250px">Agen/Perusahaan</th>
            <th width="50px">Valuta</th>
            <th width="50px">Kurs</th>   
            <th width="100px">Jumlah</th>
            <th width="100px">No&nbsp;Posting</th>  
            <th width="120px">Tgl&nbsp;Posting</th>  
            <th width="420px">Keterangan</th>                                                  
        </tr>
    </thead>
    </table> 
    </div> 
    <!--RIGHT CLICK EVENT -->
    <div class="vmenu">
        <div class="first_li"><span>Rincian Jurnal</span></div>
        <div class="first_li"><span>Ubah</span></div>
        <div class="first_li"><span>Hapus</span></div>
        <div class="first_li"><span>Cetak</span></div>
    </div>
    <!--RIGHT CLICK EVENT -->     
</div>
</body>
</html>