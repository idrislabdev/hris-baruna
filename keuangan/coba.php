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
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/demo.js"></script>	
	<script type="text/javascript" language="javascript" class="init">
var oTable;
var selected =  new Array();
 
 
$(document).ready(function() {
    $('#form').submit( function() {
        alert (selected);
        return false;
    } );
 
    /* Init the table */
    oTable = $("#example").dataTable({ bJQueryUI: true,"iDisplayLength": 50,
			  /* UNTUK MENGHIDE KOLOM ID */
			  "aoColumns": [ 
							 { bVisible:false },
							 null,
							 null,
							 null,
							 null										 								 
						],
			  "bSort":true,
			  "bProcessing": true,
			  "bServerSide": true,		
			  "sAjaxSource": "../json-keuangansiuk/bank_json.php",			  
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "100%",
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
			  anSelectedData = String(oTable.fnGetData(anSelected[0]));
			  var element = anSelectedData.split(','); 
			  anSelectedId = element[0];
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Bank</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" id="btnAdd" onClick="window.parent.OpenDHTML('bank_add.php?reqMode=insert', 'Office Management - Aplikasi Keuangan', '600', '300');" title="Tambah">Tambah</a>
            <a href="#" id="btnEdit" title="Edit">Ubah</a>
            <a href="#" id="btnDeleteRow" title="Hapus">Hapus</a>
            </li>        
        </ul>
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Id</th>
            <th width="150px">Nama</th>
			<th width="100px">Cabang</th>
            <th width="200px">Alamat</th>
            <th width="100px">Kode&nbsp;Buku&nbsp;Besar</th>                                           
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