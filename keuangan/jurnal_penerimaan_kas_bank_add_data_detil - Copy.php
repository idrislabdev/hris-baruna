<?
/* *******************************************************************************************************
MODUL NAME 			: informasi Kategori
FILE NAME 			: informasi_kategori.php
AUTHOR				: Aon-Prog
VERSION				: 1.0 beta
MODIFICATION DOC	:
DESCRIPTION			: Halaman untuk menampilkan informasi kategori
******************************************************************************************************* */

include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbDTmp.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");


/* create objects */
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqNoBukti = httpFilterGet("reqNoBukti");

if($reqId == "")
	$reqMode = "insert";
else
	$reqMode = "update";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
    <link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/jurnal_penerimaan_kas_bank_add_data_detil.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data);
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					document.location.href = 'jurnal_penerimaan_kas_bank_add_data_detil.php?reqId='+data[0];
				}
			});
		});
	</script>
    <script type="text/javascript">
   
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
		element.name = "reqBukuBesar[]";
		element.id = "reqBukuBesar"+rownum;
		element.className='easyui-validatebox';		
		cell.appendChild(element);
		row.appendChild(cell);

		/* KOLOM 2 */
		cell = document.createElement("TD");
		var element = document.createElement("input");
		element.type = "text";
		element.name = "reqKartu[]";
		element.id = "reqKartu"+rownum;
		element.className='easyui-validatebox';		
		cell.appendChild(element);
		row.appendChild(cell);
		
		/* KOLOM 3 */
		cell = document.createElement("TD");
		var element = document.createElement("input");
		element.type = "text";
		element.name = "reqBukuPusat[]";
		element.id = "reqBukuPusat"+rownum;
		element.className='easyui-validatebox';		
		cell.appendChild(element);
		row.appendChild(cell);
		
		/* KOLOM 4 */
		cell = document.createElement("TD");
		var element = document.createElement("input");
		element.type = "text";
		element.name = "reqKeterangan[]";
		element.id = "reqKeterangan"+rownum;
		element.className='easyui-validatebox';		
		cell.appendChild(element);
		row.appendChild(cell);
		
		/* KOLOM 5 */
		cell = document.createElement("TD");
		var element = document.createElement("input");
		element.type = "text";
		element.name = "reqBukuBesar[]";
		element.id = "reqBukuBesar"+rownum;
		element.className='easyui-validatebox';		
		cell.appendChild(element);
		row.appendChild(cell);
		
		/* KOLOM 6 */
		cell = document.createElement("TD");
		var element = document.createElement("input");
		element.type = "text";
		element.name = "reqDebet[]";
		element.id = "reqDebet"+rownum;
		element.className='easyui-validatebox';		
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
		element.className='easyui-validatebox';		
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
	}   

	function addRowDrawTables(tableID) {
		var table = document.getElementById(tableID);
	
		var rowCount = table.rows.length;
		var id_row = rowCount-1;
		var row = table.insertRow(rowCount);
		$('#reqArrayIndex').val(rowCount);
		
		var column0= row.insertCell(0);
		column0.innerHTML = rowCount;
		var column1= row.insertCell(1);
        var element1 = document.createElement("input");
        element1.type = "text";
		element1.name = "reqBukuBesar["+ id_row +"]";
		element1.id = "reqBukuBesar"+id_row;
		element1.className='easyui-validatebox';
        column1.appendChild(element1);
		
		var column2= row.insertCell(2);
        var element2 = document.createElement("input");
        element2.type = "text";
		element2.name = "reqKartu["+ id_row +"]";
		element2.id = "reqKartu"+id_row;
		element2.style.width = '100px';
		element2.className='easyui-validatebox';
        column2.appendChild(element2);
		
		var column3= row.insertCell(3);
        var element3= document.createElement("input");
        element3.type = "text";
		element3.name = "reqBukuPusat["+ id_row +"]";
		element3.style.width = '100px';
		element3.className='easyui-validatebox';
        column3.appendChild(element3);
		
		var column4= row.insertCell(4);
        var element4= document.createElement("input");
        element4.type = "text";
		element4.name = "reqKeterangan["+ id_row +"]";
		element4.style.width = '415px';
		element4.className='easyui-validatebox';
        column4.appendChild(element4);
		
		var column6 = row.insertCell(5);
        var element6 = document.createElement("input");
        element6.type = "text";
		element6.name = "reqDebet["+ id_row +"]";
		element6.id = "reqDebet"+id_row;
		element6.onfocus = function() {  
			FormatAngka("reqDebet"+id_row);
		};
		element6.onkeyup = function() {  
			FormatUang("reqDebet"+id_row);
			hitungDebetTotal(tableID);
			setTimeout(setCheckBalance, 1000);
		};
		element6.onblur = function() {  
			FormatUang("reqDebet"+id_row);
		};
		
		element6.style.width = '100px';
		element6.className='easyui-validatebox';
        column6.appendChild(element6);
		
		
		var column6 = row.insertCell(6);
        var element6 = document.createElement("input");
        element6.type = "text";
		element6.name = "reqKredit["+ id_row +"]";
		element6.id = "reqKredit"+id_row;
		element6.onfocus = function() {  
			FormatAngka("reqKredit"+id_row);
		};
		element6.onkeyup = function() {  
			FormatUang("reqKredit"+id_row);
			hitungKreditTotal(tableID);
			setTimeout(setCheckBalance, 1000);
		};
		element6.onblur = function() {  
			FormatUang("reqKredit"+id_row);
		};
		element6.style.width = '100px';
		element6.className='easyui-validatebox';
        column6.appendChild(element6);
		
		var column7= row.insertCell(7);
		var add_label = document.createElement('label');
		add_label.style.textAlign='center';
		column7.appendChild(add_label);
		add_label.innerHTML = '<center><a style="cursor:pointer;" onclick="deleteRowDrawTable(\'dataTableRowDinamis\', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a></center>';
	}
	
	function hitungDebetTotal(tableID)
	{
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		var total = 0;
		
		for(var i=0; i<=rowCount; i++) {
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
	
	function hitungKreditTotal(tableID)
	{
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		var total = 0;
		
		for(var i=0; i<=rowCount; i++) {
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
    </script>
    
    <!-- COLORING GRID -->
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ColoringGrid/css/table-style.css">
	<script type="text/javascript" src="../WEB-INF/lib/ColoringGrid/js/ColoringGrid.js"></script>
    
</head> 
<!--<body onLoad="setTimeout(setValue, 1000);">-->
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <form id="ff" method="post" novalidate>
    <table class="example" id="dataTableRowDinamis">
    <!--<table class="example altrowstable" id="alternatecolor" >-->
        <thead class="altrowstable">
          <tr>
              <th style="width:5%">
                No
                <a style="cursor:pointer" title="Tambah" onclick="addRow()"><img src="../WEB-INF/images/tree-add.png" width="16" height="16" border="0" /></a>
              </th>
              <th style="width:10%">Buku&nbsp;Besar</th>
              <th style="width:10%">Kartu</th>
              <th style="width:10%">Buku&nbsp;Pusat</th>
              <th>Keterangan</th>
              <th style="width:10%">Debet</th>
              <th style="width:10%">Kredit</th>
              <th style="width:5%">Aksi</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
          <?
          $i = 1;
          $checkbox_index = 0;
          
          $kbbt_jur_bb_d_tmp->selectByParams(array("NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY NO_SEQ ASC ");
          while($kbbt_jur_bb_d_tmp->nextRow())
          {
          ?>
              <tr id="node-<?=$i?>">
                  <td align="center"><?=$i?></td>
                  <td>
                    <input type="text" name="reqBukuBesar[<?=$checkbox_index?>]" class="easyui-validatebox" value="<?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_BESAR")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqKartu[<?=$checkbox_index?>]" class="easyui-validatebox" value="<?=$kbbt_jur_bb_d_tmp->getField("KD_SUB_BANTU")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqBukuPusat[<?=$checkbox_index?>]" class="easyui-validatebox" value="<?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_PUSAT")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqKeterangan[<?=$checkbox_index?>]" class="easyui-validatebox" value="<?=$kbbt_jur_bb_d_tmp->getField("KET_TAMBAH")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqDebet[]" id="reqDebet<?=$checkbox_index?>" style="text-align:right;" OnFocus="FormatAngka('reqDebet<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqDebet<?=$checkbox_index?>'); hitungDebetTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqDebet<?=$checkbox_index?>')" value="<?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_VAL_DEBET'))?>">
                  </td>
                  <td>
                    <input type="text" name="reqKredit[]" id="reqKredit<?=$checkbox_index?>" style="text-align:right;" OnFocus="FormatAngka('reqKredit<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqKredit<?=$checkbox_index?>'); hitungKreditTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqKredit<?=$checkbox_index?>')" value="<?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_VAL_KREDIT'))?>">
                  </td>
                  <td align="center">
                  <label>
                  <a style="cursor:pointer" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
                  </label>
                  </td>
              </tr>
			  <?
                $i++;
                $checkbox_index++;
                $temp_jml_debet += $kbbt_jur_bb_d_tmp->getField('SALDO_VAL_DEBET');
                $temp_jml_kredit += $kbbt_jur_bb_d_tmp->getField('SALDO_VAL_KREDIT');
              }
              ?>
        </tbody>
        
        <tfoot class="altrowstable">
        	<tr style="background:#f1f4fc">
            	<td>&nbsp;</td>
            	<td>
                <div>
                    <input type="checkbox" id="reqAll" name="reqAll" <? if($reqAll == 'on') echo "checked";?>>
                    <label for="reqAll">All</label> 
                </div>
                </td>
            	<td>
                <div>
                    <input type="checkbox" id="reqBalance" name="reqBalance" <? if($reqBalance == 'on') echo "checked";?>>
                    <label for="reqBalance">Balance</label> 
                </div>
                </td>
            	<td>
                <div>
                    <input type="checkbox" id="reqUnbalance" name="reqUnbalance" <? if($reqBalance == 'on') echo "checked";?>>
                    <label for="reqUnbalance">Unbalance</label> 
                </div>
                </td>
            	<td>&nbsp;</td>
            	<td class=""><input type="text" id="reqJumlahDebet" name="reqJumlahDebet" style="text-align:right;" readonly value="<?=numberToIna($temp_jml_debet)?>" /></td>
            	<td class=""><input type="text" id="reqJumlahKredit" name="reqJumlahKredit" style="text-align:right;" readonly value="<?=numberToIna($temp_jml_kredit)?>" /></td>
            	<td>&nbsp;</td>
            </tr>
        </tfoot>
    </table>
	
    <!--    
    <div>Buku&nbsp;Besar :</div>
    
    <div>Buku Bantu :</div>
    
    <div>Pusat Biaya :</div>
    -->
                
        <!-- ################ -->
        <div style="display:none">
            <input type="hidden" id="reqId" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqArrayIndex" id="reqArrayIndex" value="<?=$checkbox_index?>" />
            <input type="hidden" id="reqMode" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" name="btnSubmit" id="btnSubmit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
	</form>
</div>
<script>
$('input[id^="reqJumlah"]').keypress(function(e) {
	if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>