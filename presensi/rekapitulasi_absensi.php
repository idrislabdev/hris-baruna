<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");

$jenis_pegawai = new JenisPegawai();


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
	
$tinggi = 179;
$x_awal=1;

$jenis_pegawai->selectByParams();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
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
										
        var id = -1;//simulation of id
		$(window).resize(function() {
		  console.log($(window).height());
		  $('.dataTables_scrollBody').css('height', ($(window).height() - <?=$tinggi?>));
		});
        var oTable = $('#example').dataTable({ bJQueryUI: true,"iDisplayLength": 70,
			  /* UNTUK MENGHIDE KOLOM ID */
			  "aoColumns": [ 
							 { bVisible:true },
							 { bVisible:true },
							 { bVisible:true },
							 { bVisible:true }
							 <?
							 $x=$x_awal;
							 while ($x <= $date) {
								echo ',{ bVisible:true}';
								echo ',{ bVisible:true}';
								echo ',{ bVisible:true}';
							 ?>
							 <?	
								$x++;
							 } 
							 ?>
						],
			  "bSort":false,
			  "bProcessing": true,
			  "bServerSide": true,						
			  "sAjaxSource": "../json-absensi/rekapitulasi_absensi_json.php?reqTahun=<?=$reqTahun?>&reqBulan=<?=$reqBulan?>&reqDepartemen=<?=$reqDepartemen?>&reqStatusPegawai=<?=$reqStatusPegawai?>",	  
			  "scrollY": ($(window).height() - <?=$tinggi?>),
			  "scrollX": "100%",
			  "sPaginationType": "full_numbers"
			  });

			  var fc = new $.fn.dataTable.FixedColumns( oTable, {
				leftColumns: 2
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
			  
			  $('#btnImport').on('click', function () {
				  window.parent.OpenDHTML('rekapitulasi_absensi_import.php', 'Office Management - Administrasi Absensi', '900', '580');	
			  });
			  
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
				  newWindow = window.open('rekapitulasi_absensi_cetak.php?reqBulan='+$("#reqBulan").val()+'&reqTahun='+ $("#reqTahun").val()+'&reqDepartemen=<?=$reqDepartemen?>&reqStatusPegawai=<?=$reqStatusPegawai?>&reqJenisPegawai='+ $("#reqJenisPegawai").val(), 'Cetak');
				  newWindow.focus();
			  });	
			  
			  $('#btnCetakPeroranganPdf').on('click', function () {
				  if(anSelectedData == "")
					  return false;		
				  //alert('rekapitulasi_terlambat_pulang_cepat_cetak.php?reqBulan='+ $("#bulan").val()+'&reqTahun='+ $("#tahun").val());
				  newWindow = window.open('cetak_rekapitulasi_absensi.php?reqId='+anSelectedId+'&reqPeriode='+$("#reqBulan").val()+$("#reqTahun").val(), 'Cetak');
				  newWindow.focus();
			  });		
			  $('#btnCetakPeroranganExcel').on('click', function () {
				  if(anSelectedData == "")
					  return false;		
				  //alert('rekapitulasi_terlambat_pulang_cepat_cetak.php?reqBulan='+ $("#bulan").val()+'&reqTahun='+ $("#tahun").val());
				  newWindow = window.open('cetak_rekapitulasi_absensi_excel.php?reqId='+anSelectedId+'&reqPeriode='+$("#reqBulan").val()+$("#reqTahun").val(), 'Cetak');
				  newWindow.focus();
			  });			  

			  $('#btnCetakHari').on('click', function () {
				  /*if(anSelectedData == "")
					  return false;*/				
				  //alert('rekapitulasi_terlambat_pulang_cepat_cetak.php?reqBulan='+ $("#bulan").val()+'&reqTahun='+ $("#tahun").val());
					var bulan = new Array();
					bulan[0] = "";
					bulan[1] = "Januari";
					bulan[2] = "Februari";
					bulan[3] = "Maret";
					bulan[4] = "April";
					bulan[5] = "Mei";
					bulan[6] = "Juni";
					bulan[7] = "Juli";
					bulan[8] = "Agustus";
					bulan[9] = "September";
					bulan[10] = "Oktober";
					bulan[11] = "November";
					bulan[12] = "Desember";
					$.messager.prompt('Cetak Rekap ' + bulan[parseInt($("#reqBulan").val())] + ' ' + $("#reqTahun").val(), 'Masukkan tanggal :', function(r){
						if (r){
						    newWindow = window.open('rekapitulasi_absensi_per_tanggal_cetak.php?reqBulan='+$("#reqBulan").val()+'&reqTahun='+ $("#reqTahun").val()+'&reqHari='+r, 'Cetak');
						    newWindow.focus();
						}
					});
			
			  });
			  
			  $('#btnCetakMingguan').on('click', function () {
					var bulan = new Array();
					bulan[0] = "";
					bulan[1] = "Januari";
					bulan[2] = "Februari";
					bulan[3] = "Maret";
					bulan[4] = "April";
					bulan[5] = "Mei";
					bulan[6] = "Juni";
					bulan[7] = "Juli";
					bulan[8] = "Agustus";
					bulan[9] = "September";
					bulan[10] = "Oktober";
					bulan[11] = "November";
					bulan[12] = "Desember";
					//var validformat=/^\d{4}\-\d{2}\-\d{2}$/ ;
					//var validformat="^(0[1-9]|[12][0-9]|3[01])[-](0[1-9]|[12][0-9]|3[01])";
					//var validformat=/^(0?[1-9]|[12][0-9]|3[01])-(0?[1-9]|[12][0-9]|3[01])$/ ;
					var validformat="^(((0?[1-9]|1[012])/([01]?[1-9]|10|2[0-8])|(0?[13-9]|1[012])/(29|30)|(0?[13578]|1[02])/31)/(1[89]|20)[0-9]{2}|0?2/29/(1[89]|20)([24680][048]|[13579][26]))$";
					$.messager.prompt('Cetak Rekap Mingguan ' + bulan[parseInt($("#reqBulan").val())] + ' ' + $("#reqTahun").val(), 'Masukkan range tanggal (contoh:1-7) :', function(r){
						var arr= r.split("-");
						//alert(arr[0]+'---'+arr[1]);
						
						if (( arr[0] >= 1 && arr[0] <= 31) && ( arr[1] >= 1 && arr[1] <= 31))
						{
							newWindow = window.open('rekapitulasi_absensi_mingguan_tanggal_cetak.php?reqAwal='+arr[0]+'&reqAkhir='+arr[1]+'&reqBulan='+$("#reqBulan").val()+'&reqTahun='+ $("#reqTahun").val()+'&reqDepartemen=<?=$reqDepartemen?>&reqStatusPegawai=<?=$reqStatusPegawai?>', 'Cetak');
							newWindow.focus();
						}
						else
						{
							alert("contoh data valid: 1-10.");
							return false;
						}
						
						/*if(!validformat.test(r))
						{
						alert("contoh data valid: 1-10.");
						//return false;
						}
						else{
							if (r){
								alert(r);
								//newWindow = window.open('rekapitulasi_absensi_mingguan_tanggal_cetak.php?reqBulan='+$("#reqBulan").val()+'&reqTahun='+ $("#reqTahun").val()+'&reqHari='+r, 'Cetak');
								//newWindow.focus();
							}
						}*/
					});
			
			  });

			  $("#reqJenisPegawai").change(function() {
				 oTable.fnReloadAjax("../json-absensi/rekapitulasi_absensi_json.php?reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen="+$('#cc').combotree('getValue')+"&reqJenisPegawai="+ $("#reqJenisPegawai").val());				 	 
			  });

			  $("#reqBulan").change(function() { 
				 refreshfnHide();
				 oTable.fnReloadAjax("../json-absensi/rekapitulasi_absensi_json.php?reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen="+$('#cc').combotree('getValue')+"&reqJenisPegawai="+ $("#reqJenisPegawai").val());				 	 
			  });

			  $("#reqTahun").change(function() { 
		  		 refreshfnHide();
				 oTable.fnReloadAjax("../json-absensi/rekapitulasi_absensi_json.php?reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen="+$('#cc').combotree('getValue')+"&reqJenisPegawai="+ $("#reqJenisPegawai").val());				 	 
			  });			  
			  
			  $('#cc').combotree({
					onSelect: function(param){
 						 refreshfnHide();
						 oTable.fnReloadAjax("../json-absensi/rekapitulasi_absensi_json.php?reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen="+param.id+"&reqJenisPegawai="+ $("#reqJenisPegawai").val());
					}
			  });
			
			<?
			//for($i=2+($day*2);$i<64;$i++)
			for($i=4+($day*3);$i<97;$i++)
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
				 for(var i=40; i<97; i++)
			  	 {
					 if(bVis = oTable.fnSettings().aoColumns[i].bVisible == false)
						 fnShow(i);
				 }
			     var day = daysInMonth($("#reqBulan").val(), $("#reqTahun").val());
					for(var i=4+(day*3); i<97; i++)
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Rekapitulasi Absensi</span>
            </div>            
            </td>
            <td align="right">
            </td>
        </tr>
    </table>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li><a href="#" title="Cetak" id="btnCetak">&nbsp;Cetak</a></li> 
            <li><a href="#" title="Cetak" id="btnCetakHari">&nbsp;Cetak Rekap Harian</a></li> 
            <li><a href="#" title="Cetak" id="btnCetakMingguan">&nbsp;Cetak Rekap Mingguan</a></li>
            <!--<li><a href="#" title="Cetak" id="btnCetakPeroranganPdf">&nbsp;Cetak Perorangan</a></li>-->
            <li>
            <a href="#" data-flexmenu="flexmenu1">&nbsp;Cetak Perorangan</a>
            </li>
        </ul>
        <ul id="flexmenu1" class="flexdropdownmenu">
            <li><a href="#" title="Cetak" id="btnCetakPeroranganExcel">&nbsp;Excel</a></li>
            <li><a href="#" title="Cetak" id="btnCetakPeroranganPdf">&nbsp;Pdf</a></li>
        </ul> 
    </div>
 <div style="position: relative; z-index:10">
    <div style="position: absolute; margin-top:6px; margin-left:180px; z-index:9999; font-size:12px;">
    	Bulan :
            <select name="reqBulan" id="reqBulan">
            <?
            for($i=1; $i<=12; $i++)
            {
				$tempNama=getNameMonth($i);
                $temp=generateZeroDate($i,2);
            ?>
                <option value="<?=$temp?>" <? if($temp == date("m")) echo 'selected'?>><?=$tempNama?></option>
            <?
            }
            ?>
            </select>
        
        Tahun
        	<select name="reqTahun" id="reqTahun">
            	<? 
				for($i=date("Y")-2; $i < date("Y")+2; $i++)
				{
				?>
            	<option value="<?=$i?>" <? if($i == date("Y")) echo 'selected'?>><?=$i?></option>
                <?
				}
                ?>
            </select>
        Departemen : <input id="cc" class="easyui-combotree" name="reqDepartemen" data-options="url:'../json-intranet/departemen_combo_json.php'" style="width:200px;" value="<?=$reqDepartemen?>">&nbsp;&nbsp;&nbsp;
    	Jenis Pegawai : <select name="reqJenisPegawai" id="reqJenisPegawai">
        					<option value="">Semua</option>
        				<?
                        while($jenis_pegawai->nextRow())
						{
						?>
                        	<option value="<?=$jenis_pegawai->getField("JENIS_PEGAWAI_ID")?>"><?=$jenis_pegawai->getField("NAMA")?></option>	
						<?	
						}
						?>
                        </select>        
    </div>
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
        <tr>
            <th rowspan="2" class="th_like" width="70px">NRP</th>
            <th rowspan="2" class="th_like" width="250px">Nama</th>
			<th rowspan="2" class="th_like" width="200px">Jabatan</th>
			<th rowspan="2" class="th_like" width="50px">Kelas</th>
             <?
             $x=$x_awal;
             while ($x <= $date) {
             ?>
             <th colspan="3" width="80px" style="text-align:center"><?=$x?></th>
             <?	
                $x++;
             }
             ?>
        </tr>
        <tr>
            <?
            $x=$x_awal;
             while ($x <= $date) {
             ?>
             <th class="th_like" width="50px">IN</th>
             <th class="th_like" width="50px">OUT</th>
			 <th class="th_like" width="50px">J.JAM</th>
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