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
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbDTmp.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");


/* create objects */
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqKeterangan = httpFilterGet("reqKeterangan");

	
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
</head> 
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Rincian Bukti Jurnal</span>
    </div>
    <form id="ff" method="post" novalidate>
    <fieldset>
    	<table>
        	<tr>
            	<td>No Bukti</td>
                <td>:</td>
                <td><?=$reqId?></td>
            </tr>
        	<tr>
            	<td>Keterangan</td>
                <td>:</td>
                <td><?=$reqKeterangan?></td>
            </tr>
        </table>
    </fieldset>
    <table class="example" id="dataTableRowDinamis">
    <thead>
      <tr>
          <th>
          	No
          </th>
          <th>Buku&nbsp;Besar</th>
          <th>Val</th>
          <th>Saldo&nbsp;Val&nbsp;Debet</th>
          <th>Saldo&nbsp;Val&nbsp;Kredit</th>
          <th>Saldo&nbsp;Rp&nbsp;Debet</th>
          <th>Saldo&nbsp;Val&nbsp;Kredit</th>
      </tr>
    </thead>
    <tbody> 
	  <?
	  $i = 1;
	  $checkbox_index = 0;
	  $kbbt_jur_bb_d_tmp->selectByParams(array("NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY NO_SEQ ASC ");
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
              	<?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_BESAR")?>
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
      	<td colspan="3" style="text-align:right">Keseimbangan</td>
        <td align="right"><?=$saldo_val_debet?></td>
        <td align="right"><?=$saldo_val_kredit?></td>
        <td align="right"><?=$saldo_rp_debet?></td>
        <td align="right"><?=$saldo_rp_kredit?></td>
    </tbody>            
    </table>
        <div style="display:none">
            <input type="hidden" id="reqId" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqArrayIndex" id="reqArrayIndex" value="<?=$checkbox_index?>" />
            <input type="hidden" id="reqMode" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" name="btnSubmit" id="btnSubmit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
	</form>
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