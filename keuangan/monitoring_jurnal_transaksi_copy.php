<?
/* *******************************************************************************************************
MODUL NAME 			: informasi Kategori
FILE NAME 			: informasi_kategori.php
AUTHOR				: Aon-Prog
VERSION				: 1.0 beta
MODIFICATION DOC	:
DESCRIPTION			: Halaman untuk menampilkan informasi kategori
******************************************************************************************************* */

include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");


/* create objects */
$kbbt_jur_bb_tmp = new KbbtJurBb();
$kbbt_jur_bb_d_tmp = new KbbtJurBbD();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqKeterangan = httpFilterGet("reqKeterangan");

$kbbt_jur_bb_tmp->selectByParams(array("NO_NOTA" => $reqId));
$kbbt_jur_bb_tmp->firstRow();	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/global-tab-easyui.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
	<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/treeTable/doc/javascripts/jquery.ui.js"></script>
    <link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/treeTable/src/javascripts/jquery.treeTable.js"></script>
    <script type="text/javascript">

	/* KBBT_JUR_BB */
	$(function(){
		$('#ff').form({
			url:'../json-keuangansiuk/monitoring_jurnal_transaksi_copy.php',
			onSubmit:function(){
				return $(this).form('validate');
			},
			success:function(data){
				data = data.split("-");					
				$.messager.alert('Info', data[1], 'info');	
				<?
				if($kbbt_jur_bb_tmp->getField("JEN_JURNAL") == "JKK")
					$link = "jurnal_pengeluaran_kas_bank_add.php";
				else
					$link = "jurnal_rupa_rupa_add.php";				
				?>
				document.location.href = '<?=$link?>?reqId='+data[0];
				top.frames['mainFrame'].location.reload();
			}
		});
	});
			
    $(document).ready(function() {
    $(".example").treeTable({
      initialState: "expanded"
    });
    
    // Drag & Drop Example Code
    $("#dnd-example .file, #dnd-example .folder").draggable({
      helper: "clone",
      opacity: .75,
      refreshPositions: true,
      revert: "invalid",
      revertDuration: 300,
      scroll: true
    });
    
    $("#dnd-example .folder").each(function() {
      $($(this).parents("tr")[0]).droppable({
        accept: ".file, .folder",
        drop: function(e, ui) { 
          $($(ui.draggable).parents("tr")[0]).appendBranchTo(this);
          
          // Issue a POST call to send the new location (this) of the 
          // node (ui.draggable) to the server.
          $.post("move.php", {id: $(ui.draggable).parents("tr")[0].id, to: this.id});
        },
        hoverClass: "accept",
        over: function(e, ui) {
          if(this.id != $(ui.draggable.parents("tr.parent")[0]).id && !$(this).is(".expanded")) {
            $(this).expand();
          }
        }
      });
    });
    
    // Make visible that a row is clicked
    $("table#dnd-example tbody tr").mousedown(function() {
      $("tr.selected").removeClass("selected"); // Deselect currently selected rows
      $(this).addClass("selected");
    });
    
    // Make sure row is selected when span is clicked
    $("table#dnd-example tbody tr span").mousedown(function() {
      $($(this).parents("tr")[0]).trigger("mousedown");
    });
    });
	
</script>

	<!-- COLORING GRID -->
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ColoringGrid/css/table-style.css">
	<script type="text/javascript" src="../WEB-INF/lib/ColoringGrid/js/ColoringGrid.js"></script>
    
    

</head> 
<body onLoad="$('#reqBulan').focus()">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Rincian Bukti Jurnal</span>
    </div>
    <form id="ff" method="post" novalidate>
    <!--<fieldset>
    	
    </fieldset>-->
    <div id="rincian-header">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td width="10%">Bulan / Tahun</td>
                <td width="1%">:</td>
                <td width="94%"><input type="text" name="reqBulan" id="reqBulan" style="width:30px;" value="<?=date("m")?>" tabindex="1"> / <input type="text" name="reqTahun" id="reqTahun" style="width:50px;" value="<?=date("Y")?>" tabindex="2"></td>             
            </tr>
        	<tr>
            	<td>Tgl. Trans</td>
                <td>:</td>
                <td><input id="reqTanggalTransaksi" name="reqTanggalTransaksi" type="text" class="easyui-datebox" data-options="validType:'date'" value="<?=date("d-m-Y")?>"  tabindex="3" /></td>
                         
            </tr>
        	<tr>
            	<td valign="top">Keterangan</td>
                <td valign="top">:</td>
                <td><textarea name="reqKeteranganJurnal" style="width:400px; height:80px;"  tabindex="4" onMouseDown="tabindex=4"><?=$tempKeteranganJurnal?></textarea></td>
                             
            </tr>        
        </table>
        
            <input type="hidden" id="reqJenisJurnal" name="reqJenisJurnal" value="<?=$kbbt_jur_bb_tmp->getField("JEN_JURNAL")?>">
            <input type="hidden" id="reqId" name="reqId" value="<?=$reqId?>">
            <input type="hidden" id="reqMode" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" name="btnSubmit" id="btnSubmit" value="Submit">
     </div>
	</form>    
    <div id="rincian-table">
      <table id="table-gaya" width="100%" border="0" cellspacing="0" cellpadding="0">
        <!--<table class="example altrowstable" id="alternatecolor" >-->
        <thead>
          <tr>
              <th rowspan="2">No</th>
              <th rowspan="2">Buku&nbsp;Besar</th>
              <th rowspan="2">Kartu</th>
              <th rowspan="2">Buku&nbsp;Pusat</th>
              <th rowspan="2">Valuta</th>
              <th colspan="2">Valas</th>
              <th colspan="2">Rupiah</th>
          </tr>
          <tr>
             <th>Debet</th>
             <th>Kredit</th>
             <th>Debet</th>
             <th>Kredit</th>
          </tr>
        </thead>
        <tbody> 
          <?
          $i = 1;
          $checkbox_index = 0;
          $kbbt_jur_bb_d_tmp->selectByParamsJurnal(array("NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY NO_SEQ ASC ");
          $saldo_val_debet = 0;
          $saldo_val_kredit = 0;
          $saldo_rp_debet = 0;
          $saldo_rp_kredit = 0;
          
          while($kbbt_jur_bb_d_tmp->nextRow())
          {
          ?>
              <tr id="node-<?=$i?>">
                  <td><?=$i?></td>
                  <td>
                    <?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_BESAR")?> - <?=$kbbt_jur_bb_d_tmp->getField("NAMA_BB")?> 
                  </td>
                  <td>
                    <?=$kbbt_jur_bb_d_tmp->getField("KD_SUB_BANTU")?> - <?=$kbbt_jur_bb_d_tmp->getField("NAMA_KK")?> 
                  </td>
                  <td>
                    <?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_PUSAT")?> - <?=$kbbt_jur_bb_d_tmp->getField("NAMA_BP")?> 
                  </td>
                  <td>
                    <?=$kbbt_jur_bb_d_tmp->getField("KD_VALUTA")?>
                  </td>
                  <td align="right">
                    <?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_VAL_DEBET'))?>
                  </td>
                  <td align="right">
                    <?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_VAL_KREDIT'))?>
                  </td>
                  <td align="right">
                    <?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_RP_DEBET'))?>
                  </td>
                  <td align="right">
                    <?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_RP_KREDIT'))?>
                  </td></tr>
          <?
            $i++;
            $checkbox_index++;
            $saldo_val_debet += $kbbt_jur_bb_d_tmp->getField('SALDO_VAL_DEBET');
            $saldo_val_kredit += $kbbt_jur_bb_d_tmp->getField('SALDO_VAL_KREDIT');
            $saldo_rp_debet += $kbbt_jur_bb_d_tmp->getField('SALDO_RP_DEBET');
            $saldo_rp_kredit += $kbbt_jur_bb_d_tmp->getField('SALDO_RP_KREDIT');
          }
          ?>
        </tbody>            
        <tfoot>
        <td class="group_sum" colspan="5" style="text-align:right"><strong>Keseimbangan</strong></td>
          <td class="group_sum" align="right"><strong><?=numberToIna($saldo_val_debet)?></strong></td>
          <td class="group_sum" align="right"><strong><?=numberToIna($saldo_val_kredit)?></strong></td>
          <td class="group_sum" align="right"><strong><?=numberToIna($saldo_rp_debet)?></strong></td>
          <td class="group_sum" align="right"><strong><?=numberToIna($saldo_rp_kredit)?></strong></td>    
        </tfoot>
      </table>
    </div>
    <?
    if($saldo_rp_debet == $saldo_rp_kredit || $saldo_val_debet == $saldo_val_kredit)
		$hasil = "JURNAL SEIMBANG";
	else
		$hasil = "JURNAL TIDAK IMBANG";	
	?>
    <div style="width:100%; text-align:center; text-decoration:blink">
    <strong><?=$hasil?></strong>
    </div>
</div>
<script>
$('input[id^="reqJumlah"]').keypress(function(e) {
	if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>