<?php

/*---------------------------------------------
  MAIAN SEARCH v1.1
  Written by David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Website: www.maianscriptworld.co.uk
  This File: Search Import Tool
----------------------------------------------*/

//=======================================
// Specify Database Connection Info
//=======================================

$db_host      = 'localhost';         // Database Host
$db_username  = '';                  // Database Username
$db_password  = '';                  // Database Password
$db_database  = 'search';            // Database Name
$db_prefix    = 'ms_';               // Database Prefix

$connect = mysql_connect($db_host , $db_username , $db_password);
mysql_select_db($db_database, $connect) or die(mysql_error());

//================================================
// Process Import - DO NOT EDIT BELOW THIS LINE
//================================================

if (isset($_POST['process']))
{
  $filter    = $_POST['filter'];
  $title     = $_POST['title'];
  $desc      = $_POST['desc'];
  $keywords  = $_POST['keywords'];
  $url       = $_POST['url'];

  $words     = array();

  // Split filter
  
  if ($filter)
  {
    $words = explode(",", strtolower($filter));
  }
  
  //Get title of page
  
  for ($i=0; $i<count($title); $i++)
  {
    mysql_query("INSERT INTO ".$db_prefix."pages (
                             title,
                             description,
                             url,
                             keywords
                             ) VALUES (
                             '".mysql_real_escape_string(trim($title[$i]))."',
                             '".mysql_real_escape_string($desc[$i])."',
                             '".mysql_real_escape_string($url[$i])."',
                             '".mysql_real_escape_string(str_replace($words,"",strtolower($keywords[$i])))."'
                             )") or die(mysql_error());
                             
  }

  $DONE = true;
}

if (isset($_POST['stagetwo']))
{
  $file    = $_POST['file'];
  $filter  = trim($_POST['filter']);
  $url     = trim($_POST['url']);
  
  function cleanData($data)
  {
    if (get_magic_quotes_gpc())
    {
      $data = stripslashes($data);
    }
    
    return $data;
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Maian Search v1.1 Import Tool</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
TD { font-family:verdana,arial;font-size:12px;color:#000000 }
BODY { background-color: #68A7DA; }
A:LINK,A:VISITED,A:ACTIVE,A:HOVER { font-family:verdana,arial;font-size:12px;color:#000000 }
</style>
</head>

<body>
<div align="center">
<table border="0" cellpadding="0" cellspacing="0" width="760" style="background-color:#F0F6FF;border:1px solid #000000">
<tr>
    <td style="padding:10px" align="left"><b>Step Two</b><br><br>
    You have selected to import <b><?php echo count($file); ?></b> page(s) into the search system.<br><br>
    These pages are shown below. Please review the data, then click 'Import'.</td>
</tr>
</table><br>
<form method="POST" name="MyForm" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="process" value="1">
<input type="hidden" name="filter" value="<?php echo cleanData($filter); ?>">
<?php

for ($i=0; $i<count($file); $i++)
{
  $meta   = get_meta_tags($file[$i]);

  $fp = fopen($file[$i], 'r');

  if ($fp)
  {
    $cont = "";

    while(!feof($fp))
    {
      $buf = trim(fgets($fp, 4096)) ;
      $cont .= $buf;
    }

    $title = preg_match( "/<title>(.+)<\/title>/si", $cont, $match);
    $title = strip_tags($match[1]);
  }
  else
  {
    $title = '';
  }


  unset($desc);

?>
<table border="0" cellpadding="0" cellspacing="0" width="760" style="padding:5px;background-color:#F0F6FF;border:2px solid #000000">
<tr>
    <td align="left" width="20%" style="font-family:verdana,arial;font-size:12px;padding:5px"><b>Title</b>:</td>
    <td align="left" width="80%" style="padding:5px"><input type="text" name="title[]" value="<?php echo cleanData($title); ?>" style="width:95%"></td>
</tr>
<tr>
    <td align="left" style="font-family:verdana,arial;font-size:12px;padding:5px"><b>Description</b>:</td>
    <td align="left" style="padding:5px"><input type="text" name="desc[]" value="<?php echo cleanData($meta['description']); ?>" style="width:95%"></td>
</tr>
<tr>
    <td align="left" style="font-family:verdana,arial;font-size:12px;padding:5px"><b>Keywords</b>:</td>
    <td align="left" style="padding:5px"><input type="text" name="keywords[]" value="<?php echo cleanData($meta['keywords']); ?>" style="width:95%"></td>
</tr>
<tr>
    <td align="left" style="font-family:verdana,arial;font-size:12px;padding:5px"><b>URL</b>:</td>
    <td align="left" style="padding:5px"><input type="text" name="url[]" value="<?php echo cleanData($url.'/'.$file[$i]); ?>" style="width:95%"></td>
</tr>
</table><br>
<?php
}
?>
<table border="0" cellpadding="0" cellspacing="0" width="760" style="background-color:#F0F6FF;border:1px solid #000000">
<tr>
   <td align="left" style="padding:5px">If you have lots of pages, please be patient while the importing is in process.<br><br>
   <br><input type="submit" value="Import Data"></td>
</tr>
</table><br>
</form>
</div>
</body>
</html>
<?php
exit;
}

//================================
// Read contents of directory..
//================================

$dir = opendir('./');
$build = array();

while ($read = readdir($dir))
{
  if ($read!='.' && $read!='..' && (substr(strtolower($read),-4)=='html') || (substr(strtolower($read),-3)=='htm'))
  {
    $build[] = $read;
  }
}

closedir($dir);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Maian Search v1.1 Import Tool</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
TD { font-family:verdana,arial;font-size:12px;color:#000000 }
BODY { background-color: #68A7DA; }
A:LINK,A:VISITED,A:ACTIVE,A:HOVER { font-family:verdana,arial;font-size:12px;color:#000000 }
</style>
<script type="text/javascript">
function selectAll()
 {
   for (var i=0;i<document.MyForm.elements.length;i++)
   {
     var e = document.MyForm.elements[i];

     if ((e.name != 'log') && (e.type=='checkbox'))
     {
       e.checked = document.MyForm.log.checked;
     }
   }
 }
</script>
</head>

<body>
<div align="center">
<?php
if (isset($DONE))
{
?>
<table border="0" cellpadding="0" cellspacing="0" width="760" style="background-color:#F0F6FF;border:1px solid #000000">
<tr>
    <td style="padding:10px" align="left"><b>Import Successful..</b><br><br>
    You have successfully imported <b><?php echo count($title); ?></b> pages into the search system.<br><br>
    Now log in to your search admin area and update the pages if necessary.<br><br>
    <a href="import_tool.php"><b>Import More Files</b></a> &raquo;</td>
</tr>
</table><br>
<?php
}
else
{
?>
<table border="0" cellpadding="0" cellspacing="0" width="760" style="background-color:#F0F6FF;border:1px solid #000000">
<tr>
    <td style="padding:10px" align="left"><b>Maian Search v1.1 Import Tool</b>:<br><br>
    Upload this file into any directory that contains .html or .htm pages and <a href="javascript:window.location.reload()">refresh</a> page.</td>
</tr>
</table><br>
<table border="0" cellpadding="0" cellspacing="0" width="760" style="background-color:#F0F6FF;border:1px solid #000000">
<tr>
    <td style="padding:10px" align="left">
    <?php

    if (count($build)==0)
    {
      echo 'No files found to Import.';
    }
    else
    {
      ?>
      <form method="POST" name="MyForm" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <input type="hidden" name="stagetwo" value="1">
      The following files have been found. Check the boxes next to each file you want to add:<br><br>
      <input type="checkbox" name="log" onclick="selectAll()"> Select/De-Select All<br><br>
      --------------------------------------<br><br>
      <?php
      
      for ($i=0; $i<count($build); $i++)
      {
      ?>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
          <td width="10%" align="left"><input type="checkbox" name="file[]" value="<?php echo $build[$i]; ?>"></td>
          <td width="90%" align="left"><b><?php echo $build[$i]; ?></b></td>
      </tr>
      </table><br>
      <?php
      }
      ?>
      --------------------------------------<br><br>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
          <td width="20%" align="left"><b>Word Filter</b> - This is useful if you have words in your description or title tags that you don`t want importing.<br><br>
          Specify words to be omitted during the import. Seperate with a comma. NO spaces.<br><br>
          <textarea name="filter" rows="5" cols="40"></textarea></td>
      </tr>
      </table><br>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
          <td width="20%" align="left"><b>URL Path</b> - Specify the path to the above files. NO trailing slash.<br><br>
          <input type="text" name="url" value="http://<?php echo substr_replace(str_replace("search_import.php", "", $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']),"",-1); ?>" size="35" style="width:75%"></td>
      </tr>
      </table><br>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
          <td align="left"><input type="submit" value="Continue &raquo;"></td>
      </tr>
      </table><br>
      </form>
      <?php
    }

    ?>
    </td>
</tr>
</table>
<?php
}
?> <br>
<table cellpadding="0" width="760" cellspacing="0" border="0" style="background-color:#F0F6FF;border:1px solid #000000">
<tr>
    <td height="15" align="right" style="padding:5px"><b>Powered by</b>: <a href="http://www.maianscriptworld.co.uk/scripts_search.html" title="Maian Search v1.1" target="_blank">Maian Search v1.1</a><br><span class="copyright">&copy; 2005-2006 Maian Script World. All Rights Reserved</span></td>

</tr>
</table>
</div>
</body>
</html>