<?php

/*---------------------------------------------
  MAIAN SEARCH v1.1
  Written by David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Website: www.maianscriptworld.co.uk
  This File: Administration Header
----------------------------------------------*/

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>">
<title><?php echo $script . " " . $script2 . " " . $header; ?></title>
<link href="css/css.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/js_code.js"></script>
</head>

<body>
<div align="center">
<table cellpadding="0" width="760" cellspacing="0" border="0" style="border: 1px solid #000000;background-color:#F0F6FF" align="center">
<tr>
    <td class="tdcolorout" height="50"><img src="../images/logo.gif" alt="<?php echo $script . " " . $script2; ?>" title="<?php echo $script . " " . $script2; ?>"></td>
</tr>
</table><br>
<table cellpadding="0" width="760" cellspacing="0" border="0" style="border: 1px solid #000000;" align="center">
<tr>
    <?php
    if ($cmd=='login')
    {
    ?>
    <td align="right" style="border-bottom:1px solid #000000;background-color:#68A7DA;color:#FFFFFF;padding:5px">[ <b><?php echo $login; ?></b> ]</td>
    <?php
    }
    else
    {
    ?>
    <td align="left" width="40%" style="border-bottom:1px solid #000000;background-color:#68A7DA;color:#FFFFFF;padding:5px">
    [<a href="index.php" style="background-color:#68A7DA;color:#FFFFFF" title="<?php echo $header9; ?>"><b><?php echo $header9; ?></b></a>] [<a href="index.php?cmd=support" target="_blank" style="background-color:#68A7DA;color:#FFFFFF" title="<?php echo $header10; ?>"><b><?php echo $header10; ?></b></a>]    </td>
    <td align="right" width="60%" style="border-bottom:1px solid #000000;background-color:#68A7DA;color:#FFFFFF;padding:5px">
    <table width="50%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #000000">
    <tr>

       <td align="center" style="padding:3px;background-color:#F0F6FF">
       <b><?php echo $header8; ?></b>:
       <select onChange="if(this.value!= 0){location=this.options[this.selectedIndex].value}">
       <option value="0"></option>
       <option value="index.php?cmd=settings"<?php echo ($cmd=='settings' ? ' selected' : ''); ?>>- <?php echo $header4; ?></option>
       <option value="index.php?cmd=add"<?php echo ($cmd=='add' ? ' selected' : ''); ?>>- <?php echo $header2; ?></option>
       <option value="index.php?cmd=show"<?php echo ($cmd=='show' ? ' selected' : ''); ?>>- <?php echo $header3; ?></option>
       <option value="index.php?cmd=html"<?php echo ($cmd=='html' ? ' selected' : ''); ?>>- <?php echo $header5; ?></option>
       <option value="index.php?cmd=log"<?php echo ($cmd=='log' ? ' selected' : ''); ?>>- <?php echo $header6; ?></option>
       <option value="0"></option>
       <option value="index.php?cmd=logout">- <?php echo $header7; ?></option>
       </select></td>
     </tr>
     </table>
     </td>
     <?php
    }
    ?>
</tr>
<!-- LOAD TEMPLATE -->
