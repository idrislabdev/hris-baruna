function CekNumber(id)
	{
		var txt = document.getElementById(id);
		var a = txt.value;//.charAt(txt.value.length-1);
		
		var tmpA;
		var jmlKoma = 0;	
		//while(isNaN(a))
		{
			tmpA = '';
			for(var i=0;i<a.length;i++)
			{	
				if((a.charAt(i)>='0' && a.charAt(i)<='9')||(a.charAt(i)==',' ))
				{					
					tmpA = tmpA+a.charAt(i);
				}
			}
			a = tmpA;
			txt.value = a;
		}
	}
 
function CekDouble(id)
	{
		var txt = document.getElementById(id);
		var a = txt.value;//.charAt(txt.value.length-1);
		
		var tmpA;
		var jmlKoma = 0;	
		//while(isNaN(a))
		{
			tmpA = '';
			for(var i=0;i<a.length;i++)
			{	
				if((a.charAt(i)>='0' && a.charAt(i)<='9') || (i>0 && a.charAt(i)=='.'))
				{					
					tmpA = tmpA+a.charAt(i);
				}
			}
			a = tmpA;
			txt.value = a;
		}
	}
	
function ReplaceString(oldS,newS,fullS) 
{
	 
// Replaces oldS with newS in the string fullS   
	for (var i=0; i<fullS.length; i++) 
	{      
		if (fullS.substring(i,i+oldS.length) == oldS) 
		{         
			fullS = fullS.substring(0,i)+newS+fullS.substring(i+oldS.length,fullS.length)      
		}   
	}   
	return fullS
}

function FormatCurrency(num) 
{
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num))
	num = "0";
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10)
	cents = "0" + cents;
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
	{
		num = num.substring(0,num.length-(4*i+3))+'.'+num.substring(num.length-(4*i+3));
	}
	if(cents != "00")
		return (((sign)?'':'-') +  num + ',' + cents);
	else
		return (((sign)?'':'-') +  num);
}

function FormatCurrencyBaru(num) 
{
	num = num.toString().replace(/\$|\,/g,'');
	
	if(isNaN(num))
		num = "0";
		
	sign = (num == (num = Math.abs(num)));
	
	num_str = num.toString();
	cents = 0;
	
	if(num_str.indexOf(".")>=0)
	{
		num_str = num.toString();
		angka = num_str.split(".");
		cents = angka[1];
	}
	
	num = Math.floor(num).toString();
	
		
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
	{
		num = num.substring(0,num.length-(4*i+3))+'.'+num.substring(num.length-(4*i+3));
	}
	
	if(cents != "00")
		return (((sign)?'':'-') +  num + ',' + cents);
	else
		return (((sign)?'':'-') +  num);
}
    
function CekJam(id)
{
        CekNumber(id);
        var txt = document.getElementById(id);
        if (txt.value == "")
            txt.value = "00"; 
		var a = parseFloat(txt.value);
        if (a > 23)
        {
            txt.value = '00';
        }
        else
        {
            if (a<10)
                txt.value = '0' + a;
            else
                txt.value = a;    
        }
}

function CekMenit(id)
{
        CekNumber(id);
        var txt = document.getElementById(id);
        if (txt.value == "")
            txt.value = "00"; 
		var a = parseFloat(txt.value);
        if (a > 59)
        {
            txt.value = '00';
        }
        else
        {
            if (a<10)
                txt.value = '0' + a;
            else
                txt.value = a;    
        }
}

function FormatUang(id)
{
        CekNumber(id);
        var txt = document.getElementById(id);
		var a = parseFloat(txt.value);
        var nilai = FormatCurrency(a);
        txt.value = nilai;    

}

function FormatUang1(id)
{
        CekNumber(id);
        var txt = document.getElementById(id);
		var num = txt.value;
		num = num.toString().replace(",",".");

		var aPosition = num.indexOf(".");
		if(((aPosition+1)<num.length)||(aPosition<0))
		{
			var a = parseFloat(num);
			var nilai = FormatCurrencyBaru(a);
			txt.value = nilai;    
		}
}

function FormatAngka(id)
{
		//alert(id+':adasd');
        var txt = document.getElementById(id);
		var a = txt.value;
        var nilai = ReplaceString('.','',a);
        txt.value = nilai;    
}

function FormatAngkaNumber(value)
{

		var a = value;
        var nilai = ReplaceString('.','',a);
        var nilai = ReplaceString(',','.',nilai);
        return nilai;    
}

function getWaktuSisa(startTime, endTime, diff)
{
	//var TargetDate = "03/31/2009 5:30:00 PM";//Format waktu yang dipakai
	//var TargetDate = "04/14/2009 14:50:54";//Format waktu yang dipakai
    //startTime, dipakai jika anda menentukan waktu awal sendiri
	//End time: waktu akhir
	//diff = 	perbedaan waktu server dan waktu client. javascript bekerja menggunakan waktu client.
	//			sehingga perlu dihitung selisihnya.
	var sisa = 0;
	var dstart = new Date(startTime);//Di sini tidak digunakan
	var dthen = new Date(endTime);
	var dnow = new Date();
	var diff = Math.floor((dthen-dnow + diff)/1000);
	if (diff > 0){ 
		var hrsDiff = Math.floor(diff/60/60); 
		diff -= hrsDiff*60*60;
		var minsDiff = Math.floor(diff/60);
		diff -= minsDiff*60;
		var secsDiff = diff;  
		if (hrsDiff <10)
		{
			hrsDiff = '0'+ hrsDiff;
		}
		if (minsDiff <10)
		{
			minsDiff = '0' + minsDiff;
		} 
		if (secsDiff <10)
		{
			secsDiff = '0'+ secsDiff;
		}
		sisa = hrsDiff+' : '+minsDiff+' : '+secsDiff;
		//Format Return : HH : MM : SS
	}
	return sisa;
}

function validateEmpty(value, Name) {
    var error = "";
    if (value.length == 0) {
        error = Name + " belum di isi\n";
    } 
    return error;  
}
function validateRadio(radio, Name) 
{
     var error = "";
     var myOption = -1;
    for (i=radio.length-1; i > -1; i--) {
        if (radio[i].checked) {
            myOption = i; i = -1;
        }
    }
        if (myOption == -1) 
            error = Name + " belum di pilih\n";
     return error;     
}
function CekEnter(evt)
{
    evt = (evt) ? evt : event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	//If Press Enter the begin Search
	if(charCode==13){
        return true;
    }
    return false;
}

function hidediv(elementID) {

	document.getElementById(elementID).style.display = 'none';

	document.getElementById(elementID).setAttribute('display', 'none');

}

function showdiv(elementID) {

	document.getElementById(elementID).style.display = 'block';

	document.getElementById(elementID).setAttribute('display', 'block');
}

function CekNumberGrid(a)
	{
		isAngka = '1';
		for(var i=0;i<a.length;i++)
		{	
			if((a.charAt(i)>='0' && a.charAt(i)<='9'))
			{					
				isAngka = isAngka;
			}
			else
			{
				isAngka = '0';
			}
		}
			return isAngka;		
	}

function format_npwp(event, nama_text) {
	var arr_regex = new Array('\\d','\\d','[.]','\\d','\\d','\\d','[.]','\\d','\\d','\\d','[.]','\\d','[-]','\\d','\\d','\\d','[.]','\\d','\\d','\\d');
	var current_value = document.getElementById(nama_text).value;            
	var len = document.getElementById(nama_text).value.length;       
	var result_value = '';
	var current_regex = '';
	var i=0;
	for (i=0; i<len; i++) {
	  current_regex += arr_regex[i];
	}
			
	if (!current_value.match(current_regex)) {
	  if (!isNaN(current_value.substring(len-1, len))) {
		if(arr_regex[len-1] == '[.]')
		  current_value = current_value.substring(0,len-1) + '.' + current_value.substring(len-1, len);                  
		else if(arr_regex[len-1] == '[-]')
		  current_value = current_value.substring(0,len-1) + '-' + current_value.substring(len-1, len);                  
		  document.getElementById(nama_text).value = current_value;      
	  } else {        
		current_value = current_value.substring(0,len-1);                  
		document.getElementById(nama_text).value = current_value;      
	  }
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

function format_date(event, nama_text) {        
    var arr_regex = new Array('\\d','\\d','[-]','\\d','\\d','[-]','\\d','\\d','\\d','\\d');
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
    
    //alert(current_value.substring(0,len-1)+'---'+current_value.substring(len, len));
    
    if (!current_value.match(current_regex)) {
        //alert(arr_regex[len-1]+'---');
      if (!isNaN(current_value.substring(len-1, len))) {
        /*if(arr_regex[len-1] == '[.]')
          current_value = current_value.substring(0,len-1) + '.' + current_value.substring(len-1, len);                  
        else */if(arr_regex[len-1] == '[-]')
          current_value = current_value.substring(0,len-1) + '-' + current_value.substring(len-1, len);
          document.getElementById(nama_text).value = current_value;      
      } else {        
        current_value = current_value.substring(0,len-1);                  
        document.getElementById(nama_text).value = current_value;      
      }
    }    
  }
  