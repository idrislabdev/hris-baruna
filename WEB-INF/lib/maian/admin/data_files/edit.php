<?php

/*---------------------------------------------
  MAIAN SEARCH v1.1
  Written by David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Website: www.maianscriptworld.co.uk
  This File: Admin - Edit Page
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
        <td align="left" style="padding:5px;background-color:#F0F6FF;color:#000000">&raquo; <b><?php echo strtoupper($header3); ?></b><br><br><?php echo $edit4; ?></td>
    </tr>
    <tr>
        <td align="right" style="padding:5px;background-color:#F0F6FF;color:#000000"><a href="index.php?cmd=show" title="<?php echo $edit3; ?>"><b><?php echo $edit3; ?></b></a> &raquo;</td>
    </tr>
    </table><br>
    <form method="POST" action="index.php?cmd=edit&amp;form=update">
    <input type="hidden" name="id" value="<?php echo $r_edit->id; ?>">
    <table cellpadding="4" cellspacing="4" width="100%" align="center">
    <tr>
        <td class="headbox" width="30%" align="left"><?php echo $add; ?>:</td>
        <td width="70%" align="left"><input class="formbox" type="text" name="title" size="30" maxlength="250" value="<?php echo cleanData($r_edit->title); ?>"></td>
    </tr>
    <tr>
        <td class="headbox" align="left"><?php echo $add2; ?>:</td>
        <td align="left"><input class="formbox" type="text" name="description" size="30" maxlength="250" value="<?php echo cleanData($r_edit->description); ?>"></td>
    </tr>
    <tr>
        <td class="headbox" align="left"><?php echo $add3; ?>:</td>
        <td align="left"><input class="formbox" type="text" name="url" size="30" maxlength="250" value="<?php echo cleanData($r_edit->url); ?>"></td>
    </tr>
    <tr>
        <td class="headbox" align="left"><?php echo $add4; ?>:</td>
        <td align="left"><textarea cols="58" rows="8" name="keywords"><?php echo cleanData($r_edit->keywords); ?></textarea><br><i><?php echo $add10; ?></i></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="left"><br><input class="formbutton" type="submit" value="<?php echo $edit; ?>" title="<?php echo $edit; ?>"></td>
    </tr>
    </table>
    </form>
    <p>&nbsp;</p>
    </td>
</tr>

