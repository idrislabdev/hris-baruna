<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiKeluarga.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

include "../operasional/excel/excel_reader2.php";

$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);
$pegawai_keluarga = new PegawaiKeluarga();
$pegawai = new Pegawai();

$reqId = httpFilterPost("reqId");
//$reqPeriode = httpFilterPost("reqPeriode");
//$reqLokasi = httpFilterPost("reqLokasi");

$bulan = substr($reqPeriode, 0,2);
$tahun = substr($reqPeriode, 2,4);
$date=$tahun.'-'.$bulan;
$reqTanggalAwal= dateToPageCheck($tahun.'-'.$bulan.'-01');
$reqTanggalAkhir= dateToPageCheck(date("Y-m-t",strtotime($date)));

$baris = $data->rowcount($sheet_index=0);

//$check = $pegawai_keluarga->getCountByParamsKapalProduksi(array("PERIODE" => $reqPeriode, "PEGAWAI_ID" => $reqId));
//unset($pegawai_keluarga);

// import data excel mulai baris ke-4 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{
	$reqNRP = $data->val($i, 1);
	$reqHubunganKeluargaId = $data->val($i, 2);
	$reqStatusTunjangan = $data->val($i, 3);
	$reqStatusKawin = $data->val($i, 4);
	$reqStatusTanggung = $data->val($i, 5);
	$reqNama = $data->val($i, 6);
	$reqJenisKelamin = $data->val($i, 7);

	$pegawai = new Pegawai();
	$pegawai->selectByParams(array("NRP" => $reqNRP));
	$pegawai->firstRow();
	$reqId = $pegawai->getField("PEGAWAI_ID");
	
	$pegawai_keluarga = new PegawaiKeluarga();	
	$pegawai_keluarga->setField('HUBUNGAN_KELUARGA_ID', $reqHubunganKeluargaId);
	$pegawai_keluarga->setField('STATUS_KAWIN', setNULL($reqStatusKawin));
	$pegawai_keluarga->setField('JENIS_KELAMIN', $reqJenisKelamin);
	$pegawai_keluarga->setField('STATUS_TUNJANGAN', setNULL($reqStatusTunjangan));
	$pegawai_keluarga->setField('NAMA', $reqNama);
	$pegawai_keluarga->setField('TANGGAL_WAFAT', dateToDBCheck($reqTanggalWafat));
	$pegawai_keluarga->setField('TANGGAL_LAHIR', dateToDBCheck($reqTanggalLahir));
	$pegawai_keluarga->setField('STATUS_TANGGUNG', setNULL($reqStatusTanggung));
	$pegawai_keluarga->setField('TEMPAT_LAHIR', $reqTempatLahir);
	$pegawai_keluarga->setField('PENDIDIKAN_ID', $reqPendidikanId);
	$pegawai_keluarga->setField('PEKERJAAN', $reqPekerjaan);
	$pegawai_keluarga->setField('PEGAWAI_ID', $reqId);
	
	$pegawai_keluarga->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_keluarga->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	
	if($reqNama==""){}
	else
	{
		$pegawai_keluarga->insert();
		//echo $pegawai_keluarga->query;
	}
	
	unset($pegawai_keluarga);
	unset($pegawai);	
	
}

echo "Data berhasil disimpan.";
//echo $temp;

?>