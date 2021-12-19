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
include_once("../WEB-INF/classes/base/EIS.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

/* create objects */
$eis = new EIS();
$eis_cabang = new EIS();
$eis_child = new EIS();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");

$tempDateNow=date("Y-m-d", strtotime("+5 month", strtotime(date("Y-m-d"))));
for($i=1; $i <= 4; $i++)
{	
	$arrPeriode[] = getMonth($tempDateNow).getYear($tempDateNow);
	$tempDateNow= date("Y-m-d", strtotime("-1 month", strtotime($tempDateNow)));
}

$arrPeriode[] = date("m").date("Y");

$tempDateNow=date("Y-m-d", strtotime("-1 month", strtotime(date("Y-m-d"))));
for($i=1; $i <= 4; $i++)
{
	$arrPeriode[] = getMonth($tempDateNow).getYear($tempDateNow);
	$tempDateNow= date("Y-m-d", strtotime("-1 month", strtotime($tempDateNow)));	
}

if($reqPeriode == "")
	$reqPeriode = date("m").date("Y");

$eis_cabang->selectByParamsPemenuhanFormasiSDMCabang(array(), -1,-1, $reqPeriode);

function getDepartemenByParent($id_induk, $parent, $reqPeriode)
{
	$child = new EIS();
	
	$child->selectByParamsPemenuhanFormasiSDM(array("DEPARTEMEN_PARENT_ID"=>$id_induk), -1, -1, $reqPeriode);
		
	while($child->nextRow())
	{
		echo "
			  <tr id='node-".$child->getField('DEPARTEMEN_ID')."' class='child-of-node-".$child->getField('DEPARTEMEN_PARENT_ID')."'>
				<td><span class='file'>".$child->getField('NAMA')."</span></td>
				<td width='50' align='left'>".$child->getField("FORMASI")."</td>
				<td width='50' align='left'>".$child->getField("PEMENUHAN")."</td>
				<td width='50' align='left'>".$child->getField("LEVEL_3")." %</td>
			  </tr>
			 ";
		
	  getDepartemenByParent($child->getField("DEPARTEMEN_ID"), $child->getField('NAMA'), $reqPeriode);		
	}
	unset($child);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>Diklat</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">

<link href="../WEB-INF/lib/treeTable/doc/stylesheets/master.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../WEB-INF/lib/treeTable/doc/javascripts/jquery.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/treeTable/doc/javascripts/jquery.ui.js"></script>
<link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../WEB-INF/lib/treeTable/src/javascripts/jquery.treeTable.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$(".example").treeTable({
  initialState: "collapsed"
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
$(document).ready( function () {
	$("#reqPeriode").change(function() {
	  document.location.href = "ratio_pemenuhan_formasi_sdm.php?reqHeight=<?=$reqHeight?>&reqPeriode=" + $("#reqPeriode").val();
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

<?
if($reqHeight == "")
{
?>
<script type="text/javascript">
	window.location.replace('ratio_pemenuhan_formasi_sdm.php?reqHeight=' + screen.height);
</script>
<?
}
?>
<style type="text/css">
<!--
div.scroll {
height: <?=$reqHeight - 360?>px;
width: 98%;
overflow: auto;
padding: 8px;
}
-->
</style> 

<!-- CSS for Drop Down Tabs Menu #2 -->
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  
<link rel="stylesheet" type="text/css" href="../WEB-INF/css/bluetabs.css" />
<script type="text/javascript" src="../WEB-INF/css/dropdowntabs.js"></script>
<script language="JavaScript" src="../jslib/displayElement.js"></script>  

<!-- CSS for Scrollable Table -->
<link href="../WEB-INF/css/ScrollableTable.css" rel="stylesheet" type="text/css">

</head>
<body style="overflow:hidden">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Pemenuhan Formasi SDM</span>
            </div>            
            </td>
        </tr>
    </table>
    <div id="konten">
    	Periode : <select name="reqPeriode" id="reqPeriode">
        		  <?
                  for($i=0;$i<count($arrPeriode);$i++)
				  {
				  ?>
                  	<option value="<?=$arrPeriode[$i]?>" <? if($reqPeriode == $arrPeriode[$i]) { ?> selected <? } ?>><?=getNamePeriode($arrPeriode[$i])?></option>
                  <?	  
				  }
				  ?>
        		  </select>&nbsp;&nbsp;
    </div>
 		
    
    <!--<div id="tableContainer" class="tableContainer">-->
    <div class="scroll">
      <div>
      <table class="example scrollTable" id="sf">
            <thead class="fixedHeader">
              <tr>
                  <th class="kolom-awal-thead">Departemen</th>
                  <th width="50">Formasi</th>
                  <th width="50">Pemenuhan</th>
                  <th width="50">Level 3</th>
                  <th width="50">Level 2</th>
                  <th width="50">Level 1</th>
                  <th align="left" class="kolom-akhir-thead">Level 0</th>                                       
              </tr>
            </thead>
            <tbody class="fullTinggi"> 
            
            <?
			while($eis_cabang->nextRow())
			{
			?>
                <tr id="node-CAB<?=$eis_cabang->getField("CABANG_ID")?>">
                    <td class="kolom-awal-tbody"><?=$eis_cabang->getField("NAMA")?></td>
                    <td width="50"><?=$eis_cabang->getField("FORMASI")?></td>
                    <td width="50"><?=$eis_cabang->getField("PEMENUHAN")?></td>
                    <td width="50"></td>
                    <td width="50"></td>
                    <td width="50"></td>
                    <td class="kolom-akhir-tbody"><?=$eis_cabang->getField("RATIO")?> %</td>               
			<?
				$i=0;
				$eis->selectByParamsPemenuhanFormasiSDM(array("A.DEPARTEMEN_PARENT_ID" => 0, "A.CABANG_ID" => $eis_cabang->getField("CABANG_ID")), -1, -1, $reqPeriode);
				while($eis->nextRow())
				{
	
				?> 
					<tr id="node-KJ<?=$eis->getField("DEPARTEMEN_ID")?>" class="child-of-node-CAB<?=$eis_cabang->getField("CABANG_ID")?>">
						<td class="kolom-awal-tbody"><?=$eis->getField("NAMA")?></td>
						<td width="50"><?=$eis->getField("FORMASI")?></td>
						<td width="50"><?=$eis->getField("PEMENUHAN")?></td>
						<td width="50"><?=$eis->getField("LEVEL_3")?> %</td>
						<td width="50"></td>
						<td width="50" rowspan=""><?=$eis->getField("LEVEL_1")?> %</td>
						<? 
						$eis_child = new EIS();
						$eis_child->selectByParamsPemenuhanFormasiSDM(array("DEPARTEMEN_PARENT_ID" => $eis->getField("DEPARTEMEN_ID")), -1, -1, $reqPeriode);
						while($eis_child->nextRow())
						{
						?>
							<tr id="node-<?=$eis_child->getField("DEPARTEMEN_ID")?>" class="child-of-node-KJ<?=$eis_child->getField("DEPARTEMEN_PARENT_ID")?>">
								<td><span class='file'><?=$eis_child->getField("NAMA")?></span></td>
								<td width="50"><?=$eis_child->getField("FORMASI")?></td>
								<td width="50"><?=$eis_child->getField("PEMENUHAN")?></td>
								<td width="50"><?=$eis_child->getField("LEVEL_3")?> %</td>
								<td width="50"><?=$eis_child->getField("LEVEL_2")?> %</td>
								<?
								getDepartemenByParent($eis_child->getField('DEPARTEMEN_ID'), $eis_child->getField('NAMA'), $reqPeriode);
								?>
							</tr>
						<?
						} 
						?>
					</tr>
				<?php
					$i++;
					unset($departemen);
				}
            ?>  
          		</tr>
            <?
            }
			?>
 			<tr>            
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
            	<td>&nbsp;</td>
            </tr>
           </tbody>            
          </table>         
      </div> 
    </div> 
   <!-- </div>-->

</div>
</body>
</html>