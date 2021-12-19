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
$tinggi = 210;

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>Diklat</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css" title="blue">

<style type="text/css" media="screen">
    @import "../WEB-INF/lib/media/css/demo_page.css";
    @import "../WEB-INF/lib/media/css/demo_table.css";
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

<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
<script type="text/javascript" src="../WEB-INF/lib/media/js/complete.js"></script>
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/kalender-easyui.js"></script>
<script src="../WEB-INF/lib/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../WEB-INF/lib/media/js/jquery.dataTables.editable.js"></script>
<script src="../WEB-INF/lib/media/js/jquery.jeditable.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/jquery-ui.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/jquery.validate.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/FixedColumns.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">
	var filterKey = '';
	var filterValue = '';
	
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
			  "bServerSide": true,		
			  "sAjaxSource": "../json-sppd/sppd_sementara_json.php",
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "100%",
			  "sPaginationType": "full_numbers",
			  "fnDrawCallback": function(o) 
			  	{
                    $('.dataTables_scrollBody').scrollTop(0);
                }
			  }).makeEditable({
			sDeleteHttpMethod: "GET",
			pLocation: "../json-sppd/sppd_sementara_json.php",
			pDepartemen: "<?=$reqDepartemen?>",
			sDeleteURL: "../json-sppd/delete.php?reqMode=pegawai",
			sAddHttpMethod: "GET",
			"aoColumns": [
				{ 	cssclass: "required" },
				{
				},
				{
				
				},
				{
				
					},
					{
				
					}
				],
					oAddNewRowFormOptions: { 	
									title: 'Add a new browser',
									show: "blind",
									hide: "explode",
									modal: true
					}	,
					sAddDeleteToolbarSelector: ".dataTables_length", 								
					"oTableTools": {
								"aButtons": [
									"copy",
									"print",
									{
										"sExtends":    "collection",
										"sButtonText": "Save",
										"aButtons":    [ "csv", "xls", "pdf" ]
									}
									]
								}										
			  });
			/* Click event handler */
			  
			  $('#example tbody tr').live('dblclick', function () {
				  $("#btnEdit").click();	
			  });														
		  
			  /* RIGHT CLICK EVENT */
			  var anSelectedData = '';
			  var anSelectedId = '';
			  var anSelectedJenis = '';
			  var anSelectedPosition = '';	
			  var anSelectedNamaKapal = '';		  
			  var anSelectedFormat = '';
			  
			  function fnGetSelected( oTableLocal )
			  {
				  var aReturn = new Array();
				  var aTrs = oTableLocal.fnGetNodes();
				  for ( var i=0 ; i<aTrs.length ; i++ )
				  {
					  if ( $(aTrs[i]).hasClass('row_selected') )
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
					  anSelectedJenis = element[1];
					  anSelectedFormat= element[element.length-1];
			  });
			  
			  $('#btnEdit').live('click', function () {
				  if(anSelectedData == "")
					  return false;
				  window.parent.OpenDHTML('sppd_sementara_add.php?reqId='+anSelectedId, 'IMAIS - Aplikasi SPPD', '820', '525');	
			  });

			  $('#btnPerpanjang').live('click', function () {
				  if(anSelectedData == "")
					  return false;
				  window.parent.OpenDHTML('sppd_sementara_add_perpanjang.php?reqId='+anSelectedId, 'IMAIS - Aplikasi SPPD', '820', '525');	
			  });
			  
			  
			  
			 /* $('#btnCetak').live('click', function () {
			  	//window.parent.OpenDHTML('report_sppd_rpt.php?reqId='+anSelectedId, 'IMAIS - Aplikasi SPPD', '600', '300');			
				newWindow = window.open('report_sppd_rpt.php?reqId='+anSelectedId, 'Cetak');
				newWindow.focus();	
			  });*/
			  
			  $('#btnCetak').live('click', function () {
			  	//newWindow = window.open('gaji_perbantuan_buku_besar.php?reqJenisPegawaiId=2&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				//newWindow.focus();
				  if(anSelectedData == "")
					  return false;		
				window.parent.OpenDHTML('report_penanda_tangan.php?reqJenisReport=SPPD&reqId='+anSelectedId+'&reqJenis='+anSelectedJenis, 'IMAIS - Aplikasi Penghasilan', '600', '300');	
			  });
			  
			  $('#btnRefresh').live('click', function () {
				   
				  $('#reqTanggalAwal').datebox('setValue', '');
				  $('#reqTanggalAkhir').datebox('setValue', '');
				  fnReloadAjax("../json-sppd/sppd_sementara_json.php");
			  });
			  
			  $('#btnHapus').live('click', function () {
					if(anSelectedData == "")
						return false;
					if ( confirm( "Apakah anda yakin, menghapus data ini ?" ) ) {
						$.getJSON('../json-sppd/delete.php?reqMode=sppd_sementara&id='+anSelectedId, function (data) 
						{
							$.each(data, function (i, SingleElement) {
							});
						});
						
						oTable.fnDraw(oTable.fnSettings());
						oTable.fnDraw(oTable.fnSettings());
						oTable.fnDraw(oTable.fnSettings());
					}
				});

			  $('#btnBatal').live('click', function () {
			  	  if(anSelectedData == "")
					  return false;		
					$.messager.prompt('Konfirmasi', 'Alasan pembatalan :', function(r){
						if(typeof r == "undefined" || r == '')
						{ }
						else
						{
							
							$.getJSON('../json-sppd/sppd_batal_json.php?reqPesan='+r+'&reqId='+anSelectedId, function (data) 
							{
								
								$.each(data, function (i, SingleElement) {
									alert(SingleElement.STATUS);
									fnReloadAjax("../json-sppd/sppd_sementara_json.php?reqStatus="+ $("#reqStatus").val());
								});
								
							});
						}
					});	
			  });
			  
			  $("#reqStatus").change(function() { 
			  		fnReloadAjax("../json-sppd/sppd_sementara_json.php?reqStatus="+ $("#reqStatus").val());				 	 
			  });	
			  
			  $('#reqTanggalAwal').datebox({
				onChange:function(newValue,oldValue){
					if($('#reqTanggalAkhir').datebox('getValue').length == 10)
					{
						val_tanggal_akhir_approval = $('#reqTanggalAkhir').datebox('getValue');
					}
					else
					{
						val_tanggal_akhir_approval = "";
					}
					
					if(newValue.length == 10)
					{
						val_tanggal_awal_approval = newValue;
						fnReloadAjax("../json-sppd/sppd_sementara_json.php?reqTanggalAwal="+ val_tanggal_awal_approval+"&reqTanggalAkhir="+ val_tanggal_akhir_approval);
					}
					else
					{
						val_tanggal_awal_approval = "";
					}
				}
			  });
			  
			  $('#reqTanggalAkhir').datebox({
				onChange:function(newValue,oldValue){
					if($('#reqTanggalAwal').datebox('getValue').length == 10)
					{
						val_tanggal_awal_approval = $('#reqTanggalAwal').datebox('getValue');
					}
					else
					{
						val_tanggal_awal_approval = "";
					}
					
					if(newValue.length == 10)
					{
						val_tanggal_akhir_approval = newValue;
						fnReloadAjax("../json-sppd/sppd_sementara_json.php?reqTanggalAwal="+ val_tanggal_awal_approval+"&reqTanggalAkhir="+ val_tanggal_akhir_approval);
					}
					else
					{
						val_tanggal_akhir_approval = "";
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
		  
			   $('.vmenu .first_li').live('click',function() {
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
			   
			   $('.vmenu .inner_li span').live('click',function() {												
					  if($(this).text() == 'Aktif')
					  {
						  $.getJSON('../json-intranet/kapal_set_status.php?reqId='+anSelectedId+'&reqNilai=1', function (data) 
						  {
							  $.each(data, function (i, SingleElement) {
							  });
						  });									
						  oTable.fnUpdate('Aktif', anSelectedPosition, 5, false);
					  }
					  else if($(this).text() == 'Non-Aktif')
					  {
						  $.getJSON('../json-intranet/kapal_set_status.php?reqId='+anSelectedId+'&reqNilai=0', function (data) 
						  {
							  $.each(data, function (i, SingleElement) {
								  
							  });
						  });									
						  oTable.fnUpdate('Non-Aktif', anSelectedPosition, 5, false);
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
<!--RIGHT CLICK EVENT-->		

<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" />  

<!-- CSS for Drop Down Tabs Menu #2 -->
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  

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
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Sementara (Detasering)</span>
            </div>            
            </td>
        </tr>
    </table>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:32px; margin-left:180px; z-index:9999; font-size:12px;">
        Dari Tanggal
        <input id="reqTanggalAwal" name="reqTanggalAwal" class="easyui-datebox" style="width:100px" />
        Sampai Tanggal
        <input id="reqTanggalAkhir" name="reqTanggalAkhir" class="easyui-datebox" style="width:100px" />&nbsp;&nbsp;
        Status <select name="reqStatus" id="reqStatus"><option value="0">Aktif</option><option value="1">Batal</option></select>
    </div>
    </div>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" id="btnAdd" onClick="window.parent.OpenDHTML('sppd_sementara_add.php', 'IMAIS - Aplikasi SPPD', '820', '525');" title="Tambah">
            <img src="../WEB-INF/images/icn_add.png" width="15" height="15"/> Tambah</a>
            <a href="#" id="btnEdit" title="Edit"><img src="../WEB-INF/images/icn_edit.png" width="15" height="15"/> Ubah</a>
            <a href="#" id="btnPerpanjang" title="Perpanjang">Perpanjang</a>
            <a href="#" id="btnHapus" title="Hapus"><img src="../WEB-INF/images/icn_delete.png" width="15" height="15"/> Hapus</a>
            </li>      
            <li><a href="#" title="Batalkan" id="btnBatal"><img src="" width="15" height="15"/>Batalkan</a></li>          
            <li><a href="#" title="Cetak" id="btnCetak"><img src="" width="15" height="15"/>Cetak</a></li>
            <li>
            <a href="#" id="btnRefresh" title="Refresh"><img src="" width="15" height="15"/> Refresh</a>
            </li>
        </ul>
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th width="85px">ID</th>
            <th width="85px">Jenis</th>
            <th width="85px">NRP</th>
            <th width="155px">Nama</th>
            <th width="185px">Jabatan</th>
            <th width="55px">Tgl. Berangkat</th>
            <th width="55px">Tgl. Kembali</th>
            <th width="85px">Berangkat Dari</th>
            <th width="85px">Tujuan</th>
            <th width="85px">Angkutan</th>
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