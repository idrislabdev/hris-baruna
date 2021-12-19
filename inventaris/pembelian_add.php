<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");


$reqId = httpFilterGet("reqId");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link rel="icon" 
      type="image/ico" 
      href="images/favicon.ico" />
<title>Reporting Application</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="StyleSheet" href="../WEB-INF/lib/dtree/dtree.css" type="text/css" />
<link href="tabs.css" rel="stylesheet" type="text/css" />
<link href="themes/main.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../jslib/displayElement.js"></script>
<!-- POPUP WINDOW -->
<link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
<script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>

<script language="JavaScript">
function openPopup(opUrl,opWidth,opHeight)
{
    newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top = 100, left = 150");
    newWindow.focus();
}

function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
{
    var left = (screen.width/2)-(opWidth/2);
    
    divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=20,resize=1,scrolling=1,midle=1'); return false;
}

function OptionSetDokumen(id){
    $("iframe#idMainFrameDetil")[0].contentWindow.OptionSetDokumen(id);
}
</script>

</head>

<body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" height="100%" bgcolor="#F0F0F0" style="overflow:hidden">
    <tr> 
        <td height="100%" valign="top" class="menu" width="1"> 
            <table width="242" border="0" cellpadding="0" cellspacing="0" height="100%" id="menuFrame">
                <tr> 
                    <td height="100%"></td>
                    <td valign="top">
                    <!-- MENU -->
                    <iframe src="pembelian_add_menu.php?reqId=<?=$reqId?>" name="menuFramePop" width="100%" height="100%" scrolling="auto" frameborder="0"></iframe>        
                    </td>
                </tr>
            </table>
        </td>
        <td width="3" background="images/bg_menu_right.gif" align="right">
            <a href="javascript:displayElement('menuFrame')"><img src="../WEB-INF/images/btn_display_element.gif" title="Buka/Tutup Menu" border="0"></a>
        </td>
        <td valign="top" height="100%" width="100%">
            <table cellpadding="0" cellspacing="0"  width="100%" height="100%">
                <tr height="50%">
                    <td><iframe src="pembelian_add_data_add.php?reqId=<?=$reqId?>" class="mainframe" id="idMainFrame" name="mainFramePop" width="100%" height="100%" scrolling="auto" frameborder="0"></iframe></td>
                </tr>
                <tr height="50%" id="trdetil" style="display:none">
                    <td><iframe src="" class="mainframe" id="idMainFrameDetil" name="mainFrameDetilPop" width="100%" height="100%" scrolling="no" frameborder="0"></iframe></td>
                </tr>
            </table>            
        </td>
    </tr>
</table>
</body>
</html>
