var tabindex = 1; //start tabindex || 150 is last tabindex

$(document).keydown(function(event) {
	if(event.keyCode==13) event.preventDefault();
});

$(document).keyup(function(event) {
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '9' || keycode == '13') { //onEnter
		$("input, select, textarea").css("border-color","white");
		event.stopImmediatePropagation();
		event.stopPropagation();
		event.preventDefault();
		tabindex++;
		//while element exist or it's readonly and tabindex not reached max do
		while(($("[TabIndex='"+tabindex+"']").length == 0 || $("[TabIndex='"+tabindex+"']:not([readonly])").length == 0) && tabindex != 150 ){
		tabindex++;
		}
		if(tabindex == 150){ tabindex = 1 } //reseting tabindex if finished

		try {
			var classname = $("[TabIndex='"+tabindex+"']").attr('class');
			classname = classname.substr(0, 15);
			if(classname.trim() == 'easyui-combobox')
			{
				$("[TabIndex='"+tabindex+"']").next().find('input').focus();
			}
			else if(classname.trim() == 'easyui-datebox')
				$("[TabIndex='"+tabindex+"']").next().find('input').focus();
			else
				$("[TabIndex='"+tabindex+"']").focus();
			$("[TabIndex='"+tabindex+"']").css("border-color","black");
		}
		catch(err) {
			$("[TabIndex='"+tabindex+"']").focus();
			$("[TabIndex='"+tabindex+"']").css("border-color","black");
		}		
		return false;
	}

});


function disableByPolaEntry(id, urut)
{
	var lasttabindex = $("#reqBukuBesar"+urut).attr("tabindex");
	if(id == 0)
	{		
		/* reset */
		$("#reqKartu"+urut).combobox('enable');
		$("#reqBukuPusat"+urut).combobox('enable');
		$("#reqKartu"+urut).attr("tabindex", lasttabindex + 1);
		$("#reqBukuPusat"+urut).attr("tabindex", lasttabindex + 2);
		$("#reqBukuPusat"+urut).combobox('enable');
		
		/* set */			
		$("#reqKartu"+urut).removeAttr("tabindex");
		$("#reqBukuPusat"+urut).removeAttr("tabindex");
		$("#reqKartu"+urut).combobox('disable');
		$("#reqBukuPusat"+urut).combobox('disable');
		
	}
	else if(id == 1)
	{
		/* reset */
		$("#reqKartu"+urut).combobox('enable');
		$("#reqBukuPusat"+urut).combobox('enable');
		$("#reqKartu"+urut).attr("tabindex", lasttabindex + 1);
		$("#reqBukuPusat"+urut).attr("tabindex", lasttabindex + 2);
		
		/* set */	
		$("#reqBukuPusat"+urut).removeAttr("tabindex");		
		$("#reqBukuPusat"+urut).combobox('disable');
	}
	else if(id == 2)
	{
		/* reset */
		$("#reqKartu"+urut).combobox('enable');
		$("#reqBukuPusat"+urut).combobox('enable');
		$("#reqKartu"+urut).attr("tabindex", lasttabindex + 1);
		$("#reqBukuPusat"+urut).attr("tabindex", lasttabindex + 2);

		/* set */
		$("#reqKartu"+urut).removeAttr("tabindex");			
		$("#reqKartu"+urut).combobox('disable');
	}

	else if(id == 3)
	{
		/* reset */
		$("#reqKartu"+urut).attr("tabindex", lasttabindex + 1);
		$("#reqBukuPusat"+urut).attr("tabindex", lasttabindex + 2);
		
		/* set */
		$("#reqKartu"+urut).combobox('enable');
		$("#reqBukuPusat"+urut).combobox('enable');
	}	
	else
	{
		/* reset */
		$("#reqKartu"+urut).combobox('enable');
		$("#reqBukuPusat"+urut).combobox('enable');
		$("#reqKartu"+urut).attr("tabindex", lasttabindex + 1);
		$("#reqBukuPusat"+urut).attr("tabindex", lasttabindex + 2);

		/* set */
		$("#reqKartu"+urut).removeAttr("tabindex");
		$("#reqBukuPusat"+urut).removeAttr("tabindex");	
		$("#reqKartu"+urut).combobox('disable');
		$("#reqBukuPusat"+urut).combobox('disable');
	}
		
}
			
$(function(){
/*	$('input[type=text]:visible:first').focus();
	$('input, textarea, select').keydown( function(e) {
		var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
		if(key == 13) {
			e.preventDefault();
			var inputs = $(this).closest('form').find(':input:visible');
			
			inputs.eq( inputs.index(this)+ 1 ).focus();
		}
	});*/
	
	$.extend($.fn.validatebox.defaults.rules, {  
		exists:{
			validator:function(value,param){
				var cc = $(param[0]);
				var v = cc.combobox('getValue');
				var rows = cc.combobox('getData');
				for(var i=0; i<rows.length; i++){
					if (rows[i].id == v){return true}
				}
				return false;
			},
			message:'Data yang terpilih tidak ada.'
		},
		checkOption:{
			validator:function(value,param){
				var tempId= param[0];
				var panjang= $(":input[id^="+tempId+"]").length;
				var indexParam= param[1];
				
				var cc = $("#"+tempId+indexParam);
				var value_parameter = cc.combobox('getValue');
				
				for(var i=0; i < panjang; i++)
				{
					if(i == indexParam)
						continue;
					else
					{
						var valPembanding= $("#"+tempId+i).combobox('getValue');
						if(valPembanding == value_parameter)
							return false;
					}
				}
				return true;
			},
			message:'Data yang terpilih sudah dipilih.'
		},
		checkAnggaran:{
			validator:function(value,param){
				var comboBb = $("#reqBukuBesar"+param[0]).combobox('getValue');
				var comboBp = $("#reqBukuPusat"+param[0]).combobox('getValue');
				var textHarga = FormatAngkaNumber($("#reqHarga"+param[0]).val());
				var pengurang = 0;
				if(comboBb == "")
					$("#reqHarga"+param[0]).val('0');
				if(comboBp == "")
					$("#reqHarga"+param[0]).val('0');
				if(typeof param[1] == "undefined")
				{}
				else
					reqid = param[1];
					
			    $.getJSON("../json-anggaran/validasi_anggaran_json.php?reqId="+reqid+"&reqJumlah="+textHarga+"&reqKdBukuBesar="+comboBb+"&reqKdBukuPusat="+comboBp,
			    function(data){
					$("#reqValidasi"+param[0]).val(data.NILAI);
			    });				
				if($("#reqValidasi"+param[0]).val() == "1")
					return true;
				else
				{
					return false;
				}
			},
			message:'Anggaran over budget.'
		},
		checkAnggaranKasKecil:{
			validator:function(value,param){
				var textPuspel = $("#reqPuspel").val();
				var textHarga = FormatAngkaNumber($("#reqJumlahDiBayar").val());
			    $.getJSON("../json-anggaran/validasi_anggaran_kas_kecil_json.php?reqPuspel="+textPuspel+"&reqJumlah="+textHarga,
			    function(data){
					$("#reqValidasi"+param[0]).val(data.NILAI);
			    });				
				if($("#reqValidasi"+param[0]).val() == "1")
					return true;
				else
				{
					return false;
				}
			},
			message:'Anggaran over budget.'
		},
		checkAnggaranOverbudget:{
			validator:function(value,param){
				var comboBb = $("#reqBukuBesar"+param[0]).combobox('getValue');
				var comboBp = $("#reqBukuPusat"+param[0]).combobox('getValue');
				var textHarga = FormatAngkaNumber($("#reqHarga"+param[0]).val());
				var pengurang = 0;
				var pengurang_overbudget = 0;
				if(comboBb == "")
					$("#reqHarga"+param[0]).val('0');
				if(comboBp == "")
					$("#reqHarga"+param[0]).val('0');
				if(typeof param[1] == "undefined")
				{}
				else
					reqid = param[1];
					
			    $.getJSON("../json-anggaran/validasi_anggaran_overbudget_json.php?reqId="+reqid+"&reqJumlah="+textHarga+"&reqKdBukuBesar="+comboBb+"&reqKdBukuPusat="+comboBp,
			    function(data){
					$("#reqValidasi"+param[0]).val(data.NILAI);
					$("#reqOverbudget"+param[0]).val(FormatCurrency(data.OVERBUDGET));	
			    });				
				if($("#reqValidasi"+param[0]).val() == "1")
				{			
					return true;
				}
				else
				{
					return false;
				}
			},
			message:'Anggaran tidak over budget. entri melalui PPA'
		},
		checkAnggaranOverbudgetKasKecil:{
			validator:function(value,param){
				var textPuspel = $("#reqPuspel").val();
				var textHarga = FormatAngkaNumber($("#reqJumlahDiBayar").val());
			    $.getJSON("../json-anggaran/validasi_anggaran_overbudget_kas_kecil_json.php?reqPuspel="+textPuspel+"&reqJumlah="+textHarga,
			    function(data){
					$("#reqValidasi"+param[0]).val(data.NILAI);
					$("#reqOverbudget"+param[0]).val(FormatCurrency(data.OVERBUDGET));
			    });				
				if($("#reqValidasi"+param[0]).val() == "1")
				{	
					return true;
				}
				else
				{
					return false;
				}
			},
			message:'Anggaran tidak over budget. entri melalui PPA'
		},
		checkNomorDokumen:{
			validator:function(value,param){
				var textNomor = $("#reqNomor").val();
				$.getJSON("../json-hukum/dokumen_validasi_nomor_json.php?reqId="+param[0]+"&reqNomor="+textNomor,
			    function(data){
					$("#reqValidasi").val(data.NILAI);
			    });
				
				if($("#reqValidasi").val() == "0")
				{	
					return true;
				}
				else
				{
					return false;
				}
			},
			message:'Nomor dokumen sudah ada.'
		} 		 		
	});
});