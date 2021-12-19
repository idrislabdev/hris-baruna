$.fn.datebox.defaults.formatter = function(date) {
	var y = date.getFullYear();
	var m = date.getMonth() + 1;
	var d = date.getDate();
	var H = date.getHours();
	var M = date.getMinutes();
	var S = date.getSeconds();
	return (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
	//return (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y + ' ' + H + ':' + M + ':' + S;
};

$.extend($.fn.validatebox.defaults.rules, {
	dateTime:{
		validator:function(value, param) {
			if(value.length == '19')
			{
				var reg = /^(\d{1,2})(-|\/)(\d{1,2})\2(\d{1,4})(\s([0-1]\d|[2][0-3])(\:[0-5]\d){1,2})?$/;
				return reg.test(value);
			}
			else
			{
				return false;
			}
		},
		message:"Format Tanggal: dd-mm-yyyy hh:mm:ss"
	},
	date:{
		validator:function(value, param) {
			if(value.length == '10')
			{
				var reg = /^(\d{1,2})(-|\/)(\d{1,2})\2(\d{1,4})$/;
				return reg.test(value);
			}
			else
			{
				return false;
			}
		},
		message:"Format Tanggal: dd-mm-yyyy"
	}  
});

$.extend($.fn.datetimebox.defaults,{
	formatter:function(date){
		//alert('b');
		var y = date.getFullYear();
		var m = date.getMonth() + 1;
		var d = date.getDate();
		
		var h = date.getHours();
		var M = date.getMinutes();
		var s = date.getSeconds();
		//var ampm = h >= 12 ? 'pm' : 'am';
		//h = h % 12;
		//h = h ? h : 12;
		function formatNumber(value){
			return (value < 10 ? '0' : '') + value;
		}
		
		var separator = $(this).datetimebox('spinner').timespinner('options').separator;
		var r = $.fn.datebox.defaults.formatter(date) + ' ' + formatNumber(h)+separator+formatNumber(M);
		
		if ($(this).datetimebox('options').showSeconds){
			r += separator+formatNumber(s);
		}
		//r += ' ' + ampm;
		return r;
	},
	parser:function(s){
		if (s) {
			//alert('a');
			var dt = s.split(' ');
			if (dt.length < 2){
				var a = String(s).split('-');
				var d = new Number(a[0]);
				var m = new Number(a[1]);
				var y = new Number(a[2]);
				
				if(s.length < 6)
					y='1900';
				if(s.length < 3)
					m='01';
					
				var hour = parseInt(0, 10) || 0;
				var minute = parseInt(0, 10) || 0;
				var second = parseInt(0, 10) || 0;
				var dd = new Date(y, m-1, d, hour, minute, second);
				return dd;
			}
			else
			{
				//alert('s');
				var d = $.fn.datebox.defaults.parser(dt[0]);
				
				var separator = $(this).datetimebox('spinner').timespinner('options').separator;
				var tt = dt[1].split(separator);
				var hour = parseInt(tt[0], 10) || 0;
				var minute = parseInt(tt[1], 10) || 0;
				var second = parseInt(tt[2], 10) || 0;
				//var ampm = dt[2];
				//if (ampm == 'pm'){
					//hour += 12;
				//}
				//alert(hour);
				
				return new Date(d.getFullYear(), d.getMonth(), d.getDate(), hour, minute, second);
				//return new Date(d.getFullYear(), d.getMonth(), d.getDate(), hour, minute);
			}
		} 
		else 
		{
			return new Date();
		}
	}
});

$.fn.datebox.defaults.parser = function(s) {
	if (s) {
		var dt = s.split(' ');
		if(dt.length < 2)
		{
			var a = s.split('-');
			var d = new Number(a[0]);
			var m = new Number(a[1]);
			var y = new Number(a[2]);
			var dd = new Date(y, m-1, d);
			return dd;
		}
		else
		{
			var a = String(dt[0]).split('-');
			var d = new Number(a[0]);
			var m = new Number(a[1]);
			var y = new Number(a[2]);
			
			
			//var separator = $(this).datetimebox('spinner').timespinner('options').separator;
			var tt = String(dt[1]).split(':');
			var hour = parseInt(tt[0], 10) || 0;
			var minute = parseInt(tt[1], 10) || 0;
			var second = parseInt(tt[2], 10) || 0;
			//var ampm = dt[2];
			//if (ampm == 'pm'){
				//hour += 12;
			//}
			
			var dd = new Date(y, m-1, d, hour, minute, second);
			return dd;
		}
	} 
	else 
	{
		return new Date();
	}
};