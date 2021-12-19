<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiKoreksi.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiRekap.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base-operasional/Kapal.php");
include_once("../WEB-INF/classes/base-operasional/Lokasi.php");

$reqId = httpFilterGet("reqId");
$reqBulan = httpFilterGet("reqBulan");
$reqTahun = httpFilterGet("reqTahun");

$pegawai = new Pegawai();
$pegawai->selectByParams(array("A.PEGAWAI_ID" => $reqId));
$pegawai->firstRow();

$abs = new AbsensiKoreksi();
$abs->selectByParamsNew(array("A.PEGAWAI_ID"=>$reqId, "TO_CHAR(A.TGL_ABSEN, 'MMYYYY')"=>$reqBulan . $reqTahun));
$dataAbsen = array();
while($abs->nextRow()){
	$absHari = array(
		'TGL_ABSEN' => $abs->getField("TGL_ABSEN"),
		'PEGAWAI_ID' => $abs->getField("PEGAWAI_ID"),
		'KELOMPOK' => $abs->getField("KELOMPOK"),
		'KAPAL_ID' => $abs->getField("KAPAL_ID"),
		'LOKASI' => $abs->getField("LOKASI"),
		'TOTAL' => $abs->getField("TOTAL")
	);
	$dataAbsen[] = $absHari;
}
$kapal = new Kapal();
$kapal->selectByParamsKapal(null);
$dataKapal = array();
while($kapal->nextRow()){
	$idk= array('KAPAL_ID'=>$kapal->getField("KAPAL_ID"), 'NAMA'=>$kapal->getField("NAMA"));
	$dataKapal[] = $idk;
}

$lokasi = new Lokasi();
$lokasi->selectByParams(null);
$dataLokasi = array();
while($lokasi->nextRow()){
	$idl= array('LOKASI_ID'=>$lokasi->getField("LOKASI_ID"), 'NAMA'=>$lokasi->getField("NAMA"));
	$dataLokasi[] = $idl;
}


?>
<!DOCTYPE html >
<html>
<head>
	<title>Absensi</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="../WEB-INF/lib/colorpicker/js/jquery/jquery.js"></script>	
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/treeTable/doc/javascripts/jquery.ui.js"></script>
    <link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/treeTable/src/javascripts/jquery.treeTable.js"></script>
	<script type="text/javascript">
		$(function(){
			$('a.tblSimpan').click(function(){
				var id = $(this).attr('id');
				var idPeg = $('#pegawai_' + id).val();
				var mode = $('#mode_' + id).val();
				var kelompok = $('#pilKelompok_' + id).val();
				var kapal = $('#pilKapal_' + id).val();
				var posisi = $('#pilPosisi_' + id).val();
				var total = $('#pilTotal_' + id).val();
				$.post(
					"../json-absensi/kalkulasi_absensi_edit_json.php",
					{mode:mode, tgl:id, pegawai:idPeg, kelompok:kelompok, kapal:kapal, posisi:posisi, total:total},
					function(data,status){
				    $.messager.alert('Info', data, 'info');
				    top.frames['mainFrame'].location.reload();
			    });
			});
		});
	</script>
    
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css" >
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
		<span><img src="../WEB-INF/images/panah-judul.png"> Tambah Koreksi Absen</span>
	</div>
    
    <div class="data-foto-table">
        <div class="data-foto">
            <div class="data-foto-img">
                <img src="../simpeg/image_script.php?reqPegawaiId=<?=$reqId?>&reqMode=pegawai" width="60" height="77">
            </div>
            
            <div class="data-foto-ket">
            	<div style="color:#000; font-size:18px;"><?=$pegawai->getField("NAMA")?> (<?=$pegawai->getField("NRP")?>)</div>     
                    <div style="color:#000; font-size:16px; line-height:20px;">Hari Kerja : <?=$reqKelompok?></div>
                    <div style="color:#000; font-size:16px; line-height:20px;">Periode : <?php echo date('F', strtotime($reqTahun . '-' . $reqBulan . '-01')) . "&nbsp;" . $reqTahun?></div>
            </div>
    
        </div>
        
        <div class="data-table">
    		<style type="text/css">
				.divMulyo {margin:0;}
				.tabelMulyo {width:100%; border-collapse: collapse; margin:10px 0; }
				.tabelMulyo tr th {border:1px solid #000; border-collapse: collapse; margin:0; padding: 5px; background: #fff}
				.tabelMulyo tr td {border:1px solid #000; border-collapse: collapse; margin:0; padding: 5px;}
				.selekMulyo {padding:5px 10px; min-width: 190px}
				.linkMulyo {text-decoration: none; font-size:14px;}
				.linkMulyo:hover {text-decoration: underline;}
			</style>
			<div class="divMulyo">
				<table class="tabelMulyo">
				<thead class="altrowstable">
					<tr>
						<th>Tanggal</th>
						<th>Kelompok</th>
						<th>Kapal</th>
						<th>Lokasi</th>
						<th>Total</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php 
					for($i=1; $i<= date('t', strtotime($reqTahun . '-' . $reqBulan . '-01')); $i++){
						$tgl = '0' . $i;
						$tgl = substr($tgl, -2) . '-' . $reqBulan . '-' . $reqTahun;
						$absenHariIni = '';
						for($j=0; $j< count($dataAbsen); $j++){
							if($dataAbsen[$j]['TGL_ABSEN'] == $tgl) {
								$absenHariIni = $dataAbsen[$j];
								break;
							}
						}
						$ketMode = ($absenHariIni != '') ? 'update' : 'insert';
						$pilihanKelompok = '<select class="selekMulyo" name="pilKelompok" id="pilKelompok_'. $tgl .'">';
							if($absenHariIni != '' AND $absenHariIni['KELOMPOK'] == 'D') $pilihanKelompok .= '<option value="D" selected>Darat</option>'; else  $pilihanKelompok .= '<option value="D" >Darat</option>';
							if($absenHariIni != '' AND $absenHariIni['KELOMPOK'] == 'K') $pilihanKelompok .= '<option value="K" selected>Kapal</option>'; else  $pilihanKelompok .= '<option value="K" >Kapal</option>';
						$pilihanKelompok .= '</select>';
		
						$pilihanKapal = '<select class="selekMulyo" name="pilKapal" id="pilKapal_'. $tgl .'">';
							$pilihanKapal .= '<option value="" ></option>';
							for($k=0; $k<count($dataKapal); $k++){
								$selek = ($absenHariIni != '' AND $dataKapal[$k]['KAPAL_ID'] == $absenHariIni['KAPAL_ID']) ? 'selected' : '';
								$pilihanKapal .=  '<option value="'. $dataKapal[$k]['KAPAL_ID'] .'" '. $selek .' >'.  $dataKapal[$k]['NAMA'] .'</option>';
							}
						$pilihanKapal .= '</select>';
		
						$pilihanPosisi = '<select class="selekMulyo" name="pilPosisi" id="pilPosisi_'. $tgl .'">';
							$pilihanPosisi .= '<option value="" ></option>';
							for($l=0; $l<count($dataLokasi); $l++){
								$selek = ($absenHariIni != '' AND $dataLokasi[$l]['LOKASI_ID'] == $absenHariIni['LOKASI']) ? 'selected' : '';
								$pilihanPosisi .=  '<option value="'. $dataLokasi[$l]['LOKASI_ID'] .'" '. $selek .' >'.  $dataLokasi[$l]['NAMA'] .'</option>';
							}
						$pilihanPosisi .= '</select>';
		
						$pilihanTotal = '<select class="selekMulyo" name="pilTotal" id="pilTotal_'. $tgl .'">';
							$pilihanTotal .= '<option value="" ></option>';
							if($absenHariIni != '' AND $absenHariIni['TOTAL'] == '0') $pilihanTotal .= '<option value="0" selected>0</option>'; else  $pilihanTotal .= '<option value="0" >0</option>';
							if($absenHariIni != '' AND ($absenHariIni['TOTAL'] == ',5' OR $absenHariIni['TOTAL'] == '.5')) $pilihanTotal .= '<option value="0.5" selected>0.5</option>'; else  $pilihanTotal .= '<option value="0.5" >0.5</option>';
							if($absenHariIni != '' AND $absenHariIni['TOTAL'] == '1') $pilihanTotal .= '<option value="1" selected>1</option>'; else  $pilihanTotal .= '<option value="1" >1</option>';
						$pilihanTotal .= '</select>';
						echo '<input type="hidden" id="mode_'. $tgl .'" value="'. $ketMode .'" />
						<input type="hidden" id="pegawai_'. $tgl .'" value="'. $reqId .'" />
						<tr>
							<td>'. $tgl .'</td>
							<td>'. $pilihanKelompok .'</td>
							<td>'. $pilihanKapal .'</td>
							<td>'. $pilihanPosisi .'</td>
							<td>'. $pilihanTotal .'</td>
							<td><a href="#" class="linkMulyo tblSimpan" id="'. $tgl .'" >Simpan</a></td>
						</tr>
						';
					}
				 ?>
				</tbody>
				</table>
			</div><!-- end tabel -->
			
    	</div>
    </div><!-- END DATA FOTO TABLE -->
    
    
        <?php /*?><div style="float:right; margin-right:20px; margin-top:-20px;">
            <div style="margin-top:28px; width:400px; margin-left:5px; float:left; position:relative; text-align:left;">
                <div style="border:2px solid #FFF; float:left; margin-right:4px; height:77px; width:60px; -webkit-box-shadow: 0 8px 6px -6px black; -moz-box-shadow: 0 8px 6px -6px black; box-shadow: 0 8px 6px -6px black;">
                    
                </div>
                <div style="float:left; position:relative; width:300px;"> 
                    
                </div>
        	</div>
 	    </div>	<?php */?>
    <!--</div>-->
    
</div>
</body>
</html>