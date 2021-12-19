<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtNeracaSaldo.php");

$kbbt_neraca_saldo = new KbbtNeracaSaldo();

$reqBulan = httpFilterGet("reqBulan");
$reqTahun = httpFilterGet("reqTahun");
$reqKodeValuta = httpFilterGet("reqKodeValuta");
$reqKodeBukuBesar = httpFilterGet("reqKodeBukuBesar");
$reqKodeSubBantu = httpFilterGet("reqKodeSubBantu");
$reqTipe = httpFilterGet("reqTipe");

if($reqTipe == "D")
{
	$kbbt_neraca_saldo->selectByParamsLihatDebet($reqBulan, $reqTahun, $reqKodeBukuBesar, $reqKodeSubBantu, $reqKodeValuta);
	$caption = "Debet";
}
else
{
	$kbbt_neraca_saldo->selectByParamsLihatKredit($reqBulan, $reqTahun, $reqKodeBukuBesar, $reqKodeSubBantu, $reqKodeValuta);
	$caption = "Kredit";
}
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
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
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
	
	function OpenDHTMLPopup(opAddress, opCaption, opWidth, opHeight)
	{
		var left = (screen.width/2)-(opWidth/2);
		var top = (screen.height/2)-(opHeight/2) - 100;
		
		divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
	}	
	
</script>

	<!-- COLORING GRID -->
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ColoringGrid/css/table-style.css">
	<script type="text/javascript" src="../WEB-INF/lib/ColoringGrid/js/ColoringGrid.js"></script>
    
    

</head> 
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Rincian Transaksi (<?=$caption?>)</span>
    </div>
    <form id="ff" method="post" novalidate>
    <div id="rincian-table">
      <table id="table-gaya" width="100%" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
              <th>No&nbsp;Bukti</th>
              <th>Jen&nbsp;Jurnal</th>
              <th>Tgl&nbsp;Trans</th>
              <th>Jml&nbsp;Transaksi</th>
              <th>Keterangan</th>
              <th>Obyek</th>
          </tr>
        </thead>
        <tbody> 
          <?
          $i = 1;
		  $total = 0;
          while($kbbt_neraca_saldo->nextRow())
          {
          ?>
              <tr id="node-<?=$i?>" onClick="OpenDHTMLPopup('monitoring_jurnal_transaksi_lihat.php?reqId=<?=$kbbt_neraca_saldo->getField("NO_NOTA")?>', 'Rincian Jurnal', 900, 600)">
                  <td>
                    <?=$kbbt_neraca_saldo->getField("NO_NOTA")?>
                  </td>
                  <td>
                    <?=$kbbt_neraca_saldo->getField("JEN_JURNAL")?>
                  </td>
                  <td>
                    <?=getFormattedDate($kbbt_neraca_saldo->getField("TGL_TRANS"))?>
                  </td>
                  <td align="right">
                    <?=numberToIna($kbbt_neraca_saldo->getField('JML_VAL_TRANS'))?>
                  </td>
                  <td align="right">
                    <?=numberToIna($kbbt_neraca_saldo->getField('JML_VAL_TRANS'))?>
                  </td>
                  <td align="right">
                    <?=numberToIna($kbbt_neraca_saldo->getField('JML_VAL_TRANS'))?>
                  </td>
          <?
            $i++;
			$total += $kbbt_neraca_saldo->getField('JML_VAL_TRANS');
          }
          ?>
        </tbody>          
        <tfoot>
          <tr>
              <td class="group_sum" colspan="3" style="text-align:right">Total</td>
              <td class="group_sum" style="text-align:right"><?=numberToIna($total)?></td>
              <td class="group_sum" style="text-align:right"><?=numberToIna($total)?></td>
              <td class="group_sum" style="text-align:right"><?=numberToIna($total)?></td>
          </tr>        
        </tfoot>
      </table>
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