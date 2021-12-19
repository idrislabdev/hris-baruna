function addRow(no_nota)
{
	// HAPUS ISI ROW
	$("#dataTableRowDinamis > tbody").html("");
	
	$.getJSON("../json-keuangansiuk/get_pembatalan_sudah_cetak_nota_detil_json.php?reqId="+no_nota,
	function(data){			
			
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
		element.id = "reqKlasTrans"+rownum;
		element.className='easyui-validatebox';	
		element.readOnly = true;
		element.value = data.KLAS_TRANS;
		cell.appendChild(element);
		row.appendChild(cell);		
	
		/* KOLOM 3 */
		cell = document.createElement("TD");
		var element = document.createElement("input");
		element.type = "text";
		element.name = "reqNilaiPajak[]";
		element.id = "reqNilaiPajak"+rownum;
		element.style.textAlign = "right";
		element.className='easyui-validatebox';		
		element.readOnly = true;	
		element.value = data.JML_VAL_PAJAK;
		element.onfocus = function() {  
			FormatAngka("reqNilaiPajak"+rownum);
		};
		element.onkeyup = function() {  
			FormatUang("reqNilaiPajak"+rownum);
		};
		element.onblur = function() {  
			FormatUang("reqNilaiPajak"+rownum);
		};		
		cell.appendChild(element);
		row.appendChild(cell);
		
		/* KOLOM 4 */
		cell = document.createElement("TD");
		var element = document.createElement("input");
		element.type = "text";
		element.name = "reqJumlah[]";
		element.id = "reqJumlah"+rownum;
		element.style.textAlign = "right";
		element.className='easyui-validatebox';		
		element.readOnly = true;	
		element.value = data.JML_VAL_TRANS;
		element.onfocus = function() {  
			FormatAngka("reqJumlah"+rownum);
		};
		element.onkeyup = function() {  
			FormatUang("reqJumlah"+rownum);
		};
		element.onblur = function() {  
			FormatUang("reqJumlah"+rownum);
		};		
		cell.appendChild(element);
		row.appendChild(cell);
			
		tabBody.appendChild(row);
		
		hitungJumlahPajak();
		hitungJumlahTotal();
	});			
}   

function getDataJPJ()
{

	$.getJSON("../json-keuangansiuk/get_pembatalan_sudah_cetak_nota_json.php?reqId="+$("#reqNoRef3").val()+"&reqKodeKusto="+$("#reqNoPelanggan").val()+"&reqKdValuta="+$("#reqValutaNama").val()+"&reqTglTrans="+$("#reqTanggalTransaksi").val(),                                                            
	function(data){			
		if(data.NO_NOTA == '')
			alert('Data tidak ditemukan.');
		else if(data.TGL_POSTING == '')
			alert('Nota belum di posting, lakukan pembatalan nota belum posting.');
		else if(data.JML_VAL_BAYAR > 0)
			alert('Nota sudah di lunasi, dengan bukti jurnal no : '+ data.PREV_NOTA_UPDATE +', lakukan koreksi JKM.')	
		else if(data.STATUS_PROSES == 2)
			alert('Nota sudah di batalkan, dengan bukti jurnal no :'+ data.PREV_NOTA_UPDATE +'.')		
		else
		{
			$("#reqNotaUpdate").val(data.NO_NOTA);
			$("#reqMaterai").val(data.METERAI);
			$("#reqJumlahTagihan").val(data.JML_TAGIHAN);	
			$("#reqKursValuta").val(data.KURS);	
							
			addRow(data.NO_NOTA);					
		}
		
	});				
	
}
			
function hitungJumlahPajak()
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
			total = Number(total) + Number(jumlah);	
			//alert(total);
		}
	};
	$("#reqJumlahPajak").val(FormatCurrency(total));
}

function hitungJumlahTotal()
{
	if (!document.getElementsByTagName) return;
	tabBody=document.getElementsByTagName("TBODY").item(0);
	
	var rownum = tabBody.rows.length;
			
	var total = 0;		
	for(var i=0; i<=rownum; i++) {
		if(typeof $("#reqJumlah"+i).val() == "undefined")
		{}
		else
		{
			jumlah = FormatAngkaNumber($("#reqJumlah"+i).val());
			total = Number(total) + Number(jumlah);	
			//alert(total);
		}
	};
	$("#reqJumlahTrans").val(FormatCurrency(total));
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