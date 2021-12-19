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
$eis_child = new EIS();
$eis_pulang_cepat = new EIS();
$eis_child_pulang_cepat = new EIS();
$eis_kehadiran = new EIS();
$eis_child_kehadiran = new EIS();

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");

$arrPeriode[] = date("m").date("Y");

$tempDateNow=date("Y-m-d", strtotime("-1 month", strtotime(date("Y-m-d"))));
for($i=1; $i <= 4; $i++)
{
	$arrPeriode[] = getMonth($tempDateNow).getYear($tempDateNow);
	$tempDateNow= date("Y-m-d", strtotime("-1 month", strtotime($tempDateNow)));
}

if($reqPeriode == "")
	$reqPeriode = date("m").date("Y");
	
$eis->selectByParamsDisiplinSDM(array("A.DEPARTEMEN_PARENT_ID" => 0), -1, -1, $reqPeriode);
$eis_pulang_cepat->selectByParamsPulangCepatSDM(array("A.DEPARTEMEN_PARENT_ID" => 0), -1, -1, $reqPeriode);
$eis_kehadiran->selectByParamsKehadiranSDM(array("A.DEPARTEMEN_PARENT_ID" => 0), -1, -1, $reqPeriode);

function getDepartemenByParent($id_induk, $parent, $reqPeriode)
{
	$child = new EIS();
	
	$child->selectByParamsDisiplinSDM(array("DEPARTEMEN_PARENT_ID"=>$id_induk), -1, -1, $reqPeriode);
		
	while($child->nextRow())
	{
		echo "
			  <tr id='node-".$child->getField('DEPARTEMEN_ID')."' class='child-of-node-".$child->getField('DEPARTEMEN_PARENT_ID')."'>
				<td><span class='file'>".$child->getField('NAMA')."</span></td>
				<td align='left'>".$child->getField("RATIO")." %</td>
			  </tr>
			 ";
		
	  getDepartemenByParent($child->getField("DEPARTEMEN_ID"), $child->getField('NAMA'), $reqPeriode);		
	}
	unset($child);
}

function getDepartemenByParentPulangCepat($id_induk, $parent,$reqPeriode)
{
	$child = new EIS();
	
	$child->selectByParamsPulangCepatSDM(array("DEPARTEMEN_PARENT_ID"=>$id_induk), -1, -1, $reqPeriode);
		
	while($child->nextRow())
	{
		echo "
			  <tr id='node-".$child->getField('DEPARTEMEN_ID')."' class='child-of-node-PC".$child->getField('DEPARTEMEN_PARENT_ID')."'>
				<td><span class='file'>".$child->getField('NAMA')."</span></td>
				<td align='left'>".$child->getField("RATIO")." %</td>
			  </tr>
			 ";
		
	  getDepartemenByParentPulangCepat($child->getField("DEPARTEMEN_ID"), $child->getField('NAMA'), $reqPeriode);		
	}
	unset($child);	
}

function getDepartemenByParentKehadiran($id_induk, $parent, $reqPeriode)
{
	$child = new EIS();
	
	$child->selectByParamsKehadiranSDM(array("DEPARTEMEN_PARENT_ID"=>$id_induk), -1, -1, $reqPeriode);
		
	while($child->nextRow())
	{
		echo "
			  <tr id='node-".$child->getField('DEPARTEMEN_ID')."' class='child-of-node-KH".$child->getField('DEPARTEMEN_PARENT_ID')."'>
				<td><span class='file'>".$child->getField('NAMA')."</span></td>
				<td align='left'>".$child->getField("RATIO")." %</td>
			  </tr>
			 ";
		
	  getDepartemenByParentKehadiran($child->getField("DEPARTEMEN_ID"), $child->getField('NAMA'), $reqPeriode);		
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
	  document.location.href = "ratio_tingkat_disiplin_sdm.php?reqHeight=<?=$reqHeight?>&reqPeriode=" + $("#reqPeriode").val();
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
	window.location.replace('ratio_tingkat_disiplin_sdm.php?reqPeriode=<?=$reqPeriode?>&reqHeight=' + screen.height);
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
<link href="../main/css/ScrollableTable.css" rel="stylesheet" type="text/css">  

</head>
<body style="overflow:hidden">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tingkat Disiplin SDM</span>
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
    
        <!--<div id="tableContainer" class="tableContainer">-->
            <div class="scroll">
              <div>
              <table class="example scrollTable" id="sf">
                    <thead class="fixedHeader">
                      <tr>
                          <th class="kolom-awal-thead">Kapal</th>
                          <th class="kolom-akhir-thead">Ratio</th>                                       
                      </tr>
                    </thead>
                    <tbody class="fullTinggi"> 
                    <tr id="node-PARENTTERLAMBAT">
                        <td class="kolom-awal-tbody jarak-tree-table">Terlambat</td>
                        <td></td>
                    <?
                    while($eis->nextRow())
                    {
        
                    ?> 
                        <tr id="node-KJ<?=$eis->getField("DEPARTEMEN_ID")?>"  class="child-of-node-PARENTTERLAMBAT">
                            <td><?=$eis->getField("NAMA")?></td>
                            <td><?=$eis->getField("RATIO")?> %</td>
                            <? 
                            $eis_child = new EIS();
                            $eis_child->selectByParamsDisiplinSDM(array("DEPARTEMEN_PARENT_ID" => $eis->getField("DEPARTEMEN_ID")), -1, -1, $reqPeriode);
                            while($eis_child->nextRow())
                            {
                            ?>
                                <tr id="node-<?=$eis_child->getField("DEPARTEMEN_ID")?>" class="child-of-node-KJ<?=$eis_child->getField("DEPARTEMEN_PARENT_ID")?>">
                                    <td><span class='file'><?=$eis_child->getField("NAMA")?></span></td>
                                    <td align="left"><?=$eis_child->getField("RATIO")?> %</td>
                                    <?
                                    getDepartemenByParent($eis_child->getField('DEPARTEMEN_ID'), $eis_child->getField('NAMA'), $reqPeriode);
                                    ?>
                                </tr>
                            <?
                            } 
                            ?>
                        </tr>
                    <?php
                        unset($eis_child);
                    }
                    ?>  
                    </tr>
                    <tr id="node-PARENTPULANGCEPAT">
                        <td style="padding-left:30px;">Pulang Cepat</td>
                        <td></td>
                    <?
                    while($eis_pulang_cepat->nextRow())
                    {
        
                    ?> 
                        <tr id="node-KA<?=$eis_pulang_cepat->getField("DEPARTEMEN_ID")?>"  class="child-of-node-PARENTPULANGCEPAT">
                            <td><?=$eis_pulang_cepat->getField("NAMA")?></td>
                            <td><?=$eis_pulang_cepat->getField("RATIO")?> %</td>
                            <? 
                            $eis_child_pulang_cepat = new EIS();
                            $eis_child_pulang_cepat->selectByParamsDisiplinSDM(array("DEPARTEMEN_PARENT_ID" => $eis_pulang_cepat->getField("DEPARTEMEN_ID")), -1, -1, $reqPeriode);
                            while($eis_child_pulang_cepat->nextRow())
                            {
                            ?>
                                <tr id="node-PC<?=$eis_child_pulang_cepat->getField("DEPARTEMEN_ID")?>" class="child-of-node-KA<?=$eis_child_pulang_cepat->getField("DEPARTEMEN_PARENT_ID")?>">
                                    <td><span class='file'><?=$eis_child_pulang_cepat->getField("NAMA")?></span></td>
                                    <td align="left"><?=$eis_child_pulang_cepat->getField("RATIO")?> %</td>
                                    <?
                                    getDepartemenByParentPulangCepat($eis_child_pulang_cepat->getField('DEPARTEMEN_ID'), $eis_child_pulang_cepat->getField('NAMA'), $reqPeriode);
                                    ?>
                                </tr>
                            <?
                            } 
                            ?>
                        </tr>
                    <?php
                        unset($eis_child_pulang_cepat);
                    }
                    ?>                 
                    </tr>
                    <tr id="node-PARENTKEHADIRAN">
                        <td style="padding-left:30px;">Kehadiran</td>
                        <td></td>
                    <?
                    while($eis_kehadiran->nextRow())
                    {
        
                    ?> 
                        <tr id="node-KB<?=$eis_kehadiran->getField("DEPARTEMEN_ID")?>"  class="child-of-node-PARENTKEHADIRAN">
                            <td><?=$eis_kehadiran->getField("NAMA")?></td>
                            <td><?=$eis_kehadiran->getField("RATIO")?> %</td>
                            <? 
                            $eis_child_kehadiran = new EIS();
                            $eis_child_kehadiran->selectByParamsDisiplinSDM(array("DEPARTEMEN_PARENT_ID" => $eis_kehadiran->getField("DEPARTEMEN_ID")), -1, -1, $reqPeriode);
                            while($eis_child_kehadiran->nextRow())
                            {
                            ?>
                                <tr id="node-KH<?=$eis_child_kehadiran->getField("DEPARTEMEN_ID")?>" class="child-of-node-KB<?=$eis_child_kehadiran->getField("DEPARTEMEN_PARENT_ID")?>">
                                    <td><span class='file'><?=$eis_child_kehadiran->getField("NAMA")?></span></td>
                                    <td align="left"><?=$eis_child_kehadiran->getField("RATIO")?> %</td>
                                    <?
                                    getDepartemenByParentKehadiran($eis_child_kehadiran->getField('DEPARTEMEN_ID'), $eis_child_kehadiran->getField('NAMA'), $reqPeriode);
                                    ?>
                                </tr>
                            <?
                            } 
                            ?>
                        </tr>
                    <?php
                        unset($eis_child_kehadiran);
                    }
                    ?>                  
                    </tr>   
                    
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>         
                   </tbody>            
                  </table>         
              </div> 
            </div> 
        <!--</div>-->
    </div>

</div>
</body>
</html>