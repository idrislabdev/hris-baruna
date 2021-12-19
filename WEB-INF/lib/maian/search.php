<?php

/*---------------------------------------------
  MAIAN SEARCH v1.1
  Written by David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Website: www.maianscriptworld.co.uk
  This File: Search Results
----------------------------------------------*/

error_reporting (E_ALL ^ E_NOTICE);

//------------------------------
// Set path to events folder
//------------------------------

$path_to_folder = dirname(__FILE__).'/';

include($path_to_folder.'inc/db_connection.inc.php');
include($path_to_folder.'inc/functions.php');

$query = mysql_query("SELECT * FROM ".$database['prefix']."settings LIMIT 1") or die(mysql_error());
$row = mysql_fetch_object($query);

include($path_to_folder.'lang/' . $row->language);

//-----------------------------
//Get Savant template class
//-----------------------------

include($path_to_folder.'lib/Savant2.php');

//--------------------------------------------
//Create instance of Savant template class
//--------------------------------------------

$tpl =& new Savant2();

//----------------------------
//Footer variable
//Please DO NOT remove this
//----------------------------

$show_footer  = '<b>'.$script3 . '</b>: <a href="http://www.maianscriptworld.co.uk/scripts_search.html" title="' . $script . ' ' . $script2 . '" target="_blank">' . $script . ' ' . $script2 . '</a><br>';
$show_footer  .= '<span class="copyright">&copy; 2005-' . date("Y") . ' Maian Script World. '.$script8.'</span>';
//----------------------------------
//Function to generate query time
//----------------------------------

function searchQueryTime()
{
    $mtime  = explode(" ",microtime());
    $msec   = (double)$mtime[0];
    $sec    = (double)$mtime[1];

    return $sec + $msec;
}

//---------------------------
// Assign variables/Arrays
//---------------------------

$skipped_words  = array();
$search_words   = array();
$end            = 0;
$start          = 0;
$page           = (isset($_GET['page']) ? (int)strip_tags($_GET['page']) : 1);

//-----------------------
//Generate search data
//-----------------------

 if ((isset($_GET['cmd'])) && ($_GET['cmd']=="search"))
 {
      $keywords = strip_tags(trim($_GET['keywords']));
      
      //-------------------------------------------
      //Check if there are any keywords present
      //-------------------------------------------
      
      if ($keywords)
      {
          //-------------------------
          //Commence query time
          //-------------------------

          $start = searchQueryTime();
          
          //------------------------------------
          //Assign arrays
          //1. Seperate keywords with a space
          //2. Seperate skipwords with a comma
          //------------------------------------

          $get_words = explode(" ", strtolower($keywords));
          $skipwords = explode(",", $row->skipwords);

          //-----------------------------------------------------------------
          //Loop through keywords
          //Seperate skipped words if at least one valid keyword is found
          //-----------------------------------------------------------------

          for ($i=0; $i<count($get_words); $i++)
          {
               //------------------------------------------------------------------------
               //Loop through keywords
               //If NOT in skipwords array, assign keywords to $search_words array
               //If IN skipwords array, assign keywords to $skipped_words array
               //Are you following this so far? LOL
               //------------------------------------------------------------------------

               if (!in_array($get_words[$i], $skipwords))
               {
                    $search_words[] = $get_words[$i];
               }
               else
               {
                    $skipped_words[] = $get_words[$i];
               }
          }

          //-------------------------------------------------------------
          //If there is at least 1 unique keyword, build search data
          //-------------------------------------------------------------

          if (count($search_words)>0)
          {
               //--------------------------------
               //Loop through unique keywords
               //--------------------------------

               for ($i=0; $i<count($search_words); $i++)
               {
                    //----------------------------------------------------------------
                    //If log file is enabled, log search words
                    //Only log on the first page, so if page is present, do nothing
                    //----------------------------------------------------------------
                    
                    if ($row->log)
                    {
                        if ($page==1)
                        {
                            $q_log = mysql_query("SELECT count(*) as log_count FROM ".$database['prefix']."logfile WHERE keywords = '" . $search_words[$i] . "' LIMIT 1") or die(mysql_error());
                            $count_log = mysql_fetch_object($q_log);

                            //-----------------------------------------------------
                            //If word already exists in logfile, add 1 to count
                            //-----------------------------------------------------

                            if ($count_log->log_count>0)
                            {
                                mysql_query("UPDATE ".$database['prefix']."logfile SET count=(count+1) WHERE keywords = '" . $search_words[$i] . "' LIMIT 1") or die(mysql_error());
                            }
                            else
                            {
                                //------------------------------------------------------
                                //Else add word to database
                                //Backslash problematic quotes if magic quotes are OFF
                                //If ON, this is done automatically and is not needed
                                //------------------------------------------------------

                                if (!get_magic_quotes_gpc())
                                {
                                     $k_word = mysql_real_escape_string($search_words[$i]);
                                }
                                else
                                {    
                                     $k_word = $search_words[$i];
                                }

                                mysql_query("INSERT INTO ".$database['prefix']."logfile (keywords,count) VALUES ('" . $k_word . "','1')") or die(mysql_error());

                                unset($k_word);
                            }
                        }
                    }

                    //-------------------------
                    //Build SQL query data
                    //-------------------------

                    if ($i)
                    {
                         $search_string .= "OR title LIKE '%".mysql_real_escape_string($search_words[$i])."%' OR description LIKE '%".mysql_real_escape_string($search_words[$i])."%' OR keywords LIKE '%".mysql_real_escape_string($search_words[$i])."%' ";
                    }
                    else
                    {
                         $search_string = "title LIKE '%".mysql_real_escape_string($search_words[$i])."%' OR description LIKE '%".mysql_real_escape_string($search_words[$i])."%' OR keywords LIKE '%".mysql_real_escape_string($search_words[$i])."%' ";
                    }
               }
               
               $sql_search_data = "WHERE (" . $search_string . ")";

               //-------------------------------------
               //Default variables for page numbers
               //-------------------------------------

               $limitvalue = $page * $row->total - ($row->total);
               
               //-----------------------------
               //Query database for results
               //-----------------------------
               
               $search_count = mysql_query("SELECT count(*) as search_count FROM ".$database['prefix']."pages $sql_search_data") or die(mysql_error());
               $this_search_count = mysql_fetch_object($search_count);

               $search_query = mysql_query("SELECT * FROM ".$database['prefix']."pages $sql_search_data ORDER BY id DESC LIMIT $limitvalue, $row->total") or die(mysql_error());

               //------------------------------------------------
               //If results are found search results are true
               //Else they are false and no results were found
               //------------------------------------------------

               if (mysql_num_rows($search_query)>0)
               {
                    $SEARCH_RESULTS = true;
               }
               else
               {
                    $NO_RESULTS = true;
               }
          }
          else
          {
               $NO_RESULTS = true;
          }
          
          //--------------------
          //End query time
          //--------------------

          $end = searchQueryTime();
      }
      else
      {
         $NO_RESULTS = true;
      }
 }
 
//------------------------------------------
//If results have been found, show them.
//------------------------------------------

$data_code     = '';
$page_numbers  = '';

if (isset($SEARCH_RESULTS))
{
   $data_code = '<table cellpadding="1" cellspacing="1" width="760" class="results">
                 <tr>
                     <td class="displaytd">';
   
   //------------------------------------------------------------------------
   //If a search was performed and words were skipped, show skipped words
   //------------------------------------------------------------------------

   if (count($skipped_words)>0)
   {
     $data_code .= $search5 . '<b> ';

     foreach ($skipped_words as $common)
     {
           $data_code .= $common . '&nbsp;';
     }

     $data_code .= '</b><br><br>';
   }
   
   //-----------------------------------------
   //Calculate query time
   //End minus Start = Time
   //number_format formats to 4 dec places
   //-----------------------------------------

   $data_code .= $search6 . ': <b>' . (isset($this_search_count) ? $this_search_count->search_count : 0). '</b><br>' . $search7 .  ' ' . number_format($end - $start,4)  . ' ' . $search8 . '</td>';
   $data_code .= '</tr>
                  </table><br>';
   
   //--------------------------------
   //Loop through search results
   //--------------------------------

   if (isset($search_query))
   {
     while ($showsearch = mysql_fetch_assoc($search_query))
     {
       $data_code .= '<table cellpadding="1" cellspacing="1" width="760" class="results">
                      <tr>
                          <td height="15" width="3" class="searchtab" align="left">&nbsp;</td>
                          <td width="757" height="15" class="displaytd" align="left">&nbsp;&nbsp;<b><a href="' . $showsearch['url'] . '"'.(($row->target) ? ' target="_BLANK" ' : ' ').'title="' . cleanData($showsearch['title']) . '">' . strtoupper(cleanData($showsearch['title'])) . '</a></b></td>
                      </tr>
                      <tr>
                          <td height="15" align="left">&nbsp;</td>
                          <td height="15" class="displaytd" align="left">' . cleanData($showsearch['description']) . '</td>
                      </tr>
                      <tr>
                          <td height="15" align="left">&nbsp;</td>
                          <td height="15" class="displaytd" align="left"><i>URL: ' . $showsearch['url'] . '</i></td>
                      </tr>
                      </table><br>
                      ';
     }
   }
}

//---------------------------------------------
//If no results were found, display message
//---------------------------------------------

if (isset($NO_RESULTS))
{
    $data_code = '<table cellpadding="1" cellspacing="1" width="760" class="results">
                  <tr>
                      <td class="displaytd" align="left"><span style="color:#FF0000;"><b>' . $search . '</b></span><br><br>' . $search2 . '.<br><br>' . $search3 . '.<br><br></td>
                  </tr>
                  </table><br>';

    $page_numbers = 0;
}

//------------------------------------------
// Assign values to the Savant instance.
//------------------------------------------

$tpl->assign('CHARSET', $charset);
$tpl->assign('TITLE', $script . ' ' . $script2);
$tpl->assign('HEADER', $search4);
$tpl->assign('RESULTS', $data_code);
$tpl->assign('PAGE_NUMBERS', page_numbers((isset($this_search_count) ? $this_search_count->search_count : 0),$row->total,'cmd=search&amp;keywords='.(isset($keywords) ? rawurlencode($keywords) : ''),$page,'760','000000','','','search'));
$tpl->assign('FOOTER', $show_footer);

//----------------------
//Display template
//----------------------

$tpl->display('templates/search.tpl.php');

?>
