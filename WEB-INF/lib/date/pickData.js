var tabShow=0;

function pickData(s){
	if (s != null) {	
		var a = s.split("#");	
		window.opener.document.frm.id_field.value=a[0];
		window.opener.document.frm.pageid.value="a";
	}
			
			window.close();				
}

