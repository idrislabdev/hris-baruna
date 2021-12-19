<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPengalamanKerja.php");

$pengalaman_kerja = new PegawaiPengalamanKerja();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");

$pengalaman_kerja->selectByParams(array('PEGAWAI_PENGALAMAN_KERJA_ID'=>$reqRowId));
$pengalaman_kerja->firstRow();

$tempRowId		 = $pengalaman_kerja->getField('PEGAWAI_PENGALAMAN_KERJA_ID');
$nama_perusahaan = $pengalaman_kerja->getField('NAMA_PERUSAHAAN');
$jabatan 		 = $pengalaman_kerja->getField('JABATAN');
$mulai_bulan	 = substr($pengalaman_kerja->getField('MASUK_KERJA'), 0, 2);
$mulai_tahun	 = substr($pengalaman_kerja->getField('MASUK_KERJA'), 2, 5);
$selesai_bulan	 = substr($pengalaman_kerja->getField('KELUAR_KERJA'), 0, 2);
$selesai_tahun	 = substr($pengalaman_kerja->getField('KELUAR_KERJA'), 2, 5);
$gaji	 		 = $pengalaman_kerja->getField('GAJI');
$fasilitas_lain	 = $pengalaman_kerja->getField('FASILITAS');

?>
<!DOCTYPE html >
<html>
<head>
	<title>Pengalaman Kerja</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/bluetabs.css" />
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    
    <script type="text/javascript">
		$.fn.datebox.defaults.formatter = function(date) {
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			return (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
		};
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
				url:'../json-simpeg/pegawai_add_cv.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//$.messager.alert(data);
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();	
					parent.frames['mainFramePop'].location.href = 'pegawai_add_cv_monitoring.php?reqId=' + data[0];
					document.location.href = 'pegawai_add_cv.php?reqId=' + data[0] + '&reqRowId=' + data[2];
				}				
			});
		});
		
		
	</script>
    
    <style>
	    .CodeMirror-scroll { height: 100%; overflow-x: auto;}
	</style>
    
</head>
<body >
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah" class="CodeMirror-scroll">
	<div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif); position:fixed; width:100%; margin-top:0px; zIndex: -1'">    
        <ul>
            <li><a href="#" onClick="$('#btnSubmit').click();">Simpan</a></li>
            <li><a href="pegawai_print_cv.php?reqId=<?php echo $reqId; ?>" target="_blank" >Print</a></li>
        <?php
        if($reqRowId == "") {}
		else
		{
		?>
            <li>
            <a href="pegawai_add_cv.php?reqId=<?=$reqId?>">Batal</a>
            </li>        
        <?
		}
		?>
        </ul>
    </div>
    <form id="ff" method="post" novalidate style="margin-top:20px;">
    <table>
    	<tr style="height:5px;"></tr>
        <tr>
        	<td>Nama Perusahaan</td>
            <td>
                <input id="nama_perusahaan" name="nama_perusahaan"  size="60" required value="<?=$nama_perusahaan?>"></input>
            </td>
        </tr>
        <tr>
        	<td>Jabatan</td>
            <td>
                <input id="jabatan" name="jabatan" required  size="40" value="<?=$jabatan?>"></input>
            </td>
        </tr>
        <tr>
        	<td>Mulai Kerja</td>
            <td>
                <select id="mulai_bulan" name="mulai_bulan">
                	<option value="01" <?php echo ($mulai_bulan == '01') ? 'selected': ''; ?> >Januari</option>
                	<option value="02" <?php echo ($mulai_bulan == '02') ? 'selected': ''; ?> >Februari</option>
                	<option value="03" <?php echo ($mulai_bulan == '03') ? 'selected': ''; ?> >Maret</option>
                	<option value="04" <?php echo ($mulai_bulan == '04') ? 'selected': ''; ?> >April</option>
                	<option value="05" <?php echo ($mulai_bulan == '05') ? 'selected': ''; ?> >Mei</option>
                	<option value="06" <?php echo ($mulai_bulan == '06') ? 'selected': ''; ?> >Juni</option>
                	<option value="07" <?php echo ($mulai_bulan == '07') ? 'selected': ''; ?> >Juli</option>
                	<option value="08" <?php echo ($mulai_bulan == '08') ? 'selected': ''; ?> >Agustus</option>
                	<option value="09" <?php echo ($mulai_bulan == '09') ? 'selected': ''; ?> >September</option>
                	<option value="10" <?php echo ($mulai_bulan == '10') ? 'selected': ''; ?> >Oktober</option>
                	<option value="11" <?php echo ($mulai_bulan == '11') ? 'selected': ''; ?> >November</option>
                	<option value="12" <?php echo ($mulai_bulan == '12') ? 'selected': ''; ?> >Desember</option>
                </select>
                &nbsp; 
                <select id="mulai_tahun" name="mulai_tahun" >
                	<?php
                	for($i=date('Y'); $i >= 1945 ; $i--){
                		$selekted = ($mulai_tahun == $i) ? ' selected="selected" ': '';
                		echo '<option '.$selekted.' >'. $i .'</option>';
                	}
                	?>
                </select>
            </td>
        </tr>
		<tr>
        	<td>Selesai Kerja</td>
            <td>
                <select id="selesai_bulan" name="selesai_bulan" >
                	<option value="01" <?php echo ($selesai_bulan == '01') ? 'selected': ''; ?> >Januari</option>
                	<option value="02" <?php echo ($selesai_bulan == '02') ? 'selected': ''; ?> >Februari</option>
                	<option value="03" <?php echo ($selesai_bulan == '03') ? 'selected': ''; ?> >Maret</option>
                	<option value="04" <?php echo ($selesai_bulan == '04') ? 'selected': ''; ?> >April</option>
                	<option value="05" <?php echo ($selesai_bulan == '05') ? 'selected': ''; ?> >Mei</option>
                	<option value="06" <?php echo ($selesai_bulan == '06') ? 'selected': ''; ?> >Juni</option>
                	<option value="07" <?php echo ($selesai_bulan == '07') ? 'selected': ''; ?> >Juli</option>
                	<option value="08" <?php echo ($selesai_bulan == '08') ? 'selected': ''; ?> >Agustus</option>
                	<option value="09" <?php echo ($selesai_bulan == '09') ? 'selected': ''; ?> >September</option>
                	<option value="10" <?php echo ($selesai_bulan == '10') ? 'selected': ''; ?> >Oktober</option>
                	<option value="11" <?php echo ($selesai_bulan == '11') ? 'selected': ''; ?> >November</option>
                	<option value="12" <?php echo ($selesai_bulan == '12') ? 'selected': ''; ?> >Desember</option>
                </select>
                &nbsp; 
                <select id="selesai_tahun" name="selesai_tahun" >
                	<?php
                	for($i=date('Y'); $i >= 1945 ; $i--){
                		$selekted = ($selesai_tahun == $i) ? ' selected="selected" ': '';
                		echo '<option '.$selekted.' >'. $i .'</option>';
                	}
                	?>
                </select>
            </td>
        </tr>
        <tr>
        	<td>Gaji yang diterima</td>
            <td>
                <input id="gaji" name="gaji" required  size="20" value="<?=$gaji?>"></input>
            </td>
        </tr>
        <tr>
            <td>Fasilitas lain</td>
            <td>
                <input name="fasilitas_lain" id="fasilitas_lain" size="60" type="text" value="<?=$fasilitas_lain?>" />
            </td>
        </tr>
        
    </table>
        <div style="display:none">
        	<? if($tempRowId == ''){ $reqMode='insert'; }else{ $reqMode='update'; }?>
            <input type="hidden" name="reqRowId" value="<?=$tempRowId?>">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>