<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");

/* LOGIN CHECK */
$kbbr_thn_buku_d_periode_mutasi = new KbbrThnBukuD();
$kbbr_thn_buku_d_mutasi_laporan = new KbbrThnBukuD();
$kbbt_jur_bb = new KbbtJurBb();

$reqPeriode = httpFilterGet("reqPeriode");
$reqBukuTahun = httpFilterGet("reqBukuTahun");

$kbbr_thn_buku_d_periode_mutasi->selectByParams(array(), -1, -1, " AND TO_NUMBER(BLN_BUKU) >= 12 ", " ORDER BY THN_BUKU DESC, BLN_BUKU DESC ");
while($kbbr_thn_buku_d_periode_mutasi->nextRow())
{
	$arrPeriode[] = $kbbr_thn_buku_d_periode_mutasi->getField("PERIODE");	
	$arrPeriodeNama[] = $kbbr_thn_buku_d_periode_mutasi->getField("NM_BLN_BUKU")." ".$kbbr_thn_buku_d_periode_mutasi->getField("THN_BUKU");
}

$kbbr_thn_buku_d_mutasi_laporan->selectByParams(array(), -1, -1, " AND THN_BUKU = TO_CHAR(SYSDATE, 'rrrr') ", " ORDER BY THN_BUKU DESC ");
while($kbbr_thn_buku_d_mutasi_laporan->nextRow())
{
	$arrPeriodeMutasiLaporan[] = $kbbr_thn_buku_d_mutasi_laporan->getField("PERIODE");	
	$arrPeriodeNamaMutasiLaporan[] = $kbbr_thn_buku_d_mutasi_laporan->getField("NM_BLN_BUKU")." ".$kbbr_thn_buku_d_mutasi_laporan->getField("THN_BUKU");
}

if($reqPeriode == "")
	$reqPeriode = $arrPeriode[0];

$kbbt_jur_bb->selectByParams(array("BLN_BUKU || THN_BUKU" => $reqPeriode), -1, -1, " AND NO_POSTING IS NULL ");
	
$tinggi = 155;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>pindah saldo audit</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">

<!--<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
<link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
<link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />-->

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
	.libur { background-color:#F33; }
	.cuti { background-color:#FF0; }
	.ijin { background-color:#0F0; }	
</style>

<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
<script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>

<script type="text/javascript" charset="utf-8">
$(document).ready( function () {
	
		$('#btnProses').on('click', function () {
			if(confirm("Periksa dahulu apakah semua kriteria sudah benar ?"))
			{
				var win = $.messager.progress({
					title:'Please waiting',
					msg:'Loading data...'
				});

				var val = [];
				$(':checkbox:checked').each(function(i){
					val[i] = $(this).val();
				});
				if(val.length == 0)
				{
					$.messager.progress('close');
					alert('Pilih data terlebih dahulu.');
					
				}
				else
				{
					
					var id = "";
					for(i=0;i<val.length; i++)
					{
						if(id == "")
							id = val[i];
						else 
							id = id + "," + val[i];
					}
					
					$.getJSON('../json-keuangansiuk/pindah_saldo_audit_proses_json.php?reqBukuTahun='+$("#reqBukuTahun").val()+'&reqPeriode=<?=$reqPeriode?>&reqId='+id,
					  function(data){
	
						$.messager.progress('close');
						alert(data.PESAN);								
						document.location.reload();
													
					});	

				}	
				
			}
	    });

		$('#btnBatal').on('click', function () {
			
			if(confirm("Apakah anda yakin ingin membatalkan proses ?"))
			{
				var win = $.messager.progress({
					title:'Please waiting',
					msg:'Loading data...'
				});
				
				$.getJSON('../json-keuangansiuk/proses_tutup_tahun_buku_batal_json.php?reqTahunBuku='+$('#reqTahunBuku').val(),
				  function(data){
					$.messager.progress('close');
					alert(data.PESAN);	
				});		
			}
	    });		
		
		$("#reqTahunBuku").change(function() { 
		   document.location.href = "pindah_saldo_audit.php?reqPeriode="+$("#reqTahunBuku").val()+"&reqBukuTahun="+$("#reqBukuTahun").val();				 	 
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

</style>

<style>
table#table-audit{
	width:100%;
	
}
table#table-audit thead th{
	text-align:center; font-weight:bold;
	line-height:40px;
}
table#table-audit tbody{
	background:#C6C;
	position:fixed;
	width:calc(100% - 150px);
	height: 100px;
	/*overflow: auto;*/
	overflow-y:scroll;

}
table#table-audit tbody td{
	line-height:24px;
	

}
table#table-header thead th {
	text-align:center;
	font-weight:bold;
	line-height:26px;
	background:#4a5e70;
	color:#FFF;
}
table#table-body tbody td {
	text-align:center;
	font-size:14px;
	line-height:22px;
	
}
</style>

<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  
<link href="../WEB-INF/css/bluetabs.css" rel="stylesheet" type="text/css" />
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
                <span><img src="../WEB-INF/images/panah-judul.png"> PINDAH SALDO AUDIT</span>
            </div>            
            </td>
        </tr>
    </table>
    <div id="konten" class="border-frame">
    	<!--<div>
        	<div style="float:left;"><img src="../WEB-INF/images/logo-pelindo.png" height="40"></div>
        	<div style="float:right; line-height:22px;">Nama Cabang</div><br><br>
            <div style="float:right; line-height:22px;">Status Display</div>
        </div>
        <div style="font-weight:bold; text-align:center; margin-bottom:20px; clear:both;">PROSES PINDAH MUTASI KE AWAL PERIODE BERJALAN</div>-->
    	  
          <form name="form1" method="post" action="">
            <div style="font-weight:bold;">Proses yang dilakukan :</div><br>
              
            1. Memindahkan saldo mutasi tahun terpilih ke saldo mutasi periode bulan berjalan.<br>
            2. Membuat jurnal mutasi / mirror ke periode bulan berjalan, dengan mengganti rekening pendapatan dan biaya dengan R/K permanen.
              
            
            <div style="text-align:center; margin-top:10px;"><img src="../WEB-INF/images/horizontal-divider.png"></div>
            <div style="font-weight:bold; margin-top:-100px;">Perhatikan :</div><br>
            1. Periode buku bulan terpilih terlebih dahulu harus sudah close.<br>
            2. Cek jurnal mutasi yang sudah dibuat pada periode buku bulan berjalan.<br>
            
            <div style="text-align:center; margin-top:10px;"><img src="../WEB-INF/images/horizontal-divider.png"></div>
            
            <div style=" text-align:center; background:; margin:-100px 0 20px; color:#4a5e70;">
            	<table cellspacing="0" cellpadding="0" border="0" width="100%">
                  <tr>
                    <td>
                       <table id="table-header" cellspacing="0" cellpadding="1" border="1" width="100%" >
                         <thead>
                            <tr>
                                <th width="100">No&nbsp;SIUK</th>
                                <th width="100">Bukti Pendk</th>
                                <th width="100">Tanggal</th>
                                <th width="450">Keterangan</th>
                                <th width="140">Dollar</th>
                                <th width="140">Rupiah</th>
                                <th width="80">TRANS</th>
                            </tr>
                        </thead>
                       </table>
                    </td>
                  </tr>
                  <tr>
                    <td>
                       <div style="width:calc(100% + 15px); height:200px; overflow:auto;">
                         <table id="table-body" cellspacing="0" cellpadding="1" border="1" width="100%" >
                           <tbody>
                           <?
						   $i=0;
                           while($kbbt_jur_bb->nextRow())
						   {
						   ?>
                                <tr>
                                    <td width="100"><?=$kbbt_jur_bb->getField("NO_NOTA")?></td>
                                    <td width="100"><?=$kbbt_jur_bb->getField("NO_REF3")?></td>
                                    <td width="100"><?=dateToPage($kbbt_jur_bb->getField("TGL_TRANS"))?></td>
                                    <td width="450"><?=$kbbt_jur_bb->getField("KET_TAMBAH")?></td>
                                    <td width="140"><?=numberToIna($kbbt_jur_bb->getField("JML_VAL_TRANS"))?></td>
                                    <td width="140"><?=numberToIna($kbbt_jur_bb->getField("JML_RP_TRANS"))?></td>
                                    <td width="80"><input type="checkbox" name="ch<?=$i?>" id="ch<?=$i?>" value="<?=$kbbt_jur_bb->getField("NO_NOTA")?>"></td>
                                </tr>
                           <?
						   		$i++;
						   }
						   ?>
                            </tbody>
                         </table>  
                       </div>
                    </td>
                  </tr>
                </table>
                
            </div>
            
            <div style="clear:both; position:relative"></div>
            <div style="text-align:center;"><img src="../WEB-INF/images/horizontal-divider.png"></div>
            
            <div style=" text-align:center; padding:20px; background:; margin:-120px 0 20px; color:#4a5e70;">
            	<table align="center">
                	<tr>
                    	<td>
                        <div style="font-weight:bold;">Periode yang dimutasi :</div><br>
                        <select name="reqTahunBuku" id="reqTahunBuku">
                        <?
                        for($i=0; $i<count($arrPeriode); $i++)
                        {
                        ?>
                            <option value="<?=$arrPeriode[$i]?>" <? if($reqPeriode == $arrPeriode[$i]) { ?> selected <? } ?>><?=$arrPeriodeNama[$i]?></option>
                        <?
                        }
                        ?>
                        </select><br>
                        </td>
                        <td width="100">&nbsp;</td>
                        <td>
                        <div style="font-weight:bold;">Mutasi Tahun Laporan :</div><br>
                        <select name="reqBukuTahun" id="reqBukuTahun">
                        <?
                        for($i=0; $i<count($arrPeriodeMutasiLaporan); $i++)
                        {
                        ?>
                            <option value="<?=$arrPeriodeMutasiLaporan[$i]?>" <? if($reqBukuTahun == $arrPeriodeMutasiLaporan[$i]) { ?> selected <? } ?>><?=$arrPeriodeNamaMutasiLaporan[$i]?></option>
                        <?
                        }
                        ?>
                        </select>
                        </td>
                    </tr>
                </table>
                
                
            </div>
            <div style="text-align:center;">
                <input type="button" id="btnBatal" name="btnBatal" value="Batal Proses">
                <input type="button" id="btnProses" name="btnProses" value="Proses">
            </div>            
          </form>
    </div>
</div>
</body>
</html>