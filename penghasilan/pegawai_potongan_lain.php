<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriode.php");
include_once("../WEB-INF/classes/base-gaji/ProsesGajiLock.php");

$jenis_pegawai = new JenisPegawai();
$gaji_periode = new GajiPeriode();
$proses_gaji_lock = new ProsesGajiLock();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
$tinggi = 155;

$reqDepartemen = httpFilterGet("reqDepartemen");

if($reqDepartemen == "")
	$reqDepartemen = "CAB1"; //$userLogin->idDepartemen;

$jenis_pegawai->selectByParams();
//echo $reqDepartemen.'---';

$reqPeriode = $gaji_periode->getPeriodeMax(array());

$lock_proses = $proses_gaji_lock->getProsesGajiLock(array("PERIODE" => $reqPeriode, "JENIS_PROSES" => "DAFTAR_POTONGAN"));

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

	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/DataTables-1.10.6/media/css/jquery.dataTables.css">
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
							 { bVisible:false },
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
			  "sAjaxSource": "../json-gaji/pegawai_potongan_lain_json.php?reqDepartemen=<?=$reqDepartemen?>",
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
			  var anSelectedKelas = '';
			  var anSelectedJenisPegawaiId = '';
			  var anSelectedPosition = '';			  
			  var anSelectedKelompok = '';
			  
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
					  anSelectedKelas = element[1];
					  anSelectedJenisPegawaiId = element[2];
					  anSelectedKelompok = element[3];
			  });
			  
			  $('#btnEdit').on('click', function () {
				  if(anSelectedData == "")
					  return false;				
				  window.parent.OpenDHTML('pegawai_potongan_lain_add.php?reqMode=insert&reqId='+anSelectedId, 'Office Management - Aplikasi Penghasilan', '1000', '515');	
			  });
			  
			  $('#btnEditPotongan').on('click', function () {
				  if(anSelectedData == "")
					  return false;			
				  /*if(anSelectedJenisPegawaiId == 3 || anSelectedJenisPegawaiId == 4)
				  {
					  alert('Potongan hanya berlaku untuk pegawai Perbantuan dan Organik.');
					  return false;
				  }	*/  	
				  window.parent.OpenDHTML('pegawai_potongan_add.php?reqMode=insert&reqId='+anSelectedId+'&reqJenisPegawaiId='+anSelectedJenisPegawaiId+'&reqKelas='+anSelectedKelas, 'Office Management - Aplikasi Penghasilan', '980', '515');	
			  });	
			  
			  $('#cc').combotree({
					onSelect: function(param){ 
			  			oTable.fnReloadAjax("../json-gaji/pegawai_potongan_lain_json.php?reqDepartemen="+param.id+"&reqJenisPegawai="+ $("#reqJenisPegawai").val());
					}
			  });	
			  
			  $("#reqJenisPegawai").change(function() { 
					oTable.fnReloadAjax("../json-gaji/pegawai_potongan_lain_json.php?reqDepartemen="+$('#cc').combotree('getValue')+"&reqJenisPegawai="+ $("#reqJenisPegawai").val());
			  });	
			  			  	
			  
			  $('#btnEditAsuransi').on('click', function () {
				  if(anSelectedData == "")
					  return false;			
				  if(anSelectedJenisPegawaiId == 2)
				  {
					  window.parent.OpenDHTML('asuransi_pegawai_add.php?reqMode=insert&reqId='+anSelectedId+'&reqJenisPegawaiId='+anSelectedJenisPegawaiId+'&reqKelas='+anSelectedKelas, 'Office Management - Aplikasi Penghasilan', '980', '515');	
				  }
				  else
				  {
					  alert('Potongan hanya berlaku untuk pegawai Perbantuan.');
					  return false;
				  }	
			  });			  
	  
			  $('#btnApproval').on('click', function () {
			  	  if(confirm('Approval daftar potongan?'))
				  {
					  $.getJSON("../json-gaji/proses_gaji_set_lock.php?reqPeriode=<?=$reqPeriode?>&reqJenisProses=DAFTAR_POTONGAN",
					  function(data){
					  });	
					  alert('Proses approval berhasil.');
					  $('.toggle').css({"display":"none"});
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
					  if($(this).children().text() == 'Potongan')
					  {
						  $("#btnEditPotongan").click();
					  }
					  else if($(this).children().text() == 'Potongan Lain')
					  {
						  $("#btnEdit").click();
					  }
					  else if($(this).children().text() == 'Potongan Opsional')
					  {
						  $("#btnEditPotonganOpsi").click();
					  }
					  else if($(this).children().text() == 'Asuransi')
					  {
						  $("#btnEditAsuransi").click();
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
</head>
<body style="overflow:hidden">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Pegawai Potongan Lain</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" id="btnEditPotongan" title="Potongan">Potongan</a>
            <a href="#" id="btnEdit" title="Potongan Lain">Potongan Lain</a>
             <a href="#" id="btnEditAsuransi" title="Asuransi">Asuransi</a>
            </li>        
            <li>
            <a href="#" id="btnApproval" title="Approval" class="toggle">Approval Potongan</a>
            </li>
        </ul>
    </div>
    <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:6px; margin-left:180px; z-index:9999; font-size:12px;">
        Departemen : <input id="cc" class="easyui-combotree" name="reqDepartemen" data-options="url:'../json-simpeg/departemen_combo_json.php'" style="width:300px;" value="<?=$reqDepartemen?>">&nbsp;&nbsp;&nbsp;&nbsp;
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
        		  </select>
    </div>
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Id</th>
            <th>kelas</th>
            <th>jenis</th>
            <th>kelompok</th>
            <th width="85px">NRP</th> 
            <th width="85px">NIPP</th>
            <th width="200px">Nama</th> 
            <th width="150px">Jabatan</th>
            <th width="300px">Departemen</th>
        </tr>
    </thead>
    </table>
    </div>    
        <!--RIGHT CLICK EVENT -->
        <div class="vmenu">
            <div class="first_li"><span>Potongan</span></div>
            <div class="first_li"><span>Potongan Lain</span></div>
            <div class="first_li"><span>Asuransi</span></div>
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