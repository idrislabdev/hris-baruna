<?
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/Menu.php");

$menu = new Menu();

/* PARAMETERS */
$reqMode = httpFilterRequest("reqMode");
$reqMenuId = httpFilterGet("reqMenuId");
$reqMenuAkses = httpFilterGet("reqMenuAkses");

function getMenuByParent($menu_id, $menu_akses, $id_induk, $akses_id, $awal)
{
	$child = new Menu();

	
	$child->selectByParamsMenuSub($menu_id, $akses_id, $menu_akses, " AND A.MENU_PARENT_ID = '".$id_induk."'");
	
	if($awal == 0)
		echo "<ul style=\"margin-left:234px;\">";
	else
		echo "<ul>";	
	
	while($child->nextRow())
	{
		if($child->getField("AKSES") == "D")
		{}
		else
		{
			echo "<li><a href=\"".$child->getField("LINK_FILE")."\" target=\"mainFrame\">".$child->getField("NAMA")."</a>";
			if($child->getField("JUMLAH_MENU") > 0)
			{
				getMenuByParent($menu_id, $menu_akses, $child->getField("MENU_ID"), $akses_id, 1);
			}
			echo "</li>";
		}
	}
	
	echo "</ul>";
	unset($child);
}


$menu->selectByParamsMenuSub($reqMenuId, $userLogin->userAksesIntranet, $reqMenuAkses, " AND A.MENU_PARENT_ID = 0 ");
?>
<input type="hidden" id="setHideMenu">
<div class="sidebar-area">    
      
	<?
        foreach($menu_array as $key => $menu) {
            ?>    
            <div class="accordionButton"><?=$menu['accordion_button']?></div>
            <div class="accordionContent">
                <div id="smoothmenu-<?=$key+1?>" class="ddsmoothmenu-v">
                    <ul>
                    <?
                    foreach($menu['accordion_content'] as $content) {
                        ?>
                        <?
                        if ($content['sub']) {
                            ?>
                            <li><a href='#' target="mainFrame"><?=$content['nama']?></a>
                            <ul style="margin-left:234px">
                            <?
                            foreach($content['sub'] as $sub1) {
                                if ($sub1['sub']) {
                                    ?>
                                    <li><a href='#' target="mainFrame"><?=$sub1['nama']?></a>
                                    <ul>
                                    <?
                                    foreach($sub1['sub'] as $sub2) {
                                        if ($sub2['sub']) {
                                            ?>
                                            <li><a href='#' target="mainFrame"><?=$sub2['nama']?></a>
                                            <ul>
                                            <?
                                            foreach($sub2['sub'] as $sub3) {
                                                ?>
                                                <li><a href="<?=$sub3['link']?>" target="mainFrame"><?=$sub3['nama']?></a></li>
                                                <?
                                            }
                                            ?>
                                            </ul>
                                            <?
                                        } else {
                                            ?>
                                            <li><a href="<?=$sub2['link']?>" target="mainFrame"><?=$sub2['nama']?></a></li>
                                            <?
                                        }
                                    }
                                    ?>
                                    </ul>
                                    <?
                                } else {
                                    ?>
                                    <li><a href="<?=$sub1['link']?>" target="mainFrame"><?=$sub1['nama']?></a></li>
                                    <?
                                }

                            }
                            ?>
                            </ul>
                            <?
                        } else {
                            ?>
                                <li><a href="<?=$content['link']?>" target="mainFrame"><?=$content['nama']?></a>
                            <?
                        }
                        ?>
                        </li>
                        <?
                    }
                    ?>
                    </ul>
                </div>
            </div>
            <?
        }           
    ?>
     
	<div style="height:20px; width:100%; float:left;">&nbsp;</div>
    <!-- FOOTER SIDEBAR -->
    <div id="footer2">&copy; 2018 Yayasan Barunawati Biru Surabaya</div>
</div>
