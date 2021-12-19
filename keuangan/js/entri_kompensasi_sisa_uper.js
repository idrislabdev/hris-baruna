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
	element.name = "reqNoNota[]";
	element.id = "reqNoNota"+rownum;
	element.className='easyui-validatebox';	
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 2 */
	cell = document.createElement("TD");
	var combo = document.createElement("select");
	combo.setAttribute("name", "reqSumberBayar[]"); 
	combo.setAttribute("id", "reqSumberBayar"+rownum); 
	
	$.getJSON("../json-keuangansiuk/jenis_jasa_lookup_json.php?reqTipeTrans=JRR-KPT-04",
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
		
	/* KOLOM 3 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqKartu[]";
	element.id = "reqKartu"+rownum;
	element.className='easyui-validatebox';
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 4 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqNoUrut[]";
	element.id = "reqNoUrut"+rownum;
	element.className='easyui-validatebox';	
	element.value = rownum + 1;
	element.readOnly = true;
	cell.appendChild(element);
	row.appendChild(cell);
		
	/* KOLOM 5 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqNoRef[]";
	element.id = "reqNoRef"+rownum;
	element.className='easyui-validatebox';		
	element.readOnly = true;
	cell.appendChild(element);
	row.appendChild(cell);

	/* KOLOM 3 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqTanggalNota[]";
	element.id = "reqTanggalNota"+rownum;
	element.className='easyui-validatebox';	
	element.readOnly = true;
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 6 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqJumlah[]";
	element.id = "reqJumlah"+rownum;
	element.style.textAlign = "right";
	element.className='easyui-validatebox';	
	element.readOnly = true;
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
	
	/* KOLOM 7 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqSisaTagihan[]";
	element.id = "reqSisaTagihan"+rownum;
	element.style.textAlign = "right";
	element.className='easyui-validatebox';
	element.readOnly = true;
	element.onfocus = function() {  
		FormatAngka("reqSisaTagihan"+rownum);
	};
	element.onkeyup = function() {  
		FormatUang("reqSisaTagihan"+rownum);
	};
	element.onblur = function() {  
		FormatUang("reqSisaTagihan"+rownum);
	};		
	cell.appendChild(element);
	row.appendChild(cell);

	/* KOLOM 7 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqJumlahDibayar[]";
	element.id = "reqJumlahDibayar"+rownum;
	element.tabIndex = 6;
	element.style.textAlign = "right";
	element.className='easyui-validatebox';	
	element.onfocus = function() {  
		FormatAngka("reqJumlahDibayar"+rownum);
	};
	element.onkeyup = function() {  
		FormatUang("reqJumlahDibayar"+rownum);
		hitungJumlahTotal();
	};
	element.onblur = function() {  
		FormatUang("reqJumlahDibayar"+rownum);
	};		
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 8 */
	cell = document.createElement("TD");
	var button = document.createElement('label');
	button.style.textAlign='center';
	button.innerHTML = '<center><input type="hidden" name="reqBukuBesar[]" id="reqBukuBesar'+rownum+'" value=""><input type="hidden" name="reqBukuPusat[]" id="reqBukuPusat'+rownum+'"><input type="hidden" name="reqPrevNoNota[]" id="reqPrevNoNota'+rownum+'" value=""><a style="cursor:pointer;" onclick="deleteRowDrawTable(\'dataTableRowDinamis\', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a></center>';
	cell.appendChild(button);
	row.appendChild(cell);
	
	tabBody.appendChild(row);


	var rowCount = tabBody.rows.length;
	rowCount= rowCount-1;
	
	$('#reqNoNota'+rowCount).keydown(function(e) {
		if(e.which==120)
		{
			OpenDHTMLPopup('proses_kompensasi_sisa_super_pencarian.php?reqIndex='+rowCount+'&reqId='+$("#reqNoPelanggan").val()+'&reqKdValuta='+$("#reqValutaNama").val(), 'Pencarian Pelanggan', 950, 600);
		}
	});
	
	hitungJumlahTotal();		
}   

function getDataPPKB()
{
	$('#dataTableRowDinamis tbody > tr').remove();
	
	$.getJSON("../json-keuangansiuk/get_kompensasi_sisa_uper_json.php?reqId="+$("#reqNoPelanggan").val()+"&reqKdValuta="+$("#reqValutaNama").val(),
	function(data){			
		if(data.length == 0)
			alert('Data tidak ditemukan.');
		else		
		{
			for(i=0;i<data.length;i++)
			{
				addRow(data[i].NO_PPKB,data[i].KARTU,data[i].NO_REF1,data[i].TGL_TRANS,data[i].JML_WD_UPPER,data[i].SISA_TAGIHAN,data[i].JUMLAH_DIBAYAR,'',data[i].NO_NOTA);
			}
		}	
		
		
	});	
}

function ambilReferensiKlasTrans(id)
{
	$.getJSON("../json-keuangansiuk/get_jenis_jasa_kena_pajak_json.php?reqTipeTrans=JRR-KPT-04&reqKlasTrans="+$("#reqSumberBayar"+id).val(),
	function(data){
		$("#reqBukuBesar"+id).val(data.KD_BUKU_BESAR);
		$("#reqBukuPusat"+id).val(data.KD_BUKU_PUSAT);
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
	$("#reqTotalBayar").val(FormatCurrency(total));
	
	
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