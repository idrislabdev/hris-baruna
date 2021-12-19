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
	element.style.width = "35px";
	cell.appendChild(element);
	row.appendChild(cell);

	/* KOLOM 2 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqBukuBesar[]";
	element.id = "reqBukuBesar"+rownum;
	element.style.width = "165px";
	element.tabIndex = tabindex+1;
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 3 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqKartu[]";
	element.id = "reqKartu"+rownum;
	element.style.width = "165px";
	element.tabIndex = tabindex+2;
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 4 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqBukuPusat[]";
	element.id = "reqBukuPusat"+rownum;
	element.style.width = "165px";
	element.tabIndex = tabindex+3;
	cell.appendChild(element);
	row.appendChild(cell);

	/* KOLOM 5
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqFakturPajak[]";
	element.id = "reqFakturPajak"+rownum;
	element.style.width = "95%";
	element.className='easyui-validatebox';	
	element.tabIndex = tabindex+4;	
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 5 
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqTanggalFakturPajak[]";
	element.id = "reqTanggalFakturPajak"+rownum;
	element.style.width = "95%";
	element.className='easyui-datebox';	
	element.tabIndex = tabindex+5;	
	cell.appendChild(element);
	row.appendChild(cell);
			*/
	/* KOLOM 5 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqKeterangan[]";
	element.id = "reqKeterangan"+rownum;
	element.style.width = "95%";
	element.tabIndex = tabindex+6;
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
	element.style.width = "95%";
	element.tabIndex = tabindex+7;
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
	element.style.width = "95%";
	element.tabIndex = tabindex+8;
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

	$( "#reqBukuBesar"+rowCount).autocomplete({ source:'../json-keuangansiuk/buku_besar_combo_v2_json.php?reqNotId=102', 
															select: function (event, ui) { disableByPolaEntry(ui.item.POLA_ENTRY_ID, rowCount); }, 
															minLength:1,
															autoFocus: true
														}).autocomplete( "instance" )._renderItem = function( ul, item ) {
															return $( "<li>" )
														  .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
														  .appendTo( ul );	
	};

	$( "#reqKartu"+rowCount).autocomplete({ source:'../json-keuangansiuk/kartu_tambah_combo_v2_json.php' , 
										   autoFocus: true
											}).autocomplete( "instance" )._renderItem = function( ul, item ) {
												return $( "<li>" )
											  .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
											  .appendTo( ul );
	};							
				  
	$( "#reqBukuPusat"+rowCount).autocomplete({ source:'../json-keuangansiuk/buku_pusat_combo_v2_json.php', 
											   autoFocus: true 
											}).autocomplete( "instance" )._renderItem = function( ul, item ) {
												return $( "<li>" )
											  .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
											  .appendTo( ul );		
	};	

	$('#reqTanggalFakturPajak'+rowCount).datebox({  
			validType:'date'
	});
						
	$('input[id^="reqKredit"]').keydown(function(e) {
		if(e.which==13)
		{
			if(FormatAngkaNumber($(this).val()) == "0")
			{}
			else
			{
				var num = $(this).attr("id").replace("reqKredit", "");
				tabBody=document.getElementsByTagName("TBODY").item(0);
				var rownum = tabBody.rows.length - 1;
				if(num == rownum)
					addRow();
			}
		}
	});

	$('input[id^="reqDebet"]').keydown(function(e) {
		if(e.which==13)
		{
			if(FormatAngkaNumber($(this).val()) == "0")
			{}
			else
			{
				var num = $(this).attr("id").replace("reqDebet", "");
				tabBody=document.getElementsByTagName("TBODY").item(0);
				var rownum = tabBody.rows.length - 1;
				if(num == rownum)
					addRow();	
					
				var idReqKredit = $(this).attr('id').replace("reqDebet", "reqKredit");
			    $("#"+idReqKredit).removeAttr("tabindex");		
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
