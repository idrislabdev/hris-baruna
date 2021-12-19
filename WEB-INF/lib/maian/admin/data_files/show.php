<?php

/*---------------------------------------------
  MAIAN SEARCH v1.1
  Written by David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Website: www.maianscriptworld.co.uk
  This File: Admin - Show Pages
----------------------------------------------*/

if(!defined('INCLUDE_FILES'))
{
	include('index.html');
	exit;
}

$q_pages = mysql_query("SELECT count(*) as page_count FROM ".$database['prefix']."pages") or die(mysql_error());
$r_pages = mysql_fetch_object($q_pages);

?>
<tr>
    <td class="tdmain" colspan="2">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #000000">
    <tr>
        <td align="left" style="padding:5px;background-color:#F0F6FF;color:#000000">&raquo; <b><?php echo strtoupper($header3); ?></b><br><br><?php echo $show16; ?><br><br>
        <?php echo $show . " <b>" . $r_pages->page_count . "</b> " . $show2; ?>.</td>
    </tr>
    </table><br>
    <form method="POST" name="MyForm" action="index.php?cmd=show&amp;form=remove" onsubmit="return submit_confirm();">
    <table cellpadding="0" cellspacing="1" width="100%" align="center" style="border: 1px solid #68A7DA;">
    <tr>
        <td width="5%" align="center" height="12" class="menutable"><a href="index.php?cmd=show&amp;orderby=id" title="<?php echo $show6 . " " . $show3; ?>" style="color:#FFFFFF"><?php echo $show3; ?></a></td>
        <td width="25%" align="center" height="12" class="menutable"><a href="index.php?cmd=show&amp;orderby=title" title="<?php echo $show6 . " " . $show4; ?>" style="color:#FFFFFF"><?php echo $show4; ?></a></td>
        <td width="25%" align="center" height="12" class="menutable"><a href="index.php?cmd=show&amp;orderby=desc" title="<?php echo $show6 . " " . $add2; ?>" style="color:#FFFFFF"><?php echo $add2; ?></a></td>
        <td width="25%" align="center" height="12" class="menutable"><a href="index.php?cmd=show&amp;orderby=url" title="<?php echo $show6 . " " . $add3; ?>" style="color:#FFFFFF"><?php echo $add3; ?></a></td>
        <td width="15%" align="center" height="12" class="menutable"><?php echo $show7; ?></td>
        <td width="5%" align="center" height="12" class="menutable"><input type="checkbox" name="log" onclick="selectAll();"></td>
    </tr>
    </table><br>
    <?php

    //Get entries
    
    $count = 0;
    
    $limitvalue = $page * $row->total - ($row->total);

    $q_all = mysql_query("SELECT * FROM ".$database['prefix']."pages $sql_order LIMIT $limitvalue, $row->total") or die(mysql_error());
    
    while ($pages = mysql_fetch_assoc($q_all))
    {
      
    ?>
         <table bgcolor="#F0F6FF" cellpadding="0" cellspacing="1" width="100%" align="center" style="border: 1px solid #68A7DA;">
         <tr>
             <td width="5%" align="center" height="15" valign="middle" style="padding:5px"><?php echo $pages['id']; ?></td>
             <td width="25%" align="center" height="15" valign="middle"><?php echo ((strlen($pages['title'])>20) ? substr(cleanData($pages['title']),0,20) . "..." : cleanData($pages['title'])); ?></td>
             <td width="25%" align="center" height="15" valign="middle"><?php echo ((strlen($pages['description'])>20) ? substr(cleanData($pages['description']),0,20) . "..." : cleanData($pages['description'])); ?></td>
             <td width="25%" align="center" height="15" valign="middle"><a href="<?php echo $pages['url']; ?>" target="_blank" title="<?php echo $pages['url']; ?>"><?php echo ((strlen($pages['url'])>20) ? substr(cleanData($pages['url']),0,20) . "..." : cleanData($pages['url'])); ?></a></td>
             <td width="15%" align="center" height="15" valign="middle">[ <a href="index.php?cmd=edit&amp;id=<?php echo $pages['id']; ?>" title="<?php echo $show7; ?>"><b><?php echo $show7; ?></b></a> ]</td>
             <td width="5%" align="center" height="15" valign="middle"><input type="checkbox" name="pageid[]" value="<?php echo $pages['id']; ?>"></td>
         </tr>
         </table><br>
     <?php
     
     }
     
     if (mysql_num_rows($q_all)==0)
     {
       
     ?>
         <table bgcolor="#F0F6FF" cellpadding="1" cellspacing="1" width="100%" align="center" style="border: 1px solid #68A7DA;">
         <tr>
             <td width="5%" align="center" height="15" valign="middle" style="padding:5px"><?php echo $show14; ?></td>
         </tr>
         </table><br>
     <?php
     
     }
     else
     {

     ?>
     <table cellpadding="0" cellspacing="1" width="100%">
     <tr>
         <td align="center"><br><input class="formbutton" type="submit" value="<?php echo $show10; ?>" title="<?php echo $show10; ?>"></td>
     </tr>
     </table></form><br>
     <?php

     echo page_numbers($r_pages->page_count,$row->total,'cmd=show&amp;orderby='.$orderby,$page);

     }

     ?>
     
    </td>
</tr>

