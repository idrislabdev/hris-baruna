<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRefD.php");

/* LOGIN CHECK */

$reqJenisJurnal= httpFilterRequest("reqJenisJurnal");

$kbbr_general_ref_d= new KbbrGeneralRefD();

$arrJurnal=""; $index=0;

$kbbr_general_ref_d->selectByParams(array("ID_REF_FILE" => "JENISJURNAL"));

while($kbbr_general_ref_d->nextRow())
{
	$arrJurnal[$index]["JURNAL_ID"] = $kbbr_general_ref_d->getField("ID_REF_DATA");
	$arrJurnal[$index]["NAMA"] = $kbbr_general_ref_d->getField("KET_REF_DATA");
	$index++;
}

if($reqJenisJurnal == "")
{
	$tempJenisJurnal= $arrJurnal[0]["JURNAL_ID"];
}

$tinggi = 155;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>Diklat</title>
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
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender_monitoring.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/demo.js"></script>	
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>	
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.min.js"></script>	
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/media/js/jquery.dataTables.rowGrouping.js"></script>	
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
			  "sAjaxSource": "../json-keuangansiuk/cetak_bukti_jurnal_ar_monitoring_json.php?reqJenisJurnal=<?=$tempJenisJurnal?>&reqTanggalAwalAproval=<?=date("d-m-Y")?>&reqTanggalAkhirAproval=<?=date("d-m-Y")?>",
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
			  var anSelectedNota = '';
			  var val_tanggal_awal_approval=val_tanggal_akhir_approval=val_tanggal_awal_nota=val_tanggal_akhir_nota=val_jurnal="";
			  
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
					  anSelectedNota = element[2];
					  window.parent.frames['mainFrameDetilPop'].location.href = 'monitoring_kapal_tunda_kso_detail.php?reqId='+anSelectedNota;
			  });
			  
			  $('#btnEdit').on('click', function () {
				  if(anSelectedData == "")
					  return false;				
				  window.parent.OpenDHTML('cetak_bukti_jurnal_ar_detil_monitoring.php?reqMode=update&reqId='+anSelectedId, 'Office Management - Aplikasi Keuangan', '600', '300');	
			  });
			  
			  $('#btnCetak').on('click', function () {
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
			  
			  $("#reqJenisJurnal").change(function() { 
					val_jurnal= $("#reqJenisJurnal").val();
					
					if($('#reqTanggalAwalAproval').datebox('getValue').length == 10)
					{
						val_tanggal_awal_approval = $('#reqTanggalAwalAproval').datebox('getValue');
					}
					else
					{
						val_tanggal_awal_approval = "";
					}
					
			  	 	if($('#reqTanggalAkhirAproval').datebox('getValue').length == 10)
					{
						val_tanggal_akhir_approval = $('#reqTanggalAkhirAproval').datebox('getValue');
					}
					else
					{
						val_tanggal_akhir_approval = "";
					}
					
					if($('#reqTanggalAwalNotaCetak').datebox('getValue').length == 10)
					{
						val_tanggal_awal_nota = $('#reqTanggalAwalNotaCetak').datebox('getValue');
					}
					else
					{
						val_tanggal_awal_nota = "";
					}
					
					if($('#reqTanggalAkhirNotaCetak').datebox('getValue').length == 10)
					{
						val_tanggal_akhir_nota = $('#reqTanggalAkhirNotaCetak').datebox('getValue');
					}
					else
					{
						val_tanggal_akhir_nota = "";
					}
					
				 	oTable.fnReloadAjax("../json-keuangansiuk/cetak_bukti_jurnal_ar_monitoring_json.php?reqJenisJurnal="+ val_jurnal +"&reqTanggalAwalAproval="+ val_tanggal_awal_approval+"&reqTanggalAkhirAproval="+ val_tanggal_akhir_approval+"&reqTanggalAwalNotaCetak="+ val_tanggal_awal_nota+"&reqTanggalAkhirNotaCetak="+ val_tanggal_akhir_nota);
			  });
			  
			  $('#reqTanggalAwalAproval').datebox({
				onChange:function(newValue,oldValue){
					val_jurnal= $("#reqJenisJurnal").val();
					
					if($('#reqTanggalAkhirAproval').datebox('getValue').length == 10)
					{
						val_tanggal_akhir_approval = $('#reqTanggalAkhirAproval').datebox('getValue');
					}
					else
					{
						val_tanggal_akhir_approval = "";
					}
					
					if($('#reqTanggalAwalNotaCetak').datebox('getValue').length == 10)
					{
						val_tanggal_awal_nota = $('#reqTanggalAwalNotaCetak').datebox('getValue');
					}
					else
					{
						val_tanggal_awal_nota = "";
					}
					
					if($('#reqTanggalAkhirNotaCetak').datebox('getValue').length == 10)
					{
						val_tanggal_akhir_nota = $('#reqTanggalAkhirNotaCetak').datebox('getValue');
					}
					else
					{
						val_tanggal_akhir_nota = "";
					}
					
					if(newValue.length == 10)
					{
						val_tanggal_awal_approval = newValue;
						oTable.fnReloadAjax("../json-keuangansiuk/cetak_bukti_jurnal_ar_monitoring_json.php?reqJenisJurnal="+ val_jurnal +"&reqTanggalAwalAproval="+ val_tanggal_awal_approval+"&reqTanggalAkhirAproval="+ val_tanggal_akhir_approval+"&reqTanggalAwalNotaCetak="+ val_tanggal_awal_nota+"&reqTanggalAkhirNotaCetak="+ val_tanggal_akhir_nota);
					}
					else
					{
						val_tanggal_awal_approval = "";
					}
				}
			  });
			  
			  $('#reqTanggalAkhirAproval').datebox({
				onChange:function(newValue,oldValue){
					val_jurnal= $("#reqJenisJurnal").val();
					
					if($('#reqTanggalAwalAproval').datebox('getValue').length == 10)
					{
						val_tanggal_awal_approval = $('#reqTanggalAwalAproval').datebox('getValue');
					}
					else
					{
						val_tanggal_awal_approval = "";
					}
					
					if($('#reqTanggalAwalNotaCetak').datebox('getValue').length == 10)
					{
						val_tanggal_awal_nota = $('#reqTanggalAwalNotaCetak').datebox('getValue');
					}
					else
					{
						val_tanggal_awal_nota = "";
					}
					
					if($('#reqTanggalAkhirNotaCetak').datebox('getValue').length == 10)
					{
						val_tanggal_akhir_nota = $('#reqTanggalAkhirNotaCetak').datebox('getValue');
					}
					else
					{
						val_tanggal_akhir_nota = "";
					}
					
					if(newValue.length == 10)
					{
						val_tanggal_akhir_approval = newValue;
						oTable.fnReloadAjax("../json-keuangansiuk/cetak_bukti_jurnal_ar_monitoring_json.php?reqJenisJurnal="+ val_jurnal +"&reqTanggalAwalAproval="+ val_tanggal_awal_approval+"&reqTanggalAkhirAproval="+ val_tanggal_akhir_approval+"&reqTanggalAwalNotaCetak="+ val_tanggal_awal_nota+"&reqTanggalAkhirNotaCetak="+ val_tanggal_akhir_nota);
					}
					else
					{
						val_tanggal_akhir_approval = "";
					}
				}
			  });
			  
			  $('#reqTanggalAwalNotaCetak').datebox({
				onChange:function(newValue,oldValue){
					val_jurnal= $("#reqJenisJurnal").val();
					
					if($('#reqTanggalAwalAproval').datebox('getValue').length == 10)
					{
						val_tanggal_awal_approval = $('#reqTanggalAwalAproval').datebox('getValue');
					}
					else
					{
						val_tanggal_awal_approval = "";
					}
					
					if($('#reqTanggalAkhirAproval').datebox('getValue').length == 10)
					{
						val_tanggal_akhir_approval = $('#reqTanggalAkhirAproval').datebox('getValue');
					}
					else
					{
						val_tanggal_akhir_approval = "";
					}
					
					if($('#reqTanggalAkhirNotaCetak').datebox('getValue').length == 10)
					{
						val_tanggal_akhir_nota = $('#reqTanggalAkhirNotaCetak').datebox('getValue');
					}
					else
					{
						val_tanggal_akhir_nota = "";
					}
					
					if(newValue.length == 10)
					{
						val_tanggal_awal_nota = newValue;
						oTable.fnReloadAjax("../json-keuangansiuk/cetak_bukti_jurnal_ar_monitoring_json.php?reqJenisJurnal="+ val_jurnal +"&reqTanggalAwalAproval="+ val_tanggal_awal_approval+"&reqTanggalAkhirAproval="+ val_tanggal_akhir_approval+"&reqTanggalAwalNotaCetak="+ val_tanggal_awal_nota+"&reqTanggalAkhirNotaCetak="+ val_tanggal_akhir_nota);
					}
					else
					{
						val_tanggal_awal_nota = "";
					}
				}
			  });
			  
			  $('#reqTanggalAkhirNotaCetak').datebox({
				onChange:function(newValue,oldValue){
					val_jurnal= $("#reqJenisJurnal").val();
					
					if($('#reqTanggalAwalAproval').datebox('getValue').length == 10)
					{
						val_tanggal_awal_approval = $('#reqTanggalAwalAproval').datebox('getValue');
					}
					else
					{
						val_tanggal_awal_approval = "";
					}
					
					if($('#reqTanggalAkhirAproval').datebox('getValue').length == 10)
					{
						val_tanggal_akhir_approval = $('#reqTanggalAkhirAproval').datebox('getValue');
					}
					else
					{
						val_tanggal_akhir_approval = "";
					}
					
					if($('#reqTanggalAwalNotaCetak').datebox('getValue').length == 10)
					{
						val_tanggal_awal_nota = $('#reqTanggalAwalNotaCetak').datebox('getValue');
					}
					else
					{
						val_tanggal_awal_nota = "";
					}
					
					if(newValue.length == 10)
					{
						val_tanggal_akhir_nota = newValue;
						oTable.fnReloadAjax("../json-keuangansiuk/cetak_bukti_jurnal_ar_monitoring_json.php?reqJenisJurnal="+ val_jurnal +"&reqTanggalAwalAproval="+ val_tanggal_awal_approval+"&reqTanggalAkhirAproval="+ val_tanggal_akhir_approval+"&reqTanggalAwalNotaCetak="+ val_tanggal_awal_nota+"&reqTanggalAkhirNotaCetak="+ val_tanggal_akhir_nota);
					}
					else
					{
						val_tanggal_akhir_nota = "";
					}
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
					  if($(this).children().text() == 'Setting')
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
<body style="overflow:hidden" onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Monitoring Transaksi Kapal Tunda (KSO)</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <?php /*?><a href="#" id="btnCari" title="Cari Nota">Cari Nota</a>
            <a href="#" id="btnReport" title="Report">Report</a>
            <a href="#" id="btnCetak" title="Preview">Cetak</a><?php */?>
            </li>        
        </ul>
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Id</th>
            <th width="150px">No&nbsp;Bukti</th>
            <th width="150px">No PPKB</th>
            <th width="250px">Pelanggan</th>
            <th width="250px">Kapal</th>
            <th width="150px">Tgl&nbsp;Transaksi</th>
            <th width="150px">Valuta</th>
            <th width="150px">Tgl&nbsp;Valuta</th>
            <th width="150px">Upper</th>
            <th width="150px">Materai</th>
            <th width="150px">Jml Val Trans</th>
        </tr>
    </thead>
    </table> 
    </div>     
</div>
</body>
</html>