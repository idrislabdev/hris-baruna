<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");
include_once("../WEB-INF/classes/base-absensi/ProsesPresensiLock.php");

$jenis_pegawai = new JenisPegawai();
$proses_presensi_lock = new ProsesPresensiLock();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$reqMode= httpFilterGet("reqMode");
$reqTahun= httpFilterGet("reqTahun");
$reqBulan= httpFilterGet("reqBulan");
$reqDepartemen = httpFilterGet("reqDepartemen");
$reqStatusPegawai= httpFilterGet("reqStatusPegawai");

if($reqTahun == "")	{
	$reqBulan = date("m");
	$reqTahun = date("Y");	
}

if($reqDepartemen == "")
	$reqDepartemen = "CAB1";

$date=$reqTahun."-".$reqBulan;
$day =  getDay(date("Y-m-t",strtotime($date)));
$date= 31;

if($reqStatusPegawai == '')
	$reqStatusPegawai = '1';
	
$tinggi = 155;
$x_awal=1;
$jenis_pegawai->selectByParams();
$lock_proses = $proses_presensi_lock->getProsesPresensiLock(array("JENIS_PROSES" => "KOREKSI_ABSEN_KAPAL", "PERIODE" => $reqBulan.$reqTahun));


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>Diklat</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">

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

<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
<script type="text/javascript" src="../WEB-INF/lib/media/js/complete.js"></script>
<script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
<script src="../WEB-INF/lib/media/js/jquery.dataTables.rowGrouping.js" type="text/javascript"></script>

<script type="text/javascript">
	function setValue(){
		$('#cc').combotree('setValue', '<?=$reqDepartemen?>');
	}
/*
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
				document.location.href = 'absensi_koreksi.php?reqDepartemen=' + newValue + '&reqTahun=<?=$reqTahun?>&reqBulan=<?=$reqBulan?>&reqStatusPegawai=<?=$reqStatusPegawai?>'; 
			}
	};
	*/
	$(document).ready(function () {
          $('#cc').combotree({
              onSelect: function (node) { },
			  onChange:function(newValue,oldValue){
				  if(newValue == '<?=$reqDepartemen?>')
			{
			} else {
			document.location.href = 'absensi_koreksi.php?reqDepartemen=' + newValue + '&reqTahun=<?=$reqTahun?>&reqBulan=<?=$reqBulan?>&reqStatusPegawai=<?=$reqStatusPegawai?>'; 
				}
				  }
          })
		  
		  
		$('#reqLokasiId').combotree({
              onSelect: function (node) { },
			  onChange:function(newValue,oldValue){
				 oTable.fnReloadAjax("../json-absensi/absensi_koreksi_awak_kapal_json.php?reqJamKerja=4&reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen=<?=$reqDepartemen?>&reqJenisPegawai="+ $("#reqJenisPegawai").val() + "&reqLokasiId="+newValue);				 	 
			  	refreshfnHide();
				  }
          })  
		    
      });
</script>

<script src="../WEB-INF/lib/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../WEB-INF/lib/media/js/jquery.dataTables.editable.js"></script>
<script src="../WEB-INF/lib/media/js/jquery.jeditable.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/jquery-ui.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/jquery.validate.js" type="text/javascript"></script>
<script src="../WEB-INF/lib/media/js/FixedColumns.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">
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
							 { bVisible:true },
							 { bVisible:true },
							 { bVisible:true }
							 <?
							 $x=1;
							 while ($x <= $date) {
								echo ',{ bVisible:true, "sClass": "center"}';
							 ?>
							 <?	
								$x++;
							 }
							 ?>
						],
			  "bStateSave": true,
			  "bSort":false,
			  "bProcessing": true,
			  "bServerSide": true,								  
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sAjaxSource": "../json-absensi/absensi_koreksi_awak_kapal_json.php?reqTahun=<?=$reqTahun?>&reqBulan=<?=$reqBulan?>&reqDepartemen=<?=$reqDepartemen?>&reqStatusPegawai=<?=$reqStatusPegawai?>&reqJamKerja=4",
			  "sScrollX": "100%",
			  "sScrollXInner": "2700px",
			  "sPaginationType": "full_numbers",
			  "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
				    var tahun=$("#tahun").val();
					var bulan=($("#bulan").val() * 1) - 1;
					//var d_end = new Date(tahun, bulan, 23);
					var d_end = new Date(tahun, bulan, 0);
					var start_date = new Date(tahun, bulan, <?=$x_awal?>);
					var row=4;

					for(x=1;x<=aData.length;x++)
					{
						if((start_date.getDay() == 6) || (start_date.getDay() == 0)) 
						{
						  temp=row-1;	jQuery('td:eq('+temp+')', nRow).addClass('libur');
						
						}
						row++;
						start_date.setDate(start_date.getDate()+1);
					}
					
				return nRow;
			   }
			  }).makeEditable({
			sDeleteHttpMethod: "GET",
			sAddHttpMethod: "GET",
			pTahun: "<?=$reqTahun?>",
			pBulan: "<?=$reqBulan?>",
			pDepartemenId: "<?=$reqDepartemen?>",
			pStatusPegawai: "<?=$reqStatusPegawai?>",
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
		  
			  /* RIGHT CLICK EVENT */
			  var anSelectedData = '';
			  var anSelectedId = '';
			  var anSelectedKelompok = '';
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
					  anSelectedId = element[1];
					  anSelectedKelompok = element[3];
			  });
			  
			  $('#btnKoreksi').on('click', function () {
				  if(anSelectedData == "")
					  return false;				
				  window.parent.OpenDHTML('absensi_koreksi_awak_kapal_add.php?reqId='+anSelectedId+'&reqKelompok='+anSelectedKelompok+'&reqBulan='+$("#reqBulan").val()+'&reqTahun='+$("#reqTahun").val()+'', 'Office Management - Aplikasi Presensi', '880', '550');	
			  });
			  
			  $('#btnApproval').on('click', function () {
			  	  if(confirm('Approval koreksi presensi awak kapal?'))
				  {
					  $.getJSON("../json-absensi/proses_presensi_set_lock.php?reqJenisProses=KOREKSI_ABSEN_KAPAL&reqPeriode="+ $("#reqBulan").val() + $("#reqTahun").val(),
					  function(data){
					  });	
					  alert('Proses approval berhasil.');
				 	  $('.toggle').css({"display":"none"});
				  }

			  });
			  
			  $('#btnProses').on('click', function () {
					$.getJSON("../json-absensi/absensi_koreksi_validasi_json.php?reqJamKerja=4&reqPeriode="+$("#reqBulan").val()+""+$("#reqTahun").val(),
					function(data){
						jumlah = data.DATA;
					});		
					if(jumlah == 0)		  
			      		oTable.fnReloadAjax("../json-absensi/absensi_koreksi_awak_kapal_json.php?reqMode=proses&reqJamKerja=4&reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen=<?=$reqDepartemen?>&reqJenisPegawai="+ $("#reqJenisPegawai").val());
					else
			      	{
						if(confirm("Proses ulang rekap akan mengakibatkan data presensi awak kapal sebelumnya terhapus. Lanjutkan?"))
				      		oTable.fnReloadAjax("../json-absensi/absensi_koreksi_awak_kapal_json.php?reqMode=proses&reqJamKerja=4&reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen=<?=$reqDepartemen?>&reqJenisPegawai="+ $("#reqJenisPegawai").val());
						
					}					
			  });
			  		
			  $("#reqJenisPegawai").change(function() { 
			  
				 oTable.fnReloadAjax("../json-absensi/absensi_koreksi_awak_kapal_json.php?reqJamKerja=4&reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen=<?=$reqDepartemen?>&reqJenisPegawai="+ $("#reqJenisPegawai").val());				 	 
			  });
			  
			  $("#reqJamKerja").change(function() { 
			  
				 oTable.fnReloadAjax("../json-absensi/absensi_koreksi_awak_kapal_json.php?reqJamKerja=4&reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen=<?=$reqDepartemen?>&reqJenisPegawai="+ $("#reqJenisPegawai").val());				 	 
			  });
			  $("#reqBulan").change(function() { 
				$.getJSON("../json-absensi/proses_presensi_validasi_lock.php?reqJamKerja=4&reqPeriode="+$("#reqBulan").val()+""+$("#reqTahun").val(),
					function(data){
						jumlah = data.DATA;
						if(jumlah == 1)
							$('.toggle').css({"display":"none"});
						else
							$('.toggle').css({"display":""});						
	
					});	  
					  
				 oTable.fnReloadAjax("../json-absensi/absensi_koreksi_awak_kapal_json.php?reqJamKerja=4&reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen=<?=$reqDepartemen?>&reqJenisPegawai="+ $("#reqJenisPegawai").val());				 	 
			  	refreshfnHide();
			  });

			  $("#reqTahun").change(function() { 
			  	$.getJSON("../json-absensi/proses_presensi_validasi_lock.php?reqJamKerja=4&reqPeriode="+$("#reqBulan").val()+""+$("#reqTahun").val(),
					function(data){
						jumlah = data.DATA;
						if(jumlah == 1)
							$('.toggle').css({"display":"none"});
						else
							$('.toggle').css({"display":""});	
					});
				 oTable.fnReloadAjax("../json-absensi/absensi_koreksi_awak_kapal_json.php?reqJamKerja=4&reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen=<?=$reqDepartemen?>&reqJenisPegawai="+ $("#reqJenisPegawai").val());				 	 
			  	refreshfnHide();
			  });			  

			<?
			for($i=4+$day;$i<35;$i++)
			{
			?>
				fnHide(<?=$i?>);
			<?
			}
			?>
			function refreshfnHide()
			{
				var oTable = $('#example').dataTable();
				
				var bVis;
				 for(var i=28; i<35; i++)
			  	 {
					 if(bVis = oTable.fnSettings().aoColumns[i].bVisible == false)
						 fnShow(i);
				 }
			     var day = daysInMonth($("#reqBulan").val(), $("#reqTahun").val());
					for(var i=4+day; i<35; i++)
						fnHide(i);					
			}
			
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
			function daysInMonth(month, year) {
				return new Date(year, month, 0).getDate();
			}
			  						  
			  $('#btnCetakLaporan').on('click', function () {
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
			  
			  $('#btnCetak').on('click', function () {
				  /*if(anSelectedData == "")
					  return false;*/				
				  //alert('rekapitulasi_terlambat_pulang_cepat_cetak.php?reqBulan='+ $("#bulan").val()+'&reqTahun='+ $("#tahun").val());
				  newWindow = window.open('absensi_koreksi_cetak.php?reqBulan='+$("#reqBulan").val()+'&reqTahun='+ $("#reqTahun").val()+'&reqDepartemen=<?=$reqDepartemen?>&reqStatusPegawai=<?=$reqStatusPegawai?>&reqJenisPegawai='+ $("#reqJenisPegawai").val(), 'Cetak');
				  newWindow.focus();
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Koreksi Absen</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" id="btnProses" title="Hapus" class="toggle">Proses</a>
            <a href="#" id="btnKoreksi" title="Hapus" class="toggle">Koreksi</a>
            <a href="#" title="Cetak" id="btnCetak">&nbsp;Cetak</a>
            </li>        
            <li>
            <a href="#" id="btnApproval" title="Hapus" class="toggle">Approval Koreksi</a>
            </li>
        </ul>
    </div>
  <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:6px; margin-left:180px; z-index:9999; font-size:12px;">
    	Periode :
            <select name="reqBulan" id="reqBulan">
            <?
            for($i=1; $i<=12; $i++)
            {
				$tempNama=getNameMonth($i);
                $temp=generateZeroDate($i,2);
            ?>
                <option value="<?=$temp?>" <? if($temp == (int)$reqBulan) echo 'selected'?>><?=$tempNama?></option>
            <?
            }
            ?>
            </select>
        	<select name="reqTahun" id="reqTahun">
            	<? 
				for($i=date("Y")-2; $i < date("Y")+2; $i++)
				{
				?>
            	<option value="<?=$i?>" <? if($i == $reqTahun) echo 'selected'?>><?=$i?></option>
                <?
				}
                ?>
            </select>
        Departemen : <input id="cc" class="easyui-combotree" name="reqDepartemen" data-options="url:'../json-intranet/departemen_combo_json.php'" style="width:200px;">&nbsp;&nbsp;&nbsp;
    	Jenis : <select name="reqJenisPegawai" id="reqJenisPegawai">
        					<option value="">Semua</option>
        				<?
                        while($jenis_pegawai->nextRow())
						{
						?>
                        	<option value="<?=$jenis_pegawai->getField("JENIS_PEGAWAI_ID")?>"><?=$jenis_pegawai->getField("NAMA")?></option>	
						<?	
						}
						?>
                        </select> Lokasi : 
                        <input id="reqLokasiId" class="easyui-combotree" name="reqLokasiId" data-options="panelHeight:'120',url:'../json-operasional/lokasi_combo_json.php'" 
                        style="width:200px;" >                     
    </div>
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th width="50px">KAPAL ID</th> 
                <th width="50px">Pegawai ID</th> 
                <th width="50px">NRP</th> 
                <th width="50px">Hari Kerja</th> 
                <th width="250px">Nama</th> 
                <?
                 $x=1;
                 while ($x <= $date) {
                 ?>
                 <th class="th_like" width="1px" style="text-align:center"><?=$x?></th>
                 <?	
                    $x++;
                 }
                 ?>
            </tr>
        </thead>
        </table> 
	</div>        

</div>
</body>
</html>