<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/StatusPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");

$jenis_pegawai = new JenisPegawai();
$status_pegawai = new StatusPegawai();
$jabatan = new Jabatan();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
$tinggi = 208;

$reqId = httpFilterGet("reqId");
$reqDepartemen = httpFilterGet("reqDepartemen");

if($reqDepartemen == "")
	$reqDepartemen = "CAB1";

$jenis_pegawai->selectByParams();
$status_pegawai->selectByParams();

$jabatan->selectByParams(array("JABATAN_ID"=>$reqId),-1,-1);
$jabatan->firstRow();
$tempKandidatPengalaman= $jabatan->getField('KANDIDAT_PENGALAMAN');
$tempKandidatPendidikan= $jabatan->getField('PENDIDIKAN');
$tempKandidatUsia= $jabatan->getField('KANDIDAT_USIA');
unset($jabatan);

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
							 null,
							 null,
							 null												 								 
						],
			  "bSort":true,
			  "bProcessing": true,
			  "bServerSide": true,		
			  "sAjaxSource": "../json-simpeg/kandidat_jabatan_kosong_pilih_json.php?reqId=<?=$reqId?>",
			  "sScrollY": ($(window).height() - <?=$tinggi?>),
			  "sScrollX": "100%",								  
			  "sScrollXInner": "100%",
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
			  }).makeEditable({
			sDeleteHttpMethod: "GET",
			pLocation: "../json-simpeg/pegawai_json.php",
			pDepartemen: "<?=$reqDepartemen?>",
			sDeleteURL: "../json-simpeg/delete.php?reqMode=pegawai",
			sAddHttpMethod: "GET",
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
			  });
			/* Click event handler */
			  
			  $('#example tbody tr').on('dblclick', function () {
				  $("#btnEdit").click();	
			  });														
		  
			  /* RIGHT CLICK EVENT */
			  var anSelectedData = '';
			  var anSelectedId = '';
			  
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
			  });
			  
			  $('#btnPilih').on('click', function () {
				  if(anSelectedData == "")
					  return false;		
				  window.parent.divwin.close();
	
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

<!-- Flex Menu -->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/flexdropdown.css" />
<script type="text/javascript" src="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/jquery.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/Flex-Level-Drop-Down-Menu-v1.3/flexdropdown.js"></script> 

</head>
<body style="overflow:hidden" onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
	<div id="judul-halaman">
		<span><img src="../WEB-INF/images/panah-judul.png">Data Pegawai</span>
	</div>
    
    <div class="data-foto-table">
        <div class="data-foto">
            <?php /*?><div class="data-foto-img">
                <img src="../simpeg/image_script.php?reqPegawaiId=<?=$reqId?>&reqMode=pegawai" width="60" height="77">
            </div><?php */?>
            
            <div class="data-foto-ket">
            	<div style="color:#000; font-size:18px; ">Kriteria Kandidat</div>     
                <div style="color:#000; font-size:12px;  line-height:20px;">Umur : <?=$tempKandidatUsia?> Tahun</div>
                <div style="color:#000; font-size:12px;  line-height:20px;">Pendidikan : <?=$tempKandidatPendidikan?></div>
                <div style="color:#000; font-size:12px;  line-height:20px;">Pengalaman : <?=$tempKandidatPengalaman?> Tahun</div>
            </div>
    
        </div>
        
        <div class="data-table">
    		<form id="formAddNewRow" action="#" title="Add a new browser" style="width:600px;min-width:600px">
            </form>
            <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
                <ul>
                    <li><a href="#" id="btnPilih" title="Pilih">Pilih</a> </li>
                 </ul>
            </div>
			<div id="rightclickarea"> <!--RIGHT CLICK EVENT -->
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th width="85px">NRP</th> 
                        <th width="85px">NIPP</th>
                        <th width="180px">Nama</th> 
                        <th width="170px">Jabatan</th>
                        <th width="50px">MKP</th>
                        <th width="50px">Usia</th>
                        <th width="50px">Pendidikan</th>
                        <th width="50px">Pengalaman</th>
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
    </div><!-- END DATA FOTO TABLE -->
    
    
</div>
</body>
</html>