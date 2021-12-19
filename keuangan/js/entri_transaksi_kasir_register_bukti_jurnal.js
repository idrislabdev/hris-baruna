function addRow(no_nota)
{
	// HAPUS ISI ROW
	$("#dataTableRowDinamis > tbody").html("");
	
	$.getJSON("../json-keuangansiuk/get_transaksi_kasir_register_bukti_jurnal_detil_json.php?reqId="+no_nota,
	function(data){			
		$.each(data, function(index, field){           

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
			element.value = field['NO_SEQ'];
			cell.appendChild(element);
			row.appendChild(cell);
		
			/* KOLOM 2 */
			cell = document.createElement("TD");
			var element = document.createElement("input");
			element.type = "text";
			element.name = "reqBukuBesar[]";
			element.id = "reqBukuBesar"+rownum;
			element.className='easyui-validatebox';	
			element.value = field['KD_BUKU_BESAR'];	
			cell.appendChild(element);
			row.appendChild(cell);
			
			/* KOLOM 3 */
			cell = document.createElement("TD");
			var element = document.createElement("input");
			element.type = "text";
			element.name = "reqKartu[]";
			element.id = "reqKartu"+rownum;
			element.className='easyui-validatebox';	
			element.value = field['KD_SUB_BANTU'];		
			cell.appendChild(element);
			row.appendChild(cell);
			
			/* KOLOM 4 */
			cell = document.createElement("TD");
			var element = document.createElement("input");
			element.type = "text";
			element.name = "reqBukuPusat[]";
			element.id = "reqBukuPusat"+rownum;	
			element.value = field['KD_BUKU_PUSAT'];		
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
			element.value = field['SALDO_VAL_DEBET'];
			element.onfocus = function() {  
				FormatAngka("reqDebet"+rownum);
			};
			element.onkeyup = function() {  
				FormatUang("reqDebet"+rownum);
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
			element.value = field['SALDO_VAL_KREDIT'];
			element.onfocus = function() {  
				FormatAngka("reqKredit"+rownum);
			};
			element.onkeyup = function() {  
				FormatUang("reqKredit"+rownum);
			};
			element.onblur = function() {  
				FormatUang("reqKredit"+rownum);
			};		
			cell.appendChild(element);
			row.appendChild(cell);
			
			tabBody.appendChild(row);
		
		});	
		
		hitungDebetTotal();
		hitungKreditTotal();
		
	});			
	
	
}   

function getData(event)
{
	if(event.keyCode == 13){
		
		event.cancelBubble = true;
		event.returnValue = false;
	
		if (event.stopPropagation) {   
		  event.stopPropagation();
		  event.preventDefault();
		}
		$.getJSON("../json-keuangansiuk/get_transaksi_kasir_register_bukti_jurnal_json.php?reqId="+$("#reqNoDokumen").val()+"&reqKodeJurnal="+$("#reqKodeJurnal").val(),                                                            
		function(data){			
				  
			$("#reqValutaNama").val(data.KD_VALUTA);
			$("#reqNoNota").val(data.NO_NOTA);
			$("#reqKursValuta").val(data.KURS_VALUTA);	
			$("#reqTanggalTransaksi").val(data.TGL_TRANS);	
			$("#reqKeterangan").val(data.KET_TAMBAH);	
			$("#reqPerusahaan").val(data.NM_AGEN_PERUSH);	
			$("#reqAlamat").val(data.ALMT_AGEN_PERUSH);	
			$("#reqKdSubsis").val(data.KD_SUBSIS);	
			
			addRow(data.NO_NOTA);	
			
			if(data.NO_POSTING == "")
			{
				document.getElementById("btnSubmit").style.display='';					
			}
			else
			{
				alert('Data sudah diposting.');	
				document.getElementById("btnSubmit").style.display='none';
			}
				
		});				
		
		return false;
	}

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
}