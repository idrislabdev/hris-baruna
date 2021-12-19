<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikan.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiSertifikat.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiKeluarga.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPengalamanKerja.php");

$reqId = httpFilterRequest("reqId");
$pegawai = new Pegawai();
$pegawai_pendidikan = new PegawaiPendidikan();
$pegawai_sertifikat = new PegawaiSertifikat();
$pegawai_keluarga = new PegawaiKeluarga();
$pengalaman_kerja = new PegawaiPengalamanKerja();

$pegawai->selectByParams(array("A.PEGAWAI_ID" => $reqId));
$pegawai->firstRow();

$pegawai_pendidikan->selectByParams(array("PEGAWAI_ID" => $reqId));
$pegawai_sertifikat->selectByParams(array('PEGAWAI_ID'=>$reqId));
$pegawai_keluarga->selectByParams(array("PEGAWAI_ID" => $reqId));
$pengalaman_kerja->selectByParams(array('PEGAWAI_ID'=>$reqId));


?>
<!DOCTYPE html >
<html>
<head>
	<title>Pengalaman Kerja</title>
    <link href="css/print_css.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
    window.onload = function(){
    	window.print();
    }
    </script>
</head>
<body>
<div class="container">
	<h1 class="judul_atas">BIODATA PEGAWAI</h1>
	<table >
		<tbody>
			<tr><td style="width:200px;">NAMA</td><td class="padding_all">:</td><td><?php echo $pegawai->getField('NAMA'); ?></td></tr>
			<tr class="odd"><td>TEMPAT / TGL LAHIR</td><td class="padding_all">:</td><td><?php echo $pegawai->getField('TEMPAT_LAHIR') . ' / ' . $pegawai->getField('TANGGAL_LAHIR_TEK'); ?></td></tr>
			<tr ><td>ALAMAT</td><td class="padding_all">:</td><td><?php echo $pegawai->getField('ALAMAT'); ?></td></tr>
			<tr class="odd"><td>AGAMA</td><td class="padding_all">:</td><td><?php echo $pegawai->getField('AGAMA_NAMA'); ?></td></tr>
			<tr ><td>JENIS KELAMIN</td><td class="padding_all">:</td><td><?php echo $pegawai->getField('JENIS_KELAMIN'); ?></td></tr>
			<tr class="odd"><td>STATUS PERNIKAHAN</td><td class="padding_all">:</td><td><?php echo $pegawai->getField('STATUS_KAWIN'); ?></td></tr>
			<tr ><td>PENDIDIKAN TERAKHIR</td><td class="padding_all">:</td><td><?php echo $pegawai->getField('PENDIDIKAN_TERAKHIR'); ?></td></tr>
			<tr ><td>NO TELP AKTIF</td><td class="padding_all">:</td><td><?php echo $pegawai->getField('TELEPON'); ?></td></tr>
		</tbody>
	</table>

	<br>
	<H2>I. &nbsp; &nbsp;RIWAYAT PENDIDIKAN FORMAL</H2>
	<?php 
		$i = 0;
		while($pegawai_pendidikan->nextRow()){
			$i++;
			if($i == 1) echo '<table class="tabel_border"><tbody><tr class="tengah"><td class="no" >NO</td><td>PENDIDIKAN</td><td>NAMA SEKOLAH</td><td>LULUS TAHUN</td></tr>';
			echo '<tr><td class="no">'. $i .'.</td>
			<td>'. $pegawai_pendidikan->getField("PENDIDIKAN_NAMA").'</td>
			<td>'. $pegawai_pendidikan->getField("NAMA").'</td>
			<td>'. $pegawai_pendidikan->getField("LULUS").'</td>
			</tr>';
		}
		if($i == 0) echo '<p>Belum ada data !</p>';
      	else echo '</tbody></table>';
	?>

	<br>
	<H2>II. &nbsp; SERTIFIKAT KETERAMPILAN YANG DIMILIKI</H2>
	<?php 
		$i = 0;
		while($pegawai_sertifikat->nextRow()){
			$i++;
			if($i == 1) echo '<table class="tabel_border"><tbody><tr class="tengah"><td class="no" >NO</td><td >NAMA SERTIFIKAT</td><td style="width:40%">TANGGAL PELAKSANAAN</td></tr>';
			echo '<tr><td class="no">'. $i .'.</td>
			<td>'. $pegawai_sertifikat->getField("NAMA").'</td>
			<td>'. $pegawai_sertifikat->getField("TANGGAL_TERBIT_TEK").'</td></tr>';
		}
      	if($i == 0) echo '<p>Belum ada data !</p>';
      	else echo '</tbody></table>';
	?>

	<br>
	<H2>III. &nbsp;DATA KELUARGA</H2>
	<?php 
		$i = 0;
		while($pegawai_keluarga->nextRow()){
			$i++;
			if($i == 1) echo '<table class="tabel_border"><tbody><tr class="tengah"><td class="no" >NO</td><td >NAMA</td><td>JENIS KELAMIN</td><td>TEMPAT/ TANGGAL LAHIR</td><td>PENDIDIKAN TERAKHIR</td><td>HUBUNGAN KELUARGA</td></tr>';
			echo '<tr><td class="no">'. $i .'.</td>
				<td>'. $pegawai_keluarga->getField("NAMA").'</td>
				<td>'. $pegawai_keluarga->getField("JENIS_KELAMIN").'</td>
				<td>'. $pegawai_keluarga->getField("TEMPAT_LAHIR").' / '. $pegawai_keluarga->getField("TANGGAL_LAHIR_TEK").'</td>
				<td>'. $pegawai_keluarga->getField("PENDIDIKAN_NAMA").'</td>
				<td>'. $pegawai_keluarga->getField("HUBUNGAN_KELUARGA_NAMA").'</td></tr>';
		}
		if($i == 0) echo '<p>Belum ada data !</p>';
		else echo '</tbody></table>';
	?>

	<br>
	<H2>IV. &nbsp;RIWAYAT PENGALAMAN KERJA SEBELUM DI PT PELINDO MARINE SERVICE</H2>
	<table >
		<tbody>
		<?php 
		$i = 0;
		while($pengalaman_kerja->nextRow()) {
			$i++;
			echo '
			<tr><td class="padding_right">'. $i .'. </td><td>NAMA PERUSAHAAN</td><td class="padding_all">:</td><td>'. $pengalaman_kerja->getField('NAMA_PERUSAHAAN') .'</td></tr>
			<tr><td ></td><td>JABATAN</td><td class="padding_all">:</td><td>'. $pengalaman_kerja->getField('JABATAN') .'</td></tr>
			<tr><td ></td><td>MULAI (BULAN / TAHUN)</td><td class="padding_all">:</td><td>'. $pengalaman_kerja->getField('MASUK_KERJA_TEK') .'</td></tr>
			<tr><td ></td><td>SELESAI (BULAN / TAHUN)</td><td class="padding_all">:</td><td>'. $pengalaman_kerja->getField('KELUAR_KERJA_TEK') .'</td></tr>
			<tr><td ></td><td>PENGHASILAN YANG DITERIMA PER BULAN</td><td class="padding_all">:</td><td>'. number_format($pengalaman_kerja->getField('GAJI'), 0, '.', '.') .'</td></tr>
			<tr><td ></td><td>FASILITAS LAIN YANG DITERIMA</td><td class="padding_all">:</td><td>'. $pengalaman_kerja->getField('FASILITAS') .'</td></tr>
			<tr style="height:5px"></tr>
			';
		}
		if($i == 0) echo '<tr><td>Belum ada data !</td></tr>';
		?>			
		</tbody>
	</table>
</div>
</body>
</html>