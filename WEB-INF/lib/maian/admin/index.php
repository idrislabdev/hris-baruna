<?php

/*---------------------------------------------
  MAIAN SEARCH v1.1
  Written by David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Website: www.maianscriptworld.co.uk
  This File: Admin -Main Parsing File
----------------------------------------------*/

//-------------------------
//Start session
//Set error reporting
//Get functions
//Get database connection
//Get settings
//-------------------------

session_start();

error_reporting (E_ALL ^ E_NOTICE);

define('INCLUDE_FILES', 1);

include('inc/functions.inc.php');
include('../inc/functions.php');
include('../inc/db_connection.inc.php');

$query = mysql_query("SELECT * FROM ".$database['prefix']."settings LIMIT 1") or die(mysql_error());
$row = mysql_fetch_object($query);

include('../lang/' . $row->language);

//---------------------------------------------------------
//Assign variables
//---------------------------------------------------------

$cmd           = (isset($_GET['cmd']) ? strip_tags($_GET['cmd']) : 'home');
$page          = (isset($_GET['page']) ? strip_tags($_GET['page']) : 1);
$error_string  = array();

//-------------------------------
//Switch Statement
//Displays data based on $cmd
//-------------------------------

switch ($cmd)
{
    //--------------------
    //CASE: HOME
    //Main Display Page
    //--------------------

    case "home":

    if (!isset($_COOKIE['search_cookie']) && !isset($_SESSION['search_user']))
    {
         updated($login9,'index.php?cmd=login',$script4,$script6,$charset);
    }
    
    //----------------------------------------------------------------------------
    //Check to see if the install folder is present in installation directory
    //----------------------------------------------------------------------------
      
    if (is_dir('../install/'))
    {
         $INSTALL_FILE = true;
    }       

    include('inc/header.php');
    include('data_files/home.php');
    include('inc/footer.php');
    break;

    //--------------------
    //CASE: ADD
    //ADD NEW PAGE
    //--------------------

    case "add":
    
    if (!isset($_COOKIE['search_cookie']) && !isset($_SESSION['search_user']))
    {
         updated($login9,'index.php?cmd=login',$script4,$script6,$charset);
    }
    
    //-----------------------
    //SCRIPT ACTION
    //Add New Page
    //-----------------------

    if ((isset($_GET['form'])) && ($_GET['form']=="addpage"))
    {
          $title        = strip_tags(trim($_POST['title']));
          $description  = strip_tags(trim($_POST['description']));
          $url          = strip_tags(trim($_POST['url']));
          $keywords     = strip_tags(trim($_POST['keywords']));

          //Error Checking
          
          if ($title=="")
          {
               $error_string[] = $add6;
          }
          if ($description == "")
          {
               $error_string[] = $add7;
          }
          if ($url=="")
          {
               $error_string[] = $add11;
          }
          if ($keywords=="")
          {
               $error_string[] = $add8;
          }
          if ($error_string)
          {
               error($script5,$error_string,$script7,$charset);
          }
          else
          {
               //Tidy up data
               
               $title        = str_replace("'", "&#039;", $title);
               $description  = str_replace("'", "&#039;", $description);
               $keywords     = str_replace("'", "&#039;", $keywords);
               $title        = str_replace("\"", "&quot;", $title);
               $description  = str_replace("\"", "&quot;", $description);
               $keywords     = str_replace("\"", "&quot;", $keywords);

               if (!get_magic_quotes_gpc())
               {
                    $title        = mysql_real_escape_string($title);
                    $description  = mysql_real_escape_string($description);
                    $url          = mysql_real_escape_string($url);
                    $keywords     = mysql_real_escape_string($keywords);
               }

               mysql_query("INSERT INTO ".$database['prefix']."pages (
                                               title,
                                               description,
                                               url,
                                               keywords
                                               ) VALUES (
                                               '$title',
                                               '$description',
                                               '$url',
                                               '$keywords'
                                               )") or die(mysql_error());

               updated($add9,'index.php?cmd=add',$script4,$script6,$charset);
          }

    }

    include('inc/header.php');
    include('data_files/add.php');
    include('inc/footer.php');
    break;

    //--------------------
    //CASE: ADD
    //EDIT PAGES
    //--------------------

    case "edit":
    
    if (!isset($_COOKIE['search_cookie']) && !isset($_SESSION['search_user']))
    {
         updated($login9,'index.php?cmd=login',$script4,$script6,$charset);
    }
    
    //-----------------------
    //SCRIPT ACTION
    //Edit Page
    //-----------------------

    if ((isset($_GET['form'])) && ($_GET['form']=="update"))
    {
          $id           = $_POST['id'];
          $title        = strip_tags(trim($_POST['title']));
          $description  = strip_tags(trim($_POST['description']));
          $url          = strip_tags(trim($_POST['url']));
          $keywords     = strip_tags(trim($_POST['keywords']));

          //Error Checking
          
          if ($title=="")
          {
               $error_string[] = $add6;
          }
          if ($description == "")
          {
               $error_string[] = $add7;
          }
          if ($url=="")
          {
               $error_string[] = $add11;
          }
          if ($keywords=="")
          {
               $error_string[] = $add8;
          }
          if ($error_string)
          {
               error($script5,$error_string,$script7,$charset);
          }
          else
          {
               //Tidy up data
               
               $title        = str_replace("'", "&#039;", $title);
               $description  = str_replace("'", "&#039;", $description);
               $keywords     = str_replace("'", "&#039;", $keywords);
               $title        = str_replace("\"", "&quot;", $title);
               $description  = str_replace("\"", "&quot;", $description);
               $keywords     = str_replace("\"", "&quot;", $keywords);

               if (!get_magic_quotes_gpc())
               {
                    $title        = mysql_real_escape_string($title);
                    $description  = mysql_real_escape_string($description);
                    $url          = mysql_real_escape_string($url);
                    $keywords     = mysql_real_escape_string($keywords);
               }

               mysql_query("UPDATE ".$database['prefix']."pages SET
                                               title        = '$title',
                                               description  = '$description',
                                               url          = '$url',
                                               keywords     = '$keywords'
                                               WHERE id     = '$id'
                                               LIMIT 1") or die(mysql_error());

               updated($edit2,'index.php?cmd=edit&amp;id=' . $id,$script4,$script6,$charset);
          }

    }
    
    $id = strip_tags($_GET['id']);
    
    $q_edit = mysql_query("SELECT * FROM ".$database['prefix']."pages WHERE id = '$id' LIMIT 1") or die(mysql_error());
    $r_edit = mysql_fetch_object($q_edit);

    include('inc/header.php');
    include('data_files/edit.php');
    include('inc/footer.php');
    break;
    
    //--------------------
    //CASE: SHOW
    //SHOW PAGES
    //--------------------

    case "show":
    
    if (!isset($_COOKIE['search_cookie']) && !isset($_SESSION['search_user']))
    {
         updated($login9,'index.php?cmd=login',$script4,$script6,$charset);
    }
    
    //-----------------------
    //SCRIPT ACTION
    //Delete Multiple Pages
    //-----------------------

    if ((isset($_GET['form'])) && ($_GET['form']=="remove"))
    {
         $pageid = (isset($_POST['pageid']) ? $_POST['pageid'] : '');

         if (empty($pageid))
         {
             $error_string[] = $show12;

             error($script5,$error_string,$script7,$charset);
         }
         else
         {
             foreach ($pageid as $del)
             {
                  mysql_query("DELETE FROM ".$database['prefix']."pages WHERE id = '$del' LIMIT 1") or die(mysql_error());
             }

             updated($show13,'index.php?cmd=show',$script4,$script6,$charset);
         }
    }

    $orderby = (isset($_GET['orderby']) ? $_GET['orderby'] : 'id');
    
    switch ($orderby)
    {
      case "id":
      $sql_order = "ORDER BY id";
      break;

      case "title":
      $sql_order = "ORDER BY title";
      break;

      case "desc":
      $sql_order = "ORDER BY description";
      break;

      case "url":
      $sql_order = "ORDER BY url";
      break;
    }

    include('inc/header.php');
    include('data_files/show.php');
    include('inc/footer.php');
    break;

    //--------------------
    //CASE: SETTINGS
    //Program Settings
    //--------------------
    
    case "settings":
    
    if (!isset($_COOKIE['search_cookie']) && !isset($_SESSION['search_user']))
    {
         updated($login9,'index.php?cmd=login',$script4,$script6,$charset);
    }
    
    //-----------------------
    //SCRIPT ACTION
    //Update Settings
    //-----------------------

    if ((isset($_GET['form'])) && ($_GET['form']=="update"))
    {
         $path         = strip_tags(trim($_POST['path']));
         $total        = strip_tags(trim($_POST['total']));
         $lang         = $_POST['lang'];
         $target       = $_POST['target'];
         $log          = $_POST['log'];
         $skipwords    = strip_tags(trim($_POST['skipwords']));

         //Error checking

         if ($path=="")
         {
             $error_string[] = $settings12;
         }
         if (!eregi('^[0-9]+$', $total))
         {
             $error_string[] = $settings13;
         }
         if ($error_string)
         {
             error($script5,$error_string,$script7,$charset);
         }
         else
         {
             if ($log=="yes")
             {
                  $set_log = "1";
             }
             else
             {
                  $set_log = "0";
             }
             
             //-------------------------------------
             //Create HTML Code for search box
             //-------------------------------------
             
             $html_code = '<form method=&quot;GET&quot; action=&quot;' . $path . '/search.php&quot;>\n';
             $html_code .= '<input type=&quot;hidden&quot; name=&quot;cmd&quot; value=&quot;search&quot;>\n';
             $html_code .= '<input type=&quot;text&quot; name=&quot;keywords&quot;><br>';
             $html_code .= '<input type=&quot;submit&quot; value=&quot;' . $html5 . '&quot;>';
             $html_code .= '</form>';
             
             if (!get_magic_quotes_gpc())
             {
                  $skipwords = mysql_real_escape_string($skipwords);
                  $html_code = mysql_real_escape_string($html_code);
             }

             mysql_query("UPDATE ".$database['prefix']."settings SET
                                        path         = '$path',
                                        total        = '$total',
                                        language     = '$lang',
                                        target       = '$target',
                                        log          = '$set_log',
                                        skipwords    = '$skipwords',
                                        htmlcode     = '$html_code'
                                        WHERE id     = '1'
                                        LIMIT 1") or die(mysql_error());

             updated($settings14,'index.php?cmd=settings',$script4,$script6,$charset);
         }
    }

    include('inc/header.php');
    include('data_files/settings.php');
    include('inc/footer.php');
    break;
    
    //--------------------
    //CASE: HTML
    //HTML CODE
    //--------------------

    case "html":
    
    if (!isset($_COOKIE['search_cookie']) && !isset($_SESSION['search_user']))
    {
         updated($login9,'index.php?cmd=login',$script4,$script6,$charset);
    }

    include('inc/header.php');
    include('data_files/html.php');
    include('inc/footer.php');
    break;
    
    //--------------------
    //CASE: LOG
    //LOG FILE
    //--------------------

    case "log":
    
    if (!isset($_COOKIE['search_cookie']) && !isset($_SESSION['search_user']))
    {
         updated($login9,'index.php?cmd=login',$script4,$script6,$charset);
    }
    
    //-----------------------
    //SCRIPT ACTION
    //Delete Multiple Logs
    //-----------------------

    if ((isset($_GET['form'])) && ($_GET['form']=="remove"))
    {
         if (isset($_POST['remove']))
         {
             $logid = (isset($_POST['logid']) ? $_POST['logid'] : '');

             if (empty($logid))
             {
                $error_string[] = $show12;

                error($script5,$error_string,$script7,$charset);
             }
             else
             {
                foreach ($logid as $del)
                {
                    mysql_query("DELETE FROM ".$database['prefix']."logfile WHERE id = '$del' LIMIT 1") or die(mysql_error());
                }

                updated($log9,'index.php?cmd=log',$script4,$script6,$charset);
             }
         }
         if (isset($_POST['clear']))
         {
             mysql_query("TRUNCATE TABLE ".$database['prefix']."logfile") or die(mysql_error());
             
             updated($log10,'index.php?cmd=log',$script4,$script6,$charset);
         }
    }

    $orderby = (isset($_GET['orderby']) ? $_GET['orderby'] : '');
    
    if ($orderby=="")
    {
         $sql_order = "ORDER BY count DESC";
         $orderby   = "count";
    }
    else
    {
         switch ($orderby)
         {
              case "count":
              $sql_order = "ORDER BY count DESC";
              break;

              case "keyword":
              $sql_order = "ORDER BY keywords";
              break;

              case "percentage":
              $sql_order = "ORDER BY count DESC";
              break;
         }
    }

    include('inc/header.php');
    include('data_files/log.php');
    include('inc/footer.php');
    break;

    //--------------------
    //CASE: LOGIN
    //Displays Login
    //--------------------

    case "login":
    
    if (isset($_COOKIE['search_cookie']) || isset($_SESSION['search_user']))
    {
         updated($login6,'index.php',$script4,$script6,$charset);
    }

    //-----------------------
    //SCRIPT ACTION
    //Login
    //-----------------------

    if ((isset($_GET['form'])) && ($_GET['form']=="enter"))
    {
         $username = $_POST['username'];
         $password = $_POST['password'];
         $cookie   = $_POST['cookie'];

         //Get admin login details

         include('inc/password.inc.php');

         if ($admin_username != md5($username))
         {
              $error_string[] = $login7;
         }
         if ($admin_password != md5($password))
         {
              $error_string[] = $login8;
         }
         if ($error_string)
         {   
              error($script5,$error_string,$script7,$charset);
         }
         else
         {
              $_SESSION['search_user'] = $username;
              $_SESSION['search_pass'] = $password;

              if ($cookie=="yes")
              {
                   setcookie("search_cookie", $username, time()+60*60*24*30);
              }

              updated($login6,'index.php',$script4,$script6,$charset);
         }
    }

    include('inc/header.php');
    include('data_files/login.php');
    include('inc/footer.php');
    break;
    
    //--------------------
    //CASE: LOGOUT
    //Logout Message
    //--------------------

    case "logout":
    
    session_unset();
    session_destroy();
    
    if (isset($_COOKIE['search_cookie']))
    {
         setcookie("search_cookie", "");
    }
    
    unset ($_SESSION['search_user'],$_SESSION['search_pass']);
    
    updated($logout,'index.php?cmd=login',$script4,$script6,$charset);

    break;
    
    //--------------------
    //CASE: SUPPORT
    //Load support msg
    //--------------------
    
    case "support":
    include('data_files/popup/support.php');
    break;
}

?>
