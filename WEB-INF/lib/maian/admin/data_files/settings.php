<?php

/*---------------------------------------------
  MAIAN SEARCH v1.1
  Written by David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Website: www.maianscriptworld.co.uk
  This File: Admin - Settings
----------------------------------------------*/

if(!defined('INCLUDE_FILES'))
{
	include('index.html');
	exit;
}

?>
<tr>
    <td class="tdmain" colspan="2">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #000000">
    <tr>
        <td align="left" style="padding:5px;background-color:#F0F6FF;color:#000000">&raquo; <b><?php echo strtoupper($header4); ?></b><br><br><?php echo $settings17; ?></td>
    </tr>
    </table><br>
    <form method="POST" name="tcp_test" action="index.php?cmd=settings&amp;form=update">
    <table cellpadding="4" cellspacing="4" width="100%" align="center">
    <tr>
        <td class="headbox" width="30%" align="left"><?php echo $settings; ?>:</td>
        <td width="70%" align="left"><input class="formbox" type="text" name="path" size="30" value="<?php echo cleanData($row->path); ?>"> <i>(<?php echo $settings2; ?>)</i></td>
    </tr>
    <tr>
        <td class="headbox" align="left"><?php echo $settings3; ?>:</td>
        <td align="left"><input class="formbox" type="text" name="total" size="10" maxlength="3" maxlength="3" value="<?php echo $row->total; ?>"></td>
    </tr>
    <tr>
        <td class="headbox" align="left"><?php echo $settings4; ?>:</td>
        <td align="left"><select name="lang">
        <?php

        //---------------------------------------------------------
        //Read from /lang/ directory and get language files
        //---------------------------------------------------------

        $showlang = opendir("../lang/");

        while ($read = readdir($showlang))
        {
  	   if ($read != "." && $read != ".." && $read != "index.html")
           {
        	echo "<option".(($read == $row->language) ? " selected" : "").">" . $read . "</option>\n";
           }
        }

        closedir($showlang);
        
        ?>
        </select>
        </td>
    </tr>
    <tr>
        <td class="headbox" align="left"><?php echo $settings8; ?>:</td>
        <td align="left"><select name="target">
        <option<?php echo ((!$row->target) ? " selected " : " "); ?>value="0"><?php echo $settings15; ?></option>
        <option<?php echo (($row->target) ? " selected " : " "); ?>value="1"><?php echo $settings16; ?></option>
        </select>
        </td>
    </tr>
    <tr>
        <td class="headbox" align="left"><?php echo $settings5; ?>:</td>
        <td align="left"><?php echo $settings6; ?> <input type="radio" name="log" value="yes"<?php echo (($row->log) ? " checked" : ""); ?>> <?php echo $settings7; ?> <input type="radio" name="log" value="no"<?php echo ((!$row->log) ? " checked" : ""); ?>></td>
    </tr>
    <tr>
        <td class="headbox" align="left"><?php echo $settings9; ?>:</td>
        <td align="left"><textarea cols="50" rows="8" name="skipwords"><?php echo cleanData($row->skipwords); ?></textarea><br><i><?php echo $settings10; ?></i></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="left"><br><input class="formbutton" type="submit" value="<?php echo $settings11; ?>" title="<?php echo $settings11; ?>"></td>
    </tr>
    </table>
    </form>
    <p>&nbsp;</p>
    </td>
</tr>

