<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiStatusNikah.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

include "../operasional/excel/excel_reader2.php";

$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);
$pegawai_status_nikah = new PegawaiStatusNikah();
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

//$check = $pegawai_status_nikah->getCountByParamsKapalProduksi(array("PERIODE" => $reqPeriode, "PEGAWAI_ID" => $reqId));
//unset($pegawai_status_nikah);

// import data excel mulai baris ke-4 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{

//$tempPegawaiId=$data->val($i, 1);
//$reqPerjenjanganId = $data->val($i, 2);
//$reqTotalJamOps = setTime($data->raw($i, '6'), $data->val($i, 6));
//$reqHari = $data->val($i, 21);
	
	$reqNRP = $data->val($i, 1);			
	$reqTanggalNikah = $data->val($i, 2);
	$reqStatusNikah = $data->val($i, 3);
	$reqTempat = $data->val($i, 4);
	$reqNoSK = $data->val($i, 5);
	$reqHubungan = $data->val($i, 6);

	$pegawai = new Pegawai();
	$pegawai->selectByParams(array("NRP" => $reqNRP));
	$pegawai->firstRow();
	$reqId = $pegawai->getField("PEGAWAI_ID");

	$pegawai_status_nikah = new PegawaiStatusNikah();
	$pegawai_status_nikah->setField('TANGGAL_NIKAH', dateToDBCheck($reqTanggalNikah));
	$pegawai_status_nikah->setField('STATUS_NIKAH', $reqStatusNikah);
	$pegawai_status_nikah->setField('TEMPAT', $reqTempat);
	$pegawai_status_nikah->setField('NO_SK', $reqNoSK);
	$pegawai_status_nikah->setField('HUBUNGAN', $reqHubungan);
	$pegawai_status_nikah->setField('PEGAWAI_ID', $reqId);
	
	$pegawai_status_nikah->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_status_nikah->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	
	
	if($reqStatusNikah==""){}
	else
	{
		$pegawai_status_nikah->insert();
		//echo $pegawai_status_nikah->query;
	}
	//echo $pegawai_status_nikah->query;
	
	/*if($i==1)
		$temp= $pegawai_status_nikah->query;
	*/
	unset($pegawai_status_nikah);
	unset($pegawai);
	
}

echo "Data berhasil disimpan.";
//echo $temp;

?>