function addRow(no_nota)
{
	// HAPUS ISI ROW
	$("#dataTableRowDinamis > tbody").html("");
	
	$.getJSON("../json-keuangansiuk/get_pembatalan_pelunasan_nota_detil_json.php?reqId="+no_nota,
	function(result){			
			

		$.each(result, function(i, data) {
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
		element.readOnly = true;
		element.value = data.NO_REF3;
		cell.appendChild(element);
		row.appendChild(cell);	
			
		/* KOLOM 2 */
		cell = document.createElement("TD");
		var element = document.createElement("input");
		element.type = "text";
		element.name = "reqNoRef3[]";
		element.id = "reqNoRef3"+rownum;
		element.className='easyui-validatebox';	
		element.readOnly = true;
		element.value = data.NO_REF3;
		cell.appendChild(element);
		row.appendChild(cell);	
		
		/* KOLOM 2 */
		cell = document.createElement("TD");
		var element = document.createElement("input");
		element.type = "text";
		element.name = "reqTanggalTransaksiDetil[]";
		element.id = "reqTanggalTransaksiDetil"+rownum;
		element.className='easyui-validatebox';	
		element.readOnly = true;
		element.value = data.TGL_TRANS;
		cell.appendChild(element);
		row.appendChild(cell);	

		/* KOLOM 2 */
		cell = document.createElement("TD");
		var element = document.createElement("input");
		element.type = "text";
		element.name = "reqJatuhTempo[]";
		element.id = "reqJatuhTempo"+rownum;
		element.className='easyui-validatebox';	
		element.readOnly = true;
		element.value = data.TGL_JT_TEMPO;
		cell.appendChild(element);
		row.appendChild(cell);			
			
		/* KOLOM 3 */
		cell = document.createElement("TD");
		var element = document.createElement("input");
		element.type = "text";
		element.name = "reqJumlahUpper[]";
		element.id = "reqJumlahUpper"+rownum;
		element.style.textAlign = "right";
		element.readOnly = true;
		element.className='easyui-validatebox';		
		element.value = "";
		element.onfocus = function() {  
			FormatAngka("reqJumlahUpper"+rownum);
		};
		element.onkeyup = function() {  
			FormatUang("reqJumlahUpper"+rownum);
		};
		element.onblur = function() {  
			FormatUang("reqJumlahUpper"+rownum);
		};		
		cell.appendChild(element);
		row.appendChild(cell);
			
		/* KOLOM 3 */
		cell = document.createElement("TD");
		var element = document.createElement("input");
		element.type = "text";
		element.name = "reqJumlahPiutang[]";
		element.id = "reqJumlahPiutang"+rownum;
		element.style.textAlign = "right";
		element.readOnly = true;
		element.className='easyui-validatebox';		
		element.value = data.JML_TAGIHAN;
		element.onfocus = function() {  
			FormatAngka("reqJumlahPiutang"+rownum);
		};
		element.onkeyup = function() {  
			FormatUang("reqJumlahPiutang"+rownum);
		};
		element.onblur = function() {  
			FormatUang("reqJumlahPiutang"+rownum);
		};		
		cell.appendChild(element);
		row.appendChild(cell);
		
		/* KOLOM 4 */
		cell = document.createElement("TD");
		var element = document.createElement("input");
		element.type = "text";
		element.name = "reqJumlahDibayar[]";
		element.id = "reqJumlahDibayar"+rownum;
		element.style.textAlign = "right";
		element.readOnly = true;
		element.className='easyui-validatebox';		
		element.value = data.JML_VAL_TRANS;
		element.onfocus = function() {  
			FormatAngka("reqJumlahDibayar"+rownum);
		};
		element.onkeyup = function() {  
			FormatUang("reqJumlahDibayar"+rownum);
		};
		element.onblur = function() {  
			FormatUang("reqJumlahDibayar"+rownum);
		};		
		cell.appendChild(element);
		row.appendChild(cell);

		cell = document.createElement("TD");
		var button = document.createElement('label');
		button.innerHTML = '<input type="text" name="reqPrevNoNota[]" id="reqPrevNoNota'+rownum+'" value="'+data.PREV_NO_NOTA+'">';
		cell.appendChild(button);
		cell.style.display = 'none';
		row.appendChild(cell);		
			
		tabBody.appendChild(row);
		
		hitungJumlahTotal();


	   });


	});			
}   

function getDataJKM()
{
	$.getJSON("../json-keuangansiuk/get_pembatalan_pelunasan_nota_json.php?reqId="+$("#reqNoBuktiDikoreksi").val(),
	function(data){			
	
		if(data.NO_POSTING == "") 
			alert('No Bukti '+$("#reqNoBuktiDikoreksi").val()+' belum di-posting, bisa modifikasi / dihapus di form transaksi Pembayaran Nota.');
		else
		{
			$("#reqNoChqBukti").val(data.NO_CHEQUE);
			$("#reqKodeBank").val(data.KD_BANK);
			$("#reqKdBukuBesar").val(data.KD_BB_BANK);
			$("#reqNmBukuBesar").val(data.MBANK_NAMA);
			$("#reqNoPelanggan").val(data.KD_KUSTO);
			$("#reqPelanggan").val(data.MPLG_NAMA);
			$("#reqBadanUsaha").val(data.BADAN_USAHA);
			$("#reqKdBbKusto").val(data.KD_BB_KUSTO);
			$("#reqNilaiTransaksi").val(data.JML_VAL_TRANS);
			addRow($("#reqNoBuktiDikoreksi").val());
		}
	});						
}

function hitungJumlahTotal()
{
	if (!document.getElementsByTagName) return;
	tabBody=document.getElementsByTagName("TBODY").item(0);
	
	var rownum = tabBody.rows.length;
			
	var total = 0;		
	for(var i=0; i<=rownum; i++) {
		if(typeof $("#reqJumlahDibayar"+i).val() == "undefined")
		{}
		else
		{
			jumlah = FormatAngkaNumber($("#reqJumlahDibayar"+i).val());
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