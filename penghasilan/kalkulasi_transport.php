<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/Gaji.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriodeCapegPKWT.php");
include_once("../WEB-INF/classes/base-gaji/ProsesGajiLock.php");
include_once("../WEB-INF/classes/base/AksesAppPenghasilan.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
$gaji = new Gaji();
$gaji_periode = new GajiPeriodeCapegPKWT();
$proses_gaji_lock = new ProsesGajiLock();
$akses_app_penghasilan = new AksesAppPenghasilan();
$jenis_pegawai = new JenisPegawai();


$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqDepartemen = httpFilterGet("reqDepartemen");
$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");

$gaji_periode->selectByParams(array(),-1,-1,"","ORDER BY GAJI_PERIODE_CAPEG_PKWT_ID DESC");
while($gaji_periode->nextRow())
{
	$arrPeriode[] = $gaji_periode->getField("PERIODE");	
}

if($reqDepartemen == "")
	$reqDepartemen = "";

if($reqPeriode == "")
	$reqPeriode = $arrPeriode[0];

if($reqJenisPegawaiId == "")
	$reqJenisPegawaiId = '1';
else
	$reqJenisPegawaiId = $reqJenisPegawaiId;

$akses_app_penghasilan->selectByParamsAksesMenu(array("LINK_FILE" => "gaji_organik.php", "AKSES_APP_PENGHASILAN_ID" => $userLogin->userAksesPenghasilan));
$akses_app_penghasilan->firstRow();
$akses = $akses_app_penghasilan->getField("AKSES");

$jenis_pegawai->selectByParams();


$tinggi = 179;
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
    @import "../WEB-INF/lib/media/css/dataTables.tableTools.css";
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


	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/media/css/dataTables.fixedColumns.css">
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/examples/resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/examples/resources/demo.css">
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/demo.js"></script>	
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>	
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.min.js"></script>	
	<script type="text/javascript" language="javascript" class="init">
	
    $(document).ready( function () {

		<?
		if($lock_proses == 1)
		{
		?>
		$('.toggle').css({"display":"none"});
		<?
		}
		?>
						
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
							 null												 								 
						],
			  "bSort":false,
			  "bProcessing": true,
			  "bServerSide": true,		
			  "sAjaxSource": "../json-gaji/kalkulasi_transport_json.php?reqPeriode=<?=$reqPeriode?>&reqDepartemen=<?=$reqDepartemen?>&reqJenisPegawaiId=<?=$reqJenisPegawaiId?>",						  
			  "scrollY": ($(window).height() - <?=$tinggi?>),
			  "scrollX": "100%",		
			  "sPaginationType": "full_numbers",
			  "sDom": '<"H"lTfr>t<"F"ip>',
			  "oTableTools": {
					"sSwfPath": "../WEB-INF/lib/media/swf/copy_csv_xls_pdf.swf",
					"aButtons": [
						{
			                "sExtends": "copy"
			            },
			            {
			                "sExtends": "xls"
			            },
			            {
			                "sExtends": "pdf"
			            },
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
					$("#example tr").removeClass('selected');
					$(".DTFC_Cloned tr").removeClass("selected");
					var row = $(this);
				    var rowIndex = row.index() + 1;
					
					if (row.parent().parent().hasClass("DTFC_Cloned")) {
						$("#example tr:nth-child(" + rowIndex + ")").addClass("selected");;
					} else {
						$(".DTFC_Cloned tr:nth-child(" + rowIndex + ")").addClass("selected");
					}
					
					row.addClass("selected");
					  //
					  var anSelected = fnGetSelected(oTable);													
					  anSelectedData = String(oTable.fnGetData(anSelected[0]));
					  var element = anSelectedData.split(','); 
					  anSelectedId = element[0];
			  });
			  
			  $("#reqPeriode").change(function() { 
				 
			  		oTable.fnReloadAjax("../json-gaji/kalkulasi_transport_json.php?reqJenisPegawaiId="+$("#reqJenisPegawai").val()+"&reqDepartemen="+$('#cc').combotree('getValue')+"&reqPeriode="+ $("#reqPeriode").val());

			  		// document.location.href = "gaji_organik.php?reqJenisPegawaiId="+$("#reqJenisPegawai").val()+"&reqDepartemen="+$('#cc').combotree('getValue')+"&reqPeriode="+ $("#reqPeriode").val();
			  });

			  $("#reqJenisPegawai").change(function() { 
			  		oTable.fnReloadAjax("../json-gaji/kalkulasi_transport_json.php?reqJenisPegawaiId="+$("#reqJenisPegawai").val()+"&reqDepartemen="+$('#cc').combotree('getValue')+"&reqPeriode="+ $("#reqPeriode").val());

			  		// document.location.href = "gaji_organik.php?reqJenisPegawaiId="+$("#reqJenisPegawai").val()+"&reqDepartemen="+$('#cc').combotree('getValue')+"&reqPeriode="+ $("#reqPeriode").val();
			  });
			  
			  $('#cc').combotree({
					onSelect: function(param){
						 oTable.fnReloadAjax("../json-gaji/kalkulasi_transport_json.php?reqJenisPegawaiId="+$("#reqJenisPegawai").val()+"&reqDepartemen="+param.id+"&reqPeriode="+ $("#reqPeriode").val());

						 // document.location.href = "gaji_organik.php?reqJenisPegawaiId="+$("#reqJenisPegawai").val()+"&reqDepartemen="+param.id+"&reqPeriode="+ $("#reqPeriode").val();
					}
			  });
		  	  
			  $('#btnReport').on('click', function () {
			  	newWindow = window.open('kalkulasi_transport_excel.php?reqJenisPegawaiId='+$("#reqJenisPegawai").val()+'&reqPeriode='+ $("#reqPeriode").val()+ '&reqDepartemen=<?=$reqDepartemen?>', 'Cetak');
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
			  
			  $('#btnKalkulasi').on('click', function () {
					$.messager.confirm('Konfirmasi',"Proses Kalkulasi Transport?",function(r){
						if (r){
							var win = $.messager.progress({
												title:'Proses Kalkulasi Transport',
												msg:'Proses data...'
											});
							var jqxhr = $.get("../json-gaji/proses_kalkulasi_transport_json.php?reqPeriode="+$("#reqPeriode").val(), function() {
								$.messager.progress('close');
							})
							.done(function() {
								$.messager.progress('close');
							oTable.fnReloadAjax("../json-gaji/kalkulasi_transport_json.php?reqPeriode="+$("#reqPeriode").val()+"&reqDepartemen="+$('#cc').combotree('getValue')+"&reqJenisPegawaiId="+$("#reqJenisPegawai").val());
								// getSummary($("#reqCabang").combobox("getValue"));
							})
							.fail(function() {
								alert( "error" );
								$.messager.progress('close');
							});								
						}
					});	
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

<!-- Flex Menu -->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/flexdropdown.css" />
<script type="text/javascript" src="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/jquery.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/flexdropdown.js"></script>
</head>
<body style="overflow:hidden">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Kalkulasi Transport</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
<!--         	<?
            if($akses == "A")
			{
			?>        
            <?php /*?> <li><a href="#" title="Baca" id="btnBacaRow"  class="toggle">&nbsp;Kalkulasi</a></li><?php */?>        
            <?
			}
			?> -->
            <li><a href="#" title="Kalkulasi" id="btnKalkulasi">&nbsp;Kalkulasi</a></li>
            <!--<li><a href="#" title="Lihat" id="btnLihat"  >&nbsp;Lihat</a></li>-->
            <li>
            <!--<a href="#" title="Cetak" id="btnCetak"  class="toggle">&nbsp;Cetak</a>                    
            <a href="#" title="Cetak" id="btnCetakBukuBesar"  class="toggle">&nbsp;Cetak Buku Besar</a>
            <a href="#" title="Cetak" id="btnCetakPotonganLain"  class="toggle">&nbsp;Cetak Potongan Lain</a>
            <a href="#" title="Cetak" id="btnDaftarPengantar"  class="toggle">&nbsp;Cetak Daftar Pengantar</a>
            <a href="#" title="Export Excel" id="btnEkspor"  class="toggle">&nbsp;Export Excel</a>-->
            <a href="#" id="btnReport" ="flexmenu1">Cetak</a>
            </li>
<!--             <li>
            <a href="#" data-flexmenu="flexmenu2">Export Excel</a>
            </li>   -->                       
            <?php /*?><li><a href="#" title="Baca" id="btnKirimJurnal"  class="toggle">&nbsp;Kirim Jurnal</a></li>  <?php */?>                  
        </ul>
        <!--HTML for Flex Drop Down Menu 1-->
    
    </div>
    <?
	//}
	?>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:6px; margin-left:180px; z-index:9999; font-size:12px;">
        Departemen : <input id="cc" class="easyui-combotree" name="reqDepartemen" data-options="url:'../json-simpeg/departemen_combo_json.php'" style="width:300px;" value="<?=$reqDepartemen?>">&nbsp;&nbsp;&nbsp;&nbsp;
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
 		Jenis Pegawai : <select name="reqJenisPegawai" id="reqJenisPegawai">
				    <option value="">Semua</option>  
        		  <?
                  while($jenis_pegawai->nextRow())
				  {
				  ?>
                  	<option value="<?=$jenis_pegawai->getField("JENIS_PEGAWAI_ID")?>" <? if($reqJenisPegawaiId == $jenis_pegawai->getField("JENIS_PEGAWAI_ID")) { ?> selected <? } ?>><?=$jenis_pegawai->getField("NAMA")?></option>
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
            <th>Id</th>
            <th width="100px">NRP</th> 
            <th width="205px">Nama</th> 
            <th width="200px">Jabatan</th>
            <th width="85px">Jumlah Hadir</th>
            <th width="200px">Tarif</th>
            <th width="200px">Total</th>
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