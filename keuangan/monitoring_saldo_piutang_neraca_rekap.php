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
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtNeracaSaldo.php");


/* create objects */
$kbbt_nerara_saldo = new KbbtNeracaSaldo();

$reqKodeValuta = httpFilterGet("reqKodeValuta");
$reqPeriode = httpFilterGet("reqPeriode");

$statement = " AND A.BULTAH = '".$reqPeriode."' AND A.KD_VALUTA = '".$reqKodeValuta."' ";	
if($reqKodeValuta == "IDR")
{
	$abri = $kbbt_nerara_saldo->getSumByParamsSaldoPiutangNeraca(array(), " AND A.KD_BB_KUSTO LIKE '104.01%' ");
	$pemerintah =  $kbbt_nerara_saldo->getSumByParamsSaldoPiutangNeraca(array(), " AND A.KD_BB_KUSTO LIKE '104.02%' ");
	$bumn =  $kbbt_nerara_saldo->getSumByParamsSaldoPiutangNeraca(array(), " AND A.KD_BB_KUSTO LIKE '104.03%' ");
	$swasta =  $kbbt_nerara_saldo->getSumByParamsSaldoPiutangNeraca(array(), " AND A.KD_BB_KUSTO LIKE '104.04%' ");
	$perorangan =  $kbbt_nerara_saldo->getSumByParamsSaldoPiutangNeraca(array(), " AND A.KD_BB_KUSTO LIKE '104.05%' ");
}
else
{
	$abri = $kbbt_nerara_saldo->getSumByParamsSaldoPiutangNeraca(array(), " AND A.KD_BB_KUSTO LIKE '104.06%' ");
	$pemerintah =  $kbbt_nerara_saldo->getSumByParamsSaldoPiutangNeraca(array(), " AND A.KD_BB_KUSTO LIKE '104.07%' ");
	$bumn =  $kbbt_nerara_saldo->getSumByParamsSaldoPiutangNeraca(array(), " AND A.KD_BB_KUSTO LIKE '104.08%' ");
	$swasta =  $kbbt_nerara_saldo->getSumByParamsSaldoPiutangNeraca(array(), " AND A.KD_BB_KUSTO LIKE '104.09%' ");
	$perorangan =  $kbbt_nerara_saldo->getSumByParamsSaldoPiutangNeraca(array(), " AND A.KD_BB_KUSTO LIKE '104.10%' ");	
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Rincian Bukti Jurnal</span>
    </div>
    <form id="ff" method="post" novalidate>
    <div id="rincian-table">
      <table id="table-gaya" width="100%" border="0" cellspacing="0" cellpadding="0">
        <!--<table class="example altrowstable" id="alternatecolor" >-->
        <thead>
          <tr>
              <th>Badan&nbsp;Usaha</th>
              <th>Total</th>
          </tr>
        </thead>
        <tbody> 
		<tr>
			<td>ABRI</td>
            <td><?=numberToIna($abri)?></td>
        </tr>
		<tr>
			<td>PEMERINTAH</td>
            <td><?=numberToIna($pemerintah)?></td>
        </tr>
		<tr>
			<td>BUMN</td>
            <td><?=numberToIna($bumn)?></td>
        </tr>
		<tr>
			<td>SWASTA</td>
            <td><?=numberToIna($swasta)?></td>
        </tr>
		<tr>
			<td>PERORANGAN</td>
            <td><?=numberToIna($perorangan)?></td>
        </tr>
        </tbody>            
      </table>
    </div>   
</div>
</body>
</html>