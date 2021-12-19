function addRow(pNoPPKB, pPelanggan, pTanggalNota, pSisaPiutang, pJumlahBayar, pSisaBayar, pBukuBesar, pPrevNoNota)
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
	element.name = "reqNoPpkb[]";
	element.id = "reqNoPpkb"+rownum;
	element.className='easyui-validatebox';	
	element.readOnly = true;	
	/*element.onkeypress = function(event) {  
		getDataPPKB(event, rownum);
	};*/	
	element.value = pNoPPKB;
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 3 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqPelanggan[]";
	element.id = "reqPelanggan"+rownum;
	element.className='easyui-validatebox';	
	element.value = pPelanggan;	
	element.readOnly = true;
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 4 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqTanggalNota[]";
	element.id = "reqTanggalNota"+rownum;
	element.className='easyui-validatebox';	
	element.readOnly = true;
	element.value = pTanggalNota;	
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 5 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqSisaPiutang[]";
	element.id = "reqSisaPiutang"+rownum;
	element.className='easyui-validatebox';	
	element.style.textAlign = "right";	
	element.value = pSisaBayar;//pSisaPiutang;
	element.readOnly = true;
	element.onfocus = function() {  
		FormatAngka("reqSisaPiutang"+rownum);
	};
	
	element.onblur = function() {  
		FormatUang("reqSisaPiutang"+rownum);
	};		
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 6 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqJumlahBayar[]";
	element.id = "reqJumlahBayar"+rownum;
	element.style.textAlign = "right";
	element.className='easyui-validatebox';	
	element.value = 0;//pJumlahBayar;
	element.tabIndex = 6;
	//element.readOnly = true;
	element.onfocus = function() {  
		FormatAngka("reqJumlahBayar"+rownum);
	};
	element.onkeyup = function() {  
		FormatUang("reqJumlahBayar"+rownum);
		hitungJumlahTotal();
		hitungSisaBayar(rownum);
	};
	element.onblur = function() {  
		FormatUang("reqJumlahBayar"+rownum);
	};		
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 7 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqSisaBayar[]";
	element.id = "reqSisaBayar"+rownum;
	element.style.textAlign = "right";
	element.className='easyui-validatebox';	
	element.value = pSisaBayar;
	element.readOnly = true;
	element.onfocus = function() {  
		FormatAngka("reqSisaBayar"+rownum);
	};
	element.onkeyup = function() {  
		FormatUang("reqSisaBayar"+rownum);
	};
	element.onblur = function() {  
		FormatUang("reqSisaBayar"+rownum);
	};		
	cell.appendChild(element);
	row.appendChild(cell);

	/* KOLOM 7 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqUangTitipan[]";
	element.id = "reqUangTitipan"+rownum;
	element.style.textAlign = "right";
	element.readOnly = true;
	element.className='easyui-validatebox';	
	element.onfocus = function() {  
		FormatAngka("reqUangTitipan"+rownum);
	};
	element.onkeyup = function() {  
		FormatUang("reqUangTitipan"+rownum);
	};
	element.onblur = function() {  
		FormatUang("reqUangTitipan"+rownum);
	};		
	cell.appendChild(element);
	row.appendChild(cell);	
	
	/* KOLOM 8 */
	cell = document.createElement("TD");
	var button = document.createElement('label');
	button.style.textAlign='center';
	button.innerHTML = '<center><input type="hidden" name="reqBukuBesar[]" id="reqBukuBesar'+rownum+'" value="'+pBukuBesar+'"><input type="hidden" name="reqPrevNoNota[]" id="reqPrevNoNota'+rownum+'" value="'+pPrevNoNota+'"><a style="cursor:pointer;" onclick="deleteRowDrawTable(\'dataTableRowDinamis\', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a></center>';
	cell.appendChild(button);
	row.appendChild(cell);
	
	tabBody.appendChild(row);
	
	hitungJumlahTotal();		
}   

function getDataPPKB()
{

	$('#dataTableRowDinamis tbody > tr').remove();
	
	$.getJSON("../json-keuangansiuk/get_penjualan_non_tunai_json.php?reqId="+$("#reqNoPelanggan").val()+"&reqKdValuta="+$("#reqValutaNama").val(),
	function(data){		
		if(data.length == 0)
			alert('Data tidak ditemukan.');
		else		
		{
			for(i=0;i<data.length;i++)
			{
				addRow(data[i].NO_PPKB, data[i].PELANGGAN, data[i].TGL_NOTA, data[i].TOT_TAGIHAN, data[i].BAYAR, data[i].SISA_TAGIHAN, data[i].KD_BB_KUSTO, data[i].NO_NOTA);
			}
		}
	});				
	
}

function getDataBank(event)
{
	alert(event);
	if(event.keyCode == 13){
		event.cancelBubble = true;
		event.returnValue = false;
	
		if (event.stopPropagation) {   
		  event.stopPropagation();
		  event.preventDefault();
		}
		$.getJSON("../json-keuangansiuk/get_bank_json.php?reqNoBukuBesarKasId="+$("#reqNoBukuBesarKas").val(),
		function(data){			
			$("#reqBank"+id).val(data.MBANK_NAMA);
			$("#reqKodeKasBank"+id).val(data.MBANK_KODE_BB);
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
			jumlah = FormatAngkaNumber($("#reqJumlahBayar"+i).val());
			total = Number(total) + Number(jumlah);	
			//alert(total);
		}
	};
	$("#reqTotalBayar").val(FormatCurrency(total));
	$("#reqJumlahTransaksi").val(FormatCurrency(total));
	
	
}

function hitungSisaBayar(i)
{
	var jumlah = FormatAngkaNumber($("#reqSisaPiutang"+i).val()) - FormatAngkaNumber($("#reqJumlahBayar"+i).val());
	$("#reqSisaBayar"+i).val(FormatCurrency(jumlah));

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
			hitungJumlahTotal();
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
			hitungJumlahTotal();
		}
	}
	}catch(e) {
		alert(e);
	}
}