<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPenghasilan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_penghasilan = new PegawaiPenghasilan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId = httpFilterPost("reqRowId");

$reqTMTPenghasilan= httpFilterPost("reqTMTPenghasilan");
$reqPeriode= httpFilterPost("reqPeriode");
$reqKelas= httpFilterPost("reqKelas");
$reqNoSK= httpFilterPost("reqNoSK");
$reqTanggal= httpFilterPost("reqTanggal");
$reqPejabat= httpFilterPost("reqPejabat");
$reqTahun= httpFilterPost("reqTahun");
$reqBulan= httpFilterPost("reqBulan");
$reqJumlahPenghasilan= httpFilterPost("reqJumlahPenghasilan");
$reqJumlahTPP= httpFilterPost("reqJumlahTPP");
$reqJumlahTunjanganJabatan= httpFilterPost("reqJumlahTunjanganJabatan");
$reqJumlahTunjanganSelisih= httpFilterPost("reqJumlahTunjanganSelisih");
$reqJumlahTransportasi= httpFilterPost("reqJumlahTransportasi");
$reqJumlahUangMakan= httpFilterPost("reqJumlahUangMakan");
$reqJumlahInsentif= httpFilterPost("reqJumlahInsentif");
$reqProsentasePenghasilan= httpFilterPost("reqProsentasePenghasilan");
$reqProsentaseTunjanganJabatan= httpFilterPost("reqProsentaseTunjanganJabatan");

$reqProsentaseUangMakan= httpFilterPost("reqProsentaseUangMakan");
$reqProsentaseTransportasi= httpFilterPost("reqProsentaseTransportasi");
$reqProsentaseInsentif= httpFilterPost("reqProsentaseInsentif");

$reqJumlahUangKehadiran= httpFilterPost("reqJumlahUangKehadiran");
$reqProsentaseUangKehadiran= httpFilterPost("reqProsentaseUangKehadiran");
$reqProsentaseTPP= httpFilterPost("reqProsentaseTPP");

$reqKelasP3= httpFilterPost("reqKelasP3");
$reqPeriodeP3= httpFilterPost("reqPeriodeP3");
$reqJumlahP3= httpFilterPost("reqJumlahP3");

$reqJumlahMobilitas= httpFilterPost("reqJumlahMobilitas");
$reqProsentaseMobilitas = httpFilterPost("reqProsentaseMobilitas");
$reqJumlahPerumahan = httpFilterPost("reqJumlahPerumahan");
$reqProsentasePerumahan = httpFilterPost("reqProsentasePerumahan");
$reqJumlahBBM = httpFilterPost("reqJumlahBBM");
$reqProsentaseBBM = httpFilterPost("reqProsentaseBBM");
$reqJumlahTelepon = httpFilterPost("reqJumlahTelepon");
$reqProsentaseTelepon = httpFilterPost("reqProsentaseTelepon");

$pegawai_penghasilan->setField('PROSENTASE_TPP', $reqProsentaseTPP);

$pegawai_penghasilan->setField('JUMLAH_P3', setNULL(dotToNo($reqJumlahP3)));
$pegawai_penghasilan->setField('KELAS_P3', setNULL($reqKelasP3));
$pegawai_penghasilan->setField('PERIODE_P3', setNULL($reqPeriodeP3));

$pegawai_penghasilan->setField('KELAS', $reqKelas);
$pegawai_penghasilan->setField('TMT_PENGHASILAN', dateToDBCheck($reqTMTPenghasilan));
$pegawai_penghasilan->setField('PERIODE', $reqPeriode);
$pegawai_penghasilan->setField('NO_SK', $reqNoSK);
$pegawai_penghasilan->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
$pegawai_penghasilan->setField('PEJABAT_PENETAP_ID', $reqPejabat);
$pegawai_penghasilan->setField('MASA_KERJA_TAHUN', $reqTahun);
$pegawai_penghasilan->setField('MASA_KERJA_BULAN', $reqBulan);
$pegawai_penghasilan->setField('JUMLAH_PENGHASILAN', dotToNo($reqJumlahPenghasilan));
$pegawai_penghasilan->setField('JUMLAH_TPP', dotToNo($reqJumlahTPP));
$pegawai_penghasilan->setField('JUMLAH_TUNJANGAN_JABATAN', dotToNo($reqJumlahTunjanganJabatan));
$pegawai_penghasilan->setField('JUMLAH_TUNJANGAN_SELISIH', dotToNo($reqJumlahTunjanganSelisih));
$pegawai_penghasilan->setField('JUMLAH_TRANSPORTASI', dotToNo($reqJumlahTransportasi));
$pegawai_penghasilan->setField('JUMLAH_UANG_MAKAN', dotToNo($reqJumlahUangMakan));
$pegawai_penghasilan->setField('JUMLAH_INSENTIF', dotToNo($reqJumlahInsentif));
$pegawai_penghasilan->setField('PROSENTASE_PENGHASILAN', $reqProsentasePenghasilan);
$pegawai_penghasilan->setField('PROSENTASE_TUNJANGAN_JABATAN', $reqProsentaseTunjanganJabatan);

$pegawai_penghasilan->setField('PROSENTASE_UANG_MAKAN', $reqProsentaseUangMakan);
$pegawai_penghasilan->setField('PROSENTASE_TRANSPORTASI', $reqProsentaseTransportasi);
$pegawai_penghasilan->setField('PROSENTASE_INSENTIF', $reqProsentaseInsentif);

$pegawai_penghasilan->setField('JUMLAH_UANG_KEHADIRAN', dotToNo($reqJumlahUangKehadiran));
$pegawai_penghasilan->setField('PROSENTASE_UANG_KEHADIRAN', $reqProsentaseUangKehadiran);

$pegawai_penghasilan->setField('PEGAWAI_PENGHASILAN_ID', $reqRowId);
$pegawai_penghasilan->setField('PEGAWAI_ID', $reqId);

$pegawai_penghasilan->setField('JUMLAH_MOBILITAS', dotToNo($reqJumlahMobilitas));
$pegawai_penghasilan->setField('PROSENTASE_MOBILITAS', $reqProsentaseMobilitas);
$pegawai_penghasilan->setField('JUMLAH_PERUMAHAN',  dotToNo($reqJumlahPerumahan));
$pegawai_penghasilan->setField('PROSENTASE_PERUMAHAN', $reqProsentasePerumahan);
$pegawai_penghasilan->setField('JUMLAH_BBM', dotToNo($reqJumlahBBM));
$pegawai_penghasilan->setField('PROSENTASE_BBM', $reqProsentaseBBM);
$pegawai_penghasilan->setField('JUMLAH_TELEPON', dotToNo($reqJumlahTelepon));
$pegawai_penghasilan->setField('PROSENTASE_TELEPON', $reqProsentaseTelepon);
$pegawai_penghasilan->setField('KETERANGAN_PERUBAHAN', 'Kenaikan Periodik');


if($reqMode == "insert")
{
	$pegawai_penghasilan->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_penghasilan->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
	if($pegawai_penghasilan->insert()){
		$reqRowId= $pegawai_penghasilan->id;
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_penghasilan->query;
}
else
{
	$pegawai_penghasilan->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai_penghasilan->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
	if($pegawai_penghasilan->update()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_penghasilan->query;
}
?>