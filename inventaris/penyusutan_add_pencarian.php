<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqIndex = httpFilterGet("reqIndex");

$reqLokasi = httpFilterGet("reqLokasi");
$reqNotIn = httpFilterGet("reqNotIn");
if($reqLokasi == "")
	$reqLokasi = "";

$tinggi = 149;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>Diklat</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<!--<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">-->
<link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">

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
<script type="text/javascript">
	function setValue(){
		$('#cc').combotree('setValue', '<?=$reqLokasi?>');
	}

   $.fn.combotree.defaults = {
			width:'auto',
			treeWidth:null,
			treeHeight:200,
			url:null,
			onSelect:function(node){},
			onChange:function(newValue,oldValue){ 
			if(newValue == '<?=$reqLokasi?>')
			{
			}
			else
				document.location.href = "penyusutan_add_pencarian.php?reqIndex=<?=$reqIndex?>&reqLokasi=" + newValue; 
			}
	};
</script>

<script src="../WEB-INF/lib/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../WEB-INF/lib/media/js/jquery.dataTablesJSON.editable.js"></script>
<script src="../WEB-INF/lib/media/js/jquery.jeditable.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/jquery-ui.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/jquery.validate.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/FixedColumns.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/jquery.dataTables.rowGrouping.js" type="text/javascript"></script>

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
							 null,
							 null,
							 null													 								 
						],
			  "bSort":true,
			  "bProcessing": true,
			  "bServerSide": true,		
			  "sAjaxSource": "../json-inventaris/penyusutan_add_pencarian_json.php?reqIndex=<?=$reqIndex?>&reqLokasi=<?=$reqLokasi?>",		  
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "100%",
			  "sPaginationType": "full_numbers"
			  }).makeEditable({
			sDeleteHttpMethod: "GET",
			sDeleteURL: "../json-operasional/delete.php?reqMode=inventaris_ruangan_pencarian",
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
			  }).rowGrouping();
			/* Click event handler */
			  $('#example tbody tr').live('dblclick', function () {
				  $("#btnPilih").click();	
			  });	

			  /* RIGHT CLICK EVENT */
			  var anSelectedData = '';
			  var anSelectedId = '';
			  var anSelectedNomor = '';
			  var anSelectedNama = '';
			  var anSelectedPosition = '';	
			  			  
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
					  anSelectedId = element[1];
			  });
			  
			  $('#btnPilih').live('click', function () {
				  if(anSelectedData == "")
					  return false;
				  parent.OptionSetInventarisRuangan(<?=$reqIndex?>, anSelectedId);	
				  window.parent.divwin.close();	
			  });
			  
			  $('#btnCetakLaporan').live('click', function () {
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
		display:none;font-size:0.75em;
	}
	.first_li{}
	.first_li span{
		width:100px;
		display:block;
		padding:5px 10px;
		cursor:pointer
	}
	.inner_li{display:none;margin-left:120px;position:absolute;border:1px solid #aaa;border-left:1px solid #ccc;margin-top:-28px;background:#fff;}
	.sep_li{border-top: 1px ridge #aaa;margin:5px 0}
	.fill_title{font-size:11px;font-weight:bold;/height:15px;/overflow:hidden;word-wrap:break-word;}
	</style>
    
    <link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  
    <link href="../WEB-INF/css/bluetabs.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/js/dropdowntabs.js"></script>
    <script language="JavaScript" src="../jslib/displayElement.js"></script>  

</head>
<body style="overflow:hidden;" onLoad="setValue()">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    
    <span>Data Penghapusan</span>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif)">    
        <ul>
            <li>
            	<a href="#" id="btnPilih" title="Edit">Pilih</a>
            </li>     
        </ul>
    </div>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:5px; margin-left:205px; z-index:9999; font-size:14px;">
        Lokasi : <input id="cc" class="easyui-combotree" name="reqLokasi" data-options="url:'../json-inventaris/lokasi_combo_json.php',width:'500'" style="width:400px;">&nbsp;&nbsp;
    </div>
    </div> 
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Inventaris</th>
            <th width="50px">id</th>  
            <th width="100px">Nomor</th>  
            <th width="70px">Lokasi</th>  
            <th width="50px">Perolehan</th>
            <th width="50px">Nilai Perolehan</th>   
            <th width="300px">Keterangan</th>                                                                                       
        </tr>
    </thead>
    </table> 
	</div>
</div>


</body>

    
</html>