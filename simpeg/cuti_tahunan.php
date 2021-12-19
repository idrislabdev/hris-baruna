<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriodeTahun.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");
include_once("../WEB-INF/classes/base-gaji/ProsesGajiLock.php");
include_once("../WEB-INF/classes/base/AksesAppPenghasilan.php");


/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
$tinggi = 155;

$gaji_periode_tahun = new GajiPeriodeTahun();
$jenis_pegawai = new JenisPegawai();
$proses_gaji_lock = new ProsesGajiLock();
$akses_app_penghasilan = new AksesAppPenghasilan();

$gaji_periode_tahun->selectByParams(array(),-1,-1,"","ORDER BY GAJI_PERIODE_TAHUN_ID DESC");
while($gaji_periode_tahun->nextRow())
{
	$arrPeriode[] = $gaji_periode_tahun->getField("PERIODE");	
}

if($reqPeriode == "")
	$reqPeriode = $arrPeriode[0];

$lock_proses = $proses_gaji_lock->getProsesGajiLock(array("PERIODE" => $reqPeriode, "JENIS_PROSES" => "GAJI_CUTI_TAHUNAN"));


$jenis_pegawai->selectByParams();

$akses_app_penghasilan->selectByParamsAksesMenu(array("LINK_FILE" => "cuti_tahunan.php", "AKSES_APP_PENGHASILAN_ID" => $userLogin->userAksesPenghasilan));
$akses_app_penghasilan->firstRow();
$akses = $akses_app_penghasilan->getField("AKSES");

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Cuti Tahunan</title>
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
		  //console.log($(window).height());
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
							 null,
							 null,
							 null,
							 null,
							 { bVisible:false },
							 { bVisible:false }
						],
			  "sDom": '<"H"lTfr>t<"F"ip>',
			  "oTableTools": {
					"sSwfPath": "../WEB-INF/lib/media/swf/copy_csv_xls_pdf.swf",
					"aButtons": [
						{
			                "sExtends": "copy",
			                "mColumns": [2, 3, 4, 5, 6, 9, 10, 11]
			            },
			            {
			                "sExtends": "xls",
			                "mColumns": [2, 3, 4, 5, 6, 9, 10, 11]
			            },
			            {
			                "sExtends": "pdf",
			                "mColumns": [2, 3, 4, 5, 6, 9, 10, 11]
			            },
					]
				},
			  "bSort":true,
			  "bProcessing": true,
			  "bServerSide": true,		
			  "sAjaxSource": "../json-simpeg/cuti_tahunan_json.php?reqPeriode=<?=$reqPeriode?>&reqStatusProses=BELUM",
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "100%",
			  "sPaginationType": "full_numbers"
			  });

			  $("#reqJenisPegawai").change(function() { 
				 oTable.fnReloadAjax("../json-simpeg/cuti_tahunan_json.php?reqPeriode=" + $("#reqPeriode").val() + "&reqJenisPegawai="+ $("#reqJenisPegawai").val() + "&reqStatusProses="+ $("#reqStatusProses").val());
			  });

			  $("#reqStatusProses").change(function() { 			  		
				 oTable.fnReloadAjax("../json-simpeg/cuti_tahunan_json.php?reqPeriode=" + $("#reqPeriode").val() + "&reqJenisPegawai="+ $("#reqJenisPegawai").val() + "&reqStatusProses="+ $("#reqStatusProses").val());
			  });
			  			  
			  $('#btnEkspor').on('click', function () {
				  /*if(anSelectedData == "")
					  return false;	*/			
				  
				  newWindow = window.open('cuti_tahunan_excel.php?reqPeriode='+ $("#reqPeriode").val() + '&reqJenisPegawai='+ $("#reqJenisPegawai").val(), 'Cetak');
				  newWindow.focus();
				  
			  });	
			  
			 
			  $('#btnCetakPerbantuan').on('click', function () {
			  	newWindow = window.open('cuti_tahunan_rpt.php?reqJenisPegawaiId=2&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			  });			  

			  $('#btnCetakOrganik').on('click', function () {
			  	newWindow = window.open('cuti_tahunan_rpt.php?reqJenisPegawaiId=1&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			  });			  

			  $('#btnCetakCapeg').on('click', function () {
			  	newWindow = window.open('cuti_tahunan_rpt.php?reqJenisPegawaiId=5&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			  });			  

			  $('#btnCetakPKWT').on('click', function () {
			  	newWindow = window.open('cuti_tahunan_rpt.php?reqJenisPegawaiId=3&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			  });			  

			  $('#btnRekapitulasi').on('click', function () {
			  	/*newWindow = window.open('cuti_tahunan_rekap_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();*/
				window.parent.OpenDHTML('report_penanda_tangan.php?reqMode=REKAP_UANG_TRANSPORT&reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Penghasilan', '600', '300');
			  });			  

			  $('#btnCetakAwakKapal').on('click', function () {
			  	newWindow = window.open('cuti_tahunan_awak_kapal_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			  });
			  
			  $('#btnCetakDaftarPengantar').on('click', function () {
			  	newWindow = window.open('cuti_tahunan_pengantar_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			  });			  
			  
			  $("#reqPeriode").change(function() { 
				 if($("#reqPeriode").val() == '<?=$arrPeriode[0]?>' && '<?=$lock_proses?>' == '0')
				 	 $('.toggle').css({"display":"inline"});
				 else
				 	 $('.toggle').css({"display":"none"});
				
				 oTable.fnReloadAjax("../json-simpeg/cuti_tahunan_json.php?reqPeriode=" + $("#reqPeriode").val() + "&reqJenisPegawai="+ $("#reqJenisPegawai").val());
				 	 
			  });

			  $('#btnProses').on('click', function () {
				 oTable.fnReloadAjax("../json-simpeg/cuti_tahunan_json.php?reqMode=proses&reqPeriode=" + $("#reqPeriode").val() + "&reqJenisPegawai="+ $("#reqJenisPegawai").val());
			  });

			  $('#btnKirimJurnal').on('click', function () {
			  	  if(confirm('Kirim jurnal dan kunci proses bulan terpilih?'))
				  {
					$.getJSON("../json-simpeg/proses_gaji_set_lock.php?reqJenisProses=GAJI_CUTI_TAHUNAN&reqPeriode="+ $("#reqPeriode").val(),
					function(data){
					});	
				  }
				  alert('Proses di bulan terpilih telah di kunci.');
				  $('.toggle').css({"display":"none"});
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
		  
			  /* $('#example tbody').on( 'click', 'tr', function () {
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
					}
					else {
						oTable.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
					}
					
					var anSelected = fnGetSelected(oTable);													
					anSelectedData = String(oTable.fnGetData(anSelected[0]));
					var element = anSelectedData.split(','); 
					anSelectedId = element[0];
			  });*/
			  
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
					  anSelectedId = element[1];
					  anSelectedData = element[0];
			  });
			  

			  $('#btnCetakPermohonan').on('click', function () {
				  /*if(anSelectedData == "")
					  return false;	*/			
				  	
							window.parent.OpenDHTML('cuti_tahunan_cetak_sp.php', 'Office Management - Aplikasi Kepegawaian', '880', '495');			  
			  });	

			  $('#btnCetakUlang').on('click', function () {
				 if(anSelectedData == "")
					  return false;	
					  newWindow = window.open('cuti_tahunan_cetak_sp_cetak.php?reqId='+anSelectedData, 'Cetak');
				     newWindow.focus();			  
			  });				  
			  
			   $('#btnEdit').on('click', function () {
				  if(anSelectedData == "")
					  return false;
							window.parent.OpenDHTML('cuti_tahunan_edit.php?reqMode=update&reqId='+anSelectedData + '&reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Kepegawaian', '880', '495');
				});	
				
			   $('#btnDeleteRow').on('click', function () {
				if(anSelectedData == "")
					return false;
				if ( confirm( "Apakah anda yakin, menghapus data ini ?" ) ) {
					$.getJSON('../json-simpeg/delete.php?reqMode=cuti_tahunan&id='+anSelectedId, function (data) 
					{
						$.each(data, function (i, SingleElement) {
						});
					});
					
					oTable.fnDraw(oTable.fnSettings());
					oTable.fnDraw(oTable.fnSettings());
					oTable.fnDraw(oTable.fnSettings());
				}
			  });

			   $('#btnAdd').on('click', function () {
					window.parent.OpenDHTML('cuti_tahunan_add.php?reqMode=insert&reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Kepegawaian', '880', '495');
				});	

			   $('#btnExport').on('click', function () {
					window.parent.OpenDHTML('cuti_tahunan_export.php?reqPeriode='+ $("#reqPeriode").val(), 'Office Management - Aplikasi Kepegawaian', '880', '495');
				});	
								
			  /*$('#btnHapus').on('click', function () {
				if(anSelectedData == "")
					return false;
				if ( confirm( "Apakah anda yakin, menghapus data ini ?" ) ) {
					$.getJSON('../json-simpeg/delete.php?reqMode=cuti_tahunan&reqId='+anSelectedData, function (data) 
					{
						$.each(data, function (i, SingleElement) {
						});
					});
					
					oTable.fnDraw(oTable.fnSettings());
					oTable.fnDraw(oTable.fnSettings());
					oTable.fnDraw(oTable.fnSettings());
				}
			  });	*/		  
			  
			  
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
<body style="overflow:hidden" > <!-- onLoad="setValue();" -->
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Cuti Tahunan</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" id="btnAdd" title="Tambah">Tambah</a>
            <a href="#" id="btnEdit" title="Edit">Ubah</a>
            <a href="#" id="btnDeleteRow" title="Hapus">Hapus</a>
            </li>
            <li><a href="#" title="Cetak Permohonan" id="btnCetakPermohonan">&nbsp;Cetak</a></li>
            <li><a href="#" title="Cetak Permohonan" id="btnCetakUlang">&nbsp;Cetak Ulang</a></li>
                       
           <?php /*?> <?
            if($akses == "A")
			{
			?>          
            <li><a href="#" title="Baca" id="btnProses"  class="toggle">&nbsp;Kalkulasi</a></li>
            <?
			}
			?><?php */?>
           <?php /*?> <li><a href="#" title="Cetak" id="btnCetak" data-flexmenu="flexmenu1">&nbsp;Cetak</a>
            </li>
			<li><a href="#" title="Ekspor" id="btnEkspor">&nbsp;Export Excel</a></li><?php */?>

        </ul>
        <ul id="flexmenu1" class="flexdropdownmenu">
          <li><a href="#" id="btnCetakPerbantuan">Perbantuan</a></li>
          <li><a href="#" id="btnCetakOrganik">Organik</a></li>
          <li><a href="#" id="btnCetakCapeg">Capeg</a></li>
          <li><a href="#" id="btnCetakPKWT">PKWT</a></li>       
          <li><a href="#" id="btnCetakDaftarPengantar">Daftar Pengantar</a></li>     
		  <li><a href="#" id="btnRekapitulasi">Rekapitulasi</a></li>  		  
        </ul>
    </div>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:7px; margin-left:174px; z-index:9999; font-size:12px;">
 		Periode : <select name="reqPeriode" id="reqPeriode">
        		  <?
                  for($i=0;$i<count($arrPeriode);$i++)
				  {
				  ?>
                  	<option value="<?=$arrPeriode[$i]?>" <? if($reqPeriode == $arrPeriode[$i]) { ?> selected <? } ?>><?=$arrPeriode[$i]?></option>
                  <?	  
				  }
				  ?>
        		  </select>&nbsp;&nbsp;
 		Jenis Pegawai : <select name="reqJenisPegawai" id="reqJenisPegawai">
				   <option value="">Semua</option> 
        		  <?
                  while($jenis_pegawai->nextRow())
				  {
				  ?>
                  	<option value="<?=$jenis_pegawai->getField("JENIS_PEGAWAI_ID")?>" <? if($reqJenisPegawai == $jenis_pegawai->getField("JENIS_PEGAWAI_ID")) { ?> selected <? } ?>><?=$jenis_pegawai->getField("NAMA")?></option>
                  <?	  
				  }
				  ?>
        		  </select>    &nbsp;&nbsp;
         Status Proses : <select name="reqStatusProses" id="reqStatusProses">
         		<option value="BELUM">Belum Proses</option>              
         		<option value="SUDAH">Sudah Proses</option>         
         		<option value="BERHAK_CUTI">Belum Mengajukan</option>
         		<option value="">Semua</option>              
				</select>
    </div>
    </div>      
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th width="85px">id</th>
            <th width="85px">reqId</th>
            <th width="85px">NRP</th>
            <th width="85px">Nama</th>
            <th width="85px">Departemen</th>
            <th width="85px">Lama Cuti</th>
            <th width="85px">Tanggal SP Terakhir</th>
            <th width="85px">Uang Cuti</th>
            <th width="85px">PPH</th>
            <th width="85px">LANGSUNG</th>
            <th width="85px">Uang Cuti</th>
            <th width="85px">PPH</th>
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