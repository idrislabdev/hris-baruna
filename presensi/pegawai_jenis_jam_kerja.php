<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-absensi/JamKerjaJenis.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
$tinggi = 138;

$reqDepartemen = httpFilterGet("reqDepartemen");

if($reqDepartemen == "")
	$reqDepartemen = "CAB1";

$jam_kerja_jenis = new JamKerjaJenis();
$jam_kerja_jenis->selectByParams();
$i=0;
while($jam_kerja_jenis->nextRow())
{
	$arrJamKerjaJenis[$i]["NAMA"] = $jam_kerja_jenis->getField("NAMA");
	$arrJamKerjaJenis[$i]["WARNA"] = $jam_kerja_jenis->getField("WARNA");
	$arrJamKerjaJenis[$i]["JAM_KERJA_JENIS_ID"] = $jam_kerja_jenis->getField("JAM_KERJA_JENIS_ID");
	
	$i++;
}


//echo $reqDepartemen.'---';
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
	<?
	for($i=0;$i<count($arrJamKerjaJenis); $i++)
	{
	?>
	.<?=$arrJamKerjaJenis[$i]["WARNA"]?> { background-color:#<?=$arrJamKerjaJenis[$i]["WARNA"]?>; }
	<?
	}
	?>
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
							 null
						],
			  "bSort":true,
			  "bProcessing": true,
			  "bServerSide": true,		
			  "sAjaxSource": "../json-absensi/pegawai_jenis_jam_kerja_json.php?reqDepartemen=<?=$reqDepartemen?>",
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "100%",
			  "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
									<?
									for($i=0;$i<count($arrJamKerjaJenis);$i++)
									{
									?>
									if ( aData[6] == '<?=$arrJamKerjaJenis[$i]["NAMA"]?>') 
									{
										var i=0;
										for (i=0;i<=9;i++)
										{
											jQuery('td:eq('+i+')', nRow).addClass('<?=$arrJamKerjaJenis[$i]["WARNA"]?>');
										}
									} 
									<?
									}
									?>
									return nRow;
								   },	
			  "sPaginationType": "full_numbers"
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
					  if ( $(aTrs[i]).hasClass('row_selected') )
					  {
						  aReturn.push( aTrs[i] );
						  anSelectedPosition = i;
					  }
				  }
				  return aReturn;
			  }
		  
			  $('#example tbody').on( 'click', 'tr', function () {
				  
				    $("#example tr").removeClass('row_selected');
				  
					if ( $(this).hasClass('row_selected') ) {
						$(this).removeClass('row_selected');
					}
					else {
						oTable.$('tr.selected').removeClass('row_selected');
						$(this).addClass('row_selected');
					}
					  //
					  var anSelected = fnGetSelected(oTable);													
					  anSelectedData = String(oTable.fnGetData(anSelected[0]));
					  var element = anSelectedData.split(','); 
					  anSelectedId = element[0];
					  anSelectedNRP = element[1];
					  anSelectedNIPP = element[2];
					  anSelectedNama = element[3];
					  anSelectedJabatan = element[4];
					  anSelectedDepartemen = element[5];
			  });
			  
			  $('#btnEdit').on('click', function () {
				  if(anSelectedData == "")
					  return false;				
				  window.parent.OpenDHTML('pegawai_add.php?reqId='+anSelectedId, 'Office Management - Aplikasi Kepegawaian', '980', '515');	
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
					
					<?
					for($i=0;$i<count($arrJamKerjaJenis);$i++)
					{
					?>
					  if($(this).children().text() == '<?=$arrJamKerjaJenis[$i]["NAMA"]?>')
					  {					
						 $.getJSON('../json-absensi/pegawai_jenis_jam_kerja_json_set.php?reqId='+anSelectedId+'&reqJamKerjaJenisId=<?=$arrJamKerjaJenis[$i]["JAM_KERJA_JENIS_ID"]?>', function (data) 
						  {
							  $.each(data, function (i, SingleElement) {
								  oTable.fnUpdate('<div style="background-color:#<?=$arrJamKerjaJenis[$i]["WARNA"]?>; width:120%; margin-top:-3px; padding-top:3px; float:left; position:relative; margin-bottom:-3px; padding-bottom:3px; border-right:15px solid #3F3; margin-left:-10px; padding-left:8px;">&nbsp;' + anSelectedNRP + '</div>', anSelectedPosition, 1, false);
								  oTable.fnUpdate('<div style="background-color:#<?=$arrJamKerjaJenis[$i]["WARNA"]?>; width:120%; margin-top:-3px; padding-top:3px; float:left; position:relative; margin-bottom:-3px; padding-bottom:3px; border-right:15px solid #3F3; margin-left:-10px; padding-left:8px;">&nbsp;' + anSelectedNIPP + '</div>', anSelectedPosition, 2, false);
								  oTable.fnUpdate('<div style="background-color:#<?=$arrJamKerjaJenis[$i]["WARNA"]?>; width:120%; margin-top:-3px; padding-top:3px; float:left; position:relative; margin-bottom:-3px; padding-bottom:3px; border-right:15px solid #3F3; margin-left:-10px; padding-left:8px;">&nbsp;' + anSelectedNama + '</div>', anSelectedPosition, 3, false);
								  oTable.fnUpdate('<div style="background-color:#<?=$arrJamKerjaJenis[$i]["WARNA"]?>; width:120%; margin-top:-3px; padding-top:3px; float:left; position:relative; margin-bottom:-3px; padding-bottom:3px; border-right:15px solid #3F3; margin-left:-10px; padding-left:8px;">&nbsp;' + anSelectedJabatan + '</div>', anSelectedPosition, 4, false);
								  oTable.fnUpdate('<div style="background-color:#<?=$arrJamKerjaJenis[$i]["WARNA"]?>; width:120%; margin-top:-3px; padding-top:3px; float:left; position:relative; margin-bottom:-3px; padding-bottom:3px; border-right:15px solid #3F3; margin-left:-10px; padding-left:8px;">&nbsp;' + anSelectedDepartemen + '</div>', anSelectedPosition, 5, false);
								  oTable.fnUpdate('<div style="background-color:#<?=$arrJamKerjaJenis[$i]["WARNA"]?>; width:100%; margin-top:-3px; padding-top:3px; float:left; position:relative; margin-bottom:-3px; padding-bottom:3px; border-right:15px solid #3F3; margin-left:-10px; padding-left:8px;">&nbsp;<?=$arrJamKerjaJenis[$i]["NAMA"]?></div>', anSelectedPosition, 6, false);
	
							  });
						  });						
							   					  
					  }
				    <?
					}
					?>  
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

</style>
<!--RIGHT CLICK EVENT-->		

<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css"/> 

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
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Pegawai Jam Kerja</span>
            </div>            
            </td>
        </tr>
    </table>
    <form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
    </form>
    <?
    //if($userLogin->arrGroupIntranet[0]["AGENDA"] == "A")
	//{
	?>
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
        Departemen : <input id="cc" class="easyui-combotree" name="reqDepartemen" data-options="url:'../json-simpeg/departemen_combo_json.php'" style="width:200px;" value="<?=$reqDepartemen?>">&nbsp;&nbsp;&nbsp;&nbsp;
		<?
        for($i=0;$i<count($arrJamKerjaJenis);$i++)
		{
		?>
		<span style="background-color:#<?=$arrJamKerjaJenis[$i]["WARNA"]?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;<?=$arrJamKerjaJenis[$i]["NAMA"]?>&nbsp;&nbsp;&nbsp;&nbsp;
 		<?
		}
		?>
    </div>
    </div>
    <div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>Id</th>
            <th width="85px">NRP</th> 
            <th width="85px">NIPP</th>
            <th width="200px">Nama</th> 
            <th width="150px">Jabatan</th>
            <th width="150px">Departemen</th>
            <th width="150px">Jenis</th>
        </tr>
    </thead>
    </table>
    </div>    
        <!--RIGHT CLICK EVENT -->
        <div class="vmenu">
		<?
        for($i=0;$i<count($arrJamKerjaJenis);$i++)
		{
		?>
            <div class="first_li"><span><?=$arrJamKerjaJenis[$i]["NAMA"]?></span></div>
        <?
		}
		?>
        </div>
        <!--RIGHT CLICK EVENT -->
    
</div>
</body>
</html>