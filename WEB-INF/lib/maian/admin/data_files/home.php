<?php

/*---------------------------------------------
  MAIAN SEARCH v1.1
  Written by David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Website: www.maianscriptworld.co.uk
  This File: Admin - Home
----------------------------------------------*/

if(!defined('INCLUDE_FILES'))
{
	include('index.html');
	exit;
}

?>
<tr>
    <td class="tdmain" colspan="2" align="left">
    <?php
    if (isset($INSTALL_FILE))
    {
    ?>
    <table width="100%" cellpadding="3" cellspacing="3" border="0" style="border: 1px solid #FF0000;">
    <tr>
        <td align="center" class="error"><b>WARNING!</b><br><br>Please remove the &#039;/install/&#039; folder from your installation directory.</td>
    </tr>
    </table><br>
    <?php
    }
    
    ?>    
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td align="left">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #000000">
        <tr>
           <td align="left" style="padding:5px;background-color:#F0F6FF;color:#000000">Welcome to Maian Search, a simple script that enables you to put a search engine on your website. Use the links
           above to manage your search engine. This is aimed to be a nice simple system, so please don&#096;t expect too many advanced features in the future. :)<br><br>
           For details on how to get started with your search system, please see the <a href="../docs/setup/" target="_blank"><u>documentation</u></a>. If you have any problems, please use the support link top left.</td>
        </tr>
        </table><br>
        <table cellpadding="0" cellspacing="1" width="100%" align="center" style="border:1px solid #68A7DA">
        <tr>
            <td align="left" height="20" class="menutable" width="85%">&nbsp;&raquo; <b>Donations</b></td>
        </tr>
        </table><br>
        If you like this script and would like to send a small donation as a token of appreciation, please click the following link:<br><br>
        <a href="https://www.paypal.com/xclick/business=support%40maianscriptworld%2eco%2euk&amp;item_name=Maian%20Search%20v1%2e1&amp;item_number=ms_2006&amp;no_shipping=0&amp;no_note=1&amp;tax=0&amp;currency_code=GBP" target="_blank"><img src="../images/donation.gif" border="0" alt="Donate using Paypal" title="Donate using Paypal"></a><br><br>
        Donations help towards to continued development of Maian Search.<br><br>
        Hope you enjoy this script,<br><br>David.<br><a href="http://www.maianscriptworld.co.uk" target="_blank" title="Maian Script World">www.maianscriptworld.co.uk</a><br><br>
        </td>
    </tr>
    </table><br>
    </td>
</tr>

