<?php

/*---------------------------------------------
  MAIAN SEARCH v1.1
  Written by David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Website: www.maianscriptworld.co.uk
  This File: Admin - HTML Code
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
        <td align="left" style="padding:5px;background-color:#F0F6FF;color:#000000">&raquo; <b><?php echo strtoupper($header5); ?></b><br><br><?php echo $html; ?></td>
    </tr>
    </table><br>
    <form name="CODE">
    <table cellpadding="4" cellspacing="4" width="100%" align="center">
    <tr>
        <td class="headbox" width="30%" align="left"><?php echo $header5; ?>:</td>
        <td width="70%" align="left"><textarea cols="58" rows="8" name="html"><?php echo cleanData(str_replace("&quot;", "\"", $row->htmlcode)); ?></textarea><br><input class="formbutton" type="button" value="<?php echo $html2; ?>" title="<?php echo $html2; ?>" onclick="javascript:highlight()"> <?php echo $html6; ?>, <?php echo $html7; ?></td>
    </tr>
    </table><br>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #000000">
    <tr>
        <td align="left" style="padding:5px;background-color:#F0F6FF;color:#000000">&raquo; <b><?php echo strtoupper($html8); ?></b><br><br><?php echo $html3; ?></td>
    </tr>
    </table><br>
    <table cellpadding="4" cellspacing="4" width="100%" align="center">
    <tr>
        <td align="left"><input type="hidden" value="cmd" name="search"><input type="text" name="keywords"><br><input type="button" value="<?php echo $html5; ?>" onclick="Javascript:alert('<?php echo $html4; ?>')"></td>
    </tr>
    </table>
    </form>
    <p>&nbsp;</p>
    </td>
</tr>

