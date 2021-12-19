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
	
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqPajak[]";
	element.setAttribute('id', "reqPajak"+rownum);
	element.className='easyui-combobox';		
	element.tabIndex = tabindex+1;
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
		$('#reqPajak'+rowCount).combobox({  
		required: true,
		filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
		valueField: 'id', textField: 'text',
		url: '../json-keuangansiuk/pengenaan_pajak_combo_json.php',
		onSelect:function(rec){
			hitungSemua(rowCount);
		}
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
	try {
		tabBody=document.getElementsByTagName("TBODY").item(0);
		var rowCount = tabBody.rows.length;
		console.log('total baris ' + rowCount);
		var total = 0;
		for(var i=0; i<rowCount; i++) {		
			var nilai = Number(FormatAngkaNumber($("#reqJumlah"+i).val()));
			total += nilai;	
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
	var id=id.parentNode.parentNode.rowIndex;
	
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
