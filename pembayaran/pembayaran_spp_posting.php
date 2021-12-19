<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaSpp.php");

/* LOGIN CHECK */


$kptt_nota = new KpttNotaSpp();

$kptt_nota->selectByParamsPeriode(array("JEN_JURNAL" => "JKM"), -1, -1, " AND BLN_BUKU IS NOT NULL ");

while($kptt_nota->nextRow())
{
	$arrPeriode[] = $kptt_nota->getField("PERIODE");	
}

$tinggi = 155;

$reqTanggalAwal = date("d-m-Y");
$reqTanggalAkhir = date("d-m-Y");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>proses pelunasan kas bank</title>
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


	<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>


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
							 null,
							 { bVisible:false }
						],
			  "bSort":true,
			  "bProcessing": true,
			  "bServerSide": true,		
			  "sAjaxSource": "../json-pembayaran/pembayaran_all_json.php?reqTanggalAwal=<?=$reqTanggalAwal?>&reqTanggalAkhir=<?=$reqTanggalAkhir?>",			  
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "120%",
			  "sPaginationType": "full_numbers"
			  });
			/* Click event handler */

			  /* RIGHT CLICK EVENT */
			  var anSelectedData = '';
			  var anSelectedId = anSelectedNoPosting = '';
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
		  	  
			  $('#example tbody tr').on('dblclick', function () {
				$("#btnView").click();	
			  });
			  
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
					  anSelectedNoPosting= element[element.length-1];
			  });
			  
			  $('#btnView').on('click', function () {
				  if(anSelectedData == "")
					  return false;				
				  window.parent.OpenDHTML('pembayaran_spp_view.php?reqMode=update&reqId='+anSelectedId, 'Office Management - Aplikasi Pembayaran', '600', '300');	
			  });
			  
			   $('#btnCetak').on('click', function () {
				   if(anSelectedData == "")
						return false;	
						  window.parent.OpenDHTML('invoice_pdf.php?reqNoBukti='+ anSelectedId, 'Office Management - Aplikasi Pembayaran', '600', '300');				  
								
				});
			  
			  $('#btnPosting').on('click', function () {

					var mulai = $('#reqTanggalAwal').datebox('getValue');	

					if(confirm("Posting jurnal transaksi tanggal " + mulai + " ?"))
					{

						$.get( "../json-pembayaran/posting_jurnal_json.php?reqTanggal="+mulai, function( data ) {
							
						  	alert(data);
							var mulai = $('#reqTanggalAwal').datebox('getValue');	
							var selesai = $('#reqTanggalAwal').datebox('getValue');
					 		oTable.fnReloadAjax("../json-pembayaran/pembayaran_all_json.php?reqTanggalAwal=" + mulai + "&reqTanggalAkhir=" + selesai);


						});

					}

			  });
			  
			  $("#reqPeriode").change(function() { 
				 oTable.fnReloadAjax("../json-pembayaran/pembayaran_all_json.php?reqPeriode="+ $("#reqPeriode").val());
				 	 
			  });
			  
			  $('#reqTanggalAwal').datebox({
					onSelect: function(date){
						
						var mulai = $('#reqTanggalAwal').datebox('getValue');	
						var selesai = $('#reqTanggalAwal').datebox('getValue');

				 		oTable.fnReloadAjax("../json-pembayaran/pembayaran_all_json.php?reqTanggalAwal=" + mulai + "&reqTanggalAkhir=" + selesai);

					}
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Posting Pembayaran Harian</span>
            </div>            
            </td>
        </tr>
    </table>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:28px; margin-left:186px; z-index:9999; font-size:12px;">
        Periode :  <input id="reqTanggalAwal" name="reqTanggalAwal" class="easyui-datebox" data-options="validType:'date'" value="<?=$reqTanggalAwal?>" />

    </div>
    </div> 
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" id="btnView" title="View" >View</a>
            <a href="#" id="btnCetak" title="Cetak">Cetak</a>
            <a href="#" id="btnPosting" title="Posting">Posting Jurnal</a>
            </li>        
        </ul>
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Id</th>
            <th width="100px">No.&nbsp;Bukti</th>
            <th width="170px">Siswa</th>
            <th width="100px">Tgl&nbsp;Trans</th>
            <th width="140px">Ref Tagihan</th>
            <th width="120px">Thn&nbsp;/&nbsp;Bln&nbsp;Buku</th>
            <th width="300px">Rek.&nbsp;Kas&nbsp;/&nbsp;Bank</th>
            <th width="100px">Tgl&nbsp;Posting</th>
            <th width="100px">No.&nbsp;Posting</th>
            <th width="100px">Jumlah&nbsp;Trans</th>
            <th width="300px">Keterangan</th>
            <th width="150px">No&nbsp;Posting</th>
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