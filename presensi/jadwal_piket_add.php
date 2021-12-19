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
include_once("../WEB-INF/classes/base-absensi/DaftarJagaPiket.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

ini_set("memory_limit","500M");
ini_set("max_execution_time", 520);

if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

/* create objects */
$reqPeriode = httpFilterGet("reqPeriode");
$reqDepartemenId= httpFilterGet("reqDepartemenId");
$reqMode= httpFilterGet("reqMode");
$reqPeriodeTemp = $reqPeriode;
/* create objects */

$orangPiket = new DaftarJagaPiket();
$orangPiket->selectDaftarJaga(array("A.DEPARTEMEN_ID" => $reqDepartemenId, "TO_CHAR(TANGGAL, 'MMYYYY')" => $reqPeriode));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Add jadwal Piket</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/treeTable/doc/javascripts/jquery.ui.js"></script>
    <link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/treeTable/src/javascripts/jquery.treeTable.js"></script>
    <script type="text/javascript">
		$.fn.datebox.defaults.formatter = function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
		}
		
		$.fn.datebox.defaults.parser = function(s) {
			if (s) {
				var a = s.split('-');
				var d = new Number(a[0]);
				var m = new Number(a[1]);
				var y = new Number(a[2]);
				var dd = new Date(y, m-1, d);
				return dd;
			} 
			else 
			{
				return new Date();
			}
		};	
		$(function(){
			$('#ff').form({
				url:'../json-absensi/jadwal_piket_add.php',
				onSubmit:function(){
					//console.log('error disini');
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					top.frames['mainFrame'].location.reload();				
				}
			});
		});
		
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
	      $($(this).parents("tr")).droppable({
	        accept: ".file, .folder",
	        drop: function(e, ui) { 
	          $($(ui.draggable).parents("tr")).appendBranchTo(this);
	          
	          // Issue a POST call to send the new location (this) of the 
	          // node (ui.draggable) to the server.
	          $.post("move.php", {id: $(ui.draggable).parents("tr").id, to: this.id});
	        },
	        hoverClass: "accept",
	        over: function(e, ui) {
	          if(this.id != $(ui.draggable.parents("tr.parent")).id && !$(this).is(".expanded")) {
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
	      $($(this).parents("tr")).trigger("mousedown");
	    });
	    $('#tombol_tambah').click(function(){
	    	var temp = $('#reqDepartemenId').val();
	    	if(temp == '') {alert('Anda belum memilih departemen!' + temp);}
	    	else {addRow();} // fungsi untuk menambah baris filenya di jadwal_piket.js
	    });
	    
    });
		
    </script>
	<script type="text/javascript" src="../absensi/js/jadwal_piket.js"></script>
	<style type="text/css">input[type="checkbox"] {margin:0 1px;}</style>
</head> 
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Daftar Piket</span>
</div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Periode</td>
            <td>
            <?php
			if ($reqPeriode == "") { 
				$reqPeriode = "01-".date("m")."-".date("Y");
				$days=cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y"));  
			} else {
				$reqPeriode = "01-".substr($reqPeriode,0,2)."-".substr($reqPeriode,2);
				$days=cal_days_in_month(CAL_GREGORIAN,substr($reqPeriode,0,2),substr($reqPeriode,2));  
			}
			 ?>
        	<input id="reqPeriodeEntri" name="reqPeriodeEntri" class="easyui-datebox" value="<?=$reqPeriode?>" data-options="validType:'date'" style="width:100px ! important; " />
            </td>
        </tr>
        <tr>
            <td>Departemen</td>
            <td>
            	<input id="reqDepartemenCombo" name="reqDepartemenCombo" class="easyui-combotree" data-options="
                required: true,
                filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                valueField: 'id', textField: 'text',
                url: '../json-simpeg/departemen_combo_json.php',
                onSelect:function(rec){
                	$('#reqDepartemenId').val(rec.id);
                }
                "
                value="<?=$reqDepartemenId?>" style="width:408px ! important; " />
            </td>
        </tr>
        
    </table>
    
    <table style="width:2500px" class="example" id="dataTableRowDinamis" border="1" >
    <thead class="altrowstable">
     	<tr>
			<th style="padding: .3em 0.5em .1em;">
				No
				<a style="cursor:pointer" title="Tambah Pegawai" id="tombol_tambah"><img src="../WEB-INF/images/icn_add.gif" width="16" height="16" border="0" /></a>
			</th>
			<th style="padding: .3em 0.5em .1em; width:323px">Pegawai</th>
			<th style="padding: .3em 0.5em .1em;">Tgl 1</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 2</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 3</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 4</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 5</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 6</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 7</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 8</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 9</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 10</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 11</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 12</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 13</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 14</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 15</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 16</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 17</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 18</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 19</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 20</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 21</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 22</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 23</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 24</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 25</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 26</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 27</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 28</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 29</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 30</th> 	
			<th style="padding: .3em 0.5em .1em;">Tgl 31</th> 	
			<th style="padding: .3em 0.5em .1em;"></th> 	
		</tr>
	</thead>
		<tbody class="example altrowstable" id="alternatecolor"> 
			<?php
			  $no=1; $scrip_chek='';
			  $baris = 0;
			  while($orangPiket->nextRow()) {
			  		$jadwal_piket = new DaftarJagaPiket();
					$jadwal_piket->selectByParamsWithTanggal(array("A.DEPARTEMEN_ID" => $reqDepartemenId, "TO_CHAR(TANGGAL, 'MMYYYY')" => $reqPeriodeTemp, "A.PEGAWAI_ID"=>$orangPiket->getField("PEGAWAI_ID")),-1,-1,""," ORDER BY TANGGAL, PIKET_ID ");
				  	echo '<tr id="deleteRow'. $baris .'" >';
				  	echo '<td align="center">'. $no .'</td>';
				  	echo '<td >'. $orangPiket->getField("PEGAWAI");
				  	echo '<input type="hidden" name="pegawaiId[]" value="'. $orangPiket->getField("PEGAWAI_ID") .'" ></td>';
				  	
				  	for ($i=1; $i<=$days; $i++) { 
				  		echo '<td>
							<input type="checkbox" name="shift1_tgl'. $i .'_row'.$baris.'" id="shift1_tgl'. $i .'_row'.$baris.'" >
							<input type="checkbox" name="shift2_tgl'. $i .'_row'.$baris.'" id="shift2_tgl'. $i .'_row'.$baris.'" >
							<input type="checkbox" name="shift3_tgl'. $i .'_row'.$baris.'" id="shift3_tgl'. $i .'_row'.$baris.'" >
				  		</td>';
					   	
				    }
				    echo '<td><center></a>&nbsp;&nbsp;&nbsp;&nbsp;<a style="cursor:pointer;" onclick="deleteRowDrawTablePhp(\'dataTableRowDinamis\', \'deleteRow'. $baris .'\')"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a></center></td>';
				    echo '</tr>';
					$no++;	
				    while($jadwal_piket->nextRow()){
				    	for ($j=1; $j<=$days; $j++) { 
				    		$tglku = substr("0" . $j, -2) .substr($reqPeriodeTemp,0,2). substr($reqPeriodeTemp,2);
					    	if ($orangPiket->getField("PEGAWAI_ID") == $jadwal_piket->getField("PEGAWAI_ID") AND $tglku == $jadwal_piket->getField("TANGGAL_BANDING") AND strpos($jadwal_piket->getField("SHIFT"), "1")!== false) {
								$scrip_chek .= "$('#shift1_tgl". $j ."_row".$baris."').prop('checked', true );";
							}
							if ($orangPiket->getField("PEGAWAI_ID") == $jadwal_piket->getField("PEGAWAI_ID") AND $tglku == $jadwal_piket->getField("TANGGAL_BANDING") AND strpos($jadwal_piket->getField("SHIFT"), "2")!== false) {
								$scrip_chek .= "$('#shift2_tgl". $j ."_row".$baris."').prop('checked', true );";
							}
							if ($orangPiket->getField("PEGAWAI_ID") == $jadwal_piket->getField("PEGAWAI_ID") AND $tglku == $jadwal_piket->getField("TANGGAL_BANDING") AND strpos($jadwal_piket->getField("SHIFT"), "3")!== false) {
								$scrip_chek .= "$('#shift3_tgl". $j ."_row".$baris."').prop('checked', true );";
							}
						}
				    }
					unset($jadwal_piket);
					$baris++;
			   } 
			   ?>
	    </tbody>
	</table>
	<script type='text/javascript'>
	   	function show_checked() {
       		<?php echo $scrip_chek;?>
	   	}
	   	show_checked();
	</script>
	<input type="hidden" name="reqDepartemenId" id="reqDepartemenId" value="<?php echo $reqDepartemenId; ?>">
	<input type="hidden" name="reqTotalEntri" id="reqTotalEntri" value="<?php echo ($baris); ?>">
    <input type="submit" value="Submit">
    <input type="reset" id="rst_form">
    </div>
	</form>
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