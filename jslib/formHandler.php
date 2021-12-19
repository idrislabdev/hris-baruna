function doAdd() 
{
    form1.reqMode.value = "requestTambahData";
    form1.action = "<?= $pageAdd ?>"; 
    form1.submit(); 
        
}

function doSubmitEdit() 
{
    form1.reqMode.value = "submitEdit";
    form1.action = "<?= $pageEdit ?>"; 
    form1.submit(); 
        
}

function doEdit(varEdit) 
{
    form1.reqMode.value = "requestEdit";
    form1.action = "<?= $pageEdit ?>?reqBtnId=" + varEdit; 
    form1.submit(); 
        
}

function doDelete() 
{
    if (confirm("Hapus Data?")) { 
        form1.reqMode.value = "submitDelete";
        form1.submit(); 
    }
}

function doViewData() 
{
    form1.reqMode.value = "";
    form1.action = "<?= $pageView ?>"; 
    form1.submit(); 
        
}

function doSubmitSearch() 
{
    form1.reqMode.value = "requestSearch";
    form1.action = "<?= $pageView ?>"; 
    form1.submit(); 
        
}

function doCetak(actionFile) 
{
    form1.reqMode.value = "requestCetak";
    form1.action = actionFile; 
    form1.submit(); 
        
}

function confirmAction(varUrl, varOption)
{
	var varQuestion = new Array();
	
	varQuestion[1] = "Hapus data?";
	varQuestion[2] = "Tambah data?";
	varQuestion[3] = "Anda yakin?";

	if(confirm(varQuestion[varOption]))
	{
		document.location = varUrl;
	}
}

function format_menit(event, nama_text) {
    //var arr_regex = new Array('\\d','\\d','[-]','\\d','\\d','[-]','\\d','\\d','\\d','\\d');
    var arr_regex = new Array('\\d','\\d','[:]','\\d','\\d');
    var current_value = document.getElementById(nama_text).value;            
    var len = document.getElementById(nama_text).value.length;       
    var result_value = '';
    //alert(current_value);
    var current_regex = '';
    var i=0;
    for (i=0; i<len; i++) {
      current_regex += arr_regex[i];
      //alert(arr_regex[i]);
    }
            
    if (!current_value.match(current_regex)) {
        //alert(arr_regex[len-1]+'---');
      if (!isNaN(current_value.substring(len-1, len))) {
        if(arr_regex[len-1] == '[:]')
          current_value = current_value.substring(0,len-1) + ':' + current_value.substring(len-1, len);
        /* else if(arr_regex[len-1] == '[-]')
          current_value = current_value.substring(0,len-1) + '-' + current_value.substring(len-1, len);*/
          document.getElementById(nama_text).value = current_value;
      } else {        
        current_value = current_value.substring(0,len-1);                  
        document.getElementById(nama_text).value = current_value;      
      }
    }    
  }
  
function format_nipp(event, nama_text) {
    var arr_regex = new Array('[3]','[.]','\\d','\\d','\\d','\\d','\\d','\\d','\\d','\\d','\\d');
    var current_value = document.getElementById(nama_text).value;            
    var len = document.getElementById(nama_text).value.length;       
    var result_value = '';
    //alert(current_value);
    var current_regex = '';
    var i=0;
    for (i=0; i<len; i++) {
      current_regex += arr_regex[i];
      //alert(arr_regex[i]);
    }
            
    if (!current_value.match(current_regex)) {
      if (!isNaN(current_value.substring(len-1, len))) {
      	if(arr_regex[len-1] == '[.]')
          current_value = current_value.substring(0,len-1) + '.' + current_value.substring(len-1, len);                  
        else if(arr_regex[len-1] == '[3]')
          current_value = current_value.substring(0,len-1) + '3.' + current_value.substring(len-1, len);
          
          document.getElementById(nama_text).value = current_value;
      } else {        
        current_value = current_value.substring(0,len-1);                  
        document.getElementById(nama_text).value = current_value;      
      }
    }    
  }