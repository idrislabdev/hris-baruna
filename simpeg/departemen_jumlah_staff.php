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
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
include_once("../WEB-INF/classes/base-simpeg/Cabang.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

/* create objects */
$departemen = new Departemen();
$cabang = new Cabang();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "delete")
{
	$departemen->setField("DEPARTEMEN_ID", $reqId);
	if($departemen->delete())
	{
		echo '<script language="javascript">';
		echo "alert('Data berhasil dihapus.');";
		echo '</script>';		
	}	
	else
	{
		echo '<script language="javascript">';
		echo "alert('Data tidak dapat dihapus, silahkan cek data lain yang berelasi dengan data ini.');";
		echo '</script>';				
	}
}
elseif($reqMode == "status_aktif")
{
	$departemen->setField("STATUS_AKTIF", 1);
	$departemen->setField("DEPARTEMEN_ID", $reqId);
	if($departemen->updateStatus())
	{
		echo '<script language="javascript">';
		echo "alert('Data berhasil diaktifkan.');";
		echo '</script>';		
	}	
	else
	{
		echo '<script language="javascript">';
		echo "alert('Data tidak dapat diaktifkan, silahkan cek data lain yang berelasi dengan data ini.');";
		echo '</script>';				
	}
}
elseif($reqMode == "tidak_aktif")
{
	$departemen->setField("STATUS_AKTIF", 0);
	$departemen->setField("DEPARTEMEN_ID", $reqId);
	if($departemen->updateStatus())
	{
		echo '<script language="javascript">';
		echo "alert('Data berhasil dinon-aktifkan.');";
		echo '</script>';		
	}	
	else
	{
		echo '<script language="javascript">';
		echo "alert('Data tidak dapat dinon-aktifkan, silahkan cek data lain yang berelasi dengan data ini.');";
		echo '</script>';				
	}
}



$cabang->selectByParams();

function getDepartemenByParent($id_induk, $parent)
{
	$child = new Departemen();
	
	$child->selectByParams(array("DEPARTEMEN_PARENT_ID"=>$id_induk, "STATUS_AKTIF" => 1));
		
	while($child->nextRow())
	{
		$nama = $parent." | ".$child->getField('NAMA');
		echo "
			  <tr id='node-".$child->getField('DEPARTEMEN_ID')."' class='child-of-node-".$child->getField('DEPARTEMEN_PARENT_ID')."'>
				<td><span class='file'>".$nama."</span></td>
				<td align='left'><input type='text' name='reqJumlah[]' style='width:40px;' value='".$child->getField("JUMLAH_STAFF")."'><input type='hidden' name='reqDepartemenId[]' value='".$child->getField("DEPARTEMEN_ID")."'></td>
			  </tr>
			 ";
		
	  getDepartemenByParent($child->getField("DEPARTEMEN_ID"), $child->getField('NAMA'));		
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
<script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/treeTable/doc/javascripts/jquery.ui.js"></script>
<link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../WEB-INF/lib/treeTable/src/javascripts/jquery.treeTable.js"></script>
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>

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

<?
if($reqHeight == "")
{
?>
<script type="text/javascript">
	window.location.replace('departemen_jumlah_staff.php?reqHeight=' + screen.height);
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


<script type="text/javascript">


	$(function(){
		$('#ff').form({
			url:'../json-simpeg/departemen_jumlah_staff.php',
			onSubmit:function(){
				return $(this).form('validate');
			},
			success:function(data){
				$.messager.alert('Info', data, 'info');
				$('#rst_form').click();
				document.location.href = 'departemen_jumlah_staff.php';
			}				
		});
		
	});
</script>

<!-- CSS for Scrollable Table -->
<link href="../main/css/ScrollableTable.css" rel="stylesheet" type="text/css">

</head>
<body style="overflow:hidden;">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Departemen</span>
            </div>
            </td>
        </tr>
    </table>

    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" onClick="$('#btnSubmit').click();">Simpan</a>
            </li>      
        </ul>
    </div>
    
    <div id="konten">
        <!--<div id="tableContainer" class="tableContainer">-->
        <div class="scroll">
          <div>
          <form id="ff" method="post" novalidate style="margin-top:20px;">
          <table class="example scrollTable" id="sf">
                <thead class="fixedHeader">
                  <tr>
                      <th class="kolom-awal-thead">Departemen</th>
                      <th class="kolom-akhir-thead">Staff</th>                              
                  </tr>
                </thead>
                <tbody class="fullTinggi"> 
                <?
                while($cabang->nextRow())
                {
    
                ?> 
                    <tr id="node-CAB<?=$cabang->getField('CABANG_ID')?>">
                        <td class="kolom-awal-tbody jarak-tree-table"><?=$cabang->getField('NAMA')?></td>
                        <td>&nbsp;</td>
                        <?
                        $departemen = new Departemen();
                        $departemen->selectByParams(array('DEPARTEMEN_PARENT_ID' => 0, "CABANG_ID" => $cabang->getField("CABANG_ID"), "STATUS_AKTIF" => 1));
                        while($departemen->nextRow())
                        {
                        ?>
                            <tr id="node-<?=$departemen->getField('DEPARTEMEN_ID')?>" class="child-of-node-CAB<?=$cabang->getField("CABANG_ID")?>">
                                <td><span class='file'><?=$departemen->getField('NAMA')?></span></td>
                                <td class="kolom-akhir-tbody" align="left"><input type="text" name="reqJumlah[]" style="width:40px;" value="<?=$departemen->getField("JUMLAH_STAFF")?>"><input type="hidden" name="reqDepartemenId[]" value="<?=$departemen->getField("DEPARTEMEN_ID")?>"></td>
                                <?
                                    getDepartemenByParent($departemen->getField('DEPARTEMEN_ID'), $departemen->getField('NAMA'));
                                ?>
                            </tr>
                        <?
                        }
                        ?>
                    </tr>
                <?php
                    unset($departemen);
                }
                ?>  
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr> 
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr> 
               </tbody>            
              </table> 
                <div style="display:none">
                    <? if($tempRowId == ''){ $reqMode='insert'; }else{ $reqMode='update'; }?>
                    <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
                    <input type="reset" id="rst_form">
                </div>          
              </form>        
          </div> 
        </div> 
        <!--</div>-->
    </div>

</div>
</body>
</html>