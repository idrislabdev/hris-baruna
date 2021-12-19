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
	
	$child->selectByParams(array("DEPARTEMEN_PARENT_ID"=>$id_induk));
		
	while($child->nextRow())
	{
		$nama = $parent." | ".$child->getField('NAMA');
		$puspel = $child->getField('PUSPEL');
		$status_aktif = $child->getField('STATUS_AKTIF');
		echo "
			  <tr id='node-".$child->getField('DEPARTEMEN_ID')."' class='child-of-node-".$child->getField('DEPARTEMEN_PARENT_ID')."'>
				<td><span class='file'>".$nama."</span></td>
				<td width=\"100\" align=center>".$puspel."</td>
				<td width=\"100\" align=center>".getNameValueAktif($status_aktif)."</td>
				<form name='selectform'>
				<input type='hidden' name='data1' value='".$nama."#".$child->getField('DEPARTEMEN_ID')."'>        
				<td class=\"scrollKonten\" style=\"width:200px;\">
				<a href=\"#\"><img src=\"../WEB-INF/images/tree-sub.png\" title=\"Tambah Sub\" onClick=\"window.parent.OpenDHTML('departemen_add.php?reqMode=insert&reqId=".$child->getField("DEPARTEMEN_ID")."&reqNamaParent=".$child->getField('NAMA')."', 'Sistem Informasi Persuratan', '600', '300');\"></a> - <a href=\"#\" onClick=\"window.parent.OpenDHTML('departemen_add.php?reqMode=update&reqId=".$child->getField("DEPARTEMEN_ID")."', 'Sistem Informasi Persuratan', '600', '400');\"><img src=\"../WEB-INF/images/tree-edit.png\" title=\"Ubah\"></a> - <a href=\"#\" onClick=\"if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'departemen.php?reqMode=delete&reqId=".$child->getField("DEPARTEMEN_ID")."' }\"><img src=\"../WEB-INF/images/tree-delete.png\" title=\"Hapus\"></a> - <a href=\"#\" onClick=\"if(confirm('Apakah anda yakin ingin mengaktifkan data ini?')) { window.location.href = 'departemen.php?reqMode=status_aktif&reqId=".$child->getField("DEPARTEMEN_ID")."' }\"><img src=\"../WEB-INF/images/tree-aktif.png\" title=\"Aktif\"></a> - <a href=\"#\" onClick=\"if(confirm('Apakah anda yakin ingin menon-aktifkan data ini?')) { window.location.href = 'departemen.php?reqMode=tidak_aktif&reqId=".$child->getField("DEPARTEMEN_ID")."' }\"><img src=\"../WEB-INF/images/tree-noaktif.png\" title=\"Tidak Aktif\"></a>
				</td>               
				</form>
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
<link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">

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
</script>

<?
if($reqHeight == "")
{
?>
<script type="text/javascript">
	window.location.replace('departemen.php?reqHeight=' + screen.height);
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Departemen</span>
            </div>            
            </td>
        </tr>
    </table>

    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" id="btnAdd" onClick="window.parent.OpenDHTML('departemen_add.php?reqMode=insert&reqId=0', 'Sistem Informasi Persuratan', '600', '300')" title="Tambah">Tambah</a>
            </li>        
        </ul>
    </div>

    
    

    <div class="scroll">
      <div>
		<table class="example scrollTable" id="sf">
            <thead class="fixedHeader">
              <tr>
                  <th class="kolom-awal-thead">Departemen</th>
                  <th style="width:102px;">Puspel</th>
                  <th style="width:100px;">Status</th>
                  <th class="kolom-akhir-thead">Action</th>
              </tr>
            </thead>
            <tbody class="fullTinggi">
            <?
            while($cabang->nextRow())
            {
        
            ?> 
                <tr id="node-CAB<?=$cabang->getField('CABANG_ID')?>">
                    <td class="kolom-awal-tbody" style="padding-left:20px;"><?=$cabang->getField('NAMA')?></td>
                    <td style="width:100px; ">&nbsp;</td>
                    <td style="width:100px; ">&nbsp;</td>
                    <form name="selectform">
                    <td class="scrollKonten kolom-akhir-tbody"><a href="#"><img src="../WEB-INF/images/tree-sub.png" title="Tambah Sub" onClick="window.parent.OpenDHTML('departemen_add.php?reqMode=insert&reqId=0&reqCabangId=<?=$cabang->getField("CABANG_ID")?>', 'Sistem Informasi Persuratan', '600', '400');"></a></td>                
                    </form>
                    
                    <?
                    $departemen = new Departemen();
                    $departemen->selectByParams(array('DEPARTEMEN_PARENT_ID' => 0, "CABANG_ID" => $cabang->getField("CABANG_ID")));
                    while($departemen->nextRow())
                    {
                    ?>
                        <tr id="node-<?=$departemen->getField('DEPARTEMEN_ID')?>" class="child-of-node-CAB<?=$cabang->getField("CABANG_ID")?>">
                            <td><span class='file'><?=$departemen->getField('NAMA')?></span></td>
                            <td align=center><?=$departemen->getField('PUSPEL')?></td>
                            <td align=center><?=getNameValueAktif($departemen->getField('STATUS_AKTIF'))?></td>
                            <form name="selectform">
                            <td><a href="#"><img src="../WEB-INF/images/tree-sub.png" title="Tambah Sub" onClick="window.parent.OpenDHTML('departemen_add.php?reqMode=insert&reqId=<?=$departemen->getField("DEPARTEMEN_ID")?>&reqNamaParent=<?=$departemen->getField('NAMA')?>', 'Sistem Informasi Persuratan', '600', '400');"></a> - <a href="#" onClick="window.parent.OpenDHTML('departemen_add.php?reqMode=update&reqId=<?=$departemen->getField("DEPARTEMEN_ID")?>', 'Sistem Informasi Persuratan', '600', '400');"><img src="../WEB-INF/images/tree-edit.png" title="Ubah"></a> - <a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'departemen.php?reqMode=delete&reqId=<?=$departemen->getField("DEPARTEMEN_ID")?>' }"><img src="../WEB-INF/images/tree-delete.png" title="Hapus"></a> - <a href="#" onClick="if(confirm('Apakah anda yakin ingin mengaktifkan data ini?')) { window.location.href = 'departemen.php?reqMode=status_aktif&reqId=<?=$departemen->getField("DEPARTEMEN_ID")?>' }"><img src="../WEB-INF/images/tree-aktif.png" title="Aktif"></a> - <a href="#" onClick="if(confirm('Apakah anda yakin ingin menon-aktifkan data ini?')) { window.location.href = 'departemen.php?reqMode=tidak_aktif&reqId=<?=$departemen->getField("DEPARTEMEN_ID")?>' }"><img src="../WEB-INF/images/tree-noaktif.png" title="Tidak Aktif"></a></td>                
                            </form>
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
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr> 
           </tbody>            
        </table> 
      </div> 
    </div> 

</div>
</body>
</html>