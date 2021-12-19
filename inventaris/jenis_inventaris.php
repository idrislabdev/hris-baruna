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
include_once("../WEB-INF/classes/base-inventaris/JenisInventaris.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

/* create objects */
$jenis_inventaris = new JenisInventaris();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "delete")
{
	$jenis_inventaris->setField("JENIS_INVENTARIS_ID", $reqId);
	if($jenis_inventaris->delete())
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

function getJenisInventarisByParent($id_induk, $parent)
{
	$child = new JenisInventaris();
	
	$child->selectByParams(array("JENIS_INVENTARIS_PARENT_ID"=>$id_induk));
		
	while($child->nextRow())
	{
		//$nama = $parent." | ".$child->getField('NAMA');
		$kode = $child->getField('KODE');
		$nama = $child->getField('NAMA');
		echo "
			  <tr id='node-".$child->getField('JENIS_INVENTARIS_ID')."' class='child-of-node-".$child->getField('JENIS_INVENTARIS_PARENT_ID')."'>
				<td><span class='file'>".$kode."</span></td>
				<td>".$nama."</td>
                <td>".$child->getField("KETERANGAN")."</td>
                <form name='selectform'>
					<input type='hidden' name='data1' value='".$nama."#".$child->getField('JENIS_INVENTARIS_ID')."'>        
					<td>
						<a href=\"#\"><img src=\"../WEB-INF/images/tree-sub.png\" title=\"Tambah Sub\" onClick=\"window.parent.OpenDHTML('jenis_inventaris_add.php?reqMode=insert&reqId=".$child->getField("JENIS_INVENTARIS_ID")."&reqNamaParent=".$child->getField('NAMA')."', 'Sistem Informasi Inventaris');\"></a> - 
						<a href=\"#\" onClick=\"window.parent.OpenDHTML('jenis_inventaris_add.php?reqMode=update&reqId=".$child->getField("JENIS_INVENTARIS_ID")."', 'Sistem Informasi Inventaris');\"><img src=\"../WEB-INF/images/tree-edit.png\" title=\"Ubah\"></a> - 
						<a href=\"#\" onClick=\"if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'jenis_inventaris.php?reqMode=delete&reqId=".$child->getField("JENIS_INVENTARIS_ID")."' }\"><img src=\"../WEB-INF/images/tree-delete.png\" title=\"Hapus\"></a>
					</td>
				</form>
			  </tr>
			 ";
		
	  getJenisInventarisByParent($child->getField("JENIS_INVENTARIS_ID"), $child->getField('NAMA'));		
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
	window.location.replace('jenis_inventaris.php?reqHeight=' + screen.height);
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
                <span><img src="../WEB-INF/images/panah-judul.png">Jenis Asset</span>
            </div>            
            </td>
        </tr>
    </table>
    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif)">      
        <ul>
            <li>
            <a href="#" id="btnAdd" onClick="window.parent.OpenDHTML('jenis_inventaris_add_data.php?reqMode=insert&reqId=0', 'Sistem Informasi Inventaris')" title="Tambah"> Tambah</a>
            </li>        
        </ul>
    </div>
    
    <div id="tableContainer" class="tableContainer">
           <table class="example scrollTable" id="sf">
                <thead class="fixedHeader">
                  <tr>
                      <th style="width:300px;">Kode</th> 
                      <th style="width:400px;">Jenis Asset</th> 
                      <th style="width:500px;">Keterangan</th>
                      <th style="width:500px;">Kode GL Debet</th>
                      <th style="width:500px;">Kode GL Kredit</th>
                      <th style="width:500px;">Nilai Residu</th>
                      <th class="kolom-akhir-thead">Action</th>                                        
                  </tr>
                </thead>
                <tbody class="fullTinggi">
                    <tr>
                        <?
                        $jenis_inventaris->selectByParams(array('JENIS_INVENTARIS_PARENT_ID' => 0));
                        while($jenis_inventaris->nextRow())
                        {
                        ?>                 
                            <tr id="node-<?=$jenis_inventaris->getField('JENIS_INVENTARIS_ID')?>">
                                <td style="width:300px; padding-left:20px;"><span class='file'><?=$jenis_inventaris->getField('KODE')?></span></td>
                                <td style="width:400px;"><?=$jenis_inventaris->getField('NAMA')?></td>
                                <td style="width:500px;"><?=$jenis_inventaris->getField('KETERANGAN')?></td>
                                <td style="width:500px;"><?=$jenis_inventaris->getField('KODE_GL_DEBET')?></td>
                                <td style="width:500px;"><?=$jenis_inventaris->getField('KODE_GL_KREDIT')?></td>
                                <td style="width:500px;"><?=$jenis_inventaris->getField('NILAI_RESIDU')?></td>
                               <form name="selectform">
                                <td style="width:200px;">
                                	<a href="#"><img src="../WEB-INF/images/tree-sub.png" title="Tambah Sub" onClick="window.parent.OpenDHTML('jenis_inventaris_add_data.php?reqMode=insert&reqId=<?=$jenis_inventaris->getField("JENIS_INVENTARIS_ID")?>&reqNamaParent=<?=$jenis_inventaris->getField('NAMA')?>', 'Sistem Informasi Inventaris');"></a> - 
                                	<a href="#" onClick="window.parent.OpenDHTML('jenis_inventaris_add_data.php?reqMode=update&reqId=<?=$jenis_inventaris->getField("JENIS_INVENTARIS_ID")?>', 'Sistem Informasi Inventaris');"><img src="../WEB-INF/images/tree-edit.png" title="Ubah"></a> - 
                                    <a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'jenis_inventaris.php?reqMode=delete&reqId=<?=$jenis_inventaris->getField("JENIS_INVENTARIS_ID")?>' }"><img src="../WEB-INF/images/tree-delete.png" title="Hapus"></a>
                                </td>
                                </form>
                                <?
                                    getJenisInventarisByParent($jenis_inventaris->getField('JENIS_INVENTARIS_ID'), $jenis_inventaris->getField('NAMA'));
                                ?>
                            </tr>
                        <?
                        }
                        ?>
                    </tr>
                <?php
                    unset($jenis_inventaris);
                ?>  
               </tbody>            
          </table>        
    </div>   
</div>
</body>
</html>