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

$reqTahun= httpFilterGet("reqTahun");
$reqBulan= httpFilterGet("reqBulan");
$reqDepartemen = httpFilterGet("reqDepartemen");
$reqStatusPegawai= httpFilterGet("reqStatusPegawai");

if($reqTahun == "")	{
	$reqBulan = date("m");
	$reqTahun = date("Y");	
}

if($reqDepartemen == "")
	$reqDepartemen = "CAB1"; //$userLogin->idDepartemen;

if($reqStatusPegawai == '')
	$reqStatusPegawai = '1';
		
$tinggi = 155;
$jenis_pegawai->selectByParams();
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
							 null
						],
			  "bSort":true,
			  "bProcessing": true,
			  "bServerSide": true,		
			  "sAjaxSource": "../json-absensi/rekapitulasi_terlambat_pulang_cepat_json.php?reqTahun=<?=$reqTahun?>&reqBulan=<?=$reqBulan?>&reqDepartemen=<?=$reqDepartemen?>&reqStatusPegawai=<?=$reqStatusPegawai?>",
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "120%",
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
			  
			  var fc = new $.fn.dataTable.FixedColumns( oTable, {
				leftColumns: 4
			  });
			  
			  $('#btnEkspor').on('click', function () {
				  /*if(anSelectedData == "")
					  return false;*/				
				  //alert('rekapitulasi_terlambat_pulang_cepat_cetak.php?reqBulan='+ $("#bulan").val()+'&reqTahun='+ $("#tahun").val());
				  newWindow = window.open('rekapitulasi_detail_kehadiran_cetak.php?reqBulan='+$("#reqBulan").val()+'&reqTahun='+ $("#reqTahun").val()+'&reqDepartemen='+$('#cc').combotree('getValue')+'&reqJenisPegawai='+$("#reqJenisPegawai").val(), 'Cetak');
				  newWindow.focus();
			  });			  

			  $("#reqJenisPegawai").change(function() { 
			  
				 oTable.fnReloadAjax("../json-absensi/rekapitulasi_terlambat_pulang_cepat_json.php?reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen="+$('#cc').combotree('getValue')+"&reqJenisPegawai="+ $("#reqJenisPegawai").val());				 	 
			  });

			  $("#reqBulan").change(function() { 
				 oTable.fnReloadAjax("../json-absensi/rekapitulasi_terlambat_pulang_cepat_json.php?reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen="+$('#cc').combotree('getValue')+"&reqJenisPegawai="+ $("#reqJenisPegawai").val());				 	 
			  });

			  $("#reqTahun").change(function() { 
				 oTable.fnReloadAjax("../json-absensi/rekapitulasi_terlambat_pulang_cepat_json.php?reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen="+$('#cc').combotree('getValue')+"&reqJenisPegawai="+ $("#reqJenisPegawai").val());				 	 
			  });	
			  
			   $('#cc').combotree({
					onSelect: function(param){
						 oTable.fnReloadAjax("../json-absensi/rekapitulasi_terlambat_pulang_cepat_json.php?reqTahun="+$("#reqTahun").val()+"&reqBulan="+$("#reqBulan").val()+"&reqDepartemen="+param.id+"&reqJenisPegawai="+ $("#reqJenisPegawai").val());
					}
			  });
			  		  
			  			  
		} );
</script>
<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
<style>
label {
	font-size: 12px;
  }
</style>
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Rekapitulasi Terlambat &amp; Pulang Cepat</span>
            </div>            
            </td>
        </tr>
    </table>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>  
            <a href="#" title="Export Excel" id="btnEkspor">&nbsp;Export Excel</a>
            </li>
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
        Departemen : <input id="cc" class="easyui-combotree" name="reqDepartemen" id="reqDepartemen" data-options="url:'../json-intranet/departemen_combo_json.php'" style="width:200px;" value="<?=$reqDepartemen?>">&nbsp;&nbsp;&nbsp;
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
            <th>Id</th>
            <th width="70px">NRP</th>
            <th width="150px">Nama</th>
            <th width="50px">Kelompok</th>
            <th width="50px">Masuk</th>
            <th width="50px">Terlambat</th> 
            <th width="150px">Terlambat Hari</th> 
            <th width="50px">Pulang Cepat</th> 
            <th width="150px">Pulang Cepat Hari</th> 
            <th width="50px">Tidak Masuk</th> 
            <th width="150px">Tidak Masuk Hari</th> 
        </tr>
    </thead>
    </table> 
	</div>    
</div>
</body>
</html>