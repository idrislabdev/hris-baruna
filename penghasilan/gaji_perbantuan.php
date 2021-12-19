<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/Gaji.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriode.php");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
$gaji = new Gaji();
$gaji_periode = new GajiPeriode();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqDepartemen = httpFilterGet("reqDepartemen");

$gaji_periode->selectByParams(array(),-1,-1,"","ORDER BY GAJI_PERIODE_ID DESC");
while($gaji_periode->nextRow())
{
	$arrPeriode[] = $gaji_periode->getField("PERIODE");	
}

if($reqDepartemen == "")
	$reqDepartemen = "CAB1";

if($reqPeriode == "")
	$reqPeriode = $arrPeriode[0];


$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(2, "AWAL_BULAN"));
$json_item_sumbangan = json_decode($gaji->getItemSumbanganDiberikan(2));
$json_item_potongan = json_decode($gaji->getItemPotonganDiberikan(2));
$json_item_tanggungan = json_decode($gaji->getItemTanggunganDiberikan(2));

$tinggi = 245;
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
</style>

<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
<script type="text/javascript" src="../WEB-INF/lib/media/js/complete.js"></script>
<script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript">

	function setValue(){
		$('#cc').combotree('setValue', '<?=$reqDepartemen?>');
	}

   $.fn.combotree.defaults = {
			width:'auto',
			treeWidth:null,
			treeHeight:200,
			url:null,
			onSelect:function(node){},
			onChange:function(newValue,oldValue){ 
			if(newValue == '<?=$reqDepartemen?>')
			{
			}
			else
				document.location.href = 'gaji_perbantuan.php?reqDepartemen=' + newValue + '&reqPeriode='+ $("#reqPeriode").val(); 
			}
	};
</script>

<script src="../WEB-INF/lib/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../WEB-INF/lib/media/js/jquery.dataTablesJSON.editable.js"></script>
<script src="../WEB-INF/lib/media/js/jquery.jeditable.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/jquery-ui.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/jquery.validate.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/FixedColumns.js" type="text/javascript"></script>


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
							 { bVisible:false },
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
			  "bSort":true,
			  "bProcessing": true,
			  "bServerSide": true,		
			  "sAjaxSource": "../json-gaji/gaji_perbantuan_json.php?reqPeriode=<?=$reqPeriode?>&reqDepartemen=<?=$reqDepartemen?>",						  
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "4500px",
			  "sPaginationType": "full_numbers"
			  }).makeEditable({
			pReloadTarget: "../json-gaji/gaji_perbantuan_json.php?reqMode=proses&reqDepartemen=<?=$reqDepartemen?>",
			sDeleteHttpMethod: "GET",
			sDeleteURL: "../json-gaji/delete.php?reqMode=gaji_awal_bulan",
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
			  
			  $("#reqPeriode").change(function() { 
				 if($("#reqPeriode").val() == '<?=$arrPeriode[0]?>')
				 	 $('.toggle').css({"display":"inline"});
				 else
				 	 $('.toggle').css({"display":"none"}); 
			  		oTable.fnReloadAjax("../json-gaji/gaji_perbantuan_json.php?reqDepartemen=<?=$reqDepartemen?>&reqPeriode="+ $("#reqPeriode").val());
				 	 
			  });
		  
			  $('#btnLihat').on('click', function () {
				  if(anSelectedData == "")
					  return false;				
				  window.parent.OpenDHTML('gaji_perbantuan_lihat.php?reqId='+anSelectedId+'&reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Penghasilan', '900', '800');	
			  });

			  $('#btnCetakBukuBesar').on('click', function () {
			  	//newWindow = window.open('gaji_perbantuan_buku_besar.php?reqJenisPegawaiId=2&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				//newWindow.focus();
				window.parent.OpenDHTML('report_penanda_tangan.php?reqJenisReport=BESAR&reqJenisPegawaiId=2&reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Penghasilan', '600', '300');		
			  });

			  $('#btnEkspor').on('click', function () {
			  	newWindow = window.open('gaji_perbantuan_cetak.php?reqPeriode=<?=$reqPeriode?>&reqDepartemen=<?=$reqDepartemen?>', 'Cetak');
				newWindow.focus();
			  });

			  $('#btnCetakPotonganLain').on('click', function () {
			  	newWindow = window.open('potongan_lain_cetak_rpt.php?reqJenisPegawaiId=2&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			  });

			  $('#btnDaftarPengantar').on('click', function () {
			  	newWindow = window.open('daftar_pengantar_cetak_rpt.php?reqJenisPegawaiId=2&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			  });



			  $('#btnCetak').on('click', function () {
				  if(anSelectedData == "")
					{  
					  newWindow = window.open('gaji_perbantuan_slip.php?reqJenisPegawaiId=2&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					  newWindow.focus();
					}
					else
					{
					  newWindow = window.open('gaji_perbantuan_slip.php?reqId='+anSelectedId+'&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					  newWindow.focus();
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
						  $("#btnDeleteRow").click();
					  }
					  $('.vmenu').hide();
					  $('.overlay').hide();
				  }
			   });
			   
			   $('.vmenu .inner_li span').on('click',function() {												
					  if($(this).text() == 'Dibayar')
					  {
						 /* alert(anSelectedId+'---'+$("#reqPeriode").val());*/
						  $.getJSON('../json-gaji/gaji_perbantuan_set_status.php?reqId='+anSelectedId+'&reqNilai=1&reqPeriode='+ $("#reqPeriode").val(), function (data) 
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
</head>
<body style="overflow:hidden" onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Perbantuan</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li><a href="#" title="Baca" id="btnBacaRow"  class="toggle">&nbsp;Proses</a></li>        
            <li><a href="#" title="Lihat" id="btnLihat"  class="toggle">&nbsp;Lihat</a></li>                    
            <li><a href="#" title="Cetak" id="btnCetak"  class="toggle">&nbsp;Cetak</a>                    
            <a href="#" title="Cetak" id="btnCetakBukuBesar"  class="toggle">&nbsp;Cetak Buku Besar</a>
            <a href="#" title="Cetak" id="btnCetakPotonganLain"  class="toggle">&nbsp;Cetak Potongan Lain</a>
            <a href="#" title="Cetak" id="btnDaftarPengantar"  class="toggle">&nbsp;Cetak Daftar Pengantar</a>
            </li> 
            <li><a href="#" title="Export Excel" id="btnEkspor"  class="toggle">&nbsp;Export Excel</a></li>                         
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
            <th rowspan="2" class="th_like" width="80px">NRP</th>
            <th rowspan="2" class="th_like" width="100px">Nama</th>
            <th colspan="<?=count($json_item_gaji->{'NAMA'})?>" style="text-align:center">Gaji</th>
            <th colspan="<?=count($json_item_sumbangan->{'NAMA'})?>" style="text-align:center">Sumbangan</th>
            <th colspan="<?=count($json_item_potongan->{'NAMA'})?>" style="text-align:center">Potongan</th>
            <th colspan="<?=count($json_item_tanggungan->{'NAMA'})?>" style="text-align:center">Tanggungan</th>
            <th rowspan="2" class="th_like" width="20px">Potongan Lain</th>
            <th rowspan="2" class="th_like" width="20px">Jml. Dibayar</th>            
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