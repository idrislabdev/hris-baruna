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
	element.style.width = "50px";
	cell.appendChild(element);
	row.appendChild(cell);

	/* KOLOM 2 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqInventaris[]";
	element.setAttribute('id', "reqInventaris"+rownum);
	element.className='easyui-combobox';		
	element.style.width = "450px";
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 7 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqUnit[]";
	element.id = "reqUnit"+rownum;
	element.className='easyui-validatebox';
	element.setAttribute('style', 'text-align: right;');
	element.style.width = "100px";
	cell.appendChild(element);
	row.appendChild(cell);

	/* KOLOM 9 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqHarga[]";
	element.id = "reqHarga"+rownum;
	element.className='easyui-validatebox';
	element.setAttribute('style', 'text-align: right;');
	element.style.width = "150px";
	element.onfocus = function() {  
		FormatAngka("reqHarga"+rownum);
	};
	element.onkeyup = function() {  
		FormatUang("reqHarga"+rownum);
	};
	element.onblur = function() {  
		FormatUang("reqHarga"+rownum);
	};
	cell.appendChild(element);
	row.appendChild(cell);
	
	
	/* KOLOM 10 */
	cell = document.createElement("TD");
	var button = document.createElement('label');
	button.style.textAlign='center';
	button.innerHTML = '<center><a style="cursor:pointer;" onclick="deleteRowDrawTable(\'dataTableRowDinamis\', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a><input type="hidden" name="reqLokasi[]" value="0"></center>';
	cell.appendChild(button);
	row.appendChild(cell);
	
	tabBody.appendChild(row);
	
	var rowCount = tabBody.rows.length;
	rowCount= rowCount-1;
	//reqNoUrut reqInventaris reqKartu reqBukuPusat reqNama reqKeterangan reqUnit reqHarga reqJumlah
	
	$('#reqInventaris'+rowCount).combobox({  
		filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
		valueField: 'id', 
		textField: 'text',
		url:'../json-inventaris/inventaris_combo_json.php?reqTahun='+$("#reqTahun").val()+''
	});

	
	$('input[id^="reqUnit"]').keypress(function(e) {
		if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
		{
		return false;
		}
	});
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
		}
	}
	}catch(e) {
		alert(e);
	}
}