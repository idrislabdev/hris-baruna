<! DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Dynamic Image Creation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
This script shows how to implement a strong authentication scheme using dynamically generated image. This small snippet is extremely helpful for creating your signup script.
<form name="form1" method="post" action="">
  <table width="42%"  border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#990000">
    <tr>
      <td><table width="100%"  border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
        <tr>
          <td width="64%">Type the following Image Data : <br>
            <input name="data" type="text" id="data3"></td>
          </tr>
        <?
global $data;
$data = mt_rand(100000,1000000);
        ?>
        <tr>
<td>Image : <br>
<img src=captcha.php?dt=<? global $data; echo base64_encode($data);?> border="1">
            <input type=hidden name='md5' value =<? echo md5($data);?>></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><input type="submit" name="Submit" value="Submit"></td>
          </tr>
        <tr>
          <td>Result : <b>
            <?
if (count($_REQUEST)>0)
{
		if (md5($_REQUEST['data']) == $_REQUEST['md5'])
		{
			echo "Its Alright";
		}
		else
		{
			echo "Wrong";
		}
}
		echo "IKI : ".$dt;
?>	
            <br>
          </b></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>

