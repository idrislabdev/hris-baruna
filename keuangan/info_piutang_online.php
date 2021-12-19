<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}


$tinggi = 220;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>info piutang online</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">

<style type="text/css" media="screen">
	@import "../WEB-INF/lib/media/css/site_jui.css";
    @import "../WEB-INF/lib/media/css/demo_table_jui.css";
    @import "../WEB-INF/lib/media/css/themes/base/jquery-ui.css";
	@import "../WEB-INF/lib/media/css/dataTables.tableTools.css";  /* untuk export ke excel */ 
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
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/media/css/dataTables.fixedColumns.css">
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
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>  
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
					 null,
					 null,
					 null,
					 null,
					 { bVisible:false },
					 null												 								 
				],
	  "bSort":true,
	  "bProcessing": true,
	   /* UNTUK EXPORT KE EXCEL AWAL */
	  "sDom": '<"H"lTfr>t<"F"ip>',
	  "oTableTools": {
			"sSwfPath": "../WEB-INF/lib/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				"copy",
				"xls",
				"pdf"
			]
		},
	   /* UNTUK EXPORT KE EXCEL AKHIR */
	  "bServerSide": true,		
	  "sAjaxSource": "../json-keuangansiuk/info_piutang_online_json.php",			  
	  "sScrollY": ($(window).height() - <?=$tinggi?>),
	  "sScrollX": "100%",								  
	  "sScrollXInner": "100%",
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
  
	  $("#example tbody").click(function(event) {
			  $(oTable.fnSettings().aoData).each(function (){
				  $(this.nTr).removeClass('row_selected');
			  });
			  $(event.target.parentNode).addClass('row_selected');
			  //
			  var anSelected = fnGetSelected(oTable);													
			  anSelectedData = String(oTable.fnGetData(anSelected[0]));
			  var element = anSelectedData.split(','); 
			  anSelectedId = element[0];
	  });


	$('#reqKode').keydown(function (event) {
		if(event.keyCode == 13){
			event.cancelBubble = true;
			event.returnValue = false;
		
			if (event.stopPropagation) {   
			  event.stopPropagation();
			  event.preventDefault();
			}
			
				
			var kode = "";
			if($("#reqKode").val().length == 1)
				kode = "0000" + $("#reqKode").val();
			else if($("#reqKode").val().length == 2)
				kode = "000" + $("#reqKode").val();
			else if($("#reqKode").val().length == 3)
				kode = "00" + $("#reqKode").val();
			else if($("#reqKode").val().length == 4)
				kode = "0" + $("#reqKode").val();
			else
				kode = $("#reqKode").val();
			
			$("#reqKode").val(kode);
			$.getJSON("../json-keuangansiuk/get_pelanggan_json.php?reqNoPelangganId="+kode,
			function(data){
				$('#reqNama').val(data.MPLG_NAMA);
			});	
			
			$.getJSON("../json-keuangansiuk/get_info_piutang_online_summary_json.php?reqId="+kode,
			function(data){
				  $("#jumlahRP").text(data.IDR)
				  $("#jumlahUSD").text(data.USD)
			});				
			oTable.fnReloadAjax("../json-keuangansiuk/info_piutang_online_json.php?reqId="+kode);
			return false;
		}	
		else if(event.keyCode == 120)
		{
			OpenDHTMLPopup('pelanggan_pencarian.php', 'Pencarian Pelanggan', 950, 600);
		}
				
	});				  

	  $('#btnCetak').on('click', function () {
			//alert('Cetak saldo piutang');
			window.parent.OpenDHTML('info_piutang_online_penanda_tangan.php?reqKode='+$("#reqKode").val(), 'Office Management - Aplikasi Keuangan', '600', '300');	
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
			  if($(this).children().text() == 'Cetak Saldo Piutang')
			  {
				  $("#btnCetak").click();
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
});


function OptionSet(id, nama,alamat, npwp, badan_usaha){
	document.getElementById('reqKode').value = id;
	document.getElementById('reqNama').value = nama;
	$.getJSON("../json-keuangansiuk/get_info_piutang_online_summary_json.php?reqId="+id,
	function(data){
		  $("#jumlahRP").text(data.IDR)
		  $("#jumlahUSD").text(data.USD)
	});				
	oTable.fnReloadAjax("../json-keuangansiuk/info_piutang_online_json.php?reqId="+id);	
}	
	
function OpenDHTMLPopup(opAddress, opCaption, opWidth, opHeight)
{
	var left = (screen.width/2)-(opWidth/2);
	var top = (screen.height/2)-(opHeight/2) - 100;
	
	divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
}	
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Daftar Piutang Pelanggan</span>
            </div>            
            </td>
        </tr>
    </table>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:30px; margin-left:176px; z-index:9999; font-size:12px;">
           	Pelanggan <input id="reqKode" name="reqKode">&nbsp;&nbsp;
            <input id="reqNama" name="reqNama" style="width:300px;" readonly>
    </div>
    </div>     
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" id="btnCetak" title="Cetak Saldo Piutang">Cetak Saldo Piutang</a>
            </li>        
        </ul>
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th width="150px">No&nbsp;Nota</th>
            <th width="150px">Tgl Nota</th>
            <th width="50px">Valuta</th>
            <th width="100px">Segmen Usaha</th>
            <th width="250px">Nama Kapal</th>
            <th width="100px">Jml&nbsp;Tagihan</th>
        </tr>
    </thead>
    <tfoot>
    	<tr>
        	<td colspan="5" style="text-align:right; font-weight:bold">Jumlah IDR</td>
			<td><label id="jumlahRP" style="font-weight:bold"></label></td>            
        </tr>
    	<tr>
        	<td colspan="5" style="text-align:right; font-weight:bold">Jumlah USD</td>
			<td><label id="jumlahUSD" style="font-weight:bold"></label></td>            
        </tr>
    </tfoot>
    </table> 
    </div> 
    <!--RIGHT CLICK EVENT -->
    <div class="vmenu">
        <div class="first_li"><span>Cetak Saldo Piutang</span></div> 
    </div>
    <!--RIGHT CLICK EVENT -->     
</div>
</body>
</html>