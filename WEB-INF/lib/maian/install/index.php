<?php

/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Search v1.1
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Website: http://www.maianscriptworld.co.uk

  +++++++++++++++++++++++++++++++++++++++++++++++++++++++

  This File: index.php
  Description: Installation File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

error_reporting (E_ALL ^ E_NOTICE);

include('../lang/english.php');
include('../inc/db_connection.inc.php');

$step_one    = true;
$step_two    = false;
$step_three  = false;

$whichstep = 'Step One';

$cmd = (isset($_GET['cmd']) ? $_GET['cmd'] : '');

if (!empty($cmd))
{
     switch ($cmd)
     {
          case "stepone":

          $count   = 0;
          $img     = array();
          $table   = array();
          $status  = array();
          
          $whichstep = 'Step Two';

          //Install Table One: Settings =>

          $query_1 = mysql_query("CREATE TABLE ".$database['prefix']."settings (
                                  id             tinyint(1) NOT NULL auto_increment,
                                  path           text,
                                  total          int(3) NOT NULL default '25',
                                  language       varchar(30) NOT NULL default '',
                                  target         enum('0','1'),
                                  log            enum('0','1'),
                                  skipwords      text,
                                  htmlcode       text,
                                  PRIMARY KEY    (id)
                                  ) TYPE=MyISAM;");
          
          if ($query_1)
          {
               $img[]     = '<img style="background-color:#F0F6FF;border-color:#68A7DA" src="images/install_ok.gif" alt="OK" title="OK" border="1">';
               $table[]   = $database['prefix'] . 'settings';
               $status[]  = 'Installed';
          }
          else
          {
               $img[]     = '<img style="background-color:#F0F6FF;border-color:#68A7DA" src="images/install_error.gif" alt="Error" title="Error" border="1">';
               $table[]   = $database['prefix'] . 'settings';
               $status[]  = '<span class="error">Error!</span>';
               $count++;
          }

          //Install Table Two: Pages =>

          $query_2 = mysql_query("CREATE TABLE ".$database['prefix']."pages (
                                  id             int(7) NOT NULL auto_increment,
                                  title          text,
                                  description    text,
                                  url            text,
                                  keywords       text,
                                  PRIMARY KEY    (id)
                                  ) TYPE=MyISAM;");

          if ($query_2)
          {
               $img[]     = '<img style="background-color:#F0F6FF;border-color:#68A7DA" src="images/install_ok.gif" alt="OK" title="OK" border="1">';
               $table[]   = $database['prefix'] . 'pages';
               $status[]  = 'Installed';
          }
          else
          {
               $img[]     = '<img style="background-color:#F0F6FF;border-color:#68A7DA" src="images/install_error.gif" alt="Error" title="Error" border="1">';
               $table[]   = $database['prefix'] . 'pages';
               $status[]  = '<span class="error">Error!</span>';
               $count++;
          }
          
          //Install Table Two: Logfile =>

          $query_3 = mysql_query("CREATE TABLE ".$database['prefix']."logfile (
                                  id int(7)      NOT NULL auto_increment,
                                  keywords       text,
                                  count          int(10) NOT NULL default '0',
                                  PRIMARY KEY    (id)
                                  ) TYPE=MyISAM;");

          if ($query_3)
          {
               $img[]     = '<img style="background-color:#F0F6FF;border-color:#68A7DA" src="images/install_ok.gif" alt="OK" title="OK" border="1">';
               $table[]   = $database['prefix'] . 'logfile';
               $status[]  = 'Installed';
          }
          else
          {
               $img[]     = '<img style="background-color:#F0F6FF;border-color:#68A7DA" src="images/install_error.gif" alt="Error" title="Error" border="1">';
               $table[]   = $database['prefix'] . 'logfile';
               $status[]  = '<span class="error">Error!</span>';
               $count++;
          }
          
          $step_one    = false;
          $step_two    = true;
          $step_three  = false;
          break;

          case "steptwo":
          
          $whichstep = 'Completed';
          
          mysql_query("INSERT INTO ".$database['prefix']."settings (
                                     id,
                                     path,
                                     total,
                                     language,
                                     target,
                                     log,
                                     skipwords,
                                     htmlcode
                                     ) VALUES (
                                     '1', 
                                     'http://www.yoursite.com/search',
                                     '25', 
                                     'english.php', 
                                     '1', 
                                     '1', 
                                     'and,or,with,the,of,to,it,is,on,in,as,am,are,when,was,what,for,from,all,there,them,your,at', 
                                     'Settings Not Updated'
                                     )") or die(mysql_error());

          $step_one    = false;
          $step_two    = false;
          $step_three  = true;
          break;
     }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo $charset; ?>">
<title><?php echo $script . ' ' . $script2; ?> - Installation</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function step_one(URL,txt)
{
     var txt;
     
     alert(txt);
     
     window.location = URL;
}
</script>
</head>

<body>
<div align="center">
<table width="760" border="0" cellpadding="0" cellspacing="0" class="logotablebg">
<tr>
    <td>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td align="center" valign="top" colspan="2"><img src="images/logo.gif" alt="<?php echo $script . ' ' . $script2; ?> - Installation" title="<?php echo $script . ' ' . $script2; ?> - Installation"></td>
    </tr>
    </table>
    </td>
</tr>
</table><br>
<table width="760" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:1px solid #000000;padding:0px;">
<tr>
    <td align="right" style="padding:5px;border-bottom:1px solid #000000;background-color:#68A7DA;color:#FFFFFF">[ <b><?php echo $script . ' ' . $script2; ?> - Installation</b> ]</td>
</tr>
<tr>
    <td align="center"><br>
    <fieldset>
    <legend><?php echo $whichstep; ?></legend><br>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
    <?php
    
    //Installation: Step One =>

    if ($step_one && !$step_two && !$step_three)
    {

    ?>
    <tr>
        <td align="left" valign="top" colspan="2">Welcome to the <?php echo $script . ' ' . $script2; ?> script installation file. This file will set up your database with the required tables and information.<br><br>
        Before you begin make sure you have created a database and specified its connection information in the following file.<br><br><b>inc/db_connection.inc.php</b><br><br>
        If you are unsure of the procedure of how to set up a database, please contact your web hosting company who will be happy to advise you. If you have a server using the CPanel Control Panel, this link may be useful:<br><br>
        <b>- <a href="http://www.cpanel.net/docs/cpanel/" title="CPanel Manual" target="_blank">CPanel Manual</a></b><br><br>
        When you are satisfied that the information you have specified is correct, click the following button to commence setup. Installation will only take a few seconds:
        <p align="center"><br><br><input type="button" class="formbutton" value="INSTALL TABLES &raquo;" title="INSTALL TABLES" onclick="javascript:step_one('index.php?cmd=stepone','If setup terminates for any reason, please revert to manual setup.\n\nSee the docs for more information!')"></p>
        <p>&nbsp;</p></td>
    </tr>
    <?php
    
    }
    
    //Installation: Step Two =>

    if (!$step_one && $step_two && !$step_three)
    {

    ?>
    <tr>
        <td align="left" valign="top" colspan="2">&raquo; <b>Initialising Table Setup....Complete...</b><br><br>&nbsp;&nbsp;&nbsp;Table setup has now completed. Below are the results of step one. If you see no errors, click 'Install Data' to proceed.<br><br><br>
        <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #000000;">
        <tr>
            <td height="20" width="5%" style="padding:5px;background-color:#68A7DA;color:#FFFFFF;border-bottom:1px solid #000000;">&nbsp;</td>
            <td height="20" width="75%" style="padding:5px;background-color:#68A7DA;color:#FFFFFF;border-bottom:1px solid #000000;">[ <b>TABLE</b> ]</td>
            <td height="20" width="20%" style="padding:5px;background-color:#68A7DA;color:#FFFFFF;border-bottom:1px solid #000000;">[ <b>STATUS</b> ]</td>
        </tr>
        <?php
        
        //Loop through arrays and display data

        for ($i=0; $i<count($img); $i++)
        {
          
        ?>
        <tr>
            <td align="center" height="20" style="padding:5px;"><?php echo $img[$i]; ?></td>
            <td height="20" style="padding:5px;"><b><?php echo $table[$i]; ?></b></td>
            <td height="20" style="padding:5px;"><?php echo $status[$i]; ?></td>
        </tr>
        <?php
        
        }
        
        ?>
        </table>
        <p align="center"><br><br><?php echo ($count==0 ? '<input type="button" class="formbutton" value="INSTALL DATA &raquo;" title="INSTALL DATA" onclick="parent.location=\'index.php?cmd=steptwo\'">' : '<span style="color:red;font-size:14px;font-weight:bold;">Installation Aborted!</span><br>Don`t panic, this isn`t as bad as it sounds.<br><br>Please revert to manual setup. See docs for more information.'); ?></p>
        <p>&nbsp;</p></td>
    </tr>
    <?php
    
    }
    
    //Installation: Step Three =>

    if (!$step_one && !$step_two && $step_three)
    {

    ?>
    <tr>
        <td align="left" valign="top" colspan="2">
        <table width="100%" cellpadding="0" align="center" cellspacing="0" style="border: 1px solid #000000;">
        <tr>
            <td align="center" style="padding:5px;color: #FFFFFF; font-size: 20px; font-weight: bold;background-color:#68A7DA;">INSTALLATION COMPLETE!</td>
        </tr>
        </table><br><br>
        Congratulations, you have successfully set up <?php echo $script . ' ' . $script2; ?>. For security reasons it is recommended you delete the <b>/install/</b> directory and all its contents from your server. If you forget, you will see a prompt in your admin area when you log in. This will keep appearing until the directory has been removed.<br><br>
        To complete set up of this script you should do the following:<br><br>
        <b>1. Configure your settings.<br>2. Add a search box to one of your pages.<br>3. Update search template.</b><br><br>To access your administration area, click the following button:<br><br>
        <p align="center"><br><br><input type="button" class="formbutton" value="ACCESS ADMINISTRATION AREA &raquo;" title="ACCESS ADMINISTRATION AREA" onclick="parent.location='../admin/index.php?cmd=login'"></p>
        <p>&nbsp;</p></td>
    </tr>
    <?php
    
    }
    
    ?>
    </table>
    </fieldset>
    <p>&nbsp;</p>
    </td>
</tr>
</table><br>
<table width="760" border="0" cellpadding="0" cellspacing="0" bgcolor="#F0F6FF" style="border:1px solid #000000;padding:7px;">
<tr>
    <td>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td align="right" valign="middle" style="padding-right:5px;"><b>Powered by</b>: <a href="http://www.maianscriptworld.co.uk/scripts_search.html" title="<?php echo $script . ' ' . $script2; ?>" target="_blank"><?php echo $script . ' ' . $script2; ?></a><br>
        <span class="copyright">&copy; 2005-<?php echo date("Y"); ?> Maian Script World. All Rights Reserved</span></td>
    </tr>
    </table>
    </td>
</tr>
</table>
</div>
</body>
</html>
