/********************************************************************************************************
MODUL NAME 			: SIMKeu
FILE NAME 			: displayElement.js
AUTHOR				: Ridwan Rismanto
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Show or hide content
********************************************************************************************************/

var varElement;

function displayElement(reqElementId)
{
	varElement = reqElementId;
	if(document.getElementById(varElement).style.display == '' || document.getElementById(varElement).style.display == 'inline')
		doHideMenu();
	else if(document.getElementById(varElement).style.display == 'none')
		doShowMenu();
}

function doHideMenu()
{
	document.getElementById(varElement).style.display = 'none';
	document['showhide-button'].title = 'Buka Menu';
}

function doShowMenu()
{
	document.getElementById(varElement).style.display = '';
	document['showhide-button'].title = 'Tutup Menu';
}