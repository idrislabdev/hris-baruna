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
	element.style.width = "88px";
	cell.appendChild(element);
	row.appendChild(cell);

	/* KOLOM 2 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqBukuBesar[]";
	element.id = "reqBukuBesar"+rownum;
	element.className='easyui-combobox';
	element.style.width = "208px";
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 3 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqKartu[]";
	element.id = "reqKartu"+rownum;
	element.className='easyui-combobox';
	element.style.width = "208px";
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 4 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqBukuPusat[]";
	element.id = "reqBukuPusat"+rownum;
	element.className='easyui-combobox';
	element.style.width = "208px";
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 5 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqKeterangan[]";
	element.id = "reqKeterangan"+rownum;
	element.style.width = "98%";
	element.className='easyui-validatebox';		
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 6 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqDebet[]";
	element.id = "reqDebet"+rownum;
	element.style.textAlign = "right";
	element.className='easyui-validatebox';		
	element.value = 0;
	element.onfocus = function() {  
		FormatAngka("reqDebet"+rownum);
	};
	element.onkeyup = function() {  
		FormatUang("reqDebet"+rownum);
		hitungDebetTotal();
	};
	element.onblur = function() {  
		FormatUang("reqDebet"+rownum);
	};		
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 7 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqKredit[]";
	element.id = "reqKredit"+rownum;
	element.style.textAlign = "right";
	element.className='easyui-validatebox';		
	element.value = 0;
	element.onfocus = function() {  
		FormatAngka("reqKredit"+rownum);
	};
	element.onkeyup = function() {  
		FormatUang("reqKredit"+rownum);
		hitungKreditTotal();
	};
	element.onblur = function() {  
		FormatUang("reqKredit"+rownum);
	};		
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 8 */
	cell = document.createElement("TD");
	var button = document.createElement('label');
	button.style.textAlign='center';
	button.innerHTML = '<center><a style="cursor:pointer;" onclick="deleteRowDrawTable(\'dataTableRowDinamis\', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a></center>';
	cell.appendChild(button);
	row.appendChild(cell);
	
	tabBody.appendChild(row);
	
	var rowCount = tabBody.rows.length;
	rowCount= rowCount-1;
	
	$('#reqBukuBesar'+rowCount).combobox({  
		required: true,
		filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
		valueField: 'id', textField: 'text',
		url: '../json-keuangansiuk/buku_besar_combo_json.php',
		onSelect:function(rec){
		},
		validType:['exists[\'#reqBukuBesar'+rowCount+'\']','checkOption[\'reqBukuBesar\', \''+rowCount+'\']']
	});
	
	$('#reqKartu'+rowCount).combobox({  
		required: true,
		filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
		valueField: 'id', textField: 'text',
		url: '../json-keuangansiuk/kartu_tambah_combo_json.php',
		onSelect:function(rec){
		},
		validType:['exists[\'#reqKartu'+rowCount+'\']']
		//validType:['exists[\'#reqKartu'+rowCount+'\']','checkOption[\'reqKartu\', \''+rowCount+'\']']
	});
	
	$('#reqBukuPusat'+rowCount).combobox({  
		required: true,
		filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
		valueField: 'id', textField: 'text',
		url: '../json-keuangansiuk/buku_pusat_combo_json.php',
		onSelect:function(rec){
		},
		validType:['exists[\'#reqBukuPusat'+rowCount+'\']']
		//validType:['exists[\'#reqBukuPusat'+rowCount+'\']','checkOption[\'reqBukuPusat\', \''+rowCount+'\']']
	});
	
	$('input, textarea, select').keydown( function(e) {
		var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
		if(key == 13) {
			e.preventDefault();
			var inputs = $(this).closest('form').find(':input:visible');
			//var inputs = $(this).closest('form').find(':input:visible').not([readonly="readonly"]);
			inputs.eq( inputs.index(this)+ 1 ).focus();
		}
	});
	
	$('input[id^="reqKredit"]').keydown(function(e) {
		if(e.which==13)
		{
			addRow();
			var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
			if(key == 13) {
				e.preventDefault();
				var inputs = $(this).closest('form').find(':input:visible');
				inputs.eq( inputs.index(this)+ 1 ).focus();
			}
		}
	});
}   

function hitungDebetTotal()
{
	if (!document.getElementsByTagName) return;
	tabBody=document.getElementsByTagName("TBODY").item(0);
	
	var rownum = tabBody.rows.length;
			
	var total = 0;		
	for(var i=0; i<=rownum; i++) {
		if(typeof $("#reqDebet"+i).val() == "undefined")
		{}
		else
		{
			jumlah = FormatAngkaNumber($("#reqDebet"+i).val());
			total = total + Number(jumlah);	
		}
	}
	$("#reqJumlahDebet").val(FormatCurrency(total));
	setCheckBalance();
}

function hitungKreditTotal()
{
	if (!document.getElementsByTagName) return;
	tabBody=document.getElementsByTagName("TBODY").item(0);
	
	var rownum = tabBody.rows.length;
			
	var total = 0;		
	for(var i=0; i<=rownum; i++) {
		if(typeof $("#reqKredit"+i).val() == "undefined")
		{}
		else
		{
			jumlah = FormatAngkaNumber($("#reqKredit"+i).val());
			total = total + Number(jumlah);	
		}
	}
	$("#reqJumlahKredit").val(FormatCurrency(total));				
	setCheckBalance();
}

function setCheckBalance()
{
	setChecked(false);
	if($("#reqJumlahDebet").val() == $("#reqJumlahKredit").val())
	{
		$('#reqBalance').attr('checked', true);
	}
	else
	{
		$('#reqUnbalance').attr('checked', true);
	}
}

function setChecked(status)
{
	$('#reqBalance').attr('checked', status);
	$('#reqUnbalance').attr('checked', status);
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