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
include_once("../WEB-INF/classes/base-gaji/PotonganKondisi.php");
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
$potongan_kondisi = new PotonganKondisi();
$jenis_pegawai = new JenisPegawai();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqKelompokId = httpFilterGet("reqKelompokId");
$reqKelasId = httpFilterGet("reqKelasId");
$reqKelasId = str_replace(";",",",$reqKelasId);

$jenis_pegawai->selectByParams(array("JENIS_PEGAWAI_ID" => $reqId));
$jenis_pegawai->firstRow();


function getPotonganKondisiByParent($id_induk, $parent, $i, $jumlah_child, $reqJenisPegawaiId, $checkbox_index, $reqKelasId, $reqKelompokId)
{
	$child = new PotonganKondisi();
	
	$child->selectByParamsEdit(array("POTONGAN_KONDISI_PARENT_ID"=>$id_induk), -1, -1, "", $reqJenisPegawaiId, $reqKelasId, $reqKelompokId);
	$j=1;
	
	while($child->nextRow())
	{
		$selectedSumbangan = "";
		$selectedPotongan = "";		
		$selectedTanggungan = "";		
		$checked = "";
		$checkbox_index++;
		if($child->getField("POTONGAN_KONDISI_ID") == $child->getField("POTONGAN_KONDISI_ID_JP"))
			$checked = "checked";
		
		if($child->getField("OPSI") == "Y")
			$checked_opsi = "checked";
		        
		if($child->getField("JENIS_POTONGAN") == "S")
			$selectedSumbangan = "selected";
		elseif($child->getField("JENIS_POTONGAN") == "T")
			$selectedTanggungan = "selected";
		else
			$selectedPotongan = "selected";
		
				
		$nama = $child->getField('NAMA');
		echo "
			  <tr id='node-".$child->getField('POTONGAN_KONDISI_ID')."' class='child-of-node-".$child->getField('POTONGAN_KONDISI_PARENT_ID')."'>
				  <td><input name=\"reqJenisPenghasilan[]\" value=\"".$checkbox_index."\" type=\"checkbox\" ".$checked." id=\"checkbox-".$i."-".$j."\" onclick=\"check('checkbox-".$i."-".$j."', '".$jumlah_child."'); $('#tt".$i.$j."').combotree('setValues', ['".$child->getField("POTONGAN_KONDISI_ID")."']);\">".$nama."</td>
				  <td><select id=\"tt".$i.$j."\" class=\"easyui-combotree\" data-options=\"onCheck:onCheck".$i.$j.",url:'../json-gaji/potongan_kondisi_jenis_pegawai_combo_edit_json.php?reqId=".$child->getField('POTONGAN_KONDISI_ID')."&reqJenisPegawaiId=".$reqJenisPegawaiId."&reqKelasId=".$reqKelasId."&reqKelompokId=".$reqKelompokId."',onlyLeafCheck:true,checkbox:true,cascadeCheck:true\" multiple style=\"width:200px;\"></td>
					<script>
						function onCheck".$i.$j."(v){
							var s = $('#tt".$i.$j."').combotree('getText');
							document.getElementById('idJumlah".$i.$j."').value = s;
							}
					</script>				 
				  <td>
					<input type=\"text\" style=\"width:50px;\" name=\"reqJumlahEntri[]\" value=\"".$child->getField('JUMLAH_ENTRI')."\">
				  </td>
				  <td><input type=\"text\" style=\"width:30px;\" name=\"reqProsentase[]\" value=\"".$child->getField('PROSENTASE')."\"></td>
				  <td>
					<input type=\"text\" style=\"width:20px;\" name=\"reqKali[]\" value=\"".$child->getField('KALI')."\">
				  </td>
 			  <td>
 				<select name=\"reqJenisPotongan[]\">
                	<option value=\"S\" ".$selectedSumbangan.">Sumbangan</option>	
                	<option value=\"P\" ".$selectedPotongan.">Potongan</option>	
					<option value=\"T\" ".$selectedTanggungan.">Tanggungan</option>	
                </select>              
              </td>
 			  <td align=\"center\" style=\"display:none\">
			        <input type=\"checkbox\" id=\"opsi-".$i.$j."\" value=\"Y\" ".$checked_opsi." onClick=\"checkOpsi('opsi-".$i.$j."', 'idOpsi".$i.$j."');\">
					<input type=\"hidden\" name=\"reqPotonganKondisiId[]\" value=\"".$child->getField('POTONGAN_KONDISI_ID')."\">
					<input type=\"hidden\" id=\"idJumlah".$i.$j."\" name=\"reqJumlah[]\" value=\"".$child->getField('ISI_JUMLAH')."\">
					<input type=\"hidden\" id=\"idOpsi".$i.$j."\" name=\"reqOpsi[]\" value=\"".$child->getField("OPSI")."\">
              </td>

			  </tr>
			 ";

		
	  //getPotonganKondisiByParent($child->getField("POTONGAN_KONDISI_ID"), $child->getField('NAMA'), $i, $jumlah_child, $reqJenisPegawaiId);		
		$j++;
	}
	unset($child);
	return $checkbox_index;
}
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
			$('#ff').form({
				url:'../json-gaji/potongan_kondisi_jenis_pegawai_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					//$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
				}
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
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
		
		function checkOpsi(checkboxid, textid)
		{
			if(document.getElementById(checkboxid).checked)
				document.getElementById(textid).value = "Y";
			else
				document.getElementById(textid).value = "";
			 
		}
		
		function getTreeCheck(i, value, jumlahchild)
		{
			
		}
    </script>     
</head> 
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Ubah Potongan per Jenis Pegawai</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td><strong>Jenis Pegawai :</strong></td>
            <td><strong><?=$jenis_pegawai->getField("NAMA")?></strong></td>
            <td style="display:none">Kelompok</td>
            <td style="display:none">
               <select disabled>
               	<option value="K" <? if($reqKelompokId == "K") { ?> selected <? } ?>>Kapal</option>
               	<option value="D" <? if($reqKelompokId == "D") { ?> selected <? } ?>>Darat</option>
               </select>
            </td>
            <td>Kelas</td>
            <td>
               <select id="kelas" class="easyui-combotree" data-options="onCheck:onCheckkelas,url:'../json-gaji/kelas_combo_json.php?reqKelasId=<?=$reqKelasId?>',onlyLeafCheck:true,checkbox:true,cascadeCheck:true" multiple style="width:200px;"></select> 
				<script>
                    function onCheckkelas(v){
                        var s = $('#kelas').combotree('getText');
                        document.getElementById('idKelas').value = s;
                        }
                </script>  
                <input type="hidden" id="idKelas" name="reqKelas" value="<?=$reqKelasId?>">
            </td>
        </tr>
    </table>
    <table class="example" id="sf">
    <thead>
      <tr>
          <th>Jenis Penghasilan</th>    
          <th>Jumlah</th>  
          <th>Jml. Entri</th>  
          <th>Prosentase</th>             
          <th>Kali</th>             
          <th>Jenis</th>                        
          <th style="display:none">Opsi</th>                                  
      </tr>
    </thead>
    <tbody> 
	  <?
	  $i = 1;
	  $checkbox_index = 0;
      $potongan_kondisi->selectByParamsEdit(array('POTONGAN_KONDISI_PARENT_ID' => 0), -1, -1, "", $reqId, $reqKelasId, $reqKelompokId);
      while($potongan_kondisi->nextRow())
      {
		  $style_rumus = "";
      ?>
          <tr id="node-<?=$potongan_kondisi->getField('POTONGAN_KONDISI_ID')?>">
              <td class="jarak-tree-table"><input type="checkbox" <? if($potongan_kondisi->getField("JUMLAH_CHILD") == 0) { ?> name="reqJenisPenghasilan[]" value="<?=$checkbox_index?>" <? } else { $checkbox_index -= 1; } ?>  id="checkbox-<?=$i?>" <? if($potongan_kondisi->getField("POTONGAN_KONDISI_ID") == $potongan_kondisi->getField("POTONGAN_KONDISI_ID_JP")) { ?> checked <? } ?> onClick="check('checkbox-<?=$i?>', '<?=$potongan_kondisi->getField('JUMLAH_CHILD')?>'); getTreeCheck('<?=$i?>', '<?=$potongan_kondisi->getField("POTONGAN_KONDISI_ID")?>', '<?=$potongan_kondisi->getField('JUMLAH_CHILD')?>')"><?=$potongan_kondisi->getField('NAMA')?></td>
              <?
              if($potongan_kondisi->getField("JUMLAH_CHILD") == 0)
			  {
			  	 if($potongan_kondisi->getField("RUMUS") == "N")
				 	$style_rumus = "style='display:none'";				 	 		  
			  ?>
	          <td>
			  <div <?=$style_rumus?>>
              <select id="tt<?=$i?>" class="easyui-combotree" data-options="onCheck:onCheck<?=$i?>,url:'../json-gaji/potongan_kondisi_jenis_pegawai_combo_edit_json.php?reqId=<?=$potongan_kondisi->getField("POTONGAN_KONDISI_ID")?>&reqJenisPegawaiId=<?=$reqId?>&reqKelasId=<?=$reqKelasId?>&reqKelompokId=<?=$reqKelompokId?>',onlyLeafCheck:true,checkbox:true,cascadeCheck:true" multiple style="width:200px;"></select>           
			<script>
                function onCheck<?=$i?>(v){
                    var s = $('#tt<?=$i?>').combotree('getText');
                    document.getElementById('idJumlah<?=$i?>').value = s;
                    }
            </script>
            </div>    
 			  </td>
              <td>
              	<div <?=$style_rumus?>>
              	<input type="text" style="width:50px;" name="reqJumlahEntri[]" id="reqJumlahEntri<?=$i?>"  OnFocus="FormatAngka('reqJumlahEntri<?=$i?>')" OnKeyUp="FormatUang('reqJumlahEntri<?=$i?>')" OnBlur="FormatUang('reqJumlahEntri<?=$i?>')" value="<?=numberToIna($potongan_kondisi->getField('JUMLAH_ENTRI'))?>">
              	</div>
              </td>
			  <td>
              	<div <?=$style_rumus?>>
                <input type="text" style="width:30px;" name="reqProsentase[]" value="<?=$potongan_kondisi->getField('PROSENTASE')?>">
              	</div>
                </td>
              <td>
              	<div <?=$style_rumus?>>
              	<input type="text" style="width:20px;" name="reqKali[]" value="<?=$potongan_kondisi->getField('KALI')?>">
              	</div>
              </td>
 			  <td>
 				<select name="reqJenisPotongan[]">
                	<option value="S" <? if($potongan_kondisi->getField("JENIS_POTONGAN") == "S") { ?> selected <? } ?>>Sumbangan</option>	
                	<option value="P" <? if($potongan_kondisi->getField("JENIS_POTONGAN") == "P") { ?> selected <? } ?>>Potongan</option>	
                	<option value="T" <? if($potongan_kondisi->getField("JENIS_POTONGAN") == "T") { ?> selected <? } ?>>Tanggungan</option>	
                </select>
              </td>
 			  <td align="center" style="display:none">
              	<input type="checkbox" id="opsi-<?=$i?>" value="Y" <? if($potongan_kondisi->getField("OPSI") == "Y") { ?> checked <? } ?> onClick="checkOpsi('opsi-<?=$i?>', 'idOpsi<?=$i?>');">
              	<input type="hidden" name="reqPotonganKondisiId[]" value="<?=$potongan_kondisi->getField('POTONGAN_KONDISI_ID')?>">
              	<input type="text" id="idJumlah<?=$i?>" name="reqJumlah[]" value="<?=$potongan_kondisi->getField('ISI_JUMLAH')?>">             
              	<input type="hidden" id="idOpsi<?=$i?>" name="reqOpsi[]" value="<?=$potongan_kondisi->getField("OPSI")?>">             
              </td>
              <?
			  }
                  $checkbox_index = getPotonganKondisiByParent($potongan_kondisi->getField('POTONGAN_KONDISI_ID'), $potongan_kondisi->getField('NAMA'), $i, $potongan_kondisi->getField('JUMLAH_CHILD'), $reqId, $checkbox_index, $reqKelasId, $reqKelompokId);
              ?>
          </tr>
      <?php
	  	$i++;
		$checkbox_index++;
      }
      ?>  
    </tbody>            
    </table>         

        <div>
            <input type="hidden" name="reqJenisPegawaiId" value="<?=$reqId?>">
            <input type="hidden" name="reqCurrentKelas" value="<?=$reqKelasId?>">
            <input type="hidden" name="reqKelompok" value="<?=$reqKelompokId?>">
            <input type="hidden" name="reqMode" value="insert">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
	</form>
</div>
</body>
</html>