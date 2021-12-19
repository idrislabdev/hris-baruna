<?php

/*---------------------------------------------
  MAIAN SEARCH v1.1
  Written by David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Website: www.maianscriptworld.co.uk
  This File: Admin Login
----------------------------------------------*/

if(!defined('INCLUDE_FILES'))
{
	include('index.html');
	exit;
}

?>
<tr>
    <td class="tdmain">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #000000">
    <tr>
        <td align="left" style="padding:5px;background-color:#F0F6FF;color:#000000">&raquo; <b><?php echo strtoupper($login); ?></b><br><br><?php echo $login10; ?></td>
    </tr>
    </table><br>
    <form method="POST" action="index.php?cmd=login&amp;form=enter">
    <table cellpadding="4" cellspacing="4" width="100%" align="center">
    <tr>
        <td class="headbox" width="30%" align="left"><?php echo $login2; ?>:</td>
        <td width="70%" align="left"><input class="formbox" type="text" name="username" size="30"></td>
    </tr>
    <tr>
        <td class="headbox" align="left"><?php echo $login3; ?>:</td>
        <td align="left"><input class="formbox" type="password" name="password" size="30"></td>
    </tr>
    <tr>
        <td class="headbox" align="left"><?php echo $login5; ?>:</td>
        <td valign="middle" align="left"><?php echo $settings6; ?> <input type="radio" name="cookie" size="30" value="yes"> <?php echo $settings7; ?> <input type="radio" name="cookie" size="30" checked value="no"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="left"><br><input class="formbutton" type="submit" value="<?php echo $login4; ?>" title="<?php echo $login4; ?>"></td>
    </tr>
    </table>
    </form>
    <p>&nbsp;</p>
    </td>
</tr>

