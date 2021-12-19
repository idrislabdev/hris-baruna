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
include_once("../WEB-INF/classes/base-gaji/LainKondisi.php");
include_once("../WEB-INF/classes/base-gaji/LainKondisiPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

/* create objects */
$lain_kondisi = new LainKondisi();
$lain_kondisi_pegawai = new LainKondisiPegawai();
$jenis_pegawai = new JenisPegawai();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");


$lain_kondisi_pegawai->selectByParamsGajiPotongan($reqId);
$lain_kondisi_pegawai->firstRow();
$arrPerhitunganGaji = explode("-", $lain_kondisi_pegawai->getField("PERHITUNGAN_GAJI"));

$bulan = date("m");  
$tahun = date("Y");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
	<script type="text/javascript">
		$(function(){
			$('.fkey2').combobox({
			  hasDownArrow:false,
			  onShowPanel:function(){
				$(this).combobox('hidePanel');
			  }
			});
			
			$('.fkey1').combobox({
			  hasDownArrow:false,
			  onShowPanel:function(){
				$(this).combobox('hidePanel');
			  }
			});
			
			$('#ff').form({
				url:'../json-gaji/lain_kondisi_pegawai_add.php',
				onSubmit:function(){
					//$('input[id^="reqLainKondisiId"]').removeAttr('disabled');
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					//$('#rst_form').click();
					<?php /*?>top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>	<?php */?>
					
					window.parent.divwin.close();
				}
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/treeTable/doc/javascripts/jquery.ui.js"></script>
    <link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/treeTable/src/javascripts/jquery.treeTable.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
    $(".example").treeTable({
      initialState: "expanded"
    });
    
    // Drag & Drop Example Code
    $("#dnd-example .file, #dnd-example .folder").draggable({
      helper: "clone",
      opacity: .75,
      refreshPositions: true,
      revert: "invalid",
      revertDuration: 300,
      scroll: true
    });
    
    $("#dnd-example .folder").each(function() {
      $($(this).parents("tr")[0]).droppable({
        accept: ".file, .folder",
        drop: function(e, ui) { 
          $($(ui.draggable).parents("tr")[0]).appendBranchTo(this);
          
          // Issue a POST call to send the new location (this) of the 
          // node (ui.draggable) to the server.
          $.post("move.php", {id: $(ui.draggable).parents("tr")[0].id, to: this.id});
        },
        hoverClass: "accept",
        over: function(e, ui) {
          if(this.id != $(ui.draggable.parents("tr.parent")[0]).id && !$(this).is(".expanded")) {
            $(this).expand();
          }
        }
      });
    });
    
    // Make visible that a row is clicked
    $("table#dnd-example tbody tr").mousedown(function() {
      $("tr.selected").removeClass("selected"); // Deselect currently selected rows
      $(this).addClass("selected");
    });
    
    // Make sure row is selected when span is clicked
    $("table#dnd-example tbody tr span").mousedown(function() {
      $($(this).parents("tr")[0]).trigger("mousedown");
    });
    });
	
	function addRowPotonganLain(tableID) {
		var table = document.getElementById(tableID);
	
		var rowCount = table.rows.length;
		var id_row = rowCount-1;
		var row = table.insertRow(rowCount);
		//alert(id_row);
		
		var column1 = row.insertCell(0);
		var combo1 = document.createElement("select");
		combo1.style.width = '100px';
		combo1.setAttribute("name", "reqLainKondisiId[]"); 
		
		$.getJSON("../json-gaji/lain_kondisi_lookup_json.php?reqId=<?=$reqId?>",
		function(data){
			for(i=0;i<data.LAIN_KONDISI_ID.length; i++)
			{
				var option_element1 = document.createElement('option');
				option_element1.setAttribute('value', data.LAIN_KONDISI_ID[i]);
				option_element1.appendChild( document.createTextNode( data.LAIN_KONDISI_NAMA[i] ) );
				combo1.appendChild(option_element1);
				//combo1.options[i] = new Option(data.LAIN_KONDISI_NAMA[i], data.LAIN_KONDISI_ID[i]);
			} 
		});
		column1.appendChild(combo1);
		
		var add_label1 = document.createElement('label');
		column1.appendChild(add_label1);
		add_label1.innerHTML = ' <a style="cursor:pointer" onclick="deleteRowPotonganLain(\'sf\', this)"><img src="../WEB-INF/images/delete-icon.png" width="12" height="12" border="0" /></a>';
		
		
		var column2 = row.insertCell(1);
		var combo2 = document.createElement("select");
		combo2.setAttribute("name", "reqBulan[]"); 
		combo2.setAttribute("id", "reqBulan"+id_row); 
		
		$.getJSON("../json-gaji/lain_kondisi_bulan_lookup_json.php",
		function(data){
			for(i=0;i<data.BULAN_ID.length; i++)
			{
				var option_element2 = document.createElement('option');
				option_element2.setAttribute('value', data.BULAN_ID[i]);
				option_element2.appendChild( document.createTextNode( data.BULAN_NAMA[i] ) );
				if (data.BULAN_ID[i] == '<?=$bulan?>')
				{
					option_element2.setAttribute("selected", "selected");
				}
				combo2.appendChild(option_element2);
			} 
		});
		column2.appendChild(combo2);
		
		var add_label2 = document.createElement('label');
		column2.appendChild(add_label2);
		add_label2.innerHTML = '&nbsp;<input type="hidden" name="reqPotonganLain[]" value="">';
		
		var column4= row.insertCell(2);
        var element4 = document.createElement("input");
        element4.type = "text";
		element4.name = "reqAngsuran[]";
		element4.id = "reqAngsuran"+id_row;
		element4.style.width = '20px';
		element4.className='easyui-validatebox';
        column4.appendChild(element4);
		$('#reqAngsuran'+id_row).validatebox({  
			required: true
		});  
	
		$('input[id^="reqAngsuran"]').keypress(function(e) {
			if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
			{
			return false;
			}
		});
		
		var column5 = row.insertCell(3);
        var element5 = document.createElement("input");
        element5.type = "text";
		element5.name = "reqAngsuranTerbayar[]";
		element5.style.width = '20px';
		element5.disabled = true;
        column5.appendChild(element5);

		var column5 = row.insertCell(4);
        var element5 = document.createElement("input");
        element5.type = "text";
		element5.name = "reqAngsuranSisa[]";
		element5.style.width = '20px';
		element5.disabled = true;
        column5.appendChild(element5);

		
		var column6 = row.insertCell(5);
        var element6 = document.createElement("input");
        element6.type = "text";
		element6.name = "reqJumlahAwalAngsuran[]";
		element6.id = "reqJumlahAwalAngsuran"+id_row;
		element6.onfocus = function() {  
			FormatAngka("reqJumlahAwalAngsuran"+id_row);
		};
		element6.onkeyup = function() {  
			FormatUang("reqJumlahAwalAngsuran"+id_row);
		};
		element6.onblur = function() {  
			FormatUang("reqJumlahAwalAngsuran"+id_row);
		};
		element6.style.width = '50px';
		element6.className='easyui-validatebox';
        column6.appendChild(element6);
		$('#reqJumlahAwalAngsuran'+id_row).validatebox({  
			required: true
		});
		
		var column7 = row.insertCell(6);
        var element7 = document.createElement("input");
        element7.type = "text";
		element7.name = "reqJumlahAngsuran[]";
		element7.id = "reqJumlahAngsuran"+id_row;
		element7.onfocus = function() {  
			FormatAngka("reqJumlahAngsuran"+id_row);
		};
		element7.onkeyup = function() {  
			FormatUang("reqJumlahAngsuran"+id_row);
		};
		element7.onblur = function() {  
			FormatUang("reqJumlahAngsuran"+id_row);
		};
		element7.style.width = '50px';
		element7.className='easyui-validatebox';
        column7.appendChild(element7);
		$('#reqJumlahAngsuran'+id_row).validatebox({  
			required: true
		});
		
		var column8 = row.insertCell(7);
        var element8 = document.createElement("input");
        element8.type = "text";
		element8.name = "reqJumlahTotal[]";
		element8.id = "reqJumlahTotal"+id_row;
		element8.onfocus = function() {  
			FormatAngka("reqJumlahTotal"+id_row);
		};
		element8.onkeyup = function() {  
			FormatUang("reqJumlahTotal"+id_row);
		};
		element8.onblur = function() {  
			FormatUang("reqJumlahTotal"+id_row);
		};
		element8.style.width = '50px';
		element8.className='easyui-validatebox';
        column8.appendChild(element8);
		
		var column9 = row.insertCell(8);
        var element9 = document.createElement("input");
        element9.type = "text";
		element9.name = "reqKeterangan[]";
		element9.style.width = '120px';
		element9.className='easyui-validatebox';
        column9.appendChild(element9);
		
	}
	
	function deleteRowPotonganLain(tableID, id) {
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
	function setPelunasan(bulan, sisa, id, cicilan) {
		OpenDHTML('pegawai_potongan_lain_set_lunas.php?reqId='+id+'&reqCicilan='+cicilan+'&reqPegawaiId=<?=$reqId?>&reqPeriode='+bulan, 'Set Pelunasan', 670, 414);
		/*
		if(confirm('Set pelunasan dengan bulan akhir bayar ' + bulan + ' dengan sisa cicilan ' + sisa + ' bulan ?') == false)
			return "";
		
		$.getJSON("../json-gaji/potongan_lain_set_lunas.php?reqId=" + id,
		function(data){
			
		});
		alert('Pelunasan angsuran telah diproses.');
		document.location.reload();
		*/
	}
    </script>
    <script type="text/javascript">
		function check(checkboxid, jumlahchild)
		{
			var arrCheckbox = checkboxid.split('-');
			if(arrCheckbox.length == 3)
			{
				var childcheck = false;
				for(i=1;i<=jumlahchild;i++)
				{
					if(arrCheckbox[0] + '-' + arrCheckbox[1] + '-' + i == checkboxid)
					{}
					else
					{
						if(document.getElementById(arrCheckbox[0] + '-' + arrCheckbox[1] + '-' + i).checked == true)
							childcheck = true;
					}
				}
				if(childcheck == false)
					document.getElementById(arrCheckbox[0] + '-' + arrCheckbox[1]).checked = document.getElementById(checkboxid).checked;	
			}
			else
			{
						
				for(j=1;j<=jumlahchild;j++)
				{
					document.getElementById(arrCheckbox[0] + '-' + arrCheckbox[1] + '-' + j).checked = document.getElementById(checkboxid).checked;
				}				
			}
			//alert(document.getElementById(checkboxid).checked);
			
		}
		
		function setBulanAwal(id)
		{
			document.getElementById("reqBulan" + id).value = document.getElementById("bulan" + id).value + '' + document.getElementById("tahun" + id).value;
		}
	</script>     

    <!-- POPUP WINDOW -->
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
    
    <script type="text/javascript">
    function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
    {
        var left = 270;
        
        divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=100,resize=1,scrolling=1,midle=1'); return false;
    }
    </script>
    
</head> 
<body>

<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
		<span><img src="../WEB-INF/images/panah-judul.png"> Potongan Lain-lain</span>
    </div>
    
    <div class="data-foto-table">
        <div class="data-foto">
            <div class="data-foto-img">
                <img src="../simpeg/image_script.php?reqPegawaiId=<?=$reqId?>&reqMode=pegawai" width="60" height="77">
            </div>
            
            <div class="data-foto-ket">
            	<div style="font-size:18px; "><?=$lain_kondisi_pegawai->getField("NAMA")?> (<?=$lain_kondisi_pegawai->getField("NRP")?>)</div>     
                <div style="font-size:14px; line-height:20px;">Total Gaji : <?=currencyToPage($arrPerhitunganGaji[0])?></div>
                <div style="font-size:14px; line-height:20px;">Total Potongan : <?=currencyToPage($arrPerhitunganGaji[1])?></div>
                <div style="font-size:14px; line-height:20px;">Total Saldo : <?=currencyToPage($arrPerhitunganGaji[2])?></div>
            </div>
    
        </div>
        
        <div class="data-table">
    
            <form id="ff" method="post" novalidate>
            &nbsp;<a href="#" style="text-decoration:blink; color:red"><strong>Perhatian :</strong></a> Entrian "Bulan Mulai" adalah periode pembayaran pertama untuk potongan lain. Perlu diketahui bahwa periode PPTPK dan PKWT mundur 1 periode dengan Perbantuan / Organik. <br>Apabila di Set Lunas untuk Angsuran 1 x (Kelontong) akan disesuaikan dengan "Bulan Mulai" yang telah di entri. 
            <table class="example" id="sf" width="1500px">
            <thead>
              <tr>
                  <th rowspan="2">
                      <a style="cursor:pointer" title="Tambah Petugas" onclick="addRowPotonganLain('sf')"><img src="../WEB-INF/images/icn_add.gif" width="16" height="16" border="0" /></a>
                      Nama Lembaga
                  </th>
                  <th colspan="4">
                  Angsuran
                  </th>
                  <th colspan="2">
                  Pembayaran Angsuran
                  </th>
                  <th rowspan="2">Total Pinjaman</th>
                  <th width="15%" rowspan="2">Keterangan</th>
                  <th rowspan="2">Aksi</th>
              </tr>
              <tr>
                  <th>Bulan Mulai</th>
                  <th>Kali</th>
                  <th>Terbayar</th>
                  <th>Sisa</th>
                  <th>Bayar Awal</th>
                  <th>Per Bulan</th>                   
              </tr>
            </thead>
            <tbody> 
              <?
                  $j = 1;
                  $checkbox_index = 0;
                  $lain_kondisi->selectByParams(array(), -1, -1, " AND B.LAIN_KONDISI_PEGAWAI_ID IS NOT NULL", $reqId);
                  while($lain_kondisi->nextRow())
                  {
                  if($lain_kondisi->getField('ANGSURAN') == $lain_kondisi->getField('ANGSURAN_TERBAYAR'))
                    $readonly = "readonly";
                  else
                    $readonly = "";
                  ?>
                  <tr id="node-<?=$lain_kondisi->getField('LAIN_KONDISI_ID')?>">
                          <td>
                          <input type="hidden" name="reqPotonganLain[]" id="reqPotonganLain<?=$checkbox_index?>" value="<?=$lain_kondisi->getField("LAIN_KONDISI_PEGAWAI_ID")?>">
                          <select name="reqLainKondisiId[]" id="reqLainKondisiId<?=$checkbox_index?>" class="fkey1" data-options="editable:false">                
                          <option value="<?=$lain_kondisi->getField('LAIN_KONDISI_ID')?>" selected><?=$lain_kondisi->getField('NAMA')?></option>              
                          </select>
                          </td>
                          <td>
                            <select name="bulan" id="bulan<?=$checkbox_index?>" onChange="setBulanAwal('<?=$checkbox_index?>')">
                            <?
                            for($i=1; $i<=12;$i++)
                            {
                                $bulan = generateZero($i,2);
                            ?>
                                <option value="<?=$bulan?>" <? if(substr($lain_kondisi->getField("BULAN_MULAI"), 0, 2) == $bulan) { ?> selected <? } ?>><?=getExtMonth($i)?></option>
                            <?
                            }
                            ?>
                            </select>
                            <select name="tahun" id="tahun<?=$checkbox_index?>" onChange="setBulanAwal('<?=$checkbox_index?>')">
                            <?
                            for($i=date("Y")-2; $i<=date("Y")+1;$i++)
                            {
                            ?>
                                <option value="<?=$i?>" <? if(substr($lain_kondisi->getField("BULAN_MULAI"), 2, 4) == $i) { ?> selected <? } ?>><?=$i?></option>
                            <?
                            }
                            ?>
                            </select>
                            <input type="hidden" style="width:70px;" name="reqBulan[]" id="reqBulan<?=$checkbox_index?>" value="<?=$lain_kondisi->getField('BULAN_MULAI')?>">
                           </td>
                          <td><input type="text" style="width:20px;" <?=$readonly?> name="reqAngsuran[]" value="<?=$lain_kondisi->getField('ANGSURAN')?>"></td>
                          <td>
                                <input type="text" style="width:20px;" <?=$readonly?> name="reqAngsuranTerbayar[]" value="<?=$lain_kondisi->getField('ANGSURAN_TERBAYAR')?>">&nbsp; 
                                <?
                                    $bulan = substr($lain_kondisi->getField('BULAN_AKHIR_BAYAR'),0,2);
                                    $tahun = substr($lain_kondisi->getField('BULAN_AKHIR_BAYAR'),2,4);
                                    echo getExtMonth((int)$bulan)." ".$tahun;
                                ?>
                          </td>              
                          <td>
                                <input type="text" style="width:20px;" readonly name="reqAngsuranSisa[]" value="<?=($lain_kondisi->getField('ANGSURAN') - $lain_kondisi->getField('ANGSURAN_TERBAYAR'))?>">&nbsp; 
                          </td>              
                          <td><input type="text" style="width:50px;" name="reqJumlahAwalAngsuran[]" readonly id="reqJumlahAwalAngsuran<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahAwalAngsuran<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahAwalAngsuran<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlahAwalAngsuran<?=$checkbox_index?>')" value="<?=numberToIna($lain_kondisi->getField('JUMLAH_AWAL_ANGSURAN'))?>"></td>
                          <td><input type="text" style="width:50px;" name="reqJumlahAngsuran[]"  <?=$readonly?> id="reqJumlahAngsuran<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahAngsuran<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahAngsuran<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlahAngsuran<?=$checkbox_index?>')" value="<?=numberToIna($lain_kondisi->getField('JUMLAH_ANGSURAN'))?>">
                          </td>
                          <td><input type="text" style="width:50px;" name="reqJumlahTotal[]" <?=$readonly?> id="reqJumlahTotal<?=$checkbox_index?>" class="easyui-validatebox"  value="<?=numberToIna($lain_kondisi->getField('JUMLAH_TOTAL'))?>" OnFocus="FormatAngka('reqJumlahTotal<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahTotal<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlahTotal<?=$checkbox_index?>')"/></td>
                          <td><input type="text" style="width:120px;" name="reqKeterangan[]" <?=$readonly?> value="<?=$lain_kondisi->getField('KETERANGAN')?>"></td>
                          <td>
                          <?
                          if($lain_kondisi->getField('ANGSURAN') == $lain_kondisi->getField('ANGSURAN_TERBAYAR'))
                          {
                          ?>
                          Lunas
                          <?
                          }
                          else
                          {
                              if($bulan == "")
                              {
                                $bulan = substr($lain_kondisi->getField('BULAN_MULAI'),0,2);
                                $tahun = substr($lain_kondisi->getField('BULAN_MULAI'),2,4);						  
                              }
                          ?>
                          <input type="button" name="reqSetLunas<?=$checkbox_index?>" id="reqSetLunas<?=$checkbox_index?>" onClick="setPelunasan('<?=$bulan.$tahun?>', '<?=($lain_kondisi->getField('ANGSURAN') - $lain_kondisi->getField('ANGSURAN_TERBAYAR'))?>', '<?=$lain_kondisi->getField('LAIN_KONDISI_PEGAWAI_ID')?>', '<?=$lain_kondisi->getField('ANGSURAN')?>')" value="Set Lunas">
                          <?
                          }
                          ?>                
                          </td>
                      <?php /*?></table><?php */?>
                  </tr>
              <?php
                    $j++;
                    $checkbox_index++;
                  }
              ?>
            </tbody>            
            </table>         
        
                <div>
                    <input type="hidden" name="reqId" value="<?=$reqId?>">
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                    <input type="submit" value="Submit">
                    <input type="reset" id="rst_form">
                </div>
            </form>
    	</div>
    </div>
</div>
</body>
</html>