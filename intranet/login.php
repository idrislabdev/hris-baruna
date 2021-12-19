<html>
<head>
<title>Login Sistem</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="themes/main.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>

<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  </head>

<body  scroll="no" onLoad="javascript:frmLogin.reqUser.focus()" style="overflow:hidden">
<div id="begron"><img src="images/bg-login.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

<form name="frmLogin" action="" method="post">			
<table width="100%" height="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle">
	<table border="0" cellpadding="0" cellspacing="0" style="width:300px; height:180px; background-image:url(images/bg-login-form.png); background-position:center; background-repeat:no-repeat;">
      <tr>
        <td width="116" height="55" align="left" valign="middle" class="td_white">&nbsp;</td>
        <td width="184" align="left" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="33" align="left" valign="middle" class="td_white">&nbsp;</td>
        <td align="left" valign="middle"><input name="reqUser" type="text" style="background-color:transparent; border:none" id="reqUser" size="16"></td>
      </tr>
      <tr>
        <td height="33" align="left" valign="middle" class="td_white">&nbsp;</td>
        <td align="left" valign="middle"><input name="reqPasswd" type="password" style="background-color:transparent; border:none" id="reqPasswd" size="16"></td>
      </tr>
      <tr align="left">
        <td>&nbsp;</td>
        <td align="left" valign="bottom"><input name="slogin_POST_send" type="submit" value="Login" class="button" alt="DO LOGIN!" width="68" height="20"></td>
      </tr>
      <tr>
        <td colspan="2" valign="middle" align="center" bgcolor="" class="">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<input type="hidden" name="reqMode" value="submitLogin">
</form>
</div><!-- #wadah -->

</body>
</html>
