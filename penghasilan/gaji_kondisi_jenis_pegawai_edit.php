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
include_once("../WEB-INF/classes/base-gaji/GajiKondisi.php");
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
$gaji_kondisi = new GajiKondisi();
$jenis_pegawai = new JenisPegawai();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqKelompokId = httpFilterGet("reqKelompokId");
$reqKelasId = httpFilterGet("reqKelasId");
// $reqKelasId = str_replace(";",",",$reqKelasId);

$jenis_pegawai->selectByParams(array("JENIS_PEGAWAI_ID" => $reqId));
$jenis_pegawai->firstRow();


function getGajiKondisiByParent($id_induk, $parent, $i, $jumlah_child, $reqJenisPegawaiId, $checkbox_index, $reqKelasId, $reqKelompokId)
{
	$child = new GajiKondisi();
	
	$child->selectByParamsEdit(array("GAJI_KONDISI_PARENT_ID"=>$id_induk), -1, -1, "", $reqJenisPegawaiId, $reqKelasId, $reqKelompokId);
	$j=1;
	while($child->nextRow())
	{
		$checked = "";
		$checkbox_index++;
		if($child->getField("GAJI_KONDISI_ID") == $child->getField("GAJI_KONDISI_ID_JENIS_PEGAWAI"))
			$checked = "checked";
			
		$nama = $child->getField('NAMA');
		echo "
			  <tr id='node-".$child->getField('GAJI_KONDISI_ID')."' class='child-of-node-".$child->getField('GAJI_KONDISI_PARENT_ID')."'>
				  <td><input name=\"reqJenisPenghasilan[]\" value=\"".$checkbox_index."\" type=\"checkbox\" ".$checked." id=\"checkbox-".$i."-".$j."\" onclick=\"check('checkbox-".$i."-".$j."', '".$jumlah_child."');\">".$nama."</td>
				  <td><select id=\"tt".$i.$j."\" class=\"easyui-combotree\" data-options=\"onCheck:onCheck".$i.$j.",url:'../json-gaji/gaji_kondisi_jenis_pegawai_combo_edit_json.php?reqId=".$child->getField('GAJI_KONDISI_ID')."&reqJenisPegawaiId=".$reqJenisPegawaiId."&reqKelasId=".$reqKelasId."&reqKelompokId=".$reqKelompokId."',onlyLeafCheck:true,checkbox:true,cascadeCheck:true\" multiple style=\"width:300px;\"></td>
					<script>
						function onCheck".$i.$j."(v){
							var s = $('#tt".$i.$j."').combotree('getText');
							document.getElementById('idJumlah".$i.$j."').value = s;
							}
					</script>				 
				  <td><input type=\"text\" style=\"width:30px;\" name=\"reqProsentase[]\" value=\"".$child->getField('PROSENTASE')."\"></td>
				  <td>
					<input type=\"text\" style=\"width:20px;\" name=\"reqKali[]\" value=\"".$child->getField('KALI')."\">
					<input type=\"hidden\" name=\"reqGajiKondisiId[]\" value=\"".$child->getField('GAJI_KONDISI_ID')."\">
					<input type=\"hidden\" id=\"idJumlah".$i.$j."\" name=\"reqJumlah[]\">
				  </td>
			  </tr>
			 ";
		
	  //getGajiKondisiByParent($child->getField("GAJI_KONDISI_ID"), $child->getField('NAMA'), $i, $jumlah_child, $reqJenisPegawaiId);		
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
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-gaji/gaji_kondisi_jenis_pegawai_add.php',
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
		function getTreeCheck(i, value, jumlahchild)
		{
			$('#tt' + i).combotree('setValues', [value]);
			if(jumlahchild > 0)
			{
				for(j=1;j<=jumlahchild;j++)
				{
					$('#tt' + i + j).combotree('setValues', [value + '0' + j]);
				}	
			}
		}
    </script>     
</head> 
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Ubah Gaji per Jenis Pegawai</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td><strong>Jenis Pegawai :</strong></td>
            <td><strong><?=$jenis_pegawai->getField("NAMA")?></strong></td>
            <td>Kelompok</td>
            <td>
                <input readonly="" id="reqKelompok" class="easyui-combotree" data-options="url:'../json-simpeg/kelompok_pegawai_combo_json.php'" name="reqKelompok" style="width:300px;" value="<?=$reqKelompokId?>">
            </td>
            <td>Kategori Pendidikan</td>
            <td>
                <input readonly="" id="reqKelasId" class="easyui-combotree" data-options="url:'../json-simpeg/kategori_sekolah_combo_json.php'" name="reqKelasId" style="width:300px;" value="<?=$reqKelasId?>"> 
            </td>
        </tr>
    </table>
    <table class="example" id="sf">
    <thead>
      <tr>
          <th>Jenis Penghasilan</th>    
          <th>Jumlah</th>  
          <th>Prosentase</th>             
          <th>Kali</th>             
      </tr>
    </thead>
    <tbody> 
	  <?
	  $i = 1;
	  $checkbox_index = 0;
      $gaji_kondisi->selectByParamsEdit(array('GAJI_KONDISI_PARENT_ID' => 0), -1, -1, "", $reqId, $reqKelasId, $reqKelompokId);
      while($gaji_kondisi->nextRow())
      {
      ?>
          <tr id="node-<?=$gaji_kondisi->getField('GAJI_KONDISI_ID')?>">
              <td class="jarak-tree-table"><input type="checkbox" <? if($gaji_kondisi->getField("JUMLAH_CHILD") == 0) { ?> name="reqJenisPenghasilan[]" value="<?=$checkbox_index?>" <? } else { $checkbox_index -= 1; } ?>  id="checkbox-<?=$i?>" <? if($gaji_kondisi->getField("GAJI_KONDISI_ID") == $gaji_kondisi->getField("GAJI_KONDISI_ID_JENIS_PEGAWAI")) { ?> checked <? } ?> onClick="check('checkbox-<?=$i?>', '<?=$gaji_kondisi->getField('JUMLAH_CHILD')?>');"><?=$gaji_kondisi->getField('NAMA')?></td>
              <?
              if($gaji_kondisi->getField("JUMLAH_CHILD") == 0)
			  {
			  ?>
	          <td>
              <select id="tt<?=$i?>" class="easyui-combotree" data-options="onCheck:onCheck<?=$i?>,url:'../json-gaji/gaji_kondisi_jenis_pegawai_combo_edit_json.php?reqId=<?=$gaji_kondisi->getField("GAJI_KONDISI_ID")?>&reqJenisPegawaiId=<?=$reqId?>&reqKelasId=<?=$reqKelasId?>&reqKelompokId=<?=$reqKelompokId?>',onlyLeafCheck:true,checkbox:true,cascadeCheck:true" multiple style="width:300px;"></select>           
			<script>
                function onCheck<?=$i?>(v){
                    var s = $('#tt<?=$i?>').combotree('getText');
                    document.getElementById('idJumlah<?=$i?>').value = s;
                    }
            </script>    
 			  </td>
			  <td><input type="text" style="width:30px;" name="reqProsentase[]" value="<?=$gaji_kondisi->getField('PROSENTASE')?>"></td>
              <td>
              	<input type="text" style="width:20px;" name="reqKali[]" value="<?=$gaji_kondisi->getField('KALI')?>">
              	<input type="hidden" name="reqGajiKondisiId[]" value="<?=$gaji_kondisi->getField('GAJI_KONDISI_ID')?>">
              	<input type="hidden" id="idJumlah<?=$i?>" name="reqJumlah[]" value="">
              </td>
              <?
			  }
	          if($gaji_kondisi->getField("JUMLAH_CHILD") == 0)
			  {}
			  else
	              $checkbox_index = getGajiKondisiByParent($gaji_kondisi->getField('GAJI_KONDISI_ID'), $gaji_kondisi->getField('NAMA'), $i, $gaji_kondisi->getField('JUMLAH_CHILD'), $reqId, $checkbox_index, $reqKelasId, $reqKelompokId);
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