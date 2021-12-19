<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->CHARSET; ?>">
<title><?php echo $this->TITLE; ?></title>
<link href="css/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<div align="center">
<table cellpadding="0" width="760" cellspacing="0" border="0" style="border: 1px solid #000000;background-color:#F0F6FF">
<tr>
    <td class="tdcolorout" height="50"><img src="images/logo.gif" alt="<?php echo $this->TITLE; ?>" title="<?php echo $this->TITLE; ?>"></td>
</tr>
</table><br>

<!-- SHOW SEARCH RESULTS -->

<?php echo $this->RESULTS; ?>

<!-- END SEARCH RESULTS -->

<!-- SHOW PAGE NUMBERS -->

<?php echo $this->PAGE_NUMBERS; ?>

<!-- END PAGE NUMBERS -->

<table cellpadding="0" width="760" cellspacing="0" border="0">
<tr>
    <td height="15" align="right" class="footertable"><?php echo $this->FOOTER; ?></td>
</tr>
</table>
</div>
</body>
</html>
