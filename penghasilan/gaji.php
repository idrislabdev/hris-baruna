<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/Gaji.php");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$gaji = new Gaji();

$reqMode= httpFilterGet("reqMode");
$reqTahun= httpFilterGet("reqTahun");
$reqBulan= httpFilterGet("reqBulan");
$reqDepartemen = httpFilterGet("reqDepartemen");
$reqJenisPegawai = httpFilterGet("reqJenisPegawai");

if($reqJenisPegawai == "")
	$reqJenisPegawai = 4;

if($reqTahun == "")	{
	$reqBulan = date("m");
	$reqTahun = date("Y");	
}

if($reqDepartemen == "")
	$reqDepartemen = "CAB1"; //$userLogin->idDepartemen;
	
$tinggi = 155;

$json_item_gaji = json_decode($gaji->getItemGajiDiberikan($reqJenisPegawai, "AWAL_BULAN"));


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
	.bayar { background-color:#3F3; }
	.belumbayar { background-color:#F00; }	
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
				document.location.href = 'gaji.php?reqDepartemen=' + newValue + '&reqTahun=<?=$reqTahun?>&reqBulan=<?=$reqBulan?>'; 
			}
	};
</script>

<script src="../WEB-INF/lib/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../WEB-INF/lib/media/js/jquery.dataTablesTahun.editable.js"></script>
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
							 null,
							 null,
							 <?
							 for($i=0; $i<count($json_item_gaji->{"ITEM_GAJI"}); $i++)
							 {
							 ?>
							 null,
							 <?
							 }
							 ?>
							 null
						],
			  "bSort":true,
			  "bProcessing": true,
			  "bServerSide": true,		
			  "sAjaxSource": "../json-gaji/gaji_json.php?reqTahun=<?=$reqTahun?>&reqBulan=<?=$reqBulan?>&reqDepartemen=<?=$reqDepartemen?>",			  
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "100%",
			  "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
									if ( aData[9] == '1') 
									{
										var i=0;
										for (i=0;i<=9;i++)
										{
											jQuery('td:eq('+i+')', nRow).addClass('bayar');
										}
									} 
									
									return nRow;
								   },	
			  "sPaginationType": "full_numbers"
			  }).makeEditable({
			sDeleteHttpMethod: "GET",
			sDeleteURL: "../json-database/delete.php?reqMode=cabang",
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
 			  var anSelectedData = '';
			  var anSelectedId = '';
			  var anSelectedValidasi = '';			  
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
					  anSelectedNama = element[1];
					  anSelectedKelas = element[2];
					  anSelectedPeriode = element[3];
					  anSelectedMerit = element[4];
					  anSelectedTPP = element[5];
					  anSelectedTjPerbantuan = element[6];
					  anSelectedTjJabatan = element[7];
					  anSelectedTotal = element[8];
					  anSelectedBayar = element[9];		
			  });
			  			  
			  $('#btnProses').on('click', function () { 
			  		oTable.fnReloadAjax('../json-gaji/gaji_json.php?reqMode=proses&reqDepartemen=<?=$reqDepartemen?>&reqBulan=' + $("#bulan").val() + '&reqTahun=' + $("#tahun").val());

						
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
			   $('.vmenu .inner_li span').on('click',function() {												
					  if($(this).text() == 'Sudah Bayar')
					  {					
						 $.getJSON('../json-gaji/gaji_json_set.php?reqId='+anSelectedId+'&reqBulanTahun=<?=$reqBulan.$reqTahun?>&reqNilai=1', function (data) 
						  {
							  $.each(data, function (i, SingleElement) {
								  oTable.fnUpdate('<div style="background-color:#3F3; width:100%; margin-top:-3px; padding-top:3px; float:left; position:relative; margin-bottom:-3px; padding-bottom:3px; border-right:15px solid #3F3; margin-left:-10px; padding-left:10px;">' + anSelectedNama + '</div>', anSelectedPosition, 1, false);
								  oTable.fnUpdate('<div style="background-color:#3F3; width:100%; margin-top:-3px; padding-top:3px; float:left; position:relative; margin-bottom:-3px; padding-bottom:3px; border-right:15px solid #3F3; margin-left:-10px; padding-left:10px;">' + anSelectedKelas + '</div>', anSelectedPosition, 2, false);
								  oTable.fnUpdate('<div style="background-color:#3F3; width:100%; margin-top:-3px; padding-top:3px; float:left; position:relative; margin-bottom:-3px; padding-bottom:3px; border-right:15px solid #3F3; margin-left:-10px; padding-left:10px;">' + anSelectedPeriode + '</div>', anSelectedPosition, 3, false);
								  oTable.fnUpdate('<div style="background-color:#3F3; width:100%; margin-top:-3px; padding-top:3px; float:left; position:relative; margin-bottom:-3px; padding-bottom:3px; border-right:15px solid #3F3; margin-left:-10px; padding-left:10px;">' + anSelectedMerit + '</div>', anSelectedPosition, 4, false);
								  oTable.fnUpdate('<div style="background-color:#3F3; width:100%; margin-top:-3px; padding-top:3px; float:left; position:relative; margin-bottom:-3px; padding-bottom:3px; border-right:15px solid #3F3; margin-left:-10px; padding-left:10px;">' + anSelectedTPP + '</div>', anSelectedPosition, 5, false);
								  oTable.fnUpdate('<div style="background-color:#3F3; width:100%; margin-top:-3px; padding-top:3px; float:left; position:relative; margin-bottom:-3px; padding-bottom:3px; border-right:15px solid #3F3; margin-left:-10px; padding-left:10px;">' + anSelectedTjPerbantuan + '</div>', anSelectedPosition, 6, false);
								  oTable.fnUpdate('<div style="background-color:#3F3; width:100%; margin-top:-3px; padding-top:3px; float:left; position:relative; margin-bottom:-3px; padding-bottom:3px; border-right:15px solid #3F3; margin-left:-10px; padding-left:10px;">' + anSelectedTjJabatan + '</div>', anSelectedPosition, 7, false);
								  oTable.fnUpdate('<div style="background-color:#3F3; width:100%; margin-top:-3px; padding-top:3px; float:left; position:relative; margin-bottom:-3px; padding-bottom:3px; border-right:15px solid #3F3; margin-left:-10px; padding-left:10px;">' + anSelectedTotal + '</div>', anSelectedPosition, 8, false);

							  });
						  });						
							   					  
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
			  /* RIGHT CLICK EVENT */			  
		} );
</script>

<!--RIGHT CLICK EVENT-->		
<style>

	.vmenu{
		margin-top:-105px;
	border:1px solid #aaa;
	position:absolute;
	background:#fff;
	display:none;font-size:0.75em;}
	.vmenu span{ position:relative;}
	.first_li{}
	.first_li span{width:100px;display:block;padding:5px 10px;cursor:pointer;}
	.inner_li{display:none;margin-left:120px;position:absolute;border:1px solid #aaa;border-left:1px solid #ccc;margin-top:-28px;background:#fff;}
	.sep_li{border-top: 1px ridge #aaa;margin:5px 0}
	.fill_title{font-size:11px;font-weight:bold;/height:15px;/overflow:hidden;word-wrap:break-word;}

</style>
<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Gaji</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
     <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" id="btnProses" title="Hapus">Proses</a>
            </li>        
        </ul>
    </div>
  <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:6px; margin-left:320px; z-index:9999; font-size:12px;">
        Departemen : <input id="cc" class="easyui-combotree" name="reqDepartemen" data-options="url:'../json-intranet/departemen_combo_json.php'" style="width:300px;">&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
        <tr>
            <th>Id</th>
            <th width="200px">Nama</th>
            <?
            for($i=0; $i<count($json_item_gaji->{"ITEM_GAJI"}); $i++)
			{
			?>
            <th width="150px"><?=$json_item_gaji->{"NAMA"}{$i}?></th>
			<?
			}
			?>
            <th>Jumlah</th>
        </tr>
        </thead>
        </table> 
	</div>    
    <!--RIGHT CLICK EVENT -->
    <div class="vmenu">
        <div class="first_li"><span>Status</span>
            <div class="inner_li">
                <span>Sudah Bayar</span> 
			</div>
        </div>
    </div>
    <!--RIGHT CLICK EVENT -->        
</div>
</body>
</html>