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
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/TmpAgingRollRate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmPelanggan.php");

/* create objects */
$tmp_aging_roll_rate = new TmpAgingRollRate();
$safm_pelanggan = new SafmPelanggan();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqTanggal = httpFilterGet("reqTanggal");
$reqKodeValuta = httpFilterGet("reqKodeValuta");
$arrTahunBulan = explode("-", $reqTanggal);
$reqTahunBulan = $arrTahunBulan[2].$arrTahunBulan[1];

$safm_pelanggan->selectByParams(array("MPLG_KODE" => $reqId));
$safm_pelanggan->firstRow();

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

	<!-- COLORING GRID -->
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ColoringGrid/css/table-style.css">
	<script type="text/javascript" src="../WEB-INF/lib/ColoringGrid/js/ColoringGrid.js"></script>
    
    

</head> 
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Rincian Aging Piutang</span>
    </div>
    <form id="ff" method="post" novalidate>
    <!--<fieldset>
    	
    </fieldset>-->
    <div id="rincian-header">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td width="165">Kode</td>
                <td width="16">:</td>
                <td width="413"><?=$reqId?></td>
                <td width="165">Tgl. Batas</td>
                <td width="16">:</td>
                <td width="486"><?=$reqTanggal?></td>                
            </tr>
        	<tr>
            	<td>Pelanggan</td>
                <td>:</td>
                <td><?=$safm_pelanggan->getField("MPLG_NAMA")?></td>
                <td>Kode Valuta</td>
                <td>:</td>
                <td><?=$reqKodeValuta?></td>                
            </tr>
        	<tr>
            	<td>Badan Usaha</td>
                <td>:</td>
                <td><?=$safm_pelanggan->getField("MPLG_BADAN_USAHA")?></td>       
            </tr>        
        </table>
    </div>
    
    <div id="rincian-table">
      <table id="table-gaya" width="100%" border="0" cellspacing="0" cellpadding="0">
        <!--<table class="example altrowstable" id="alternatecolor" >-->
        <thead>
          <tr>
              <th>No. Nota</th>
              <th>No.&nbsp;Invoice</th>
              <th>No.&nbsp;Posting</th>
              <th>Keterangan</th>
              <th>Saldo Awal</th>		
              <th>Debet</th>		
              <th>Kredit</th>		
              <th>Saldo Akhir</th>			
          </tr>
        </thead>
        <tbody> 
          <?
          $i = 1;
          $tmp_aging_roll_rate->selectByParamsAgingPiutangRincian(array("KD_KUSTO" => $reqId), $reqTanggal, $reqTahunBulan, $reqKodeValuta);
          $saldo = 0;
          $keterangan = "";
          while($tmp_aging_roll_rate->nextRow())
          {
			  if($keterangan == $tmp_aging_roll_rate->getField("KETERANGAN"))
			  {}
			  else
			  {
				  if($keterangan == "")
				  {}
				  else
				  {
          ?>
                    <tr>
                    	<td class="group_sum" colspan="7" style="text-align:right"><strong>Total</strong></td>
                        <td class="group_sum" style="text-align:right"><strong><?=numberToIna($saldo)?></strong></td>
                    </tr>    
          
          <?
		  			$saldo = 0;
				  }
		  ?>
          		<tr>
		            <td class="group_sum" colspan="8"><strong><?=$tmp_aging_roll_rate->getField("KETERANGAN")?></strong></td>
                </tr>    
          <?
			  }
		  ?>
              <tr id="node-<?=$i?>">
                  <td>
                    <?=$tmp_aging_roll_rate->getField("NO_NOTA")?> 
                  </td>
                  <td>
                    <?=$tmp_aging_roll_rate->getField("NO_REF3")?> 
                  </td>
                  <td>
                    <?=$tmp_aging_roll_rate->getField("NO_POSTING")?> 
                  </td>
                  <td>
                    <?=$tmp_aging_roll_rate->getField("KET_TAMBAHAN")?>
                  </td>
                  <td align="right">
                    <?=numberToIna($tmp_aging_roll_rate->getField('JML_SALDO_AWAL'))?>
                  </td>				 
                  <td align="right">
                    <?=numberToIna($tmp_aging_roll_rate->getField('JML_DEBET'))?>
                  </td>				 
                  <td align="right">
                    <?=numberToIna($tmp_aging_roll_rate->getField('JML_KREDIT'))?>
                  </td>				 
                  <td align="right">
                    <?=numberToIna($tmp_aging_roll_rate->getField('SALDO'))?>
                  </td>				 
                </tr>
          <?
            $i++;
            $saldo += $tmp_aging_roll_rate->getField('SALDO');
			$keterangan = $tmp_aging_roll_rate->getField("KETERANGAN");
          }
          ?>
            <tr>
                <td class="group_sum" colspan="7" style="text-align:right"><strong>Total</strong></td>
                <td class="group_sum" style="text-align:right"><strong><?=numberToIna($saldo)?></strong></td>
            </tr>             
        </tbody>      
      </table>
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