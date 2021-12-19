function addRow(reqLokasi)
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
	element.style.width = "30px";
	cell.appendChild(element);
	row.appendChild(cell);

	/* KOLOM 2 */
	var element = document.createElement("input");
	element.type = "hidden";
	element.name = "reqInventarisRuanganId[]";
	element.id = "reqInventarisRuanganId"+rownum;
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 3 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqNomor[]";
	element.id = "reqNomor"+rownum;
	element.style.width = "200px";
	element.readOnly=true;
	element.className='easyui-validatebox';	
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 4 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqLokasi[]";
	element.id = "reqLokasi"+rownum;
	element.style.width = "300px";
	element.readOnly=true;
	element.className='easyui-validatebox';	
	cell.appendChild(element);
	row.appendChild(cell);
	
	/* KOLOM 5 */
	cell = document.createElement("TD");
	var element = document.createElement("input");
	element.type = "text";
	element.name = "reqKeterangan[]";
	element.id = "reqKeterangan"+rownum;
	element.style.width = "300px";
	element.readOnly=true;
	element.className='easyui-validatebox';	
	cell.appendChild(element);
	row.appendChild(cell);
		
	/* KOLOM 10 */
	cell = document.createElement("TD");
	var button = document.createElement('label');
	button.style.textAlign='center';
	button.innerHTML = '<center><a style="cursor:pointer;" onclick="deleteRowDrawTable(\'dataTableRowDinamis\', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a></center>';
	cell.appendChild(button);
	row.appendChild(cell);
	
	tabBody.appendChild(row);
	
	var rowCount = tabBody.rows.length;
	rowCount= rowCount-1;
	
	$('#reqNomor'+rowCount).keydown(function(e) {
		if(e.which==120)
		{
			OpenDHTMLPopup('penyusutan_add_pencarian.php?reqIndex='+rowCount, 'Pencarian Inventaris', 950, 600);
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