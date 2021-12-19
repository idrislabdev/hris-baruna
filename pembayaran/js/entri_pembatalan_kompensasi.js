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
	element.name = "reqNoNota[]";
	element.id = "reqNoNota"+rownum;
	element.className='easyui-validatebox';		
	element.onkeypress = function(event) {  
		getDataPPKB(event, rownum);
	};	
	cell.appendChild(element);	
	row.appendChild(cell);
	
	/* KOLOM 3 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqNoPelangganDetil[]";
	element.readOnly = true;
	element.id = "reqNoPelangganDetil"+rownum;
	element.className='easyui-validatebox';		
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 4 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqTanggalNota[]";
	element.readOnly = true;
	element.id = "reqTanggalNota"+rownum;
	element.className='easyui-validatebox';		
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 5 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqJumlahBayar[]";
	element.id = "reqJumlahBayar"+rownum;
	element.style.textAlign = "right";
	element.readOnly = true;
	element.className='easyui-validatebox';		
	element.value = 0;
	element.onfocus = function() {  
		FormatAngka("reqJumlahBayar"+rownum);
	};
	element.onkeyup = function() {  
		FormatUang("reqJumlahBayar"+rownum);
	};
	element.onblur = function() {  
		FormatUang("reqJumlahBayar"+rownum);
	};		
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 6 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqJumlahDikembalikan[]";
	element.id = "reqJumlahDikembalikan"+rownum;
	element.style.textAlign = "right";
	element.className='easyui-validatebox';	
	element.value = 0;
	element.onfocus = function() {  
		FormatAngka("reqJumlahDikembalikan"+rownum);
	};
	element.onkeyup = function() {  
		FormatUang("reqJumlahDikembalikan"+rownum);
		hitungJumlahTotal();
	};
	element.onblur = function() {  
		FormatUang("reqJumlahDikembalikan"+rownum);
	};		
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 7 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqSisa[]";
	element.id = "reqSisa"+rownum;
	element.style.textAlign = "right";
	element.readOnly = true;	
	element.className='easyui-validatebox';		
	element.value = 0;
	element.onfocus = function() {  
		FormatAngka("reqSisa"+rownum);
	};
	element.onkeyup = function() {  
		FormatUang("reqSisa"+rownum);
	};
	element.onblur = function() {  
		FormatUang("reqSisa"+rownum);
	};		
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 8 */
	cell = document.createElement("TD");
	var button = document.createElement('label');
	button.style.textAlign='center';
	button.innerHTML = '<input type="hidden" name="reqPrevNoNota[]" id="reqPrevNoNota'+rownum+'"><center><a style="cursor:pointer;" onclick="deleteRowDrawTable(\'dataTableRowDinamis\', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a></center>';
	cell.appendChild(button);
	row.appendChild(cell);
	
	tabBody.appendChild(row);
}   

function getDataPPKB(event, id)
{
	if(event.keyCode == 13){
		event.cancelBubble = true;
		event.returnValue = false;
	
		if (event.stopPropagation) {   
		  event.stopPropagation();
		  event.preventDefault();
		}
		$.getJSON("../json-keuangansiuk/get_pembatalan_kompensasi_json.php?reqId="+$("#reqNoNota"+id).val()+"&reqKdKusto="+$("#reqNoPelanggan").val()+"&reqKdValuta="+$("#reqValutaNama").val(),
		function(data){			
			$("#reqNoNota"+id).val(data.NO_PPKB);
			$("#reqNoPelanggan"+id).val(data.PELANGGAN);
			$("#reqTanggalNota"+id).val(data.TGL_NOTA);
			$("#reqJumlahBayar"+id).val(data.TOT_TAGIHAN);	
			$("#reqJumlahDikembalikan"+id).val(data.BAYAR);
			$("#reqPrevNoNota"+id).val(data.NO_NOTA);
			hitungJumlahTotal();		
		});				
		
		return false;
	}

}

function hitungJumlahTotal()
{
	if (!document.getElementsByTagName) return;
	tabBody=document.getElementsByTagName("TBODY").item(0);
	
	var rownum = tabBody.rows.length;
			
	var total = 0;		
	for(var i=0; i<=rownum; i++) {
		if(typeof $("#reqJumlahBayar"+i).val() == "undefined")
		{}
		else
		{
			sisa = Number(FormatAngkaNumber($("#reqJumlahBayar"+i).val())) - Number(FormatAngkaNumber($("#reqJumlahDikembalikan"+i).val()));
			$("#reqSisa"+i).val(FormatCurrency(sisa));
			
			jumlah = FormatAngkaNumber($("#reqJumlahDikembalikan"+i).val());
			total = Number(total) + Number(jumlah);	
			//alert(total);
		}
	};
	$("#reqJumlahTransaksi").val(FormatCurrency(total));
	$("#reqJumlahTrans").val(FormatCurrency(total));
	
	
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