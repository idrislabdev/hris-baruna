<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/StatusPegawai.php");

$jenis_pegawai = new JenisPegawai();
$status_pegawai = new StatusPegawai();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
$tinggi = 155;

$reqDepartemen = httpFilterGet("reqDepartemen");

$reqJenisPegawai= httpFilterGet("reqJenisPegawai");
$reqKelompok= httpFilterGet("reqKelompok");
$reqStatusPegawai= httpFilterGet("reqStatusPegawai");

if($reqDepartemen == "")
	$reqDepartemen = "CAB1";

$jenis_pegawai->selectByParams();
$status_pegawai->selectByParams();

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
</style>

<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../WEB-INF/lib/media/js/complete.js"></script>
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
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
				document.location.href = "pegawai.php?reqDepartemen=" + newValue + "&reqKelompok="+ $("#reqKelompok").val() + "&reqJenisPegawai="+ $("#reqJenisPegawai").val() + "&reqStatusPegawai=" +$("#reqStatusPegawai").val(); 
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
		var oldStart = 0;
		
        var oTable = $('#example').dataTable({ bJQueryUI: true,"iDisplayLength": 50,
			  /* UNTUK MENGHIDE KOLOM ID */
			  "aoColumns": [ 
							 { bVisible:false },
							 null,
							 null,
							 null,
							 null,
							 null,
							 { bVisible:false },
							 { bVisible:false },
							 null,
							 null,
							 null,
							 null,
							 null,
							 null,
							 null,
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
			  "sAjaxSource": "../json-simpeg/pegawai_json.php?reqDepartemen=<?=$reqDepartemen?>&reqKelompok=<?=$reqKelompok?>&reqJenisPegawai=<?=$reqJenisPegawai?>&reqStatusPegawai=<?=$reqStatusPegawai?>",
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "3000px",/*"sScrollXInner": "300%",*/
			  "sPaginationType": "full_numbers",
			  /*"fnDrawCallback": function (o) {
					if ( o._iDisplayStart != oldStart ) {
						var targetOffset = $('#example').offset().top;
						//$('html,body').animate({scrollTop: targetOffset}, 500);
						$('html,body').animate({scrollTop: 0}, 500);
						//$('.dataTables_scrollBody').scrollTop(0);
						oldStart = o._iDisplayStart;
					}
				}*/
			  "fnDrawCallback": function(o) 
			  	{
                    $('.dataTables_scrollBody').scrollTop(0);
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
			  var anSelectedStatusPegawai = '';
			  var anSelectedNissKadet = '';
			  var anSelectedJenisPegawai = '';
			  
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
					  anSelectedNissKadet= element[element.length-3];
					  anSelectedStatusPegawai= element[element.length-2];
					  anSelectedJenisPegawai= element[element.length-1];
			  });
			  
			  $('#btnEdit').on('click', function () {
				  if(anSelectedData == "")
					  return false;
					if(anSelectedNissKadet == "")
					{
				  		window.parent.OpenDHTML('pegawai_add.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '880', '495');
					}
					else
					{
						window.parent.OpenDHTML('pegawai_kadet_add.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '880', '495');
					}
			  });
			  
			  $('#btnMutasi').on('click', function () {
				  if(anSelectedData == "")
					  return false;
				  if(anSelectedStatusPegawai == 1 || anSelectedStatusPegawai == 5)
					  window.parent.OpenDHTML('pegawai_add_mutasi.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '980', '400');
			 	  else
				  	  alert('Mutasi departemen berlaku untuk pegawai yang masih aktif.');
			  });
	
			  $('#btnMutasiKeluar').on('click', function () {
				  if(anSelectedData == "")
					  return false;
				  if(anSelectedStatusPegawai == 1 || anSelectedStatusPegawai == 5)
					  window.parent.OpenDHTML('pegawai_add_mutasi_keluar.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '980', '400');
			 	  else
				  	  alert('Mutasi keluar berlaku untuk pegawai yang masih aktif.');
					 
			  });
			  

			  $('#btnMutasiMasuk').on('click', function () {
				  if(anSelectedData == "")
					  return false;
				  if(anSelectedStatusPegawai == 3)
					  window.parent.OpenDHTML('pegawai_add_mutasi_masuk.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '980', '400');
			 	  else
				  	  alert('Mutasi masuk berlaku untuk pegawai dengan status mutasi keluar.');
					 
			  });

			  $('#btnPerpanjanganKontrak').on('click', function () {
				  if(anSelectedData == "")
					  return false;
				  if(anSelectedJenisPegawai == 3)
					  window.parent.OpenDHTML('pegawai_add_perpanjangan_kontrak.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '980', '400');
			 	  else
				  	  alert('Perpanjangan Kontrak hanya berlaku untuk jenis pegawai PKWT.');
					 
			  });
			  
			  $('#btnKenaikanJabatan').on('click', function () {
				  if(anSelectedData == "")
					  return false;
			      
				  if(anSelectedStatusPegawai == 1 || anSelectedStatusPegawai == 5)
					  window.parent.OpenDHTML('pegawai_add_usulan_kenaikan_jabatan.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '980', '400');
			 	  else
				  	  alert('Kenaikan jabatan berlaku untuk pegawai yang masih aktif.');
				  //window.parent.OpenDHTML('pegawai_add_usulan_kenaikan_jabatan_realisasi.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '980', '400');
				  
			  });

			  $('#btnPensiun').on('click', function () {
				  if(anSelectedData == "")
					  return false;
			      
				  if(anSelectedStatusPegawai == 1 || anSelectedStatusPegawai == 5)
					  window.parent.OpenDHTML('pegawai_add_pensiun.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '980', '400');
			 	  else
				  	  alert('Pensiun berlaku untuk pegawai yang masih aktif.');
				  //window.parent.OpenDHTML('pegawai_add_usulan_kenaikan_jabatan_realisasi.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '980', '400');
				  
			  });

			  $('#btnPerubahanJenisPegawai').on('click', function () {
				  if(anSelectedData == "")
					  return false;
				  
				  window.parent.OpenDHTML('pegawai_add_perubahan_jenis_pegawai.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '880', '495');
			  });			  
			  
			  
			  $('#btnMpp').on('click', function () {
				  if(anSelectedData == "")
					  return false;
				  if(anSelectedStatusPegawai == 1)
				  {
					  window.parent.OpenDHTML('pegawai_add_mpp.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '880', '495');
				  }
				  else
				  	  alert('Perubahan status MPP berlaku untuk pegawai yang masih aktif.');
				  /*
				  if ( confirm( "Apakah anda yakin, mengubah status pegawai menjadi MPP ?" ) ) 
				  {
					$.getJSON('../json-simpeg/pegawai_json_set_mpp.php?reqId='+anSelectedId, function (data) 
					{
						$.each(data, function (i, SingleElement) {
						});
					});
					
					window.parent.OpenDHTML('pegawai_add_mpp.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '880', '495');
					oTable.fnDraw(oTable.fnSettings());
					oTable.fnDraw(oTable.fnSettings());
					oTable.fnDraw(oTable.fnSettings());
				 }
				 */
				  
			  });
			  
			  $('#btnCV').on('click', function () {
				  if(anSelectedData == "")
					  return false;
				  
				  newWindow = window.open('pegawai_data_cv_excel.php?reqId='+ anSelectedId, 'Cetak');
				  newWindow.focus();
				  
			  });
			  
			  //TEMPLATE IMPORT DATA 
			  $('#btnImportPerjenjanganTemplate').on('click', function () {
				  /*if(anSelectedData == "")
					  return false;	*/
				 newWindow = window.open('import_pendidikan_perjenjangan_template_excel.php?reqId='+anSelectedId, 'Template');
				 newWindow.focus();
				  
			  });
			  
			  $('#btnImportSubstansialTemplate').on('click', function () {
				  /*if(anSelectedData == "")
					  return false;	*/
				 newWindow = window.open('import_pendidikan_substansial_template_excel.php?reqId='+anSelectedId, 'Template');
				 newWindow.focus();
				  
			  });	
			  
			  $('#btnImportPendidikanTemplate').on('click', function () {
				  /*if(anSelectedData == "")
					  return false;	*/
				 newWindow = window.open('import_pendidikan_template_excel.php?reqId='+anSelectedId, 'Template');
				 newWindow.focus();
				  
			  });
			  
			  $('#btnImportStatusTemplate').on('click', function () {
				  /*if(anSelectedData == "")
					  return false;	*/
				 newWindow = window.open('import_status_nikah_template_excel.php?reqId='+anSelectedId, 'Template');
				 newWindow.focus();
				  
			  });
			  
			  $('#btnImportKeluargaTemplate').on('click', function () {
				  /*if(anSelectedData == "")
					  return false;	*/
				 newWindow = window.open('import_keluarga_template_excel.php?reqId='+anSelectedId, 'Template');
				 newWindow.focus();
				  
			  });
			  
			  $('#btnImportSertifikatTemplate').on('click', function () {
				  /*if(anSelectedData == "")
					  return false;	*/
				 newWindow = window.open('import_sertifikat_template_excel.php?reqId='+anSelectedId, 'Template');
				 newWindow.focus();
				  
			  });
			  
			  
			  //IMPORT DATA
			  $('#btnImportPerjenjanganData').on('click', function () {
				  window.parent.OpenDHTML('import_data_pendidikan_perjenjangan.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '480', '175');
			  });
			  
			  
			  $('#btnImportSubstansialData').on('click', function () {
				  window.parent.OpenDHTML('import_data_pendidikan_substansial.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '480', '175');
			  });
			  
			  
			  $('#btnImportPendidikanData').on('click', function () {
				  window.parent.OpenDHTML('import_data_pendidikan.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '480', '175');
			  });
			  
			  $('#btnImportStatusData').on('click', function () {
				  window.parent.OpenDHTML('import_data_status_nikah.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '480', '175');
			  });
			  
			  $('#btnImportKeluargaData').on('click', function () {
				  window.parent.OpenDHTML('import_data_keluarga.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '480', '175');
			  });			  
			  
			  $('#btnImportSertifikatData').on('click', function () {
				  window.parent.OpenDHTML('import_data_sertifikat.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '480', '175');
			  });
			  	
			  			   
			  //EKSPOR
			  $('#btnEkspor').on('click', function () {
				  /*if(anSelectedData == "")
					  return false;	*/			
				  
				  newWindow = window.open('pegawai_data_excel.php?reqDepartemen=<?=$reqDepartemen?>&reqKelompok=' + $("#reqKelompok").val() + '&reqJenisPegawai='+ $("#reqJenisPegawai").val() + '&reqStatusPegawai='+ $("#reqStatusPegawai").val(), 'Cetak');
				  newWindow.focus();
				  
			  });
			  
			  $('#btnEksporKeluargaPegawai').on('click', function () {	
				  newWindow = window.open('pegawai_data_keluarga_excel.php?reqDepartemen=<?=$reqDepartemen?>&reqKelompok=' + $("#reqKelompok").val() + '&reqJenisPegawai='+ $("#reqJenisPegawai").val() + '&reqStatusPegawai='+ $("#reqStatusPegawai").val(), 'Cetak');
				  newWindow.focus();
				  
			  });			  
			  
			  $("#reqJenisPegawai").change(function() { 
				 refreshfnHide();
				 oTable.fnReloadAjax("../json-simpeg/pegawai_json.php?reqDepartemen=<?=$reqDepartemen?>&reqKelompok="+ $("#reqKelompok").val() + "&reqJenisPegawai="+ $("#reqJenisPegawai").val() + "&reqStatusPegawai=" +$("#reqStatusPegawai").val());				 	 
			  });
			  					  
			  $("#reqStatusPegawai").change(function() { 
			     refreshfnHide();
				 oTable.fnReloadAjax("../json-simpeg/pegawai_json.php?reqDepartemen=<?=$reqDepartemen?>&reqKelompok="+ $("#reqKelompok").val() + "&reqJenisPegawai="+ $("#reqJenisPegawai").val() + "&reqStatusPegawai=" +$("#reqStatusPegawai").val());				 	 
			  });
			  
			  $("#reqKelompok").change(function() { 
				 refreshfnHide();
				 oTable.fnReloadAjax("../json-simpeg/pegawai_json.php?reqDepartemen=<?=$reqDepartemen?>&reqKelompok="+ $("#reqKelompok").val() + "&reqJenisPegawai="+ $("#reqJenisPegawai").val() + "&reqStatusPegawai=" +$("#reqStatusPegawai").val());				 	 
			  });
			  
			  function refreshfnHide()
			  {
				fnHide(6);
				fnHide(7);
				 
				if($("#reqJenisPegawai").val() == 3)
				{
					fnShow(6);
					fnShow(7);
				}
			  }
			
			  <? 
			  if($reqJenisPegawai == '3')
			  {
			  ?>
				  fnShow(6);
				  fnShow(7);
			  <?
			  }
			  ?>
			  
			  function fnHide( iCol )
			  {
				/* Get the DataTables object again - this is not a recreation, just a get of the object */
				var oTable = $('#example').dataTable();
				var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
				oTable.fnSetColumnVis( iCol,false);
			  }
			  function fnShow( iCol )
			  {
				/* Get the DataTables object again - this is not a recreation, just a get of the object */
				var oTable = $('#example').dataTable();
				
				var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
				oTable.fnSetColumnVis( iCol, true );
			  }
			  
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
					  $('.vmenu').hide();
					  $('.overlay').hide();
				  }
			   });
			   
			   $('.vmenu .inner_li span').on('click',function() {												
					  if($(this).text() == 'Aktif')
					  {
						  $.getJSON('../json-intranet/pegawai_set_status.php?reqId='+anSelectedId+'&reqNilai=1', function (data) 
						  {
							  $.each(data, function (i, SingleElement) {
							  });
						  });									
						  oTable.fnUpdate('Aktif', anSelectedPosition, 5, false);
					  }
					  else if($(this).text() == 'Non-Aktif')
					  {
						  $.getJSON('../json-intranet/pegawai_set_status.php?reqId='+anSelectedId+'&reqNilai=0', function (data) 
						  {
							  $.each(data, function (i, SingleElement) {
								  
							  });
						  });									
						  oTable.fnUpdate('Non-Aktif', anSelectedPosition, 5, false);
					  }
					  $('.vmenu').hide();
					  $('.overlay').hide();
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
	
	label {
	font-size: 12px;
  }
	  
</style>
<!--RIGHT CLICK EVENT-->		

<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 

<!-- CSS for Drop Down Tabs Menu #2 -->
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  
<link href="../WEB-INF/css/bluetabs.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../WEB-INF/css/dropdowntabs.js"></script>
<script language="JavaScript" src="../jslib/displayElement.js"></script>  

<!-- Flex Menu -->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/flexdropdown.css" />
<script type="text/javascript" src="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/jquery.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/flexdropdown.js"></script> 

</head>
<body style="overflow:hidden" onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Master Pegawai</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            
            </li>
        </ul>
    </div>
    <?
	//}
	?>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:6px; margin-left:180px; z-index:9999; font-size:12px;">
    	Status : <select name="reqStatusPegawai" id="reqStatusPegawai">
        				<?
                        while($status_pegawai->nextRow())
						{
						?>
                        	<option value="<?=$status_pegawai->getField("STATUS_PEGAWAI_ID")?>"><?=$status_pegawai->getField("NAMA")?></option>	
						<?	
						}
						?>
                        </select>&nbsp;&nbsp;
    	Jenis : <select name="reqJenisPegawai" id="reqJenisPegawai" style="width:100px;">
        					<option value="">Semua</option>
        				<?
                        while($jenis_pegawai->nextRow())
						{
						?>
                        	<option value="<?=$jenis_pegawai->getField("JENIS_PEGAWAI_ID")?>"><?=$jenis_pegawai->getField("NAMA")?></option>	
						<?	
						}
						?>
                        </select>&nbsp;&nbsp;
		Kelompok : <select name="reqKelompok" id="reqKelompok">
					<option value="">Semua</option>
					<option value="D">Darat</option>
					<option value="K">Kapal</option>
				   </select>&nbsp;&nbsp;
        Departemen : <input id="cc" class="easyui-combotree" name="reqDepartemen" data-options="url:'../json-simpeg/departemen_combo_json.php'" style="width:180px;">&nbsp;&nbsp;
    </div>
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Id</th>
            <th width="50px">NRP</th> 
            <th width="50px">NIPP</th>
            <th width="130px">Nama</th> 
            <th width="130px">Jabatan</th>
			<th width="30px">Kelas</th>
			<th width="100px">Kontrak Awal</th>
            <th width="100px">Kontrak Akhir</th>
            <th width="20px">MKP</th>
            <th width="180px">Departemen</th>
            <th width="60px">Agama</th> 
            <th width="40px">L / P</th> 
            <th width="90px">Tanggal Lahir</th>
            <th width="60px">Zodiac</th>
            <th width="70px">Status Kawin</th> 
            <th width="80px">Status Pegawai</th> 
            <th width="60px">Gol. Darah</th> 
            <th width="180px">Alamat</th> 
            <th width="50px">Telepon</th>
            <th width="50px">Email</th>
            <th width="130px">Hobby</th>
        </tr>
    </thead>
    </table>
    </div>   
</div>
</body>
</html>