<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikanPerjenjangan.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

include "../operasional/excel/excel_reader2.php";

$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);
$pegawai_pendidikan_perjenjangan = new PegawaiPendidikanPerjenjangan();
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

//$check = $pegawai_pendidikan_perjenjangan->getCountByParamsKapalProduksi(array("PERIODE" => $reqPeriode, "PEGAWAI_ID" => $reqId));
//unset($pegawai_pendidikan_perjenjangan);

// import data excel mulai baris ke-4 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{

//$tempPegawaiId=$data->val($i, 1);
//$reqPerjenjanganId = $data->val($i, 2);
//$reqTotalJamOps = setTime($data->raw($i, '6'), $data->val($i, 6));
//$reqHari = $data->val($i, 21);
	
	$reqNRP = $data->val($i, 1);
	$reqNama = $data->val($i, 2);
	$reqTanggalAwal = $data->val($i, 3);
	$reqTanggalAkhir = $data->val($i, 4);
	
	$pegawai = new Pegawai();
	$pegawai->selectByParams(array("NRP" => $reqNRP));
	$pegawai->firstRow();
	$reqId = $pegawai->getField("PEGAWAI_ID");

	$pegawai_pendidikan_perjenjangan = new PegawaiPendidikanPerjenjangan();
	$pegawai_pendidikan_perjenjangan->setField('PEGAWAI_ID', $reqId);
	$pegawai_pendidikan_perjenjangan->setField('NAMA', $reqNama);
	$pegawai_pendidikan_perjenjangan->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
	$pegawai_pendidikan_perjenjangan->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
	
	$pegawai_pendidikan_perjenjangan->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_pendidikan_perjenjangan->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	
	
	if($reqNama==""){}
	else
	{
		$pegawai_pendidikan_perjenjangan->insert();
		//echo $pegawai_pendidikan_perjenjangan->query;
	}
	//echo $pegawai_pendidikan_perjenjangan->query;
	
	/*if($i==1)
		$temp= $pegawai_pendidikan_perjenjangan->query;
	*/
	unset($pegawai_pendidikan_perjenjangan);
	unset($pegawai);
	
}

echo "Data berhasil disimpan.";
//echo $temp;

?>