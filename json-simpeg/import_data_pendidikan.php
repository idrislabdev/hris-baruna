<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikan.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

include "../operasional/excel/excel_reader2.php";

$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);
$pegawai_pendidikan = new PegawaiPendidikan();
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

//$check = $pegawai_pendidikan->getCountByParamsKapalProduksi(array("PERIODE" => $reqPeriode, "PEGAWAI_ID" => $reqId));
//unset($pegawai_pendidikan);

// import data excel mulai baris ke-4 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{
	$reqNRP = $data->val($i, 1);
	$reqPendidikanId = $data->val($i, 2);
	$reqPendidikanBiayaId = $data->val($i, 3);
	$reqNama = $data->val($i, 4);
	$reqKota = $data->val($i, 5);
	$reqUniversitasId = $data->val($i, 6);
	$reqLulus = $data->val($i, 7);
	$reqNoIjasah = $data->val($i, 8);
	
	$pegawai = new Pegawai();
	$pegawai->selectByParams(array("NRP" => $reqNRP));
	$pegawai->firstRow();
	$reqId = $pegawai->getField("PEGAWAI_ID");

	$pegawai_pendidikan = new PegawaiPendidikan();
	$pegawai_pendidikan->setField('PEGAWAI_ID', $reqId);
	$pegawai_pendidikan->setField('PENDIDIKAN_ID', $reqPendidikanId);
	$pegawai_pendidikan->setField('PENDIDIKAN_BIAYA_ID', $reqPendidikanBiayaId);
	$pegawai_pendidikan->setField('NAMA', $reqNama);
	$pegawai_pendidikan->setField('KOTA', $reqKota);
	$pegawai_pendidikan->setField('UNIVERSITAS_ID', $reqUniversitasId);
	$pegawai_pendidikan->setField('LULUS', $reqLulus);
	$pegawai_pendidikan->setField('NO_IJASAH', $reqNoIjasah);
	$pegawai_pendidikan->setField('TANGGAL_ACC', dateToDBCheck($reqTanggalAcc));
	$pegawai_pendidikan->setField('TANGGAL_IJASAH', dateToDBCheck($reqTanggalIjasah));
	
	$pegawai_pendidikan->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_pendidikan->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	
	if($reqNama==""){}
	else
	{
		$pegawai_pendidikan->insert();
		//echo $pegawai_pendidikan->query;
	}
	/*
		if($i==1)
		$temp= $pegawai_pendidikan->query;
	*/
	unset($pegawai_pendidikan);
	unset($pegawai);	
	
}

echo "Data berhasil disimpan.";
//echo $temp;

?>