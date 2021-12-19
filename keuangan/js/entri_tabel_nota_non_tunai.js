function addRow()
{
	if (!document.getElementsByTagName) return;
	tabBody=document.getElementsByTagName("TBODY").item(0);
	 
	var rownum = tabBody.rows.length;
	row=document.createElement("TR");
	
	/* KOLOM 1 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqNoUrut[]";
	element.id = "reqNoUrut"+rownum;
	element.className='easyui-validatebox';	
	element.readOnly = true;
	element.value = rownum + 1;
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 2 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqKlasTrans[]";
	element.setAttribute('id', "reqKlasTrans"+rownum);
	element.className='easyui-combobox';		
	element.tabIndex = tabindex+1;
	element.style.width = '300px';
	cell.appendChild(element);
	row.appendChild(cell);
			
	/* KOLOM 2
	cell = document.createElement("TD");
	var combo = document.createElement("select");
	combo.setAttribute("name", "reqKlasTrans[]"); 
	combo.setAttribute("id", "reqKlasTrans"+rownum); 
	
	$.getJSON("../json-keuangansiuk/jenis_jasa_lookup_json.php?reqTipeTrans=" + $("#reqSegmen").val(),
	function(data){
		for(i=0;i<data.KLAS_TRANS.length; i++)
		{
			var option_element1 = document.createElement('option');
			option_element1.setAttribute('value', data.KLAS_TRANS[i]);
			option_element1.appendChild( document.createTextNode( data.KETK_TRANS[i] ) );
			combo.appendChild(option_element1);
		} 
	});
	combo.onchange = function() {  
		ambilReferensiKlasTrans(rownum);						
	};
	cell.appendChild(combo);
	row.appendChild(cell);
	*/
	
	/* KOLOM 3
	cell = document.createElement("TD");		
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqPajak[]";
	element.id = "reqPajak"+rownum;
	element.readOnly = true;
	element.className='easyui-validatebox';		
	cell.appendChild(element);
	row.appendChild(cell);
    */
	
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqPajak[]";
	element.setAttribute('id', "reqPajak"+rownum);
	element.className='easyui-combobox';		
	element.tabIndex = tabindex+1;
	cell.appendChild(element);
	row.appendChild(cell);

	
	/* KOLOM 5 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqNilaiJasa[]";
	element.id = "reqNilaiJasa"+rownum;
	element.style.textAlign = "right";
	element.tabIndex = tabindex+2;
	element.className='easyui-validatebox';	
	element.value = 0;
	element.onfocus = function() {  
		FormatAngka("reqNilaiJasa"+rownum);
	};
	element.onkeyup = function() {  
		FormatUang("reqNilaiJasa"+rownum);	
		hitungSemua(rownum);			
	};
	element.onblur = function() {  
		FormatUang("reqNilaiJasa"+rownum);
	};				
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 3 */
	cell = document.createElement("TD");		
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqKeteranganTambah[]";
	element.id = "reqKeteranganTambah"+rownum;
	element.tabIndex = tabindex+3;
	element.style.width = "98%";
	element.className='easyui-validatebox';		
	cell.appendChild(element);
	row.appendChild(cell);	
	
	/* KOLOM 7 */
	cell = document.createElement("TD");
	var button = document.createElement('label');
	button.style.textAlign='center';
	button.innerHTML = '<center><input type="hidden" name="reqKdBukuBesar[]" id="reqKdBukuBesar'+rownum+'"><input type="hidden" name="reqNilaiPajak[]" id="reqNilaiPajak'+rownum+'"><input type="hidden" name="reqJumlah[]" id="reqJumlah'+rownum+'"><input type="hidden" name="reqDK[]" id="reqDK'+rownum+'"><a style="cursor:pointer;" onclick="deleteRowDrawTable(\'dataTableRowDinamis\', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a></center>';
	cell.appendChild(button);
	row.appendChild(cell);
		
	tabBody.appendChild(row);
	
	var rowCount = tabBody.rows.length;
	rowCount= rowCount-1;
	
	tempSegmen= $('#reqSegmen').combobox('getValue');
	
	$('input[id^="reqKeteranganTambah"]').keydown(function(e) {
		if(e.which==13)
		{
			addRow();
		}
	});
	
	$('#reqKlasTrans'+rowCount).combobox({  
		required: true,
		filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
		valueField: 'id', textField: 'text',
		url: '../json-keuangansiuk/segmen_jenis_jasa_combo_json.php?reqId='+tempSegmen,
		onSelect:function(rec){
			ambilReferensiKlasTransHtml();
		},
		validType: 'exists["#reqKlasTrans'+rowCount+'"]'
	});

	$('#reqPajak'+rowCount).combobox({  
		required: true,
		filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
		valueField: 'id', textField: 'text',
		url: '../json-keuangansiuk/pengenaan_pajak_combo_json.php',
		onSelect:function(rec){
			hitungSemua(rowCount);
		}
	});
		
	function ambilReferensiKlasTransHtml()
	{
		tempSegmen= $('#reqSegmen').combobox('getValue');
		tempKlasTran= $('#reqKlasTrans'+rowCount).combobox('getValue');
		
		$.getJSON("../json-keuangansiuk/get_jenis_jasa_kena_pajak_json.php?reqTipeTrans="+tempSegmen+"&reqKlasTrans="+tempKlasTran,
		function(data){
			$("#reqPajak"+rowCount).combobox('setValue', data.STATUS_KENA_PAJAK);
			$("#reqKdBukuBesar"+rowCount).val(data.KD_BUKU_BESAR);
			$("#reqDK"+rowCount).val(data.KD_DK);		
		});	
	}
}   

function hitungSemua(id)
{
	hitungPajakJasa(id);		
	hitungPajakTotal();		
	hitungNilaiJasaTotal();
	hitungMaterai();		
		
}

function hitungMaterai()
{
	if($("#reqPpnMaterai").val() == 'Y')
		var total = Number(FormatAngkaNumber($("#reqJumlahTrans").val())) + Number(FormatAngkaNumber($("#reqJumlahPajak").val()));
	else
		var total = Number(FormatAngkaNumber($("#reqJumlahTrans").val()));
		
	
	$.getJSON("../json-keuangansiuk/get_materai_json.php?reqJumlah="+total,
	function(data){		
		$("#reqMaterai").val(data.MATERAI);
		hitungJumlahTotal();	
	});				
}

function hitungJumlahTotal()
{
	if (!document.getElementsByTagName) return;
	tabBody=document.getElementsByTagName("TBODY").item(0);
	
	var rownum = tabBody.rows.length;
	if($("#reqPpnMaterai").val() == 'Y')
	{
		var total = Number(FormatAngkaNumber($("#reqJumlahTrans").val())) + Number(FormatAngkaNumber($("#reqJumlahPajak").val())) + Number($("#reqMaterai").val());		
	}
	else
	{
		$("#reqMaterai").val(0);		
		var total = Number(FormatAngkaNumber($("#reqJumlahTrans").val())) + Number(FormatAngkaNumber($("#reqJumlahPajak").val()));		
	}
	
	$("#reqJumlahTagihan").val(FormatCurrency(total));
}

function hitungPajakTotal()
{
	if (!document.getElementsByTagName) return;
	tabBody=document.getElementsByTagName("TBODY").item(0);
	
	var rownum = tabBody.rows.length;
			
	var total = 0;		
	for(var i=0; i<=rownum; i++) {
		if(typeof $("#reqNilaiPajak"+i).val() == "undefined")
		{}
		else
		{
			jumlah = FormatAngkaNumber($("#reqNilaiPajak"+i).val());
			total = total + Number(jumlah);	
		}
	}
	$("#reqJumlahPajak").val(FormatCurrency(total));
}

function hitungNilaiJasaTotal()
{
	if (!document.getElementsByTagName) return;
	tabBody=document.getElementsByTagName("TBODY").item(0);
	
	var rownum = tabBody.rows.length;
			
	var total = 0;		
	for(var i=0; i<=rownum; i++) {
		if(typeof $("#reqNilaiJasa"+i).val() == "undefined")
		{}
		else
		{
			jumlah = FormatAngkaNumber($("#reqNilaiJasa"+i).val());
			total = Number(total) + Number(jumlah);	
			//alert(total);
		}
	}
	$("#reqJumlahTrans").val(FormatCurrency(total));
}

function hitungPajakJasa(id)
{
	var nilai = FormatAngkaNumber($("#reqNilaiJasa"+id).val());
	if($("#reqPajak"+id).combobox('getValue') == 'Y')
	{
		// PERHITUNGAN PAJAK PER TRANSAKSI 
		var prosen_pajak = $("#reqPersenPajak").val();
		var pajak = nilai * (prosen_pajak / 100);
		if($("#reqValutaNama").val() == "IDR")
			pajak = Math.round(pajak);
			
		var total = Number(nilai) + pajak;
		$("#reqNilaiPajak"+id).val(FormatCurrency(pajak));
		$("#reqJumlah"+id).val(FormatCurrency(total));
	}
	else
	{
		$("#reqNilaiPajak"+id).val(0);	
		$("#reqJumlahPajak").val(0);
		$("#reqJumlah"+id).val(FormatCurrency(nilai));
	}
			
}

function deleteRowDrawTable(tableID, id) {
	if(confirm('Apakah anda ingin menghapus data terpilih?') == false)
		return "";
			
	try {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	var id=id.parentNode.parentNode.parentNode.parentNode.rowIndex;
	
	for(var i=0; i<=rowCount; i++) {
		if(id == i) {
			table.deleteRow(i);
			hitungSemua(0);
		}
	}
	}catch(e) {
		alert(e);
	}
}

function deleteRowDrawTablePhp(tableID, id) {
	if(confirm('Apakah anda ingin menghapus data terpilih?') == false)
		return "";
			
	try {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	var id=id.parentNode.parentNode.parentNode.rowIndex;
	
	for(var i=0; i<=rowCount; i++) {
		if(id == i) {
			table.deleteRow(i);
			hitungSemua(0);
		}
	}
	}catch(e) {
		alert(e);
	}
}			

function ambilReferensiKlasTrans(id)
{
	tempSegmen= $('#reqSegmen').combobox('getValue');
	tempKlasTran= $('#reqKlasTrans'+id).combobox('getValue');
	
	$.getJSON("../json-keuangansiuk/get_jenis_jasa_kena_pajak_json.php?reqTipeTrans="+tempSegmen+"&reqKlasTrans="+tempKlasTran,
	function(data){
		$("#reqPajak"+id).combobox('setValue', data.STATUS_KENA_PAJAK);
		$("#reqKdBukuBesar"+id).val(data.KD_BUKU_BESAR);
		$("#reqDK"+id).val(data.KD_DK);		
	});	
}

function setSegmenJenisJasaPhp(val)
{
	var url= '../json-keuangansiuk/segmen_jenis_jasa_combo_json.php?reqId='+val;
	$('input[id^="reqKlasTrans"]').combobox('setValue', '');
	$('input[id^="reqKlasTrans"]').combobox('reload', url);
}

$(function(){
	
	var textFakturPajak = "";
	var cc = $('#reqFakturPajak');  // the combobox object
	cc.combobox('textbox').bind('keyup', function(e){
		
		if(e.which == 13)
		{
			if(textFakturPajak == "")
				textFakturPajak = cc.combobox('getText');
			
			cc.combobox('setValue', textFakturPajak);						
		}
		else
		{
			textFakturPajak = cc.combobox('getText');
		}
	});
});	  