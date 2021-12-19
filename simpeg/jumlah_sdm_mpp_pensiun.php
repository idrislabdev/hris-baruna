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
$mpp = new EIS();
$mpp_child = new EIS();

$pensiun = new EIS();
$pensiun_child = new EIS();

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

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
	
$mpp->selectByParamsJumlahMPPPensiun(array("A.DEPARTEMEN_PARENT_ID" => 0), -1, -1, $reqPeriode, 55);
$pensiun->selectByParamsJumlahMPPPensiun(array("A.DEPARTEMEN_PARENT_ID" => 0), -1, -1, $reqPeriode, 56);


function getDepartemenByParentMPP($id_induk, $parent, $periode)
{
	$child = new EIS();
	
	$child->selectByParamsJumlahMPPPensiun(array("DEPARTEMEN_PARENT_ID"=>$id_induk), -1, -1, $periode, 55);
		
	while($child->nextRow())
	{
		
		if($child->getField("JUMLAH") > 0)
			$button = '<input type="button" name="reqLihat" value="Lihat" onClick="viewDetil(\''.$child->getField("DEPARTEMEN_ID").'\',\'55\',\''.$periode.'\');">';

		echo "
			  <tr id='node-".$child->getField('DEPARTEMEN_ID')."' class='child-of-node-CHILDMPP".$child->getField('DEPARTEMEN_PARENT_ID')."'>
				<td><span class='file'>".$child->getField('NAMA')."</span></td>
				<td align='left'>".$child->getField("JUMLAH")."</td>
				<td>".$button."
				</td>				
			  </tr>
			 ";
		$button = "";
	  getDepartemenByParentMPP($child->getField("DEPARTEMEN_ID"), $child->getField('NAMA'), $periode);		
	}
	unset($child);
}

function getDepartemenByParentPensiun($id_induk, $parent, $periode)
{
	$child = new EIS();
	
	$child->selectByParamsJumlahMPPPensiun(array("DEPARTEMEN_PARENT_ID"=>$id_induk), -1, -1, $periode, 56);
		
	while($child->nextRow())
	{
		if($child->getField("JUMLAH") > 0)
			$button = '<input type="button" name="reqLihat" value="Lihat" onClick="viewDetil(\''.$child->getField("DEPARTEMEN_ID").'\',\'56\',\''.$periode.'\');">';

		echo "
			  <tr id='node-".$child->getField('DEPARTEMEN_ID')."' class='child-of-node-CHILDPENSIUN".$child->getField('DEPARTEMEN_PARENT_ID')."'>
				<td><span class='file'>".$child->getField('NAMA')."</span></td>
				<td align='left'>".$child->getField("JUMLAH")."</td>
				<td>".$button."
				</td>				
			  </tr>
			 ";
		$button = "";
		
	  getDepartemenByParentPensiun($child->getField("DEPARTEMEN_ID"), $child->getField('NAMA'), $periode);		
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
$(document).ready( function () {
	$("#reqPeriode").change(function() {
	  document.location.href = "jumlah_sdm_mpp_pensiun.php?reqHeight=<?=$reqHeight?>&reqPeriode=" + $("#reqPeriode").val();
	});	
});

function viewDetil(departemenid,batas,periode)
{
	window.parent.OpenDHTML('jumlah_sdm_mpp_pensiun_detil.php?reqDepartemenId='+departemenid+'&reqBatas='+batas+'&reqPeriode='+periode+'', 'Office Management - Dashboarding', '600', '300');
}
</script>

<?
if($reqHeight == "")
{
?>
<script type="text/javascript">
	window.location.replace('jumlah_sdm_mpp_pensiun.php?reqHeight=' + screen.height + '&reqPeriode=<?=$reqPeriode?>');
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Jumlah SDM MPP &amp; Pensiun</span>
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
                          <th class="kolom-awal-thead">Departemen</th>
                          <th style="width:100px;">Jumlah</th>                                       
                          <th class="kolom-akhir-thead">Aksi</th>                                       
                      </tr>
                    </thead>
                    <tbody class="fullTinggi"> 
                    <tr id="node-MPP">
                        <td class="kolom-awal-tbody jarak-tree-table">MPP</td>
                        <td width="100px"></td>
                    <?
                    while($mpp->nextRow())
                    {
        
                    ?> 
                        <tr id="node-PARENTMPP<?=$mpp->getField("DEPARTEMEN_ID")?>"  class="child-of-node-MPP">
                            <td><?=$mpp->getField("NAMA")?></td>
                            <td><?=$mpp->getField("JUMLAH")?></td>
                            <td>
                            <?
                            if($mpp->getField("JUMLAH") > 0)
                            {
                            ?>
                                <input type="button" name="reqLihat" value="Lihat" onClick="viewDetil('<?=$mpp->getField("DEPARTEMEN_ID")?>','55','<?=$reqPeriode?>');">
                            <?
                            }
                            ?>
                            </td>
                            <?
                            $mpp_child = new EIS();
                            $mpp_child->selectByParamsJumlahMPPPensiun(array("DEPARTEMEN_PARENT_ID" => $mpp->getField("DEPARTEMEN_ID")), -1, -1, $reqPeriode, 55);
                            while($mpp_child->nextRow())
                            {
                            ?>
                                <tr id="node-CHILDMPP<?=$mpp_child->getField("DEPARTEMEN_ID")?>" class="child-of-node-PARENTMPP<?=$mpp_child->getField("DEPARTEMEN_PARENT_ID")?>">
                                    <td><span class='file'><?=$mpp_child->getField("NAMA")?></span></td>
                                    <td align="left"><?=$mpp_child->getField("JUMLAH")?></td>
                                    <td>
                                    <?
                                    if($mpp_child->getField("JUMLAH") > 0)
                                    {
                                    ?>
                                        <input type="button" name="reqLihat" value="Lihat" onClick="viewDetil('<?=$mpp_child->getField("DEPARTEMEN_ID")?>','55','<?=$reqPeriode?>');">
                                    <?
                                    }
                                    ?>
                                    </td>
        
                                    <?
                                    getDepartemenByParentMPP($mpp_child->getField('DEPARTEMEN_ID'), $mpp_child->getField('NAMA'), $reqPeriode);
                                    ?>
                                </tr>
                            <?
                            } 
                            ?>
                        </tr>
                    <?php
                        unset($mpp_child);
                    }
                    ?>  
                    </tr>
                    <tr id="node-PENSIUN">
                        <td class="kolom-awal-tbody jarak-tree-table">Pensiun</td>
                        <td></td>
                    <?
                    while($pensiun->nextRow())
                    {
        
                    ?> 
                        <tr id="node-PARENTPENSIUN<?=$pensiun->getField("DEPARTEMEN_ID")?>"  class="child-of-node-PENSIUN">
                            <td><?=$pensiun->getField("NAMA")?></td>
                            <td><?=$pensiun->getField("JUMLAH")?></td>
                            <td>
                            <?
                            if($pensiun->getField("JUMLAH") > 0)
                            {
                            ?>
                                <input type="button" name="reqLihat" value="Lihat" onClick="viewDetil('<?=$pensiun->getField("DEPARTEMEN_ID")?>','56','<?=$reqPeriode?>');">
                            <?
                            }
                            ?>
                            </td>                    
                            <? 
                            $pensiun_child = new EIS();
                            $pensiun_child->selectByParamsJumlahMPPPensiun(array("DEPARTEMEN_PARENT_ID" => $pensiun->getField("DEPARTEMEN_ID")), -1, -1, $reqPeriode, 56);
                            while($pensiun_child->nextRow())
                            {
                            ?>
                                <tr id="node-CHILDPENSIUN<?=$pensiun_child->getField("DEPARTEMEN_ID")?>" class="child-of-node-PARENTPENSIUN<?=$pensiun_child->getField("DEPARTEMEN_PARENT_ID")?>">
                                    <td><span class='file'><?=$pensiun_child->getField("NAMA")?></span></td>
                                    <td align="left"><?=$pensiun_child->getField("JUMLAH")?></td>
                                    <td>
                                    <?
                                    if($pensiun_child->getField("JUMLAH") > 0)
                                    {
                                    ?>
                                        <input type="button" name="reqLihat" value="Lihat" onClick="viewDetil('<?=$pensiun_child->getField("DEPARTEMEN_ID")?>','56','<?=$reqPeriode?>');">
                                    <?
                                    }
                                    ?>
                                    </td>                              
                                    <?
                                    getDepartemenByParentPensiun($pensiun_child->getField('DEPARTEMEN_ID'), $pensiun_child->getField('NAMA'), $reqPeriode);
                                    ?>
                                </tr>
                            <?
                            } 
                            ?>
                        </tr>
                    <?php
                        unset($pensiun_child);
                    }
                    ?>  
                    </tr>
                    
                    <tr>
                        <td>&nbsp;</td>
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