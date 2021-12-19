<?php

/*---------------------------------------------
  MAIAN SEARCH v1.1
  Written by David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Website: www.maianscriptworld.co.uk
  This File: Admin - Log File
----------------------------------------------*/

if(!defined('INCLUDE_FILES'))
{
	include('index.html');
	exit;
}

$q_log = mysql_query("SELECT count(*) as log_count FROM ".$database['prefix']."logfile") or die(mysql_error());
$r_log = mysql_fetch_object($q_log);

?>
<tr>
    <td class="tdmain" colspan="2">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #000000">
    <tr>
        <td align="left" style="padding:5px;background-color:#F0F6FF;color:#000000">&raquo; <b><?php echo strtoupper($header6); ?></b><br><br><?php echo $log11; ?><br><br>
        <?php echo $show . " <b>" . $r_log->log_count . "</b> " . $log; ?>.</td>
    </tr>
    </table><br>
    <form method="POST" name="MyForm" action="index.php?cmd=log&amp;form=remove" onsubmit="return submit_confirm();">
    <table cellpadding="0" cellspacing="1" width="100%" align="center" style="border: 1px solid #68A7DA;">
    <tr>
        <td width="15%" align="center" height="12" class="menutable"><a href="index.php?cmd=log&amp;orderby=count" title="<?php echo $show6 . " " . $log3; ?>" style="color:#FFFFFF"><?php echo $log3; ?></a></td>
        <td width="60%" align="center" height="12" class="menutable"><a href="index.php?cmd=log&amp;orderby=keyword" title="<?php echo $show6 . " " . $log4; ?>" style="color:#FFFFFF"><?php echo $log4; ?></a></td>
        <td width="20%" align="center" height="12" class="menutable"><a href="index.php?cmd=log&amp;orderby=percentage" title="<?php echo $show6 . " " . $log5; ?>" style="color:#FFFFFF"><?php echo $log5; ?></a></td>
        <td width="5%" align="center" height="12" class="menutable"><input type="checkbox" name="log" onclick="selectAll();"></td>
    </tr>
    </table><br>
    <?php

    //Get entries
    
    $limitvalue = $page * $row->total - ($row->total);

    $q_all = mysql_query("SELECT * FROM ".$database['prefix']."logfile $sql_order LIMIT $limitvalue, $row->total") or die(mysql_error());
    
    $q_perc = mysql_query("SELECT SUM(count) as sum_count FROM ".$database['prefix']."logfile") or die(mysql_error());
    $r_perc = mysql_fetch_object($q_perc);

    while ($logs = mysql_fetch_assoc($q_all))
    {
      
    ?>
         <table bgcolor="#F0F6FF" cellpadding="1" cellspacing="1" width="100%" align="center" style="border: 1px solid #68A7DA;">
         <tr>
             <td width="15%" align="center" height="15" valign="middle" style="padding:5px"><?php echo $logs['count']; ?></td>
             <td width="60%" align="center" height="15" valign="middle"><?php echo cleanData($logs['keywords']); ?></td>
             <?php

             //Calculate Percentage

             $percentage = $logs['count'] / $r_perc->sum_count * 100;

             ?>
             <td width="20%" align="center" height="15" valign="middle"><b><?php echo number_format($percentage,1); ?>%</b></td>
             <td width="5%" align="center" height="15" valign="middle"><input type="checkbox" name="logid[]" value="<?php echo $logs['id']; ?>"></td>
         </tr>
         </table><br>
     <?php
     
     unset ($percentage);
     
     }
     
     if (mysql_num_rows($q_all)==0)
     {
       
     ?>
         <table bgcolor="#F0F6FF" cellpadding="1" cellspacing="1" width="100%" align="center" style="border: 1px solid #68A7DA;">
         <tr>
             <td width="5%" align="center" height="15" valign="middle" style="padding:5px"><?php echo $log2; ?></td>
         </tr>
         </table></form><br>
     <?php
     
     }
     else
     {

     ?>
     <table cellpadding="0" cellspacing="1" width="100%">
     <tr>
         <td align="center"><br><input class="formbutton" name="remove" type="submit" value="<?php echo $log6; ?>" title="<?php echo $log6; ?>"> <input class="formbutton" name="clear" type="submit" value="<?php echo $log7; ?>" title="<?php echo $log7; ?>"></td>
     </tr>
     </table><br>
     <?php

     echo page_numbers($r_log->log_count,$row->total,'cmd=log&amp;orderby='.$orderby,$page);
     
     }

     ?>
    </td>
</tr>

