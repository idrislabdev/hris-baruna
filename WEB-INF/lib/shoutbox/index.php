<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Shoutbox</title>
<style type="text/css">
@import 'templates/style.css';
<!--[if IE]>
@import 'templates/style_ie.css';
<![endif]-->
</style>
<script>
function showPopup(opFile,opWidth,opHeight)
{
	newWindow = window.open(opFile, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars");
	newWindow.focus();
}
</script>
</head>
<body style="margin:0px; padding:0px;">
<?php include 'shoutbox.php'; ?>
</body>
</html>