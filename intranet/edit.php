<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link rel="icon" 
      type="image/ico" 
      href="images/favicon.ico" />
<title>Sistem Informasi Pegawai (SIP)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="StyleSheet" href="../WEB-INF/lib/dtree/dtree.css" type="text/css" />
<link href="tabs.css" rel="stylesheet" type="text/css" />
<link href="themes/main.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../jslib/displayElement.js"></script>
<script language="JavaScript">
function openPopup(opUrl,opWidth,opHeight)
{
	newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top = 100, left = 150");
	newWindow.focus();
}
</script>

</head>

<body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">

<script language=JavaScript>
<!--

//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com

var message="Function Disabled!";

///////////////////////////////////
function clickIE4(){
if (event.button==2){
alert(message);
return false;
}
}

function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
alert(message);
return false;
}
}
}

if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

document.oncontextmenu=new Function("return false")

// --> 
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" height="100%" bgcolor="#F0F0F0" style="overflow:hidden">
	<tr id="banner">
    	<td colspan="5" style="background-image:url(images/bg-title-popup.png);height:70px;">
        &nbsp;
        </td>
    </tr>
   	<tr> 
    	<td height="100%" valign="top" class="menu" width="1"> 
      		<table width="242" border="0" cellpadding="0" cellspacing="0" height="100%" id="menuFrame">
        		<tr> 
		  			<td height="100%"></td>
         			<td valign="top">
		  			<? //include "menu-tree-inc.php"; ?>		
				  	<!-- MENU -->
				  	<iframe src="edit_menu.php?reqJenisId=<?=$reqJenisId?>&reqPegawaiId=<?=$reqId?>&reqIdOrganisasi=<?=$reqIdOrganisasi?>" name="menuFramePop" width="100%" height="100%" scrolling="auto" frameborder="0"></iframe>		  
		  			</td>
        		</tr>
      		</table>
		</td>
		<td width="3" background="images/bg_menu_right.gif" align="right">
			<a href="javascript:displayElement('menuFrame')"><img src="../WEB-INF/images/btn_display_element.gif" title="Buka/Tutup Menu" border="0"></a>
		</td>
    	<td valign="top" height="100%" width="100%">
            <table cellpadding="0" cellspacing="0"  width="100%" height="100%">
            	<tr height="10%">
                	<td><iframe src="identitas_edit.php?reqJenisId=<?=$reqJenisId?>&reqPegawaiId=<?=$reqId?>&reqIdOrganisasi=<?=$reqIdOrganisasi?>" class="mainframe" id="idMainFrame" name="mainFramePop" width="100%" height="100%" scrolling="auto" frameborder="0"></iframe></td>
                </tr>
            	<tr height="20%" id="trdetil" style="display:none">
                	<td><iframe src="" class="mainframe" id="idMainFrame" name="mainFrameDetilPop" width="100%" height="100%" scrolling="no" frameborder="0"></iframe></td>
                </tr>
            </table>			
		</td>
	</tr>
</table>
</body>
</html>
