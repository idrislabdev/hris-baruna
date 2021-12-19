function doGetCaretPosition (oField) 
{
	var iCaretPos = 0;
	if (document.selection) // IE Support
	{
		oField.focus ();
		var oSel = document.selection.createRange ();
		// Move selection start to 0 position
		oSel.moveStart ('character', -oField.value.length);
		// The caret position is selection length
		iCaretPos = oSel.text.length;
	}
	else
	{
		//var temp= oField[0].textContent;
		//alert(oField.selectionStart+"--"+temp);
		if (oField.selectionStart || oField.selectionStart == '0') // Firefox support
			iCaretPos = oField.selectionStart;
	}
	return (iCaretPos);
}

function doSetCaretPosition (oField, iCaretPos)
{
	if (document.selection) // IE Support
	{
		oField.focus ();
		var oSel = document.selection.createRange ();
		oSel.moveStart ('character', -oField.value.length);
		oSel.moveStart ('character', iCaretPos);
		oSel.moveEnd ('character', 0);
		oSel.select ();
	}
	else
	{
		if (oField.selectionStart || oField.selectionStart == '0') // Firefox support
			{
			oField.selectionStart = iCaretPos;
			oField.selectionEnd = iCaretPos;
			oField.focus ();
			}
	}
}

function forceupper(o, mode)
{
	var x = doGetCaretPosition(o);
	//alert(x);
	if(mode == "combobox")
	{
		var temp= o.combobox('getValue');
		temp= temp.toUpperCase();
		o.combobox('setValue', temp)
	}
	else
	{
		o.value=o.value.toUpperCase();
	}
	doSetCaretPosition(o,x);
}