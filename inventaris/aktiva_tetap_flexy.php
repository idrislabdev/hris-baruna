<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/KalkulasiPenyusutan.php");
$kalkulasi_penyusutan = new KalkulasiPenyusutan();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
$tinggi = 200;

$reqPeriode = httpFilterGet("reqPeriode");
$reqPeriodeLalu = httpFilterGet("reqPeriodeLalu");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");


$kalkulasi_penyusutan->selectByParamsPeriode();
$i = 0;
while($kalkulasi_penyusutan->nextRow())
{
	if($i == 0)
		$reqNotPeriode = $kalkulasi_penyusutan->getField("PERIODE");
	
	$arrPeriode[] = $kalkulasi_penyusutan->getField("PERIODE");	
	$i++;
}

$kalkulasi_penyusutan->selectByParamsPeriode(array("NOT PERIODE" => $reqNotPeriode));
while($kalkulasi_penyusutan->nextRow())
{
	if(substr($kalkulasi_penyusutan->getField("PERIODE"), 0, 2) == "07")
		$defaultLalu = $kalkulasi_penyusutan->getField("PERIODE");
		
	$arrPeriodeLalu[] = $kalkulasi_penyusutan->getField("PERIODE");	
}

if($reqPeriode == "")
	$reqPeriode = $arrPeriode[0];

if($reqPeriodeLalu == "")
{
	if($defaultLalu == "")
		$reqPeriodeLalu =  $arrPeriodeLalu[0];
	else
		$reqPeriodeLalu =  $defaultLalu;
		
}

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
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>	
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
			  "sAjaxSource": "../json-inventaris/aktiva_tetap_flexy_json.php?reqPeriode=<?=$reqPeriode?>&reqPeriodeLalu=<?=$reqPeriodeLalu?>",						  
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "100%",
			  "sPaginationType": "full_numbers"
			  });
			/* Click event handler */
			  
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
			  
			  $('#btnEksporXls').on('click', function () {
				  document.location.href = "rekap_aktiva_tetap_flexy_excel.php?reqMode=update&reqPeriode="+$("#reqPeriode").val()+"&reqPeriodeLalu="+$("#reqPeriodeLalu").val();	
			  });
			  $('#btnEksporPdf').on('click', function () {
				  window.parent.OpenDHTML("rekap_aktiva_tetap_flexy_pdf.php?reqMode=update&reqPeriode="+$("#reqPeriode").val()+"&reqPeriodeLalu="+$("#reqPeriodeLalu").val(), 'Sistem Informasi Inventaris');	
			  });
			  
			  $('#btnKalkulasi').on('click', function () {
				if(confirm('Kalkulasi periode terpilih?'))
				{  
					var jqxhr = $.get( "../json-inventaris/kalkulasi_penyusutan.php?reqPeriode="+$("#reqPeriode").val(), function(data) {
					  alert(data);
			  		  oTable.fnReloadAjax("../json-inventaris/aktiva_tetap_tahunan_json.php?reqPeriode="+ $("#reqPeriode").val());
					});	
				}				 
			  });


			  $('#btnLihat').on('click', function () {
					 window.parent.OpenDHTML('jurnal_lihat.php?reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Fixed Asset', '900', '600');	
			 
			  });
			  
			  $("#reqPeriode").change(function() { 
			  		document.location.href ="aktiva_tetap_flexy.php?reqPeriode="+ $("#reqPeriode").val()+"&reqPeriodeLalu="+ $("#reqPeriodeLalu").val();
			  });
			  	
			  
			  $("#reqPeriodeLalu").change(function() { 
			  		document.location.href ="aktiva_tetap_flexy.php?reqPeriode="+ $("#reqPeriode").val()+"&reqPeriodeLalu="+ $("#reqPeriodeLalu").val();
			  });
			  	
			  $('#btnDeleteRow').on('click', function () {
				if(anSelectedData == "")
					return false;
				if ( confirm( "Apakah anda yakin, menghapus data ini ?" ) ) {
					$.getJSON('../json-gaji/delete.php?reqMode=tunjangan_jabatan&id='+anSelectedId, function (data) 
					{
						$.each(data, function (i, SingleElement) {
						});
					});
					
					oTable.fnDraw(oTable.fnSettings());
					oTable.fnDraw(oTable.fnSettings());
					oTable.fnDraw(oTable.fnSettings());
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
			  
			  
			  $('#btnLihat').on('click', function () {
					 window.parent.OpenDHTML('jurnal_flexy_lihat.php?reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Fixed Asset', '900', '600');	
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
<!--RIGHT CLICK EVENT-->		

<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 

<!-- CSS for Drop Down Tabs Menu #2 -->
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  
<link rel="stylesheet" type="text/css" href="../WEB-INF/css/bluetabs.css" />
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Rekapitulasi Aktiva Tetap per Periode</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <!-- <a href="#" id="btnImport" onClick="window.parent.OpenDHTML('kalkulasi_penyusutan_import.php?reqMode=import', 'Office Management - Aplikasi Penghasilan', '600', '300');" title="Tambah">Import</a> -->
            <!-- <a href="#" id="btnKalkulasi" title="Kalkulasi"> Kalkulasi</a> -->
            <a href="#" id="btnEksporXls" title="Ekspor"> Export Excel</a>
            <a href="#" id="btnEksporPdf"title="Ekspor"> Export PDF</a>
            <!-- <a href="#" id="btnLihat" title="Lihat"> Lihat Jurnal</a> -->
            <!-- <a href="#" id="btnAdd" onClick="window.parent.OpenDHTML('tunjangan_mengajar_add.php?reqMode=insert', 'Office Management - Aplikasi Penghasilan', '600', '300');" title="Tambah">Tambah</a> -->
            <!-- <a href="#" id="btnEdit" title="Edit">Ubah</a> -->
            <!-- <a href="#" id="btnDeleteRow" title="Hapus">Hapus</a> -->
            </li>        
        </ul>
    </div>

    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:6px; margin-left:180px; z-index:9999; font-size:12px;">
 		Periode : <select name="reqPeriodeLalu" id="reqPeriodeLalu">
 				  <option value=""></option>
        		  <?
                  for($i=0;$i<count($arrPeriodeLalu);$i++)
				  {
				  ?>
                  	<option value="<?=$arrPeriodeLalu[$i]?>" <? if($reqPeriodeLalu == $arrPeriodeLalu[$i]) { ?> selected <? } ?>><?=getNamePeriode($arrPeriodeLalu[$i])?></option>
                  <?	  
				  }
				  ?>
        		  </select>
                  s.d
         		  <select name="reqPeriode" id="reqPeriode">
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
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>	

        <tr>  
            <th style="width:400px" rowspan="2">Kelompok</th>          
            <th width="50px" rowspan="2">Saldo Aktiva <?=getNamePeriode($reqPeriodeLalu)?></th>          
            <th width="50px" colspan="2">Mutasi Aktiva</th>          
            <th width="50px" rowspan="2">Saldo Aktiva <?=getNamePeriode($reqPeriode)?></th>            
            <th width="50px" rowspan="2">Saldo Akm. Penyusutan <?=getNamePeriode($reqPeriodeLalu)?></th>           
            <th width="50px" colspan="2">Mutasi Penyusutan</th>   
            <th width="50px" rowspan="2">Saldo Akm. Penyusutan</th> 
            <th width="50px" rowspan="2">Nilai Buku</th> 
        </tr>
        <tr>
        	<td>Penambahan</td>
        	<td>Pengurangan</td>
        	<td>Penambahan</td>
        	<td>Pengurangan</td>
        </tr>
    </thead>
    </table> 
    </div> 
    <!--RIGHT CLICK EVENT -->
<!--     <div class="vmenu">
        <div class="first_li"><span>Ubah</span></div>
        <div class="first_li"><span>Hapus</span></div>
    </div> -->
    <!--RIGHT CLICK EVENT -->    
</div>
</body>
</html>