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

$jenis_pegawai->selectByParams();

function getPotonganKondisiByParent($id_induk, $parent, $i, $jumlah_child, $checkbox_index)
{
	$child = new PotonganKondisi();
	
	$child->selectByParams(array("POTONGAN_KONDISI_PARENT_ID"=>$id_induk));
	$j=1;
	while($child->nextRow())
	{
		$checkbox_index++;
		$nama = $child->getField('NAMA');
		echo "
			  <tr id='node-".$child->getField('POTONGAN_KONDISI_ID')."' class='child-of-node-".$child->getField('POTONGAN_KONDISI_PARENT_ID')."'>
				  <td><input type=\"checkbox\" name=\"reqJenisPenghasilan[]\" value=\"".$checkbox_index."\" id=\"checkbox-".$i."-".$j."\" onclick=\"check('checkbox-".$i."-".$j."', '".$jumlah_child."')\">".$nama."</td>
				  <td><select id=\"tt".$i.$j."\" class=\"easyui-combotree\" data-options=\"onCheck:onCheck".$i.$j.",url:'../json-gaji/potongan_kondisi_jenis_pegawai_combo_json.php?reqId=".$child->getField('POTONGAN_KONDISI_ID')."',onlyLeafCheck:true,checkbox:true,cascadeCheck:true\" multiple style=\"width:200px;\"></td>
					<script>
						function onCheck".$i.$j."(v){
							var s = $('#tt".$i.$j."').combotree('getText');
							document.getElementById('idJumlah".$i.$j."').value = s;
							}
					</script>				 
				  <td><input type=\"text\" style=\"width:50px;\" name=\"reqJumlahEntri[]\" value=\"\"></td>	
				  <td><input type=\"text\" style=\"width:30px;\" name=\"reqProsentase[]\" value=\"100\"></td>
				  <td>
					<input type=\"text\" style=\"width:20px;\" name=\"reqKali[]\" value=\"1\">
				  </td>
				  <td>
					<select name=\"reqJenisPotongan[]\">
						<option value=\"S\">Sumbangan</option>	
						<option value=\"P\">Potongan</option>
						<option value=\"T\">Tanggungan</option>	
					</select>  				  
				  </td>
				  <td>
					<input type=\"checkbox\" value=\"Y\" onClick=\"checkOpsi('opsi-".$i.$j."', 'idOpsi".$i.$j."');\">
					<input type=\"hidden\" name=\"reqPotonganKondisiId[]\" value=\"".$child->getField('POTONGAN_KONDISI_ID')."\">
					<input type=\"hidden\" id=\"idJumlah".$i.$j."\" name=\"reqJumlah[]\">
					<input type=\"hidden\" id=\"idOpsi".$i.$j."\" name=\"reqOpsi[]\" value=\"".$child->getField("OPSI")."\">
				  </td>
			  </tr>
			 ";
		
	  	getPotonganKondisiByParent($child->getField("POTONGAN_KONDISI_ID"), $child->getField('NAMA'), $i, $jumlah_child, $checkbox_index);		
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
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
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
	</script>     
</head> 
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Potongan per Jenis Pegawai</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Jenis Pegawai</td>
            <td>
               <select name="reqJenisPegawaiId">
               <?
               while($jenis_pegawai->nextRow())
			   {
			   ?>
               	<option value="<?=$jenis_pegawai->getField("JENIS_PEGAWAI_ID")?>"><?=$jenis_pegawai->getField("NAMA")?></option>
               <?
			   }
			   ?>
               </select>
            </td>
            <td style="display:none">Kelompok</td>
            <td style="display:none">
               <select name="reqKelompok">
               	<option value="PENDIDIK">PENDIDIK</option>
               	<option value="STAFF">STAFF</option>
               </select>
            </td>
            <td>Kelompok</td>
            <td>
                <input id="reqKelompok" class="easyui-combotree" data-options="url:'../json-simpeg/kelompok_pegawai_combo_json.php'" name="reqKelompok" style="width:300px;">
            </td>
            <td>Kategori Pendidikan</td>
            <td>
               <input id="reqKelas" class="easyui-combotree" data-options="url:'../json-simpeg/kategori_sekolah_combo_json.php'" name="reqKelas" style="width:300px;"> 
            </td>
            <!-- <td>Kelas</td>
            <td>
               <select id="kelas" class="easyui-combotree" data-options="onCheck:onCheckkelas,url:'../json-gaji/kelas_combo_json.php',onlyLeafCheck:true,checkbox:true,cascadeCheck:true" multiple style="width:300px;"></select> 
				<script>
                    function onCheckkelas(v){
                        var s = $('#kelas').combotree('getText');
                        document.getElementById('idKelas').value = s;
                        }
                </script>  
                <input type="hidden" id="idKelas" name="reqKelas" value="">
            </td> -->
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
          <th>Opsi</th>                       
      </tr>
    </thead>
    <tbody> 
	  <?
	  $i = 1;
	  $checkbox_index = 0;
      $potongan_kondisi->selectByParams(array('POTONGAN_KONDISI_PARENT_ID' => 0));
      while($potongan_kondisi->nextRow())
      {
		  $style_rumus = "";
		   if($potongan_kondisi->getField("RUMUS") == "N")
			  $style_rumus = "style='display:none'";		
						 	 		  
      ?>
          <tr id="node-<?=$potongan_kondisi->getField('POTONGAN_KONDISI_ID')?>">
              <td class="jarak-tree-table"><input type="checkbox" <? if($potongan_kondisi->getField("JUMLAH_CHILD") == 0) { ?> name="reqJenisPenghasilan[]" value="<?=$checkbox_index?>" <? } else { $checkbox_index -= 1; } ?> id="checkbox-<?=$i?>" onClick="check('checkbox-<?=$i?>', '<?=$potongan_kondisi->getField('JUMLAH_CHILD')?>')"><?=$potongan_kondisi->getField('NAMA')?></td>
              <?
              if($potongan_kondisi->getField("JUMLAH_CHILD") == 0)
			  {
			  ?>
                  <td>
                  <div <?=$style_rumus?>>
                  <select id="tt<?=$i?>" class="easyui-combotree" data-options="onCheck:onCheck<?=$i?>,url:'../json-gaji/potongan_kondisi_jenis_pegawai_combo_json.php?reqId=<?=$potongan_kondisi->getField('POTONGAN_KONDISI_ID')?>',onlyLeafCheck:true,checkbox:true,cascadeCheck:true" multiple style="width:200px;"></select>           
                <script>
                    function onCheck<?=$i?>(v){
                        var s = $('#tt<?=$i?>').combotree('getText');
                        document.getElementById('idJumlah<?=$i?>').value = s;
                        }
                </script>    
                </div>
                  </td>
                  <td><div <?=$style_rumus?>>
                  	<input type="text" style="width:50px;" name="reqJumlahEntri[]" id="reqJumlahEntri<?=$i?>"  OnFocus="FormatAngka('reqJumlahEntri<?=$i?>')" OnKeyUp="FormatUang('reqJumlahEntri<?=$i?>')" OnBlur="FormatUang('reqJumlahEntri<?=$i?>')" value="">
                   	</div>
                    </td>
                  <td><div <?=$style_rumus?>><input type="text" style="width:30px;" name="reqProsentase[]" value="100"></div></td>
                  <td>
                  <div <?=$style_rumus?>>
                  <input type="text" style="width:20px;" name="reqKali[]" value="1">
                  </div>
                  </td>
                  <td>
                    <select name="reqJenisPotongan[]">
                        <option value="S">Sumbangan</option>	
                        <option value="P">Potongan</option>	
                        <option value="T">Tanggungan</option>	
                    </select>              
                  </td>
                  <td>
                    <input type="checkbox" value="Y" onClick="checkOpsi('opsi-<?=$i?>', 'idOpsi<?=$i?>');">
                    <input type="hidden" name="reqPotonganKondisiId[]" value="<?=$potongan_kondisi->getField('POTONGAN_KONDISI_ID')?>">
                    <input type="hidden" id="idJumlah<?=$i?>" name="reqJumlah[]" value="">
                    <input type="hidden" id="idOpsi<?=$i?>" name="reqOpsi[]" value="<?=$potongan_kondisi->getField("OPSI")?>">
                  </td>
              <?
			  }
                  $checkbox_index = getPotonganKondisiByParent($potongan_kondisi->getField('POTONGAN_KONDISI_ID'), $potongan_kondisi->getField('NAMA'), $i, $potongan_kondisi->getField('JUMLAH_CHILD'), $checkbox_index);
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
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
	</form>
</div>
</body>
</html>