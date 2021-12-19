<?php

/*---------------------------------------------
  MAIAN SEARCH v1.1
  Written by David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Website: www.maianscriptworld.co.uk
  This File: Program Functions
  Added in v1.1
----------------------------------------------*/

//======================
// Clean up function
//======================

function cleanData($data)
{
  if (get_magic_quotes_gpc())
  {
    $data = stripslashes($data);
  }

  return $data;
}

//======================
// PAGE NUMBERS
//======================

function page_numbers($count,$limit,$url,$page,$size='100%',$border='68A7DA',$font='font-size:11px;',$break='<br>',$get='index')
{
  global $show15;

  $numofpages  = $count/$limit;
  $data        = '';

  for ($i=1; $i<=$numofpages; $i++)
  {
    if ($i == $page)
    {
      $data .= '<b>' . $i . '</b>&nbsp;';
    }
    else
    {
      $data .= '[<a href="'.$get.'.php?'.$url.'&amp;page=' . $i . '" title="' . $i . '">' . $i . '</a>] ';
    }
  }
  if ($count % $limit != 0)
  {
    if ($i == $page)
    {
      $data .= '<b>' . $i . '</b>&nbsp;';
    }
    else
    {
      $data .= '[<a href="'.$get.'.php?'.$url.'&amp;page=' . $i . '" title="' . $i . '">' . $i . '</a>] ';
    }
  }

  $body_area = $break.'
                <div align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="'.$size.'" style="border:1px solid #'.$border.'">
                <tr>
                   <td align="left" width="20%"style="'.$font.'padding:5px;background-color:#F0F6FF;color:#000000"><b>'.$show15.'</b> ('.ceil($numofpages).'):</td>
                   <td align="right" width="80%" style="'.$font.'padding:5px;background-color:#F0F6FF;color:#000000">'.$data.'</td>
                </tr>
                </table><br>
                </div>
';

return $body_area;

}

?>
