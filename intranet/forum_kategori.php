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
include_once("../WEB-INF/classes/base/ForumKategori.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

/* create objects */
$forum_kategori = new ForumKategori();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "delete")
{
	$forum_kategori->setField("FORUM_KATEGORI_ID", $reqId);
	if($forum_kategori->delete())
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

$forum_kategori->selectByParams(array('FORUM_KATEGORI_PARENT_ID' => 0));	

function getUsersBaseByParent($id_induk, $parent)
{
	$child = new ForumKategori();
	
	$child->selectByParams(array("FORUM_KATEGORI_PARENT_ID"=>$id_induk));
		
	while($child->nextRow())
	{
		$nama = $parent." | ".$child->getField('NAMA');
		echo "
      <tr id='node-".$child->getField('FORUM_KATEGORI_ID')."' class='child-of-node-".$child->getField('FORUM_KATEGORI_PARENT_ID')."'>
        <td><span class='file'>".$nama."</span></td>
		<form name='selectform'>
			<input type='hidden' name='data1' value='".$nama."#".$child->getField('FORUM_KATEGORI_ID')."'>        
			<td><a href=\"#\"><img src=\"../WEB-INF/images/tree-sub.png\" title=\"insert Sub\" onClick=\"window.parent.OpenDHTML('forum_kategori_add.php?reqMode=sub&reqId=".$child->getField("FORUM_KATEGORI_ID")."&reqNamaParent=".$child->getField('NAMA')."', 'Sistem Informasi Persuratan', '600', '300');\"></a> - <a href=\"#\" onClick=\"window.parent.OpenDHTML('forum_kategori_add.php?reqMode=update&reqId=".$child->getField("FORUM_KATEGORI_ID")."', 'Sistem Informasi Persuratan', '600', '300');\"><img src=\"../WEB-INF/images/tree-edit.png\" title=\"Ubah\"></a> - <a href=\"#\" onClick=\"if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'forum_kategori.php?reqMode=delete&reqId=".$child->getField("FORUM_KATEGORI_ID")."' }\"><img src=\"../WEB-INF/images/tree-delete.png\" title=\"Hapus\"></a></td>               
		</form>
      </tr>
			 ";
		
	  getUsersBaseByParent($child->getField("FORUM_KATEGORI_ID"), $child->getField('NAMA'));		
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
	window.location.replace('forum_kategori.php?reqHeight=' + screen.height);
</script>
<?
}
?>
<style type="text/css">
<!--
div.scroll {
height: <?=$reqHeight - 270?>px;
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
</head>
<body style="overflow:hidden">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Kategori Forum</span>
            </div>            
            </td>
        </tr>
    </table>

    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <a href="#" id="btnAdd" onClick="window.parent.OpenDHTML('forum_kategori_add.php?reqMode=insert&reqId=0', 'Sistem Informasi Persuratan', '600', '300')" title="insert">Tambah</a>
            </li>        
        </ul>
    </div>
    <div class="scroll">
      <div>
      <table class="example" id="sf">
            <thead>
              <tr>
                  <th>Kategori</th>                
                  <th width="15%">Action</th>                                        
              </tr>
            </thead>
            <tbody> 
              <?
                  while($forum_kategori->nextRow())
                  {
              ?> 
                  <tr id="node-<?=$forum_kategori->getField('FORUM_KATEGORI_ID')?>">
                      <td style="padding-left:20px;"><?=$forum_kategori->getField('NAMA')?></td>
                      <form name="selectform">
                      <input type="hidden" name="data1" value="<?=$forum_kategori->getField('NAMA')?>#<?=$forum_kategori->getField('FORUM_KATEGORI_ID')?>">
                      <td><a href="#"><img src="../WEB-INF/images/tree-sub.png" title="insert Sub" onClick="window.parent.OpenDHTML('forum_kategori_add.php?reqMode=insert&reqId=<?=$forum_kategori->getField("FORUM_KATEGORI_ID")?>&reqNamaParent=<?=$forum_kategori->getField('NAMA')?>', 'Sistem Informasi Persuratan', '600', '300');"></a> - <a href="#" onClick="window.parent.OpenDHTML('forum_kategori_add.php?reqMode=update&reqId=<?=$forum_kategori->getField("FORUM_KATEGORI_ID")?>', 'Sistem Informasi Persuratan', '600', '300');"><img src="../WEB-INF/images/tree-edit.png" title="Ubah"></a> - <a href="#" onClick="if(confirm('Apakah anda yakin ingin menghapus data ini?')) { window.location.href = 'forum_kategori.php?reqMode=delete&reqId=<?=$forum_kategori->getField("FORUM_KATEGORI_ID")?>' }"><img src="../WEB-INF/images/tree-delete.png" title="Hapus"></a></td>                
                      </form>
                      <?
                      getUsersBaseByParent($forum_kategori->getField('FORUM_KATEGORI_ID'), $forum_kategori->getField('NAMA'));
                      ?>
                  </tr>
              <?php
                  }
              ?>  
           </tbody>            
          </table>         
      </div> 
    </div> 

</div>
</body>
</html>