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
$kbbt_jur_bb_d = new KbbtJurBbD();
$kbbt_jur_bb = new KbbtJurBb();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqKeterangan = httpFilterGet("reqKeterangan");

$kbbt_jur_bb->selectByParams(array("NO_NOTA" => $reqId));
$kbbt_jur_bb->firstRow();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
	<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/treeTable/doc/javascripts/jquery.ui.js"></script>
    <link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/treeTable/src/javascripts/jquery.treeTable.js"></script>
    <script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/jurnal_ubah.php',
				onSubmit:function(){
					if(confirm("Ubah rincian jurnal?"))					
						return $(this).form('validate');
					else
						return false;
				},
				success:function(data){
					data = data.split("-");					
					$.messager.alert('Info', data[1], 'info');	
					document.location.href = 'jurnal_ubah.php?reqId='+data[0];
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
	
	$('#btnCetakBukti').on('click', function () {
	   alert('Belum Ada Report');			  		
	});
	
</script>

	<!-- COLORING GRID -->
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ColoringGrid/css/table-style.css">
	<script type="text/javascript" src="../WEB-INF/lib/ColoringGrid/js/ColoringGrid.js"></script>
    
    

</head> 
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Rincian Bukti Jurnal</span>
    </div>
    <form id="ff" method="post" novalidate>
    <div id="rincian-header">	
    	<table>
        	<tr>
            	<td>No Bukti</td>
                <td>:</td>
                <td><?=$reqId?></td>
                <td style="width:100px;">
            	<td>Tgl. Trans</td>
                <td>:</td>
                <td><?=getFormattedDate($kbbt_jur_bb->getField("TGL_TRANS"))?></td>                
            </tr>
        	<tr>
            	<td>Pelanggan</td>
                <td>:</td>
                <td><?=$kbbt_jur_bb->getField("KD_KUSTO")?> - <?=$kbbt_jur_bb->getField("MPLG_NAMA")?></td>
                <td>
            	<td>Kode Valuta</td>
                <td>:</td>
                <td><?=$kbbt_jur_bb->getField("KD_VALUTA")?></td>                
            </tr>
        	<tr>
            	<td>Bukti&nbsp;Pendukung</td>
                <td>:</td>
                <td><?=$kbbt_jur_bb->getField("NO_REF1")?></td>
                <td>
            	<td>No / Tanggal Posting</td>
                <td>:</td>
                <td><?=$kbbt_jur_bb->getField("NO_POSTING")?> / <?=getFormattedDate($kbbt_jur_bb->getField("TGL_POSTING"))?></td>                
            </tr>
        </table>
    </div>
    
    <div id="rincian-table">
    <table id="table-gaya" width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
          <th rowspan="2">Buku&nbsp;Besar</th>
          <th rowspan="2">Kartu</th>
          <th rowspan="2">Buku Pusat</th>
          <th colspan="2">D/K</th>
      </tr>
	  <tr>
      	 <th>Debet</th>
      	 <th>Kredit</th>
      </tr>
    </thead>
    <tbody> 
	  <?
	  $i = 1;
	  $checkbox_index = 0;
	  $kbbt_jur_bb_d->selectByParams(array("NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY NO_SEQ ASC ");
	  $saldo_val_debet = 0;
	  $saldo_val_kredit = 0;
	  $saldo_rp_debet = 0;
	  $saldo_rp_kredit = 0;
	  
      while($kbbt_jur_bb_d->nextRow())
	  {
      ?>
          <tr id="node-<?=$i?>">
             <td>
             	
                <input id="reqNoSeq<?=$checkbox_index?>" name="reqNoSeq[]" type="hidden" value="<?=$kbbt_jur_bb_d->getField("NO_SEQ")?>">
                <input id="reqBukuBesar<?=$checkbox_index?>" name="reqBukuBesar[]" class="easyui-combobox" data-options="
                required: true,
                filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                valueField: 'id', textField: 'text',
                url: '../json-keuangansiuk/buku_besar_combo_json.php',
                onSelect:function(rec){
                    disableByPolaEntry(rec.POLA_ENTRY_ID, '<?=$checkbox_index?>');
                }
                "
                value="<?=$kbbt_jur_bb_d->getField("KD_BUKU_BESAR")?>" style="width:165px" />
              </td>
              <td>
                <input id="reqKartu<?=$checkbox_index?>" name="reqKartu[]" class="easyui-combobox" data-options="
                filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                valueField: 'id', textField: 'text',
                url: '../json-keuangansiuk/kartu_tambah_combo_json.php',
                onSelect:function(rec){
                }
                "
                value="<?=$kbbt_jur_bb_d->getField("KD_SUB_BANTU")?>" style="width:165px" <? if($kbbt_jur_bb_d->getField("DISABLE_KARTU") == "DISABLED") {} else { ?> <? } ?> <?=$kbbt_jur_bb_d->getField("DISABLE_KARTU")?>  />
              </td>
              <td>
                <input id="reqBukuPusat<?=$checkbox_index?>" name="reqBukuPusat[]" class="easyui-combobox" data-options="
                filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                valueField: 'id', textField: 'text',
                url: '../json-keuangansiuk/buku_pusat_combo_json.php',
                onSelect:function(rec){
                }
                "
                value="<?=$kbbt_jur_bb_d->getField("KD_BUKU_PUSAT")?>" style="width:165px" <? if($kbbt_jur_bb_d->getField("DISABLE_BPUSAT") == "DISABLED") {} else { ?> <? } ?> <?=$kbbt_jur_bb_d->getField("DISABLE_BPUSAT")?> />
              </td>
              <td>
                <input type="text" name="reqDebet[]" id="reqDebet<?=$checkbox_index?>" style="text-align:right; width:95%;" readonly value="<?=numberToIna($kbbt_jur_bb_d->getField('SALDO_VAL_DEBET'))?>">
              </td>
              <td>
                <input type="text" name="reqKredit[]" id="reqKredit<?=$checkbox_index?>" style="text-align:right; width:95%;" readonly value="<?=numberToIna($kbbt_jur_bb_d->getField('SALDO_VAL_KREDIT'))?>">
              </td>
			  </tr>
     			 <?
                $i++;
                $checkbox_index++;
                $temp_jml_debet += $kbbt_jur_bb_d->getField('SALDO_VAL_DEBET');
                $temp_jml_kredit += $kbbt_jur_bb_d->getField('SALDO_VAL_KREDIT');
				  }
				  ?>
    </tbody>            
        <tfoot class="altrowstable">
        	<tr style="background:#f1f4fc">
            	<td colspan="3">
                <div>
                    <input type="checkbox" id="reqAll" name="reqAll" disabled <? if($reqAll == 'on') echo "checked";?>>
                    <label for="reqAll">All</label> 
                
                    <input type="checkbox" id="reqBalance" name="reqBalance" disabled <? if(floor($temp_jml_debet) == floor($temp_jml_kredit)) { ?> checked <? } ?>>
                    <label for="reqBalance">Balance</label> 
                
                    <input type="checkbox" id="reqUnbalance" name="reqUnbalance" disabled <? if(floor($temp_jml_debet) == floor($temp_jml_kredit)) {} else { ?> checked <? } ?>>
                    <label for="reqUnbalance">Unbalance</label> 
                </div>
                </td>
            	<td class=""><input type="text" id="reqJumlahDebet" name="reqJumlahDebet" style="text-align:right; width:95%;" readonly value="<?=numberToIna($temp_jml_debet)?>" /></td>
            	<td class=""><input type="text" id="reqJumlahKredit" name="reqJumlahKredit" style="text-align:right; width:95%;" readonly value="<?=numberToIna($temp_jml_kredit)?>" /></td>

            </tr>
        </tfoot>
    </table>
    <br>

	<div style="width:100%; text-align:center;">
    <input type="hidden" name="reqId" value="<?=$reqId?>">
    <input type="submit" name="btnSubmit" id="btnSubmit" value="Submit">
    <?php /*?><input type="button" name="btnCetakBukti" id="btnCetakBukti" value="Cetak Bukti"><?php */?>
    <input type="button" name="btnExit" id="btnExit" value="Exit" onClick="window.parent.divwin.close();">
	</div>
	</form>
    <div style="width:100%; text-align:center; text-decoration:blink">
    <strong><?=$hasil?></strong>
    </div>
</div>
</body>
</html>