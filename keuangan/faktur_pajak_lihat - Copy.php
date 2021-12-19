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
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajak.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajakD.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");


/* create objects */
$no_faktur_pajak = new NoFakturPajak();
$no_faktur_pajak_d = new NoFakturPajakD();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqKeterangan = httpFilterGet("reqKeterangan");

$no_faktur_pajak->selectByParams(array("NO_FAKTUR_PAJAK_ID" => $reqId));
$no_faktur_pajak->firstRow();	
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Pemakaian Nomor Faktur Pajak</span>
    </div>
    <form id="ff" method="post" novalidate>
    <!--<fieldset>
    	
    </fieldset>-->
    <div id="rincian-header">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td width="50">Periode</td>
                <td width="16">:</td>
                <td width="200"><?=getFormattedDate($no_faktur_pajak->getField("TANGGAL_AWAL"))?> s/d <?=getFormattedDate($no_faktur_pajak->getField("TANGGAL_AKHIR"))?></td>
                <td width="50">No. Faktur</td>
                <td width="16">:</td>
                <td width="486"><?=$no_faktur_pajak->getField("FAKTUR_PAJAK")?></td>                
            </tr>        
        </table>
    </div>
    
    <div id="rincian-table">
      <table id="table-gaya" width="100%" border="0" cellspacing="0" cellpadding="0">
        <!--<table class="example altrowstable" id="alternatecolor" >-->
        <thead>
          <tr>
             <th>No</th>
             <th>Faktur Pajak</th>
             <th>Status</th>
             <th>No.&nbsp;Nota</th>
          </tr>
        </thead>
        <tbody> 
          <?
          $i = 1;
          $no_faktur_pajak_d->selectByParams(array("NO_FAKTUR_PAJAK_ID"=>$reqId), -1, -1, "", " ORDER BY NOMOR ASC ");
          while($no_faktur_pajak_d->nextRow())
          {
          ?>
              <tr id="node-<?=$i?>">
                  <td><?=$i?></td>
                  <td>
                    <?=$no_faktur_pajak_d->getField("NOMOR")?>
                  </td>
                  <td <? if($no_faktur_pajak_d->getField("STATUS") == "1") { ?> style="color:#F00" <? } ?>>
					<?=$no_faktur_pajak_d->getField("KETERANGAN")?> 
                  </td>
                  <td>
                    <?=$no_faktur_pajak_d->getField("NO_NOTA")?>
                  </td>
               </tr>
          <?
		  	$i++;
          }
          ?>
        </tbody>     
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