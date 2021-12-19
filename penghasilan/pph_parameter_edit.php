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
include_once("../WEB-INF/classes/base-gaji/PerhitunganPph.php");
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
$jenis_pegawai = new JenisPegawai();
$perhitungn_pph =  new PerhitunganPph();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

$jenis_pegawai->selectByParams();

$perhitungn_pph->selectByParams(array("PERHITUNGAN_PPH_ID" => $reqId));
$perhitungn_pph->firstRow();

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
				url:'../json-gaji/pph_parameter_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					//$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					window.parent.divwin.close(); 				
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
		
		$("#reqJenisPerhitungan").change(function() { 
	
			if($("#reqJenisPerhitungan").val() == 'PROSENTASE')
			{
				document.getElementById('dispJumlah').style.display = '';
				document.getElementById('dispProsentaseNPWP').style.display = '';
				document.getElementById('dispProsentaseTanpaNPWP').style.display = '';
			}
			else
			{
				document.getElementById('dispJumlah').style.display = 'none';
				document.getElementById('dispProsentaseNPWP').style.display = 'none';
				document.getElementById('dispProsentaseTanpaNPWP').style.display = 'none';				
			}
			  				 
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
		
	</script>     
</head> 
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> PPH per Jenis Pegawai</span>
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
               	<option value="<?=$jenis_pegawai->getField("JENIS_PEGAWAI_ID")?>" <? if($jenis_pegawai->getField("JENIS_PEGAWAI_ID") == $perhitungn_pph->getField("JENIS_PEGAWAI_ID")) { ?> selected <? } ?>><?=$jenis_pegawai->getField("NAMA")?></option>
               <?
			   }
			   ?>
               </select>
            </td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>
               <select id="kelas" class="easyui-combotree" data-options="onCheck:onCheckkelas,url:'../json-gaji/kelas_combo_json.php?reqKelasId=<?=$perhitungn_pph->getField("KELAS")?>',onlyLeafCheck:true,checkbox:true,cascadeCheck:true" multiple style="width:300px;"></select> 
				<script>
                    function onCheckkelas(v){
                        var s = $('#kelas').combotree('getText');
                        document.getElementById('idKelas').value = s;
                        }
                </script>  
                <input type="hidden" id="idKelas" name="reqKelas" value="<?=$perhitungn_pph->getField("KELAS")?>">
            </td>
        </tr>
        <tr>
            <td>Jenis Penghasilan</td>
            <td>
               <select name="reqJenisPenghasilan">
               		<option value="GAJI" <? if($perhitungn_pph->getField("JENIS_PENGHASILAN") == "GAJI")  {?> selected <? } ?>>Gaji</option>
               		<option value="MOBILITAS" <? if($perhitungn_pph->getField("JENIS_PENGHASILAN") == "MOBILITAS")  {?> selected <? } ?>>Mobilitas</option>
               		<option value="TRANSPORT" <? if($perhitungn_pph->getField("JENIS_PENGHASILAN") == "TRANSPORT")  {?> selected <? } ?>>Transport</option>
               		<option value="UANG_MAKAN" <? if($perhitungn_pph->getField("JENIS_PENGHASILAN") == "UANG_MAKAN")  {?> selected <? } ?>>Uang Makan</option>
               		<option value="INSENTIF" <? if($perhitungn_pph->getField("JENIS_PENGHASILAN") == "INSENTIF")  {?> selected <? } ?>>Insentif</option>
               		<option value="PREMI" <? if($perhitungn_pph->getField("JENIS_PENGHASILAN") == "PREMI")  {?> selected <? } ?>>Premi</option>
                    <option value="BANTUAN_PENDIDIKAN" <? if($perhitungn_pph->getField("JENIS_PENGHASILAN") == "BANTUAN_PENDIDIKAN")  {?> selected <? } ?>>Bantuan Pendidikan</option>
               		<option value="THR" <? if($perhitungn_pph->getField("JENIS_PENGHASILAN") == "THR")  {?> selected <? } ?>>THR</option>
               		<option value="CUTI_TAHUNAN" <? if($perhitungn_pph->getField("JENIS_PENGHASILAN") == "CUTI_TAHUNAN")  {?> selected <? } ?>>Cuti Tahunan</option>
               		<option value="BONUS_TAHUNAN" <? if($perhitungn_pph->getField("JENIS_PENGHASILAN") == "BONUS_TAHUNAN")  {?> selected <? } ?>>Bonus Tahunan</option>
               </select>
            </td>
        </tr>
        <tr>
            <td>Jenis Perhitungan</td>
            <td>
               <select name="reqJenisPerhitungan" id="reqJenisPerhitungan">
               		<option value="GROSSUP" <? if($perhitungn_pph->getField("JENIS_PERHITUNGAN") == "GROSSUP")  {?> selected <? } ?>>Grossup</option>
               		<option value="PROSENTASE" <? if($perhitungn_pph->getField("JENIS_PERHITUNGAN") == "PROSENTASE")  {?> selected <? } ?>>Prosentase</option>
               </select>
            </td>
        </tr>
        <?
        if($perhitungn_pph->getField("JENIS_PERHITUNGAN") == "PROSENTASE")
			$display = "";
		else
			$display = "style='display:none'";
			
		?>
        <tr id="dispJumlah" <?=$display?>>
            <td>Jumlah</td>
            <td>
              	<select id="tt<?=$i?>" class="easyui-combotree" data-options="onCheck:onCheck<?=$i?>,url:'../json-gaji/pph_kondisi_jenis_pegawai_combo_json.php?reqId=<?=$perhitungn_pph->getField("JUMLAH")?>',onlyLeafCheck:true,checkbox:true,cascadeCheck:true" multiple style="width:300px;"></select>           
              	<input type="hidden" id="idJumlah<?=$i?>" name="reqJumlah" value="<?=$perhitungn_pph->getField("JUMLAH")?>">
				<script>
                    function onCheck<?=$i?>(v){
                        var s = $('#tt<?=$i?>').combotree('getText');
                        document.getElementById('idJumlah<?=$i?>').value = s;
                        }
                </script>    
            </td>
        </tr> 

        <tr id="dispProsentaseNPWP" <?=$display?>>
            <td>Prosentase NPWP</td>
            <td>
              	<input type="text" name="reqProsentaseNpwp" value="<?=$perhitungn_pph->getField("PROSENTASE_NPWP")?>">  
            </td>
        </tr><tr id="dispProsentaseNPWP" <?=$display?>>
            <td>Nilai NPWP</td>
            <td>
              	<input type="text" name="reqNilaiNpwp" value="<?=$perhitungn_pph->getField("JUMLAH_NPWP")?>">  
            </td>
        </tr>
        <tr id="dispProsentaseTanpaNPWP" <?=$display?>>
            <td>Prosentase Tanpa NPWP</td>
            <td>
              	<input type="text" name="reqProsentaseTanpaNpwp" value="<?=$perhitungn_pph->getField("PROSENTASE_TANPA_NPWP")?>">  
            </td>
        </tr>
        </tr><tr id="dispProsentaseNPWP" <?=$display?>>
            <td>Nilai Tanpa NPWP</td>
            <td>
              	<input type="text" name="reqNilaiTanpaNpwp" value="<?=$perhitungn_pph->getField("JUMLAH_TANPA_NPWP")?>">  
            </td>
        </tr>
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