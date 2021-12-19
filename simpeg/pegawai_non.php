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
<link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">

<style type="text/css" media="screen">
    @import "../WEB-INF/lib/media/css/site_jui.css";
    @import "../WEB-INF/lib/media/css/demo_table_jui.css";
    @import "../WEB-INF/lib/media/css/themes/base/jquery-ui.css";;
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
				//document.location.href = "pegawai.php?reqDepartemen=" + newValue + "&reqKelompok="+ $("#reqKelompok").val() + "&reqJenisPegawai="+ $("#reqJenisPegawai").val() + "&reqStatusPegawai=" +$("#reqStatusPegawai").val(); 
			document.location.href = "pegawai_non.php?reqDepartemen=" + newValue;
			}
	};
</script>

	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/examples/resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/examples/resources/demo.css">
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/examples/resources/demo.js"></script>	
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>	
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/extensions/TableTools/js/dataTables.tableTools.min.js"></script>	
	<script type="text/javascript" language="javascript" class="init">
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
							 null,
							 null,
							 null												 								 
						],
			  "bSort":true,
			  "bProcessing": true,
			  "bServerSide": true,		
			  "sAjaxSource": "../json-simpeg/pegawai_non_json.php?reqDepartemen=<?=$reqDepartemen?>",
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "120%",
			  "sPaginationType": "full_numbers",
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
						window.parent.OpenDHTML('pegawai_non_add.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '880', '495');
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
			  
			  $('#btnEkspor').on('click', function () {
				  /*if(anSelectedData == "")
					  return false;	*/			
				  
				  newWindow = window.open('pegawai_data_excel.php?reqDepartemen=<?=$reqDepartemen?>&reqKelompok=' + $("#reqKelompok").val() + '&reqJenisPegawai='+ $("#reqJenisPegawai").val() + '&reqStatusPegawai='+ $("#reqStatusPegawai").val(), 'Cetak');
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
					  else if($(this).children().text() == 'Mutasi')
					  {
						  $("#btnMutasi").click();
					  }
					  else if($(this).children().text() == 'MPP')
					  {
						  $("#btnMpp").click();
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
                <span><img src="../WEB-INF/images/panah-judul.png">Data Non Pegawai</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" id="btnAdd" onClick="window.parent.OpenDHTML('pegawai_non_add.php', 'Office Management - Aplikasi Kepegawaian', '880', '495');" title="Tambah">Tambah</a>
            <a href="#" id="btnEdit" title="Edit">Ubah</a> </li>
          <?php /*?>  <li>
            <a href="#" title="Proses" id="btnProses" data-flexmenu="flexmenu1">&nbsp;Proses</a>
            </li>
            <li>
            <a href="#" title="Ekspor" id="btnEkspor">&nbsp;Export Excel</a>
			<a href="#" title="Ekspor" id="btnCV">&nbsp;Curriculum Vitae</a>
            </li><?php */?>
        </ul>
        <ul id="flexmenu1" class="flexdropdownmenu">
          <li><a href="#" id="btnPerubahanJenisPegawai">Perubahan Jenis Pegawai</a></li>
          <li><a href="#" id="btnMutasiKeluar">Mutasi Keluar</a></li>
          <li><a href="#" id="btnMutasiMasuk">Mutasi Masuk</a></li>
          <li><a href="#" id="btnMutasi">Mutasi Internal</a></li>
          <li><a href="#" id="btnKenaikanJabatan">Promosi (Usulan)</a></li>
          <li><a href="#" id="btnMpp">MPP</a></li>
          <li><a href="#" id="btnPensiun">Pensiun</a></li>
          <li><a href="#" id="btnPerpanjanganKontrak">Perpanjangan Kontrak PKWT</a></li>          
        </ul> 
        
        <ul id="flexmenu2" class="flexdropdownmenu">
          <li><a href="#" onClick="window.parent.OpenDHTML('pegawai_add.php', 'Office Management - Aplikasi Kepegawaian', '880', '495');" id="btnPegawai">Pegawai</a></li>
          <li><a href="#" onClick="window.parent.OpenDHTML('pegawai_non_add.php', 'Office Management - Aplikasi Kepegawaian', '880', '495');" id="btnPegawaiKadet">Siswa Magang</a></li>
        </ul>
      
    </div>
    <?
	//}
	?>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:6px; margin-left:178px; z-index:9999; font-size:12px;">
    	<?php /*?>Status : <select name="reqStatusPegawai" id="reqStatusPegawai">
        				<?
                        while($status_pegawai->nextRow())
						{
						?>
                        	<option value="<?=$status_pegawai->getField("STATUS_PEGAWAI_ID")?>" <? if($reqStatusPegawai == $status_pegawai->getField("STATUS_PEGAWAI_ID")) echo "selected";?>><?=$status_pegawai->getField("NAMA")?></option>	
						<?	
						}
						?>
                        </select>&nbsp;&nbsp;
    	Jenis : <select name="reqJenisPegawai" id="reqJenisPegawai">
        					<option value="">Semua</option>
        				<?
                        while($jenis_pegawai->nextRow())
						{
						?>
                        	<option value="<?=$jenis_pegawai->getField("JENIS_PEGAWAI_ID")?>" <? if($reqJenisPegawai == $jenis_pegawai->getField("JENIS_PEGAWAI_ID")) echo "selected";?>><?=$jenis_pegawai->getField("NAMA")?></option>	
						<?	
						}
						?>
                        </select>&nbsp;&nbsp;
		Kelompok : <select name="reqKelompok" id="reqKelompok">
					<option value="">Semua</option>
					<option value="D" <? if($reqKelompok == "D") echo "selected";?>>Darat</option>
					<option value="K" <? if($reqKelompok == "K") echo "selected";?>>Kapal</option>
				   </select>&nbsp;&nbsp;<?php */?>
         
        Departemen : <input id="cc" class="easyui-combotree" name="reqDepartemen" data-options="url:'../json-simpeg/departemen_combo_json.php'" style="width:200px;" value="<?=$reqDepartemen?>">&nbsp;&nbsp;
    </div>
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Id</th>
            <th width="85px">NIP</th>
            <th width="150px">Nama</th>       
            <th width="90px">Agama</th>
            <th width="60px">L/P</th>
            <th width="70px">Tempat Lahir</th> 
            <th width="70px">Tanggal Lahir</th> 
            <th width="100px">Jenis Pegawai</th>         
            <th width="200px">Unit Kerja</th>
            
        </tr>
    </thead>
    </table>
    </div>    
        <!--RIGHT CLICK EVENT -->
        <div class="vmenu">
            <div class="first_li"><span>Ubah</span></div>
            <div class="first_li"><span>Mutasi</span></div>
            <div class="first_li"><span>MPP</span></div>
            <div class="first_li"><span>Hapus</span></div>
            <!--<div class="first_li"><span>Status</span>
                <div class="inner_li">
                    <span>Aktif</span> 
                    <span>Non-Aktif</span>
                </div>
            </div>-->
        </div>
        <!--RIGHT CLICK EVENT -->
    
</div>
</body>
</html>