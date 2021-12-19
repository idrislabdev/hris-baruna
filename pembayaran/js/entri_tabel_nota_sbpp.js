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
	element.style.width = "60px";
	element.readOnly = true;
	element.value = rownum + 1;
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 3 */
	cell = document.createElement("TD");		
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqKetTambah[]";
	element.tabIndex = tabindex+1;
	element.id = "reqKetTambah"+rownum;
	element.style.width = "99%";
	element.className='easyui-validatebox';		
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 4 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqTandaTrans[]";
	element.tabIndex = tabindex+2;
	element.id = "reqTandaTrans"+rownum;	
	element.style.width = "80px";
	element.className='easyui-combobox';		
	cell.appendChild(element);
	row.appendChild(cell);


	/* KOLOM 7 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqJumlah[]";
	element.tabIndex = tabindex+3;
	element.id = "reqJumlah"+rownum;
	element.style.width = "98%";
	element.style.textAlign = "right";
	element.className='easyui-validatebox';		
	element.value = 0;
	element.onfocus = function() {  
		FormatAngka("reqJumlah"+rownum);
	};
	element.onkeyup = function() {  
		FormatUang("reqJumlah"+rownum);
		hitungSemua(rownum);			
	};
	element.onblur = function() {  
		FormatUang("reqJumlah"+rownum);
	};		
	cell.appendChild(element);
	row.appendChild(cell);		
	
	/* KOLOM 7 */
	cell = document.createElement("TD");
	var button = document.createElement('label');
	button.style.textAlign='center';
	button.innerHTML = '<center><a style="cursor:pointer;" onclick="deleteRowDrawTable(\'dataTableRowDinamis\', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a></center>';
	cell.appendChild(button);
	row.appendChild(cell);
		
	tabBody.appendChild(row);
	
	var rowCount = tabBody.rows.length;
	rowCount= rowCount-1;
	
	$('#reqTandaTrans'+rowCount).combobox({ 
		required: true, 
		valueField: 'label', textField: 'value',
		data: [{
			label: '+',
			value: '+'
		},{
			label: '-',
			value: '-'
		}]
	});
	
	
	$('input[id^="reqJumlah"]').keydown(function(e) {
		if(e.which==13)
		{
			addRow();
		}
	});
}   

function hitungSemua(id)
{
	hitungNilaiJasaTotal();
	hitungMaterai();			
}

function hitungNilaiJasaTotal()
{
	try {
		tabBody=document.getElementsByTagName("TBODY").item(0);
		var rowCount = tabBody.rows.length;
		var total = 0;
		for(var i=0; i<rowCount; i++) {		
			var nilai = Number(FormatAngkaNumber($("#reqJumlah"+i).val()));
			
			var tanda = $("#reqTandaTrans"+i).combobox("getValue");
			if(tanda == "+")
				total += nilai;
			else
				total -= nilai;			
		}
	}catch(e) {
		alert(e);
	}	
	$("#reqJumlahTrans").val(FormatCurrency(total));
}

function hitungMaterai()
{
	var total = Number(FormatAngkaNumber($("#reqJumlahTrans").val()));
	
	$.getJSON("../json-keuangansiuk/get_materai_json.php?reqJumlah="+total,
	function(data){
		
		$("#reqMaterai").val(data.MATERAI);
		hitungJumlahTotal();	
	});				
}

function hitungJumlahTotal()
{
			
	var total = Number(FormatAngkaNumber($("#reqJumlahTrans").val())) + Number($("#reqMaterai").val());		
	
	$("#reqJumlahTagihan").val(FormatCurrency(total));
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