<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");

/* LOGIN CHECK */

$kbbt_jur_bb_tmp = new KbbtJurBbTmp();

$kbbt_jur_bb_tmp->selectByParamsPeriode(array(), -1, -1, " AND BLN_BUKU IS NOT NULL ");
while($kbbt_jur_bb_tmp->nextRow())
{
	$arrPeriode[] = $kbbt_jur_bb_tmp->getField("PERIODE");	
}

if($reqPeriode == "")
	$reqPeriode = $arrPeriode[0];

$tinggi = 155;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>anggaran mutasi</title>
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
	.coloringRowRed { background-color:#FBADA2; }
	.coloringRowKuning { background-color:#F3FB91; }
	.coloringRowPutih { background-color:#FFF; }
	
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
							 null										 								 
						],
			  "bSort":true,
			  "bProcessing": true,
			  "bServerSide": true,		
			  "sAjaxSource": "../json-anggaran/anggaran_mutasi_json.php?reqPeriode=<?=$reqPeriode?>",
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "100%",
			  "sPaginationType": "full_numbers",
			  "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
				  if(aData[1] == 1){
					  var i=0;
					  for (i=0;i<=8;i++)
					  {
					  jQuery('td:eq('+i+')', nRow).addClass('coloringRowRed');
					  }
				  }
				  return nRow;
				 }
			  });
			/* Click event handler */

			  /* RIGHT CLICK EVENT */
			  var anSelectedData = '';
			  var anSelectedId = anSelectedValidasi = '';
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
					  anSelectedValidasi= element[1];
					  //anSelectedId= element[element.length-1];
					   //alert(anSelectedRowId);
			  });
			  
			  $('#btnEdit').on('click', function () {
				  if(anSelectedData == "")
					  return false;
				  
				  if(anSelectedValidasi == 1)
				  	alert("Data tervalidasi");
				  else
				  	window.parent.OpenDHTML('anggaran_mutasi_add.php?reqMode=update&reqId='+anSelectedId+'&reqPeriode='+$("#reqPeriode").val(), 'Office Management - Aplikasi Keuangan', '600', '300');
			  });
			  
			  $('#btnLihat').on('click', function () {
				  if(anSelectedData == "")
					  return false;				
				  	window.parent.OpenDHTML('anggaran_mutasi_add.php?reqMode=lihat&reqId='+anSelectedId, 'Office Management - Aplikasi Keuangan', '600', '300');
			  });
			  
			   $('#btnHapus').on('click', function () {
				if(anSelectedData == "")
					return false;
				if(anSelectedValidasi == 1)
				  	alert("Data tervalidasi");
				else
				{  
					if ( confirm( "Apakah anda yakin, menghapus data ini ?" ) ) {
						$.getJSON('../json-anggaran/delete.php?reqMode=anggaran_mutasi&reqId='+anSelectedId+'&reqRowId='+anSelectedRowId, function (data) 
						{
							$.each(data, function (i, SingleElement) {
							});
						});
						
						oTable.fnDraw(oTable.fnSettings());
						oTable.fnDraw(oTable.fnSettings());
						oTable.fnDraw(oTable.fnSettings());
					}
				}
			  });
			  
			  $('#btnCetak').on('click', function () {
			  });
			  
			  $("#reqPeriode").change(function() { 
				 oTable.fnReloadAjax("../json-anggaran/anggaran_mutasi_json.php?reqPeriode="+ $("#reqPeriode").val() + "&reqStatus=" + $("#reqStatus").val());
			  });
			  
			  $("#reqStatus").change(function() {
				 oTable.fnReloadAjax("../json-anggaran/anggaran_mutasi_json.php?reqPeriode="+ $("#reqPeriode").val() + "&reqStatus=" + $("#reqStatus").val());
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
					  else if($(this).children().text() == 'Hapus')
					  {
						  $("#btnHapus").click();
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
		
		function setTambah()
		{
			window.parent.OpenDHTML('anggaran_mutasi_add.php?reqMode=insert&reqPeriode='+$("#reqPeriode").val(), 'Office Management - Administrasi Keuangan', '600', '300');
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Penggunaan Anggaran</span>
            </div>
            </td>
        </tr>
    </table>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:30px; margin-left:176px; z-index:9999; font-size:12px;">
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
            &nbsp;&nbsp;&nbsp;
            Status
            <select name="reqStatus" id="reqStatus">
                <option value="">Semua</option>
                <option value="0">Permohonan</option>
                <option value="1">Tervalidasi</option>
            </select>
    </div>
    </div>        
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
        	<li>
            <a href="#" id="btnLihat" title="Lihat">Lihat</a>
            </li>
            <li>
            <a href="#" id="btnAdd" onClick="setTambah()" title="Tambah">Tambah</a>
            <a href="#" id="btnEdit" title="Edit">Ubah</a>
            <a href="#" id="btnHapus" title="Hapus">Hapus</a>
            </li>        
        </ul>
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Id</th>
            <th>Id</th>
            <th width="100px">Tanggal</th>
            <th width="100px">Kode&nbsp;Buku&nbsp;Pusat</th>
            <th width="100px">Kode&nbsp;Sub&nbsp;Bantu</th>
            <th width="100px">Kode&nbsp;Buku&nbsp;Besar</th>
            <th width="100px">Jumlah&nbsp;Mutasi</th>
            <th width="100px">Pph</th>   
            <th width="100px">Total</th>                                                  
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